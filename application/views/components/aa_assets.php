<?php
/**
 * AccessAnatomy — ressources de l'interface unifiée.
 *
 * À inclure dans le <head>, APRÈS app.css / v1_app.css : à spécificité égale
 * c'est le dernier chargé qui gagne, et aa-ui.css doit pouvoir reprendre la
 * main sur les styles historiques.
 *
 *     <?php include('components/aa_assets.php'); ?>
 *
 * aa-ui.js est chargé en `defer` : il attend le DOM sans bloquer le rendu, et
 * s'auto-initialise (pas d'appel à faire depuis la page).
 */

/**
 * Empreinte de version = date de modification du fichier. Sans elle, un
 * navigateur qui a déjà chargé aa-ui.js le garde en cache et continue
 * d'exécuter l'ancienne version après un déploiement — un correctif de l'ui
 * paraissait alors sans effet. La valeur ne change qu'à la modification du
 * fichier : le cache reste pleinement utilisé entre deux déploiements.
 */
$aa_v = function ($chemin) {
    $absolu = FCPATH . 'assets/' . $chemin;
    return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
};
?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>aa-ui.css<?php echo $aa_v('css/aa-ui.css'); ?>">
<script src="<?php echo HTTP_JS; ?>aa-ui.js<?php echo $aa_v('js/aa-ui.js'); ?>" defer></script>
