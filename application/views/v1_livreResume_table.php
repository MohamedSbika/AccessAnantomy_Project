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

	<div class="row"  id="element" >

		<?php include('v1_racourci.php'); ?>

		<div class="col-12 col-lg-6 col-xl-6" style="float: left;width: 48%;margin-left: 45px;">
			<div class="row">
				<li class="breadcrumb-item">

					&nbsp;&nbsp;
					<div class="input-group input-group-navbar" style="padding-right: 0em;padding-left: 1em;">
						<div style="display: flex; gap: 20px;padding-top: 5px;">
							<button class="carreaux_lec" style="width: 100px;" onclick="toggleSpeech()">Lecture seule</button>
							<button class="carreaux_lec" style="width: 140px;" onclick="speak()">Lecture automatique</button>
							<button class="carreaux_lec" style="width: 70px;">Vidéos</button>
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

				<table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" role="grid" aria-describedby="datatables-ajax_info" >
					<tbody>
					</tbody>
				</table>

				<div style="margin-bottom: 20px;align-items: center;display: flex; justify-content: center;">
					<button class="carreaux_lec" id="carreaux_lec"  onclick="openModalDetailsCurs(); return false;"
							style="font-size: 10.5px; width: 184px; height: 35px; align-items: center;letter-spacing: 0.2px;">
						<b style="letter-spacing: 0.1px;">Accéder à la version détaillée</b>
					</button>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-6 col-xl-6" style="float:right;width: 48%;">
			<input type="hidden" value="<?php print count($listFig) ?>" id="cmpFig" name="cmpFig">

			<div class="row">

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
          class="slider-image zoomable" onclick="myFunction(this);" >' .
							'<div><a href="#" class="btn" style="font-size: .75rem;">' . $value['TitreFigure'] . '</a></div>';

						if ($this->session->userdata('EstAdmin') == 1) {
							echo '<a href="#" style="display: grid;" onclick="suppFigu(\'' . base64_encode($value['IDFigure']) . '\')" name="' . htmlspecialchars($value['TitreFigure']) . '" id="' . base64_encode($value['IDFigure']) . '">
                <i class="fa fa-trash-alt" title="' . htmlspecialchars($this->lang->line('actionSupp')) . '" style="font-size: 0.8rem;"></i>
              </a>';
						}

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

                function myFunction(imgs) {
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
	<?php include('v1_modal_version_detaillee_cours.php'); ?>
	</body>
	<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

	<script type='text/javascript'>

        $(document).ready(function() {

            var table_middleware_main = $('#datatables-ajax').dataTable({


                "bLengthChange": false,
                "bFilter": false,
                "bPaginate": false,
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 1,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_PagesResume_list",
                    "type": "POST",
                    "data": function(d) {
                        d.ic = "<?= $OneCurs[0]['IDResume']; ?>";
                        d.indexSearch = "<?php print $indexSearch; ?>";
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

            $("body").on("drop", function(e) {
                return false;
            });
            $("body").on("dragstart", function(e) {
                return false;
            });
            $("body").on("selectstart", function(e) {
                return false;
            });
            $("body").on("contextmenu", function(e) {
                return false;
            });
            $('body').bind('cut copy', function(e) {
                e.preventDefault();
            });
            $('body').bind('cut copy', function(e) {
                e.preventDefault();
            });

            function refresh_table() {
                table_middleware_main.fnDraw();
            }

        });

        function setFig(ur = '', titur = '', iFig = '') {

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/getURLFig",
                data: {
                    ifFig: iFig
                },
                timeout: 300000,
                success: function(html) {

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        ur = ar[0]["desc"];
                        titur = ''; // ar[0]["desc"][0]["TitreFigure"];

                        $("#figZoo").html(ur);

                    } else {
                        alert(ar[0]["desc"]);
                    }
                },
                error: function() {
                    alert("Error when call webservice to get Figure . ");
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

	<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
		<script type="text/javascript" >
            function suppFigu(idC)
            {
                if(IsFullScreenCurrently())
                    GoOutFullscreen();

                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?>'+' <br> '+tit,
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
                            data: { idC: idC} ,
                            timeout: 300000,
                            success: function(html) {

                                console.log(html);
                                var resu = JSON.parse(html);
                                console.log(resu);

                                if(resu[0]["id"]==1)
                                {
                                    // $('#namelistFig').load(" #namelistFig > *");
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
                                            document.getElementById("cmpFig").value = document.getElementById("cmpFig").value -1;
                                            const elementExists = document.getElementById("min_"+idC);
                                            if(elementExists)
                                            {document.getElementById("min_"+idC).remove();}
                                            document.getElementById(idC).remove();
                                            $("#figZoo").html('');
                                            $("[name='"+idC+"']").remove();
                                            $("[name='"+tit+"']").remove();
                                        }
                                    })

                                }else{
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
                                // SHOW AN ERROR { if php failed to fetch }

                                //$("#user_message_error_pretech").show();
                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }
		</script>
	<?php }?>

	<script>
        let isPaused = false; // Variable pour suivre l'état de la lecture
        let msg = null; // Variable pour stocker l'objet de synthèse vocale

        function toggleSpeech() {
            if (window.speechSynthesis.speaking) {
                if (isPaused) {
                    window.speechSynthesis.resume();
                    isPaused = false;
                    console.log("Lecture reprise");
                } else {
                    window.speechSynthesis.pause();
                    isPaused = true;
                    console.log("Lecture mise en pause");
                }
                return;
            }

            speak(); // Si la lecture n'a pas encore commencé, on la démarre
        }

        function speak__ok() {
            window.speechSynthesis.cancel();

            let iframe = document.getElementById('iframeID');

            if (iframe && iframe.contentWindow && iframe.contentWindow.document) {
                let textToRead = iframe.contentWindow.document.body.innerText.trim();

                if (textToRead.length > 0) {
                    let msg = new SpeechSynthesisUtterance();
                    msg.text = textToRead;

                    let lang = "<?php echo trim($this->lang->line('siteLang'), '/ '); ?>".toUpperCase();
                    msg.lang = (lang === "FR") ? "fr-FR" : "en-US";

                    function setVoice() {
                        let voices = window.speechSynthesis.getVoices();
                        console.log("Voices disponibles :", voices);

                        let maleVoiceKeywords = (lang === "FR")
                            ? ["Paul", "Thomas", "Yannick", "Google français", "Daniel", "Male", "Man"]
                            : ["David", "Mark", "John", "Google UK English Male", "Google US English Male"];

                        let maleVoice = voices.find(voice =>
                            voice.lang.startsWith(msg.lang) &&
                            maleVoiceKeywords.some(keyword => voice.name.toLowerCase().includes(keyword.toLowerCase()))
                        );

                        if (maleVoice) {
                            msg.voice = maleVoice;
                        } else {
                            let defaultVoice = voices.find(voice => voice.lang.startsWith(msg.lang));
                            if (defaultVoice) msg.voice = defaultVoice;
                        }

                        console.log("Voix sélectionnée :", msg.voice ? msg.voice.name : "Aucune voix trouvée");

                        // Événement déclenché à chaque mot lu
                        msg.onboundary = function (event) {
                            let spokenText = msg.text.substring(event.charIndex, event.charIndex + event.charLength);
                            console.log("Mot détecté :", spokenText);

                            // Utilisation de la regex pour détecter "fig" suivi de n'importe quel chiffre de 1 à 200
                            let regex = /\bfig[\.\s]?(0?[1-9]|1[0-9]{1,2}|200)\b/i;
                            if (regex.test(spokenText)) {
                                alert("Mot 'fig' détecté avec un nombre : " + spokenText);
                            }
                        };

                        window.speechSynthesis.speak(msg);
                    }

                    if (window.speechSynthesis.getVoices().length > 0) {
                        setVoice();
                    } else {
                        window.speechSynthesis.onvoiceschanged = () => {
                            setTimeout(setVoice, 100);
                        };
                    }
                } else {
                    alert("Aucun texte à lire !");
                }
            } else {
                alert("Impossible d'accéder au contenu !");
            }
        }

        function speak__ok_detect_all_fig_au_debut() {
            window.speechSynthesis.cancel();

            let iframe = document.getElementById('iframeID');

            if (iframe && iframe.contentWindow && iframe.contentWindow.document) {
                let textToRead = iframe.contentWindow.document.body.innerText.trim();

                if (textToRead.length > 0) {
                    let msg = new SpeechSynthesisUtterance();
                    msg.text = textToRead;

                    let lang = "<?php echo trim($this->lang->line('siteLang'), '/ '); ?>".toUpperCase();
                    msg.lang = (lang === "FR") ? "fr-FR" : "en-US";

                    let detectedText = ""; // Stocke les parties lues progressivement

                    function setVoice() {
                        let voices = window.speechSynthesis.getVoices();
                        console.log("Voices disponibles :", voices);

                        let maleVoiceKeywords = (lang === "FR")
                            ? ["Paul", "Thomas", "Yannick", "Google français", "Daniel", "Male", "Man"]
                            : ["David", "Mark", "John", "Google UK English Male", "Google US English Male"];

                        let maleVoice = voices.find(voice =>
                            voice.lang.startsWith(msg.lang) &&
                            maleVoiceKeywords.some(keyword => voice.name.toLowerCase().includes(keyword.toLowerCase()))
                        );

                        if (maleVoice) {
                            msg.voice = maleVoice;
                        } else {
                            let defaultVoice = voices.find(voice => voice.lang.startsWith(msg.lang));
                            if (defaultVoice) msg.voice = defaultVoice;
                        }

                        console.log("Voix sélectionnée :", msg.voice ? msg.voice.name : "Aucune voix trouvée");

                        // Événement déclenché à chaque passage de texte lu
                        msg.onboundary = function (event) {
                            let fullText = msg.text.substring(event.charIndex).trim();
                            console.log("Texte en cours de lecture :", fullText);

                            // Nettoyage du texte
                            let cleanedText = fullText.replace(/[\(\),;!?]/g, '').trim();

                            // Détection de "Fig.X" avec ou sans espace ou point
                            let regex = /\b[Ff]ig[\.\s]?(0?[1-9]|[1-9][0-9]|1[0-9]{2}|200)\b/g;

                            let match = cleanedText.match(regex);
                            if (match) {
                                console.log("Mot 'Fig' détecté avec un nombre : " + match[0]);
                            }
                        };

                        // Démarrer la lecture
                        window.speechSynthesis.speak(msg);
                    }

                    // Vérification si les voix sont déjà chargées
                    if (window.speechSynthesis.getVoices().length > 0) {
                        setVoice();
                    } else {
                        window.speechSynthesis.onvoiceschanged = () => {
                            setTimeout(setVoice, 100);
                        };
                    }
                } else {
                    alert("Aucun texte à lire !");
                }
            } else {
                alert("Impossible d'accéder au contenu !");
            }
        }

        function speak() {
            window.speechSynthesis.cancel();

            let iframe = document.getElementById('iframeID');

            if (iframe && iframe.contentWindow && iframe.contentWindow.document) {
                let textToRead = iframe.contentWindow.document.body.innerText.trim();

                if (textToRead.length > 0) {
                    let msg = new SpeechSynthesisUtterance();
                    msg.text = textToRead;

                    let lang = "<?php echo trim($this->lang->line('siteLang'), '/ '); ?>".toUpperCase();
                    msg.lang = (lang === "FR") ? "fr-FR" : "en-US";

                    function setVoice() {
                        let voices = window.speechSynthesis.getVoices();
                        console.log("Voices disponibles :", voices);

                        let maleVoiceKeywords = (lang === "FR")
                            ? ["Paul", "Thomas", "Yannick", "Google français", "Daniel", "Male", "Man"]
                            : ["David", "Mark", "John", "Google UK English Male", "Google US English Male"];

                        let maleVoice = voices.find(voice =>
                            voice.lang.startsWith(msg.lang) &&
                            maleVoiceKeywords.some(keyword => voice.name.toLowerCase().includes(keyword.toLowerCase()))
                        );

                        if (maleVoice) {
                            msg.voice = maleVoice;
                        } else {
                            let defaultVoice = voices.find(voice => voice.lang.startsWith(msg.lang));
                            if (defaultVoice) msg.voice = defaultVoice;
                        }

                        console.log("Voix sélectionnée :", msg.voice ? msg.voice.name : "Aucune voix trouvée");

                        msg.onboundary = function (event) {
                            let fullText = msg.text.substring(event.charIndex).trim();
                            console.log("Texte en cours de lecture :", fullText);

                            let cleanedText = fullText.replace(/[\(\),;!?]/g, '').trim();

                            let regex = /\b[Ff]ig[\.\s]?(0?[1-9]|[1-9][0-9]|1[0-9]{2}|200)\b/g;

                            let match = cleanedText.match(regex);
                            if (match) {
                                let figName = match[0].replace(/\./g, '').replace(/\s/g, '');
                                figName = figName.replace(/Fig0+(\d+)/, "Fig$1"); // Supprime le zéro devant

                                // alert("Mot 'Fig' détecté avec un nombre : " + figName);

                                // Recherche de l'image correspondante (exacte ou avec un intervalle FigX-Y)
                                let targetImg = document.querySelector(`img[data-name="${figName}"]`) ||
                                    [...document.querySelectorAll('img[data-name]')].find(img => {
                                        let rangeMatch = img.getAttribute("data-name").match(/Fig(\d+)-(\d+)/);
                                        if (rangeMatch) {
                                            let start = parseInt(rangeMatch[1], 10);
                                            let end = parseInt(rangeMatch[2], 10);
                                            let detectedNumber = parseInt(figName.replace("Fig", ""), 10);
                                            return detectedNumber >= start && detectedNumber <= end;
                                        }
                                        return false;
                                    });

                                if (targetImg) {
                                    console.log("Image trouvée, déclenchement du clic :", targetImg);
                                    targetImg.click(); // Simuler le clic
                                } else {
                                    console.warn("Aucune image trouvée avec data-name =", figName);
                                }
                            }
                        };

                        window.speechSynthesis.speak(msg);
                    }

                    if (window.speechSynthesis.getVoices().length > 0) {
                        setVoice();
                    } else {
                        window.speechSynthesis.onvoiceschanged = () => {
                            setTimeout(setVoice, 100);
                        };
                    }
                } else {
                    alert("Aucun texte à lire !");
                }
            } else {
                alert("Impossible d'accéder au contenu !");
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
