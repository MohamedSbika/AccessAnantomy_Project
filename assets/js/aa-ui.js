/* ==========================================================================
   AccessAnatomy — comportements de l'interface unifiée (aa-ui)
   ==========================================================================

   Tiroir de navigation, menus déroulants, accordéons, mode lecture.

   Sans dépendance : ni jQuery ni Bootstrap JS. L'application charge les deux
   sur la plupart des pages, mais pas sur toutes (v1_figures_only,
   video_upload, cursHTML) — et l'en-tête doit y fonctionner aussi. C'est la
   raison pour laquelle les menus n'utilisent pas `data-toggle="dropdown"`.

   Compatibilité : toggleNav() et closeNav() restent exposés en global,
   plusieurs vues les appellent encore en onclick.
   ========================================================================== */

(function () {
    'use strict';

    var CLE_LECTURE = 'aa-mode-lecture';

    function $(sel, ctx) { return (ctx || document).querySelector(sel); }
    function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

    /* ----------------------------------------------------------------------
       Tiroir
       ---------------------------------------------------------------------- */

    function tiroir() { return $('#aaSidebar') || $('#sideNav'); }
    function voile()  { return $('#aaVoile'); }

    function ouvrirTiroir() {
        var t = tiroir();
        if (!t) return;
        fermerMenus();
        t.classList.add('est-ouvert');
        if (voile()) voile().classList.add('est-ouvert');
        document.body.classList.add('aa-drawer-ouvert');
        t.setAttribute('aria-hidden', 'false');

        var burger = $('#aaBurger');
        if (burger) burger.setAttribute('aria-expanded', 'true');

        // Le focus part dans le tiroir, sinon la navigation clavier reste
        // bloquée derrière le voile.
        var premier = t.querySelector('a, button');
        if (premier) premier.focus();
    }

    function fermerTiroir() {
        var t = tiroir();
        if (!t) return;
        t.classList.remove('est-ouvert');
        if (voile()) voile().classList.remove('est-ouvert');
        document.body.classList.remove('aa-drawer-ouvert');
        t.setAttribute('aria-hidden', 'true');

        var burger = $('#aaBurger');
        if (burger) burger.setAttribute('aria-expanded', 'false');
    }

    function basculerTiroir() {
        var t = tiroir();
        if (!t) return;
        if (t.classList.contains('est-ouvert')) fermerTiroir();
        else ouvrirTiroir();
    }

    /* ----------------------------------------------------------------------
       Menus déroulants de l'en-tête
       ---------------------------------------------------------------------- */

    function fermerMenus(sauf) {
        $$('[data-aa="menu"].est-ouvert').forEach(function (m) {
            if (m === sauf) return;
            m.classList.remove('est-ouvert');
            var d = m.querySelector('.aa-declencheur, .aa-nav__link');
            if (d) d.setAttribute('aria-expanded', 'false');
        });
    }

    function basculerMenu(menu) {
        var ouvert = menu.classList.contains('est-ouvert');
        fermerMenus(menu);
        menu.classList.toggle('est-ouvert', !ouvert);

        var d = menu.querySelector('.aa-declencheur, .aa-nav__link');
        if (d) d.setAttribute('aria-expanded', String(!ouvert));
    }

    /* ----------------------------------------------------------------------
       Connexion
       Une seule modale pour toute l'application : components/aa_modal_login.php,
       qui expose openModalLogin(). Il y en avait deux — celle de footer.php et
       celle de v1_modal_login.php —, d'où le double test qui vivait ici.

       Ne PAS tester window.openModal : v1_listCalqueFigure.php définit une
       fonction de ce nom pour sa modale de test de calque, sans rapport avec
       l'authentification.

       Si la page n'embarque pas le composant, le lien suit son href, qui mène
       à l'accueil avec ?connexion=1 — la modale s'y ouvre d'elle-même.
       ---------------------------------------------------------------------- */

    function ouvrirConnexion(e) {
        if (typeof window.openModalLogin !== 'function') { return; }

        e.preventDefault();
        fermerTiroir();

        // Remet la cible « ouvrir tel livre après connexion » à zéro : un clic
        // précédent sur un livre l'aurait laissée renseignée.
        if (typeof window.redirectLogLivr === 'function') { window.redirectLogLivr(0); }

        window.openModalLogin();
    }

    /* ----------------------------------------------------------------------
       Visionneuse d'image

       Sur téléphone et tablette, une couverture d'ouvrage occupait le premier
       écran entier avant le moindre texte. Elle y est remplacée par un bouton
       qui l'ouvre en plein écran :

           <button data-aa="image" data-image="…">Voir la couverture</button>

       data-image accepte une URL comme une data-URI — les couvertures sont
       stockées en base64 en base.
       ---------------------------------------------------------------------- */

    function visionneuse() {
        var v = $('#aaVisionneuse');
        if (v) { return v; }

        v = document.createElement('div');
        v.id = 'aaVisionneuse';
        v.className = 'aa-visionneuse';
        v.setAttribute('role', 'dialog');
        v.setAttribute('aria-modal', 'true');
        v.innerHTML =
            '<button type="button" class="aa-visionneuse__fermer" aria-label="Fermer">&times;</button>' +
            '<img alt="">';
        document.body.appendChild(v);

        v.addEventListener('click', function (e) {
            // Clic sur le fond ou sur la croix : l'image elle-même ne ferme pas,
            // on peut vouloir la parcourir au doigt sans la refermer par erreur.
            if (e.target === v || e.target.closest('.aa-visionneuse__fermer')) { fermerImage(); }
        });

        return v;
    }

    function ouvrirImage(src, texte) {
        if (!src) { return; }
        var v = visionneuse();
        var img = v.querySelector('img');
        img.src = src;
        img.alt = texte || '';
        v.classList.add('est-ouverte');
        document.body.classList.add('aa-fige');
    }

    function fermerImage() {
        var v = $('#aaVisionneuse');
        if (!v) { return; }
        v.classList.remove('est-ouverte');
        document.body.classList.remove('aa-fige');

        // On vide la source : une couverture en base64 pèse plusieurs centaines
        // de kilo-octets, inutile de la garder décodée en mémoire.
        v.querySelector('img').removeAttribute('src');
    }

    /* ----------------------------------------------------------------------
       Mode lecture (bascule d'affichage locale)
       ---------------------------------------------------------------------- */

    function activerLecture() {
        document.body.classList.add('aa-mode-lecture');
        try { localStorage.setItem(CLE_LECTURE, '1'); } catch (e) { /* navigation privée */ }
    }

    function quitterLecture() {
        document.body.classList.remove('aa-mode-lecture');
        try { localStorage.removeItem(CLE_LECTURE); } catch (e) { /* navigation privée */ }
    }

    function basculerLecture() {
        if (document.body.classList.contains('aa-mode-lecture')) quitterLecture();
        else activerLecture();
    }

    /* Restaure le mode lecture d'une page à l'autre : un utilisateur qui lit
       un chapitre enchaîne sur le suivant sans vouloir le réactiver. */
    function restaurerLecture() {
        var actif = false;
        try { actif = localStorage.getItem(CLE_LECTURE) === '1'; } catch (e) { /* ignore */ }
        if (actif && $('.aa-lecture-zone')) document.body.classList.add('aa-mode-lecture');
    }

    /* ----------------------------------------------------------------------
       Câblage
       ---------------------------------------------------------------------- */

    function init() {
        restaurerLecture();

        var burger = $('#aaBurger');
        if (burger) burger.addEventListener('click', basculerTiroir);

        var v = voile();
        if (v) v.addEventListener('click', fermerTiroir);

        // Ouverture au survol sur desktop uniquement : au tactile, un survol
        // simulé ouvrirait le menu au premier appui et avalerait le clic.
        var pointeurFin = window.matchMedia('(min-width: 992px) and (hover: hover)');
        $$('[data-aa="menu"]').forEach(function (menu) {
            menu.addEventListener('mouseenter', function () {
                if (pointeurFin.matches) { fermerMenus(menu); menu.classList.add('est-ouvert'); }
            });
            menu.addEventListener('mouseleave', function () {
                if (pointeurFin.matches) menu.classList.remove('est-ouvert');
            });
        });

        // Délégation : couvre aussi les boutons rendus après coup.
        document.addEventListener('click', function (e) {
            if (!e.target.closest) return;

            var menu = e.target.closest('[data-aa="menu"]');
            var declencheur = e.target.closest('.aa-declencheur, .aa-nav__item[data-aa="menu"] > .aa-nav__link');

            if (menu && declencheur) {
                e.preventDefault();
                basculerMenu(menu);
                return;
            }

            // Clic hors d'un menu ouvert : on referme.
            if (!menu) fermerMenus();

            var cible = e.target.closest('[data-aa]');
            if (!cible) return;

            switch (cible.getAttribute('data-aa')) {
                case 'fermer-tiroir':
                    fermerTiroir();
                    break;
                case 'ouvrir-tiroir':
                    ouvrirTiroir();
                    break;
                case 'accordeon':
                    e.preventDefault();
                    var acc = cible.parentNode;
                    var ouvert = acc.classList.toggle('est-ouvert');
                    cible.setAttribute('aria-expanded', String(ouvert));
                    break;
                case 'lecture':
                    e.preventDefault();
                    basculerLecture();
                    break;
                case 'quitter-lecture':
                    e.preventDefault();
                    quitterLecture();
                    break;
                case 'connexion':
                    ouvrirConnexion(e);
                    break;
                case 'image':
                    e.preventDefault();
                    ouvrirImage(
                        cible.getAttribute('data-image') || cible.getAttribute('href'),
                        cible.getAttribute('data-image-alt')
                    );
                    break;
            }
        });

        // Échap ferme, dans l'ordre : l'image, un menu, le tiroir, le mode lecture.
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            var t = tiroir();
            var v = $('#aaVisionneuse');
            if (v && v.classList.contains('est-ouverte')) fermerImage();
            else if ($('[data-aa="menu"].est-ouvert')) fermerMenus();
            else if (t && t.classList.contains('est-ouvert')) fermerTiroir();
            else if (document.body.classList.contains('aa-mode-lecture')) quitterLecture();
        });

        // La couverture redevient visible en desktop : la visionneuse ouverte
        // n'aurait plus lieu d'être.
        var mqImage = window.matchMedia('(min-width: 992px)');
        var surLargeur = function (ev) { if (ev.matches) fermerImage(); };
        if (mqImage.addEventListener) mqImage.addEventListener('change', surLargeur);
        else if (mqImage.addListener) mqImage.addListener(surLargeur);

        // Repasser en desktop doit refermer le tiroir, sinon il reste ouvert
        // par-dessus la mise en page à colonnes.
        var mq = window.matchMedia('(min-width: 992px)');
        var onChange = function (ev) { if (ev.matches) fermerTiroir(); };
        if (mq.addEventListener) mq.addEventListener('change', onChange);
        else if (mq.addListener) mq.addListener(onChange);   // Safari < 14
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /* ----------------------------------------------------------------------
       API globale
       toggleNav / closeNav sont conservés : des vues les appellent encore en
       onclick. Les retirer casserait ces pages.
       ---------------------------------------------------------------------- */

    window.toggleNav = basculerTiroir;
    window.closeNav  = fermerTiroir;
    window.openNav   = ouvrirTiroir;

    window.AA = {
        ouvrirTiroir:    ouvrirTiroir,
        fermerTiroir:    fermerTiroir,
        basculerTiroir:  basculerTiroir,
        activerLecture:  activerLecture,
        quitterLecture:  quitterLecture,
        basculerLecture: basculerLecture
    };
})();
