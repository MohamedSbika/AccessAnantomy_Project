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

			#indc{
				font-size: 0.4em;
				color: green;
			}

			.table > tbody > tr > td{
				padding: 0.05rem;
			}

			#datatables-ajax_info{
				display: none;
			}

				#id_essai , #setResp{
					width: 100%;
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

			.zoom {
				width: 320px;
				height: 240px;
			}
			.image {
				width: 100%;
				height: 100%;
			}
			.image img {
				/* La transition s'applique à la fois sur la largeur et la hauteur, avec une durée d'une seconde. */
				-webkit-transition: all 1s ease; /* Safari et Chrome */
				-moz-transition: all 1s ease; /* Firefox */
				-ms-transition: all 1s ease; /* Internet Explorer 9 */
				-o-transition: all 1s ease; /* Opera */
				transition: all 1s ease;
			}
			.image:hover img {
				/* L'image est grossie de 25% */
				-webkit-transform:scale(1.25); /* Safari et Chrome */
				-moz-transform:scale(1.25); /* Firefox */
				-ms-transform:scale(1.25); /* Internet Explorer 9 */
				-o-transform:scale(1.25); /* Opera */
				transform:scale(1.25);
			}
			.zoom {
				display:inline-block;
				position: relative;
				clear: both;
				margin: 15px;

			}

			/* magnifying glass icon */
			.zoom:after {
				content:'';
				display:block;
				width:33px;
				height:33px;
				position:absolute;
				top:0;
				right:0;
				background:url(../images/icon.png);
			}

			.zoom img {
				display: block;
			}

			.zoom img::selection {
				background-color: transparent;
			}


			#ex2 img:hover {
				cursor: url(../images/grab.cur), default;
			}

			#ex2 img:active {
				cursor: url(../images/grabbed.cur), default;
			}

			.previous {
				background-color: #f1f1f1;
				color: black;
				float: left;
			}

			.next {
				background-color: #a9aaa8;
				color: white;
				float: right;
			}

			.round {
				border-radius: 50%;
			}

			.defil {
				text-decoration: none;
				display: inline-block;
				padding: 15px 15px;
				font-size: 30px;
				bottom: 20px;
				color: #d5122f;
				border: 0;
				background: none;
			}

			/* Style du slider */
			.slider-container {
				position: relative;
				width: 100%;
				max-width: 650px; /* Largeur maximale du slider */
				margin: auto;
				overflow: hidden; /* Cacher les images qui dépassent */
				max-height: 200px;
			}

			.slider {
				display: flex;
				transition: transform 0.5s ease; /* Animation de transition pour le slider */
			}

			.slider-image {
				width: 33.33%; /* Afficher 3 images à la fois */
				object-fit: cover;
				padding: 5px; /* Espacement entre les images */
			}

			/* Style des boutons next/prev */
			.prev , .next {
				position: absolute;
				top: 30%;
				transform: translateY(-50%);
				background-color: rgba(0, 0, 0, 0.5);
				color: white;
				border: none;
				font-size: 18px;
				padding: 10px;
				cursor: pointer;
				z-index: 100;
			}

			.prev {
				left: 0;
			}

			.next {
				right: 0;
			}

			.column {
				float: left;
				width: 100%;
				padding: 10px;
				display: flex;
			}

			.column img {
				opacity: 0.8;
				cursor: pointer;
			}

			.column img:hover {
				opacity: 1;
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

			#expandedImg {
				width: 100%;
				transition: transform 0.5s ease;
				cursor: zoom-in;
			}

			#imgtext {
				position: absolute;
				bottom: 15px;
				left: 15px;
				color: white;
				font-size: 20px;
			}

			/* No zoom effect here, we will handle it with JS */
			.zoomable {
				transition: transform 0.5s ease;
			}


			div.scroll-container {
				background-color: white;
				overflow: auto;
				white-space: nowrap;
				padding: 1px;
			}

			div.scroll-container img {
				padding: 1px;
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
			@media (min-width: 768px) {
				.col-md-6 {
					flex: 0 0 auto;
					width: 100%;
				}
			}
		</style>
	</head>

	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
		<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
			<?php include('v1_header_menu.php'); ?>
		</header>
	</header>

	<body data-theme="default" data-layout="boxed" data-sidebar="left" >
	<div class="wrapper">
		<div class="main" >
			<?php include('v1_header_nav.php'); ?>
			<main class="content" style="max-width: inherit;">
				<div class="container-fluid">



					<?php include('v1_racourci.php'); ?>

					<div class="main-section" id="mainSection"  style="margin-left: 90px;">

						<div   style="float: left;width: 45%;">
							<table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" role="grid" aria-describedby="datatables-ajax_info">
							<thead style="display: none">
							<tr>
								<th><?php echo $this->lang->line('question'); ?></th>
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						</div>
						<div  style="float:right;width: 50%;margin-right: 90px;">
							<input type="hidden" value="<?php print count($listFig) ?>" id="cmpFig" name="cmpFig">

							<div class="row" style="text-align: center;font-size: .875rem;font-weight: 400; line-height: 1.5;">

								<div class="scroll-container">

									<?php
									$counter = -1;
									foreach ($listFig as $value) {
										// Determine the width based on the number of images
										$imageWidth = '45px';//count($listFig) > 3 ? '80%' : '40%'; // Set width to 80% if more than 2 images, otherwise 30%
										$imageHeight = '45px'; //count($listFig) > 3 ? '40%' : '30%'; // Set width to 80% if more than 2 images, otherwise 30%
										$objectFit = count($listFig) > 3 ? '' : 'object-fit: initial;'; // Set width to 80% if more than 2 images, otherwise 30%

										echo '<div class="image-container" style="position: relative; display: inline-block; padding-top: 0.2rem;">';

										echo '<img src="data:image/jpeg;base64,' . $value['encryptFigure'] . '" data-name="'.$value['TitreFigure'].'"
          style="width: ' . $imageWidth . '; height: '.$imageHeight.';'.$objectFit.'; margin-left: 0.5rem; border: 0.1px solid #ccc;" 
          class="slider-image zoomable" onclick="showFig(this);" >' .
											'<div><a href="#" class="btn" style="font-size: .75rem;">' . $value['TitreFigure'] . '</a></div>';

										if (count($listFig) > 1 && ($counter + 1) < count($listFig)) {
											echo '<i id="min_' . base64_encode($value['IDFigure']) . '" class="fa fa-minus" style="display:none;padding-right: 1rem; opacity: 0; font-size: 0rem;"></i>';
										}

										echo '</div>';
										$counter++;
									}
									?>

								</div>
							</div>

							<div class="container">
								<img id="expandedImg" class="zoomable" style="width:100%" onclick="toggleZoom()">
								<div id="imgtext"></div>
							</div>

							<script>
                                let currentSlide = 0;
                                let zoomedIn = false; // Track whether zoom is active or not
                                let lastTouchX = 0, lastTouchY = 0; // For tracking touch positions

                                function moveSlide(direction) {
                                    const images = document.querySelectorAll('.slider-image');
                                    const totalImages = images.length;

                                    currentSlide = (currentSlide + direction + totalImages) % totalImages;
                                    const slider = document.getElementById('imageSlider');
                                    const slideWidth = images[0].clientWidth;
                                    slider.style.transform = 'translateX(' + (-currentSlide * slideWidth) + 'px)';
                                }

                                function showFig(imgs) {
                                    var expandImg = document.getElementById("expandedImg");
                                    var imgText = document.getElementById("imgtext");

                                    expandImg.src = imgs.src;
                                    imgText.innerHTML = imgs.alt;
                                    expandImg.parentElement.style.display = "block";

                                }

                                // Toggle zoom effect on click
                                function toggleZoom() {
                                    var expandImg = document.getElementById("expandedImg");

                                    if (!zoomedIn) {
                                        // Activate zoom on hover or touch
                                        expandImg.addEventListener("mousemove", zoomImage);
                                        expandImg.addEventListener("touchmove", zoomImageTouch);
                                        zoomedIn = true;
                                    } else {
                                        // Deactivate zoom effect
                                        expandImg.removeEventListener("mousemove", zoomImage);
                                        expandImg.removeEventListener("touchmove", zoomImageTouch);
                                        expandImg.style.transform = "scale(1)"; // Reset zoom
                                        zoomedIn = false;
                                    }
                                }

                                // Zoom effect on hover (after first click)
                                function zoomImage(e) {
                                    var img = e.target;
                                    var offsetX = e.offsetX / img.width;
                                    var offsetY = e.offsetY / img.height;
                                    var scale = 2; // The zoom scale factor

                                    img.style.transformOrigin = `${offsetX * 100}% ${offsetY * 100}%`;
                                    img.style.transform = `scale(${scale})`;
                                }

                                // Zoom effect for touch events (on mobile devices)
                                function zoomImageTouch(e) {
                                    e.preventDefault(); // Prevent default touch behavior like scrolling
                                    var img = e.target;

                                    // Calculate touch position relative to the image
                                    var touch = e.touches[0];
                                    var offsetX = (touch.clientX - img.offsetLeft) / img.width;
                                    var offsetY = (touch.clientY - img.offsetTop) / img.height;
                                    var scale = 2; // The zoom scale factor

                                    img.style.transformOrigin = `${offsetX * 100}% ${offsetY * 100}%`;
                                    img.style.transform = `scale(${scale})`;

                                    // Track touch movement for better zooming
                                    lastTouchX = touch.clientX;
                                    lastTouchY = touch.clientY;
                                }

                                // Reset zoom if touch ends
                                document.getElementById("expandedImg").addEventListener("touchend", function () {
                                    var img = document.getElementById("expandedImg");
                                    img.style.transform = "scale(1)"; // Reset zoom
                                    zoomedIn = false;
                                });

                                // Adjust zoom behavior for small screens (optional)
                                if (window.innerWidth <= 768) { // For mobile/tablet screens
                                    document.getElementById("expandedImg").style.cursor = "pointer"; // Remove the zoom-in cursor
                                }

							</script>
						</div>

					</div>

				</div>
			</main>

			<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
			<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
			<script src="<?php echo HTTP_JS; ?>app.js"></script>

			<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

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
                "pageLength": 1,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_QuestionType_list",
                    "type": "POST",
                    "data": function(d){
                        d.typeQ 	= "Qroc";
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

         function myFunction() {
            var elmsResp = document.getElementById("bt_resp");
            elmsResp.style.visibility = "hidden";
        }

        function setFig(ur='',titur='',iFig='') {

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/getURLFig",
                data: { ifFig: iFig},
                timeout: 300000,
                success: function(html) {

                    var ar =  JSON.parse(html);

                    if(ar[0]["id"]==1)
                    {
                        ur = ar[0]["desc"];
                        titur = '';// ar[0]["desc"][0]["TitreFigure"];

                        $("#figZoo").html(ur);

                    }else{
                        alert(ar[0]["desc"]);
                    }
                },
                error: function() {
                    alert("Error when call webservice to get Figure . ") ;
                }

            });

            setActiveFig(iFig);

        }


        function setActiveFig(iFig=''){
            var elms 		= document.querySelectorAll("[id='setFigStyl']");
            for(var i = 0; i < elms.length; i++)
            {
                if(elms[i].getAttribute("name")==iFig)
                {elms[i].className = 'btn btn-outline-primary active';}else{elms[i].className = 'btn btn-outline-primary';}
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
