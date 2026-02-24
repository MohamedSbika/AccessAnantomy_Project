<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================
 * Controller : Traduction
 * ============================================================
 * Gère le workflow de traduction en 3 étapes :
 *   Step 1 : Extraction DOCX → JSON meta  (step1_extract.py)
 *   Step 2 : Traduction JSON meta → JSON traduit  (step2_translate.py)
 *   Step 3 : Reconstruction JSON traduit → DOCX final  (step3_rebuild.py)
 *   Confirm : Archivage DOCX + conversion HTML pour affichage
 *
 * Convention fichiers DOCX originaux (dans uploads/docx_originals/) :
 *   cours  → {idSubChap}.docx
 *   resume → {idSubChap}_resume.docx
 *
 * Convention fichiers intermédiaires (dans uploads/translations/) :
 *   meta JSON      → {idSubChap}_{docType}_{lang}_meta.json
 *   traduit JSON   → {idSubChap}_{docType}_{lang}_translated.json
 *   log            → {idSubChap}_{docType}_{lang}.log
 *
 * Convention fichiers finaux (dans PlatFormeConvert/) :
 *   DOCX final     → {idSubChap}_{docType}_{lang}.docx
 *   HTML cours     → {idSubChap}_{lang}_Sub.HTML
 *   HTML resume    → {idSubChap}_{lang}_SubResume.HTML
 * ============================================================
 */
class Traduction extends CI_Controller {

    private $pythonPath;
    private $scriptDir;
    private $uploadDir;
    private $docxOriginalDir;
    private $convertDir;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');

        // Détecter le chemin absolu de python.exe (fiable sous Apache/XAMPP)
        $pythonWhere = trim(shell_exec('where python 2>nul') ?: '');
        // Prendre la première ligne seulement (where peut retourner plusieurs résultats)
        $pythonLines = array_filter(explode("\n", $pythonWhere));
        $pythonFirst = trim(reset($pythonLines) ?: '');
        $this->pythonPath = ($pythonFirst && file_exists($pythonFirst))
            ? str_replace('/', DIRECTORY_SEPARATOR, $pythonFirst)
            : 'python';

        // Tous les chemins en backslashes Windows purs (évite les erreurs proc_open)
        $this->scriptDir       = str_replace('/', DIRECTORY_SEPARATOR, FCPATH . 'application/third_party/traduction/');
        $this->uploadDir       = str_replace('/', DIRECTORY_SEPARATOR, FCPATH . 'uploads/translations/');
        $this->docxOriginalDir = str_replace('/', DIRECTORY_SEPARATOR, FCPATH . 'uploads/docx_originals/');
        $this->convertDir      = str_replace('/', DIRECTORY_SEPARATOR, FCPATH . 'PlatFormeConvert/');

