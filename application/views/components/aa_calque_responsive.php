<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Page des calques (v1_listCalqueFigure.php) — couche responsive.
 *
 * Sert les deux parcours bâtis sur cette vue :
 *   /XX/listCalque/<chapitre>
 *   /XX/evaluatCalque/<chap>.<chap>…
 *
 * À inclure à la fin du <head>, APRÈS v1_app.css et AVANT aa_rtl_assets() :
 *
 *     <?php include('components/aa_calque_responsive.php'); ?>
 *
 * Charge le socle commun aux pages qui incluent v1_racourci.php, puis la
 * feuille propre aux calques.
 *
 * La page n'a pas de pagineur DataTables ; aa_pagination_responsive.php n'est
 * donc pas inclus ici.
 */
$aa_v = isset($aa_v) ? $aa_v : function ($chemin) {
    $absolu = FCPATH . 'assets/' . $chemin;
    return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
};

/* __DIR__ obligatoire : un chemin relatif serait résolu depuis ce dossier-ci
   (components/), pas depuis la vue appelante — l'include échouerait en
   silence et la couche commune ne serait jamais chargée. */
include(__DIR__ . '/aa_racourci_responsive.php');
?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>calque-responsive.css<?php echo $aa_v('css/calque-responsive.css'); ?>">
