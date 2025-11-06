<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Access Anatomy</title>
	<!-- Swiper CSS -->
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
	<!-- Swiper JS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

	<style>
		body {
			font-family: 'Roboto', sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f5f5f5;
			color: white;
			overflow-x: hidden;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: 'Unbounded', sans-serif;
			margin: 0;
			padding: 0;
		}

		h1 {
			font-weight: 600;
		}

		h2 {
			font-weight: 500;
		}

		h3 {
			font-weight: 400;
		}

		h4 {
			font-weight: 300;
		}

		h5 {
			font-weight: 200;
		}

		.top-bar {
			color: white;
			padding: 10px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
		}

		.top-bar nav a {
			color: white;
			margin-left: 15px;
			text-decoration: none;
		}

		.side-nav {
			position: fixed;
			top: 0;
			left: -250px;
			width: 250px;
			height: 100%;
			background-color: #0E2A47;
			transition: 0.3s;
			z-index: 1000;
			padding-top: 60px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		}

		.side-nav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 22px;
			color: white;
			display: block;
			transition: 0.3s;
		}

		.side-nav a:hover {
			background-color: #575757;
		}

		/* Close button inside the sidebar */
		.side-nav .close-btn {
			position: absolute;
			top: 20px;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
			color: white;
		}

		/* Hamburger menu button */
		.menu-btn {
			display: none;
			font-size: 30px;
			color: white;
			background: none;
			border: none;
			cursor: pointer;
		}

		.main-nav {
			width: 90%;
			font-size: 10px;
			background: white;
			color: #120E47;
			padding: 10px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			flex-wrap: wrap;
		}

		.btn {
			background: #2E7D32;
			color: white;
			padding: 12px 24px;
			text-decoration: none;
			border-radius: 8px;
			font-weight: bold;
		}

		.btn.secondary {
			background: blue;
			border: 2px solid white;
			padding: 10px 22px;
		}

		@media (max-width: 768px) {
			.menu-btn {
				display: flex;
				position: absolute;
				top: 5px;
				left: 10px;
				width: 40px;
			}

			.side-nav {
				padding-top: 80px;
			}
		}

		@media (min-width: 769px) {
			.side-nav {
				display: none;
			}

			.main-nav ul {
				display: flex;
			}
		}
		@media (max-width: 768px) {
			.menu-btn {
				display: flex;
				position: absolute;
				top: 5px;
				left: 10px;
			}

			.main-nav {
				display: none;
			}

			.side-nav {
				padding-top: 80px;
			}
		}

		@media (min-width: 769px) {
			.main-nav ul {
				display: flex;
			}
		}


		.top-bar {
			color: white;
			padding: 10px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
		}

		.top-bar nav a {
			color: white;
			margin-left: 15px;
			text-decoration: none;
		}



		.main-nav ul {
			list-style: none;
			padding: 0;
			display: flex;
			flex-wrap: wrap;
		}

		.main-nav ul li a {
			color: #120E47;
			text-decoration: none;
			font-weight: bold;
		}

		.btn {
			background: none;
			color: #120E47;
			padding: 12px 24px;
			text-decoration: none;
			border-radius: 8px;
			font-weight: bold;
			border: 1px solid #120E47;
		}

		.btn.secondary {
			background: none;
			border: 2px solid white;
			padding: 10px 22px;
		}

		.hero {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 20px 5%;
			background: white;
			flex-wrap: wrap;
		}

		.hero-text {
			max-width: 45%;
			margin-left: 90px;
		}

		.hero-text h1 {
			font-size: 2.2em;
			font-weight: bold;
			line-height: 1.2;
			color: #120E47;
		}

		.hero-text p {
			font-size: 1.2em;
			margin-bottom: 20px;
			color: #120E47;
		}

		.buttons {
			display: flex;
			gap: 15px;
		}

		.hero-image img {
			margin-bottom: 20px;
			height: 500px;
			width: 500px;
			border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0.4, 0.4, 0.4, 0.45);
	filter: blur(0.2px);
		}

		/* Media Queries for Responsiveness */
		@media (max-width: 1200px) {
			.hero {
				flex-direction: column;
				padding: 80px 5%;
			}

			.hero-text {
				max-width: 100%;
				text-align: center;
				margin-left: 5px;
			}

			.hero-image {
				margin-top: 20px;
				width: 100%;
			}

			.hero-text h1 {
				font-size: 2em;
			}

			.hero-text p {
				font-size: 1em;
			}
		}

		@media (max-width: 768px) {
			.main-nav {
				display: none;
			}

			.hero {
				padding: 80px 5%;
			}

			.hero-text h1 {
				font-size: 1.8em;
			}

			.hero-text p {
				font-size: 1em;
			}

			.hero-image img {
				width: -moz-available;
			}

			.buttons {
				flex-direction: column;
				gap: 10px;
			}

			.main-nav ul {
				flex-direction: column;
				align-items: center;
				width: 100%;
			}

			.main-nav ul li {
				margin: 10px 0;
			}

			.main-nav ul li a {
				font-size: 1.1em;
			}

			.top-bar nav {
				/* flex-direction: column; */
				align-items: center;
			}
		}

		@media (max-width: 480px) {
			.hero {
				padding: 80px 5%;
			}

			.hero-text h1 {
				font-size: 1.6em;
			}

			.hero-text p {
				font-size: 0.9em;
			}

			.buttons {
				gap: 8px;
			}

			.main-nav ul li a {
				font-size: 0.9em;
			}

			.top-bar {
				flex-direction: column;
				align-items: center;
			}

			.top-bar nav a {
				margin: 5px 0;
			}

			.hero-image img {
				border-radius: 8px;
				width: -moz-available;
			}

			.hero-text p {
				line-height: 1.4;
			}
		}

		nav {
			display: flex;
			/* Utilisation de Flexbox pour aligner les éléments horizontalement */
			justify-content: flex-end;
			/* Aligne tous les éléments à droite */
			align-items: center;
			/* Aligne verticalement les éléments */
		}

		nav a {
			text-decoration: none;
			color: white;
			font-weight: bold;
		}

		.social-link {
			display: inline-block;
		}

		.social-icon {
			width: 40px;
			/* Taille des icônes sociales */
			height: 40px;
			border-radius: 50%;
			/* Rendre les icônes circulaires */
		}

		.flag {
			font-size: 1.5em;
		}

		.dropdown-menu {
			top: 20px !important;
		}
	</style>