        // Créer les dossiers si nécessaire
        foreach ([$this->uploadDir, $this->docxOriginalDir, $this->convertDir] as $dir) {
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0777, true)) {
                    log_message('error', 'Traduction: Impossible de créer le dossier ' . $dir);
                }
            }
        }
    }

    /**
     * Helper pour envoyer une réponse JSON propre
     */
    private function jsonResponse($data) {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    // =========================================================================
    // Helpers privés
    // =========================================================================

    /**
     * Retourne le chemin du DOCX original selon le type de document.
     * cours  → uploads/docx_originals/{id}.docx
     * resume → uploads/docx_originals/{id}_resume.docx
     */
    private function getSourceDocx($idSubChap, $docType) {
        $suffix = ($docType === 'resume') ? '_resume' : '';
        return $this->docxOriginalDir . $idSubChap . $suffix . '.docx';
    }

    /**
     * Retourne le préfixe de base pour les fichiers intermédiaires.
     * Exemple : "74_cours_en" ou "74_resume_es"
     */
    private function baseName($idSubChap, $docType, $lang) {
        return "{$idSubChap}_{$docType}_{$lang}";
    }

    /**
     * Chemin du fichier JSON de métadonnées (sortie step1).
     * Exemple : uploads/translations/74_cours_en_meta.json
     */
    private function metaJsonPath($idSubChap, $docType, $lang) {
        return $this->uploadDir . $this->baseName($idSubChap, $docType, $lang) . '_meta.json';
    }

    /**
     * Chemin du fichier JSON traduit (sortie step2).
     * step2_translate.py génère : {stem}_translated_{LANG}.json
     * où stem = nom du fichier meta sans extension et sans "_meta"
     * → uploads/translations/74_cours_en_translated_EN.json
     *
     * ⚠ step2 utilise args.lang en MAJUSCULES (EN, ES)
     */
    private function translatedJsonPath($idSubChap, $docType, $lang) {
        $base = $this->baseName($idSubChap, $docType, $lang);
        // step2 génère : {stem sans _meta}_translated_{LANG_UPPER}.json
        // stem du meta = "74_cours_en_meta" → sans "_meta" = "74_cours_en"
        return $this->uploadDir . $base . '_translated_' . strtoupper($lang) . '.json';
    }

    /**
     * Chemin du log step2.
     */
    private function logPath($idSubChap, $docType, $lang) {
        return $this->uploadDir . $this->baseName($idSubChap, $docType, $lang) . '.log';
    }

    /**
     * Chemin du DOCX final généré par step3.
     */
    private function finalDocxPath($idSubChap, $docType, $lang) {
        return $this->convertDir . "{$idSubChap}_{$docType}_{$lang}.docx";
    }

    /**
     * Chemin du HTML final (après confirmation).
     * cours  → {id}_{lang}_Sub.HTML
     * resume → {id}_{lang}_SubResume.HTML
     */
    private function finalHtmlPath($idSubChap, $docType, $lang) {
        $suffix = ($docType === 'resume') ? "_{$lang}_SubResume.HTML" : "_{$lang}_Sub.HTML";
        return $this->convertDir . $idSubChap . $suffix;
    }

    // =========================================================================
    // STEP 1 + 2 : Extraire puis traduire (via wrapper PHP CLI en arrière-plan)
    // Route : GET Traduction/lancer/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function lancer($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType    = ($docType === 'resume') ? 'resume' : 'cours';
        $lang       = strtolower($lang);
        $sourceDocx = $this->getSourceDocx($idSubChap, $docType);

        if (!file_exists($sourceDocx)) {
            $this->jsonResponse([
                'status'  => 'error',
                'message' => "Fichier original ({$docType}) introuvable. Veuillez d'abord uploader le fichier .docx."
            ]);
            return;
        }

        $metaJson    = $this->metaJsonPath($idSubChap, $docType, $lang);
        $logFile     = $this->logPath($idSubChap, $docType, $lang);
        $step1Script = $this->scriptDir . 'step1_extract.py';
        $step2Script = $this->scriptDir . 'step2_translate.py';
        $wrapperScript = $this->scriptDir . 'run_translation.php';
        $langUpper   = strtoupper($lang);
        // Détecter php.exe sur XAMPP (PHP_BINARY = httpd.exe quand module Apache)
        // On cherche php.exe dans le dossier parent de Apache, puis dans les chemins XAMPP standards
        $apacheDir = dirname(PHP_BINARY); // ex: C:\xampp\7.4\apache\bin
        $candidates = [
            dirname($apacheDir) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'php.exe', // C:\xampp\7.4\php\php.exe
            dirname(dirname($apacheDir)) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'php.exe', // C:\xampp\php\php.exe
            'C:\\xampp\\7.4\\php\\php.exe',
            'C:\\xampp\\php\\php.exe',
            PHP_BINDIR . DIRECTORY_SEPARATOR . 'php.exe',
        ];
        $phpExe = '';
        foreach ($candidates as $c) {
            if (file_exists($c)) { $phpExe = $c; break; }
        }
        if (!$phpExe) {
            // Dernier recours : chercher dans le PATH
            $phpExe = trim(shell_exec('where php.exe 2>nul')) ?: 'php';
        }

        // Supprimer l'ancien fichier traduit et vider le log
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);
        if (file_exists($translatedJson)) unlink($translatedJson);
        file_put_contents($logFile, '');

        // Créer un fichier .bat temporaire — méthode la plus fiable sur Windows/XAMPP
        $batFile = $this->uploadDir . "run_{$idSubChap}_{$docType}_{$lang}.bat";

        // Utiliser les librairies Python locales (copiées dans application/third_party/traduction/libs)
        // pour contourner les problèmes de permissions d'accès au dossier utilisateur depuis Apache/Service
        $localLibs = $this->scriptDir . 'libs';

        $batContent  = "@echo off\r\n";
        $batContent .= "set PYTHONIOENCODING=utf-8\r\n";
        // Ajouter les site-packages locaux au PYTHONPATH
        if (is_dir($localLibs)) {
            $batContent .= "set PYTHONPATH=" . $localLibs . "\r\n";
        }
        $batContent .= "\"" . $phpExe . "\" \"" . $wrapperScript . "\" ";
        $batContent .= "\"" . $sourceDocx . "\" ";
        $batContent .= "\"" . $metaJson . "\" ";
        $batContent .= "\"" . $logFile . "\" ";
        $batContent .= $langUpper . " ";
        $batContent .= "\"" . $this->pythonPath . "\" ";
        $batContent .= "\"" . $step1Script . "\" ";
        $batContent .= "\"" . $step2Script . "\"\r\n";
        file_put_contents($batFile, $batContent);

        // Lancer le .bat en arrière-plan via PowerShell Start-Process (processus vraiment détaché)
        $psCmd = 'powershell -Command "Start-Process -FilePath \"' . $batFile . '\" -WindowStyle Hidden"';
        pclose(popen($psCmd, 'r'));

        $this->jsonResponse([
            'status'  => 'success',
            'message' => 'Traduction lancée en arrière-plan.',
        ]);
    }

    // =========================================================================
    // Lire la progression en temps réel depuis le log
    // Route : GET Traduction/progression/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function progression($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType        = ($docType === 'resume') ? 'resume' : 'cours';
        $lang           = strtolower($lang);
        $logFile        = $this->logPath($idSubChap, $docType, $lang);
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);

        // Terminé ?
        if (file_exists($translatedJson)) {
            $this->jsonResponse(['status' => 'finished', 'progress' => 100, 'current' => 0, 'total' => 0]);
            return;
        }

        // Pas encore démarré ?
        if (!file_exists($logFile) || filesize($logFile) === 0) {
            $this->jsonResponse(['status' => 'not_started', 'progress' => 0, 'current' => 0, 'total' => 0]);
            return;
        }

        $logContent = file_get_contents($logFile);

        // Erreur Python ?
        if (strpos($logContent, 'Traceback') !== false || strpos($logContent, 'Error:') !== false) {
            // Extraire la dernière ligne d'erreur
            $lines = array_filter(explode("\n", trim($logContent)));
            $lastError = end($lines);
            $this->jsonResponse(['status' => 'error', 'progress' => 0, 'message' => $lastError]);
            return;
        }

        // Parser [PROGRESS] X/Y
        $current = 0; $total = 0; $progress = 0;
        if (preg_match_all('/\[PROGRESS\] (\d+)\/(\d+)/', $logContent, $matches)) {
            $lastIdx = count($matches[0]) - 1;
            $current = (int)$matches[1][$lastIdx];
            $total   = (int)$matches[2][$lastIdx];
            if ($total > 0) $progress = round(($current / $total) * 100);
        }

        $this->jsonResponse([
            'status'   => 'processing',
            'progress' => $progress,
            'current'  => $current,
            'total'    => $total
        ]);
    }

    // =========================================================================
    // Vérifier le statut de la traduction
    // Route : GET Traduction/etat/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function etat($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType        = ($docType === 'resume') ? 'resume' : 'cours';
        $lang           = strtolower($lang);
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);
        $metaJson       = $this->metaJsonPath($idSubChap, $docType, $lang);
        $logFile        = $this->logPath($idSubChap, $docType, $lang);
        $sourceDocx     = $this->getSourceDocx($idSubChap, $docType);
        $hasSource      = file_exists($sourceDocx);

        // --- Cas 1 : Traduction terminée (fichier JSON traduit présent) ---
        if (file_exists($translatedJson)) {
            $data  = json_decode(file_get_contents($translatedJson), true);
            $stats = ['SUCCESS' => 0, 'REJECTED' => 0, 'ERROR' => 0, 'SKIPPED' => 0];

            if (isset($data['structure'])) {
                foreach ($this->recursiveFindGroups($data['structure']) as $group) {
                    $s = $group['translation_status'] ?? 'SKIPPED';
                    if (array_key_exists($s, $stats)) $stats[$s]++;
                }
            }

            // Récupérer les stats du script si disponibles
            $scriptStats = $data['_metadata']['translation_stats'] ?? null;

            $this->jsonResponse([
                'status'       => 'finished',
                'has_source'   => $hasSource,
                'stats'        => $stats,
                'script_stats' => $scriptStats
            ]);
            return;
        }

        // --- Cas 2 : Verifier le log (en cours ou erreur) ---
        if (file_exists($logFile) && filesize($logFile) > 0) {
            $logContent = file_get_contents($logFile);

            // Erreur Python ?
            if (strpos($logContent, 'Traceback') !== false || strpos($logContent, 'Error:') !== false) {
                // Extraire la dernière ligne d'erreur
                $lines = array_filter(explode("\n", trim($logContent)));
                $lastError = end($lines);
                $this->jsonResponse([
                    'status'     => 'error',
                    'has_source' => $hasSource,
                    'message'    => $lastError
                ]);
                return;
            }

            // En cours
            $this->jsonResponse([
                'status'     => 'processing',
                'has_source' => $hasSource
            ]);
            return;
        }

        // --- Cas 3 : Pas encore démarré ---
        $this->jsonResponse([
            'status'     => 'not_started',
            'has_source' => $hasSource
        ]);
    }

    // =========================================================================
    // Récupérer les segments pour prévisualisation ou correction
    // Route : GET Traduction/get_segments/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function get_segments($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType        = ($docType === 'resume') ? 'resume' : 'cours';
        $lang           = strtolower($lang);
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);

        if (!file_exists($translatedJson)) {
            $this->jsonResponse([
                'status'  => 'error',
                'message' => "Fichier de traduction introuvable : " . basename($translatedJson)
            ]);
            return;
        }

        $data     = json_decode(file_get_contents($translatedJson), true);
        $segments = [];

        foreach ($this->recursiveFindGroups($data['structure']) as $group) {
            $segments[] = [
                'metadata_id'        => $group['metadata_id'],
                'source_text'        => $group['source_text'],
                'translated_text'    => $group['translated_text'] ?? '',
                'translation_status' => $group['translation_status'] ?? 'SKIPPED',
            ];
        }

        $this->jsonResponse(['status' => 'success', 'segments' => $segments]);
    }

    // =========================================================================
    // Sauvegarder les corrections manuelles
    // Route : POST Traduction/save_corrections
    // Body  : { idSousChap, lang, docType, corrections: { metadata_id: text } }
    // =========================================================================
    public function save_corrections() {
        $dataPost    = json_decode(file_get_contents('php://input'), true);
        $idSubChap   = $dataPost['idSousChap'];
        $lang        = strtolower($dataPost['lang']);
        $docType     = isset($dataPost['docType']) ? $dataPost['docType'] : 'cours';
        $corrections = $dataPost['corrections'];

        $docType        = ($docType === 'resume') ? 'resume' : 'cours';
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);

        if (!file_exists($translatedJson)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Fichier de traduction introuvable.']);
            return;
        }

        $data = json_decode(file_get_contents($translatedJson), true);
        $this->applyCorrectionsRecursive($data['structure'], $corrections);
        file_put_contents($translatedJson, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->jsonResponse(['status' => 'success', 'message' => 'Corrections enregistrées.']);
    }

    // =========================================================================
    // STEP 3 : Reconstruire le DOCX traduit
    // Route : GET Traduction/generer/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function generer($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType        = ($docType === 'resume') ? 'resume' : 'cours';
        $lang           = strtolower($lang);
        $sourceDocx     = $this->getSourceDocx($idSubChap, $docType);
        $translatedJson = $this->translatedJsonPath($idSubChap, $docType, $lang);
        $outputDocx     = $this->finalDocxPath($idSubChap, $docType, $lang);

        if (!file_exists($translatedJson)) {
            $this->jsonResponse([
                'status'  => 'error',
                'message' => 'Aucune traduction trouvée. Veuillez d\'abord lancer la traduction.'
            ]);
            return;
        }

        if (!file_exists($sourceDocx)) {
            $this->jsonResponse([
                'status'  => 'error',
                'message' => "Fichier source introuvable : {$sourceDocx}"
            ]);
            return;
        }

        $step3Script = $this->scriptDir . 'step3_rebuild.py';
        $cmd3 = "\"{$this->pythonPath}\" \"{$step3Script}\" \"{$translatedJson}\" -s \"{$sourceDocx}\" -o \"{$outputDocx}\" 2>&1";

        $output3    = [];
        $returnVar3 = 0;
        exec($cmd3, $output3, $returnVar3);

        if ($returnVar3 !== 0 || !file_exists($outputDocx)) {
            log_message('error', 'Traduction Step3 FAILED: ' . implode("\n", $output3));
            $this->jsonResponse([
                'status'  => 'error',
                'message' => 'Erreur lors de la reconstruction du document.',
                'details' => $output3
            ]);
            return;
        }

        $this->jsonResponse([
            'status'   => 'success',
            'message'  => 'Document généré avec succès.',
            'file_url' => base_url("PlatFormeConvert/{$idSubChap}_{$docType}_{$lang}.docx")
        ]);
    }

    // =========================================================================
    // Confirmer la traduction : archiver DOCX + convertir en HTML
    // Route : GET Traduction/confirmer/{idSubChap}/{docType}/{lang}
    // =========================================================================
    public function confirmer($idSubChap, $docType = 'cours', $lang = 'en') {
        $docType   = ($docType === 'resume') ? 'resume' : 'cours';
        $lang      = strtolower($lang);
        $tempDocx  = $this->finalDocxPath($idSubChap, $docType, $lang);
        $htmlPath  = $this->finalHtmlPath($idSubChap, $docType, $lang);

        if (!file_exists($tempDocx)) {
            $this->jsonResponse([
                'status'  => 'error',
                'message' => "Le document n'a pas encore été généré. Cliquez d'abord sur 'Générer'."
            ]);
            return;
        }

        // Archiver le DOCX dans un dossier permanent
        $finalDir  = FCPATH . 'uploads/final_translations/';
        if (!is_dir($finalDir)) mkdir($finalDir, 0777, true);
        $finalDocx = $finalDir . "{$idSubChap}_{$docType}_{$lang}.docx";
        copy($tempDocx, $finalDocx);

        // Convertir en HTML pour affichage dans livreDetails.php
        try {
            require_once APPPATH . 'third_party/wordToPh/vendor/autoload.php';

            $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
            $contents  = $objReader->load($tempDocx);

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($contents, 'HTML');
            $objWriter->save($htmlPath);

            $this->jsonResponse([
                'status'    => 'success',
                'message'   => 'Traduction confirmée et disponible pour affichage.',
                'html_file' => basename($htmlPath)
            ]);

        } catch (Exception $e) {
            log_message('error', 'Traduction confirmer HTML conversion failed: ' . $e->getMessage());
            $this->jsonResponse([
                'status'  => 'error',
                'message' => 'DOCX archivé mais erreur de conversion HTML : ' . $e->getMessage()
            ]);
        }
    }

    // =========================================================================
    // Helpers récursifs pour parcourir la structure JSON
    // =========================================================================

    private function recursiveFindGroups($structure) {
        $groups = [];
        foreach ($structure as $item) {
            if ($item['type'] === 'paragraph') {
                foreach ($item['metadata_groups'] ?? [] as $g) {
                    if (!empty($g['metadata_id'])) {
                        $groups[] = $g;
                    }
                }
            } elseif ($item['type'] === 'table') {
                foreach ($item['rows'] ?? [] as $row) {
                    foreach ($row['cells'] ?? [] as $cell) {
                        foreach ($cell['paragraphs'] ?? [] as $para) {
                            foreach ($para['metadata_groups'] ?? [] as $g) {
                                if (!empty($g['metadata_id'])) {
                                    $groups[] = $g;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $groups;
    }

    private function applyCorrectionsRecursive(&$structure, $corrections) {
        foreach ($structure as &$item) {
            if ($item['type'] === 'paragraph') {
                foreach ($item['metadata_groups'] as &$g) {
                    if (isset($corrections[$g['metadata_id']])) {
                        $g['translated_text']    = $corrections[$g['metadata_id']];
                        $g['translation_status'] = 'SUCCESS';
                    }
                }
            } elseif ($item['type'] === 'table') {
                foreach ($item['rows'] as &$row) {
                    foreach ($row['cells'] as &$cell) {
                        foreach ($cell['paragraphs'] as &$para) {
                            foreach ($para['metadata_groups'] as &$g) {
                                if (isset($corrections[$g['metadata_id']])) {
                                    $g['translated_text']    = $corrections[$g['metadata_id']];
                                    $g['translation_status'] = 'SUCCESS';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
