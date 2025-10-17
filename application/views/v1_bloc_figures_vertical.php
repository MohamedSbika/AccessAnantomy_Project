<?php if(strlen($this->session->userdata('passTok'))==200) { ?>

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
			padding: 15px 15px;
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
			left: 15px;
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
			padding: 1px;
		}

		div.scroll-container img {
			padding: 1px;
		}

		/* Scroll container images */
		.scroll-container {
			display: flex;
			flex-direction: column;
			gap: 8px;
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
			max-height: 50vh;
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
	</style>

	<input type="hidden" value="<?php print count($listFig) ?>" id="cmpFig" name="cmpFig">

	<div class="row">

		<div class="col-2 col-lg-2 col-xl-2">
			<div class="scroll-container">

				<?php
				$counter = -1;
				foreach ($listFig as $value) {
					// Determine the width based on the number of images
					$imageWidth = '45px';//count($listFig) > 3 ? '80%' : '40%'; // Set width to 80% if more than 2 images, otherwise 30%
					$imageHeight = '45px'; //count($listFig) > 3 ? '40%' : '30%'; // Set width to 80% if more than 2 images, otherwise 30%
					$objectFit = count($listFig) > 3 ? '' : 'object-fit: initial;'; // Set width to 80% if more than 2 images, otherwise 30%

					echo '<div class="image-container" style="position: relative; display: inline-block; padding-top: 0.2rem;">';

					echo '<img src="data:image/jpeg;base64,' . $value['encryptFigure'] . '" data-name="'.$value['TitreFigure'].'"
          style="width: ' . $imageWidth . '; height: '.$imageHeight.';'.$objectFit.'; margin-left: 0.5rem; border: 0.1px solid #ccc;" 
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

		<div class="col-10 col-lg-10 col-xl-10">
			<div class="container-fig" style="margin: auto;padding: 5px;max-height: 43vw; overflow:hidden;justify-content: center;
  align-items: center;height: 100vh;background: #fff;background-color: #fff;">
				<img id="expandedImg" class="zoomable" style="transform-origin: 51.1628% 43.9834% 0px;
  transform: scale(1);
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
  object-fit: contain; " onclick="toggleZoom()">
				<div id="imgtext"></div>
			</div>

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
            var expandImg = document.getElementById("expandedImg");
            var imgText = document.getElementById("imgtext");

            expandImg.src = imgs.src;
            imgText.innerHTML = imgs.alt;
            expandImg.parentElement.style.display = "block";

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

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
