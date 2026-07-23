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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
	</head>

	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #ffffffff 30%, #182540 100%);">
		<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #ffffffff 30%, #182540 100%);">
			<?php include('v1_header_menu.php'); ?>
		</header>
	</header>



	<body>

	<?php include('v1_header_nav.php'); ?>

	<div class="wrapper">

		<div class="main" style="min-height:auto;" ondragstart="return false">

			<main class="content">


				<?php include('v1_racourci.php'); ?>
				<style>
					section{
						margin-left: 90px;
						margin-right: 10px;
					}
					.main {
						background: rgb(245, 249, 248);
					}
					.content {
						max-width: 100%;
					}
					#couvImg {
						transition: transform 0.3s;
					}

					#couvImg:hover {
						transform: scale(1.1);
						/*box-shadow: 1px 1px 2px grey, -1px -1px 2px grey;*/
						box-shadow: 10px 10px 5px #ccc;
					}

					.containerSo {
						position: relative;
					}

					/* Bottom right text */
					.text-block {
						position: absolute;
						color: white;
						top: 8px;
						left: 16px;
					}

					@import url('https://fonts.googleapis.com/css?family=Poppins:900i');

					/**************SVG****************/

					path.one {
						transition: 0.4s;
						transform: translateX(-60%);

						animation: color_anim 1s infinite 0.4s;
					}

					path.two {
						transition: 0.5s;
						transform: translateX(-30%);
					}

					path.three {
						animation: color_anim 1s infinite 0.2s;
					}

					path.one {
						transform: translateX(0%);
						animation: color_anim 1s infinite 0.6s;
					}

					path.two {
						transform: translateX(0%);
						animation: color_anim 1s infinite 0.4s;
					}

					/* SVG animations */

					@keyframes color_anim {
						0% {
							fill: white;
						}

						50% {
							fill: #FBC638;
						}

						100% {
							fill: white;
						}
					}

					@font-face {
						font-family: "League Spartan Black";
						src: url(/assets/TYPO/LeagueSpartan-Black.ttf) format("truetype");
					}

					@font-face {
						font-family: "League Spartan Regular";
						src: url(<?php echo base_url('assets/TYPO/LeagueSpartan-Regular.ttf'); ?>) format("truetype");
					}

					p {
						color: green;
					}

					.inactive {
						display: none;
					}

					.selected-figure {
						border: 3px green solid;
					}

					.block-images {
						text-align: center;
						background-color: lightgrey;
					}

					.image-figure {
						display: inline-block;
						width: 80px;
						height: 80px;
						padding: 5px;
						cursor: pointer;
					}



					.image-figure img {
						width:100%;
						height:100%;
					}

					.image-figure:hover {
						padding: 10px;
					}

					.btn-corriger{
						background-color: #86C4AF;
					}

					.btn-corriger:hover{
						background-color: rgba(9,138,99);
					}

					.rond {
						display: inline-flex;          /* Utiliser flexbox pour un meilleur alignement */
						align-items: center;           /* Aligner verticalement l'icône et le texte */
						justify-content: center;       /* Centrer horizontalement */
						height: 40px;                  /* Hauteur du cercle */
						background-color: #0077b5;     /* Couleur de fond (à personnaliser) */
						color: white;                  /* Couleur du texte */
						font-weight: bold;             /* Poids du texte */
						text-align: center;            /* Centrer le texte horizontalement */
						font-size: 14px;               /* Taille du texte */
						min-width: 40px;
						padding: 0 10px;               /* Laisser respirer le texte (ex: "Fig-") */
						white-space: nowrap;
						box-sizing: border-box;
					}

					.rond i {
						font-size: 15px;               /* Taille de l'icône */
						margin-right: 5px;             /* Espacement entre l'icône et le texte */
					}
					.Toastify {
						position: fixed !important;
						top: 50% !important;
						left: 50% !important;
						transform: translate(-50%, -50%) !important;
						z-index: 9999; /* Optionnel : assure que le toast soit bien au-dessus de tout autre élément */
					}

					.btn_app{
						border-radius: 10px;
						padding: 10px;
						font-size: 0.9em;
						text-align: center;
						cursor: pointer;
						transition: background-color 0.3s ease;
						display: flex;
						flex-direction: column;
						justify-content: center;
						align-items: center;
						border: 2px solid #182540;
						height: 35px;
						background-color: #182540;
						color: white !important;
						font-weight: bold;
					}

					.btn_app:hover, .btn_app.active {
						background-color: #2d5e51ff !important;
						border-color: #2d5e51ff !important;
					}

					/* Sélecteur de légende : libellé "Légende :" + deux boutons (style identique à Test / Résumé) */
					.legend-switch {
						gap: 12px !important;
						flex-wrap: wrap;
					}

					.legend-switch-label,
					.legend-switch-sep {
						color: #182540;
						font-weight: bold;
						font-size: 0.95em;
					}

					/* Fenêtre modale "Résumé" */
					.resume-modal-overlay {
						display: none;
						position: fixed;
						inset: 0;
						z-index: 10000;
						background: rgba(24, 37, 64, 0.55);
						justify-content: center;
						align-items: center;
						padding: 16px;
					}

					.resume-modal-box {
						background: #ffffff;
						border-radius: 12px;
						max-width: 420px;
						width: 100%;
						padding: 24px 24px 20px;
						box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
						position: relative;
						text-align: center;
					}

					.resume-modal-title {
						margin: 0 0 12px;
						color: #182540;
						font-weight: bold;
					}

					.resume-modal-body {
						margin: 0;
						color: #2d5e51ff;
						font-weight: bold;
						font-size: 1.05em;
					}

					.resume-modal-close {
						position: absolute;
						top: 8px;
						right: 12px;
						border: none;
						background: transparent;
						font-size: 1.6em;
						line-height: 1;
						color: #182540;
						cursor: pointer;
					}

					.ad-legend-item {
						display: flex;
						align-items: center;
						padding: 6px 0;
						margin-top: 1px;
						margin-right: 2px;
						margin-left: 1px;
					}

					/* Hôte du HTML autonome (Shadow DOM) : pleine largeur du bloc figure,
					   affiché par le JS uniquement en mode "Légende complète" */
					.atlas-html-host {
						display: none;
						width: 100%;
						height: 88vh;
						overflow: auto;
						background: #fff;
						margin-top: 10px;
					}

					.ad-legend-text {
						color: #182540;
						font-size: 14px;
						margin: 0;
						padding-left: 8px;
						white-space: normal;
					}
				</style>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<style>
					div.scroll-container {
						background-color: white;
						overflow: auto;
						white-space: nowrap;
						padding: 1px;
					}

					div.scroll-container img {
						padding: 1px;
					}
				</style>

				<section>
					<div class="content">
						<div class="row">
							<div class="col-sm-12 slider-container">

								<!-- Scrollable container with images -->
								<div class="scroll-container">
									<div class="block-images slider" id="imageSlider">
										<?php
										$compteurFigure = 0;
										foreach ($arrayFigures as $figure) {
											$class = ($compteurFigure === 0) ? "slider-image selected-figure" : "slider-image"; ?>
											<div class="image-figure">
												<img class="<?= $class ?>" src="data:image/png;base64,<?php print $figure['image'] ?>" onclick="afficheFigure(<?= $compteurFigure ?>)" alt="Image <?= $compteurFigure ?>" />
											</div>
											<?php
											$compteurFigure++;
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section>
					<!-- Div qui affichera le message du title -->
					<div id="toastMessage" style="display: none; position: absolute; z-index: 9999; background-color: #0077b5; color: white; padding: 10px; border-radius: 5px; max-width: 300px; box-sizing: border-box;">
					</div>

					<!-- Fenêtre modale "Résumé" (partagée par tous les boutons Résumé) -->
					<div id="resumeModal" class="resume-modal-overlay">
						<div class="resume-modal-box">
							<button type="button" class="resume-modal-close" aria-label="Close">&times;</button>
							<h3 class="resume-modal-title"><?php echo $this->lang->line('resume_btn'); ?></h3>
							<p class="resume-modal-body"><?php echo $this->lang->line('resume_soon'); ?></p>
						</div>
					</div>

					<?php $compteurFigure = 0;
					foreach ($arrayFigures as $figure) {
					if ($compteurFigure === 0) { 	?>

					<div class="content block-figure">
						<?php } else { ?>
						<div class="content block-figure inactive">
							<?php } $compteurFigure++; ?>

							<div class="row">
								<div class="col-sm-4 legend-switch" style="margin-top: 20px; display: flex;justify-content: center; align-items: center;">
									<!-- Phrase : "Légende : Complète / Séquentielle" — les mots réutilisent les boutons de mode existants -->
									<span class="legend-switch-label"><?php echo $this->lang->line('legend_label'); ?></span>
									<button class="btn-info btn_app adMode" type="button"><?php echo $this->lang->line('legend_opt_complete'); ?></button>
									<span class="legend-switch-sep">/</span>
									<button class="btn-info btn_app restoreNormalMode" id="btnAscensionPedagogique" type="button"><?php echo $this->lang->line('legend_opt_sequential'); ?></button>
								</div>


								<div class="col-sm-4" style="display:flex; justify-content:center; align-items:center;display: flex;flex-direction: column;align-items: flex-start;/*! gap: 10px; */">
									<?php if(isset($figure['pathAudio']) && $figure['pathAudio']) { ?>
										<span style="width: 100%;text-align: center;color: #1d3557;font-weight: bold;"><?php echo $this->lang->line('sidebar_as_tooltip'); ?></span>
										<audio style="padding-right: 1rem;width: 100%;" width="100%" height="auto" controls id="<?php echo 'audio'. $compteurFigure; ?>" allow="autoplay"
											   onplay="handleAudioPlay(<?php echo $compteurFigure; ?>)"  oncontextmenu="return false;"  controlsList="nodownload">
											<source src="<?php echo base_url() .'uploads/'. $figure['pathAudio']; ?>" type="audio/mp3">
										</audio>

										<?php if($compteurFigure == 1) { ?>
											<button style="visibility:hidden; height:0px; width:0px; padding:0px;" id="buttonPlayAudioId" onclick="document.getElementById('audio1').play()"></button>
										<?php } ?>

									<?php } ?>
								</div>

								<div class="col-sm-4" style="margin-top:20px; display:flex; justify-content:center; align-items:center; gap: 20px;">
									<button class="btn-info btn_app beginTest"><?php echo $this->lang->line('legend_test'); ?></button>
									<button class="btn-info btn_app resumeBtn" type="button"><?php echo $this->lang->line('resume_btn'); ?></button>
								</div>

							</div>

							<!-- Figure HTML autonome : rendue dans un Shadow DOM dans les 3 modes
							     (remplace les rangées classiques) ; chargée à la demande via atlasFigureHtml -->
							<div class="atlas-html-host" data-idfig="<?= (int) $figure['idFigure']; ?>" data-hashtml="<?= !empty($figure['hasHtml']) ? '1' : '0'; ?>"></div>

							<div class="row atlas-classic-row">
								<div class="col-sm-3" style="padding-left: 30px;">
									<?php $compteurEssai = 0;
									$compteurReponse = 0;
									foreach ($figure['textGauche'] as $itemBlock) { ?>

										<div class="row legend-group-row" style="margin-top:10px; position:relative; padding-left:1px;">
											<hr>
											<button style="padding:0px; right:0px; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-gauche" id="btn-corriger-<?php echo $compteurFigure; ?>" onclick="afficheReponseBlock(event,true)">
												<?php echo $this->lang->line('decouv_respons'); ?>
											</button>
											<div class="scroll-container">
												<?php
												$compteur = 0;
												foreach ($itemBlock as $item) {
													$compteurEssai++;
													$compteur++;
													$badgeNum = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $m) ? $m[1] : (isset($item['numero']) ? $item['numero'] : $compteurEssai); ?>
													<div class="row legend-row-test" style="margin-top:1px;margin-right: 2px;margin-left: 1px;">

														<div class="col-6 text_saisie_gauche" style="display: none;width: auto;">

															<div style="display: none; flex-direction: row; flex-wrap: nowrap; padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
    														<span class="rond" data-title="<?= $item['mot']; ?>" onclick="showToast(this)">
        														<i class="fas fa-eye"></i> <?= $compteurEssai; ?>
    														</span>

																<textarea style="width: 100%;" rows="1" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
															</div>

														</div>

														<div class="col-6 text_response" style="width: auto;">
															<p><?= $item['mot']; ?></p>
														</div>

													</div>
												<?php } ?>
											</div>

										</div>

									<?php }

									// AD mode: render all left-side legends as one continuous flat block
									$adCounterL = 0;
									?>
									<div class="ad-legend-block ad-legend-block-left" style="display:none;">
										<?php foreach ($figure['textGauche'] as $itemBlock) {
											foreach ($itemBlock as $item) {
												$adCounterL++;
												$adBadgeL = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $mL) ? $mL[1] : (isset($item['numero']) ? $item['numero'] : $adCounterL); ?>
												<div class="ad-legend-item">
													<span class="rond"><?= $adBadgeL; ?></span>
													<p class="ad-legend-text"><?= $item['mot']; ?></p>
												</div>
											<?php }
										} ?>
									</div>
								</div>
								<div class="col-sm-6" style="position:relative; padding-top:10px;padding-right: 10px;">
									<img style="display:block;margin:auto; max-width:100%;border-left:2px solid #d0d2d4; border-right:2px solid #d0d2d4;" src="data:image/png;base64,<?php print $figure['image'] ?> "></img>
								</div>
								<div class="col-sm-3" style="padding-right: 30px;">
									<?php
									foreach ($figure['textDroite'] as $itemBlock) { ?>
										<div class="row legend-group-row" style="margin-top:10px; position:relative;padding-left: 25px;">
											<hr>

											<button style="padding:0px; left:0px; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-droite" onclick="afficheReponseBlock(event,true)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>

											<div class="col-12">
												<?php
												$compteur = 0;
												foreach ($itemBlock as $item) {
													$compteurEssai++;
													$compteur++;
													$badgeNum = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $m) ? $m[1] : (isset($item['numero']) ? $item['numero'] : $compteurEssai); ?>
													<div class="row legend-row-test" style="margin-top:1px; padding-right:0px;">

														<div class="col-6 text_response" style="width: auto;">
															<p><?= $item['mot']; ?></p>
														</div>

														<div class="col-6" style="padding-left: inherit;width: 100%;">

															<div style="display: none; flex-direction: row; flex-wrap: nowrap; padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
															<span class="rond" data-title="<?= $item['mot']; ?>" onclick="showToast(this)">
        														<i class="fas fa-eye"></i> <?= $compteurEssai; ?>
    														</span>
																<textarea style="width: 100%" rows="1" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
															</div>

														</div>

													</div>
												<?php } ?>
											</div>

										</div>

									<?php }

									// AD mode: render all right-side legends as one continuous flat block
									$adCounterR = 0;
									?>
									<div class="ad-legend-block ad-legend-block-right" style="display:none;">
										<?php foreach ($figure['textDroite'] as $itemBlock) {
											foreach ($itemBlock as $item) {
												$adCounterR++;
												$adBadgeR = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $mR) ? $mR[1] : (isset($item['numero']) ? $item['numero'] : $adCounterR); ?>
												<div class="ad-legend-item">
													<span class="rond"><?= $adBadgeR; ?></span>
													<p class="ad-legend-text"><?= $item['mot']; ?></p>
												</div>
											<?php }
										} ?>
									</div>
								</div>

							</div>

							<div class="row atlas-classic-row">
								<div class="col-sm-6" style="margin:20px; margin-left:auto; margin-right:auto;">
									<div class="row" style="margin-right: 0rem; margin-left: 1rem;">
										<div class="col-12" style="position:relative; padding-left:0px; padding-right:0px; margin-bottom:5px;">

											<div style="display: none; flex-direction: row; flex-wrap: nowrap; padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
											<span class="rond" data-title="<?= $figure['titre']; ?>" onclick="showToast(this)">
        									<i class="fas fa-eye"></i> Fig-
    									</span>
												<textarea rows="1" cols="33" class="form-control form-control-lg text_titre"
														  style="display: none;"
														  type="text" name="FR_textGauche" placeholder=""></textarea>
											</div>

											<br>
										</div>

										<div class="col-12 bloc_titre" style="position:relative; padding-left:0px; padding-right:0px; min-height:30px;" >

											<button style="padding:0px; float:right; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-titre" onclick="afficheReponseBlock(event,true)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>

											<span style="color:green;"><?= $figure['titre']; ?></span>
										</div>

										<?php
										$figBadge = preg_match('/^\s*Fig\s*\.?\s*(\d+)/i', $figure['titre'], $mF) ? $mF[1] : 'Fig';
										?>
										<div class="col-12 ad-figure-title" style="display:none; padding-left:0px; padding-right:0px;">
											<div class="ad-legend-item">
												<span class="rond"><?= $figBadge; ?></span>
												<p class="ad-legend-text" style="color:black; font-weight:bold;"><?= $figure['titre']; ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<hr>

						</div>
						<?php } ?>
				</section>

			</main>
		</div>
	</div>

	<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/zoomove.min.js"></script>

	<script src="<?php echo HTTP_JS; ?>jquery-validate/jquery.validate.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

	<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>

	<script>

        function showToast(element) {
            // Récupère le contenu du titre à partir de l'élément cliqué
            var titleContent = element.getAttribute('data-title');

            // Récupère la position du span cliqué avec getBoundingClientRect
            var spanRect = element.getBoundingClientRect();

            // Trouve la div du toast (message à afficher)
            var toastDiv = document.getElementById('toastMessage');

            // Place la div toast à la position du span cliqué
            toastDiv.style.top = (spanRect.top + window.scrollY ) + 'px';  // Un peu au-dessus du span
            toastDiv.style.left = (spanRect.left + window.scrollX + 44) + 'px';     // Juste à droite du span

            // Affiche le contenu du toast
            toastDiv.textContent =  titleContent;

            // Affiche la div (au lieu d'un toast classique)
            toastDiv.style.display = 'block';

            // Masquer le toast après 3 secondes
            setTimeout(function() {
                toastDiv.style.display = 'none';
            }, 5000); // Masque après 3 secondes
        }

        // Function to switch to AD mode (legends-only view, same page)
        var adButtons = document.querySelectorAll('.adMode');
        adButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Manage active states
                document.querySelectorAll('.btn_app').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Hide the existing grouped legend rows (with hr separators and overlay buttons)
                var legendGroupRows = document.getElementsByClassName('legend-group-row');
                for (let row of legendGroupRows) {
                    row.style.display = 'none';
                }

                // Hide title textarea
                var correctionButtonsTT = document.getElementsByClassName('text_titre');
                for (let j = 0; j < correctionButtonsTT.length; j++) {
                    correctionButtonsTT[j].style.display = 'none';
                }

                // Hide the btn-titre overlay so only the green title text shows
                var correctionButtonsT = document.getElementsByClassName('btn-titre');
                for (let btn of correctionButtonsT) {
                    btn.style.display = 'none';
                }

                // Hide the original bloc_titre (replaced in AD mode by ad-figure-title)
                var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
                for (let btn of correctionButtonsBT) {
                    btn.style.display = 'none';
                }

                // Hide the Fig- badge / textarea row in AD mode
                var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
                for (let div of textGaucheDrDivs) {
                    div.style.display = 'none';
                }

                // Show AD-mode flat legend blocks (one per side per figure)
                var adBlocks = document.getElementsByClassName('ad-legend-block');
                for (let div of adBlocks) {
                    div.style.display = 'block';
                }

                // Show AD-mode figure title (harmonized with .ad-legend-item)
                var adFigTitles = document.getElementsByClassName('ad-figure-title');
                for (let div of adFigTitles) {
                    div.style.display = 'block';
                }
            });
        });

        // Function to restore normal mode (Ascension pédagogique)
        var restoreButtons = document.querySelectorAll('.restoreNormalMode');
        restoreButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Manage active states
                document.querySelectorAll('.btn_app').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Hide AD-mode flat legend blocks
                var adBlocks = document.getElementsByClassName('ad-legend-block');
                for (let div of adBlocks) {
                    div.style.display = 'none';
                }

                // Hide AD-mode figure title
                var adFigTitles = document.getElementsByClassName('ad-figure-title');
                for (let div of adFigTitles) {
                    div.style.display = 'none';
                }

                // Restore the grouped legend rows
                var legendGroupRows = document.getElementsByClassName('legend-group-row');
                for (let row of legendGroupRows) {
                    row.style.display = '';
                }

                // Hide text input fields
                var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
                for (let sais of text_saisie_gauche) {
                    sais.style.display = 'none';
                }

                // Show all correction buttons gauche
                var btnGaucheButtons = document.getElementsByClassName('btn-gauche');
                for (let btn of btnGaucheButtons) {
                    btn.style = "padding: 0px;\n" +
                        "  right: 0px;\n" +
                        "  position: absolute;\n" +
                        "  width: 100%;\n" +
                        "  color: green;\n" +
                        "  height: 100%;";
                }

                // Show all correction buttons droite
                var correctionButtonsD = document.getElementsByClassName('btn-droite');
                for (let btn of correctionButtonsD) {
                    btn.style = "padding: 0px;\n" +
                        "  left: 0px;\n" +
                        "  position: absolute;\n" +
                        "  width: 100%;\n" +
                        "  color: green;\n" +
                        "  height: 100%;";
                }

                // Hide textGauche divs
                var textGaucheDivs = document.getElementsByClassName('textGauche');
                for (let div of textGaucheDivs) {
                    div.style.visibility = 'hidden';
                }

                // Show text responses
                var textResponses = document.getElementsByClassName('text_response');
                for (let div of textResponses) {
                    div.style.display = 'flex';
                }

                // Hide textGaucheCoteDroite
                var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
                for (let div of textGaucheDrDivs) {
                    div.style.display = 'none';
                }

                // Hide text_titre
                var correctionButtonsTT = document.getElementsByClassName('text_titre');
                for (let j = 0; j < correctionButtonsTT.length; j++) {
                    correctionButtonsTT[j].style.display = 'none';
                }

                // Show bloc_titre
                var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
                for (let btn of correctionButtonsBT) {
                    btn.style.display = 'flex';
                }

                // Show titre button
                var correctionButtonsT = document.getElementsByClassName('btn-titre');
                for (let j = 0; j < correctionButtonsT.length; j++) {
                    correctionButtonsT[j].style = "padding: 0px;\n" +
                        " float: right;\n" +
                        "  position: absolute;\n" +
                        "  width: 100%;\n" +
                        "  height: 100%;\n" ;
                }
            });
        });


        // Function triggered by clicking the "Begin Test" button
        // Select all buttons with the class 'beginTest'
        var testButtons = document.querySelectorAll('.beginTest');

        // Loop through each button and add an event listener
        testButtons.forEach(function(button) {
            button.addEventListener('click', function() {
				// Manage active states
				document.querySelectorAll('.btn_app').forEach(b => b.classList.remove('active'));
				this.classList.add('active');

                // Hide AD-mode flat legend blocks
                var adBlocks = document.getElementsByClassName('ad-legend-block');
                for (let div of adBlocks) {
                    div.style.display = 'none';
                }

                // Hide AD-mode figure title
                var adFigTitles = document.getElementsByClassName('ad-figure-title');
                for (let div of adFigTitles) {
                    div.style.display = 'none';
                }

                // Restore the grouped legend rows
                var legendGroupRows = document.getElementsByClassName('legend-group-row');
                for (let row of legendGroupRows) {
                    row.style.display = '';
                }

                var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
                for (let sais of text_saisie_gauche) {
                    sais.style.display = 'flex';
                }

                // 1. Hide all buttons with class 'btn-gauche'
                var btnGaucheButtons = document.getElementsByClassName('btn-gauche');
                for (let btn of btnGaucheButtons) {
                    btn.style.display = 'none';
                }

                var correctionButtonsD = document.getElementsByClassName('btn-droite');
                // Mettre tous les boutons de correction sur display: none
                for (let btn of correctionButtonsD) {
                    btn.style.display = 'none';
                }

                // 2. Show all divs with class 'textGauche'
                var textGaucheDivs = document.getElementsByClassName('textGauche');
                for (let div of textGaucheDivs) {
                    div.style.visibility = 'visible';
                }

                var textResponses = document.getElementsByClassName('text_response');
                for (let div of textResponses) {
                    div.style.display = 'none'; // Hide all text responses
                }

                var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
                for (let div of textGaucheDrDivs) {
                    div.style.display = 'flex';
                    div.style.flexWrap = "nowrap";
                }

                var correctionButtonsTT = document.getElementsByClassName('text_titre');
                // Display all correction buttons
                for (let j = 0; j < correctionButtonsTT.length; j++) {
                    correctionButtonsTT[j].style.display = 'flex';
                }

                var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
                // Hide all bloc_titre buttons
                for (let btn of correctionButtonsBT) {
                    btn.style.display = 'none';
                }

                // Additional logic can go here, for example, to trigger other actions or animations
            });
        });

        // Mode par défaut : "Légende complète". Active le mode et met le mot "Complète" en vert (actif),
        // "Séquentielle" en bleu marine. Les boutons "Complète" / "Séquentielle" gardent leur propre
        // gestionnaire de clic (anciens boutons adMode / restoreNormalMode), le comportement est inchangé.
        function activateLegendComplete() {
            var adBtn = document.querySelector('.adMode');
            if (adBtn) adBtn.click(); // applique le mode "Légende complète" et gère les classes .active
            // Reflète l'état actif sur toutes les figures (les blocs masqués n'ont aucun effet visuel)
            document.querySelectorAll('.adMode').forEach(function(b) { b.classList.add('active'); });
            document.querySelectorAll('.restoreNormalMode').forEach(function(b) { b.classList.remove('active'); });
        }

        // Bouton "Résumé" : ouvre la fenêtre modale (contenu bientôt disponible)
        (function () {
            var modal = document.getElementById('resumeModal');
            if (!modal) return;
            function openModal() { modal.style.display = 'flex'; }
            function closeModal() { modal.style.display = 'none'; }
            document.querySelectorAll('.resumeBtn').forEach(function(b) {
                b.addEventListener('click', openModal);
            });
            var closeBtn = modal.querySelector('.resume-modal-close');
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
            document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
        })();


        var afficheFigure = function(position) {

            var audio_path = null;
            var figures = document.getElementsByClassName('block-figure');
            var buttons = document.getElementsByClassName('image-figure');
            for(let i = 0; i < figures.length; i++){
                if(i == position){
                    figures[i].classList.remove("inactive");
                    buttons[i].setAttribute("class", "image-figure selected-figure");
                    let audio = document.getElementById('audio' + (i+1));
                    console.log("audio 2")
                    console.log(audio)
                    audio_path = audio;
                    // if (audio) audio.play();  // Play the audio
                }else{
                    figures[i].classList.add("inactive");
                    buttons[i].setAttribute("class", "image-figure");
                    let audio = document.getElementById('audio' + (i+1));
                    if (audio) {
                        audio.pause();         // Pause the audio
                        audio.currentTime = 0; // Reset the audio to the beginning
                    }
                }
            }

            // Au changement de figure, on revient au mode par défaut "Légende complète"
            activateLegendComplete();
        }

        var afficheReponseBlock = function(event,isHide) {

            if(isHide=='1'){
                event.target.setAttribute("style", "display:none;")
                var textResponses = document.getElementsByClassName('text_response');
                for (let div of textResponses) {
                    div.style.display =  'block'; // Show if 'show' is true, otherwise hide
                }

            }else{
                event.target.setAttribute("style", "display:block;")
            }

        }

        var afficheReponse = function(posInitiale, size, direction) {

            var idButton = "button" + direction + posInitiale + "-" + size

            var button = document.getElementById("button" + direction + posInitiale + "-" + size);
            button.setAttribute("style", "display:none;")

            for (let numero = posInitiale; numero < (size + posInitiale); numero++) {
                var proposition = document.getElementById("proposition" + direction + numero);
                var reponse = document.getElementById("reponse" + direction + numero);

                console.log(proposition.value);

                var allTextReponse = reponse.textContent;
                var posEspace = allTextReponse.indexOf(" ");
                var textReponse = allTextReponse.substring(posEspace + 1);

                reponse.textContent = reponse.textContent
                reponse.setAttribute("style", "color:green;")

                /*if(textReponse == proposition.value){
				   reponse.textContent = "(Vrai) " + reponse.textContent
				   reponse.setAttribute("style","color:green;")
				}else{
				   reponse.textContent = "(Faux) " + reponse.textContent
				   reponse.setAttribute("style","color:red;")
				}*/
            }
        }

        window.onload = function() {
            // Mode par défaut au chargement : "Légende complète"
            activateLegendComplete();

            // playAudio();
            // setTimeout(function() {
            //     let firstButtonPlayAudio = document.getElementById('buttonPlayAudioId')
            //     if(firstButtonPlayAudio) firstButtonPlayAudio.click()
            // }, 3000);  // Delay set to 1000 milliseconds (1 second)
        };

        function playAudio() {
            setTimeout(function() {
                let firstButtonPlayAudio = document.getElementById('buttonPlayAudioId')
                if(firstButtonPlayAudio) firstButtonPlayAudio.click()
            }, 3000);  // Delay set to 1000 milliseconds (1 second)
        }

        /* ═════════ Figures HTML autonomes (Shadow DOM) — même principe que livreCours ═════════
           Si la figure a un HTML, les 3 modes s'appuient dessus : les rangées classiques
           (légendes texte + image + titre) sont remplacées par le HTML complet, rendu dans
           un Shadow DOM (isolation CSS totale). Clic légende/marqueur N → tous les éléments
           data-num=N en rouge.

           Mode "Séquentielle" : comportement IDENTIQUE aux figures classiques
           (.legend-group-row + .btn-corriger) — les légendes sont découpées en groupes de 4
           et CHAQUE groupe est recouvert de SON bouton "Découvrir la réponse". Tous les
           boutons sont affichés en même temps : un clic ne dévoile que son groupe, dans
           l'ordre voulu par l'utilisateur. Aucun parcours pas-à-pas, aucun compteur.
           Sur un HTML multi-images, le découpage par 4 REPART À ZÉRO à chaque titre :
           un groupe n'est jamais à cheval sur deux images.

           Mode "Test" : identique au test classique — les masques disparaissent et TOUTES
           les légendes reçoivent d'un coup badge + œil (réponse en toast) + champ de saisie.

           Si le HTML ne porte aucune légende data-num, ces deux modes retombent sur les
           rangées classiques (aucune page cassée). */

        var ATLAS_HTML_URL = "<?php echo base_url(); ?>home/atlasFigureHtml/";
        var ATLAS_BLOCK_SIZE = 4;   // nombre de réponses par groupe masqué
        var ATLAS_REVEAL_LABEL = <?php echo json_encode($this->lang->line('decouv_respons')); ?>;

        // Styles de base injectés dans chaque Shadow DOM : surlignage rouge (contrat data-num)
        var ATLAS_SHADOW_STYLE = ':host{display:block;width:100%;height:100%;}'
            + 'img,svg{max-width:100%;height:auto;}'
            + '[data-num]{cursor:pointer;}'
            + '.marker-num{transition:fill 200ms;}'
            + '.marker-arrow{transition:stroke 200ms,stroke-width 200ms;vector-effect:non-scaling-stroke;}'
            + '.marker-num.active{fill:#d62828 !important;font-weight:900 !important;}'
            + '.marker-arrow.active{stroke:#d62828 !important;stroke-width:2.5px !important;vector-effect:non-scaling-stroke;}'
            + '.legend-item.active,.aa-legend-item.active{background:#fee2e2;}'
            + '.legend-item.active .leg-badge,.aa-legend-item.active .aa-badge{background:#d62828;}'
            + 'text[data-num].active,tspan[data-num].active{fill:#d62828 !important;font-weight:900 !important;}'
            + 'line[data-num].active,path[data-num].active,polyline[data-num].active,circle[data-num].active{stroke:#d62828 !important;stroke-width:2.5px !important;}'
            + 'li[data-num].active,span[data-num].active,div[data-num].active,td[data-num].active{background:#fee2e2;color:#d62828;}';

        // Surcharges de mise en page (injectées APRÈS le style de l'export, donc gagnantes) :
        // pleine hauteur, légendes aux extrémités, figure maximale (boîte SVG = toute la cellule)
        var ATLAS_SHADOW_LAYOUT = '.aa-root{height:100%;}'
            + '@container (min-width:621px){'
            + '.aa-layout{height:100%;gap:6px;grid-template-columns:minmax(160px,24%) minmax(0,1fr) minmax(160px,24%);}'
            + '.aa-side{position:relative;overflow:hidden;}'
            + '.aa-svg-host{align-items:center;}'
            + '.aa-svg-host svg{width:100% !important;height:100% !important;max-width:100% !important;max-height:100% !important;}'
            + '.aa-viewer{padding:4px;}'
            + '.aa-legend-item{font-size:14px;padding:7px 8px;}'
            + '.aa-badge{min-width:24px;height:24px;font-size:12px;}'
            + '.aa-title{font-size:16px;}'
            + '.aa-subtitle{font-size:13.5px;}'
            + '.aa-roman-item{font-size:13px;}'
            + '.aa-roman-children li{font-size:12px;}'
            + '}';

        // Styles des modes "Séquentielle" / "Test" : n'ajoutent que des classes atlas-*.
        // Aucune couleur ni typographie de l'export n'est redéfinie : le bouton est un
        // CALQUE posé au-dessus du groupe (comme .btn-corriger sur .legend-group-row en
        // classique) et le texte-réponse est masqué par visibility (la place est conservée,
        // la mise en page de l'export ne bouge pas).
        var ATLAS_SHADOW_REVEAL = '.atlas-group{position:relative;display:block;list-style:none;margin:0;padding:0;}'
            + '.atlas-reveal{display:none;position:absolute;top:0;left:0;width:100%;height:100%;z-index:5;'
            + 'padding:0;border:none;border-radius:6px;font:inherit;font-weight:700;cursor:pointer;'
            + 'background:#86C4AF;color:green;}'
            + '.atlas-reveal:hover{background:rgb(9,138,99);color:#fff;}'
            + '.atlas-group-covered > .atlas-reveal{display:block;}'
            + '.atlas-item-hidden > .atlas-answer{visibility:hidden;}'
            + '.atlas-test-input{display:none;align-items:center;gap:4px;margin-left:4px;flex:1 1 auto;min-width:70px;}'
            + '.atlas-item-input > .atlas-answer{display:none;}'
            + '.atlas-item-input .atlas-test-input{display:inline-flex;}'
            + '.atlas-test-input input{width:100%;min-width:60px;box-sizing:border-box;font:inherit;'
            + 'padding:1px 4px;border:1px solid #9ca3af;border-radius:4px;background:#fff;}'
            + '.atlas-eye{cursor:pointer;font-size:13px;line-height:1;user-select:none;}';

        /* ───────── Analyse du HTML : images, titres, découpage des légendes par 4 ───────── */

        var ATLAS_TITLE_SEL = '.titre-figure, .aa-title, .aa-subtitle, figcaption, h1, h2, h3, h4';
        var ATLAS_BADGE_SEL = '.leg-badge, .aa-badge, .rond, [class*="badge"]';

        function atlasIsHiddenEl(el) {
            return /display\s*:\s*none/i.test(el.getAttribute('style') || '');
        }

        // Index d'ordre du document : sert au tri et au rattachement de repli
        function atlasIndexAll(root) {
            var i = 0;
            Array.prototype.forEach.call(root.querySelectorAll('*'), function (el) { el._atlasIdx = i++; });
        }

        function atlasDocOrder(a, b) { return (a._atlasIdx || 0) - (b._atlasIdx || 0); }

        // Panneaux "image" visibles : <svg> et <img> non masquées. L'<img> de miniature du
        // contrat porte style="display:none" et ne compte donc pas comme une image.
        function atlasVisiblePanels(root) {
            var out = [];
            Array.prototype.forEach.call(root.querySelectorAll('svg, img'), function (el) {
                if (el.parentElement && el.parentElement.closest('svg')) return; // imbriqué dans un schéma
                if (atlasIsHiddenEl(el)) return;
                out.push(el);
            });
            return out;
        }

        // Items de légende : porteurs de data-num situés HORS du schéma SVG (les marqueurs
        // restent toujours visibles : ce sont les questions) et non imbriqués dans un autre porteur.
        function atlasLegendItems(root) {
            return Array.prototype.slice.call(root.querySelectorAll('[data-num]')).filter(function (el) {
                if (el.closest('svg')) return false;
                var p = el.parentElement;
                while (p) {
                    if (p.hasAttribute && p.hasAttribute('data-num')) return false;
                    p = p.parentElement;
                }
                return true;
            });
        }

        function atlasTitleIn(scope) {
            var el = scope.querySelector(ATLAS_TITLE_SEL);
            return el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '';
        }

        // Libellé d'un groupe déclaré par data-fig : on ne remonte pas l'arbre (le premier
        // titre trouvé serait celui de l'image 1) — le titre doit lui aussi porter data-fig.
        function atlasLabelForFig(root, key, index) {
            var sel = ATLAS_TITLE_SEL.split(',').map(function (s) {
                return s.trim() + '[data-fig="' + key + '"]';
            }).join(', ');
            var el = root.querySelector(sel);
            return el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : ('#' + (index + 1));
        }

        // Plus grand ancêtre d'un panneau ne contenant aucun autre panneau : la "section" de l'image
        function atlasScopeFor(panel, panels) {
            var node = panel;
            while (node.parentElement) {
                var parent = node.parentElement, n = 0;
                for (var i = 0; i < panels.length; i++) if (parent.contains(panels[i])) n++;
                if (n > 1) break;
                node = parent;
            }
            return node;
        }

        // Rattachement légendes ↔ image, du plus fiable au repli (cf. plan §2.2)
        function atlasBuildGroups(root) {
            var items = atlasLegendItems(root);
            if (!items.length) return [];

            // 1) Contrat explicite data-fig : rattachement sans ambiguïté
            var tagged = items.filter(function (el) { return el.hasAttribute('data-fig'); });
            if (tagged.length === items.length) {
                var order = [], map = {};
                items.forEach(function (el) {
                    var k = el.getAttribute('data-fig');
                    if (!map[k]) { map[k] = { label: '', items: [] }; order.push(k); }
                    map[k].items.push(el);
                });
                return order.map(function (k, i) {
                    map[k].label = atlasLabelForFig(root, k, i);
                    return map[k];
                });
            }

            var panels = atlasVisiblePanels(root);
            if (panels.length <= 1) {
                return [{ label: atlasTitleIn(root), items: items }];
            }

            // 2) Structure DOM : une section par image
            var scopes = panels.map(function (p) { return atlasScopeFor(p, panels); });
            var groups = scopes.map(function (sc, i) {
                return { label: atlasTitleIn(sc) || ('#' + (i + 1)), items: [] };
            });
            var orphans = [];
            items.forEach(function (it) {
                for (var i = 0; i < scopes.length; i++) {
                    if (scopes[i].contains(it)) { groups[i].items.push(it); return; }
                }
                orphans.push(it);
            });

            // 3) Repli : rattacher l'item au panneau le plus proche dans l'ordre du document
            orphans.forEach(function (it) {
                var best = 0, bestDist = Infinity;
                panels.forEach(function (p, i) {
                    var d = Math.abs((it._atlasIdx || 0) - (p._atlasIdx || 0));
                    if (d < bestDist) { bestDist = d; best = i; }
                });
                groups[best].items.push(it);
            });

            groups.forEach(function (g) { g.items.sort(atlasDocOrder); });
            return groups.filter(function (g) { return g.items.length; });
        }

        // Isole le texte-réponse dans un <span class="atlas-answer"> : le badge numéro reste
        // en place (il fait partie de la question), le HTML d'origine n'est pas dénaturé.
        function atlasWrapAnswer(item) {
            if (item._atlasAnswer) return item._atlasAnswer;
            var span = document.createElement('span');
            span.className = 'atlas-answer';
            Array.prototype.slice.call(item.childNodes).forEach(function (n) {
                if (n.nodeType === 1 && n.matches && n.matches(ATLAS_BADGE_SEL)) return; // garder le badge
                span.appendChild(n);
            });
            item.appendChild(span);
            item._atlasAnswer = span;
            item._atlasText = (span.textContent || '').replace(/\s+/g, ' ').trim();
            return span;
        }

        // Mode Test : champ de saisie + œil qui révèle la réponse en info-bulle (comme le test classique)
        function atlasEnsureInput(item) {
            if (item._atlasInput) return item._atlasInput;
            var wrap = document.createElement('span');
            wrap.className = 'atlas-test-input';

            var eye = document.createElement('span');
            eye.className = 'atlas-eye';
            eye.textContent = '👁';
            eye.setAttribute('data-title', item._atlasText || '');
            eye.addEventListener('click', function (e) {
                e.stopPropagation();
                if (typeof showToast === 'function') showToast(eye);
            });

            var input = document.createElement('input');
            input.type = 'text';
            input.setAttribute('autocomplete', 'off');
            input.addEventListener('click', function (e) { e.stopPropagation(); });

            wrap.appendChild(eye);
            wrap.appendChild(input);
            item.appendChild(wrap);
            item._atlasInput = wrap;
            return wrap;
        }

        function atlasChunk(items, size) {
            var out = [];
            for (var i = 0; i < items.length; i += size) out.push(items.slice(i, i + size));
            return out;
        }

        // Liste des groupes de 4, le découpage repartant à zéro à chaque titre d'image
        function atlasAnalyzeFigure(root) {
            atlasIndexAll(root);
            var groups = atlasBuildGroups(root);
            var blocks = [];
            groups.forEach(function (g, gi) {
                g.items.forEach(atlasWrapAnswer);
                atlasChunk(g.items, ATLAS_BLOCK_SIZE).forEach(function (chunkItems) {
                    blocks.push({ items: chunkItems, titleIndex: gi, title: g.label || '' });
                });
            });
            return { groups: groups, blocks: blocks, multi: groups.length > 1 };
        }

        /* ───────── Masques par groupe de 4 : un bouton par groupe, tous affichés ─────────
           Copie du fonctionnement classique : chaque groupe est enveloppé dans un
           .atlas-group (position:relative) recouvert d'un bouton « Découvrir la réponse ».
           Le clic masque CE bouton uniquement — les autres groupes restent couverts. */

        // Découpe les items d'un groupe en suites de frères contigus : un masque par suite
        // (un groupe dont les légendes ne se suivent pas dans le DOM reçoit plusieurs
        // masques, qui se lèvent ensemble puisqu'ils portent le même index de groupe).
        function atlasRuns(items) {
            var runs = [], cur = null;
            items.forEach(function (it) {
                var last = cur && cur.items[cur.items.length - 1];
                if (cur && it.parentElement === cur.parent && last.nextElementSibling === it) {
                    cur.items.push(it);
                    return;
                }
                cur = { parent: it.parentElement, items: [it] };
                runs.push(cur);
            });
            return runs;
        }

        // Enveloppe une suite d'items et pose son bouton-masque. Le conteneur reprend la
        // balise attendue par le parent (<li> dans une liste) pour ne pas casser le HTML.
        function atlasWrapRun(run, groupIndex) {
            var parent = run.parent;
            if (!parent) return null;
            var wrap = document.createElement(/^(UL|OL)$/.test(parent.tagName) ? 'li' : 'div');
            wrap.className = 'atlas-group';
            wrap.setAttribute('data-atlas-group', groupIndex);
            parent.insertBefore(wrap, run.items[0]);
            run.items.forEach(function (it) { wrap.appendChild(it); });

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'atlas-reveal';
            btn.textContent = ATLAS_REVEAL_LABEL;
            wrap.appendChild(btn);
            return wrap;
        }

        // Enveloppement effectué une seule fois par figure (à la 1re bascule Séquentielle/Test)
        function atlasEnsureGroups(host) {
            var a = host._analysis;
            if (!a || a.wrapped) return;
            a.blocks.forEach(function (blk, bi) {
                blk.wrappers = atlasRuns(blk.items)
                    .map(function (run) { return atlasWrapRun(run, bi); })
                    .filter(Boolean);
            });
            a.wrapped = true;
        }

        function atlasRender(host) {
            var a = host._analysis;
            if (!a) return;
            var mode = host._mode || 'complete';
            var revealed = host._revealed || (host._revealed = {});

            a.blocks.forEach(function (blk, bi) {
                // Séquentielle : groupe couvert tant qu'on n'a pas cliqué son bouton.
                // Test : aucun masque (les saisies remplacent les réponses, comme en classique).
                var covered = (mode === 'sequential') && !revealed[bi];
                blk.items.forEach(function (item) {
                    item.classList.remove('atlas-item-hidden', 'atlas-item-input');
                    if (covered) item.classList.add('atlas-item-hidden');
                    if (mode === 'test') {
                        atlasEnsureInput(item);
                        item.classList.add('atlas-item-input');
                    }
                });
                (blk.wrappers || []).forEach(function (w) {
                    w.classList.toggle('atlas-group-covered', covered);
                });
            });
        }

        // Clic sur un bouton-masque : ce groupe (et lui seul) se dévoile
        function atlasReveal(host, groupIndex) {
            if (!host._analysis) return;
            host._revealed = host._revealed || {};
            host._revealed[groupIndex] = true;
            atlasRender(host);
        }

        // Retour à l'état de départ : tous les groupes recouverts, saisies vidées
        function atlasResetProgress(host) {
            host._revealed = {};
            var a = host._analysis;
            if (!a) return;
            a.blocks.forEach(function (blk) {
                blk.items.forEach(function (item) {
                    if (!item._atlasInput) return;
                    var input = item._atlasInput.querySelector('input');
                    if (input) input.value = '';
                });
            });
        }

        function atlasGetShadow(host) {
            if (host._shadow) return host._shadow;
            host._shadow = host.attachShadow({ mode: 'open' });
            host._activeNum = null;
            // Écouteur délégué : bouton-masque → révélation de son groupe ; sinon clic sur
            // tout porteur de data-num → surlignage rouge ; re-clic → désactivation
            host._shadow.addEventListener('click', function (e) {
                var btn = e.target && e.target.closest ? e.target.closest('.atlas-reveal') : null;
                if (btn) {
                    atlasReveal(host, parseInt(btn.parentElement.getAttribute('data-atlas-group'), 10));
                    return;
                }
                var item = e.target && e.target.closest ? e.target.closest('[data-num]') : null;
                if (!item) return;
                var n = parseInt(item.getAttribute('data-num'), 10);
                if (isNaN(n)) return;
                host._activeNum = (host._activeNum === n) ? null : n;
                host._shadow.querySelectorAll('[data-num]').forEach(function (el) {
                    el.classList.toggle('active', parseInt(el.getAttribute('data-num'), 10) === host._activeNum);
                });
            });
            return host._shadow;
        }

        // Repli sur l'affichage classique (HTML indisponible ou inexploitable)
        function atlasFallbackToClassic(host) {
            host.style.display = 'none';
            var block = host.closest('.block-figure');
            if (block) {
                block.querySelectorAll('.atlas-classic-row').forEach(function (r) { r.style.display = ''; });
            }
        }

        function atlasLoadHtml(host, done) {
            if (host._loaded) { if (done) done(); return; }
            if (host._loading) { host._pending = done; return; }   // évite un double fetch
            host._loading = true;
            var sr = atlasGetShadow(host);
            sr.innerHTML = '<style>' + ATLAS_SHADOW_STYLE + '</style><div style="padding:20px;text-align:center;color:#9ca3af;font-style:italic;">Chargement…</div>';
            fetch(ATLAS_HTML_URL + host.dataset.idfig)
                .then(function (r) { if (!r.ok) throw new Error('html'); return r.text(); })
                .then(function (html) {
                    host._loaded = true;
                    host._loading = false;
                    host._activeNum = null;
                    // Le style de l'export est conservé tel quel ; les surcharges de mise en page
                    // et les styles des masques sont ajoutés APRÈS (ils ne touchent pas aux couleurs).
                    sr.innerHTML = '<style>' + ATLAS_SHADOW_STYLE + '</style>' + html
                        + '<style>' + ATLAS_SHADOW_LAYOUT + '</style>'
                        + '<style>' + ATLAS_SHADOW_REVEAL + '</style>';
                    host._analysis = atlasAnalyzeFigure(sr);
                    host._revealed = {};
                    if (done) done();
                    if (host._pending) { var p = host._pending; host._pending = null; p(); }
                })
                .catch(function () {
                    host._loading = false;
                    host._pending = null;
                    atlasFallbackToClassic(host);
                });
        }

        // Applique le mode courant à une figure dont le HTML est chargé
        function atlasApplyModeToHost(host) {
            var mode = host._mode || 'complete';
            var a = host._analysis;

            // Aucune légende data-num exploitable : Séquentielle / Test repassent au classique
            if (mode !== 'complete' && a && !a.blocks.length) {
                atlasFallbackToClassic(host);
                return;
            }

            var block = host.closest('.block-figure');
            if (block) block.querySelectorAll('.atlas-classic-row').forEach(function (r) { r.style.display = 'none'; });
            host.style.display = 'block';
            // Les groupes ne sont enveloppés qu'au premier passage en Séquentielle / Test :
            // en mode Complète, le HTML de l'export reste strictement intact.
            if (mode !== 'complete') atlasEnsureGroups(host);
            atlasResetProgress(host);   // changement de mode → tous les groupes recouverts
            atlasRender(host);
        }

        // mode ∈ {'complete', 'sequential', 'test'} — tout changement de mode remet les masques
        function atlasApplyHtmlMode(mode) {
            document.querySelectorAll('.block-figure').forEach(function (block) {
                var host = block.querySelector('.atlas-html-host');
                if (!host || host.dataset.hashtml !== '1') return; // figure classique : rien à faire
                host._mode = mode;
                host._revealed = {};
                block.querySelectorAll('.atlas-classic-row').forEach(function (r) { r.style.display = 'none'; });
                host.style.display = 'block';
                // Chargement à la demande : seulement la figure actuellement visible
                if (block.classList.contains('inactive')) return;
                atlasLoadHtml(host, function () { atlasApplyModeToHost(host); });
            });
        }

        // Branché APRÈS les gestionnaires existants (ordre d'exécution garanti) :
        // le comportement historique des modes s'applique d'abord (il ne concerne
        // visuellement que les figures sans HTML), puis l'aiguillage HTML
        document.querySelectorAll('.adMode').forEach(function (b) {
            b.addEventListener('click', function () { atlasApplyHtmlMode('complete'); });
        });
        document.querySelectorAll('.restoreNormalMode').forEach(function (b) {
            b.addEventListener('click', function () { atlasApplyHtmlMode('sequential'); });
        });
        document.querySelectorAll('.beginTest').forEach(function (b) {
            b.addEventListener('click', function () { atlasApplyHtmlMode('test'); });
        });

        // Fonction pour déclencher un clic sur le bouton lorsque l'audio commence à jouer
        function handleAudioPlay(compteurFigure) {
            // Sélectionner tous les boutons avec la classe `btn-corriger`
            var buttons = document.getElementsByClassName('btn-corriger');

            // // Itérer sur chaque bouton et simuler un clic
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].click();
            }

            var textResponses = document.getElementsByClassName('text_response');
            for (let div of textResponses) {
                div.style.display =  'flex'; // Show if 'show' is true, otherwise hide
            }

            var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
            // Mettre tous les boutons de correction sur display: block
            for (let btn of correctionButtonsBT) {
                btn.style.display = 'flex';
            }

            // 2. Show all divs with class 'textGauche'
            var textGaucheDivs = document.getElementsByClassName('textGauche');
            for (let div of textGaucheDivs) {
                div.style.visibility = 'hidden';
            }

            var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
            for (let div of textGaucheDrDivs) {
                div.style.display = 'none';
                div.style.flexWrap = "nowrap";
            }

            var correctionButtonsTT = document.getElementsByClassName('text_titre');
            // Display all correction buttons
            for (let j = 0; j < correctionButtonsTT.length; j++) {
                correctionButtonsTT[j].style.display = 'none';
            }

            var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
            for (let sais of text_saisie_gauche) {
                sais.style.display = 'none';
            }

            console.log('Audio is playing, all correction buttons clicked!'); // Log pour vérification
        }


	</script>

	</body>

	</html>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
