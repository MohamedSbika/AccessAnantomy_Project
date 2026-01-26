<?php
require_once 'application/config/database.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die('Erreur connexion: ' . $mysqli->connect_error);
}

// Vérifier si la colonne existe
$result = $mysqli->query('DESCRIBE _rappel_anatomique');
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

if (!in_array('FichierHTML', $columns)) {
    $mysqli->query('ALTER TABLE _rappel_anatomique ADD COLUMN FichierHTML VARCHAR(255) NULL');
    echo 'Colonne FichierHTML ajoutée avec succès';
} else {
    echo 'Colonne FichierHTML existe déjà';
}

$mysqli->close();
?>