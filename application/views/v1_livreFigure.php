<?php if(strlen($this->session->userdata('passTok'))==200) { ?>


	<!DOCTYPE html>
	<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Membre Supérieur - Atlas d'Anatomie Humaine</title>
		<!-- ✅ Lien vers Font Awesome pour les icônes -->

		<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo HTTP_JS; ?>DataTables/datatables.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">

		<style type="text/css">
			body {
				margin-bottom: 20px;
				font-size: 0px;
				background-color: white;
			}

			.row {
				--bs-gutter-x: 0px;
			}

			.card-header {
				padding: 0rem 0rem;
			}

			#element {

				height: 200px;
				width: 100%;
				background-color: white;
				text-align: center;*/
			box-sizing: border-box;
				font-size: .875rem;
				font-weight: 400;
				line-height: 1.5;
			}

			.my-1 {
				margin-top: .0rem !important;
			}

			/* webkit requires explicit width, height = 100% of sceeen */
			/* webkit also takes margin into account in full screen also - so margin should be removed (otherwise black areas will be seen) */

			.image-item img {
				margin-left: 0;
				margin-top: 0;
			}

			.zoo-item {
				position: initial;
			}

			#outerContainer #mainContainer div.toolbar {
				display: none !important;
				/* hide PDF viewer toolbar */
			}

			#outerContainer #mainContainer #viewerContainer {
				top: 0 !important;
				/* move doc up into empty bar space */
			}

			.btn-outline-primary {
				color: #000000;
			}

			.toolbar {
				display: none !important;
			}

			.btn-outline-primary.hover {
				background-color: #c5daef;
			}

			.btn-outline-primary.active {
				background-color: #c5daef;
			}


			.image {
				width: 100%;
				height: 100%;
			}

			.image img {
				/* La transition s'applique à la fois sur la largeur et la hauteur, avec une durée d'une seconde. */
				-webkit-transition: all 1s ease;
				/* Safari et Chrome */
				-moz-transition: all 1s ease;
				/* Firefox */
				-ms-transition: all 1s ease;
				/* Internet Explorer 9 */
				-o-transition: all 1s ease;
				/* Opera */
				transition: all 1s ease;
			}

			.image:hover img {
				/* L'image est grossie de 25% */
				-webkit-transform: scale(1.25);
				/* Safari et Chrome */
				-moz-transform: scale(1.25);
				/* Firefox */
				-ms-transform: scale(1.25);
				/* Internet Explorer 9 */
				-o-transform: scale(1.25);
				/* Opera */
				transform: scale(1.25);
			}


			/* magnifying glass icon */

			.demo_container {
				margin: 0 auto;
			}

			.zoom {

				position: relative;
				clear: both;
				/*cursor: zoom-in;*/
			}

			/* magnifying glass icon */
			.zoom:after {
				content: '';
				display: block;
				width: 100px;
				height: 100px;
				position: absolute;
				top: 0;
				right: 0;

			}

			.zoom img {
				display: block;
			}

			.zoom img::selection {
				background-color: transparent;
			}


			* {
				box-sizing: border-box
			}

			/* Slideshow container */
			.slideshow-container {
				max-width: 1000px;
				position: relative;
				margin: auto;
			}

			/* Hide the images by default */
			.mySlides {
				display: none;
			}

			/* Next & previous buttons */
			.prev,
			.next {
				cursor: pointer;
				position: absolute;
				top: 50%;
				width: auto;
				margin-top: -22px;
				padding: 16px;
				color: black;
				font-weight: bold;
				font-size: 18px;
				transition: 0.6s ease;
				border-radius: 0 3px 3px 0;
				user-select: none;
			}

			/* Position the "next button" to the right */
			.prev {
				left: -10%;
			}

			.next {
				right: -10%;
				border-radius: 3px 0 0 3px;
			}

			/* On hover, add a black background color with a little bit see-through */
			.prev:hover,
			.next:hover {
				background-color: rgba(0, 0, 0, 0.8);
			}

			/* Caption text */
			.text {
				color: #f2f2f2;
				font-size: 15px;
				padding: 8px 12px;
				position: absolute;
				bottom: 8px;
				width: 100%;
			}

			/* Number text (1/3 etc) */
			.numbertext {
				color: #f2f2f2;
				font-size: 12px;
				padding: 8px 12px;
				position: absolute;
				top: 0;
			}

			/* The dots/bullets/indicators */
			.dot {
				cursor: pointer;
				margin: 0 2px;
				/*background-color: #bbb;*/
				background-color: transparent;
				border-radius: 10%;
				display: inline-block;
				transition: background-color 0.6s ease;
				font-size: 1rem;
			}

			/* Fading animation */
			.fade {
				-webkit-animation-name: fade;
				-webkit-animation-duration: 1.5s;
				animation-name: fade;
				animation-duration: 1.5s;
			}

			@-webkit-keyframes fade {
				from {
					opacity: .4
				}

				to {
					opacity: 1
				}
			}

			@keyframes fade {
				from {
					opacity: .4
				}

				to {
					opacity: 1
				}
			}

			.fade:not(.show) {
				opacity: 1;
			}
			.dot {
				cursor: pointer;
				margin: 0 2px;
				background-color: transparent;
				border-radius: 10%;
				display: inline-block;
				transition: background-color 0.3s ease;
				font-size: 1rem;
				padding: 5px;
			}

			.dot.active {
				background-color: #c5daef; /* Light blue background for active dot */
			}
		</style>
	</head>

	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
		<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
			<?php include('v1_header_menu.php'); ?>
		</header>
	</header>

	<body>

	<div id="element" style="background:white !important;">
		<?php include('v1_header_nav.php'); ?>

		<?php include('v1_racourci.php'); ?>


		<div class="d-flex justify-content-center flex-wrap">
			<div class="col-2 col-lg-2 col-xl-2"></div>
			<div class="col-8 col-lg-8 col-xl-8">
				<?php include('v1_bloc_figures_atlas.php'); ?>
			</div>
			<div class="col-2 col-lg-2 col-xl-2"></div>
		</div>

	</div>

	</body>

	</html>

<?php } else { ?>

	<?php
	header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
	exit();
	?>

<?php } ?>
