<?php
/**
 * Generates server-ready deployment SQL files for RU, TR, PT languages.
 * Extracts FR→target title pairs from the local database and creates
 * complete, charset-safe SQL scripts.
 *
 * Run: php generate_server_deploy.php
 * Or:  http://localhost/public_html/generate_server_deploy.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');

$db = new mysqli('localhost', 'root', '', 'mezidxco_db_local');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error . "\n");
}
$db->set_charset('utf8mb4');

// Language config: FR category → target category mapping
$languages = [
    'RU' => [
        'cat_map' => [3 => 2700, 4 => 2701, 5 => 2702, 7 => 2703],
        'desc_col' => 'RU_Description',
        'couv_replace' => ['couverture_ES', 'couverture_RU'], // original pattern in perfect_deploy
    ],
    'TR' => [
        'cat_map' => [3 => 2800, 4 => 2801, 5 => 2802, 7 => 2803],
        'desc_col' => 'TR_Description',
        'couv_replace' => ['couverture_FR', 'couverture_TR'],
    ],
    'PT' => [
        'cat_map' => [3 => 2900, 4 => 2901, 5 => 2902, 7 => 2903],
        'desc_col' => 'PT_Description',
        'couv_replace' => ['couverture_FR', 'couverture_PT'],
    ],
];

foreach ($languages as $lang => $cfg) {
    echo "=== Generating server_deploy_{$lang}.sql ===\n";
    
    $target_cats = array_values($cfg['cat_map']);
    $fr_cats = array_keys($cfg['cat_map']);
    $target_cats_str = implode(',', $target_cats);
    $fr_cats_str = implode(',', $fr_cats);
    
    // 1. Get category translations (target lang Libelle)
    $cat_trans = [];
    $res = $db->query("SELECT IDCategory, Libelle FROM _category WHERE IDCategory IN ($target_cats_str)");
    while ($row = $res->fetch_assoc()) {
        $cat_trans[$row['IDCategory']] = $row['Libelle'];
    }
    
    // 2. Get theme translations
    $theme_trans = [];
    $res = $db->query("SELECT IDCategory, LibelleTheme FROM _theme WHERE IDCategory IN ($target_cats_str)");
    while ($row = $res->fetch_assoc()) {
        $theme_trans[$row['IDCategory']] = $row['LibelleTheme'];
    }
    
    // 3. Get FR→TARGET book title pairs by matching position within category pairs
    $book_trans = [];
    foreach ($cfg['cat_map'] as $fr_cat => $tgt_cat) {
        // Get FR books in order
        $fr_books = [];
        $res = $db->query("SELECT l.IDLivre, l.Titre FROM _livre l JOIN _theme t ON t.IDTheme = l.IDTheme WHERE t.IDCategory = $fr_cat ORDER BY l.IDLivre");
        while ($row = $res->fetch_assoc()) {
            $fr_books[] = $row;
        }
        
        // Get target books in order
        $tgt_books = [];
        $res = $db->query("SELECT l.IDLivre, l.Titre FROM _livre l JOIN _theme t ON t.IDTheme = l.IDTheme WHERE t.IDCategory = $tgt_cat ORDER BY l.IDLivre");
        while ($row = $res->fetch_assoc()) {
            $tgt_books[] = $row;
        }
        
        // Pair by position
        $count = min(count($fr_books), count($tgt_books));
        for ($i = 0; $i < $count; $i++) {
            $fr_title = $fr_books[$i]['Titre'];
            $tgt_title = $tgt_books[$i]['Titre'];
            if ($fr_title !== $tgt_title) { // Only if actually translated
                $book_trans[] = ['fr' => $fr_title, 'tgt' => $tgt_title];
            }
        }
        
        // 4. Get chapter translations by matching position within each book pair
        for ($i = 0; $i < $count; $i++) {
            $fr_livre_id = $fr_books[$i]['IDLivre'];
            $tgt_livre_id = $tgt_books[$i]['IDLivre'];
            
            $fr_chaps = [];
            $res = $db->query("SELECT IDChapitre, TitreChapitre FROM _chapitre WHERE IDLivre = $fr_livre_id ORDER BY IDChapitre");
            while ($row = $res->fetch_assoc()) {
                $fr_chaps[] = $row;
            }
            
            $tgt_chaps = [];
            $res = $db->query("SELECT IDChapitre, TitreChapitre FROM _chapitre WHERE IDLivre = $tgt_livre_id ORDER BY IDChapitre");
            while ($row = $res->fetch_assoc()) {
                $tgt_chaps[] = $row;
            }
            
            $ch_count = min(count($fr_chaps), count($tgt_chaps));
            for ($j = 0; $j < $ch_count; $j++) {
                $fr_ch = $fr_chaps[$j]['TitreChapitre'];
                $tgt_ch = $tgt_chaps[$j]['TitreChapitre'];
                // Collect all - even same titles (some might not be translated yet)
                // We'll deduplicate later
            }
        }
    }
    
    // 5. Get ALL chapter translations (fr → target) by position within paired books
    $chap_trans = [];
    $seen_fr_chaps = [];
    foreach ($cfg['cat_map'] as $fr_cat => $tgt_cat) {
        $fr_books = [];
        $res = $db->query("SELECT l.IDLivre FROM _livre l JOIN _theme t ON t.IDTheme = l.IDTheme WHERE t.IDCategory = $fr_cat ORDER BY l.IDLivre");
        while ($row = $res->fetch_assoc()) $fr_books[] = $row['IDLivre'];
        
        $tgt_books = [];
        $res = $db->query("SELECT l.IDLivre FROM _livre l JOIN _theme t ON t.IDTheme = l.IDTheme WHERE t.IDCategory = $tgt_cat ORDER BY l.IDLivre");
        while ($row = $res->fetch_assoc()) $tgt_books[] = $row['IDLivre'];
        
        $count = min(count($fr_books), count($tgt_books));
        for ($i = 0; $i < $count; $i++) {
            $fr_chaps = [];
            $res = $db->query("SELECT TitreChapitre FROM _chapitre WHERE IDLivre = {$fr_books[$i]} ORDER BY IDChapitre");
            while ($row = $res->fetch_assoc()) $fr_chaps[] = $row['TitreChapitre'];
            
            $tgt_chaps = [];
            $res = $db->query("SELECT TitreChapitre FROM _chapitre WHERE IDLivre = {$tgt_books[$i]} ORDER BY IDChapitre");
            while ($row = $res->fetch_assoc()) $tgt_chaps[] = $row['TitreChapitre'];
            
            $ch_count = min(count($fr_chaps), count($tgt_chaps));
            for ($j = 0; $j < $ch_count; $j++) {
                $fr_t = $fr_chaps[$j];
                $tgt_t = $tgt_chaps[$j];
                if (!isset($seen_fr_chaps[$fr_t]) && $fr_t !== $tgt_t) {
                    $chap_trans[] = ['fr' => $fr_t, 'tgt' => $tgt_t];
                    $seen_fr_chaps[$fr_t] = true;
                }
            }
        }
    }
    
    // Deduplicate book translations
    $seen_books = [];
    $unique_book_trans = [];
    foreach ($book_trans as $bt) {
        if (!isset($seen_books[$bt['fr']])) {
            $unique_book_trans[] = $bt;
            $seen_books[$bt['fr']] = true;
        }
    }
    $book_trans = $unique_book_trans;
    
    echo "  Books: " . count($book_trans) . " translations\n";
    echo "  Chapters: " . count($chap_trans) . " translations\n";
    
    // === Generate SQL file ===
    $case_map = '';
    foreach ($cfg['cat_map'] as $fr => $tgt) {
        $case_map .= "WHEN IDCategory=$fr THEN $tgt ";
    }
    
    $sql = "-- =================================================================\n";
    $sql .= "-- Server Deployment: $lang Language\n";
    $sql .= "-- Auto-generated from local database on " . date('Y-m-d H:i:s') . "\n";
    $sql .= "-- Run: docker exec -i anatomy_db mysql -u anatomy_user -puser_password_ici access_anatomy < server_deploy_" . strtolower($lang) . ".sql\n";
    $sql .= "-- =================================================================\n\n";
    
    $sql .= "SET NAMES utf8mb4;\n";
    $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n";
    $sql .= "SET CHARACTER_SET_CLIENT = utf8mb4;\n";
    $sql .= "SET CHARACTER_SET_RESULTS = utf8mb4;\n";
    $sql .= "SET COLLATION_CONNECTION = utf8mb4_general_ci;\n\n";
    
    // Charset fix for main tables
    $sql .= "-- ========== STEP 0: Fix column charsets ==========\n";
    $sql .= "ALTER TABLE `_category` MODIFY `Libelle` VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_category` MODIFY `FR_Description` VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_category` MODIFY `EN_Description` VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_category` MODIFY `ES_Description` VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_theme` MODIFY `LibelleTheme` VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_livre` MODIFY `Titre` VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL;\n";
    $sql .= "ALTER TABLE `_chapitre` MODIFY `TitreChapitre` VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL;\n\n";
    
    // Add description column if needed
    $desc_col = $cfg['desc_col'];
    $sql .= "-- Add {$desc_col} column if not exists\n";
    $sql .= "SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '_category' AND COLUMN_NAME = '{$desc_col}');\n";
    $sql .= "SET @sql_add = IF(@col_exists = 0, 'ALTER TABLE `_category` ADD COLUMN `{$desc_col}` varchar(1000) DEFAULT NULL', 'SELECT 1');\n";
    $sql .= "PREPARE stmt FROM @sql_add; EXECUTE stmt; DEALLOCATE PREPARE stmt;\n\n";
    
    // Cleanup
    $sql .= "-- ========== STEP 1: Cleanup old {$lang} data ==========\n";
    $sql .= "DELETE FROM _chapitre WHERE IDLivre IN (SELECT IDLivre FROM _livre WHERE IDTheme IN (SELECT IDTheme FROM _theme WHERE IDCategory IN ($target_cats_str)));\n";
    $sql .= "DELETE FROM _livre WHERE IDTheme IN (SELECT IDTheme FROM _theme WHERE IDCategory IN ($target_cats_str));\n";
    $sql .= "DELETE FROM _theme WHERE IDCategory IN ($target_cats_str);\n";
    $sql .= "DELETE FROM _category WHERE IDCategory IN ($target_cats_str);\n\n";
    
    // Create categories
    $sql .= "-- ========== STEP 2: Create {$lang} categories ==========\n";
    foreach ($cfg['cat_map'] as $fr_cat => $tgt_cat) {
        $libelle = $db->real_escape_string($cat_trans[$tgt_cat] ?? 'Category');
        $sql .= "INSERT INTO `_category` (`IDCategory`, `Libelle`, `Couverture`, `multi_lingue`, `FR_Description`, `EN_Description`, `ES_Description`, `{$desc_col}`, `OrdreCat`, `EstActifAccueil`, `EstActifMenu`, `EstActifQSM`, `EstActifQROC`, `EstActifResume`, `EstActifCalques`, `EstActifTest`)\n";
        $sql .= "SELECT $tgt_cat, '$libelle', Couverture, '$lang', FR_Description, EN_Description, ES_Description, FR_Description, OrdreCat, EstActifAccueil, EstActifMenu, EstActifQSM, EstActifQROC, EstActifResume, EstActifCalques, EstActifTest FROM `_category` WHERE IDCategory = $fr_cat;\n";
    }
    $sql .= "\n";
    
    // Clone themes
    $sql .= "-- ========== STEP 3: Clone themes ==========\n";
    $sql .= "INSERT INTO `_theme` (`IDCategory`, `LibelleTheme`, `url`, `EstUnLivre`, `EstActif`, `OrderTheme`)\n";
    $sql .= "SELECT CASE {$case_map}END, LibelleTheme, url, EstUnLivre, EstActif, OrderTheme\n";
    $sql .= "FROM `_theme` WHERE IDCategory IN ($fr_cats_str);\n\n";
    
    // Theme mapping + clone books & chapters
    $sql .= "-- ========== STEP 4: Clone books & chapters ==========\n";
    $sql .= "CREATE TEMPORARY TABLE _mapping_theme (old_id INT, new_id INT);\n";
    $sql .= "INSERT INTO _mapping_theme SELECT t1.IDTheme, t2.IDTheme FROM _theme t1 JOIN _theme t2 ON t1.LibelleTheme = t2.LibelleTheme WHERE t1.IDCategory IN ($fr_cats_str) AND t2.IDCategory IN ($target_cats_str);\n\n";
    
    $sql .= "-- Clone books\n";
    $sql .= "INSERT INTO `_livre` (`Titre`, `Auteur`, `Couverture`, `Description`, `IDTheme`, `encryptCouverture`, `encryptCouvertureVideo`, `indexKeysBook`)\n";
    $sql .= "SELECT l.Titre, l.Auteur, l.Couverture, l.Description, m.new_id, l.encryptCouverture, l.encryptCouvertureVideo, l.indexKeysBook\n";
    $sql .= "FROM `_livre` l JOIN _mapping_theme m ON l.IDTheme = m.old_id;\n\n";
    
    $sql .= "-- Clone chapters\n";
    $sql .= "INSERT INTO `_chapitre` (`TitreChapitre`, `NumOrdre`, `IDLivre`, `NbreCours`, `NbreResume`, `NbreQcm`, `NbreQroc`, `NbreTest`, `TitreQcm`, `TitreQroc`, `indexKeysCurs`, `indexKeysResum`, `indexKeysQcm`, `indexKeysQroc`)\n";
    $sql .= "SELECT ch.TitreChapitre, ch.NumOrdre, l2.IDLivre, 0, 0, 0, 0, 0, ch.TitreQcm, ch.TitreQroc, ch.indexKeysCurs, ch.indexKeysResum, ch.indexKeysQcm, ch.indexKeysQroc\n";
    $sql .= "FROM `_chapitre` ch\n";
    $sql .= "JOIN `_livre` l1 ON ch.IDLivre = l1.IDLivre\n";
    $sql .= "JOIN _mapping_theme m ON l1.IDTheme = m.old_id\n";
    $sql .= "JOIN `_livre` l2 ON l2.Titre = l1.Titre AND l2.IDTheme = m.new_id;\n\n";
    
    // Apply translations - categories
    $sql .= "-- ========== STEP 5: Apply translations ==========\n";
    $sql .= "-- Update category labels\n";
    foreach ($cfg['cat_map'] as $fr_cat => $tgt_cat) {
        if (isset($cat_trans[$tgt_cat])) {
            $label = $db->real_escape_string($cat_trans[$tgt_cat]);
            $sql .= "UPDATE `_category` SET `Libelle` = '$label' WHERE IDCategory = $tgt_cat;\n";
        }
    }
    $sql .= "\n-- Update theme labels\n";
    foreach ($cfg['cat_map'] as $fr_cat => $tgt_cat) {
        if (isset($theme_trans[$tgt_cat])) {
            $label = $db->real_escape_string($theme_trans[$tgt_cat]);
            $sql .= "UPDATE `_theme` SET `LibelleTheme` = '$label' WHERE IDCategory = $tgt_cat;\n";
        }
    }
    
    // Book translations via temp table
    $sql .= "\n-- ========== Book translations ==========\n";
    $sql .= "DROP TEMPORARY TABLE IF EXISTS _tmp_book_trans;\n";
    $sql .= "CREATE TEMPORARY TABLE _tmp_book_trans (\n";
    $sql .= "    fr_title VARCHAR(150) NOT NULL,\n";
    $sql .= "    tgt_title VARCHAR(150) NOT NULL,\n";
    $sql .= "    UNIQUE KEY uniq_fr (fr_title)\n";
    $sql .= ") CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;\n\n";
    
    $sql .= "INSERT IGNORE INTO _tmp_book_trans (fr_title, tgt_title) VALUES\n";
    $book_lines = [];
    foreach ($book_trans as $bt) {
        $fr = $db->real_escape_string($bt['fr']);
        $tgt = $db->real_escape_string($bt['tgt']);
        $book_lines[] = "('$fr', '$tgt')";
    }
    $sql .= implode(",\n", $book_lines) . ";\n\n";
    
    $sql .= "UPDATE `_livre` l\n";
    $sql .= "JOIN `_theme` t ON t.IDTheme = l.IDTheme\n";
    $sql .= "JOIN _tmp_book_trans m ON m.fr_title = l.Titre\n";
    $sql .= "SET l.Titre = m.tgt_title\n";
    $sql .= "WHERE t.IDCategory IN ($target_cats_str);\n\n";
    $sql .= "SELECT '--- Books translated ---' AS status, ROW_COUNT() AS nb_rows;\n\n";
    
    // Chapter translations via temp table
    $sql .= "-- ========== Chapter translations ==========\n";
    $sql .= "DROP TEMPORARY TABLE IF EXISTS _tmp_chap_trans;\n";
    $sql .= "CREATE TEMPORARY TABLE _tmp_chap_trans (\n";
    $sql .= "    fr_title VARCHAR(200) NOT NULL,\n";
    $sql .= "    tgt_title VARCHAR(200) NOT NULL,\n";
    $sql .= "    UNIQUE KEY uniq_fr (fr_title)\n";
    $sql .= ") CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;\n\n";
    
    $sql .= "INSERT IGNORE INTO _tmp_chap_trans (fr_title, tgt_title) VALUES\n";
    $chap_lines = [];
    foreach ($chap_trans as $ct) {
        $fr = $db->real_escape_string($ct['fr']);
        $tgt = $db->real_escape_string($ct['tgt']);
        $chap_lines[] = "('$fr', '$tgt')";
    }
    $sql .= implode(",\n", $chap_lines) . ";\n\n";
    
    $sql .= "UPDATE `_chapitre` ch\n";
    $sql .= "JOIN `_livre` l ON l.IDLivre = ch.IDLivre\n";
    $sql .= "JOIN `_theme` t ON t.IDTheme = l.IDTheme\n";
    $sql .= "JOIN _tmp_chap_trans m ON m.fr_title = ch.TitreChapitre\n";
    $sql .= "SET ch.TitreChapitre = m.tgt_title\n";
    $sql .= "WHERE t.IDCategory IN ($target_cats_str);\n\n";
    $sql .= "SELECT '--- Chapters translated ---' AS status, ROW_COUNT() AS nb_rows;\n\n";
    
    // Cleanup temp tables
    $sql .= "-- ========== Cleanup ==========\n";
    $sql .= "DROP TEMPORARY TABLE IF EXISTS _mapping_theme;\n";
    $sql .= "DROP TEMPORARY TABLE IF EXISTS _tmp_book_trans;\n";
    $sql .= "DROP TEMPORARY TABLE IF EXISTS _tmp_chap_trans;\n\n";
    
    // Verification
    $sql .= "-- ========== Verification ==========\n";
    $sql .= "SELECT 'Categories' AS type, COUNT(*) AS count FROM `_category` WHERE multi_lingue = '$lang'\n";
    $sql .= "UNION ALL\n";
    $sql .= "SELECT 'Themes', COUNT(*) FROM `_theme` WHERE IDCategory IN ($target_cats_str)\n";
    $sql .= "UNION ALL\n";
    $sql .= "SELECT 'Livres', COUNT(*) FROM `_livre` l JOIN `_theme` t ON t.IDTheme = l.IDTheme WHERE t.IDCategory IN ($target_cats_str)\n";
    $sql .= "UNION ALL\n";
    $sql .= "SELECT 'Chapitres', COUNT(*) FROM `_chapitre` ch JOIN `_livre` l ON l.IDLivre = ch.IDLivre JOIN `_theme` t ON t.IDTheme = l.IDTheme WHERE t.IDCategory IN ($target_cats_str);\n\n";
    
    $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";
    
    // Write file
    $filename = __DIR__ . '/server_deploy_' . strtolower($lang) . '.sql';
    file_put_contents($filename, $sql);
    echo "  Written: $filename (" . strlen($sql) . " bytes)\n\n";
}

$db->close();
echo "=== DONE! Upload the server_deploy_*.sql files and run them. ===\n";
echo "Commands:\n";
echo "docker exec -i anatomy_db mysql -u anatomy_user -puser_password_ici access_anatomy < /var/www/access-anatomy/public_html/server_deploy_ru.sql\n";
echo "docker exec -i anatomy_db mysql -u anatomy_user -puser_password_ici access_anatomy < /var/www/access-anatomy/public_html/server_deploy_pt.sql\n";
echo "docker exec -i anatomy_db mysql -u anatomy_user -puser_password_ici access_anatomy < /var/www/access-anatomy/public_html/server_deploy_tr.sql\n";
