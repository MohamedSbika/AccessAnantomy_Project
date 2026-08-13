<?php
/**
 * AccessAnatomy — en-tête unifié.
 *
 * Remplace header_steppes.php + header_category.php (front mode admin),
 * v1_header_menu.php + v1_header_category.php + v1_header_langauge.php
 * (front mode lecture) et la barre de adm_nav.php (back-office) par un seul
 * markup, dont le responsive est piloté par aa-ui.css.
 *
 * À inclure juste après l'ouverture de <body> :
 *     <?php include('components/aa_header.php'); ?>
 *
 * Ne PAS l'envelopper dans un <header> de la vue : le composant fournit déjà
 * son propre <header class="aa-header">, et un parent avec un fond en
 * dégradé fait apparaître une bande de couleur au-dessus.
 *
 * Dépend de aa-ui.css et aa-ui.js (voir components/aa_assets.php).
 * Le tiroir mobile est rendu par components/aa_sidebar.php, inclus en fin de
 * fichier : les deux se nourrissent du même aa_nav_items.php.
 */

include_once(__DIR__ . '/aa_nav_items.php');
?>

<a class="aa-skip" href="#aa-contenu"><?php echo aa_e(aa_trad($aa_ci, 'aller_contenu', 'Aller au contenu')); ?></a>

<?php
/**
 * id="setNAVSTEPPS" : hérité de header_steppes.php. page_home.php mesure sa
 * hauteur pour dimensionner le carrousel, et footer.php le recharge en AJAX
 * après connexion. Le renommer casserait ces deux appels.
 */
