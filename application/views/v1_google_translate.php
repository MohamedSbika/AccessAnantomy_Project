<!-- ============================================= -->
<!-- Google Translate Widget                        -->
<!-- Inclure UNE SEULE FOIS par page (avant </body>)-->
<!-- ============================================= -->

<style>
	/* ── Barre fixe déplaçable ── */
	#gt-fixed-bar {
		position: fixed;
		top: 0;
		left: 0;
		z-index: 99999;
		background: linear-gradient(135deg, #120E47 0%, #1a3a5c 100%);
		padding: 6px 18px;
		border-radius: 0 0 12px 0;
		box-shadow: 0 2px 12px rgba(0,0,0,0.25);
		display: none;
		align-items: center;
		gap: 10px;
		cursor: grab;
		user-select: none;
		-webkit-user-select: none;
		transition: box-shadow 0.2s ease, opacity 0.3s ease;
	}
	#gt-fixed-bar:active {
		cursor: grabbing;
		box-shadow: 0 4px 20px rgba(0,0,0,0.4);
	}
	#gt-fixed-bar .gt-label {
		color: rgba(255,255,255,0.85);
		font-size: 12px;
		font-family: 'Manrope', 'Roboto', sans-serif;
		font-weight: 500;
		white-space: nowrap;
		pointer-events: none;
	}

	/* ── Style Premium du sélecteur (dropdown) ── */
	#gt-fixed-bar .goog-te-gadget {
		color: transparent !important;
		font-size: 0 !important;
	}
	#gt-fixed-bar .goog-te-gadget select {
		background-color: rgba(255, 255, 255, 0.12) !important;
		color: #fff !important;
		border: 1px solid rgba(255, 255, 255, 0.25) !important;
		padding: 5px 12px !important;
		border-radius: 20px !important;
		font-size: 12px !important;
		font-weight: 500 !important;
		font-family: 'Manrope', 'Roboto', sans-serif !important;
		cursor: pointer !important;
		outline: none !important;
		width: auto !important;
		max-width: 180px !important;
		appearance: auto;
		-webkit-appearance: menulist;
		transition: all 0.2s ease;
	}
	#gt-fixed-bar .goog-te-gadget select:hover,
	#gt-fixed-bar .goog-te-gadget select:focus {
		background-color: rgba(255, 255, 255, 0.22);
		border-color: rgba(255, 255, 255, 0.4);
	}
	#gt-fixed-bar .goog-te-gadget select option {
		background: #1a2a4a;
		color: #fff;
	}

	/* ── Cacher "Powered by Google" ── */
	#gt-fixed-bar .goog-te-gadget > span,
	#gt-fixed-bar .goog-te-gadget > div > span,
	#gt-fixed-bar .goog-logo-link,
	#gt-fixed-bar .goog-te-gadget-icon {
		display: none !important;
	}
	#gt-fixed-bar .goog-te-menu-value { margin: 0 !important; }

	/* ── Cacher le widget quand un modal est ouvert ── */
	#gt-fixed-bar.gt-hidden {
		opacity: 0 !important;
		pointer-events: none !important;
		transition: opacity 0.2s ease !important;
	}

	/* ── Bouton fermer ── */
	#gt-fixed-bar .gt-close-btn {
		color: rgba(255,255,255,0.6);
		font-size: 14px;
		cursor: pointer;
		padding: 2px 6px;
		border-radius: 50%;
		transition: all 0.2s ease;
		pointer-events: auto;
		line-height: 1;
	}
	#gt-fixed-bar .gt-close-btn:hover {
		color: #fff;
		background-color: rgba(255,255,255,0.15);
	}
</style>

<!-- Barre Google Translate (cachée par défaut, affichée via "Autre") -->
<div id="gt-fixed-bar">
	<span class="gt-label">🌐 Traduire</span>
	<div id="google_translate_element"></div>
	<span class="gt-close-btn" onclick="hideGtBar()" title="Fermer">✕</span>
</div>

