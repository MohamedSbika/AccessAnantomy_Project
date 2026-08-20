<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Pages de lecture — couche responsive mobile & tablette.
 *
 * À inclure à la fin du <head>, APRÈS v1_app.css ET après le <style> de la
 * vue : les vues posent leurs largeurs en !important ou en style inline, et à
 * spécificité égale c'est la feuille chargée en dernier qui l'emporte.
 *
 *     <?php include('components/aa_lecture_responsive.php'); ?>
 *
 * Option à définir AVANT l'include :
 *   $aa_avec_figures = false;   -> page sans bloc figures (evaluatQCM/QROC)
 *
 * Une page qui a en plus des besoins propres (livreCours) charge sa feuille
 * après celle-ci ; voir components/aa_cours_responsive.php.
 */
$aa_avec_figures = isset($aa_avec_figures) ? $aa_avec_figures : true;

$aa_v = isset($aa_v) ? $aa_v : function ($chemin) {
    $absolu = FCPATH . 'assets/' . $chemin;
    return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
};

/* __DIR__ obligatoire : un chemin relatif serait résolu depuis ce dossier-ci
   (components/), pas depuis la vue appelante — l'include échouerait en
   silence et la couche commune ne serait jamais chargée. */
include(__DIR__ . '/aa_racourci_responsive.php');
?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>lecture-responsive.css<?php echo $aa_v('css/lecture-responsive.css'); ?>">
<?php if ($aa_avec_figures) { ?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>figures-responsive.css<?php echo $aa_v('css/figures-responsive.css'); ?>">
<?php } ?>
<?php
/* En dernier : la pagination des listes de questions doit reprendre la main
   sur les règles que les vues posent dans un <style> du <body>, et sur celles
   de lecture-responsive.css chargée juste au-dessus. */
include(__DIR__ . '/aa_pagination_responsive.php');
?>
