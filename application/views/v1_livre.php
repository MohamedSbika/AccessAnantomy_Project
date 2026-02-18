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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
    <link href="<?php echo HTTP_CSS; ?>responsive.css" rel="stylesheet">
	<style >

		.btn{
			background-color: #203b6f;
			display: inline-block;
			font-weight: 400;
			line-height: 1.5;
			text-align: center;
			user-select: none;
			border: 1px solid transparent;
			font-size: .875rem;
			border-radius: .2rem;
			transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		}
		/* Style pour masquer la modale par défaut */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			display: flex;
			align-items: center;
			justify-content: center;
		}

		/* Contenu de la modale */
		.modal-content {
			text-align: center;
			position: relative;
			background-color: white;
			padding: 20px;
			border-radius: 8px;
			max-width: 50%;
			max-height: 80vh;
			overflow-y: auto;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		}

		/* Bouton de fermeture */
		.close {
			position: absolute;
			top: 10px;
			right: 15px;
			font-size: 20px;
			cursor: pointer;
		}
		.btn{
			background-color: #0077b5;
			text-decoration: none;
			display: inline-block;
			font-weight: 400;
			line-height: 1.5;
			text-align: center;
			user-select: none;
			border: 1px solid transparent;
			padding: .25rem .7rem;
			font-size: .875rem;
			border-radius: .2rem;
			transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		}
		.btn:hover {
			border-color: #117a8b;
		}
		button:not(:disabled) {
			cursor: pointer;
		}
		.nav-link.dropdown-toggle::after {
			content: " ▼";
			font-size: 12px;
			margin-left: 5px;
			color: inherit;
			transition: transform 0.2s ease-in-out;
		}
		.dropdown-toggle::after {
			border: aliceblue;
			display: inline-block;
			padding: 2px;
			transform: rotate(0deg);
		}
		.dropdown-toggle::after {
			vertical-align: 0em;
		}
		.navbar-nav .nav-link {
			padding-right: 0;
			padding-left: 0;
		}
		.navbar-nav {
			direction: ltr;
		}
		.mr-auto {
			margin-right: auto !important;
		}
		.navbar-nav {
			flex-direction: inherit;
			margin-bottom: 0;
		}
		.nav-link {
			display: block;
		}
		.dropdown-toggle {
			white-space: nowrap;
		}
		[role="button"] {
			cursor: pointer;
		}

		.bloc_pub {
			margin-right: 20px;
			margin-left: 20px;
			padding-right: 10px;
			margin-bottom: 30px;
 			border-radius: 10px;
			color: white;
			font-size: 16px;
			line-height: 1.6;
			max-height: 500px;
			overflow-y: auto;
			padding-top: 15px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.74);
		}
	</style>
</head>
<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
	<?php include('v1_header_menu.php'); ?>
</header>
<body  data-theme="default" data-layout="boxed" data-sidebar="left" >

<div class="wrapper">
	<div class="main" >
		<?php include('v1_header_nav.php'); ?>
		<main class="content">
			<div class="container-fluid">
				<?php include('v1_racourci.php'); ?>

<div class="main-section" id="mainSection" style="padding-top: 10px;">
	<div class="row" style="align-items: flex-start;">

		<!-- Colonne image : 1/3 -->
		<div class="col-md-4">
            <div id="arrowViewImage" onclick="viewImage()" class="arrowViewImage d-flex d-md-none">
                <span class="style"><</span>
            </div>

            <div id="arrowHideImage" onclick="hideImage()" class="arrowHideImage d-none">
                <span class="style">x</span>
            </div>
			<div id="imageView" class="imageView">
                <?php if($OneBook[0]["encryptCouverture"] =='') { ?>
                    <img src="<?php echo HTTP_IMAGES; ?>photos/NoPicture.png" alt="" class="img-fluid" style="max-height: 500px; width: 100%; object-fit: contain;">
                <?php } else { ?>
                    <img src="data:image/png;base64,<?php print $OneBook[0]["encryptCouverture"]; ?>"
                         class="img-fluid" style="max-height: 450px; width: 100%; object-fit: contain; margin-left: 30px;">
                <?php }?>
            </div>
		</div>

		<!-- Colonne contenu : 2/3 -->
		<div class="col-md-8">
			<div class="bloc_pub bloc_pub_responsive" style="padding: 20px; color: black">
				<?php
				$html = $OneBook[0]["Description"];
				if (!empty($html)) {
					preg_match('/<div class=WordSection1>(.*?)<\/div>/s', $html, $match);
					if (sizeof($match) > 0) {
						echo $match[0];
					} else {
						preg_match('/<body>(.*?)<\/body>/s', $html, $match2);
						if (sizeof($match2) > 0) {
							echo $match2[0];
						} else {
							echo $html;
						}
					}
				}
				?>
			</div>
		</div>

	</div>
</div>


			</div>
		</main>
	</div>
</div>

<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
<script src="<?php echo HTTP_JS; ?>app.js"></script>

<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>
</body>
</html>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>

<script>
    // Function to view image
    function viewImage() {
        let imageView = document.getElementById("imageView");
        let arrowViewImage = document.getElementById("arrowViewImage");
        let arrowHideImage = document.getElementById("arrowHideImage");
        let mainSection = document.getElementById("mainSection");

        mainSection.classList.add("backgroundOpacity");

        imageView.classList.remove("imageView");
        imageView.classList.add("imageViewAnimation");

        arrowViewImage.classList.remove("d-flex", "d-md-none");
        arrowViewImage.classList.add("d-none");

        arrowHideImage.classList.remove("d-none");
        arrowHideImage.classList.add("d-flex",  "d-md-none");
    }

    function hideImage(){
        let imageView = document.getElementById("imageView");
        let arrowViewImage = document.getElementById("arrowViewImage");
        let arrowHideImage = document.getElementById("arrowHideImage");
        let mainSection = document.getElementById("mainSection");

        mainSection.classList.remove("backgroundOpacity");

        imageView.classList.add("imageView");
        imageView.classList.remove("imageViewAnimation");

        arrowViewImage.classList.add("d-flex", "d-md-none");
        arrowViewImage.classList.remove("d-none");

        arrowHideImage.classList.add("d-none");
        arrowHideImage.classList.remove("d-flex",  "d-md-none");
    }
</script>