<!-- Script Google Translate -->
<script type="text/javascript">
	function googleTranslateElementInit() {
		new google.translate.TranslateElement({
			pageLanguage: 'fr',
			autoDisplay: false
		}, 'google_translate_element');
	}

	// Fonctions globales utilisées par le dropdown de langue
	function toggleGtBar() {
		var bar = document.getElementById('gt-fixed-bar');
		if (!bar) return;
		if (bar.style.display === 'flex') {
			bar.style.display = 'none';
			localStorage.setItem('gt-bar-visible', 'false');
		} else {
			bar.style.display = 'flex';
			localStorage.setItem('gt-bar-visible', 'true');
		}
	}

	function hideGtBar() {
		var bar = document.getElementById('gt-fixed-bar');
		if (bar) bar.style.display = 'none';
		localStorage.setItem('gt-bar-visible', 'false');
	}

	function resetTranslate() {
		// 1. Supprimer le cookie Google Translate
		var domains = [window.location.hostname, "." + window.location.hostname];
		var paths = ["/", "/public_html"]; // Ajouter les chemins courants du projet
		
		domains.forEach(function(domain) {
			paths.forEach(function(path) {
				document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + path + "; domain=" + domain + ";";
				document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + path + ";";
			});
		});

		// 2. Masquer la barre Google Translate
		hideGtBar();
	}

	// Restaurer la visibilité sauvegardée
	(function() {
		var visible = localStorage.getItem('gt-bar-visible');
		if (visible === 'true') {
			var bar = document.getElementById('gt-fixed-bar');
			if (bar) bar.style.display = 'flex';
		}
	})();
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- Script AGRESSIF pour masquer le bandeau Google -->
<script>
(function() {
	// Injecter du CSS dynamiquement en dernier = priorité maximale
	function injectBannerKillerCSS() {
		var old = document.getElementById('gt-banner-killer');
		if (old) old.remove();
		var s = document.createElement('style');
		s.id = 'gt-banner-killer';
		s.textContent =
			'.goog-te-banner-frame, .goog-te-banner-frame.skiptranslate,' +
			'iframe.goog-te-banner-frame, body > iframe.skiptranslate {' +
			'  display: none !important; height: 0 !important;' +
			'  width: 0 !important; visibility: hidden !important;' +
			'  position: absolute !important; top: -9999px !important;' +
			'}' +
			'body > .skiptranslate:first-child {' +
			'  display: none !important; height: 0 !important;' +
			'}' +
			'body { top: 0px !important; }';
		document.head.appendChild(s);
	}

	function hideGoogleBanner() {
		// 1. Re-injecter notre CSS en fin de head (priorité max)
		injectBannerKillerCSS();

		// 2. Cacher les iframes Google Translate
		var allIframes = document.querySelectorAll('iframe');
		for (var i = 0; i < allIframes.length; i++) {
			try {
				var cls = allIframes[i].className || '';
				if (cls.indexOf('goog-te-banner') !== -1 || cls.indexOf('skiptranslate') !== -1) {
					allIframes[i].style.setProperty('display', 'none', 'important');
					allIframes[i].style.setProperty('height', '0', 'important');
					allIframes[i].style.setProperty('visibility', 'hidden', 'important');
				}
			} catch(e) {}
		}

		// 3. Cacher le div skiptranslate en haut du body (pas notre widget)
		var topDivs = document.querySelectorAll('body > .skiptranslate');
		for (var j = 0; j < topDivs.length; j++) {
			if (!topDivs[j].querySelector('#google_translate_element')) {
				topDivs[j].style.setProperty('display', 'none', 'important');
				topDivs[j].style.setProperty('height', '0', 'important');
			}
		}

		// 4. Forcer body.top = 0 avec !important
		if (document.body) {
			document.body.style.setProperty('top', '0px', 'important');
		}
	}

	// Exécuter immédiatement et régulièrement
	hideGoogleBanner();
	setInterval(hideGoogleBanner, 500);

	document.addEventListener('DOMContentLoaded', hideGoogleBanner);
	window.addEventListener('load', function() {
		hideGoogleBanner();
		setTimeout(hideGoogleBanner, 500);
		setTimeout(hideGoogleBanner, 1500);
		setTimeout(hideGoogleBanner, 3000);
	});
})();

