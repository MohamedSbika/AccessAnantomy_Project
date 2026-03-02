<?php
/**
 * run_translation.php — Wrapper CLI pour la traduction
 * Exécuté en arrière-plan par Traduction.php via un fichier .bat
 *
 * Arguments :
 *   $argv[1] = chemin absolu vers le fichier DOCX source
 *   $argv[2] = chemin absolu vers le fichier meta JSON de sortie (step1)
 *   $argv[3] = chemin absolu vers le fichier log
 *   $argv[4] = langue (EN ou ES)
 *   $argv[5] = chemin vers python.exe
 *   $argv[6] = chemin vers step1_extract.py
 *   $argv[7] = chemin vers step2_translate.py
 */

if (php_sapi_name() !== 'cli') {
    die("Ce script ne peut être exécuté qu'en CLI.\n");
}

if ($argc < 8) {
    die("Usage: php run_translation.php <docx> <meta_json> <log_file> <lang> <python> <step1> <step2>\n");
}

$sourceDocx  = $argv[1];
$metaJson    = $argv[2];
$logFile     = $argv[3];
$lang        = strtoupper($argv[4]);
$pythonPath  = $argv[5];
$step1Script = $argv[6];
$step2Script = $argv[7];

// Répertoire de travail = dossier des scripts Python
$workDir = dirname($step1Script);

// Forcer UTF-8
if (function_exists('mb_internal_encoding')) mb_internal_encoding('UTF-8');

function writeLog($logFile, $msg) {
    file_put_contents($logFile, $msg . "\n", FILE_APPEND);
}

// Vider le log et démarrer
file_put_contents($logFile, '');
writeLog($logFile, '[WRAPPER] Démarrage de la traduction');
writeLog($logFile, '[WRAPPER] Python : ' . $pythonPath);
writeLog($logFile, '[WRAPPER] Source : ' . $sourceDocx);
writeLog($logFile, '[WRAPPER] Langue : ' . $lang);
writeLog($logFile, '[WRAPPER] WorkDir: ' . $workDir);

// Récupérer les variables d'environnement actuelles (getenv est fiable en CLI Windows)
// $_ENV peut être vide selon la config php.ini (variables_order)
$currentEnv = [];
foreach (array_keys($_SERVER) as $k) {
    $v = getenv($k);
    if ($v !== false) $currentEnv[$k] = $v;
}
// Récupérer aussi PYTHONPATH défini dans le .bat
$pythonPath_env = getenv('PYTHONPATH') ?: '';
writeLog($logFile, '[WRAPPER] PYTHONPATH: ' . $pythonPath_env);

// Variables d'environnement pour Python (via putenv pour l'héritage)
putenv('PYTHONIOENCODING=utf-8');
putenv('PYTHONUTF8=1');
if ($pythonPath_env) {
    putenv('PYTHONPATH=' . $pythonPath_env);
}

$descriptors = [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
];

// ─── STEP 1 : Extraction ────────────────────────────────────────────────────
writeLog($logFile, '[WRAPPER] === STEP 1 : Extraction ===');

// Sur Windows, proc_open accepte un tableau pour éviter les problèmes de guillemets
$cmd1 = [$pythonPath, $step1Script, $sourceDocx, '-o', $metaJson];
writeLog($logFile, '[WRAPPER] CMD1: ' . implode(' ', $cmd1));

// Env = null pour hériter de tout l'environnement système (PATH, SystemRoot...)
$proc1 = proc_open($cmd1, $descriptors, $pipes1, $workDir, null);

if (!is_resource($proc1)) {
    writeLog($logFile, '[ERROR] Impossible de lancer step1 (proc_open failed)');
    exit(1);
}

fclose($pipes1[0]);
$out1 = stream_get_contents($pipes1[1]);
$err1 = stream_get_contents($pipes1[2]);
fclose($pipes1[1]);
fclose($pipes1[2]);
$ret1 = proc_close($proc1);

if (trim($out1)) writeLog($logFile, '[STEP1 OUT] ' . trim($out1));
if (trim($err1)) writeLog($logFile, '[STEP1 ERR] ' . trim($err1));

if ($ret1 !== 0 || !file_exists($metaJson)) {
    writeLog($logFile, '[ERROR] Step1 échoué (code ' . $ret1 . ')');
    writeLog($logFile, 'Traceback: ' . trim($err1));
    exit(1);
}

writeLog($logFile, '[WRAPPER] Step1 OK - meta JSON créé : ' . $metaJson);

// ─── STEP 2 : Traduction ────────────────────────────────────────────────────
writeLog($logFile, '[WRAPPER] === STEP 2 : Traduction ===');

// Python écrit directement dans le fichier log via --log-file
// Cela évite les problèmes de pipes/race-condition sur Windows
$cmd2 = [
    $pythonPath,
    '-u',
    $step2Script,
    $metaJson,
    '-l', $lang,
    '--log-file', $logFile,
];
writeLog($logFile, '[WRAPPER] CMD2: ' . implode(' ', $cmd2));

// Descripteurs : on redirige stdout/stderr vers NUL car Python écrit dans le log directement
$descriptors2 = [
    0 => ['pipe', 'r'],   // stdin
    1 => ['file', 'NUL', 'w'],  // stdout → NUL (Python écrit dans --log-file)
    2 => ['file', $logFile, 'a'],  // stderr → log file directement
];

$proc2 = proc_open($cmd2, $descriptors2, $pipes2, $workDir, null);

if (!is_resource($proc2)) {
    writeLog($logFile, '[ERROR] Impossible de lancer step2 (proc_open failed)');
    exit(1);
}

fclose($pipes2[0]); // Fermer stdin

writeLog($logFile, '[WRAPPER] Step2 lancé (PID: ' . proc_get_status($proc2)['pid'] . '). Attente...');

// Attendre la fin du processus (bloquant mais correct)
$ret2 = proc_close($proc2);

if ($ret2 !== 0) {
    writeLog($logFile, '[ERROR] Step2 échoué (code ' . $ret2 . ')');
} else {
    writeLog($logFile, '[WRAPPER] ✓ Step2 terminé avec succès');
}

exit($ret2);
