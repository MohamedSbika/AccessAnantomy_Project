<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Page cours (livreCours) — couche responsive mobile & tablette.
 *
 * À inclure à la fin du <head>, APRÈS v1_app.css ET après le <style> de la
 * vue : plusieurs règles de la page (colonnes, #demo, plafond 40vw du bloc
 * figures) sont en !important, et à spécificité égale c'est la feuille
 * chargée en dernier qui l'emporte.
 *
 *     <?php include('components/aa_cours_responsive.php'); ?>
 *
 * Charge le socle commun des pages de lecture, puis la feuille propre au
 * cours (#demo, ligne de recherche, modales d'administration).
 */
$aa_v = isset($aa_v) ? $aa_v : function ($chemin) {
    $absolu = FCPATH . 'assets/' . $chemin;
    return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
};

/* __DIR__ obligatoire : un chemin relatif serait résolu depuis ce dossier-ci
   (components/), pas depuis la vue appelante. */
include(__DIR__ . '/aa_lecture_responsive.php');
?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>cours-responsive.css<?php echo $aa_v('css/cours-responsive.css'); ?>">
<script src="<?php echo HTTP_JS; ?>cours-responsive.js<?php echo $aa_v('js/cours-responsive.js'); ?>" defer></script>