// ── Drag & Drop pour la barre Google Translate ──
(function() {
	function initDrag() {
		var bar = document.getElementById('gt-fixed-bar');
		if (!bar) return;

		var isDragging = false;
		var offsetX = 0, offsetY = 0;

		// Restaurer la position sauvegardée
		var savedPos = localStorage.getItem('gt-bar-position');
		if (savedPos) {
			try {
				var pos = JSON.parse(savedPos);
				bar.style.left = pos.left + 'px';
				bar.style.top = pos.top + 'px';
				bar.style.right = 'auto';
				updateBorderRadius(bar, pos.left, pos.top);
			} catch(e) {}
		}

		bar.addEventListener('mousedown', function(e) {
			// Ne pas déclencher le drag si on clique sur le select
			if (e.target.tagName === 'SELECT' || e.target.tagName === 'OPTION') return;
			isDragging = true;
			offsetX = e.clientX - bar.getBoundingClientRect().left;
			offsetY = e.clientY - bar.getBoundingClientRect().top;
			bar.style.transition = 'none';
			e.preventDefault();
		});

		document.addEventListener('mousemove', function(e) {
			if (!isDragging) return;
			var newLeft = e.clientX - offsetX;
			var newTop = e.clientY - offsetY;

			// Garder dans les limites de l'écran
			newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - bar.offsetWidth));
			newTop = Math.max(0, Math.min(newTop, window.innerHeight - bar.offsetHeight));

			bar.style.left = newLeft + 'px';
			bar.style.top = newTop + 'px';
			bar.style.right = 'auto';
			updateBorderRadius(bar, newLeft, newTop);
		});

		document.addEventListener('mouseup', function() {
			if (!isDragging) return;
			isDragging = false;
			bar.style.transition = 'box-shadow 0.2s ease';

			// Sauvegarder la position
			localStorage.setItem('gt-bar-position', JSON.stringify({
				left: parseInt(bar.style.left),
				top: parseInt(bar.style.top)
			}));
		});

		// Support tactile (mobile)
		bar.addEventListener('touchstart', function(e) {
			if (e.target.tagName === 'SELECT') return;
			isDragging = true;
			var touch = e.touches[0];
			offsetX = touch.clientX - bar.getBoundingClientRect().left;
			offsetY = touch.clientY - bar.getBoundingClientRect().top;
			bar.style.transition = 'none';
		}, { passive: true });

		document.addEventListener('touchmove', function(e) {
			if (!isDragging) return;
			var touch = e.touches[0];
			var newLeft = touch.clientX - offsetX;
			var newTop = touch.clientY - offsetY;
			newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - bar.offsetWidth));
			newTop = Math.max(0, Math.min(newTop, window.innerHeight - bar.offsetHeight));
			bar.style.left = newLeft + 'px';
			bar.style.top = newTop + 'px';
			bar.style.right = 'auto';
			updateBorderRadius(bar, newLeft, newTop);
		}, { passive: true });

		document.addEventListener('touchend', function() {
			if (!isDragging) return;
			isDragging = false;
			bar.style.transition = 'box-shadow 0.2s ease';
			localStorage.setItem('gt-bar-position', JSON.stringify({
				left: parseInt(bar.style.left),
				top: parseInt(bar.style.top)
			}));
		});
	}

	// Adapter le border-radius selon la position
	function updateBorderRadius(bar, left, top) {
		if (top <= 5 && left <= 5) {
			bar.style.borderRadius = '0 0 12px 0';        // coin haut-gauche
		} else if (top <= 5 && left + bar.offsetWidth >= window.innerWidth - 5) {
			bar.style.borderRadius = '0 0 0 12px';        // coin haut-droite
		} else {
			bar.style.borderRadius = '12px';               // flottant
		}
	}

	if (document.readyState === 'complete' || document.readyState === 'interactive') {
		initDrag();
	} else {
		document.addEventListener('DOMContentLoaded', initDrag);
	}
})();

// ── Auto-masquer le widget quand un modal est ouvert ──
(function() {
	function checkModals() {
		var bar = document.getElementById('gt-fixed-bar');
		if (!bar) return;

		var modals = document.querySelectorAll('.modal, [id*="modal"], [id*="Modal"], .swal2-container');
		var anyVisible = false;
		for (var i = 0; i < modals.length; i++) {
			var el = modals[i];
			if (el.id === 'gt-fixed-bar' || el.id === 'google_translate_element') continue;
			var style = window.getComputedStyle(el);
			if (style.display !== 'none' && style.visibility !== 'hidden' && el.offsetHeight > 0) {
				anyVisible = true;
				break;
			}
		}

		if (anyVisible) {
			bar.classList.add('gt-hidden');
		} else {
			bar.classList.remove('gt-hidden');
		}
	}

	setInterval(checkModals, 300);
})();
</script>
