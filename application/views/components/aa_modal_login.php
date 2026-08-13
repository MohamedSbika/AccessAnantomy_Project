<?php
/**
 * AccessAnatomy — modale de connexion unique.
 *
 * Remplace les DEUX modales qui coexistaient, au design sans rapport l'une
 * avec l'autre :
 *   - footer.php          #centeredModalPrimary — fond vert plein, champs
 *                         verts sur vert, dépendante de Bootstrap et de
 *                         jquery.validate, servie sur les 38 vues historiques ;
 *   - v1_modal_login.php  #customModal — carte blanche, styles en ligne,
 *                         servie sur le seul accueil.
 *
 * À inclure une fois par page, avant la fermeture de </body> :
 *     <?php include('components/aa_modal_login.php'); ?>
 *
 * Ouverture :
 *   - un lien ou bouton portant data-aa="connexion" (aa-ui.js s'en charge) ;
 *   - window.openModalLogin() depuis n'importe quel script ;
 *   - l'URL ?connexion=1, utilisée par les pages réservées qui renvoient un
 *     visiteur non connecté vers l'accueil.
 *
 * L'identifiant #centeredModalPrimary et les noms de champs sont conservés :
 * plusieurs vues les visent encore directement.
 *
 * Aucune dépendance : ni Bootstrap, ni jQuery, ni SweetAlert. Les vues
 * v1_figures_only et video_upload ne chargent pas bootstrap.js, et la
 * connexion doit y fonctionner. SweetAlert est utilisé s'il est présent,
 * sinon les messages s'affichent dans la modale.
 */

/**
 * Une seule instance par page : les identifiants (#loginform, #redirectLog…)
 * doivent rester uniques, et footer.php comme la vue elle-même peuvent
 * l'inclure. Le chemin d'inclusion varie d'un appelant à l'autre, include_once
 * ne suffirait donc pas à dédoublonner.
 */
if (defined('AA_MODALE_LOGIN_RENDUE')) {
    return;
}
define('AA_MODALE_LOGIN_RENDUE', true);

include_once(__DIR__ . '/aa_nav_items.php');

/**
 * Destination après connexion. Reprend les cas que footer.php traitait en
 * PHP au milieu de son script :
 *   - page « livre »       : la fiche du livre demandé ;
 *   - page « searchIndex » : on relance la recherche en place ;
 *   - ailleurs             : on recharge, le serveur rend alors la version
 *                            connectée de la page.
 * Une vue peut imposer sa propre cible en posant $aa_login_retour avant
 * l'include.
 */
if (!isset($aa_login_retour)) {
    $aa_login_retour = '';
    if (isset($page) && $page === 'livre' && !empty($OneBook[0]['IDLivre'])) {
        $aa_login_retour = $aa_base . 'livreDetails/' . $OneBook[0]['IDLivre'];
    }
}

$aa_login_recherche = (isset($page) && $page === 'searchIndex');
?>

