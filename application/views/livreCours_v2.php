
<?php
include('header.php');
?>

<style>
	#setNAVSTEPPS{
		display: none;
	}
	.footer{
		display: none;
	}
	.image-item{

		display: inline-block;
		margin-right: 3px;
		position: relative;
	}
	.image-item img{
		margin-left: 0; margin-top: 0;
	}
	.zoo-item {
		position: initial;
	}

	.row {
		width: 100%;
	}
</style>

<body>

<?php
include('header_steppes.php');
?>

<div class="wrapper">

	<div class="main">

		<main class="">

			<div class="container-fluid p-0">

				<div class="row" style="width: 100%">

					<div class="col-12 col-lg-6 col-xl-6">

						<div class="card" style="height: 100%;">
							<div class="card-header">

									<a class="badge bg-success text-white ml-2" href="" onclick="twPleinEcran('<?php echo base_url(); ?>livreCours/<?php print $OneBook[0]["IDLivre"]; ?>');" style="float:right; background-color: #8f84d9 !important;"><i class="fa fa-window-maximize" aria-hidden="true"></i>
									</a>
									<a class="badge bg-success text-white ml-2" href="<?php echo base_url(); ?>livreDetails/<?php print $OneBook[0]["IDChapitre"]; ?>"  style="float:right; background-color: #8f84d9 !important;">X</a>

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
									<button onclick="setFig('<?php echo HTTP_PLATFORM; ?><?=$value['UrlFigure'];?>' ,'<?=$value['TitreFigure'];?>')" class="badge bg-primary mr-1 my-1"><strong><?=$value['TitreFigure'];?></strong></button>
								<?php }?>
								<div class="card-body text-center" style="overflow-y: scroll; height: 500px">
									<h4 id="setTitFig"></h4>
									<div class='image-item' id="figZoo">
										<figure class="zoo-item" id="zoom_01" data-zoo-image=""></figure>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</main>
	</div>
</div>
<?php
include('footer.php');
?>



<script type='text/javascript'>

	$(document).ready(function () {

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
				"data": function(d){
					d.ic 	= "<?=$OneCurs[0]['IDCours'];?>";
				}
			},
			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [0], //first column / numbering column
					"sClass": "text-left",
					"orderable": false,
				},{"sClass": "text-center", "aTargets": [0]},
			],
			"language": {
				"sProcessing":     "Traitement en cours...",
				"sSearch":         "Rechercher&nbsp;:",
				"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
				"sInfo":           "",
				"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
				"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				"sInfoPostFix":    "",
				"sLoadingRecords": "Chargement en cours...",
				"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
				"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
				"oPaginate": {
					"sFirst":      "Premier",
					"sPrevious":   "Pr&eacute;c&eacute;dent",
					"sNext":       "Suivant",
					"sLast":       "Dernier"
				},
				"oAria": {
					"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
				},
				"select": {
					"rows": {
						_: "%d lignes séléctionnées",
						0: "Aucune ligne séléctionnée",
						1: "1 ligne séléctionnée"
					}
				}
			}

		});

		function refresh_table(){
			table_middleware_main.fnDraw();
		}

	});

	function setFig(ur='',titur='') {

	$("#figZoo").html('<img class="zoo-item" id="zoom_01" src="'+ur+'" />');
	$("#setTitFig").html('<h4>'+titur+'</h4>');

	$('.zoo-item').ZooMove({
		image: "'"+titur+"'",
		scale: '3',
		move: 'true',
		over: 'false',
		cursor: 'true'
	});


}

	function twPleinEcran(nURL) {
		var windowFeatures = "fullscreen=yes, scrollbars=auto";
		window.open(nURL,"CNN_WindowName", windowFeatures);
	}
</script>

</body>
</html>
