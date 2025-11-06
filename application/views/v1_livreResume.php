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
		<style type="text/css">

			body {
				margin: 0;
				font-size: 0px;
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
			.table.dataTable th{
				display: none;
			}
			.my-1 {
				margin-top: .0rem !important;
			}

			.toolbar {
				display: none !important;
			}
			.table.dataTable {
				clear: both;
				margin-top: 0px !important;
				margin-bottom: 1px !important;
			}
			.dataTables_info{
				visibility: hidden;
			}
			.table td, .table tfoot, .table th, .table thead, .table tr {
				padding: .0rem;
			}
			.btn-outline-primary.hover{
				background-color: #c5daef;
			}
			.btn-outline-primary.active{
				background-color: #c5daef;
			}

			.row:after {
				content: "";
				display: table;
				clear: both;
			}

			.container {
				position: relative;
				width: 100%;
				height: 29rem;
				margin: 0px auto;
				text-align: center;
				overflow-x: hidden;
				overflow-y: auto;
				display: block;
			}

			@media (max-width: 768px) {
				.container {
					height: 40vh;  /* Increase height on smaller screens */
				}
			}

			@media (min-width: 1200px) {
				.container {
					height: 85vh;  /* Decrease height on larger screens */
				}
			}

			.carreaux_lec{
				width: 170px;
				height: 30px;
				background: linear-gradient(135deg, #1d3557, #457b9d);
				color: white;
				justify-content: center;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
				border-radius: 10px;
				display: flex;
				font-size: 11.5px;
				letter-spacing: 0.2px;
				align-items: center;
				font-weight: bold;
			}
		</style>
	</head>

	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
		<?php include('v1_header_menu.php'); ?>
	</header>

	<body>

	<style>
		/* Global Reset */
		* {
			box-sizing: border-box;
		}

		/* Conteneur principal */
		#element {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			padding: 1px;
		}

		/* Colonne gauche */
		.left-column {
			flex: 1 1 100%;
			max-width: 100%;
			margin-bottom: 20px;
		}

		@media(min-width: 768px) {
			.left-column {
				flex: 0 0 48%;
				max-width: 48%;
				margin-left: 2%;
			}
		}

		/* Colonne droite */
		.right-column {
			flex: 1 1 100%;
			max-width: 100%;
		}

		@media(min-width: 768px) {
			.right-column {
				flex: 0 0 48%;
				max-width: 48%;
				margin-left: 2%;
			}
		}

		.input-group-navbar {
			flex-wrap: wrap;
		}
	</style>

	<div   id="element" >

		<?php include('v1_racourci.php'); ?>

		<div class="col-12 col-lg-6 col-xl-6" style="float: left;width: 48%;margin-left: 45px;">
			<div class="row">
				<li class="breadcrumb-item">

					&nbsp;&nbsp;
                    <div style="display: flex; align-items: center; gap: 5px; margin-left: auto;">
						<div style="display: flex; gap: 20px;padding-top: 5px;">
							<div style="display: flex; align-items: center; gap: 5px; margin-left: 30px;">
								<input name="keywordsIN" id="keywordsIN" type="text"
									   style="border: 1px solid #ced4da; transition: 0.3s; max-width: 190px; height: 30px; padding: 5px;"
									   value="<?php print urldecode($indexSearch); ?>"
									   class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…" >
								<button class="btn" onclick="mySearchIndx();"
										style="display: flex; align-items: center; justify-content: center; height: 30px; padding: 5px;">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle">
										<circle cx="11" cy="11" r="8"></circle>
										<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
									</svg>
								</button>
							</div>


						</div>

					</div>

					<script>
                        var input = document.getElementById("keywordsIN");

                        // Execute a function when the user releases a key on the keyboard
                        input.addEventListener("keyup", function(event) {
                            // Number 13 is the "Enter" key on the keyboard
                            if (event.keyCode === 13) {
                                // Cancel the default action, if needed
                                event.preventDefault();
                                // Trigger the button element with a click
                                mySearchIndx();
                            }
                            document.getElementById("keywordsIN").focus();
                        });

                        function mySearchIndx() {
                            var iframe = document.getElementById("iframeID");
                            var elmnt = iframe.contentWindow.document.getElementById("btn_search");
                            var elmntSearchIN = document.getElementById("keywordsIN");
                            var elmntSearch = iframe.contentWindow.document.getElementById("keywords");
                            elmntSearch.value = elmntSearchIN.value;
                            elmnt.click();
                        }

					</script>

				</li>
			</div>
			<div class="row">
				<?php print $CursShow ?>
				<div style="align-items: center;display: flex; justify-content: center;">
					<button class="carreaux_lec" id="carreaux_lec"  onclick="openModalDetailsCurs(); return false;"
							style="font-size: 10.5px; width: 184px; height: 35px; align-items: center;letter-spacing: 0.2px;">
						<b style="letter-spacing: 0.1px;">Accéder à la version détaillée</b>
					</button>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-6 col-xl-6" style="float:right;width: 48%;">
			<?php include('v1_bloc_figures.php'); ?>
		</div>

	</div>

	<?php include('v1_modal_mode_lecture.php'); ?>
	<?php include('v1_modal_version_detaillee_cours.php'); ?>

	</body>

	<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

	</html>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
