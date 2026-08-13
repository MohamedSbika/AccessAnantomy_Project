<?php
/**
 * AccessAnatomy — tiroir de navigation.
 *
 * Un seul composant pour les deux usages :
 *   - sous 992px  : tiroir hors écran, ouvert par le hamburger, avec voile
 *   - au-dessus   : peut être ancré en colonne via .aa-sidebar--ancree
 *
 * Rendu depuis aa_nav_items.php, la même source que l'en-tête : le menu
 * mobile n'est pas un second markup à maintenir en parallèle.
 *
 * L'id `sideNav` est référencé par d'anciens scripts de vue via closeNav() ;
 * aa-ui.js retombe sur cet id si #aaSidebar est absent.
 */

// Inclus seul (page sans aa_header), on charge quand même la navigation.
if (!isset($aa_nav_visible)) {
    include_once(__DIR__ . '/aa_nav_items.php');
}

/** Une vue peut passer $aa_sidebar_ancree = true pour la colonne desktop. */
$aa_ancree = isset($aa_sidebar_ancree) && $aa_sidebar_ancree;
?>

<div class="aa-voile" id="aaVoile" aria-hidden="true"></div>

<aside class="aa-sidebar<?php echo $aa_ancree ? ' aa-sidebar--ancree' : ''; ?>"
       id="aaSidebar"
       aria-hidden="true"
       aria-label="<?php echo aa_e(aa_trad($aa_ci, 'menu', 'Menu')); ?>">

    <div class="aa-sidebar__entete">
        <a class="aa-header__logo" href="<?php echo $aa_base; ?>login">
            <img src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" alt="Access Anatomy">
        </a>

        <button type="button"
                class="aa-sidebar__fermer"
                data-aa="fermer-tiroir"
                aria-label="<?php echo aa_e(aa_trad($aa_ci, 'fermer', 'Fermer')); ?>">&times;</button>
    </div>

    <nav class="aa-sidebar__corps" role="navigation">

        <?php
        // La recherche est masquée dans l'en-tête sous 768px : elle réapparaît
        // ici. Comme dans l'en-tête, elle est réservée aux comptes connectés.
        if ($aa_connecte): ?>
        <form action="<?php echo $aa_base; ?>searchIndex" method="post" role="search"
              style="margin-bottom: 6px;">
            <input type="search"
                   name="indexSearch"
                   placeholder="<?php echo aa_e(aa_trad($aa_ci, 'search', 'Rechercher')); ?>"
                   aria-label="<?php echo aa_e(aa_trad($aa_ci, 'search', 'Rechercher')); ?>"
                   style="width:100%;min-height:46px;border:1px solid var(--aa-bordure);border-radius:var(--aa-radius-sm);padding:0 14px;font-size:16px;">
        </form>
        <?php endif; ?>

        <?php if (!empty($aa_categories)): ?>
            <div class="aa-sidebar__titre"><?php echo aa_e(aa_trad($aa_ci, 'catalogue', 'Catalogue')); ?></div>

            <?php foreach ($aa_categories as $aa_i => $aa_cat): ?>
                <?php if (empty($aa_cat['livres'])): ?>

                    <a class="aa-sidebar__lien" href="<?php echo aa_e($aa_cat['url']); ?>" data-aa="fermer-tiroir">
                        <?php echo aa_e($aa_cat['libelle']); ?>
                    </a>

                <?php else: ?>

                    <?php // Accordéon : le survol du desktop n'existe pas au tactile. ?>
                    <div class="aa-accordeon">
                        <button type="button" class="aa-sidebar__lien" data-aa="accordeon"
                                aria-expanded="false">
                            <span><?php echo aa_e($aa_cat['libelle']); ?></span>
                            <span class="aa-nav__chevron" aria-hidden="true"></span>
                        </button>

                        <div class="aa-accordeon__contenu">
                            <?php foreach ($aa_cat['livres'] as $aa_livre): ?>
                                <a class="aa-sidebar__lien"
                                   href="<?php echo aa_e($aa_livre['url']); ?>"
                                   data-aa="fermer-tiroir">
                                    <?php echo aa_e($aa_livre['libelle']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="aa-sidebar__titre"><?php echo aa_e(aa_trad($aa_ci, 'navigation', 'Navigation')); ?></div>

        <?php foreach ($aa_nav_visible as $aa_item): ?>
            <a class="aa-sidebar__lien<?php echo ($aa_page_active === $aa_item['cle']) ? ' aa-sidebar__lien--actif' : ''; ?>"
               href="<?php echo aa_e($aa_item['url']); ?>"
               data-aa="fermer-tiroir">
                <?php echo aa_e($aa_item['libelle']); ?>
            </a>
        <?php endforeach; ?>

        <div class="aa-sidebar__titre"><?php echo aa_e(aa_trad($aa_ci, 'compte', 'Mon compte')); ?></div>

        <?php if ($aa_connecte): ?>

            <?php if ($aa_estAdmin): ?>
                <a class="aa-sidebar__lien"
                   href="<?php echo base_url() . $aa_lang . 'switchPlatform/' . $aa_url_retour; ?>">
                    <?php echo $aa_mode_lecture_plateforme
                        ? aa_e(aa_trad($aa_ci, 'mode_admin', 'Mode admin'))
                        : aa_e(aa_trad($aa_ci, 'mode_lecture', 'Mode lecture')); ?>
                </a>
            <?php endif; ?>

            <a class="aa-sidebar__lien" href="<?php echo $aa_base; ?>logout">
                <?php echo aa_e(aa_trad($aa_ci, 'logout', 'Déconnexion')); ?>
            </a>

        <?php else: ?>

            <?php // Même repli que l'en-tête : accueil + ouverture de la modale. ?>
            <a class="aa-sidebar__lien" href="<?php echo $aa_base; ?>login" data-aa="connexion">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_in', 'Se connecter')); ?>
            </a>
            <a class="aa-sidebar__lien" href="<?php echo $aa_base; ?>signUp" data-aa="fermer-tiroir">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_up', "S'inscrire")); ?>
            </a>

        <?php endif; ?>

        <?php
        /**
         * Pas de sélecteur de langue ici. Le tiroir n'est ouvert que sous
         * 1200px, largeurs auxquelles l'en-tête affiche déjà le sien (réduit
         * au drapeau sous 768px, mais toujours présent). Les onze langues
         * ajoutaient une liste plus longue que la navigation elle-même, qu'il
         * fallait dépasser à chaque ouverture pour atteindre le contenu propre
         * à la page rendu juste en dessous.
         */
        ?>

        <?php
        /**
         * Contenu propre à la page (sommaire de chapitre, calques, raccourcis
         * atlas). La vue le fournit en définissant $aa_sidebar_extra avant
         * l'include, ce qui évite de rouvrir ce fichier pour chaque cas.
         */
        if (isset($aa_sidebar_extra) && $aa_sidebar_extra !== '') {
            echo $aa_sidebar_extra;
        }
        ?>
    </nav>
</aside>