<div class="aa-modale" id="centeredModalPrimary" role="dialog" aria-modal="true"
     aria-labelledby="aaLoginTitre" hidden>

    <div class="aa-modale__contenu" role="document">

        <button type="button" class="aa-modale__fermer" data-aa="fermer-modale"
                aria-label="<?php echo aa_e(aa_trad($aa_ci, 'fermer', 'Fermer')); ?>">&times;</button>

        <img class="aa-modale__logo" src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" alt="">

        <h2 class="aa-modale__titre" id="aaLoginTitre">
            <?php echo aa_e(aa_trad($aa_ci, 'auth_req', 'Authentification requise')); ?>
        </h2>

        <p class="aa-modale__intro">
            <?php echo aa_e(aa_trad($aa_ci, 'auth_intro',
                'Connectez-vous pour accéder aux cours, aux atlas et aux évaluations.')); ?>
        </p>

        <form id="loginform" name="loginformA" method="post" novalidate>

            <?php // Lu par redirectLogLivr() : identifiant du livre à ouvrir après connexion. ?>
            <input type="hidden" value="0" id="redirectLog">

            <div id="user_message_error" class="aa-alerte aa-alerte--erreur" role="alert" hidden>
                <?php echo aa_e(aa_trad($aa_ci, 'user_message_error',
                    'Identifiants incorrects. Veuillez réessayer.')); ?>
            </div>

            <div class="aa-groupe">
                <label class="aa-label" for="aaLoginEmail">
                    <?php echo aa_e(aa_trad($aa_ci, 'email', 'Email')); ?>
                </label>
                <input class="aa-champ" type="email" name="email" id="aaLoginEmail"
                       autocomplete="email" required
                       placeholder="<?php echo aa_e(aa_trad($aa_ci, 'in_email', 'vous@exemple.com')); ?>">
            </div>

            <div class="aa-groupe">
                <label class="aa-label" for="aaLoginPassword">
                    <?php echo aa_e(aa_trad($aa_ci, 'password', 'Mot de passe')); ?>
                </label>

                <div class="aa-champ-groupe">
                    <input class="aa-champ" type="password" name="password" id="aaLoginPassword"
                           autocomplete="current-password" required
                           placeholder="<?php echo aa_e(aa_trad($aa_ci, 'in_password', 'Votre mot de passe')); ?>">

                    <button type="button" class="aa-champ-action" id="aaLoginOeil"
                            aria-label="<?php echo aa_e(aa_trad($aa_ci, 'show_password', 'Afficher le mot de passe')); ?>"
                            aria-pressed="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"></path>
                            <circle cx="12" cy="12" r="3.2"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="aa-modale__liens">
                <a href="<?php echo $aa_base; ?>resetUp">
                    <?php echo aa_e(aa_trad($aa_ci, 'forgot_password', 'Mot de passe oublié ?')); ?>
                </a>
            </div>

            <button type="submit" class="aa-btn aa-btn--bloc aa-btn--large" id="aaLoginValider">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_in', 'Se connecter')); ?>
            </button>
        </form>

        <p class="aa-modale__pied">
            <?php echo aa_e(aa_trad($aa_ci, 'no_account', 'Pas encore de compte ?')); ?>
            <a href="<?php echo $aa_base; ?>signUp">
                <?php echo aa_e(aa_trad($aa_ci, 'sign_up', "S'inscrire")); ?>
            </a>
        </p>
    </div>
</div>

