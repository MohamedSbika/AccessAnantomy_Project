<?php
/**
 * AccessAnatomy — pied de page unifié.
 *
 * Remplace les trois pieds de page qui coexistaient :
 *   - footer.php        bandeau bleu, logo + Contact + Connexion
 *   - v1_footer.php     bandeau vert sapin, newsletter + liens rapides
 *   - (rien du tout)    sur les vues de cours, figures et QCM
 *
 * ATTENTION : ce composant ne remplace PAS le fichier footer.php.
 * footer.php porte aussi la modale de connexion et neuf balises <script>
 * (jQuery, DataTables, app.js, validation…). Le retirer casserait le JS de
 * toutes les vues historiques. footer.php inclut désormais ce composant à la
 * place de son ancien bloc <footer>, et garde le reste.
 *
 * Sur une vue v1 qui n'inclut pas footer.php, l'appeler directement :
 *     <?php include('components/aa_footer.php'); ?>
 */

if (!isset($aa_base)) {
    include_once(__DIR__ . '/aa_nav_items.php');
}

/** Les catégories alimentent la colonne « Catalogue ». */
$aa_footer_cats = array_slice($aa_categories, 0, 5);
?>

<footer class="aa-footer aa-masquer-en-lecture" role="contentinfo">

    <div class="aa-footer__grille">

        <div>
            <a class="aa-footer__logo" href="<?php echo $aa_base; ?>login">
                <img src="<?php echo HTTP_IMAGES; ?>icons/icon-logo.png" alt="Access Anatomy">
            </a>

            <p class="aa-footer__pitch">
                <?php echo aa_e(aa_trad($aa_ci, 'footer_logo_description',
                    "Access Anatomy, l'excellence au service du savoir : votre référence en anatomie et embryologie.")); ?>
            </p>

            <?php if (!empty($aa_socials)): ?>
                <div class="aa-socials">
                    <?php foreach ($aa_socials as $aa_reseau): ?>
                        <a href="<?php echo aa_e($aa_reseau['url']); ?>"
                           target="_blank" rel="noopener"
                           title="<?php echo aa_e($aa_reseau['nom']); ?>"
                           aria-label="<?php echo aa_e($aa_reseau['nom']); ?>">
                            <img src="<?php echo aa_e($aa_reseau['icone']); ?>" alt="">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <div class="aa-footer__titre"><?php echo aa_e(aa_trad($aa_ci, 'footer_quick_links', 'Liens rapides')); ?></div>
            <ul class="aa-footer__liste">
                <?php foreach ($aa_nav_visible as $aa_item): ?>
                    <li>
                        <a href="<?php echo aa_e($aa_item['url']); ?>">
                            <?php echo aa_e($aa_item['libelle']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (!$aa_connecte): ?>
                    <li><a href="<?php echo $aa_base; ?>signUp"><?php echo aa_e(aa_trad($aa_ci, 'sign_up', "S'inscrire")); ?></a></li>
                <?php else: ?>
                    <li><a href="<?php echo $aa_base; ?>logout"><?php echo aa_e(aa_trad($aa_ci, 'logout', 'Déconnexion')); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div>
            <div class="aa-footer__titre"><?php echo aa_e(aa_trad($aa_ci, 'catalogue', 'Catalogue')); ?></div>
            <ul class="aa-footer__liste">
                <?php if (empty($aa_footer_cats)): ?>
                    <li><a href="<?php echo $aa_base; ?>login"><?php echo aa_e(aa_trad($aa_ci, 'accueil', 'Accueil')); ?></a></li>
                <?php else: ?>
                    <?php foreach ($aa_footer_cats as $aa_cat): ?>
                        <li>
                            <a href="<?php echo aa_e($aa_cat['url']); ?>">
                                <?php echo aa_e($aa_cat['libelle']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div>
            <div class="aa-footer__titre"><?php echo aa_e(aa_trad($aa_ci, 'footer_newsletter_title', 'Newsletter')); ?></div>
            <p style="margin:0 0 14px;">
                <?php echo aa_e(aa_trad($aa_ci, 'footer_newsletter_description',
                    'Rejoignez notre newsletter pour les dernières actualités.')); ?>
            </p>

            <?php
            /**
             * Le formulaire poste vers contactUS_process, seul point d'entrée
             * existant. v1_footer.php affichait un champ sans action : le
             * bouton ne faisait rien.
             */
            ?>
            <form class="aa-newsletter" action="<?php echo $aa_base; ?>contactUS" method="get">
                <input type="email" name="email" required
                       placeholder="<?php echo aa_e(aa_trad($aa_ci, 'footer_newsletter_placeholder', 'Votre email')); ?>"
                       aria-label="<?php echo aa_e(aa_trad($aa_ci, 'footer_newsletter_placeholder', 'Votre email')); ?>">
                <button type="submit">
                    <?php echo aa_e(aa_trad($aa_ci, 'footer_newsletter_button', "S'abonner")); ?>
                </button>
            </form>
        </div>
    </div>

    <div class="aa-footer__bas">
        <span>
            &copy; <?php echo date('Y'); ?> Access Anatomy —
            <a href="https://www.bongest.net" target="_blank" rel="noopener">Powered by BonGest</a>
        </span>

        <span class="aa-footer__legal">
            <a href="<?php echo $aa_base; ?>contactUS"><?php echo aa_e(aa_trad($aa_ci, 'footer_contact', 'Contact')); ?></a>
            <a href="<?php echo $aa_base; ?>listOffers/1"><?php echo aa_e(aa_trad($aa_ci, 'offers', 'Offres')); ?></a>
        </span>
    </div>
</footer>
