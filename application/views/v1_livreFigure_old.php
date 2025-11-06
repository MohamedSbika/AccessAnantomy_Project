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

		<style type="text/css">
			body {
				margin: 0;
				font-size: 0px;
				background-color: white;
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

			.my-1 {
				margin-top: .0rem !important;
			}

			/* webkit requires explicit width, height = 100% of sceeen */
			/* webkit also takes margin into account in full screen also - so margin should be removed (otherwise black areas will be seen) */

			.image-item img {
				margin-left: 0;
				margin-top: 0;
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

			.toolbar {
				display: none !important;
			}

			.btn-outline-primary.hover {
				background-color: #c5daef;
			}

			.btn-outline-primary.active {
				background-color: #c5daef;
			}


			.image {
				width: 100%;
				height: 100%;
			}

			.image img {
				/* La transition s'applique à la fois sur la largeur et la hauteur, avec une durée d'une seconde. */
				-webkit-transition: all 1s ease;
				/* Safari et Chrome */
				-moz-transition: all 1s ease;
				/* Firefox */
				-ms-transition: all 1s ease;
				/* Internet Explorer 9 */
				-o-transition: all 1s ease;
				/* Opera */
				transition: all 1s ease;
			}

			.image:hover img {
				/* L'image est grossie de 25% */
				-webkit-transform: scale(1.25);
				/* Safari et Chrome */
				-moz-transform: scale(1.25);
				/* Firefox */
				-ms-transform: scale(1.25);
				/* Internet Explorer 9 */
				-o-transform: scale(1.25);
				/* Opera */
				transform: scale(1.25);
			}


			/* magnifying glass icon */

			.demo_container {
				margin: 0 auto;
			}

			.zoom {

				position: relative;
				clear: both;
				/*cursor: zoom-in;*/
			}

			/* magnifying glass icon */
			.zoom:after {
				content: '';
				display: block;
				width: 100px;
				height: 100px;
				position: absolute;
				top: 0;
				right: 0;

			}

			.zoom img {
				display: block;
			}

			.zoom img::selection {
				background-color: transparent;
			}


			* {
				box-sizing: border-box
			}

			/* Slideshow container */
			.slideshow-container {
				max-width: 1000px;
				position: relative;
				margin: auto;
			}

			/* Hide the images by default */
			.mySlides {
				display: none;
			}

			/* Next & previous buttons */
			.prev,
			.next {
				cursor: pointer;
				position: absolute;
				top: 50%;
				width: auto;
				margin-top: -22px;
				padding: 16px;
				color: black;
				font-weight: bold;
				font-size: 18px;
				transition: 0.6s ease;
				border-radius: 0 3px 3px 0;
				user-select: none;
			}

			/* Position the "next button" to the right */
			.prev {
				left: -10%;
			}

			.next {
				right: -10%;
				border-radius: 3px 0 0 3px;
			}

			/* On hover, add a black background color with a little bit see-through */
			.prev:hover,
			.next:hover {
				background-color: rgba(0, 0, 0, 0.8);
			}

			/* Caption text */
			.text {
				color: #f2f2f2;
				font-size: 15px;
				padding: 8px 12px;
				position: absolute;
				bottom: 8px;
				width: 100%;
			}

			/* Number text (1/3 etc) */
			.numbertext {
				color: #f2f2f2;
				font-size: 12px;
				padding: 8px 12px;
				position: absolute;
				top: 0;
			}

			/* The dots/bullets/indicators */
			.dot {
				cursor: pointer;
				margin: 0 2px;
				/*background-color: #bbb;*/
				background-color: transparent;
				border-radius: 10%;
				display: inline-block;
				transition: background-color 0.6s ease;
				font-size: 1rem;
			}

			/* Fading animation */
			.fade {
				-webkit-animation-name: fade;
				-webkit-animation-duration: 1.5s;
				animation-name: fade;
				animation-duration: 1.5s;
			}

			@-webkit-keyframes fade {
				from {
					opacity: .4
				}

				to {
					opacity: 1
				}
			}

			@keyframes fade {
				from {
					opacity: .4
				}

				to {
					opacity: 1
				}
			}

			.fade:not(.show) {
				opacity: 1;
			}
			.dot {
				cursor: pointer;
				margin: 0 2px;
				background-color: transparent;
				border-radius: 10%;
				display: inline-block;
				transition: background-color 0.3s ease;
				font-size: 1rem;
				padding: 5px;
			}

			.dot.active {
				background-color: #c5daef; /* Light blue background for active dot */
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

	<body>

	<div id="element" style="background:white !important;">
		<?php include('v1_header_nav.php'); ?>

		<?php include('v1_racourci.php'); ?>


		<div style="/*height:100vh !important; */overflow-y:scroll;">

			<div style="position: relative; float: none;margin: 0 auto; display: flex;flex-direction: column;align-items: center;justify-content: center; gap: 10px;"
				 class="col-12 col-lg-6 col-xl-6" id="bloc_img_fig">

				<div class="card-body" style="padding: 0rem; z-index:20; width:200px;" id="namelistFig">
					<div style="text-align:center; background-color:white; ">

						<?php $counter = 1;
						foreach ($listFig as $value) { ?>
							<?php if ($counter > 1) { ?> <i id="min_<?php print base64_encode($value['IDFigure']); ?>" class="fa fa-minus" style="font-size: 0.8rem;"></i> <?php } ?>
							<span id="Nam_<?php print base64_encode($value['IDFigure']); ?>" class="dot" onclick="currentSlide(<?= $counter; ?>)"><?= $value['TitreFigure']; ?></span>

							<a href="#" onclick="suppFigu('<?php print base64_encode($value['IDFigure']); ?>')" name="<?php print $value['TitreFigure']; ?>" id="<?php print base64_encode($value['IDFigure']); ?>">
								<i class="fa fa-trash-alt" style="font-size: 0.8rem;"></i>
							</a>
							<?php $counter++;
						} ?>
					</div>
				</div>
				<div class="card-body" style="/*padding: 0rem;*/ position:relative;" id="blockImages">
					<!-- The dots/circles -->
					<input type="hidden" value="<?php print count($listFig)  ?>" id="cmpFig" name="cmpFig">


					<!-- Slideshow container -->
					<div class="slideshow-container">

						<!-- Full-width images with number and caption text -->
						<?php $counter = 1;
						foreach ($listFig as $value) { ?>
							<div class="mySlides fade" style="text-align: center" id="Fig_<?php print base64_encode($value['IDFigure']); ?>">
								<?php if ($paramsCurs == 100) {
									$scrl = 'scroll';
									$nbSh = 0;
								} else {
									$scrl = 'hidden';
									$nbSh = 100 - $paramsCurs;
								} ?>
								<!--<span class="zoom" id="ex<?= $counter; ?>" style="overflow-y: <?= $scrl; ?>;display: inline-block;height: calc(100vh - <?= $nbSh; ?>vh);">-->
								<img src="data:image/png;base64,<?= $value['encryptFigure']; ?>" height="auto" style="width: 100%;max-height: 45vw;" />
								<!--</span>-->
							</div>
							<?php $counter++;
						} ?>

						<?php if (($counter - 1) > 1) { ?>
							<!-- Next and previous buttons -->
							<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
							<a class="next" onclick="plusSlides(1)">&#10095;</a>
						<?php  } ?>

					</div>



				</div>
			</div>

		</div>

	</div>

	</body>

	<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/fig_zoom_js.js"></script>

	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type='text/javascript'>
        $(document).ready(function() {

            var blockImages = document.getElementById("blockImages")
            var namelistFig = document.getElementById("namelistFig")
            namelistFig.setAttribute("style", "padding: 0rem; margin-right:-50px; z-index:20; width:"+blockImages.offsetWidth +"px;")
            blockImages.setAttribute("style", "position:relative;")

			<?php $counter = 1;
			foreach ($listFig as $value) { ?>
            //$('#ex<?= $counter; ?>').zoom({ on:'click' });
			<?php $counter++;
			} ?>

        });

	</script>

	<script>

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);

            var dots = document.getElementsByClassName("dot");
            for (var i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }

            dots[n - 1].classList.add("active");
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";

        }

        if (document.getElementById('iframeID') instanceof Object) {

        }
        if (top.location.href != window.location.href) {
            window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>' + 'login';
        }

        var message = "";

        function clickIE() {
            if (document.all) {
                (message);
                return false;
            }
        }

        function clickNS(e) {
            if (document.layers || (document.getElementById && !document.all)) {
                if (e.which == 2 || e.which == 3) {
                    (message);
                    return false;
                }
            }
        }
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN);
            document.onmousedown = clickNS;
        } else {
            document.onmouseup = clickNS;
            document.oncontextmenu = clickIE;
        }




        function dMDown(e) {
            return false;
        }

        function dOClick() {
            return true;
        }
        document.onmousedown = dMDown;
        document.onclick = dOClick;
	</script>

	<?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

		<script type="text/javascript">
            function suppFigu(idC) {
                if (IsFullScreenCurrently())
                    GoOutFullscreen();

                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textFig'); ?>',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
                }).then((result) => {
                    if (result.value) {

                        Swal.fire({
                            title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        })

                        $.ajax({

                            type: "POST",
                            url: "<?php echo base_url(); ?>home/suppFigu",
                            data: {
                                idC: idC
                            },
                            timeout: 300000,
                            success: function(html) {

                                console.log(html);
                                var resu = JSON.parse(html);
                                console.log(resu);

                                if (resu[0]["id"] == 1) {
                                    Swal.fire({
                                        title: resu[0]["desc"],
                                        position: 'center',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'OK',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.value) {
                                            document.getElementById("cmpFig").value = document.getElementById("cmpFig").value - 1;
                                            var cmpFig = document.getElementById("cmpFig").value;

                                            if (cmpFig == 0) {
                                                window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>' + 'livreDetails/' + '<?php print $OneBook[0]["IDLivre"] ?>';
                                            } else {

                                                document.getElementById(idC).remove();
                                                document.getElementById("Nam_" + idC).remove();
                                                document.getElementById("Fig_" + idC).remove();
                                                document.getElementById("min_" + idC).remove();
                                                plusSlides(1);
                                            }

                                        }
                                    })

                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'error',
                                        title: resu[0]["desc"],
                                        showConfirmButton: false,
                                        timer: 4000
                                    })
                                }


                            },
                            error: function() {

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }
		</script>
	<?php } ?>

	</html>

<?php } else { ?>

	<?php
	header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
	exit();
	?>

<?php } ?>
