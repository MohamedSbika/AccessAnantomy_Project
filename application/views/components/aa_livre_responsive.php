<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Page livre (livreDetails) — couche responsive mobile & tablette.
 *
 * À inclure dans le <head>, APRÈS v1_app.css : à spécificité égale c'est le
 * dernier chargé qui gagne, et ces feuilles doivent reprendre la main sur les
 * styles historiques.
 *
 *     <?php include('components/aa_livre_responsive.php'); ?>
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
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>livre-responsive.css<?php echo $aa_v('css/livre-responsive.css'); ?>">
