/* ==========================================================================
   Page cours (livreCours) — correction du défilement automatique au chargement
   --------------------------------------------------------------------------
   v1_bloc_figures.php centre la miniature active au chargement avec
   scrollIntoView({block:'nearest', inline:'center'}). L'intention est
   horizontale (centrer la vignette dans sa bande), mais scrollIntoView fait
   aussi défiler la PAGE : sur desktop la bande est déjà visible et le
   mouvement est nul, alors qu'en mobile — colonnes empilées, bande sous la
   ligne de flottaison — la page s'ouvre plusieurs centaines de pixels plus
   bas, en plein milieu du cours, en-tête et raccourcis hors écran.

   On ramène donc la page en haut pendant la seconde qui suit le chargement,
   et on s'arrête AU PREMIER geste de l'utilisateur : s'il fait défiler ou
   touche l'écran, il reste maître du défilement.

   Inerte sur desktop (>= 768px) et si l'URL porte une ancre.
   ========================================================================== */
(function () {
    'use strict';

    var BREAKPOINT = 768;
    var DUREE = 1200;   // ms : couvre le scroll "smooth" déclenché au chargement

    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth >= BREAKPOINT) return;
        if (window.location.hash) return;

        var rendu = false;   // l'utilisateur a pris la main
        function relacher() { rendu = true; }

        ['touchstart', 'wheel', 'pointerdown', 'keydown'].forEach(function (type) {
            window.addEventListener(type, relacher, { passive: true, once: true });
        });

        var fin = Date.now() + DUREE;
        (function maintenir() {
            if (rendu) return;
            if (window.scrollY !== 0) window.scrollTo(0, 0);
            if (Date.now() < fin) window.requestAnimationFrame(maintenir);
        })();
    });
})();
