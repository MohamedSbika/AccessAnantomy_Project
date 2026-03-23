<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Access Anatomy</title>
	<!-- <link rel="stylesheet" href="styles.css"> -->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
	<link rel="stylesheet" href="<?= base_url('assets/css/v1_app.css') ?>">
	<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script> -->


	<!-- Swiper CSS -->
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
	<!-- Swiper JS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
	<style>
		body {
			font-family: 'Manrope', sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f5f5f5;
			color: white;
			overflow-x: hidden;
			/* Prevent horizontal scrolling */
			font-size: 12px;
		}

		.main {
			background: rgb(255, 255, 255);
		}

		label {
			color: black
		}

		footer.footer {
			padding: 1rem .875rem;
			direction: ltr;
			background: #fff;
			background-color: rgb(255, 255, 255);
			background-color: #073b3a;
			color: white;
			padding: 20px 50px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			flex-wrap: wrap;
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
			color: white;
		}

		h1 {
			font-weight: 600;
			/* Pour un titre plus bold */
		}

		h2 {
			font-weight: 500;
			/* Moins bold que h1 */
		}

		h3 {
			font-weight: 400;
			/* Poids normal pour h3 */
		}

		h4 {
			font-weight: 300;
			/* Poids normal pour h3 */
		}

		h5 {
			font-weight: 200;
			/* Poids normal pour h3 */
		}

		.top-bar {
			/*background: #0E2A47;*/
			color: white;
			padding: 10px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			/* Allows stacking on small screens */
		}

		.top-bar nav a {
			color: white;
			margin-left: 15px;
			text-decoration: none;
		}

		/* Sidebar (initially hidden) */
		.side-nav {
			position: fixed;
			top: 0;
			left: -250px;
			/* Hidden offscreen initially */
			width: 250px;
			height: 100%;
			background-color: #0E2A47;
			transition: 0.3s;
			/* Smooth transition */
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
			/* Hide by default */
			font-size: 30px;
			color: white;
			background: none;
			border: none;
			cursor: pointer;
		}

		/* Main navigation bar */
		.main-nav {
			background: white;
			color: #0E2A47;
			padding: 15px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			flex-wrap: wrap;
			width: 80%;
			margin-left: 5%;
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
			background: none;
			border: 2px solid white;
			padding: 10px 22px;
		}

		/* Media Queries for Mobile */
		@media (max-width: 768px) {
			.menu-btn {
				display: flex;
				position: absolute;
				top: 5px;
				left: 10px;
				width: 40px;
			}

			/* Sidebar navigation visible when toggled */
			.side-nav {
				padding-top: 80px;
			}
		}

		/* Adjust the layout for larger screens */
		@media (min-width: 769px) {
			.side-nav {
				display: none;
				/* Sidebar hidden by default on large screens */
			}

			.main-nav ul {
				display: flex;
			}
		}

		/* Show the toggle button on smaller screens */
		@media (max-width: 768px) {
			.menu-btn {
				display: flex;
				position: absolute;
				top: 5px;
				left: 10px;
			}

			.main-nav {
				display: none;
				/* Hide default nav on small screens */
			}

			.side-nav {
				padding-top: 80px;
				/* Adjust padding for mobile */
			}
		}

		/* Adjust main-nav for mobile */
		@media (min-width: 769px) {
			.main-nav ul {
				display: flex;
			}
		}


		.top-bar {
			/*background: #0E2A47;*/
			color: white;
			padding: 10px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			/* Allows stacking on small screens */
		}

		.top-bar nav a {
			color: white;
			margin-left: 15px;
			text-decoration: none;
		}

		.main-nav {
			background: white;
			color: #0E2A47;
			padding: 15px 5%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			flex-wrap: wrap;
			/* Wraps navigation items on small screens */
			border-radius: 10px;
			/* Ajoute des bords arrondis */
		}

		.main-nav ul {
			list-style: none;
			padding: 0;
			display: flex;
			flex-wrap: wrap;
		}

		.main-nav ul li a {
			color: #0E2A47;
			text-decoration: none;
			font-weight: bold;
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
			background: none;
			border: 2px solid white;
			padding: 10px 22px;
		}

		.hero {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 50px 5%;
			background: linear-gradient(135deg, #120E47 30%, #0c2d26e8 100%);
			flex-wrap: wrap;
			/* Allow elements to stack on small screens */
		}

		.hero-text {
			max-width: 45%;
			margin-left: 90px;
		}

		.hero-text h1 {
			font-size: 2.2em;
			font-weight: bold;
			line-height: 1.2;
		}

		.hero-text p {
			font-size: 1.2em;
			margin-bottom: 20px;
		}

		.buttons {
			display: flex;
			gap: 15px;
		}

		.hero-image img {
			max-width: 100%;
			border-radius: 12px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
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
				width: 100%;
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
				max-width: 100%;
				border-radius: 8px;
			}

			.hero-text p {
				line-height: 1.4;
				color: #120E47; 
				
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
	</style>

</head>
<style>
	input.error {
		border: 1px solid red;
	}

	.error {
		color: red;
	}
</style>

<body style="min-height: 0vh; overflow: auto; height:auto;">
	<main class="main">
		<div class="container d-flex flex-column">

			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="text-center mt-1">
						<a class="navbar-brand"
							href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
							<img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/mezidxlogo.jpg"
								style="width: 200px ; margin-top: -1em;">
						</a>
					</div>

					<div class="card">
						<div class="card-body" style="padding: 0.6rem;background-color: #14556d;">
							<div class="m-sm-6" style="margin: 1.5rem !important;">
								<form id="comptform" name="comptform" class="needs-validation" action="" method="post"
									novalidate="novalidate">
									<h2 class="text-center" style="color:black">
										<?php echo $this->lang->line('desc_cmpt'); ?><small
											style="color: #aaa8a8;">&nbsp;<br><b>*</b>&nbsp;&nbsp;<?php echo $this->lang->line('chmp_oblg'); ?></small>
									</h2>
									<hr>
									<div class="row">
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputName"><?php echo $this->lang->line('name'); ?>&nbsp;&nbsp;<b>*</b></label>
											<input type="text" name="inputName" class="form-control" required=""
												id="inputName" placeholder="">
										</div>
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputPren"><?php echo $this->lang->line('lastname'); ?>&nbsp;&nbsp;<b>*</b></label>
											<input type="text" name="inputPren" class="form-control" id="inputPren"
												placeholder="">
										</div>
									</div>

									<div class="row">
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputEmail"><?php echo $this->lang->line('email'); ?>&nbsp;&nbsp;<b>*</b></label>
											<input type="email" name="inputEmail" class="form-control" id="inputEmail"
												placeholder="">
										</div>
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputEmailCF"><?php echo $this->lang->line('email_conf'); ?></label>
											<input type="email" name="inputEmailCF" class="form-control"
												id="inputEmailCF" placeholder="">
										</div>
									</div>
									<div class="row">
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputPassword"><?php echo $this->lang->line('passwd'); ?>&nbsp;&nbsp;<b>*</b></label>
											<input type="password" name="inputPassword" class="form-control"
												id="inputPassword" placeholder="">
										</div>
										<div class="mb-2 col-md-6">
											<label class="form-label"
												for="inputPasswordCF"><?php echo $this->lang->line('password_conf'); ?></label>
											<input type="password" name="inputPasswordCF" class="form-control"
												id="inputPasswordCF" placeholder="">
										</div>
									</div>

									<div class="row">
										<div class="mb-2">
											<label class="form-label"
												for="inputAddress"><?php echo $this->lang->line('adresse1'); ?>&nbsp;&nbsp;</label>
											<input type="text" name="inputAddress" class="form-control"
												id="inputAddress" placeholder="">
										</div>
									</div>
									<div class="row">
										<div class="mb-3 col-md-4">
											<label class="form-label"
												for="inputState"><?php echo $this->lang->line('country'); ?>&nbsp;&nbsp;</label>
											<input type="text" name="inputState" class="form-control" id="inputState">
										</div>
										<div class="mb-3 col-md-5">
											<label class="form-label"
												for="inputCity"><?php echo $this->lang->line('city'); ?>&nbsp;&nbsp;</label>
											<input type="text" name="inputCity" class="form-control" id="inputCity">
										</div>
										<div class="mb-3 col-md-3">
											<label class="form-label"
												for="inputZip"><?php echo $this->lang->line('zipcd'); ?>&nbsp;&nbsp;</label>
											<input type="number" name="inputZip" class="form-control" id="inputZip">
										</div>
									</div>

									<div class="row">
										<hr>
										<h2 class="text-center" hidden>
											<?php echo $this->lang->line('inscrp_etab'); ?><small
												style="color: #aaa8a8;"></small>
										</h2>
										<hr>
										<div class="row justify-content-center mt-2 mb-2" hidden>
											<div class="mb-2 col-md-5">
												<label class="form-label" for="inputEtab"
													style="font-weight: bold"><?php echo $this->lang->line('name_etab'); ?></label>
											</div>
											<div class="mb-2 col-md-7">
												<select class="form-select" id="inputEtab" name="inputEtab">
													<option value="0"><?php echo $this->lang->line('choice_univ'); ?>
													</option>
													<?php foreach ($listEtab as $valEtab) { ?>
														<option value="<?php print $valEtab['IDEtablissement']; ?>">
															<?php print $valEtab['Libelle']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="row justify-content-center mt-2 mb-2" hidden>

											<div class="mb-2 col-md-6">
												<label class="form-label" for="inputProfess"
													style="font-weight: bold"><?php echo $this->lang->line('insc_catg'); ?></label>
											</div>
											<div class="mb-2 col-md-3">
												<label class="form-check">
													<input name="inputProfess" id="ProfessEtudiant"
														value="<?php echo $this->lang->line('choiceEtud'); ?>"
														type="radio" class="form-check-input" checked="">
													<span
														class="form-check-label"><?php echo $this->lang->line('choiceEtud'); ?></span>
												</label>
											</div>
											<div class="mb-2 col-md-3">
												<label class="form-check">
													<input name="inputProfess" id="ProfessEnseignant"
														value="<?php echo $this->lang->line('choiceEns'); ?>"
														type="radio" class="form-check-input">
													<span
														class="form-check-label"><?php echo $this->lang->line('choiceEns'); ?></span>
												</label>
											</div>
										</div>
										<div class="row justify-content-center mt-2 mb-2" hidden>
											<div class="mb-2 col-md-5">
												<label class="form-label" for="inputIDF"
													style="font-weight: bold">Identifiant</label>
											</div>
											<div class="mb-2 col-md-7">
												<input type="text" name="inputIDF" id="inputIDF" class="form-control"
													placeholder="">
											</div>
										</div>
										<label class="form-check" style="background-color: #f1eeff;">
											<span class="form-check-label">
												En fournissant des informations personnelles et en terminant cette
												procédure, vous acceptez les Conditions d'utilisation et la politique de
												Protection des données personnelles de Access
												Anatomy.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</span>
											<input class="form-check-input" type="checkbox" style="float: revert"
												name="inputLegal" id="inputLegal">
										</label>

										<?php echo $widget; ?>
										<?php echo $script; ?>

										<button type="submit" class="btn btn-primary">Valider</button>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</main>

	<?php
	include('v1_footer.php');
	?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script> -->
<script>
	$(document).ready(function () {

		$("body").on("contextmenu", function (e) {
			return false;
		});
		$('body').bind('cut copy', function (e) {
			e.preventDefault();
		});
		$('body').bind('cut copy', function (e) {
			e.preventDefault();
		});
		//* validation
		$('#comptform').validate({

			onkeyup: false,
			errorClass: 'error',
			validClass: 'valid',
			rules: {
				inputName: { required: true },
				inputPren: { required: true },
				//inputAddress: { required: true },
				//inputState: { required: true },
				//inputCity: { required: true },
				//inputZip: { required: true },
				inputEmail: { required: true },
				inputEmailCF: { required: true },
				inputPassword: { required: true },
				inputPasswordCF: { required: true },
				//inputIDF: { required: true },
			}, messages: {
				inputName: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				inputPren: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				//inputAddress: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				//inputState: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				//inputCity: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				//inputZip: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				inputEmail: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				inputEmailCF: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				inputPassword: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				inputPasswordCF: "<?php echo $this->lang->line('saisi_oblg'); ?>",
				//inputIDF: "<?php echo $this->lang->line('saisi_oblg'); ?>",
			}, highlight: function (element, errorClass, validClass) {
				$(element).removeClass(validClass).addClass(errorClass).
					next('label').removeAttr('data-success').attr('data-error', 'Incorrect!');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass(errorClass).addClass(validClass).
					next('label').removeAttr('data-error').attr('data-success', 'Correct!');
			},
			submitHandler: function () {

				Swal.fire({
					title: 'Création de compte',
					text: 'Envoie de demande en cours ..',
					onBeforeOpen: () => {
						Swal.showLoading()
					}
				})

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>home/compte_process",
					data: $('#comptform').serialize(),
					timeout: 30000,
					success: function (html) {
						console.log(html);
						Swal.close();
						var ar = JSON.parse(html);

						if (ar[0]["id"] == 1) {

							Swal.fire({
								position: 'center',
								type: 'success',
								title: 'Validation de compte' + ar[0]["desc"],
								text: 'Veuillez vérifier votre boîte de réception pour un courriel de confirmation, cliquez sur le lien pour valider votre inscription.',
								showConfirmButton: true
							}).then(function () {
								window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login';
							})
						} else {
							Swal.fire({
								position: 'center',
								type: 'error',
								title: ar[0]["desc"],
								showConfirmButton: true
							})
						}
						Swal.hideLoading();
					},
					error: function () {
						Swal.hideLoading();
					}
				});
				return false;
			}

		});

	});

</script>
</body>


</html>
