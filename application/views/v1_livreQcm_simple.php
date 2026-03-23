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
		<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
		<style>
			.table > tbody > tr > td{
				padding: 0.05rem;
			}
			hr{
				margin: 0.3rem 0;
			}
			#datatables-ajax_info{
				display: none;
			}

			.form-check-input{
				width: 2em;
				height: 2em;
			}

		</style>
	</head>

	 <header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
			<?php include('v1_header_menu.php'); ?>
		</header>


	<body data-theme="default" data-layout="boxed" data-sidebar="left" >

	<div class="wrapper">
		<div class="main" >
			<?php include('v1_header_nav.php'); ?>
			<main class="content">
				<div class="container-fluid p-0">

					<?php include('v1_racourci.php'); ?>

 						<div class="main-section" id="mainSection"  style="margin-left: 90px;margin-right: 20px;width: auto;">
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
			</main>

			<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
			<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
			<script src="<?php echo HTTP_JS; ?>app.js"></script>

			<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
			<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/zoomove.min.js"></script>

			<script src="<?php echo HTTP_JS; ?>jquery-validate/jquery.validate.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

			<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>
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


	</style>

<script type="text/javascript" >

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
