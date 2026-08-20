<?php if(strlen($this->session->userdata('passTok'))==200) { ?>
<div style="display: flex; flex-direction: column; background-color: white;">
	<style>
		.zoom {
			width: 320px;
			height: 240px;
		}
		.image {
			width: 100%;
			height: 100%;
		}
		.image img {
			/* La transition s'applique à la fois sur la largeur et la hauteur, avec une durée d'une seconde. */
			-webkit-transition: all 1s ease; /* Safari et Chrome */
			-moz-transition: all 1s ease; /* Firefox */
			-ms-transition: all 1s ease; /* Internet Explorer 9 */
			-o-transition: all 1s ease; /* Opera */
			transition: all 1s ease;
		}
		.image:hover img {
			/* L'image est grossie de 25% */
			-webkit-transform:scale(1.25); /* Safari et Chrome */
			-moz-transform:scale(1.25); /* Firefox */
			-ms-transform:scale(1.25); /* Internet Explorer 9 */
			-o-transform:scale(1.25); /* Opera */
			transform:scale(1.25);
		}
		.zoom {
			display:inline-block;
			position: relative;
			clear: both;
			margin: 15px;

		}

		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block;
			width:33px;
			height:33px;
			position:absolute;
			top:0;
			right:0;
			background:url(../images/icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection {
			background-color: transparent;
		}


		#ex2 img:hover {
			cursor: url(../images/grab.cur), default;
		}

		#ex2 img:active {
			cursor: url(../images/grabbed.cur), default;
		}

		.previous {
			background-color: #f1f1f1;
			color: black;
			float: left;
		}

		.next {
			background-color: #a9aaa8;
			color: white;
			float: right;
		}

		.round {
			border-radius: 50%;
		}

		.defil {
			text-decoration: none;
			display: inline-block;
			padding: 5px 15px;
			font-size: 30px;
			bottom: 20px;
			color: #d5122f;
			border: 0;
			background: none;
		}

		/* Style du slider */
		.slider-container {
			position: relative;
			width: 100%;
			max-width: 650px; /* Largeur maximale du slider */
			margin: auto;
			overflow: hidden; /* Cacher les images qui dépassent */
			max-height: 200px;
		}

		.slider {
			display: flex;
			transition: transform 0.5s ease; /* Animation de transition pour le slider */
		}

		.slider-image {
			width: 33.33%; /* Afficher 3 images à la fois */
			object-fit: cover;
			padding: 5px; /* Espacement entre les images */
		}

		/* Style des boutons next/prev */
		.prev , .next {
			position: absolute;
			top: 30%;
			transform: translateY(-50%);
			background-color: rgba(0, 0, 0, 0.5);
			color: white;
			border: none;
			font-size: 18px;
			padding: 10px;
			cursor: pointer;
			z-index: 100;
		}

		.prev {
			left: 0;
		}

		.next {
			right: 0;
		}

		.column {
			float: left;
			width: 100%;
			padding: 10px;
			display: flex;
		}

		.column img {
			opacity: 0.8;
			cursor: pointer;
		}

		.column img:hover {
			opacity: 1;
		}


		#expandedImg {
			width: 100%;
			transition: transform 0.5s ease;
			cursor: zoom-in;
		}

		#imgtext {
			position: absolute;
			bottom: 15px;
			left: 5px;
			color: white;
			font-size: 20px;
		}

		/* No zoom effect here, we will handle it with JS */
		.zoomable {
			transition: transform 0.5s ease;
		}


		div.scroll-container {
			background-color: white;
			overflow-x: auto;
			overflow-y: hidden;
			white-space: nowrap;
			padding: 1px;
		}

		div.scroll-container img {
			padding: 1px;
		}

		/* Scroll container images — bande horizontale au-dessus de la figure (scroll latéral) */
		.scroll-container {
			display: flex;
			flex-direction: row;
			flex-wrap: nowrap;
			justify-content: flex-start;      /* le centrage est géré par les marges auto ci-dessous */
			gap: 14px;                        /* espacement entre les miniatures */
			overflow-x: auto;
			overflow-y: hidden;
			max-height: none;
			width: 100%;
			padding: 1px;
			background-color: white;
			scroll-behavior: smooth;
			scrollbar-width: thin;            /* Firefox */
			scrollbar-color: #bbb #f8f8f8;    /* Firefox */
		}

		/* Les miniatures gardent leur taille et débordent horizontalement (pas de rétrécissement) */
		.scroll-container .image-container {
			flex: 0 0 auto;
		}

		/* Centrage par marges auto : la bande est centrée quand elle tient,
		   mais quand il y a beaucoup d'images le défilement part bien de la 1re
		   (corrige le bug où la 1re miniature était coupée/inaccessible avec justify-content:center). */
		.scroll-container > .image-container:first-child { margin-left: auto; }
		.scroll-container > .image-container:last-child  { margin-right: auto; }

		/* WebKit (Chrome, Edge, Safari) — barre horizontale */
		.scroll-container::-webkit-scrollbar {
			height: 6px;
		}

		.scroll-container::-webkit-scrollbar-track {
			background: #f8f8f8;
		}

		.scroll-container::-webkit-scrollbar-thumb {
			background-color: #bbb;
			border-radius: 10px;
			border: 1px solid #f8f8f8;
		}

		.scroll-container::-webkit-scrollbar-thumb:hover {
			background-color: #888;
		}

		/* Miniatures */
		.scroll-container img {
			width: 60px;
			height: 60px;
			object-fit: contain;
			border: 1px solid #ccc;
		}

		/* Conteneur image principale */
		.container-fig {
			display: flex;
			justify-content: center;
			align-items: center;
			max-height: 50vw;
			background: #fff;
			padding: 10px;
			overflow: hidden;
		}

		/* ═════════ Viewer SVG interactif (porté de viewer.html) ═════════
		   Panneaux de légendes aux extrémités gauche/droite de la figure,
		   pleine hauteur, défilement interne uniquement si dépassement. */
		.fig-legend-panel {
			position: absolute;
			top: 0;
			bottom: 0;
			display: none;             /* affiché par le JS quand la figure a un SVG */
			flex-direction: column;
			max-width: 26%;
			overflow-y: auto;
			overflow-x: hidden;
			padding: 6px 8px;
			box-sizing: border-box;
			z-index: 5;
			scrollbar-width: thin;            /* Firefox */
			scrollbar-color: #bbb #f1f1f1;    /* Firefox */
		}
		.fig-legend-panel.left  {
			left: 0;
			direction: rtl;            /* place la barre de défilement à gauche */
			padding-left: 8px;
			padding-right: 0;
		}
		.fig-legend-panel.left > * { direction: ltr; }   /* le contenu reste lisible de gauche à droite */
		.fig-legend-panel.right {
			right: -5px;             /* compense le padding (5px) de la colonne pour coller au bord droit */
			padding-right: 0;
			padding-left: 8px;
		}
		.fig-legend-panel::-webkit-scrollbar { width: 6px; }
		.fig-legend-panel::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
		.fig-legend-panel::-webkit-scrollbar-thumb { background: #bbb; border-radius: 10px; }
		.fig-legend-panel::-webkit-scrollbar-thumb:hover { background: #888; }

		/* Bloc (sous-figure) : séparé par un filet gris */
		.fig-block { padding: 6px 2px 10px; }
		.fig-block + .fig-block {
			border-top: 1px solid #d1d5db;
			margin-top: 6px;
			padding-top: 12px;
		}

		/* Croix d'orientation (Crânial / Dorsal…) */
		.orient-cross { display: inline-block; margin: 0 0 6px 0; user-select: none; }
		.orient-cross svg { width: 100px; height: 47px; display: block; overflow: visible; }
		.orient-cross text { font-size: 2.0px; font-weight: 600; fill: #c2410c; font-family: inherit; }
		.orient-cross .axis { stroke: #c2410c; stroke-width: 0.32; fill: none; stroke-linecap: butt; }
		.orient-cross .arrow { fill: #c2410c; stroke: none; }

		/* Sous-titre de sous-figure (ex. "4-1- Stade de cinq semaines") */
		.fig-subtitle {
			font-weight: 600;
			font-size: 12px;
			color: #1e3a8a;
			margin: 4px 0 8px;
			line-height: 1.4;
		}

		/* Légendes numérotées cliquables */
		.legend-list { list-style: none; padding: 0; margin: 0; }
		.legend-item {
			display: flex;
			align-items: flex-start;
			gap: 8px;
			padding: 5px 6px;
			margin-bottom: 3px;
			border-radius: 6px;
			font-size: 12.5px;
			line-height: 1.35;
			cursor: pointer;
			transition: background 120ms;
		}
		.legend-item:hover { background: #eff6ff; }
		.legend-item.active { background: #fee2e2; }
		.legend-item .leg-badge {
			flex-shrink: 0;
			min-width: 22px; height: 22px;
			border-radius: 4px;
			background: #1e3a8a; color: white;
			font-size: 11px; font-weight: 700;
			display: flex; align-items: center; justify-content: center;
			padding: 0 5px;
			box-sizing: border-box;
		}
		.legend-item.active .leg-badge { background: #d62828; }
		.legend-item .leg-text { flex: 1; color: #1f2937; }

		/* Légendes romaines / lettres (non cliquables) */
		.roman-list { list-style: none; padding: 0; margin: 8px 0 0; }
		.roman-item { padding: 4px 0; font-size: 12px; color: #4b5563; line-height: 1.4; }
		.roman-item .roman-prefix { display: inline-block; min-width: 24px; color: #6b21a8; font-weight: 600; }
		.roman-children { list-style: none; padding: 0; margin: 4px 0 4px 28px; }
		.roman-children li { padding: 2px 0; font-size: 11.5px; color: #6b7280; }
		.roman-children .roman-prefix { min-width: 18px; color: #6b21a8; }

		.empty-hint { padding: 14px 6px; font-size: 12px; color: #9ca3af; text-align: center; font-style: italic; }

		/* Marqueurs du SVG : numéro + flèche passent en rouge quand la légende est active */
		.marker-num { transition: fill 200ms; }
		.marker-arrow { transition: stroke 200ms, stroke-width 200ms; vector-effect: non-scaling-stroke; }
		.marker-num.active { fill: #d62828 !important; font-weight: 900 !important; }
		.marker-arrow.active {
			stroke: #d62828 !important;
			stroke-width: 2.5px !important;
			vector-effect: non-scaling-stroke;
		}

		/* Zone d'affichage du HTML autonome (remplace #expandedImg quand la figure a un HTML).
		   Le contenu vit dans un Shadow DOM : seules les dimensions de l'hôte comptent ici. */
		#html-viewer {
			display: none;             /* affiché par le JS */
			width: 100%;
			height: 100%;
			overflow: auto;
		}
		/* Mode HTML : la figure occupe TOUTE la largeur du bloc figures.
		   !important requis : max-width 900px et max-height 50vw sont des styles inline.
		   Le plafond 50vw (limitant sur écran étroit) est remplacé par la pleine
		   hauteur du viewport → figure la plus grande possible sans défilement.
		   Le sélecteur #element est indispensable : v1_livreCours.php impose
		   "#element .container-fig{max-width:40vw !important}" — il faut une
		   spécificité supérieure (ID + 2 classes) pour l'emporter en mode HTML. */
		.container-fig.html-wide,
		#element .container-fig.html-wide {
			max-width: 100% !important;
			max-height: 100vh !important;
			padding: 0 !important;
		}

		/* Zone d'affichage du SVG (remplace #expandedImg quand la figure a un SVG) */
		#svg-viewer {
			display: none;             /* affiché par le JS */
			width: 100%;
			height: 100%;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
		#svg-host {
			flex: 1 1 auto;
			width: 100%;
			min-height: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			overflow: hidden;
		}
		#svg-host svg {
			width: 100%;
			height: 100%;
			max-width: 100%;
			max-height: 100%;
			display: block;            /* pas de width/height forcés : viewBox + preserveAspectRatio gèrent */
		}
		#figure-title {
			flex: 0 0 auto;
			margin-top: 6px;
			padding: 8px 12px 4px;
			font-size: 13px;
			font-weight: 600;
			color: #1f2937;
			text-align: center;
			line-height: 1.4;
			max-width: 90%;
			border-top: 2px solid #1e3a8a;
		}

		.container-fig img {
			max-width: 100%;
			max-height: 100%;
			width: auto;
			height: auto;
			object-fit: contain;
		}

		.btn{
			padding: .0rem .0rem;
		}
		.col-12 .col-lg-6 .col-xl-6 {
			background-color: white;
		}

		.scroll-container img.active-thumb {
			border: 2px solid #007bff;
			opacity: 1 !important;
		}


		.viewer-wrapper {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			position: relative;
			padding: 5px 0;
		}

		.nav-arrow {
			display: flex;
			justify-content: center;
			align-items: center;
			transition: background-color 0.3s ease;
		}

		.nav-arrow:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}

		.nav-left {
			margin-right: 10px;
		}

		.nav-right {
			margin-left: 10px;
		}

		.image-viewer {
			position: relative;
			width: 100%;
			max-width: 900px;
			margin: auto;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 20px;
 		}

		.image-viewer img {
			max-width: 100%;
			max-height: 80vh;
			object-fit: contain;
		}

		.absolute-arrow {
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			background-color: rgba(0, 0, 0, 0.5);
			color: white;
			border: none;
			width: 20px;
			height: 50px;
			font-size: 24px;
			z-index: 10;
		}

		.left-arrow {
			left: 10px;
		}

		.right-arrow {
			right: 10px;
		}

		.absolute-arrow:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}

		.scroll-container img.active-thumb {
			border: 3px solid #007bff;
			opacity: 1 !important;
			box-shadow: 0 0 5px #007bff;
		}

	</style>

	<input type="hidden" value="<?php print isset($listFig) && is_array($listFig) ? count($listFig) : 0 ?>" id="cmpFig" name="cmpFig">

	<div class="">
		<div id="figures-scroll-container" class="scroll-container">

			<?php
			if (!isset($listFig) || empty($listFig)) : ?>
				<p class="text-center text-muted" style="padding: 10px; font-size: 0.9rem;">Aucune figure disponible pour ce cours.</p>
			<?php else :
			$counter = -1;
			$firstFig = $listFig[0];
			foreach ($listFig as $value) {
				// Determine the width based on the number of images
				$imageWidth = '60px';//count($listFig) > 3 ? '80%' : '40%'; // Set width to 80% if more than 2 images, otherwise 30%
				$imageHeight = '60px'; //count($listFig) > 3 ? '40%' : '30%'; // Set width to 80% if more than 2 images, otherwise 30%
				$objectFit = count($listFig) > 3 ? '' : 'object-fit: initial;'; // Set width to 80% if more than 2 images, otherwise 30%

				echo '<div class="image-container" style="position: relative; display: inline-block; text-align: center;padding-bottom: 7px;">';

				echo '<img src="data:image/jpeg;base64,' . $value['encryptFigure'] . '" data-name="'.$value['TitreFigure'].'"
          style="width: ' . $imageWidth . '; height: '.$imageHeight.';'.$objectFit.'; border: 0.1px solid #ccc;" 
          class="slider-image zoomable" onclick="showFig(this);" >' .
					'<div><a href="#" class="btn" style="font-size: .75rem;">' . $value['TitreFigure'] . '</a></div>';

				if (count($listFig) > 1 && ($counter + 1) < count($listFig)) {
					echo '<i id="min_' . base64_encode($value['IDFigure']) . '" class="fa fa-minus" style="display:none;padding-right: 1rem; opacity: 0; font-size: 0rem;"></i>';
				}

				echo '</div>';
				$counter++;
			}
			endif;
			?>

		</div>
	</div>

	<?php
// Vérification robuste de $OneBook pour éviter les erreurs "Undefined offset"
if (isset($OneBook) && !empty($OneBook) && is_array($OneBook) && isset($OneBook[0])) {
    $idLivre = isset($OneBook[0]["IDLivre"]) ? (int)$OneBook[0]["IDLivre"] : 0;
    $idTheme = isset($OneBook[0]["IDTheme"]) ? (int)$OneBook[0]["IDTheme"] : 0;
    
    // Atlas themes: FR=16, EN=27, ES=34, RU=42, TR=46, PT=50, IT=54, DE=58, PL=62, JA=66, KO=70 (verify after running setup_ko_database.sql)
    if (in_array($idLivre, [70, 71]) || in_array($idTheme, [16, 27, 34, 42, 46, 50, 54, 58, 62, 66, 70])) {
        $showScroll = true;
    } else {
        $showScroll = false;
    }
} else {
    // Fallback si $OneBook n'est pas disponible (accès direct au fichier HTML)
    $showScroll = false;
}
?>
	<div class="" style="width: 100%; position: relative;">
		<div class="container-fig" style="max-height: 50vw; overflow: hidden;height: 100vh;background: rgb(255, 255, 255);position: relative;
  											width: 100%;  max-width: 900px; margin: auto; display: flex;
  											justify-content: center; align-items: center;">
	<?php if ($showScroll): ?><button onclick="prevImage()" class="nav-arrow absolute-arrow left-arrow"> < </button><?php endif; ?>
			<img id="expandedImg" class="zoomable" style="transform-origin: 51.1628% 43.9834% 0px;
  transform: scale(1);
  max-width: 100%;
  max-height: 100%;
 width: 100%;
  height: auto;
  object-fit: contain; " onclick="toggleZoom()">
			<div id="imgtext"></div>
			<?php if (isset($page) && $page === 'livreCours'): ?>
				<!-- Viewer SVG interactif : remplace l'image PNG quand la figure a un SVG -->
				<div id="svg-viewer">
					<div id="svg-host"></div>
					<div id="figure-title"></div>
				</div>
				<!-- Viewer HTML autonome : le HTML complet (image + marqueurs + légendes)
				     est rendu dans un Shadow DOM (isolation CSS totale, page ↔ figure) -->
				<div id="html-viewer"></div>
			<?php endif; ?>
			<?php if ($showScroll): ?><button onclick="nextImage()" class="nav-arrow absolute-arrow right-arrow"> > <button><?php endif; ?>
		</div>
		<?php if (isset($page) && $page === 'livreCours'): ?>
			<!-- Panneaux de légendes du viewer SVG (remplis par le JS depuis le JSON de la figure) -->
			<div class="fig-legend-panel left" id="fig-legend-left"></div>
			<div class="fig-legend-panel right" id="fig-legend-right"></div>
		<?php endif; ?>
	</div>

	<script>
        let currentSlide = 0;
        let zoomedIn = false; // Track whether zoom is active or not
        let lastTouchX = 0, lastTouchY = 0; // For tracking touch positions

        function moveSlide(direction) {
            const images = document.querySelectorAll('.slider-image');
            const totalImages = images.length;

            currentSlide = (currentSlide + direction + totalImages) % totalImages;
            const slider = document.getElementById('imageSlider');
            const slideWidth = images[0].clientWidth;
            slider.style.transform = 'translateX(' + (-currentSlide * slideWidth) + 'px)';
        }

        function showFig(imgs) {
            // Route par l'index pour bénéficier de l'aiguillage HTML/SVG/PNG de showFigByIndex.
            // Index = POSITION de la miniature dans le DOM (même ordre que figImages et
            // FIG_SVG_MAP) — jamais par src : deux figures issues du même fichier ont des
            // miniatures identiques et indexOf(src) renverrait toujours la première.
            const index = Array.prototype.indexOf.call(document.querySelectorAll('.slider-image'), imgs);
            if (index !== -1) {
                currentIndex = index;
                showFigByIndex(index);
                return;
            }

            // Fallback historique (liste pas encore initialisée) : affichage PNG direct
            const expandImg = document.getElementById("expandedImg");
            const imgText = document.getElementById("imgtext");

            expandImg.src = imgs.src;
            imgText.innerHTML = imgs.getAttribute("data-name");
            expandImg.parentElement.style.display = "block";

            // Met à jour l’apparence des miniatures
            document.querySelectorAll('.slider-image').forEach((el) => {
                el.classList.remove("active-thumb");
            });
            imgs.classList.add("active-thumb");
        }

        // Toggle zoom effect on click
        function toggleZoom() {
            var expandImg = document.getElementById("expandedImg");

            if (!zoomedIn) {
                // Activate zoom on hover or touch
                expandImg.addEventListener("mousemove", zoomImage);
                expandImg.addEventListener("touchmove", zoomImageTouch);
                zoomedIn = true;
            } else {
                // Deactivate zoom effect
                expandImg.removeEventListener("mousemove", zoomImage);
                expandImg.removeEventListener("touchmove", zoomImageTouch);
                expandImg.style.transform = "scale(1)"; // Reset zoom
                zoomedIn = false;
            }
        }

        // Zoom effect on hover (after first click)
        function zoomImage(e) {
            var img = e.target;
            var offsetX = e.offsetX / img.width;
            var offsetY = e.offsetY / img.height;
            var scale = 2; // The zoom scale factor

            img.style.transformOrigin = `${offsetX * 100}% ${offsetY * 100}%`;
            img.style.transform = `scale(${scale})`;
        }

        // Zoom effect for touch events (on mobile devices)
        function zoomImageTouch(e) {
            e.preventDefault(); // Prevent default touch behavior like scrolling
            var img = e.target;

            // Calculate touch position relative to the image
            var touch = e.touches[0];
            var offsetX = (touch.clientX - img.offsetLeft) / img.width;
            var offsetY = (touch.clientY - img.offsetTop) / img.height;
            var scale = 2; // The zoom scale factor

            img.style.transformOrigin = `${offsetX * 100}% ${offsetY * 100}%`;
            img.style.transform = `scale(${scale})`;

            // Track touch movement for better zooming
            lastTouchX = touch.clientX;
            lastTouchY = touch.clientY;
        }

        // Reset zoom if touch ends
        document.getElementById("expandedImg").addEventListener("touchend", function () {
            var img = document.getElementById("expandedImg");
            img.style.transform = "scale(1)"; // Reset zoom
            zoomedIn = false;
        });

        // Adjust zoom behavior for small screens (optional)
        if (window.innerWidth <= 768) { // For mobile/tablet screens
            document.getElementById("expandedImg").style.cursor = "pointer"; // Remove the zoom-in cursor
        }

        // NB : l'affichage initial de la première figure est géré plus bas
        // (DOMContentLoaded du bloc "figImages" → showFigByIndex(0), qui aiguille SVG/PNG).

	</script>

	<script type='text/javascript'>

        function setFig(ur='',titur='',iFig='') {

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/getURLFig",
                data: { ifFig: iFig},
                timeout: 300000,
                success: function(html) {

                    var ar =  JSON.parse(html);

                    if(ar[0]["id"]==1)
                    {
                        ur = ar[0]["desc"];
                        titur = '';// ar[0]["desc"][0]["TitreFigure"];

                        $("#figZoo").html(ur);

                    }else{
                        alert(ar[0]["desc"]);
                    }
                },
                error: function() {
                    alert("Error when call webservice to get Figure . ") ;
                }

            });

            setActiveFig(iFig);

        }

        function setActiveFig(iFig=''){
            var elms 		= document.querySelectorAll("[id='setFigStyl']");
            for(var i = 0; i < elms.length; i++)
            {
                if(elms[i].getAttribute("name")==iFig)
                {elms[i].className = 'btn btn-outline-primary active';}else{elms[i].className = 'btn btn-outline-primary';}
            }
        }
	</script>

	<script>

        var figImages = [];
        var figTitles = [];
        var currentIndex = 0;

        document.addEventListener("DOMContentLoaded", function () {
            const allImages = document.querySelectorAll('.slider-image');
            allImages.forEach((img, index) => {
                figImages.push(img.src);
                figTitles.push(img.getAttribute("data-name"));
                img.addEventListener("click", () => {
                    currentIndex = index;
                });
            });

			<?php if (!empty($firstFig)): ?>
            currentIndex = 0;
            showFigByIndex(currentIndex);
			<?php endif; ?>
        });

        function showFigByIndex(index) {
            const expandImg = document.getElementById("expandedImg");
            const imgText = document.getElementById("imgtext");

            if (figImages.length > 0 && figImages[index]) {
                // Aiguillage : HTML autonome > SVG interactif > PNG classique
                if (figHasHtml(index)) {
                    hideSvgViewer();
                    showHtmlViewer(index);
                } else if (figHasSvg(index)) {
                    hideHtmlViewer();
                    showSvgViewer(index);
                } else {
                    hideSvgViewer();
                    hideHtmlViewer();
                    expandImg.src = figImages[index];
                    imgText.innerHTML = figTitles[index];
                }

                // Mise à jour de la miniature active
                const allThumbs = document.querySelectorAll('.slider-image');
                allThumbs.forEach((img, idx) => {
                    if (idx === index) {
                        img.classList.add("active-thumb");
                        if (img.scrollIntoView) {
                            img.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
                        }
                    } else {
                        img.classList.remove("active-thumb");
                    }
                });
            }
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % figImages.length;
            showFigByIndex(currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + figImages.length) % figImages.length;
            showFigByIndex(currentIndex);
        }

	</script>

	<script>
        /* ═════════ Viewer SVG interactif (porté de viewer.html) ═════════
           Le SVG (numéros/flèches data-num) et son JSON de légendes sont
           chargés à la demande depuis _figure_svg, puis le SVG est INLINÉ
           dans le DOM (indispensable : un <img src> rendrait les marqueurs
           inaccessibles au JS). Clic légende N ↔ numéro+flèche N en rouge. */

        // Carte index de miniature → {id, hasSvg, hasHtml} (même ordre que .slider-image)
        var FIG_SVG_MAP = <?php
            $figSvgMap = array();
            if (isset($listFig) && is_array($listFig)) {
                foreach ($listFig as $vMap) {
                    $figSvgMap[] = array(
                        'id' => isset($vMap['IDFigure']) ? (int) $vMap['IDFigure'] : 0,
                        'hasSvg' => !empty($vMap['hasSvg']),
                        'hasHtml' => !empty($vMap['hasHtml'])
                    );
                }
            }
            echo json_encode($figSvgMap);
        ?>;
        var FIG_BASE_URL = "<?php echo base_url(); ?>";
        var svgFigCache = {};          // idFigure → {svg, meta} (jamais re-téléchargé dans la page)
        var activeLegendNum = null;

        function figHasSvg(index) {
            // Le viewer n'existe que sur livreCours (#svg-viewer présent) ; ailleurs → toujours PNG
            return !!(document.getElementById('svg-viewer') && FIG_SVG_MAP[index] && FIG_SVG_MAP[index].hasSvg);
        }

        function figHasHtml(index) {
            return !!(document.getElementById('html-viewer') && FIG_SVG_MAP[index] && FIG_SVG_MAP[index].hasHtml);
        }

        /* ═════════ Viewer HTML autonome (Shadow DOM) ═════════
           Le HTML uploadé contient tout (image, marqueurs, légendes, styles)
           et est rendu dans un Shadow DOM : ses styles ne fuient pas vers la
           page et réciproquement. L'interactivité (clic légende N ↔ marqueur N
           en rouge) reste dans la page : un écouteur délégué sur le shadow root
           agit sur tout élément porteur de data-num — même contrat que le SVG. */

        var htmlFigCache = {};         // idFigure → html (jamais re-téléchargé dans la page)
        var htmlShadowRoot = null;
        var activeHtmlNum = null;

        // Styles injectés dans le Shadow DOM : le surlignage rouge (contrat data-num).
        // Classes du pipeline (marker-num / marker-arrow / legend-item) + repli générique.
        var FIG_SHADOW_STYLE = ':host{display:block;width:100%;height:100%;}'
            + 'img,svg{max-width:100%;height:auto;}'
            + '[data-num]{cursor:pointer;}'
            + '.marker-num{transition:fill 200ms;}'
            + '.marker-arrow{transition:stroke 200ms,stroke-width 200ms;vector-effect:non-scaling-stroke;}'
            + '.marker-num.active{fill:#d62828 !important;font-weight:900 !important;}'
            + '.marker-arrow.active{stroke:#d62828 !important;stroke-width:2.5px !important;vector-effect:non-scaling-stroke;}'
            + '.legend-item.active{background:#fee2e2;}'
            + '.legend-item.active .leg-badge{background:#d62828;}'
            /* Repli si l'export n'utilise pas les classes du pipeline : data-num nu */
            + 'text[data-num].active,tspan[data-num].active{fill:#d62828 !important;font-weight:900 !important;}'
            + 'line[data-num].active,path[data-num].active,polyline[data-num].active,circle[data-num].active{stroke:#d62828 !important;stroke-width:2.5px !important;}'
            + 'li[data-num].active,span[data-num].active,div[data-num].active,td[data-num].active{background:#fee2e2;color:#d62828;}';

        // Surcharges de MISE EN PAGE injectées APRÈS le style de l'export (donc gagnantes) :
        // alignement sur les dimensions du viewer SVG — figure pleine hauteur du bloc,
        // colonnes de légendes aux extrémités, typographie agrandie pour la lisibilité.
        // Ciblent les classes aa-* du pipeline d'export ; sans effet sur un autre HTML.
        // Scopées ≥ 621px pour préserver le mode empilé mobile de l'export (@container ≤ 620px).
        var FIG_SHADOW_LAYOUT = '.aa-root{height:100%;}'
            + '@container (min-width:621px){'
            /* Côtés à 26% : maintenant que .container-fig n'est plus plafonné à 40vw,
               le bloc s'étale sur toute la colonne (55%) — les légendes absorbent la
               largeur gagnée, la figure centrale garde ses dimensions validées */
            + '.aa-layout{height:100%;gap:6px;grid-template-columns:minmax(160px,26%) minmax(0,1fr) minmax(160px,26%);}'
            + '.aa-svg-host{align-items:center;}'
            /* La boîte du SVG remplit toute la cellule : preserveAspectRatio agrandit
               le dessin au maximum qui tient (contain), quel que soit son format */
            + '.aa-svg-host svg{width:100% !important;height:100% !important;max-width:100% !important;max-height:100% !important;}'
            + '.aa-viewer{padding:4px;}'
            /* Légendes alignées à gauche (l'export les centre par défaut) */
            + '.aa-side{align-items:flex-start;text-align:left;}'
            + '.aa-legend-list{align-items:flex-start;}'
            /* Typographie agrandie (l'export est calibré petit : 12px / badges 20px) */
            + '.aa-legend-item{font-size:14px;padding:7px 8px;justify-content:flex-start;text-align:left;}'
            + '.aa-badge{min-width:24px;height:24px;font-size:12px;}'
            + '.aa-title{font-size:16px;}'
            + '.aa-subtitle{font-size:13.5px;}'
            + '.aa-roman-item{font-size:13px;}'
            + '.aa-roman-children li{font-size:12px;}'
            + '}'
            /* Mobile (< 621px) : l'export empile déjà les panneaux, mais dans
               l'ordre légendes → figure → légendes, et calibré pour un écran
               large (légendes 12px sur 26px de haut, pastilles 18px, alors
               qu'elles se cliquent au doigt pour surligner un repère).
               On remonte donc la figure en tête et on desserre la typographie. */
            + '@container (max-width:620px){'
            + '.aa-layout{gap:10px;}'
            + '.aa-layout > .aa-viewer{order:-1;}'
            + '.aa-viewer{padding:4px;}'
            /* L'export verrouille ces deux-là par ".aa-root .aa-x{... !important}" :
               il faut la même spécificité ET !important pour reprendre la main
               (la feuille injectée passe après celle de l'export). */
            + '.aa-root .aa-legend-item{font-size:13.5px !important;padding:8px 6px !important;line-height:1.35 !important;}'
            + '.aa-root .aa-badge{min-width:22px !important;width:22px !important;height:22px !important;font-size:11.5px !important;}'
            + '.aa-title{font-size:15px;}'
            + '.aa-subtitle{font-size:12.5px;}'
            + '.aa-roman-item{font-size:12.5px;}'
            + '.aa-roman-children li{font-size:12px;}'
            + '}';

        function getHtmlShadowRoot() {
            if (htmlShadowRoot) return htmlShadowRoot;
            var host = document.getElementById('html-viewer');
            if (!host) return null;
            htmlShadowRoot = host.attachShadow({ mode: 'open' });
            // Écouteur unique et délégué : dans le shadow root, e.target n'est pas
            // re-ciblé, closest() atteint donc le porteur de data-num le plus proche
            htmlShadowRoot.addEventListener('click', function (e) {
                var item = e.target && e.target.closest ? e.target.closest('[data-num]') : null;
                if (item) setActiveHtmlLegend(parseInt(item.getAttribute('data-num'), 10));
            });
            return htmlShadowRoot;
        }

        // Clic légende/marqueur N → tous les éléments data-num=N en rouge ; re-clic → désactivation
        function setActiveHtmlLegend(n) {
            if (!htmlShadowRoot || isNaN(n)) return;
            activeHtmlNum = (activeHtmlNum === n) ? null : n;
            htmlShadowRoot.querySelectorAll('[data-num]').forEach(function (el) {
                el.classList.toggle('active', parseInt(el.getAttribute('data-num'), 10) === activeHtmlNum);
            });
        }

        function hideHtmlViewer() {
            var viewer = document.getElementById('html-viewer');
            if (!viewer) return;
            viewer.style.display = 'none';
            var cf = viewer.closest('.container-fig');
            if (cf) cf.classList.remove('html-wide');   // retour au max-width 900px pour PNG/SVG
            var expandImg = document.getElementById('expandedImg');
            var imgText = document.getElementById('imgtext');
            if (expandImg) expandImg.style.display = '';
            if (imgText) imgText.style.display = '';
        }

        function renderHtmlFigure(html) {
            activeHtmlNum = null;
            var sr = getHtmlShadowRoot();
            // Ordre voulu : base < style de l'export < surcharges de mise en page
            if (sr) sr.innerHTML = '<style>' + FIG_SHADOW_STYLE + '</style>' + html + '<style>' + FIG_SHADOW_LAYOUT + '</style>';
        }

        function showHtmlViewer(index) {
            var idFigure = FIG_SVG_MAP[index].id;
            var viewer = document.getElementById('html-viewer');

            document.getElementById('expandedImg').style.display = 'none';
            document.getElementById('imgtext').style.display = 'none';
            // Le HTML embarque ses propres légendes : les panneaux du viewer SVG restent cachés
            document.querySelectorAll('.fig-legend-panel').forEach(function (p) { p.style.display = 'none'; });
            viewer.style.display = 'block';
            var cf = viewer.closest('.container-fig');
            if (cf) cf.classList.add('html-wide');      // pleine largeur du bloc figures

            if (htmlFigCache[idFigure]) {
                renderHtmlFigure(htmlFigCache[idFigure]);
                return;
            }

            renderHtmlFigure('<div style="padding:20px;text-align:center;color:#9ca3af;font-style:italic;">Chargement…</div>');
            fetch(FIG_BASE_URL + 'home/figureHtml/' + idFigure)
                .then(function (r) { if (!r.ok) throw new Error('html'); return r.text(); })
                .then(function (html) {
                    htmlFigCache[idFigure] = html;
                    renderHtmlFigure(html);
                })
                .catch(function () {
                    // Échec de chargement : retour au PNG classique (aucune page cassée)
                    hideHtmlViewer();
                    document.getElementById('expandedImg').src = figImages[index];
                    document.getElementById('imgtext').innerHTML = figTitles[index];
                });
        }

        function hideSvgViewer() {
            var viewer = document.getElementById('svg-viewer');
            if (!viewer) return;
            viewer.style.display = 'none';
            document.querySelectorAll('.fig-legend-panel').forEach(function (p) { p.style.display = 'none'; });
            var expandImg = document.getElementById('expandedImg');
            var imgText = document.getElementById('imgtext');
            if (expandImg) expandImg.style.display = '';
            if (imgText) imgText.style.display = '';
        }

        function showSvgViewer(index) {
            var idFigure = FIG_SVG_MAP[index].id;
            var viewer = document.getElementById('svg-viewer');

            document.getElementById('expandedImg').style.display = 'none';
            document.getElementById('imgtext').style.display = 'none';
            viewer.style.display = 'flex';
            document.querySelectorAll('.fig-legend-panel').forEach(function (p) { p.style.display = 'flex'; });

            if (svgFigCache[idFigure]) {
                renderSvgFigure(svgFigCache[idFigure]);
                return;
            }

            document.getElementById('svg-host').innerHTML = '<div class="empty-hint">Chargement…</div>';
            Promise.all([
                fetch(FIG_BASE_URL + 'home/figureSvg/' + idFigure).then(function (r) { if (!r.ok) throw new Error('svg'); return r.text(); }),
                fetch(FIG_BASE_URL + 'home/figureMeta/' + idFigure).then(function (r) { if (!r.ok) throw new Error('meta'); return r.json(); })
            ]).then(function (res) {
                svgFigCache[idFigure] = { svg: res[0], meta: res[1] };
                renderSvgFigure(svgFigCache[idFigure]);
            }).catch(function () {
                // Échec de chargement : retour au PNG classique (aucune page cassée)
                hideSvgViewer();
                document.getElementById('expandedImg').src = figImages[index];
                document.getElementById('imgtext').innerHTML = figTitles[index];
            });
        }

        function renderSvgFigure(data) {
            activeLegendNum = null;
            document.getElementById('svg-host').innerHTML = data.svg;   // inline dans le DOM
            document.getElementById('figure-title').textContent = data.meta.title_fr || '';
            renderLegendPanels(data.meta);
        }

        function escapeXmlFig(s) {
            return String(s).replace(/[<>&]/g, function (c) { return { '<': '&lt;', '>': '&gt;', '&': '&amp;' }[c]; });
        }

        // Croix d'orientation (Crânial / Dorsal…) — géométrie reprise de viewer.html
        function renderOrientationCross(orient) {
            if (!orient) return '';
            var v = escapeXmlFig(orient.vertical || '');
            var h = escapeXmlFig(orient.horizontal || '');
            return '<div class="orient-cross" title="Orientation">'
                + '<svg viewBox="-8 -4 30 14" xmlns="http://www.w3.org/2000/svg">'
                + '<line class="axis" x1="0" y1="8" x2="0" y2="1.7"/>'
                + '<polygon class="arrow" points="-0.65,1.8 0,0.2 0.65,1.8"/>'
                + '<text x="0" y="-0.9" text-anchor="middle">' + v + '</text>'
                + '<line class="axis" x1="0" y1="8" x2="6.3" y2="8"/>'
                + '<polygon class="arrow" points="6.2,7.35 7.8,8 6.2,8.65"/>'
                + '<text x="8.7" y="8" dominant-baseline="middle">' + h + '</text>'
                + '</svg></div>';
        }

        function renderLegendBlock(block) {
            var parts = ['<div class="fig-block">'];
            parts.push(renderOrientationCross(block.orientation));
            if (block.subtitle) {
                parts.push('<div class="fig-subtitle">' + escapeXmlFig(block.subtitle) + '</div>');
            }
            // Légendes numérotées (cliquables)
            if (block.legends && block.legends.length) {
                parts.push('<ul class="legend-list">');
                block.legends.forEach(function (leg) {
                    parts.push('<li class="legend-item" data-num="' + parseInt(leg.num, 10) + '">'
                        + '<span class="leg-badge">' + parseInt(leg.num, 10) + '</span>'
                        + '<span class="leg-text">' + escapeXmlFig(leg.label_fr) + '</span></li>');
                });
                parts.push('</ul>');
            }
            // Légendes romaines / lettres (non cliquables)
            if (block.roman_legends && block.roman_legends.length) {
                parts.push('<ul class="roman-list">');
                block.roman_legends.forEach(function (r) {
                    parts.push('<li class="roman-item"><span class="roman-prefix">' + escapeXmlFig(r.prefix) + '-</span>' + escapeXmlFig(r.text));
                    if (r.children && r.children.length) {
                        parts.push('<ul class="roman-children">');
                        r.children.forEach(function (c) {
                            parts.push('<li><span class="roman-prefix">' + escapeXmlFig(c.prefix) + '-</span>' + escapeXmlFig(c.text) + '</li>');
                        });
                        parts.push('</ul>');
                    }
                    parts.push('</li>');
                });
                parts.push('</ul>');
            }
            parts.push('</div>');
            return parts.join('');
        }

        function renderLegendPanels(meta) {
            var left = document.getElementById('fig-legend-left');
            var right = document.getElementById('fig-legend-right');
            if (!left || !right) return;

            left.innerHTML = (meta.left_panel && meta.left_panel.length)
                ? meta.left_panel.map(renderLegendBlock).join('')
                : '<div class="empty-hint">Aucune légende à gauche</div>';
            right.innerHTML = (meta.right_panel && meta.right_panel.length)
                ? meta.right_panel.map(renderLegendBlock).join('')
                : '<div class="empty-hint">Aucune légende à droite</div>';

            document.querySelectorAll('.fig-legend-panel .legend-item').forEach(function (el) {
                el.addEventListener('click', function () {
                    setActiveLegend(parseInt(el.dataset.num, 10));
                });
            });
        }

        // Clic légende N → numéro + flèche N en rouge sur le schéma ; re-clic → désactivation
        function setActiveLegend(n) {
            activeLegendNum = (activeLegendNum === n) ? null : n;
            document.querySelectorAll('.fig-legend-panel .legend-item').forEach(function (el) {
                el.classList.toggle('active', parseInt(el.dataset.num, 10) === activeLegendNum);
            });
            document.querySelectorAll('#svg-host .marker-num, #svg-host .marker-arrow').forEach(function (el) {
                el.classList.toggle('active', parseInt(el.getAttribute('data-num'), 10) === activeLegendNum);
            });
        }

	</script>

</div>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
