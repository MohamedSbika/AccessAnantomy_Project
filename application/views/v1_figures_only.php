<?php if(strlen($this->session->userdata('passTok'))==200) { ?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Figures - Access Anatomy</title>

	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">

	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			background-color: white;
			font-family: 'Manrope', sans-serif;
		}

		.main-container {
			display: flex;
			width: 100%;
			gap: 0;
		}

		.figures-container {
			flex: 1;
			max-width: 900px;
			margin: 20px auto;
			padding: 20px;
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
			<?php include('v1_bloc_figures_atlas.php'); ?>
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