<script>
(function () {
    'use strict';

    var modale  = document.getElementById('centeredModalPrimary');
    var form    = document.getElementById('loginform');
    var erreur  = document.getElementById('user_message_error');
    var valider = document.getElementById('aaLoginValider');
    if (!modale || !form) { return; }

    var LIBELLE_VALIDER = valider ? valider.textContent.trim() : '';
    var dernierFocus    = null;

    /* ------------------------------------------------------------------
       Ouverture / fermeture
       ------------------------------------------------------------------ */

    function ouvrir() {
        dernierFocus = document.activeElement;
        modale.hidden = false;
        modale.classList.add('est-ouverte');
        document.body.style.overflow = 'hidden';

        var champ = document.getElementById('aaLoginEmail');
        if (champ) { champ.focus(); }
    }

    function fermer() {
        modale.classList.remove('est-ouverte');
        modale.hidden = true;
        document.body.style.overflow = '';
        cacherErreur();

        // Rendre le focus à l'élément qui a ouvert la modale : sans cela, la
        // navigation au clavier repart du haut du document.
        if (dernierFocus && typeof dernierFocus.focus === 'function') {
            dernierFocus.focus();
        }
    }

    // On n'expose délibérément PAS openModal/closeModal : v1_listCalqueFigure.php
    // définit des fonctions de ces noms pour sa modale de test de calque.
    window.openModalLogin  = ouvrir;
    window.closeModalLogin = fermer;

    /** Identifiant du livre à ouvrir une fois la connexion établie. */
    window.redirectLogLivr = function (typeCNX) {
        document.getElementById('redirectLog').value = typeCNX || 0;
    };

    modale.addEventListener('click', function (e) {
        // Clic sur le voile (hors de la carte) ou sur la croix.
        if (e.target === modale || e.target.closest('[data-aa="fermer-modale"], [data-dismiss="modal"]')) {
            fermer();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modale.classList.contains('est-ouverte')) { fermer(); }
    });

    /* Les pages réservées renvoient ici avec ?connexion=1. */
    if (new URLSearchParams(window.location.search).has('connexion')) {
        ouvrir();
    }

    /* ------------------------------------------------------------------
       Affichage du mot de passe
       ------------------------------------------------------------------ */

    var oeil = document.getElementById('aaLoginOeil');
    if (oeil) {
        oeil.addEventListener('click', function () {
            var champ = document.getElementById('aaLoginPassword');
            var visible = champ.type === 'text';
            champ.type = visible ? 'password' : 'text';
            oeil.setAttribute('aria-pressed', String(!visible));
            champ.focus();
        });
    }

    /* ------------------------------------------------------------------
       Soumission
       ------------------------------------------------------------------ */

    function afficherErreur(message) {
        erreur.textContent = message;
        erreur.hidden = false;
    }

    function cacherErreur() {
        erreur.hidden = true;
    }

    function enCours(actif) {
        if (!valider) { return; }
        valider.disabled = actif;
        valider.textContent = actif
            ? <?php echo json_encode(aa_trad($aa_ci, 'auth_prog', 'Connexion en cours…')); ?>
            : LIBELLE_VALIDER;
    }

    /** Cible après connexion — voir le calcul PHP en tête de fichier. */
    function apresConnexion() {
        var livre = parseInt(document.getElementById('redirectLog').value, 10) || 0;
        if (livre > 0) {
            window.location.href = <?php echo json_encode($aa_base . 'livreDetails/'); ?> + livre;
            return;
        }

        var cible = <?php echo json_encode($aa_login_retour); ?>;
        if (cible) { window.location.href = cible; return; }

        <?php if ($aa_login_recherche): ?>
        // Page de résultats : on relance la recherche en place plutôt que de
        // recharger sur un formulaire vide.
        var relancer = document.getElementById('validSearch');
        if (relancer) { relancer.click(); return; }
        <?php endif; ?>

        // Par défaut : on recharge, le serveur rend la version connectée.
        // ?connexion=1 est retiré, sinon la modale se rouvrirait par-dessus.
        var url = new URL(window.location.href);
        url.searchParams.delete('connexion');
        window.location.href = url.toString();
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        cacherErreur();

        var email = document.getElementById('aaLoginEmail');
        var pass  = document.getElementById('aaLoginPassword');

        if (!email.value.trim() || !pass.value) {
            afficherErreur(<?php echo json_encode(aa_trad($aa_ci, 'form_required',
                'Renseignez votre email et votre mot de passe.')); ?>);
            (email.value.trim() ? pass : email).focus();
            return;
        }

        enCours(true);

        var donnees = new FormData();
        donnees.append('email', email.value.trim());
        donnees.append('password', pass.value);

        fetch(<?php echo json_encode(base_url() . 'home/login_process'); ?>, {
            method: 'POST',
            body: donnees,
            credentials: 'same-origin'
        })
            .then(function (r) { return r.text(); })
            .then(function (texte) {
                var data;
                try { data = JSON.parse(texte); } catch (err) { data = null; }

                if (data && data.length && parseInt(data[0].id, 10) === 1) {
                    apresConnexion();
                    return;
                }

                enCours(false);
                afficherErreur((data && data[0] && data[0].desc)
                    ? data[0].desc
                    : <?php echo json_encode(aa_trad($aa_ci, 'verif_log',
                        'Identifiants incorrects. Veuillez réessayer.')); ?>);
                pass.focus();
                pass.select();
            })
            .catch(function () {
                enCours(false);
                afficherErreur(<?php echo json_encode(aa_trad($aa_ci, 'error_network',
                    'Une erreur est survenue. Veuillez réessayer.')); ?>);
            });
    });
})();
</script>
