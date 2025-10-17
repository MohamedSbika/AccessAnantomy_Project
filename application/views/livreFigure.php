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
            background-color: white;
        }

        .row {
            --bs-gutter-x: 0px;
        }

        .card-header {
            padding: 0rem 0rem;
        }

        #element {


            width: 100%;
            background-color: white;
            font-size: 20px;
            text-align: center;
            box-sizing: border-box;
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
            background-color: white;
            margin: 0;
        }

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

        .active,
        .dot:hover {
            /*background-color: #717171;*/
            background-color: #c5daef;
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
    </style>

    <body>

        <div id="element" style="background:white !important;">
            <div style="height:100vh !important; overflow-y:scroll;">
                <div style="height: 50%;float: left;" class="col-12 col-lg-3 col-xl-3">
                    <div class="row">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login"><?php echo $this->lang->line('accueil'); ?></a>
                            &nbsp;&nbsp;
                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a>
                            <a class="badge bg-success text-white ml-2" id="go-button" href="#" style="float:right; background-color: #8f84d9 !important;"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
                        </li>
                    </div>
                    <div class="row">
                    </div>
                </div>

                <div style="float: left; position:relative; " class="col-12 col-lg-6 col-xl-6">

                    <div class="card-body" style="padding: 0rem; position:fixed; z-index:20; width:200px;" id="namelistFig">
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
                    <div class="card-body" style="padding: 0rem; position:relative;" id="blockImages">
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
                                    <img src="data:image/png;base64,<?= $value['encryptFigure']; ?>" height="auto" style="width: 100%" />
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

                <div style="float: right;height: 50%;" class="col-12 col-lg-3 col-xl-3">

                </div>

            </div>

        </div>

    </body>

    <script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/fig_zoom_js.js"></script>

    <script src="<?php echo HTTP_JS; ?>app.js"></script>

    <script type='text/javascript'>
        $(document).ready(function() {

            /*var element = document.getElementById("namelistFig")
            console.log(element[0].offsetHeight)

            var zooms = document.getElementsByClassName("zoom")
            for(let i = 0; i < zooms.length; i++){
                zooms[i].setAttribute("style", "height:"+element[0].offsetHeight+"px; overflow-y:auto;")
            }*/

            var blockImages = document.getElementById("blockImages")
            var namelistFig = document.getElementById("namelistFig")
            namelistFig.setAttribute("style", "padding: 0rem; margin-right:-50px; position:fixed; z-index:20; width:"+blockImages.offsetWidth +"px;")
            blockImages.setAttribute("style", "padding: 0rem; position:relative; margin-top:"+namelistFig.offsetHeight +"px;")
           

            <?php $counter = 1;
            foreach ($listFig as $value) { ?>
                //$('#ex<?= $counter; ?>').zoom({ on:'click' });
            <?php $counter++;
            } ?>


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
                        else{
                            var blockImages = document.getElementById("blockImages")
                            var namelistFig = document.getElementById("namelistFig")
                            namelistFig.setAttribute("style", "padding: 0rem; margin-right:-50px; position:fixed; z-index:20; width:"+blockImages.offsetWidth +"px;")
                            blockImages.setAttribute("style", "padding: 0rem; position:relative; margin-top:"+namelistFig.offsetHeight +"px;")
                            GoInFullscreen($("#element").get(0));
    
                        }
                    }
                })
            }


        });

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



        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
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
        if (document.getElementById('iframeID') instanceof Object) {

        }
        if (top.location.href != window.location.href) {
            window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>' + 'login';
        }

        //disable cut copy past
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
        document.oncontextmenu = new Function("return false")


        //for disable select option
        document.onselectstart = new Function('return false');

        function dMDown(e) {
            return false;
        }

        function dOClick() {
            return true;
        }
        document.onmousedown = dMDown;
        document.onclick = dOClick;
    </script>
    <script language="JavaScript">
        window.onload = function() {

            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function(e) {
                //document.onkeydown = function(e) {
                //"I" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                    disabledEvent(e);
                }
                //"J" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                    disabledEvent(e);
                }
                //"S" key + macOS
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    disabledEvent(e);
                }
                //"U" key
                if (e.ctrlKey && e.keyCode == 85) {
                    disabledEvent(e);
                }
                //"F12" key
                if (event.keyCode == 123) {
                    disabledEvent(e);
                }
            }, false);

            function disabledEvent(e) {
                if (e.stopPropagation) {
                    e.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
                e.preventDefault();
                return false;
            }
        }
        //edit: removed ";" from last "}" because of javascript error
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
                                            //location.reload();
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
    <?php } ?>

    </html>

<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>