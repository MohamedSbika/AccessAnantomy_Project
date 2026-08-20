/* ==========================================================================
   Pagination DataTables — comportement de la bande défilante
   --------------------------------------------------------------------------
   Complément de pagination-responsive.css, qui transforme la rangée de
   numéros en une bande bornée à la largeur disponible et défilante
   horizontalement.

   Deux choses manquent alors, et ce script les apporte :

     1. Recentrer le numero courant. Avec `pageLength: 1` (QROC) ou `2` (QCM),
        le pagineur EST la navigation entre les questions : arriver a la
        question 47 sans que le bouton 47 soit visible rend la suite
        introuvable. Apres chaque redessin, la bande est repositionnee sur le
        bouton actif.

     2. Signaler qu'il reste des numeros hors du cadre. Le CSS pose un dégradé
        sur le bord concerné ; ce script maintient les classes qui le
        declenchent (aa-pager-more-start / aa-pager-more-end).

   Aucune dependance : ni jQuery, ni l'API DataTables. Le pagineur est
   entierement reconstruit a chaque redessin (le renderer fait un `.empty()`
   suivi d'un `.append()`), donc un MutationObserver pose sur le document
   couvre tous les chemins — chargement Ajax, changement de page, filtre —
   sans avoir a se brancher sur les evenements de DataTables ni a toucher aux
   vues.

   Charge en `defer` : le DOM est pret, rien ne bloque le rendu.
   ========================================================================== */
(function () {
    'use strict';

    var PAGER = '.dataTables_paginate';
    var STRIP = ':scope > span, :scope > ul.pagination';
    var CURRENT = '.current, .active';

    /* Le redessin d'un pagineur est une rafale de mutations : on n'agit qu'une
       fois, a la frame suivante. */
    var pending = false;

    function strips(pager) {
        /* :scope n'est pas supporte partout sur querySelectorAll dans les
           vieux moteurs ; le repli parcourt les enfants directs. */
        try {
            return pager.querySelectorAll(STRIP);
        } catch (e) {
            var found = [];
            for (var i = 0; i < pager.children.length; i++) {
                var child = pager.children[i];
                if (child.tagName === 'SPAN' ||
                    (child.tagName === 'UL' && child.classList.contains('pagination'))) {
                    found.push(child);
                }
            }
            return found;
        }
    }

    /* Position de defilement qui place le bouton actif au milieu de la bande.
       offsetLeft est relatif au premier ancetre positionne : la bande ne l'est
       pas, on passe donc par les rectangles, seuls fiables ici (et corrects en
       RTL, ou scrollLeft peut etre negatif). */
    function centre(strip) {
        var current = strip.querySelector(CURRENT);
        if (!current) return;

        var stripBox = strip.getBoundingClientRect();
        var itemBox = current.getBoundingClientRect();
        var delta = (itemBox.left + itemBox.width / 2) - (stripBox.left + stripBox.width / 2);

        /* Deja centre a quelques pixels pres : ne rien faire, sous peine de
           voler le geste de defilement en cours a l'utilisateur. */
        if (Math.abs(delta) < 2) return;

        /* Affectation directe, sans defilement anime : le recentrage suit un
           changement de page, il doit etre deja fait quand la question
           s'affiche. `scroll-behavior: smooth` est volontairement absent de la
           feuille pour la meme raison. */
        strip.scrollLeft += delta;
    }

    /* Dégradés de bord : uniquement du cote ou il reste quelque chose. */
    function markOverflow(pager, strip) {
        var overflows = strip.scrollWidth - strip.clientWidth > 1;
        /* En RTL, scrollLeft est negatif ou decroissant selon le moteur : la
           valeur absolue donne la distance parcourue dans les deux cas. */
        var scrolled = Math.abs(strip.scrollLeft);
        var maxScroll = strip.scrollWidth - strip.clientWidth;

        pager.classList.toggle('aa-pager-more-start', overflows && scrolled > 2);
        pager.classList.toggle('aa-pager-more-end', overflows && scrolled < maxScroll - 2);
    }

    function refresh(pager) {
        var list = strips(pager);
        for (var i = 0; i < list.length; i++) {
            var strip = list[i];
            centre(strip);
            markOverflow(pager, strip);

            if (!strip.dataset.aaPagerBound) {
                strip.dataset.aaPagerBound = '1';
                strip.addEventListener('scroll', (function (p, s) {
                    return function () { markOverflow(p, s); };
                })(pager, strip), { passive: true });
            }
        }
    }

    function refreshAll() {
        pending = false;
        var pagers = document.querySelectorAll(PAGER);
        for (var i = 0; i < pagers.length; i++) {
            refresh(pagers[i]);
        }
    }

    function schedule() {
        if (pending) return;
        pending = true;
        /* Appel via window : detache de son objet, requestAnimationFrame leve
           une « Illegal invocation » dans les moteurs WebKit. */
        if (window.requestAnimationFrame) {
            window.requestAnimationFrame(refreshAll);
        } else {
            window.setTimeout(refreshAll, 16);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        schedule();

        if (window.MutationObserver) {
            new MutationObserver(function (records) {
                for (var i = 0; i < records.length; i++) {
                    var target = records[i].target;
                    if (target.nodeType === 1 && target.closest && target.closest(PAGER)) {
                        schedule();
                        return;
                    }
                }
            }).observe(document.body, { childList: true, subtree: true });
        }

        /* Rotation de l'ecran / redimensionnement : la largeur disponible
           change, le centrage et les degrades avec elle. */
        window.addEventListener('resize', schedule);
    });
})();