?>
<header class="aa-header" id="setNAVSTEPPS" role="banner">

    <!-- Hamburger : masqué au-dessus de 992px par le CSS, jamais par un
         second markup dupliqué. -->
    <button type="button"
            class="aa-burger"
            id="aaBurger"
            aria-label="<?php echo aa_e(aa_trad($aa_ci, 'menu', 'Menu')); ?>"
            aria-controls="aaSidebar"
            aria-expanded="false">
        <span class="aa-burger__bar"></span>
    </button>

    <a class="aa-header__logo" href="<?php echo $aa_base; ?>login">
        <img src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" alt="Access Anatomy">
    </a>

    <!-- Navigation desktop. Rendue depuis aa_nav_items.php, la même source
         que le tiroir : une entrée ajoutée là apparaît aux deux endroits. -->
    <nav class="aa-nav" role="navigation" aria-label="<?php echo aa_e(aa_trad($aa_ci, 'menu', 'Menu')); ?>">

        <?php foreach ($aa_categories as $aa_i => $aa_cat): ?>
            <?php if (empty($aa_cat['livres'])): ?>

                <div class="aa-nav__item">
                    <a class="aa-nav__link" href="<?php echo aa_e($aa_cat['url']); ?>">
                        <span class="aa-nav__libelle"><?php echo aa_e($aa_cat['libelle']); ?></span>
                    </a>
                </div>

            <?php else: ?>

                <div class="aa-nav__item" data-aa="menu">
                    <button type="button" class="aa-nav__link"
                            aria-expanded="false"
                            aria-controls="aaCat<?php echo (int) $aa_i; ?>">
                        <span class="aa-nav__libelle"><?php echo aa_e($aa_cat['libelle']); ?></span>
                        <span class="aa-nav__chevron" aria-hidden="true"></span>
                    </button>

                    <div class="aa-panneau" id="aaCat<?php echo (int) $aa_i; ?>" role="menu">
                        <?php foreach ($aa_cat['livres'] as $aa_livre): ?>
                            <a class="aa-panneau__lien" role="menuitem"
                               href="<?php echo aa_e($aa_livre['url']); ?>">
                                <?php echo aa_e($aa_livre['libelle']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>

        <?php
        /**
         * Seul « Contact » rejoint les catégories dans la barre. Les autres
         * entrées sont volontairement absentes ici :
         *   - Accueil        déjà porté par le logo ;
         *   - Recherche      déjà porté par le champ de recherche à droite ;
         *   - Administration déjà dans le menu compte.
         *
         * Le nombre de catégories vient de la base et peut être élevé : sans
         * cet élagage, les derniers liens passaient sous le champ de
         * recherche dès 1440px. Toutes les entrées restent accessibles dans
         * le tiroir et le pied de page, qui n'ont pas cette contrainte.
         */
        foreach ($aa_nav_visible as $aa_item):
            if ($aa_item['cle'] !== 'contact') { continue; }
            ?>
            <div class="aa-nav__item">
                <a class="aa-nav__link<?php echo ($aa_page_active === $aa_item['cle']) ? ' aa-nav__link--actif' : ''; ?>"
                   href="<?php echo aa_e($aa_item['url']); ?>">
                    <span class="aa-nav__libelle"><?php echo aa_e($aa_item['libelle']); ?></span>
                </a>
            </div>
        <?php endforeach; ?>

    </nav>

    <div class="aa-header__actions">

        <?php
        /**
         * La recherche porte sur le contenu des ouvrages, qui n'est accessible
         * qu'aux comptes connectés : la proposer à un visiteur anonyme le
         * menait à une page de résultats sur laquelle il ne pouvait ouvrir
         * aucun lien. Elle est donc réservée à la session authentifiée, ici
         * comme dans le tiroir.
         */
        if ($aa_connecte): ?>
        <form class="aa-recherche"
              action="<?php echo $aa_base; ?>searchIndex"
              method="post"
              role="search">
            <?php // Le contrôleur searchIndex lit $_POST['indexSearch']. ?>
            <svg class="aa-recherche__icone" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search"
                   name="indexSearch"
                   value="<?php echo isset($indexSearch) ? aa_e($indexSearch) : ''; ?>"
                   placeholder="<?php echo aa_e(aa_trad($aa_ci, 'search', 'Rechercher')); ?>"
                   aria-label="<?php echo aa_e(aa_trad($aa_ci, 'search', 'Rechercher')); ?>">
            <button type="submit" class="aa-recherche__valider" tabindex="-1" aria-hidden="true"></button>
        </form>
        <?php endif; ?>

        <!-- Sélecteur de langue -->
        <div class="aa-langue" data-aa="menu">
            <button type="button" class="aa-declencheur" aria-expanded="false"
                    aria-label="<?php echo aa_e(aa_trad($aa_ci, 'langue', 'Langue')); ?>">
                <span class="aa-drapeau" aria-hidden="true"><?php echo $aa_drapeau; ?></span>
                <span class="aa-langue__nom"><?php echo aa_e($aa_langue_active); ?></span>
                <span class="aa-nav__chevron" aria-hidden="true"></span>
            </button>

            <div class="aa-panneau aa-panneau--droite" role="menu">
                <?php foreach ($aa_langues as $aa_code_langue => $aa_infos): ?>
                    <a class="aa-panneau__lien<?php echo ($aa_code_langue === $aa_langue_active) ? ' aa-panneau__lien--actif' : ''; ?>"
                       role="menuitem"
                       href="<?php echo base_url(); ?>login/switchLang/<?php echo $aa_code_langue; ?>">
                        <span class="aa-drapeau" aria-hidden="true"><?php echo $aa_infos['drapeau']; ?></span>
                        <?php echo aa_e($aa_infos['nom']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($aa_connecte): ?>

            <div class="aa-compte" data-aa="menu">
                <button type="button" class="aa-declencheur" aria-expanded="false">
                    <img src="<?php echo HTTP_IMAGES; ?>photos/user-icon.png"
                         class="aa-avatar" alt="">
                    <span class="aa-compte__nom">
                        <?php echo aa_e($aa_ci->session->userdata('logged_in_name')
                            ?: $aa_ci->session->userdata('logged_in')); ?>
                    </span>
                    <span class="aa-nav__chevron" aria-hidden="true"></span>
                </button>

                <div class="aa-panneau aa-panneau--droite" role="menu">

                    <?php if ($aa_estAdmin): ?>
                        <a class="aa-panneau__lien" role="menuitem" href="<?php echo $aa_base; ?>pagesSetting">
                            <?php echo aa_e(aa_trad($aa_ci, 'settings', 'Administration')); ?>
                        </a>

                        <?php
                        /**
                         * Bascule mode admin / mode lecture. C'est
                         * switchPlatform() qui change le jeu de vues servi
                         * (v1_* en lecture) ; l'URL courante est passée
                         * chiffrée pour revenir sur la même page.
                         */
                        ?>
                        <a class="aa-panneau__lien" role="menuitem"
                           href="<?php echo base_url() . $aa_lang . 'switchPlatform/' . $aa_url_retour; ?>">
                            <?php echo $aa_mode_lecture_plateforme
                                ? aa_e(aa_trad($aa_ci, 'mode_admin', 'Mode admin'))
                                : aa_e(aa_trad($aa_ci, 'mode_lecture', 'Mode lecture')); ?>
                        </a>

                        <div class="aa-panneau__separateur"></div>
                    <?php endif; ?>

                    <a class="aa-panneau__lien" role="menuitem" href="<?php echo $aa_base; ?>logout">
                        <?php echo aa_e(aa_trad($aa_ci, 'logout', 'Déconnexion')); ?>
                    </a>
                </div>
            </div>

        <?php else: ?>

            <?php
            /**
             * La modale de connexion est fournie par footer.php (#centeredModalPrimary)
             * sur les vues historiques et par v1_modal_login.php
             * (openModalLogin()) sur les vues v1. aa-ui.js appelle celle qui
             * est présente.
             *
             * Le href sert de repli quand la page n'en embarque aucune : il
             * mène à l'accueil avec ?connexion=1, qui y ouvre la modale.
             * Auparavant il pointait sur « …/login », une page sans formulaire
             * — le clic semblait sans effet.
             */
            ?>
            <a class="aa-btn aa-btn--ghost aa-cacher-xs" href="<?php echo $aa_base; ?>login" data-aa="connexion">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_in', 'Se connecter')); ?>
            </a>

            <a class="aa-btn" href="<?php echo $aa_base; ?>signUp">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_up', "S'inscrire")); ?>
            </a>

        <?php endif; ?>

        <?php
        /**
         * Emplacement d'appel à l'action, utilisé par la page d'accueil pour
         * son bouton « Démarrer gratuitement ». La vue le pose AVANT
         * l'include :  $aa_cta = array('libelle' => '…', 'url' => '…');
         */
        if (!empty($aa_cta['libelle'])): ?>
            <a class="aa-btn aa-cacher-md" href="<?php echo aa_e($aa_cta['url']); ?>">
                <?php echo aa_e($aa_cta['libelle']); ?>
            </a>
        <?php endif; ?>

    </div>
</header>

<?php
include(__DIR__ . '/aa_sidebar.php');

// Le sélecteur Google Translate reste tel quel : il est utilisé par
// l'ensemble des pages et sort du périmètre de cette refonte.
if (file_exists(__DIR__ . '/../v1_google_translate.php')) {
    include_once(__DIR__ . '/../v1_google_translate.php');
}
?>
