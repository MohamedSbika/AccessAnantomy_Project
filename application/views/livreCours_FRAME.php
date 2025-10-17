<?php if (strlen($this->session->userdata('passTok')) == 200) { ?>


	<!DOCTYPE html>
	<html>
	<?php
	include('header.php');
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
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
			background-color: #e9e9e9;
			font-size: 20px;
			text-align: center;
			box-sizing: border-box;
		}

		.table.dataTable th {
			display: none;
		}

		.my-1 {
			margin-top: .0rem !important;
		}

		#go-button {

			display: block;
		}

		.swal2-title {
			margin: 0px;
			font-size: 1.1em;
			box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.21);
			margin-bottom: 28px;
		}

		/* webkit requires explicit width, height = 100% of sceeen */
		/* webkit also takes margin into account in full screen also - so margin should be removed (otherwise black areas will be seen) */
		#element:-webkit-full-screen {
			width: 100%;
			height: 100%;
			background-color: pink;
			margin: 0;
		}

		#element:-moz-full-screen {
			background-color: pink;
			margin: 0;
		}

		#element:-ms-fullscreen {
			background-color: pink;
			margin: 0;
		}

		/* W3C proposal that will eventually come in all browsers */
		#element:fullscreen {
			background-color: pink;
			margin: 0;
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
	</style>

	<body>

		<div class="row" style="width: 100%" id="element">

			<div class="col-12 col-lg-6 col-xl-6">

				<div class="card" style="height: 100%;">
					<div class="card-header">
						<div class="row">
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a>
								<a class="badge bg-success text-white ml-2" id="go-button" href="#" style="float:right; background-color: #8f84d9 !important;"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
							</li>
						</div>

						<table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" role="grid" aria-describedby="datatables-ajax_info">
							<tbody>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="col-12 col-lg-6 col-xl-6">
				<div class="card" style="height: 100%;">
					<div class="card-header">
						<?php foreach ($listFig as $value) { ?>
							<a name="<?= $value['IDFigure']; ?>" id="setFigStyl" onclick="setFig('' ,'','<?= $value['IDFigure']; ?>')" class="btn btn-outline-primary" href="#"><?= $value['TitreFigure']; ?></i></a>
						<?php } ?>
						<div class="card-body text-center" style="overflow-y: scroll; height: 700px">
							<h4 id="setTitFig"></h4>
							<div class='image-item' id="figZoo">
								<figure class="zoo-item" id="zoom_01" data-zoo-image=""></figure>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</body>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/zoomove.min.js"></script>


	<script type='text/javascript'>
		$(document).ready(function() {

			var table_middleware_main = $('#datatables-ajax').dataTable({


				"bLengthChange": false,
				"bFilter": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
				"pageLength": 1,
				// Load data for the table's content from an Ajax source
				"aoColumns": [
					null
				],
				"ajax": {
					"url": "<?php echo base_url(); ?>home/ajax_PagesCours_list",
					"type": "POST",
					"data": function(d) {
						d.ic = "<?= $OneCurs[0]['IDCours']; ?>";
					}
				},
				//Set column definition initialisation properties.
				"columnDefs": [{
					"targets": [0], //first column / numbering column
					"sClass": "text-left",
					"orderable": false,
				}, {
					"sClass": "text-center",
					"aTargets": [0]
				}, ],
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo $this->lang->line('table_lang'); ?>.json"
				}

			});

			function refresh_table() {
				table_middleware_main.fnDraw();
			}

			var windowWidth = window.screen.width < window.outerWidth ?
				window.screen.width : window.outerWidth;
			var mobile = windowWidth < 700;

			if (!mobile) {
				Swal.fire({
					title: "<?php echo $this->lang->line('full_scrn'); ?>",
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'OK',
					allowOutsideClick: false,
					allowEscapeKey: false
				}).then((result) => {
					if (result.value) {
						if (IsFullScreenCurrently())
							GoOutFullscreen();
						else
							GoInFullscreen($("#element").get(0));
					}
				})

			}

		});

		function toolbarhid() {
			//document.getElementById('iframeID').style.visibility = "hidden";
			// document.getElementById('iframeID').find("#toolbarViewerRight").hide();
			var iFrameDOM = $("iframeID").contents();

			iFrameDOM.find(".pdfViewer").css("visibility", 'hidden');
			alert(iFrameDOM.find(".pdfViewer"));
		}

		function setFig(ur = '', titur = '', iFig = '') {


			$.ajax({

				type: "POST",
				url: "<?php echo base_url(); ?>home/getURLFig",
				data: {
					ifFig: iFig
				},
				timeout: 300000,
				success: function(html) {

					console.log(html);
					var ar = JSON.parse(html);

					if (ar[0]["id"] == 1) {
						ur = "<?php echo HTTP_PLATFORM; ?>" + ar[0]["desc"][0]["UrlFigure"];
						titur = ''; // ar[0]["desc"][0]["TitreFigure"];
						$("#figZoo").html('<img class="zoo-item" id="zoom_01" src="' + ur + '" />');
						$("#setTitFig").html('<h4>' + titur + '</h4>');
					} else {
						alert(ar[0]["desc"]);
					}
				},
				error: function() {
					alert("Error when call webservice to get Figure . ");
				}

			});


			$('.zoo-item').ZooMove({
				image: "'" + titur + "'",
				scale: '3',
				move: 'true',
				over: 'false',
				cursor: 'true'
			});

			setActiveFig(iFig);

		}
		var elem = document.documentElement;

		function openFullscreen() {
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			} else if (elem.webkitRequestFullscreen) {
				/* Safari */
				elem.webkitRequestFullscreen();
			} else if (elem.msRequestFullscreen) {
				/* IE11 */
				elem.msRequestFullscreen();
			}
		}

		function setActiveFig(iFig = '') {
			var elms = document.querySelectorAll("[id='setFigStyl']");
			for (var i = 0; i < elms.length; i++) {
				if (elms[i].getAttribute("name") == iFig) {
					elms[i].className = 'btn btn-outline-primary active';
				} else {
					elms[i].className = 'btn btn-outline-primary';
				}
			}
		}
	</script>

	<script>
		/* Get into full screen */
		function GoInFullscreen(element) {
			if (element.requestFullscreen)
				element.requestFullscreen();
			else if (element.mozRequestFullScreen)
				element.mozRequestFullScreen();
			else if (element.webkitRequestFullscreen)
				element.webkitRequestFullscreen();
			else if (element.msRequestFullscreen)
				element.msRequestFullscreen();
		}

		/* Get out of full screen */
		function GoOutFullscreen() {
			if (document.exitFullscreen)
				document.exitFullscreen();
			else if (document.mozCancelFullScreen)
				document.mozCancelFullScreen();
			else if (document.webkitExitFullscreen)
				document.webkitExitFullscreen();
			else if (document.msExitFullscreen)
				document.msExitFullscreen();
		}

		/* Is currently in full screen or not */
		function IsFullScreenCurrently() {
			var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

			// If no element is in full-screen
			if (full_screen_element === null)
				return false;
			else
				return true;
		}

		$("#go-button").on('click', function() {
			if (IsFullScreenCurrently())
				GoOutFullscreen();
			else
				GoInFullscreen($("#element").get(0));
		});

		$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
			if (IsFullScreenCurrently()) {
				$("#element span").text('Full Screen Mode Enabled');
				$("#go-button").text('Disable Full Screen');
			} else {
				$("#element span").text('Full Screen Mode Disabled');
				$("#go-button").text('Enable Full Screen');
			}
		});
	</script>

	</html>

<?php } else { ?>

	<?php
	header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
	exit();
	?>

<?php } ?>