<?php
/**
 * AccessAnatomy — bandeau de contexte (mode admin + entrée en mode lecture).
 *
 * MODE ADMIN
 * Un bandeau visible en permanence quand EstAdmin == 1. Auparavant, le fait
 * d'être administrateur ne se voyait qu'aux crayons d'édition disséminés
 * dans les breadcrumbs : rien ne distinguait clairement la consultation de
 * l'édition sur un contenu pédagogique.
 *
 * MODE LECTURE
 * Retire tout le chrome et ramène le contenu à une colonne lisible.
 * À ne pas confondre avec switchPlatform(), qui change de jeu de vues :
 * ici c'est une bascule CSS sur <body>, persistée en localStorage pour
 * survivre au passage au chapitre suivant.
 *
 * Usage, juste après components/aa_header.php :
 *     <?php include('components/aa_modes.php'); ?>
 *
 * Puis envelopper le contenu du cours :
 *     <div class="aa-lecture-zone"> ... </div>
 *
 * Une vue sans contenu lisible (liste, formulaire) peut masquer le bouton :
 *     <?php $aa_sans_mode_lecture = true; ?>
 */

if (!isset($aa_base)) {
    include_once(__DIR__ . '/aa_nav_items.php');
}

/**
 * Le bouton « mode lecture » est désactivé par défaut.
 *
 * Les vues de cours en proposent déjà un, dans le rail de raccourcis de
 * v1_racourci.php : il ouvre customModal_Mode_Lecture, une modale avec
 * réglages de police et de contraste (v1_modal_mode_lecture.php). Rendre en
 * plus le bouton ci-dessous donnerait deux entrées « Mode lecture » côte à
 * côte, faisant deux choses différentes.
 *
 * La bascule CSS reste disponible pour une vue qui n'a pas la modale :
 *     <?php $aa_avec_mode_lecture = true; ?>
 * ou depuis n'importe quel bouton portant data-aa="lecture".
 */
$aa_montrer_lecture = (isset($aa_avec_mode_lecture) && $aa_avec_mode_lecture)
    && !(isset($aa_sans_mode_lecture) && $aa_sans_mode_lecture);

/** Identifiants de contexte, utilisés pour les liens d'édition. */
$aa_id_livre    = isset($OneBook[0]['IDLivre'])    ? $OneBook[0]['IDLivre']    : null;
$aa_id_chapitre = isset($OneBook[0]['IDChapitre']) ? $OneBook[0]['IDChapitre'] : null;

/** Rien à afficher : ni bandeau admin, ni bouton lecture. */
if (!$aa_estAdmin && !$aa_montrer_lecture) {
    return;
}
?>

<div class="aa-admin-bar aa-masquer-en-lecture" role="region"
     aria-label="<?php echo aa_e(aa_trad($aa_ci, 'mode_admin', 'Mode administrateur')); ?>">

    <?php if ($aa_estAdmin): ?>

        <span class="aa-admin-bar__etiquette">
            <?php echo aa_e(aa_trad($aa_ci, 'mode_admin', 'Mode admin')); ?>
        </span>

        <span>
            <?php echo aa_e($aa_ci->session->userdata('logged_in_name')
                ?: $aa_ci->session->userdata('logged_in')); ?>
        </span>

    <?php endif; ?>

    <span class="aa-admin-bar__actions">

        <?php if ($aa_montrer_lecture): ?>
            <?php
            /**
             * Bouton d'entrée en mode lecture. Il vivait auparavant en
             * position flottante en haut à gauche, où il recouvrait le rail
             * de raccourcis (Cours / QCM / QROC) de v1_racourci.php.
             */
            ?>
            <a href="#" data-aa="lecture">
                <span aria-hidden="true">&#128214;</span>
                <?php echo aa_e(aa_trad($aa_ci, 'mode_lecture', 'Mode lecture')); ?>
            </a>
        <?php endif; ?>

        <?php if ($aa_estAdmin): ?>

            <a href="<?php echo $aa_base; ?>pagesSetting">
                <?php echo aa_e(aa_trad($aa_ci, 'settings', 'Administration')); ?>
            </a>

            <?php if ($aa_id_livre !== null): ?>
                <a href="<?php echo $aa_base; ?>livre/<?php echo (int) $aa_id_livre; ?>">
                    <?php echo aa_e(aa_trad($aa_ci, 'ouvrage', 'Ouvrage')); ?>
                </a>
            <?php endif; ?>

            <?php if ($aa_id_chapitre !== null): ?>
                <a href="<?php echo $aa_base; ?>settingTest/<?php echo (int) $aa_id_chapitre; ?>">
                    <?php echo aa_e(aa_trad($aa_ci, 'tests', 'Tests')); ?>
                </a>
            <?php endif; ?>

        <?php endif; ?>
    </span>
</div>

<?php if ($aa_montrer_lecture): ?>
    <!-- Sortie flottante : en mode lecture l'en-tête est masqué, il faut un
         moyen visible de revenir. -->
    <div class="aa-lecture-sortie">
        <button type="button" class="aa-btn" data-aa="quitter-lecture">
            &times;&nbsp; <?php echo aa_e(aa_trad($aa_ci, 'quitter_lecture', 'Quitter la lecture')); ?>
        </button>
    </div>
<?php endif; ?>
