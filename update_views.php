<?php
$file = 'application/views/livreDetails.php';
$content = file_get_contents($file);

// Replace accept=".docx"
$content = str_replace('accept=".docx"', 'accept=".docx,.html,.htm"', $content);

// Replace accept="\.docx" in other valid strings if they exist, but the above should catch them.
$content = str_replace('text: \'Seuls les fichiers .docx sont acceptés\'', 'text: \'Seuls les fichiers .docx, .html ou .htm sont acceptés\'', $content);
$content = str_replace('text: "Seuls les fichiers .docx sont acceptés"', 'text: "Seuls les fichiers .docx, .html ou .htm sont acceptés"', $content);

// Function checks for .docx
$content = str_replace('if (!fichier.name.endsWith(\'.docx\')) {', 'var ext = fichier.name.split(".").pop().toLowerCase();'."\n".'    if (![\'docx\', \'html\', \'htm\'].includes(ext)) {', $content);

$content = str_replace("text: 'Veuillez choisir un fichier .docx avant de continuer.'", "text: 'Veuillez choisir un fichier .docx, .html ou .htm avant de continuer.'", $content);
$content = str_replace("Contenu (.docx)", "Contenu (.docx, .html)", $content);
$content = str_replace("Résumé (.docx)", "Résumé (.docx, .html)", $content);

file_put_contents($file, $content);

echo "Updated livreDetails.php\n";
