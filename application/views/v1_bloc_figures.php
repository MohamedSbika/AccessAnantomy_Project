<?php if(strlen($this->session->userdata('passTok'))==200) { ?>
<div style="display: flex;background-color: white">
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
			overflow: auto;
			white-space: nowrap;
			padding-right: 13px;
		}

		div.scroll-container img {
			padding: 1px;
		}

		/* Scroll container images */
		.scroll-container {
			display: flex;
			flex-direction: column;
			/*gap: 8px;*/
			overflow-y: auto;
			max-height: 90vh; /* Limite de hauteur pour activer le scroll */
			padding: 1px;
			background-color: white;
			scroll-behavior: smooth;
			scrollbar-width: thin;            /* Firefox */
			scrollbar-color: #bbb #f8f8f8;    /* Firefox */
		}

		/* WebKit (Chrome, Edge, Safari) */
		.scroll-container::-webkit-scrollbar {
			width: 6px;
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

	<input type="hidden" value="<?php print count($listFig) ?>" id="cmpFig" name="cmpFig">

	<div class="">
		<div class="scroll-container">

			<?php
			$counter = -1;
			$firstFig = !empty($listFig) ? $listFig[0] : null;
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
			?>

		</div>
	</div>

	<?php
if (in_array((int)$OneBook[0]["IDLivre"], [70, 71]) || in_array((int)$OneBook[0]["IDTheme"], [16, 27, 34])) {
	 $showScroll = true;
} else { ?>
	<?php $showScroll = false; } ?>
	<div class="" style="width: 100%;">
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
			<?php if ($showScroll): ?><button onclick="nextImage()" class="nav-arrow absolute-arrow right-arrow"> > <button><?php endif; ?>
		</div>
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
            const expandImg = document.getElementById("expandedImg");
            const imgText = document.getElementById("imgtext");

            expandImg.src = imgs.src;
            imgText.innerHTML = imgs.getAttribute("data-name");
            expandImg.parentElement.style.display = "block";

            // Met à jour l’index courant
            const index = figImages.indexOf(imgs.src);
            if (index !== -1) {
                currentIndex = index;
            }

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

        // Affiche automatiquement la première figure au chargement
        document.addEventListener("DOMContentLoaded", function() {
			<?php if (!empty($firstFig)): ?>
            // Crée un élément virtuel pour déclencher showFig()
            const firstImg = document.createElement('img');
            firstImg.src = "data:image/jpeg;base64,<?php echo $firstFig['encryptFigure']; ?>";
            firstImg.setAttribute('data-name', "<?php echo $firstFig['TitreFigure']; ?>");
            showFig(firstImg); // Affiche la première image
			<?php endif; ?>
        });

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

        let figImages = [];
        let figTitles = [];
        let currentIndex = 0;

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
                expandImg.src = figImages[index];
                imgText.innerHTML = figTitles[index];

                // Mise à jour de la miniature active
                const allThumbs = document.querySelectorAll('.slider-image');
                allThumbs.forEach((img, idx) => {
                    if (idx === index) {
                        img.classList.add("active-thumb");
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

        // Dans showFigByIndex
        const activeImg = document.querySelectorAll('.slider-image')[index];
        if (activeImg && activeImg.scrollIntoView) {
            activeImg.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
        }

	</script>

</div>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
