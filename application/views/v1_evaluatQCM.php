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
			.image-item img{
				margin-left: 0; margin-top: 0;
			}
			.zoo-item {
				position: initial;
			}
			#outerContainer #mainContainer div.toolbar {
				display: none !important; /* hide PDF viewer toolbar */
			}
			#outerContainer #mainContainer #viewerContainer {
				top: 0 !important; /* move doc up into empty bar space */
			}
			.btn-outline-primary {
				color: #000000;
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
background: linear-gradient(135deg, #120E47 30%, #eeeeeeff 100%);">
		<?php include('v1_header_menu.php'); ?>
	</header>

	<body>

	<style>
		.table > tbody > tr > td{ 	padding: 0.05rem; }
		hr{ margin: 0.3rem 0; }
		#datatables-ajax_info{ display: none; }
		.swal2-title{font-size: 20px !important ;}
		#setMinut{z-index: 1000;background-color: #465975;}

	</style>


	<div   id="element">

		<?php include('v1_header_nav.php'); ?>

		<?php include('v1_racourci.php'); ?>

		<div class="col-12 col-lg-12 col-xl-12" style="float: left;width: 90%;margin-left: 70px;">
			<div class="row">

				<input type="hidden" value="0" id="numrws">
				<table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" 	role="grid" aria-describedby="datatables-ajax_info">
					<thead style="display: none">
					<tr>
						<th><?php echo $this->lang->line('question'); ?></th>
					</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>


	</div>

	</body>


	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

	<script type="text/javascript" >

        $(document).ready(function () {

            var table_middleware_main = $('#datatables-ajax').dataTable({

                "bLengthChange": false,
                "bFilter": false,
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 100,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_QuestionTypeTest_list",
                    "type": "POST",
                    "data": function(d){
                        d.typeQ 	= "QCM";
                        d.typeC 	= "<?php print $OneBook[0]['IDLivre']; ?>";
                        d.listDIS 	= "<?php print $listDIS; ?>";
                        d.typeImp 	= "<?php print $typeImp; ?>";
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
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo $this->lang->line('table_lang'); ?>.json"
                },
                "initComplete": function(settings, json) {
                    var api = this.api();
                    var numRows = api.rows( ).count();

                    //var ddd = document.getElementById("titleQ").innerHTML;
                    document.getElementById("numrws").value = numRows;
                    beginTest();
                }

            });

            function refresh_table(){
                table_middleware_main.fnDraw();
            }

        });

        function myFunction(id=0) {

            // var elmsResp		= document.querySelector("[id='setKeyResp']");
            //elmsResp.style.visibility = 'visible';
            var kpp 		= "setKeyResp";//+id;
            var elmsResp	= document.querySelectorAll("[id='"+kpp+"']");
            for(var i = 0; i < elmsResp.length; i++)
            {
                elmsResp[i].style.visibility = 'visible';
            }

            var kks 		= "setInf";//+id;
            var elms 		= document.querySelectorAll("[id='"+kks+"']");
            for(var i = 0; i < elms.length; i++)
            {
                elms[i].style.color 		= 'green';
                elms[i].style.fontWeight 	= 'bold';
            }
            var kkD 	= "indCT";//+id;
            var elmCDT 	= document.querySelectorAll("[id='"+kkD+"']");
            for(var i = 0; i < elmCDT.length; i++)
            {elmCDT[i].style.visibility = 'visible';}

            var kks 	= "setValTEST";//+id;
            var reqst 	= '';
            var resp  	= '';
            var nbrQ  	= 0;
            var nbrQR  	= 0;
            var kksj 	= "quest_";//+id;
            var markedCheckboxj = document.querySelectorAll("[id='"+kksj+"']");
            for (var checkbox of markedCheckboxj) {

                nbrQ++ ;
                //alert("Question id "+checkbox.getAttribute('data-quest'));
                var ids = checkbox.getAttribute('data-quest');
                var kks = "setValTEST_"+ids;
                reqst	= '';
                resp  	= '';
                var markedCheckbox = document.querySelectorAll("[id='"+kks+"']");
                for (var checkboxxx of markedCheckbox) {

                    reqst = reqst+";"+checkboxxx.getAttribute('data-setTST');
                    resp  = resp+";"+checkboxxx.checked;
                }
                if(reqst != resp){nbrQ--;}
                //alert("Ligne id "+reqst+'<br>'+resp);
                nbrQR++;
            }

            Swal.fire({
                title				: '<?php echo $this->lang->line('testPopRslt'); ?>'+nbrQ+"/"+nbrQR,
                position			: 'center',
                type				: 'success',
                confirmButtonColor	: '#3085d6',
                cancelButtonColor	: '#d33',
                confirmButtonText	: '<?php echo $this->lang->line('testPopEnd'); ?>',
                allowOutsideClick	: false,
                allowEscapeKey		: false
            }).then((result) => {
                if (result.value) {
                    //window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= base64_encode($OneBook[0]['IDLivre']);?>";
                }
            })

        }
        function beginTest(){
            // Set the date we're counting down to

            var today 		= new Date();
            var tomorrow 	= new Date();

            var numrws = document.getElementById("numrws").value;
            tomorrow.setSeconds(today.getSeconds()+1);
            tomorrow.setMinutes(today.getMinutes()+Number(numrws));
            var countDownDate = tomorrow.getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days 	= Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours 	= Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="setMinut"
                document.getElementById("setMinut").innerHTML = minutes + "m " + seconds + "s ";

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("setMinut").innerHTML = "EXPIRED";
                    myFunction(0);
                }
            }, 1000);
        }

	</script>

	<script>
        // When the user scrolls down 50px from the top of the document, resize the header's font size
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                document.getElementById("setMinut").style.fontSize = "1.3em";
            } else {
                document.getElementById("setMinut").style.fontSize = "1.3em";
            }
        }
	</script>


	</html>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
