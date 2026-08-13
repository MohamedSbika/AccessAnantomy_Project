<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Socle responsive commun aux pages « lecture » (celles qui incluent
 * v1_racourci.php) : couche globale + bloc raccourcis + panneau des chapitres.
 *
 * N'est jamais inclus directement par une vue : les composants de page
 * (aa_livre_responsive.php, aa_cours_responsive.php…) l'incluent en premier,
 * puis ajoutent leur propre feuille.
 *
 * Le header mobile (barre + tiroir) est fourni séparément par
 * components/aa_header_mobile.php, déjà inclus depuis v1_header_menu.php.
 *
 * Empreinte de version = date de modification du fichier : sans elle, un
 * navigateur ayant déjà chargé le CSS garde l'ancienne version en cache après
 * un déploiement. La valeur ne bouge qu'à la modification du fichier.
 */
$aa_v = isset($aa_v) ? $aa_v : function ($chemin) {
    $absolu = FCPATH . 'assets/' . $chemin;
    return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
};
?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>responsive-global.css<?php echo $aa_v('css/responsive-global.css'); ?>">
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>racourci-responsive.css<?php echo $aa_v('css/racourci-responsive.css'); ?>">
<script src="<?php echo HTTP_JS; ?>racourci-responsive.js<?php echo $aa_v('js/racourci-responsive.js'); ?>" defer></script>
