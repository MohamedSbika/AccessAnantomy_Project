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

		/* Champ de recherche */
		.input-group-navbar {
			flex-wrap: wrap;
		}
	</style>


	<div   id="element" >

		<?php include('v1_header_nav.php'); ?>

		<?php include('v1_racourci.php'); ?>

		<div class="col-12 col-lg-6 col-xl-6" style="float: left;width: 48%;margin-left: 45px;">
			<div class="row">
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

		<div class="col-12 col-lg-6 col-xl-6" style="float:right;width: 48%;">
			<?php include('v1_bloc_figures.php'); ?>
		</div>

	</div>

	</body>

	<style>
		/* Centering the pagination container */
		.dataTables_paginate {
			display: block ruby;
			justify-content: center;   /* Centers the pagination */
			margin-top: 20px;           /* Optional: adds space above the pagination */
			padding-bottom: 20px;           /* Optional: adds space above the pagination */
			overflow-x: auto;
			scrollbar-width: revert-layer;
		}
		div.dataTables_wrapper div.dataTables_paginate {
			margin: 0;
			white-space: nowrap;
			text-align: center;
		}
		/* Style for the active page in pagination */
		.dataTables_paginate .pagination .page-item.active .page-link {
			background-color: #3b7ddd;  /* Active page background color */
			color: white;               /* Active page text color */
			font-weight: bold;          /* Bold text for active page */
		}

		/* Style for the page numbers */
		.dataTables_paginate .pagination .page-item .page-link {
			border: 1px solid #ddd;    /* Light border around page numbers */
			color: #3b7ddd;             /* Default text color for page links */
			padding: 8px 12px;          /* Padding around the page number */
			font-size: 1rem;            /* Font size */
			margin: 0 5px;              /* Add space between the page numbers */
		}

		/* Hover effect for the page numbers */
		.dataTables_paginate .pagination .page-item .page-link:hover {
			background-color: #0056b3;  /* Hover background color */
			color: white;               /* Hover text color */
			border-color: #0056b3;      /* Hover border color */
		}

		/* Style for the "Previous" and "Next" buttons */
		.dataTables_paginate .pagination .page-item .page-link:disabled {
			background-color: #f1f1f1;  /* Disabled button background */
			color: #ccc;                /* Disabled button text */
			border-color: #ccc;         /* Disabled button border */
		}

		/* Remove the border-radius to make "Previous" and "Next" buttons square */
		.dataTables_paginate .pagination .page-item .page-link:disabled {
			border-radius: 0;  /* Make the previous/next buttons square */
		}

		.paginate_button.page-item.current {
			background-color: #3b7ddd; /* Button background color */
			color: white;             /* Text color */
			width: 40px;              /* Set width of the button */
			height: 40px;             /* Set height of the button */
			display: flex;            /* Center content */
			align-items: center;      /* Center content vertically */
			justify-content: center;  /* Center content horizontally */
			font-size: 14px;          /* Adjust font size */
			cursor: pointer;          /* Pointer cursor */
			border-radius: .2rem;
		}

		.paginate_button.page-item.current:hover {
			background-color: #0056b3; /* Darker shade for hover effect */
		}

		.paginate_button.page-item {
			background-color: #f0f0f0; /* Default button background color */
			color: #333;              /* Default text color */
			padding: 8px 12px;        /* Padding for the button */
			margin: 0 5px;            /* Space between buttons */
			text-decoration: none;    /* Remove underline for links */
			font-size: 14px;          /* Font size */
			display: inline-block;    /* Make it behave like a button */
			cursor: pointer;          /* Pointer cursor on hover */
			border-radius: .2rem;
			transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition */
		}

		.paginate_button.page-item:hover {
			background-color: #3b7ddd; /* Highlight color on hover */
			color: white;              /* Text color on hover */
			border-color: #3b7ddd;     /* Change border color on hover */
		}

		.paginate_button.page-item.active {
			background-color: #0056b3; /* Active button background color */
			color: white;              /* Active button text color */
		}

		.paginate_button.page-item.disabled {
			background-color: #e9ecef; /* Disabled button background */
			color: #6c757d;            /* Disabled text color */
			cursor: not-allowed;       /* Not-allowed cursor */
			pointer-events: none;      /* Disable interactions */
		}

		.paginate_button.page-item.first,
		.paginate_button.page-item.previous,
		.paginate_button.page-item.next,
		.paginate_button.page-item.last {
			width: 40px;               /* Sets equal width for round shape */
			height: 40px;              /* Sets equal height for round shape */
			display: none;             /* Flexbox for centering content */
			align-items: center;       /* Centers items vertically */
			justify-content: center;   /* Centers items horizontally */
			font-size: 14px;           /* Adjust font size */
			cursor: pointer;           /* Adds pointer cursor for interactivity */
		}

        #datatables-ajax_wrapper{
            /*max-height: 46vw;*/
            overflow-y: scroll;
            height: calc(100vh - 12vh);
            width: 98%;
            margin-left: 20px;
            background-color: white;
        }

	</style>

	<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

	<script type='text/javascript'>

        $(document).ready(function () {

            $.fn.DataTable.ext.pager.numbers_length = 200; // Controls how many page numbers to show

            // Custom pagination function to show all numbers (no ellipses)
            $.fn.DataTable.ext.pager.full_numbers_no_ellipses = function (settings, page, pages) {
                var numbers = [];
                var range = 3; // Number of pages shown around the current page

                // Create page numbers for the current pagination
                for (var i = Math.max(0, page - range); i < Math.min(pages, page + range + 1); i++) {
                    numbers.push(i);
                }

                // Return the full page numbers without ellipses
                return ["<<", "<", numbers, ">", ">>"];
            };

            var table_middleware_main = $('#datatables-ajax').dataTable({

                "pagingType": "full_numbers",  // Use full numbers pagination (all page numbers shown)
                "paging": true,                // Enable pagination
                "dom": '<"top"fi>rt<"bottom"lp><"clear">',  // Custom layout for the DataTable
                "renderer": "full_numbers_no_ellipses",  // Apply the custom pagination functio

                "bLengthChange": false,
                "bFilter": false,
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 2,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_QuestionType_list",
                    "type": "POST",
                    "data": function(d){
                        d.typeQ 	= "QCM";
                        d.typeC 	= "<?php print $OneBook[0]['IDChapitre']; ?>";
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
                    var ddd = document.getElementById("titleQ").innerHTML;
                    document.getElementById("titleQu").innerHTML = ddd;
                }

            });


            function refresh_table(){
                table_middleware_main.fnDraw();
            }

        });

        function myFunction(id=0) {
            // var elmsResp		= document.querySelector("[id='setKeyResp']");
            //elmsResp.style.visibility = 'visible';
            var kpp = "setKeyResp-"+id;
            var elmsResp		= document.querySelectorAll("[id='"+kpp+"']");
            for(var i = 0; i < elmsResp.length; i++)
            {
                elmsResp[i].style.visibility = 'visible';
            }

            var kks = "setInf-"+id;
            var elms 		= document.querySelectorAll("[id='"+kks+"']");
            for(var i = 0; i < elms.length; i++)
            {
                elms[i].style.color = 'green';
                elms[i].style.fontWeight = 'bold';
            }
            var kkD = "indCT-"+id;
            var elmCDT 		= document.querySelectorAll("[id='"+kkD+"']");
            for(var i = 0; i < elmCDT.length; i++)
            {elmCDT[i].style.visibility = 'visible';}
        }

	</script>

	</html>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
