/* ==========================================================================
   Bloc raccourcis — comportement mobile du panneau des chapitres
   --------------------------------------------------------------------------
   Sous 768px, #listChapTooltip est affichee en feuille ancree en bas
   (voir racourci-responsive.css). Ce script lui ajoute ce qui manque pour
   qu'elle se comporte comme une vraie feuille : voile sombre, blocage du
   defilement de la page, croix de fermeture, fermeture par ESC.

   Le script ne modifie AUCUNE fonction des vues : il observe simplement
   l'attribut style de la feuille, que selectUniqueCarreau() et les
   fermetures existantes basculent entre display:block et display:none.
   C'est ce qui permet de couvrir tous les chemins d'ouverture / fermeture
   sans les reecrire.

   Sur desktop (>= 768px) le script reste inerte.
   ========================================================================== */
(function () {
    'use strict';

    var BREAKPOINT = 768;
    var SHEET_ID = 'listChapTooltip';
    var BACKDROP_ID = 'aaSheetBackdrop';

    function sheet() {
        return document.getElementById(SHEET_ID);
    }

    function isMobile() {
        return window.innerWidth < BREAKPOINT;
    }

    function isVisible(el) {
        return !!el && el.style.display !== 'none' && el.style.display !== '';
    }

    function backdrop() {
        var el = document.getElementById(BACKDROP_ID);
        if (!el) {
            el = document.createElement('div');
            el.id = BACKDROP_ID;
            el.className = 'aa-sheet-backdrop';
            el.addEventListener('click', hideSheet);
            document.body.appendChild(el);
        }
        return el;
    }

    /* Fermeture : on repose display:none, l'observateur fait le reste. */
    function hideSheet() {
        var el = sheet();
        if (el) el.style.display = 'none';
    }

    /* Croix de fermeture, posee dans l'en-tete (qui est sticky : elle reste
       visible quand la liste defile). Ajoutee une seule fois. */
    function ensureCloseButton() {
        var el = sheet();
        if (!el || el.querySelector('.aa-sheet-close')) return;

        var host = el.querySelector('.chapter-header') || el;
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'aa-sheet-close';
        btn.setAttribute('aria-label', 'Fermer');
        btn.innerHTML = '&times;';
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            hideSheet();
        });
        host.appendChild(btn);
    }

    function syncState() {
        var el = sheet();
        if (!el) return;

        var open = isMobile() && isVisible(el);
        backdrop().classList.toggle('aa-open', open);
        document.body.classList.toggle('aa-sheet-lock', open);

        if (open) {
            ensureCloseButton();
            el.scrollTop = 0;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var el = sheet();
        if (!el) return;

        ensureCloseButton();

        /* L'ouverture se fait par un style inline pose en JS par les vues :
           observer l'attribut style est le seul point commun a tous les
           chemins (tuile cliquee, clic exterieur, choix d'un chapitre). */
        if (window.MutationObserver) {
            new MutationObserver(syncState).observe(el, {
                attributes: true,
                attributeFilter: ['style']
            });
        }

        document.addEventListener('keydown', function (e) {
            if ((e.key === 'Escape' || e.keyCode === 27) && isVisible(el)) {
                hideSheet();
            }
        });

        /* Retour en desktop : on ne laisse ni voile ni scroll bloque. */
        window.addEventListener('resize', syncState);

        syncState();
    });
})();
