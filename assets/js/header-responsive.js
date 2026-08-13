/* ==========================================================================
   Header responsive — comportement du menu mobile / tablette
   --------------------------------------------------------------------------
   Ne s'active qu'en dessous de 992px. Sur desktop, toggleNav()/closeNav()
   restent sans effet visible puisque le tiroir est masque par le CSS.

   Remplace les fonctions globales toggleNav()/closeNav() definies dans les
   vues (elles positionnaient "left" en inline) par une bascule de classe,
   et ajoute : voile sombre, blocage du scroll, fermeture par ESC / voile /
   clic sur un lien, sous-menus en accordeon.
   ========================================================================== */
(function () {
    'use strict';

    var BREAKPOINT = 992;
    var BACKDROP_ID = 'aaNavBackdrop';

    function drawer() {
        return document.getElementById('sideNav');
    }

    function backdrop() {
        var el = document.getElementById(BACKDROP_ID);
        if (!el) {
            el = document.createElement('div');
            el.id = BACKDROP_ID;
            el.className = 'aa-nav-backdrop';
            el.addEventListener('click', closeNav);
            document.body.appendChild(el);
        }
        return el;
    }

    function isMobile() {
        return window.innerWidth < BREAKPOINT;
    }

    /* Remonte jusqu'au premier parent correspondant au selecteur. */
    function closestSel(node, selector) {
        while (node && node.nodeType === 1) {
            if (node.matches ? node.matches(selector)
                : (node.msMatchesSelector && node.msMatchesSelector(selector))) {
                return node;
            }
            node = node.parentNode;
        }
        return null;
    }

    function openNav() {
        var nav = drawer();
        if (!nav) return;
        nav.style.left = '';              // neutralise l'ancien style inline
        nav.classList.add('aa-open');
        backdrop().classList.add('aa-open');
        document.body.classList.add('aa-nav-lock');
        nav.setAttribute('aria-hidden', 'false');
    }

    function closeNav() {
        var nav = drawer();
        if (!nav) return;
        nav.style.left = '';
        nav.classList.remove('aa-open');
        backdrop().classList.remove('aa-open');
        document.body.classList.remove('aa-nav-lock');
        nav.setAttribute('aria-hidden', 'true');
    }

    function toggleNav() {
        var nav = drawer();
        if (!nav) return;
        if (nav.classList.contains('aa-open')) {
            closeNav();
        } else {
            openNav();
        }
    }

    /* Les vues appellent toggleNav()/closeNav() via onclick : on ecrase les
       versions definies plus haut dans la page. */
    window.toggleNav = toggleNav;
    window.closeNav = closeNav;
    window.openNav = openNav;

    /* Sous-menus en accordeon : le :hover n'existe pas au doigt.
       Capture = true pour passer avant le dropdown de Bootstrap. */
    document.addEventListener('click', function (e) {
        var nav = drawer();
        if (!nav || !isMobile() || !nav.classList.contains('aa-open')) return;

        var toggle = closestSel(e.target, '.dropdown-toggle');
        if (!toggle || !nav.contains(toggle)) return;

        var item = closestSel(toggle, 'li');
        if (!item || !item.querySelector('.dropdown-menu')) return;

        e.preventDefault();
        e.stopPropagation();
        item.classList.toggle('aa-open');
    }, true);

    /* Un clic sur un vrai lien ferme le tiroir. */
    document.addEventListener('click', function (e) {
        var nav = drawer();
        if (!nav || !isMobile() || !nav.classList.contains('aa-open')) return;

        var link = closestSel(e.target, 'a');
        if (!link || !nav.contains(link)) return;
        if (closestSel(link, '.dropdown-toggle')) return;

        var href = link.getAttribute('href') || '';
        if (href && href.charAt(0) !== '#' && href.indexOf('javascript:') !== 0) {
            closeNav();
        }
    });

    /* ESC ferme le tiroir. */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' || e.keyCode === 27) closeNav();
    });

    /* Passage en desktop : on remet tout a plat. */
    window.addEventListener('resize', function () {
        if (!isMobile()) closeNav();
    });

    /* Etat initial propre (certaines vues laissent un left inline). */
    document.addEventListener('DOMContentLoaded', function () {
        var nav = drawer();
        if (nav) {
            nav.style.left = '';
            nav.setAttribute('aria-hidden', 'true');
        }
    });
})();
