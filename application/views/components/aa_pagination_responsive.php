<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Pagination DataTables — couche responsive commune.
 *
 * À inclure dans le <head>, APRÈS app.css / v1_app.css et après les autres
 * feuilles responsive de la page : les vues posent leurs propres règles de
 * pagination dans un <style> du <body>, et cette feuille doit pouvoir les
 * reprendre.
 *
 *     <?php include('components/aa_pagination_responsive.php'); ?>
 *
 * Un même include suffit pour toutes les pages : la feuille et le script sont
 * inertes tant qu'aucun pagineur DataTables n'est présent.
 *
 * Points de chargement :
 *   - header.php ............... toutes les pages historiques / administration
 *   - aa_lecture_responsive.php  toutes les pages de lecture v1_*
 *   - aa_calque_responsive.php   page des calques (listCalque / evaluatCalque)
 *
 * Une garde évite le double <link> quand deux de ces chemins se croisent
 * (aa_cours_responsive inclut aa_lecture_responsive, par exemple).
 *
 * Empreinte de version = date de modification du fichier : sans elle, un
 * navigateur ayant déjà chargé les fichiers garde l'ancienne version en cache
 * après un déploiement.
 */
if (!isset($GLOBALS['aa_pagination_responsive_loaded'])) {
    $GLOBALS['aa_pagination_responsive_loaded'] = true;

    $aa_v = isset($aa_v) ? $aa_v : function ($chemin) {
        $absolu = FCPATH . 'assets/' . $chemin;
        return is_file($absolu) ? '?v=' . filemtime($absolu) : '';
    };
    ?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>pagination-responsive.css<?php echo $aa_v('css/pagination-responsive.css'); ?>">
<script src="<?php echo HTTP_JS; ?>pagination-responsive.js<?php echo $aa_v('js/pagination-responsive.js'); ?>" defer></script>
<?php } ?>
