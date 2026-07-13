<?php
/**
 * Import one-off du lot démo (Fig_NN.svg + Fig_NN.json) dans _figure_svg.
 *
 * Usage :
 *   php _import_figure_svg.php find <texte>       → cherche les chapitres par titre (pour trouver l'ID)
 *   php _import_figure_svg.php dryrun <IDChapitre> → liste les figures du cours + mapping proposé (n'insère RIEN)
 *   php _import_figure_svg.php import <IDChapitre> → importe selon le mapping (propositions + $manualMapping)
 *
 * Le mapping automatique déduit "Fig_NN" du premier nombre de TitreFigure
 * (ex. "Fig4" → Fig_04 ; "Fig1-2-3" → Fig_01 à CONFIRMER).
 * Pour corriger/forcer : remplir $manualMapping ci-dessous puis relancer.
 */

$DEMO_DIR = 'C:/Users/ASUS/Downloads/demo/demo';

// Mapping manuel : 'Fig_NN' => IDFigure  (prioritaire sur la déduction automatique)
// Exemple : $manualMapping = ['Fig_01' => 123, 'Fig_02' => 124];
$manualMapping = [];

$mysqli = new mysqli('localhost', 'root', '', 'mezidxco_db_local');
if ($mysqli->connect_error) { die("Connexion BDD impossible: " . $mysqli->connect_error . "\n"); }
$mysqli->set_charset('utf8mb4');

$mode = isset($argv[1]) ? $argv[1] : '';
$arg  = isset($argv[2]) ? $argv[2] : '';

/* ───────────── find : retrouver l'IDChapitre ───────────── */
if ($mode === 'find') {
    if ($arg === '') { die("Usage: php _import_figure_svg.php find <texte>\n"); }
    $stmt = $mysqli->prepare(
        "SELECT c.IDChapitre, c.TitreChapitre, l.Titre AS TitreLivre,
                (SELECT COUNT(*) FROM _cours co JOIN _figure f ON f.IDCours = co.IDCours WHERE co.IDChapitre = c.IDChapitre) AS nbFig
         FROM _chapitre c JOIN _livre l ON l.IDLivre = c.IDLivre
         WHERE c.TitreChapitre LIKE CONCAT('%', ?, '%')
         ORDER BY c.IDChapitre"
    );
    $stmt->bind_param('s', $arg);
    $stmt->execute();
    $res = $stmt->get_result();
    printf("%-10s %-14s %-50s %s\n", 'IDChapitre', 'Nb figures', 'TitreChapitre', 'Livre');
    while ($r = $res->fetch_assoc()) {
        printf("%-10d %-14d %-50s %s\n", $r['IDChapitre'], $r['nbFig'], mb_substr($r['TitreChapitre'], 0, 48), mb_substr($r['TitreLivre'], 0, 40));
    }
    exit;
}

if (($mode !== 'dryrun' && $mode !== 'import') || !ctype_digit($arg)) {
    die("Usage:\n  php _import_figure_svg.php find <texte>\n  php _import_figure_svg.php dryrun <IDChapitre>\n  php _import_figure_svg.php import <IDChapitre>\n");
}
$idChapitre = (int) $arg;

/* ───────────── figures du cours ───────────── */
$stmt = $mysqli->prepare(
    "SELECT f.IDFigure, f.TitreFigure,
            (SELECT COUNT(*) FROM _figure_svg s WHERE s.IDFigure = f.IDFigure) AS hasSvg
     FROM _cours co JOIN _figure f ON f.IDCours = co.IDCours
     WHERE co.IDChapitre = ?
     ORDER BY CAST(SUBSTRING(f.TitreFigure, 4) AS UNSIGNED), f.IDFigure"
);
$stmt->bind_param('i', $idChapitre);
$stmt->execute();
$figures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (empty($figures)) { die("Aucune figure trouvée pour le chapitre $idChapitre.\n"); }

/* codes disponibles dans le dossier démo */
$available = [];
foreach (glob($DEMO_DIR . '/Fig_*.json') as $p) {
    $code = basename($p, '.json');
    if (is_file($DEMO_DIR . "/$code.svg")) { $available[$code] = true; }
}

/* inverse du mapping manuel : IDFigure => code */
$manualByFig = [];
foreach ($manualMapping as $code => $idf) { $manualByFig[(int) $idf] = $code; }

/* ───────────── proposition de mapping ───────────── */
$rows = [];
foreach ($figures as $f) {
    $idf = (int) $f['IDFigure'];
    $titre = $f['TitreFigure'];

    if (isset($manualByFig[$idf])) {
        $code = $manualByFig[$idf];
        $note = 'mapping manuel';
    } elseif (preg_match('/(\d+)/', $titre, $m)) {
        $code = sprintf('Fig_%02d', (int) $m[1]);
        $note = (strpos($titre, '-') !== false) ? 'titre groupé — À CONFIRMER' : 'auto (titre)';
    } else {
        $code = null;
        $note = 'aucun nombre dans le titre';
    }

    if ($code !== null && !isset($available[$code])) {
        $note .= " — $code ABSENT du dossier démo";
        $code = null;
    }

    $rows[] = ['idf' => $idf, 'titre' => $titre, 'code' => $code, 'note' => $note, 'hasSvg' => (int) $f['hasSvg']];
}

printf("%-10s %-22s %-10s %-10s %s\n", 'IDFigure', 'TitreFigure', 'Actuel', 'Code', 'Note');
foreach ($rows as $r) {
    printf("%-10d %-22s %-10s %-10s %s\n",
        $r['idf'], mb_substr($r['titre'], 0, 20),
        $r['hasSvg'] ? 'SVG ✓' : 'PNG',
        $r['code'] ?: '—', $r['note']);
}

if ($mode === 'dryrun') {
    echo "\nDRY-RUN : rien n'a été inséré. Vérifie le mapping ci-dessus,\n";
    echo "corrige via \$manualMapping si besoin, puis relance en mode import.\n";
    exit;
}

/* ───────────── import ───────────── */
echo "\nImport...\n";
$stmt = $mysqli->prepare(
    "INSERT INTO _figure_svg (IDFigure, svgContent, jsonMeta) VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE svgContent = VALUES(svgContent), jsonMeta = VALUES(jsonMeta)"
);
$ok = 0; $skip = 0;
foreach ($rows as $r) {
    if ($r['code'] === null) { $skip++; continue; }
    $svg  = file_get_contents($DEMO_DIR . '/' . $r['code'] . '.svg');
    $json = file_get_contents($DEMO_DIR . '/' . $r['code'] . '.json');
    if ($svg === false || $json === false) { echo "  ÉCHEC lecture {$r['code']}\n"; $skip++; continue; }
    if (json_decode($json) === null) { echo "  ÉCHEC JSON invalide {$r['code']}\n"; $skip++; continue; }
    $stmt->bind_param('iss', $r['idf'], $svg, $json);
    $stmt->execute();
    echo "  OK  IDFigure {$r['idf']}  ←  {$r['code']}\n";
    $ok++;
}
echo "\nTerminé : $ok importée(s), $skip ignorée(s).\n";
echo "Recharge la page livreCours (Ctrl+F5) pour voir le viewer.\n";
