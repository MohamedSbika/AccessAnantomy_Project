<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Header responsive — mobile & tablette.
 *
 * Ajoute uniquement le comportement < 992px : le header desktop est inchange.
 *
 * Options a definir AVANT l'include :
 *   $aa_mobile_bar = true;  -> affiche une barre superieure (logo + burger)
 *                              sur les pages qui n'ont pas de header visible
 *                              en mobile (livre, cours, figures...).
 */
$aa_mobile_bar = isset($aa_mobile_bar) ? $aa_mobile_bar : false;
?>
<link href="<?php echo HTTP_CSS; ?>header-responsive.css?v=1" rel="stylesheet">

<?php if ($aa_mobile_bar) { ?>
    <style>
        /* La barre mobile remplace le burger flottant */
        @media (max-width: 991.98px) {
            button.menu-btn {
                display: none !important;
            }
        }
    </style>
    <div class="aa-mobile-bar">
        <button type="button" class="aa-mobile-bar__burger" onclick="toggleNav()"
                aria-label="Menu" aria-controls="sideNav">&#9776;</button>
        <a class="aa-mobile-bar__brand"
           href="<?php echo base_url() . $this->lang->line('siteLang'); ?>login">
            <img src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" alt="Access Anatomy">
        </a>
        <span class="aa-mobile-bar__spacer"></span>
    </div>
<?php } ?>

<div class="aa-nav-backdrop" id="aaNavBackdrop"></div>

<script src="<?php echo HTTP_JS; ?>header-responsive.js?v=1"></script>
