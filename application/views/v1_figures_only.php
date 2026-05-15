<?php if(strlen($this->session->userdata('passTok'))==200) { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Figures - Access Anatomy</title>

	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">

	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			background-color: #f5f9f8;
			font-family: 'Manrope', sans-serif;
		}

		.main-container {
			display: flex;
			width: 100%;
			gap: 0;
		}

		.figures-container {
			flex: 1;
			margin: 20px auto;
			padding: 20px;
			max-width: 1200px;
		}

		/* Top horizontal thumbnails strip — matches /listCalque */
		div.scroll-container {
			background-color: white;
			overflow: auto;
			white-space: nowrap;
			padding: 1px;
		}

		div.scroll-container img {
			padding: 1px;
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
			width: 100%;
			height: 100%;
		}

		.image-figure:hover {
			padding: 10px;
		}

		.selected-figure {
			border: 3px green solid;
		}

		/* Figure block */
		.block-figure {
			background: #ffffff;
			border-radius: 10px;
			padding: 20px;
			margin-top: 20px;
			box-shadow: 0 2px 10px rgba(24, 37, 64, 0.06);
		}

		.inactive {
			display: none;
		}

		/* Legends columns — frame matches /listCalque */
		.legend-column {
			padding: 10px;
		}

		.legend-column .legend-item {
			display: flex;
			align-items: center;
			padding: 6px 0;
			margin-top: 1px;
			margin-right: 2px;
			margin-left: 1px;
		}

		.legend-column .legend-text {
			color: #182540;
			font-size: 14px;
			margin: 0;
			padding-left: 8px;
			white-space: normal;
		}

		/* Number badge — exact match with /listCalque .rond */
		.rond {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 40px;
			height: 40px;
			background-color: #0077b5;
			color: white;
			font-weight: bold;
			text-align: center;
			font-size: 14px;
			min-width: 40px;
		}

		/* Image column */
		.figure-image-wrapper {
			position: relative;
			padding: 10px;
			text-align: center;
		}

		.figure-image-wrapper img {
			display: block;
			margin: auto;
			max-width: 100%;
			max-height: 70vh;
			object-fit: contain;
			border-left: 2px solid #d0d2d4;
			border-right: 2px solid #d0d2d4;
		}

		/* Bottom title */
		.figure-title {
			margin: 20px auto 0 auto;
			text-align: center;
		}

		.figure-title .title-row {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
			padding: 10px 16px;
			background: #f5f9f8;
			border-radius: 8px;
			border: 1px solid #e3e6ea;
		}

		.figure-title .title-text {
			color: #2d5e51;
			font-weight: 600;
			font-size: 16px;
		}

		/* Nav button — exact match with /listCalque .btn_app */
		.btn_app {
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

		.row {
			display: flex;
			flex-wrap: wrap;
			margin-right: -15px;
			margin-left: -15px;
		}

		.col-sm-3 { flex: 0 0 25%; max-width: 25%; padding: 0 15px; }
		.col-sm-4 { flex: 0 0 33.333%; max-width: 33.333%; padding: 0 15px; }
		.col-sm-6 { flex: 0 0 50%; max-width: 50%; padding: 0 15px; }
		.col-sm-12 { flex: 0 0 100%; max-width: 100%; padding: 0 15px; }

		@media (max-width: 992px) {
			.col-sm-3, .col-sm-6 { flex: 0 0 100%; max-width: 100%; }
			.figure-image-wrapper img { max-height: 50vh; }
		}
	</style>
</head>

<header style="z-index: 1000; width: 100%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
	<?php include('v1_header_menu.php'); ?>
</header>

<body>

	<div class="main-container">
		<?php include('v1_racourci_atlas.php'); ?>

		<div class="figures-container">

			<div class="row">
				<div class="col-sm-12">
					<div class="scroll-container">
						<div class="block-images" id="imageSlider">
							<?php
							$compteurFigure = 0;
							foreach ($arrayFigures as $figure) {
								$class = ($compteurFigure === 0) ? "image-figure selected-figure" : "image-figure"; ?>
								<div class="<?= $class ?>" onclick="afficheFigure(<?= $compteurFigure ?>)">
									<img src="data:image/png;base64,<?php print $figure['image'] ?>" alt="Image <?= $compteurFigure ?>" />
								</div>
								<?php
								$compteurFigure++;
							}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4" style="margin-top: 20px; display: flex; justify-content: center; align-items: center; text-align: end; gap: 40px;">
					<a class="btn-info btn_app" href="<?php echo base_url() . $this->lang->line('siteLang') . 'listCalque/' . $OneBook[0]['IDChapitre']; ?>" style="text-decoration: none;">AG</a>
				</div>
			</div>

			<?php $compteurFigure = 0;
			foreach ($arrayFigures as $figure) {
				$blockClass = ($compteurFigure === 0) ? 'block-figure' : 'block-figure inactive';
				$compteurFigure++;
				?>
				<div class="<?= $blockClass ?>">

					<div class="row">
						<div class="col-sm-3 legend-column">
							<?php
							foreach ($figure['textGauche'] as $itemBlock) {
								foreach ($itemBlock as $item) {
									$badgeNum = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $m) ? $m[1] : $item['numero'];
									?>
									<div class="legend-item">
										<span class="rond"><?= $badgeNum; ?></span>
										<p class="legend-text"><?= $item['mot']; ?></p>
									</div>
								<?php }
							} ?>
						</div>

						<div class="col-sm-6 figure-image-wrapper">
							<img src="data:image/png;base64,<?php print $figure['image'] ?>" alt="<?= htmlspecialchars($figure['titre'], ENT_QUOTES); ?>" />
						</div>

						<div class="col-sm-3 legend-column">
							<?php
							foreach ($figure['textDroite'] as $itemBlock) {
								foreach ($itemBlock as $item) {
									$badgeNum = preg_match('/^\s*(\d+)\s*-/', $item['mot'], $m) ? $m[1] : $item['numero'];
									?>
									<div class="legend-item">
										<span class="rond"><?= $badgeNum; ?></span>
										<p class="legend-text"><?= $item['mot']; ?></p>
									</div>
								<?php }
							} ?>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 figure-title">
							<div class="title-row">
								<span class="title-text"><?= $figure['titre']; ?></span>
							</div>
						</div>
					</div>

				</div>
			<?php } ?>

		</div>
	</div>

	<script>
		function afficheFigure(position) {
			var figures = document.getElementsByClassName('block-figure');
			var buttons = document.getElementsByClassName('image-figure');

			for (let i = 0; i < figures.length; i++) {
				if (i == position) {
					figures[i].classList.remove("inactive");
					buttons[i].setAttribute("class", "image-figure selected-figure");
					buttons[i].scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
				} else {
					figures[i].classList.add("inactive");
					buttons[i].setAttribute("class", "image-figure");
				}
			}
		}
	</script>

</body>

</html>

<?php } else { ?>

	<?php
	header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
	exit();
	?>

<?php } ?>