</head>

<body>

	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
		<div class="top-bar">
			<span>📧 contact@accessanatomy.com</span>

			<nav>
				<a href="https://www.facebook.com/AccessAnatomyFB" target="_blank" title="Facebook" class="social-link"
					id="facebook-link">
					<img src="<?php echo HTTP_IMAGES; ?>social_media/fb_40.png" class="rounded-circle social-icon"
						alt="Facebook">
				</a>
				<a href="https://www.instagram.com/accessanatomy_com/" target="_blank" title="Instagram"
					class="social-link" id="instagram-link">
					<img src="<?php echo HTTP_IMAGES; ?>social_media/instagram_40.png"
						class="rounded-circle social-icon" alt="instagram">
				</a>

				<?php if ($this->session->userdata('user_id') > 0) { ?>
					<a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>logout"
						class="dropdown-item" style="padding: .5rem 0.2rem;">
						<i class="fa fa-sign-out-alt"></i>
						<span class="text-dark"><?php echo $this->lang->line('logout'); ?></span>
					</a>
					<?php if ($this->session->userdata('EstAdmin') == 1) {
						$encrypted_url = urlencode(base64_encode($this->uri->uri_string())); ?>
						<a href="<?php echo base_url() . $this->lang->line('siteLang') . 'switchPlatform/' . $encrypted_url; ?>"
							class="dropdown-item" style="padding: .5rem 0.2rem;">
							<?php if ($this->session->userdata('typePlatform') == true && $this->session->userdata('EstAdmin') == 1) { ?>
								<i class="fa fa-tools"></i>
								<span class="text-dark"
									style="margin-left: 10px"><?php echo $this->lang->line('modeAdmin'); ?></span>
							<?php } else { ?>
								<i class="fa fa-book-open"></i>
								<span class="text-dark"
									style="margin-left: 10px"><?php echo $this->lang->line('ModeLecture'); ?></span>
							<?php } ?>
						</a>
					<?php } ?>
				<?php } else { ?>
					<a href="#" onclick="openModalLogin(); return false;"><?php echo $this->lang->line('sign_in'); ?></a>
				<?php } ?>

				<?php include('v1_header_langauge.php'); ?>

			</nav>
		</div>

		<!-- Hamburger Menu Icon -->
		<button class="menu-btn" onclick="toggleNav()">☰</button>

		<!-- Sidebar Navigation (Initially hidden) -->
		<div class="side-nav" id="sideNav">
			<a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>
			<a href="#">Accueil</a>
			<a href="#">Anatomie ▼</a>
			<a href="#">Embryologie ▼</a>
			<a href="#">ELearning</a>
			<a href="#">Contact</a>
		</div>

		<!-- Main Navigation for larger screens -->
		<nav class="main-nav">

			<img style="width: 120px" src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" alt="Access Anatomy Logo">

			<?php include('v1_header_category.php'); ?>

			<a href="<?php echo base_url('FR/livreList/1/1'); ?>" class="btn"
				style="font-size: small;"><?php echo $this->lang->line('demarrerGratuit'); ?></a>

		</nav>
	</header>

	<script>
		function toggleNav() {
			var sideNav = document.getElementById("sideNav");
			if (sideNav.style.left === "0px") {
				sideNav.style.left = "-250px"; 
			} else {
				sideNav.style.left = "0";  
			}
		}

		function closeNav() {
			document.getElementById("sideNav").style.left = "-250px"; 
		}
	</script>

	<main>

		<section class="hero">
			<div class="hero-text">
				<h1><?php echo $this->lang->line('desc_access'); ?></h1>
				<p><?php echo $this->lang->line('desc_access2'); ?></p>
				<div class="buttons">
					<a href="signUp" class="btn" style="height: 30px; line-height: 30px;">
						<?php echo $this->lang->line('s_inscrire'); ?>
					</a>

					<style>
						.buttons {
							display: flex;
							justify-content: space-between;
							gap: 20px;
							align-items: center;
						}


						.btn.secondary-test {
							background: none;
							padding: 10px 20px;
							border-radius: 30px;
							text-decoration: none;
							color: #120E47;
							font-weight: bold;
							display: flex;
							align-items: center;
							font-size: 1em;
							white-space: nowrap;
							gap: 10px;
						}

						.play-icon {
							background-color: #120E47;
							color: #fff;
							border-radius: 50%;
							padding: 10px;
							font-size: 1.5em;
							display: flex;
							justify-content: center;
							align-items: center;
							width: 30px;
						}

						.btn:hover {
							background-color: whitesmoke;
						}
					</style>
					<a href="#" class="btn secondary-test">
						<span class="play-icon">▶</span> <?php echo $this->lang->line('decouvrir_platform'); ?>
					</a>

				</div>
			</div>
			<div class="hero-image">
				<img src="<?php echo HTTP_IMAGES; ?>photos/brain.png" alt="Image anatomique">
			</div>
		</section>

		<style>
			@media (max-width: 768px) {
				.responsive-section {
					flex-direction: column;
					text-align: center;
				}

				.responsive-item {
					margin-bottom: 20px;
					justify-content: center;
				}
			}
		</style>

		<section class="responsive-section"
			style="background-color: #008b6a; display: flex; justify-content: space-around; color: white; align-items: center; padding: 25px; flex-wrap: wrap;">
			<div class="responsive-item" style="display: flex; align-items: center; margin: 10px;">
				<i class="fas fa-book-open" style="font-size: 30px; margin-right: 10px;"></i>
				<h2><?php echo $this->lang->line('cours'); ?></h2>
			</div>
			<div class="responsive-item" style="display: flex; align-items: center; margin: 10px;">
				<i class="fas fa-check-circle" style="font-size: 30px; margin-right: 10px;"></i>
				<h2><?php echo $this->lang->line('qcm'); ?></h2>
			</div>
			<div class="responsive-item" style="display: flex; align-items: center; margin: 10px;">
				<i class="fas fa-pencil-alt" style="font-size: 30px; margin-right: 10px;"></i>
				<h2><?php echo $this->lang->line('qroc'); ?></h2>
			</div>
			<div class="responsive-item" style="display: flex; align-items: center; margin: 10px;">
				<i class="fas fa-file-alt" style="font-size: 30px; margin-right: 10px;"></i>
				<h2><?php echo $this->lang->line('types_cours'); ?></h2>
			</div>
		</section>

		<style>
			.section-info {
				display: flex;
				align-items: center;
				padding: 60px 5%;
				background: white;
				color: #0E2A47;
			}

			.section-info .image-container {
				position: relative;
				max-width: 40%;
			}

			.section-info .image-container img {
				max-width: 100%;
				border-radius: 12px;
				box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
			}

			.section-info .image-container::before {
				content: "";
				position: absolute;
				width: 90%;
				height: 90%;
				background: #2E7D32;
				border-radius: 12px;
				left: -10px;
				top: 10px;
				z-index: -1;
			}

			.section-info .text-container {
				max-width: 50%;
				margin-left: 5%;
			}

			.section-info h2 {
				font-size: 2.2em;
				font-weight: bold;
				margin-bottom: 20px;
			}

			.section-info p {
				font-size: 1.2em;
				margin-bottom: 20px;
			}

			.section-info ul {
				list-style: none;
				padding: 0;
			}

			.section-info ul li {
				display: flex;
				align-items: center;
				margin-bottom: 10px;
			}

			.section-info ul li::before {
				content: "✔";
				color: #2E7D32;
				font-weight: bold;
				margin-right: 10px;
			}

			/* Media Queries for Responsiveness */
			@media (max-width: 1200px) {
				.section-info {
					flex-direction: column;
					padding: 40px 5%;
				}

				.section-info .image-container {
					max-width: 80%;
					margin: 0 auto;
				}

				.section-info .text-container {
					max-width: 100%;
					text-align: center;
					margin-left: 0;
					margin-top: 20px;
				}

				.section-info h2 {
					font-size: 2em;
				}

				.section-info p {
					font-size: 1.1em;
				}

				.section-info ul li {
					font-size: 1em;
				}
			}

			@media (max-width: 768px) {
				.section-info {
					padding: 30px 5%;
				}

				.section-info h2 {
					font-size: 1.8em;
				}

				.section-info p {
					font-size: 1em;
				}

				.section-info ul li {
					font-size: 0.9em;
				}

				.section-info .image-container img {
					max-width: 100%;
					margin-bottom: 20px;
				}
			}

			@media (max-width: 480px) {
				.section-info {
					padding: 20px 5%;
				}

				.section-info h2 {
					font-size: 1.6em;
				}

				.section-info p {
					font-size: 0.9em;
				}

				.section-info ul li {
					font-size: 0.9em;
				}

				.section-info .image-container img {
					max-width: 100%;
				}
			}
		</style>
		<section class="section-info">
			<div class="image-container">
				<img src="<?php echo HTTP_IMAGES; ?>photos/brain.png" alt="Cerveau énergétique">
			</div>
			<div class="text-container">
				<h3><?php echo $this->lang->line('access_desc_title'); ?></h3>
				<p><?php echo $this->lang->line('access_desc_p'); ?></p>
				<p><?php echo $this->lang->line('access_desc_p1'); ?></p>
				<ul>
					<li><?php echo $this->lang->line('access_desc_li1'); ?></li>
					<li><?php echo $this->lang->line('access_desc_li2'); ?></li>
					<li><?php echo $this->lang->line('access_desc_li3'); ?></li>
					<li><?php echo $this->lang->line('access_desc_li4'); ?></li>
					<li><?php echo $this->lang->line('access_desc_li5'); ?></li>
					<li><?php echo $this->lang->line('access_desc_li6'); ?></li>
				</ul>
				<p><?php echo $this->lang->line('access_desc_p2'); ?></p>
			</div>

		</section>

		<style>
			.section-container {
				display: flex;
				justify-content: space-between;
				align-items: flex-start;
				padding: 20px;
				max-width: 1200px;
				margin: 0 auto;
				flex-wrap: wrap;
			}

			.text-container {
				max-width: 590px;
				margin-bottom: 20px;
			}

			.text-container h2 {
				font-size: 1.5em;
				font-weight: bold;
				color: #333;
			}

			.method-box {
				background: #ffffff;
				border: 2px solid #006d77;
				border-radius: 10px;
				padding: 20px;
				width: 300px;
				text-align: center;
				box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
				height: 400px;
				margin-bottom: 20px;
			}

			.method-box h3 {
				font-size: 1.5em;
				color: #006d77;
			}

			.step {
				background: linear-gradient(-200deg, #203b6f, #008b6a);
				color: white;
				padding: 20px;
				border-radius: 10px;
				width: 250px;
				text-align: justify;
				height: 400px;
				margin-bottom: 20px;
			}

			.step h1 {
				font-size: 80px;
				text-align: center;
				font-weight: 800
			}

			.step h2 {
				text-align: center;
			}

			.step h3 {
				font-size: 2em;
				margin-bottom: 10px;
			}

			.step h4 {
				font-size: 1.2em;
				margin-bottom: 15px;
			}

			.step-container {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-around;
				max-width: 1200px;
				margin: 10px auto;
			}

			/* Media Queries for Responsiveness */
			@media (max-width: 768px) {
				.section-container {
					/*flex-direction: column;*/
					align-items: center;
				}

				.method-box,
				.step {
					width: 80%;
					margin-bottom: 15px;
				}

				.text-container {
					max-width: 90%;
					text-align: center;
				}

				.text-container h2 {
					font-size: 2.5em;
				}

				.method-box h3,
				.step h3 {
					font-size: 1.5em;
				}

				.step h4 {
					font-size: 1em;
				}
			}

			@media (max-width: 480px) {
				.section-container {
					padding: 15px;
				}

				.text-container h2 {
					font-size: 2em;
				}

				.method-box,
				.step {
					width: 100%;
					margin-bottom: 10px;
				}

				.method-box h3,
				.step h3 {
					font-size: 1.3em;
				}

				.step h4 {
					font-size: 0.9em;
				}
			}
		</style>

		<div class="step-container"
			style="justify-content: flex-start !important; margin: 5px auto !important;gap: 20px;">

			<div class="method-box">
				<div class="text-container">
					<h2 style="color: black;font-size: 1.8em;line-height: 1.8;">
						<?php echo $this->lang->line('learning_steps_title'); ?>
					</h2>
				</div>
				<hr style="border: none;border-top: 2px solid #cccccc4f; margin: 20px 0;">
				<p style="color: black;line-height: 1.8;"><b><?php echo $this->lang->line('learning_steps_desc'); ?></b>
				</p>
			</div>
			<style>
				.step {
					width: 100%;
					max-width: 810px;
					padding: 10px;
					margin: 0 auto;
				}

				.step-container {
					margin: 0 auto;
				}

				.step-card {
					display: flex;
					flex-direction: row;
					background: #f5f5f5;
					border-radius: 10px;
					box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
					overflow: hidden;
					margin-bottom: 15px;
				}

				.left-box {
					background-color: #120e47;
					color: white;
					display: flex;
					flex-direction: column;
					align-items: center;
					justify-content: center;
					width: 140px;
					min-width: 140px;
					padding: 10px;
				}

				.left-box h1 {
					margin: 0;
					font-size: 25px;
				}

				.left-box h2 {
					font-size: 14px;
					text-transform: uppercase;
					text-align: center;
				}

				.right-box {
					padding: 10px;
					flex: 1;
					background-color: white;
				}

				.right-box p {
					margin: 0;
					color: #333;
					font-size: 13px;
				}

				/* Responsive Design */
				@media screen and (max-width: 600px) {
					.step-card {
						flex-direction: column;
					}

					.left-box {
						width: 100%;
						flex-direction: row;
						justify-content: flex-start;
						width: auto !important;
						display: block;
					}

					.left-box h1,
					.left-box h2 {
						font-size: 18px;
					}

					.right-box {
						padding-top: 0;
					}
				}
			</style>

			<div class="step" style="width: 810px;padding: 10px;height: 100%;">
				<div class="step-container" style="margin: 0px auto;">

					<div class="step-card"
						style="display: flex; background: #f5f5f5; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 15px;">

						<!-- Bloc gauche -->
						<div class="left-box">
							<h1 style="margin: 0; font-size: 25px;">1</h1>
							<h2 style="font-size: 14px; text-transform: uppercase;">
								<?php echo $this->lang->line('step_1_title'); ?>
							</h2>
						</div>

						<!-- Bloc droit -->
						<div class="right-box" style="padding: 10px; flex: 1;">
							<p style="margin: 0; color: #333;font-size: 13px;">
								<?php echo $this->lang->line('step_1_desc'); ?>
							</p>
						</div>

					</div>

					<div class="step-card"
						style="display: flex; background: #f5f5f5; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 15px;">

						<!-- Bloc gauche -->
						<div class="left-box">
							<h1 style="margin: 0; font-size: 25px;">2</h1>
							<h2 style="font-size: 14px; text-transform: uppercase;">
								<?php echo $this->lang->line('step_2_title'); ?>
							</h2>
						</div>

						<!-- Bloc droit -->
						<div class="right-box" style="padding: 10px; flex: 1;">
							<p style="margin: 0; color: #333;font-size: 13px;">
								<?php echo $this->lang->line('step_2_desc'); ?>
							</p>
						</div>

					</div>

					<div class="step-card">

						<div class="left-box">
							<h1 style="margin: 0; font-size: 25px;">3</h1>
							<h2 style="font-size: 14px; text-transform: uppercase;">
								<?php echo $this->lang->line('step_3_title'); ?>
							</h2>
						</div>

						<div class="right-box" style="padding: 10px; flex: 1;">
							<p style="margin: 0; color: #333;font-size: 13px;">
								<?php echo $this->lang->line('step_3_desc'); ?>
							</p>
						</div>

					</div>

					<div class="step-card"
						style="display: flex; background: #f5f5f5; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 15px;">

							<h1 style="margin: 0; font-size: 25px;">4</h1>
							<h2 style="font-size: 14px; text-transform: uppercase;">
								<?php echo $this->lang->line('step_4_title'); ?>
							</h2>
						</div>

						<div class="right-box" style="padding: 10px; flex: 1;">
							<p style="margin: 0; color: #333;font-size: 13px;">
								<?php echo $this->lang->line('step_4_desc'); ?>
							</p>
						</div>

					</div>

					<div class="step-card" style="margin-bottom: 0px !important;">

						<div class="left-box">
							<h1 style="margin: 0; font-size: 25px;">5</h1>
							<h2 style="font-size: 14px; text-transform: uppercase;">
								<?php echo $this->lang->line('step_5_title'); ?>
							</h2>
						</div>

						<div class="right-box" style="padding: 10px; flex: 1;">
							<p style="margin: 0; color: #333;font-size: 13px;">
								<?php echo $this->lang->line('step_5_desc'); ?>
							</p>
						</div>

					</div>

				</div>

			</div>

		</div>






		<section>
			<style>
				.section-price-plan {
					display: flex;
					justify-content: space-between;
					align-items: center;
					padding: 10px 5%;
					background: linear-gradient(135deg, #120E47 30%, #0c2d26e8 100%);
					flex-direction: column;
				}

				.price_plan {
					max-width: 1200px;
					margin: auto;
					margin-top: 20px;
					width: 100%;
				}

				.toggle-container {
					margin-top: 20px;
					margin-bottom: 20px;
					display: flex;
					align-items: center;
					justify-content: center;
					gap: 10px;
				}

				.toggle-switch {
					position: relative;
					display: inline-block;
					width: 50px;
					height: 24px;
				}

				.toggle-switch input {
					opacity: 0;
					width: 0;
					height: 0;
				}

				.slider-toggle {
					position: absolute;
					cursor: pointer;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					background-color: #ccc;
					transition: .4s;
					border-radius: 24px;
				}

				.slider-toggle:before {
					position: absolute;
					content: "";
					height: 16px;
					width: 16px;
					left: 4px;
					bottom: 4px;
					background-color: white;
					transition: .4s;
					border-radius: 50%;
				}

				input:checked+.slider-toggle {
					background-color: #28a745;
				}

				input:checked+.slider-toggle:before {
					transform: translateX(26px);
				}

				.plans {
					display: flex;
					justify-content: space-between;
					gap: 50px;
					flex-wrap: wrap;
					width: 100%;
				}

				.plan {
					background: white;
					padding: 20px;
					border-radius: 10px;
					box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
					flex: 1;
					min-width: 200px;
					display: flex;
					flex-direction: column;
					justify-content: space-between;
					margin-bottom: 20px;
				}

				.plan h2 {
					color: #333;
					text-align: center;
				}

				.plan p.description {
					font-size: 14px;
					color: #666;
					margin-bottom: 10px;
					text-align: center;
				}

				.price {
					font-family: 'Unbounded', sans-serif;
					font-size: 24px;
					font-weight: bold;
					margin: 10px 0;
					text-align: center;
					color: #000;
				}

				.features {
					text-align: left;
					padding: 10px 0;
					flex-grow: 1;
				}

				.features li {
					list-style: none;
					padding: 5px 0;
					display: flex;
					align-items: center;
					color: #000;
					position: relative;
				}

				.features li::before {
					content: '\2714';
					color: white;
					background-color: #28a745;
					border-radius: 50%;
					width: 20px;
					height: 20px;
					position: absolute;
					top: 5px;
					left: 0;
					display: flex;
					justify-content: center;
					align-items: center;
					font-size: 14px;
					text-align: center;
				}

				.features li span {
					margin-left: 30px;
					text-align: left;
				}

				.button {
					display: inline-block;
					padding: 10px 20px;
					text-decoration: none;
					border-radius: 5px;
					margin-top: 10px;
					text-align: center;
				}

				.plan:nth-child(1) .button {
					background: #203b6f;
					color: white;
				}

				.plan:nth-child(1) .button:hover {
					background: #0056b3;
				}

				.plan:nth-child(2) .button {
					background: #008b6a;
					color: white;
				}

				.plan:nth-child(2) .button:hover {
					background: #146c43;
				}

				.plan:nth-child(3) .button {
					background: #008b6a;
					color: white;
				}

				.plan:nth-child(3) .button:hover {
					background: #d39e00;
				}

				@media (max-width: 768px) {
					.section-price-plan {
						padding: 10px 2%;
					}

					.plans {
						flex-direction: column;
						gap: 15px;
					}

					.plan {
						margin-bottom: 10px;
						min-width: auto;
					}

					.price {
						font-size: 20px;
					}

					.plan h2 {
						font-size: 1.2rem;
					}

					.plan p.description {
						font-size: 12px;
					}

					.features li {
						font-size: 12px;
					}

					.button {
						padding: 8px 15px;
						font-size: 14px;
					}
				}

				@media (max-width: 480px) {
					.plan h2 {
						font-size: 1rem;
					}

					.plan p.description {
						font-size: 10px;
					}

					.price {
						font-size: 18px;
					}

					.features li {
						font-size: 10px;
					}

					.button {
						font-size: 12px;
						padding: 6px 12px;
					}
				}

				.plan:nth-child(1) .features li:nth-child(5)::before,
				.plan:nth-child(1) .features li:nth-child(6)::before,
				.plan:nth-child(1) .features li:nth-child(7)::before {
					content: '\2716';
					color: white;
					background-color: red;
					border-radius: 50%;
					width: 20px;
					height: 20px;
					position: absolute;
					top: 5px;
					left: 0;
					display: flex;
					justify-content: center;
					align-items: center;
					font-size: 14px;
					text-align: center;
				}
			</style>

			<section class="section-info">
				<div class="image-container">
					<img src="<?php echo HTTP_IMAGES; ?>photos/chatbot.png" alt="Cerveau énergétique">
				</div>
				<div class="text-container">
	<h3><?php echo $this->lang->line('chatbot_title'); ?></h3>
	<p><?php echo $this->lang->line('chatbot_p'); ?></p>
	<p><?php echo $this->lang->line('chatbot_p1'); ?></p>
	<ul>
		<li><?php echo $this->lang->line('chatbot_li1'); ?></li>
		<li><?php echo $this->lang->line('chatbot_li2'); ?></li>
		<li><?php echo $this->lang->line('chatbot_li3'); ?></li>
		<li><?php echo $this->lang->line('chatbot_li4'); ?></li>
		<li><?php echo $this->lang->line('chatbot_li5'); ?></li>
	</ul>
	<p><?php echo $this->lang->line('chatbot_p2'); ?></p>

	<?php $button_text = $this->lang->line('chatbot_button') ?? 'hello'; ?>

	<?php if ($this->session->userdata('user_id') > 0): ?>
		<a href="http://localhost:5173" class="btn-chatbot" target="_blank">
			<?= $button_text; ?>
		</a>
	<?php else: ?>
		<a href="#" class="btn-chatbot" onclick="openModalLogin(); return false;">
			<?= $button_text; ?>
		</a>
	<?php endif; ?>
</div>
				<style>
					.section-info .btn-chatbot {
						display: inline-block;
						padding: 15px 40px;
						margin-top: 15px;
						background-color: #2A9D8F;
						color: #fff;
						font-size: 16px;
						font-weight: 600;
						border-radius: 8px;
						text-decoration: none;
						transition: background 0.3s ease;
						text-align: center;
						min-width: 120px;
					}

					.section-info .btn-chatbot:hover {
						background-color: #203b6f;
						color: #fff;
					}

					.section-info .btn-chatbot:link,
					.section-info .btn-chatbot:visited {
						color: #fff;
						text-decoration: none;
					}
				</style>
			</section>


			<div class="section-price-plan">
				<div class="price_plan">
					<h1 style="text-align: center; font-size: xx-large">
						<?php echo $this->lang->line('pricing_title'); ?>
					</h1>
					<div class="toggle-container">
						<span><?php echo $this->lang->line('monthly'); ?></span>
						<label class="toggle-switch">
							<input type="checkbox" checked>
							<span class="slider-toggle"></span>
						</label>
						<span><?php echo $this->lang->line('annual'); ?></span>
					</div>
					<div class="plans">
						<?php
						$plans = ['basic', 'premium', 'institutional'];
						foreach ($plans as $plan) { ?>
							<div class="plan">
								<h2><?php echo $this->lang->line("{$plan}_title"); ?></h2>
								<p class="description"><?php echo $this->lang->line("{$plan}_desc"); ?></p>
								<p class="price"><?php echo $this->lang->line("{$plan}_price"); ?></p>
								<p style="color: black"><?php echo $this->lang->line('resource_highlight'); ?></p>
								<ul class="features">
									<?php foreach ($this->lang->line("{$plan}_features") as $feature) { ?>
										<li><span><?php echo $feature; ?></span></li>
									<?php } ?>
								</ul>
								<a href="#" class="button"><?php echo $this->lang->line("{$plan}_cta"); ?></a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</section>




		<section class="section-gallery" style="padding-bottom: 30px;padding-top: 30px;background-color: #bfbfbf;">

			<style>
				.swiper-container {
					width: 100%;
					height: 100%;
				}

				.swiper-slide {
					text-align: center;
					font-size: 18px;
					background: #fff;

					display: -webkit-box;
					display: -ms-flexbox;
					display: -webkit-flex;
					display: flex;
					-webkit-box-pack: center;
					-ms-flex-pack: center;
					-webkit-justify-content: center;
					justify-content: center;
					-webkit-box-align: center;
					-ms-flex-align: center;
					-webkit-align-items: center;
					align-items: center;
				}

				.swiper-slide img {
					display: block;
					width: 100%;
					height: auto;
					object-fit: cover;
					box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7),
						0 6px 20px rgba(0, 0, 0, 0.3);
					border-radius: 8px;
				}

				.swiper-horizontal>.swiper-pagination-bullets,
				.swiper-pagination-bullets.swiper-pagination-horizontal {
					bottom: auto;
				}
			</style>


			<!-- Slider principal -->
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>1.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>2.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>3.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>4.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>5.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>6.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>7.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>8.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>9.png" alt="Image 1"></div>
					</div>
					<div class="swiper-slide">
						<div class="image-scroll"><img src="<?php echo HTTP_IMAGES_COUV; ?>10.png" alt="Image 1"></div>
					</div>
				</div>

				<!-- Pagination -->
				<div class="swiper-pagination"></div>

			</div>

			<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
			<style>
				.swiper-wrapper {
					transition-timing-function: linear !important;
				}
			</style>

			<script>
				var swiper = new Swiper('.swiper-container', {
					loop: true,
					slidesPerView: 4,
					spaceBetween: 30,
					autoplay: {
						delay: 0, 
						disableOnInteraction: false
					},
					speed: 4000, 
					freeMode: true, 
					freeModeMomentum: false, 
					freeModeSticky: false, 
					pagination: { el: '.swiper-pagination', clickable: true },
					navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
				});
			</script>

		</section>

		<br>

		<style>
			.section-contact {
				background-color: #f4f4f4;
				margin: 0;
				padding: 0;
				display: flex;
				justify-content: center;
				align-items: center;
				padding: 20px;
			}

			.container-contact {
				display: flex;
				background: white;
				padding: 20px;
				max-width: 1200px;
				width: 100%;
				flex-wrap: wrap;
				gap: 20px;
			}

			.left {
				flex: 1;
				padding: 20px;
			}

			.left h1 {
				font-size: 32px;
				color: #111;
			}

			.left p {
				color: #555;
				margin-bottom: 20px;
			}

			.contact-info {
				display: flex;
				align-items: center;
			}

			.contact-info img {
				width: 40px;
				margin-right: 10px;
			}

			.contact-info p {
				margin: 0;
				font-weight: bold;
			}

			.right {
				flex: 1;
				background: #f9f9f9;
				padding: 35px;
				border-radius: 10px;
			}

			.right h2 {
				font-size: 22px;
				color: #222;
			}

			.form-group {
				margin-bottom: 15px;
			}

			input,
			textarea {
				width: 100%;
				padding: 10px;
				border: 1px solid #ddd;
				border-radius: 5px;
			}

			button {
				background: green;
				color: white;
				border: none;
				padding: 10px;
				width: 100%;
				border-radius: 5px;
				cursor: pointer;
			}

			button:hover {
				background: darkgreen;
			}

			/* Responsive styles */
			@media (max-width: 768px) {
				.container-contact {
					flex-direction: column;
					padding: 10px;
				}

				.left,
				.right {
					flex: 1;
					padding: 15px;
					margin-bottom: 20px;
				}

				.left h1 {
					font-size: 28px;
				}

				.left p {
					font-size: 14px;
				}

				.contact-info img {
					width: 35px;
				}

				.right h2 {
					font-size: 20px;
				}

				.form-group input,
				.form-group textarea {
					font-size: 14px;
					padding: 8px;
				}

				button {
					font-size: 16px;
				}
			}

			@media (max-width: 480px) {
				.left h1 {
					font-size: 24px;
				}

				.left p {
					font-size: 12px;
				}

				.contact-info img {
					width: 30px;
				}

				.right h2 {
					font-size: 18px;
				}

				.form-group input,
				.form-group textarea {
					font-size: 12px;
					padding: 6px;
				}

				button {
					font-size: 14px;
					padding: 8px;
				}
			}
		</style>

		<section class="section-contact">
			<div class="container-contact">
				<div class="left">
					<h1><?php echo $this->lang->line('contact_title'); ?></h1>
					<p><?php echo $this->lang->line('contact_desc'); ?></p>
					<div class="contact-info">
						<span>📧</span>
						<div>
							<h3 style="color: black"><?php echo $this->lang->line('contact_label'); ?></h3>
							<p><?php echo $this->lang->line('contact_email'); ?></p>
						</div>
					</div>
				</div>
				<div class="right">
					<h2><?php echo $this->lang->line('form_title'); ?></h2>
					<p style="color: black"><?php echo $this->lang->line('form_desc'); ?></p>

					<!-- Formulaire sécurisé avec CodeIgniter -->
					<form>
						<div class="form-group">
							<label for="name"><?php echo $this->lang->line('form_name'); ?></label>
							<input type="text" name="name" id="name_contact"
								placeholder="<?php echo $this->lang->line('form_name_placeholder'); ?>" required>
						</div>
						<div class="form-group">
							<label for="phone"><?php echo $this->lang->line('form_phone'); ?></label>
							<input type="text" name="phone" id="phone_contact"
								placeholder="<?php echo $this->lang->line('form_phone_placeholder'); ?>" required>
						</div>
						<div class="form-group">
							<label for="email"><?php echo $this->lang->line('form_email'); ?></label>
							<input type="email" name="email" id="email_contact"
								placeholder="<?php echo $this->lang->line('form_email_placeholder'); ?>" required>
						</div>
						<div class="form-group">
							<label for="message"><?php echo $this->lang->line('form_message'); ?></label>
							<textarea name="message" id="message_contact"
								placeholder="<?php echo $this->lang->line('form_message_placeholder'); ?>"
								required></textarea>
						</div>
						<button type="submit" style="background-color: #008b6a">
							<?php echo $this->lang->line('form_submit'); ?>
						</button>
					</form>
				</div>
			</div>
		</section>

		<?php include('v1_modal_login.php'); ?>

		<?php include('v1_footer.php'); ?>

	</main>

</body>

</html>