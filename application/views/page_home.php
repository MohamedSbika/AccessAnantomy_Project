<?php
include('header.php');
?>

<?php

if($_SERVER['REQUEST_URI'] === "" || $_SERVER['REQUEST_URI'] === "/"){
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
}
//header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
//exit();
?>


<style>
    #couvImg {
        transition: transform 0.3s;
    }

    #couvImg:hover {
        transform: scale(1.1);
        /*box-shadow: 1px 1px 2px grey, -1px -1px 2px grey;*/
        box-shadow: 10px 10px 5px #ccc;
    }

    .containerSo {
        position: relative;
    }

    /* Bottom right text */
    .text-block {
        position: absolute;
        color: white;
        top: 8px;
        left: 16px;
    }

    @import url('https://fonts.googleapis.com/css?family=Poppins:900i');

    /**************SVG****************/

    path.one {
        transition: 0.4s;
        transform: translateX(-60%);

        animation: color_anim 1s infinite 0.4s;
    }

    path.two {
        transition: 0.5s;
        transform: translateX(-30%);
    }

    path.three {
        animation: color_anim 1s infinite 0.2s;
    }

    path.one {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.6s;
    }

    path.two {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.4s;
    }

    /* SVG animations */

    @keyframes color_anim {
        0% {
            fill: white;
        }

        50% {
            fill: #FBC638;
        }

        100% {
            fill: white;
        }
    }

    @font-face {
        font-family: "League Spartan Black";
        src: url(/assets/TYPO/LeagueSpartan-Black.ttf) format("truetype");
    }

    @font-face {
        font-family: "League Spartan Regular";
        src: url(<?php echo base_url('assets/TYPO/LeagueSpartan-Regular.ttf'); ?>) format("truetype");
    }

    @media only screen and (min-width: 800px) {
        .slider-p {
            margin-left: 40px;
        }
    }



    .slider-p p {
        font-family: "League Spartan Regular";
        font-size: 40px;
        color: blue;
        text-align: center;
        font-weight: 900;
        letter-spacing: 3px;
    }

    .slider-span1 {
        font-size: 44px;
        font-weight: 600;
        letter-spacing: 3px;
    }

    .slider-span2 {
        color: green;
        font-size: 41px;
    }

    #categories {
        background-color: rgb(144, 203, 185);
    }

    .categorie-title p {
        font-family: "League Spartan Regular";
        font-size: 34px;
        color: white;
        text-align: center;
        font-weight: 500;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .categorie-title p span {
        font-size: 36px;
    }

    .box-item {
        position: relative;
    }

    .item-categorie {
        background-color: white;
        border-radius: 5px;
        margin: 15px 0px;
        padding: 10px;
        padding-top: 30px;
        padding-left: 20px;
        height: 90%;
    }

    .item-categorie div {
        margin-bottom: 10px;
    }

    .item-categorie div {
        display: flex;
        flex-wrap: nowrap;
        flex-direction: line;
        height: 50px;
    }

    .item-categorie h3 {
        color: rgb(59, 145, 118);
        font-family: "League Spartan Regular";
        font-size: 25px !important;
        font-weight: 600;
        margin-top: auto;
        margin-bottom: auto;
    }

    .item-categorie p {
        color: rgb(114, 114, 114) !important;
        font-family: "League Spartan Regular";
        font-size: 17px !important;

    }

    .covertures {
        margin-top: 50px;
        margin-bottom: 30px;
    }

    .covertures div {
        padding-left: 20px;
        padding-right: 20px;
    }

    @media only screen and (min-width: 573px) {
        .covertures div {
            padding-left: 5px;
            padding-right: 5px;
        }
    }

    @media only screen and (min-width: 800px) {
        .covertures div {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    .covertures-item {
        padding: 50px;
    }

    .formulaire {
        padding: 50px 0px;
        background-color: rgb(12, 105, 108);
    }

    .formulaire-2 {
        text-align: center;
        padding: 30px;
    }

    .box {
        padding: 10px 30px;
    }

    .label-page-categorie {
        font-size: 30px;
        font-family: "League Spartan Regular";
        color: white;
        padding: 10px;
    }

    .textarea-page-categorie {
        max-width: 700px !important;
        font-size: 30px;
        font-family: "League Spartan Regular";
        border-radius: 15px;
        border: none;
        margin-left: auto;
        margin-right: auto;
    }

    .input-page-categorie {
        max-width: 400px !important;
        font-size: 30px;
        font-family: "League Spartan Regular";
        border-radius: 15px;
        border: none;
        margin-left: auto;
        margin-right: auto;
    }

    #slider {
        background-image: url('<?php echo HTTP_IMAGES; ?>slider1.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        padding-top: 10vh;
    }

    .item-categorie img {
        height: 35px;
        margin: 5px;
    }

    .image-couverture {
        transform: scale(1);
        /* you need a scale here to allow it to transition in both directions */
        transition: transform 0.3s;

    }

    .image-couverture:hover {
        transform: scale(1.1);
        box-shadow: 10px 10px 5px rgba(9, 138, 99);

    }

    .videos {
        padding: 50px 40px;
        text-align: center;
        background: #ebe9ea;
        position:relative;
    }

    @media only screen and (max-width: 800px) {
        .videos {
            padding: 50px 0px;
        }
    }

    .videos h1{
        font-family: "League Spartan Regular";
        font-size: 40px;
        color: blue;
        text-align: center;
        font-weight: 900;
        letter-spacing: 3px;
    }
    .tilesWrap {
        padding: 0;
        margin: 10px auto;
        list-style: none;
        text-align: center;
    }

    .tilesWrap .dropdown{
        padding-left: 4px;
        position: absolute;
        top: -10px;
    }

    .tilesWrap .couche-tilesWrap{
        top:0px;
        left:0px;
        position:absolute;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0);
        z-index:5;
    }

    .tilesWrap .titreAndImage{
        bottom:0px;
        left:0px;
        width:100%;
        position:absolute;
        height: content;
        z-index:7;
        background:none;
        transition: all 0.3s ease-in-out;
        /* transform: translateY(+10px); */
        opacity: 0;
        text-align: center;
    }

    .tilesWrap .li-item .titreAndImage{
        /* transform: translateY(+50px); */
        top:0px;
        bottom:0px;
        left:0px;
        right:0px;
        margin-top:auto;
        max-height: 50%;
        opacity: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .tilesWrap .sous-li-item:hover .couche-tilesWrap{
        background:rgba(0,0,0,0.4);
    }

    /* .tilesWrap .li-item:hover .titreAndImage{
        transform: translateY(+50px);
        opacity: 1;
    } */



    .tilesWrap .li-item {
        display: inline-block;
        padding: 30px;
        margin:5px;
        font-family: 'helvetica', san-serif;
        background: transparent;
        /* border: 1px solid #252727; */
        margin-left: auto;
        margin-right: auto;
        position: relative;
    }

    .tilesWrap .li-item .sous-li-item{
        transform: scale(1);
        /* you need a scale here to allow it to transition in both directions */
        transition: transform 0.3s;
    }

    .tilesWrap .li-item .sous-li-item:hover {
        overflow: hidden;
        transform: scale(1.05);
        box-shadow: 10px 10px 5px rgba(9, 138, 99);
    }

    .tilesWrap .li-item h2 {
        /* font-size: 114px; */
        margin: 0px;
        width: 50px;
        /* position: absolute; */
        left: 50%;
        margin-left: -25px;

        z-index:7;
        opacity: 1;
        /* top:0;
        bottom:0;
        right:0;
        left:0; */
        margin:auto;
        transition: all 0.3s ease-in-out;
    }

    .tilesWrap .li-item h3 {
        font-size: 20px;
        padding:10px;
        color: #b7b7b7;
        margin-bottom: 5px;
        margin-top:10px;
    }

    .tilesWrap .li-item h3 a {
        font-family: "League Spartan Regular";
        /* color: #b7b7b7; */
        color: white !important;
        text-decoration:none !important;
    }
    .tilesWrap .li-item p {
        font-size: 16px;
        line-height: 18px;
        color: #b7b7b7;
        margin-top: 5px;
    }
    .tilesWrap .li-item button {
        background: rgba(9, 138, 99, 0.75);
        border: 2px solid white;
        padding: 5px 5px;
        margin-left:5px;
        color: #b7b7b7;
        position:relative;
        border-radius: 3px;
        transition: all 0.3s ease-in-out;
        /* transform: translateY(-40px); */
        opacity: 0;
        cursor: pointer;
        overflow: hidden;
        z-index:10;
        /* top:0;
        bottom:0;
        left:0;
        right:0; */
        margin:auto;
        font-size: 20px;
        height: 50px;
        width: 180px;

    }

    .tilesWrap .li-item button:before {
        content: '';
        position: absolute;
        height: 100%;
        width: 120%;
        background: white;
        top: 0;
        opacity: 0;
        left: -140px;
        border-radius: 0 20px 20px 0;
        z-index: -1;
        transition: all 0.3s ease-in-out;
    }

    .tilesWrap .sous-li-item button {
        transform: translateY(-10px);
        opacity: 1;
    }



    .tilesWrap .li-item button:hover {
        color: #262a2b;
    }

    .tilesWrap .li-item button a{
        /* color: #b7b7b7 !important; */
        color: white !important;
        text-decoration: none;
        font-weight:900;
    }
    .tilesWrap .li-item button:hover a{
        color: rgba(9, 138, 99) !important;
        text-decoration: none;
    }
    .tilesWrap .li-item button:hover:before {
        left: 0;
        opacity: 1;
    }

    .tilesWrap .sous-li-item h2 {
        /* transform: translateY(110px); */
        bottom: 0px;
        opacity: 1;
    }

    .tilesWrap .li-item h2 {
        bottom: 0px;
        opacity: 1;
    }

    .tilesWrap .li-item h2 a i{
        left: 0;
        opacity: 1;
    }


    .tilesWrap .li-item h2 div i {
        background:rgba(9, 138, 99, 0.75);
        color: rgba(255, 255, 255, 0.75);
        border-radius: 50%;
        margin-right:2px;
        font-size:60px;
        margin-bottom:65px;
        border:1px white solid;
    }

    .tilesWrap .li-item h2 div i:hover {
        background:white !important;
        color:rgba(9, 138, 99, 0.75);
    }



    /* .tilesWrap div{
      background: #262a2b;
      z-index: 2;
      position: relative;
      padding: 10px;
      min-height: 173px;
    } */

</style>

<body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">
<?php
include('header_steppes.php');
?>

<div class="wrapper">

    <div class="main" style="min-height:auto;" ondragstart="return false">


        <main class="content">

            <section id="slider" style="position:relative;">
                <script>
                    var windowWidth = window.screen.width < window.outerWidth ?
                        window.screen.width : window.outerWidth;
                    var mobile = windowWidth < 700;

                    if (!mobile) {
                        var viewport_height = window.innerHeight;
                        var viewport_height2 = document.getElementById("setNAVSTEPPS").clientHeight;

                        document.getElementById("slider").setAttribute("style", "height:" + (viewport_height - viewport_height2) + "px;")
                    }
                </script>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-9 slider-p">
                            <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                <p> <span class="slider-span1">Access Anatomy </span>est la source la plus fiable
                                    <br> de <span class="slider-span2">l'ANATOMIE</span> et de <span class="slider-span2">l'EMBROYOLOGIE</span>
                                </p>
                            <?php } else { ?>
                                <p> <span class="slider-span1">Access Anatomy </span>is the most reliable source <br> for <span class="slider-span2">Anatomy</span> and <span class="slider-span2">Embryology</span> </p>
                            <?php } ?>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </div>
            </section>


            <section id="cat_desc" style="background-color: #6f75e4;">
                <div class="container">
                    <div class="row categorie-title">
                        <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                            <p>242 cours très fiables, agrémentés de 1624 schémas colorés et d'une qualité exceptionnelle<br> <span>3400 QCM</span> sont formulées selon une méthode pédagogique qui facilite l'apprentissage et la mémorisation <br>
                                <span>1600 QROC</span> permettent aux étudiants une mémorisation synthétique
                            </p>
                        <?php } else { ?>
                            <p>242 highly reliable courses, enhanced by 1624 colorful, high quality diagrams<br> <span>3400 MCQ</span> are formulated according to a pedagogical method that facilitates learning and memorization <br>
                                <span>1600 SAQ</span> allow students a synthetic memorization
                            </p>
                        <?php } ?>

                    </div>
                </div>
            </section>

            <section id="categories">
                <div class="container" style="max-width: 1320px;">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="col-md-12 box-item">
                                <div class="item-categorie" style="background-color: #90cbb9; text-align: center;">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <span style="display: inline-block; color: white; font-size: 25px;" class="slider-span2">SUPPORTS ACADEMIQUES</span>
                                    <?php } else { ?>
                                        <span style="display: inline-block; color: white; font-size: 25px;" class="slider-span2">ACADEMIC SUPPORTS</span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-12 box-item">
                                <div class="item-categorie">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <div>
                                            <h3> COURS D'ANATOMIE</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon1.png">
                                        </div>
                                        <p> Une référence exhaustive simple et excellente illustrée avec une page de texte à gauche et une page de schémas à droite</p>
                                    <?php } else { ?>
                                        <div>
                                            <h3> Courses of Anatomy</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon1.png">
                                        </div>
                                        <p> A comprehensive, simple and excellent reference, illustrated with a page of text on the left and a page of diagrams on the right</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 box-item">
                                <div class="item-categorie">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <div>
                                            <h3> QCM</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon2.png">
                                        </div>
                                        <p> 3400 QCM sont formulées selon une méthode pédagogique, qui facilite l’apprentissage et la mémorisation. Elles donnent aux étudiants la capacité de répondre à toutes les questions quelle que soit leur origine.</p>
                                    <?php } else { ?>
                                        <div>
                                            <h3> MCQ</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon2.png">
                                        </div>
                                        <p> 3400 MCQ are formulated according to a pedagogical method, which facilitates learning and memorization. They give students the ability to answer all questions regardless of their origin</p>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="col-md-12 box-item">
                                <div class="item-categorie">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <div>
                                            <h3> QROC</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon3.png">
                                        </div>
                                        <p>1600 QROC résument les principales structures anatomiques, permettant aux étudiants une mémorisation synthétique</p>
                                    <?php } else { ?>
                                        <div>
                                            <h3> SAQ</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon3.png">
                                        </div>
                                        <p>1600 SAQ summarise the main anatomical structures, allowing students to memorise them in a synthetic way</p>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="col-md-12 box-item">
                                <div class="item-categorie">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <div>
                                            <h3> TEST</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon3.png">
                                        </div>

                                        <p>- Test QCM : 20 questions dans chaque essai <br>
                                            - Test QROC : 10 questions dans chaque essai <br>
                                            - Test légendes des Atlas
                                        </p>
                                    <?php } else { ?>
                                        <div>
                                            <h3> TEST</h3>
<img src="<?php echo HTTP_IMAGES; ?>icons/icon4.png">
                                        </div>

                                        <p>- MCQ Test : 20 questions in each essay <br>
                                            - QROC Test : 10 questions in each essay <br>
                                            - Atlas legends Test
                                        </p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <style>
                                ul.timeline {
                                    list-style-type: none;
                                    position: relative;
                                }
                                ul.timeline:before {
                                    content: ' ';
                                    background: rgb(59, 145, 118);
                                    display: inline-block;
                                    position: absolute;
                                    left: 29px;
                                    width: 2px;
                                    height: 100%;
                                    z-index: 400;
                                }
                                ul.timeline > li {
                                    margin: 20px 0;
                                    padding-left: 20px;
                                }
                                ul.timeline > li:before {
                                    content: ' ';
                                    background: white;
                                    display: inline-block;
                                    position: absolute;
                                    border-radius: 50%;
                                    border: 3px solid rgb(59, 145, 118);
                                    left: 20px;
                                    width: 20px;
                                    height: 20px;
                                    z-index: 400;
                                }

                                .step_timeline_desc {
                                    border-bottom: 1px solid #90cbb9;
                                }

                                .step_timeline_title {
                                    color: rgb(59, 145, 118);
                                    font-family: "League Spartan Regular";
                                    font-size: 23px !important;
                                    font-weight: 600;
                                    margin-top: auto;
                                    margin-bottom: auto;
                                }
                                .step_timeline_desc {
                                    color: rgb(114, 114, 114) !important;
                                    font-family: "League Spartan Regular";
                                    font-size: 17px !important;
                                }

                                @media (min-width: 768px) {
                                    .offset-md-3 {
                                        margin-left: 1%;
                                    }
                                }

                                .step-item {
                                    max-width: 40vw; /* Largeur maximale */
                                    min-width: 40vw; /* Largeur minimale pour l'affichage sur petits écrans */
                                    width: 100%; /* Prend toute la largeur disponible */
                                    margin: 0 auto; /* Centrer l'élément */
                                    padding: 0rem; /* Ajout d'espace intérieur */
                                    background-color: white; /* Fond blanc pour le contraste */

                                }

                                @media (max-width: 992px) {
                                    .step-item {
                                        min-width: 40vw; /* min-width: 15rem;  Permet à l'élément de prendre 100% sur les écrans moyens */
                                        padding: 0.7rem; /* Réduit le padding pour un meilleur ajustement */
                                    }
                                }

                                @media (max-width: 768px) {
                                    .step-item {
                                        min-width: 100%; /* Permet à l'élément de s'ajuster complètement sur les petits écrans */
                                        padding: 0.5rem; /* Réduit le padding pour un meilleur ajustement */
                                    }
                                }

                                @media (max-width: 576px) {
                                    .step-item {
                                        min-width: 100%;
                                        padding: 0.4rem; /* Réduit encore le padding pour les petits écrans */
                                    }
                                }
                                @media (max-width: 768px) {
                                    .step-item {
                                        min-width: 300px; /* Limite inférieure fixe */
                                    }
                                }

                                /* Ajustement pour écrans moyens */
                                @media (min-width: 769px) and (max-width: 1024px) {
                                    .step-item {
                                        min-width: 35vw; /* Ajuste à 35% de la largeur visible */
                                    }
                                }

                                /* Ajustement pour écrans très larges */
                                @media (min-width: 1200px) {
                                    .step-item {
                                        min-width: 40vw; /* Réduit la largeur relative pour écrans gigantesques */
                                    }
                                }
                                /* Ajustement pour écrans très larges */
                                @media (min-width: 2200px) {
                                    .step-item {
                                        min-width: 20vw; /* Réduit la largeur relative pour écrans gigantesques */
                                    }
                                }
                                @media (min-width: 1500px) {
                                    .step-item {
                                        min-width: 20vw; /* Réduit la largeur relative pour écrans gigantesques */
                                    }
                                }
                                /* Ajustement pour écrans très larges */
                                @media (min-width: 2800px) {
                                    .step-item {
                                        min-width: 12vw; /* Réduit la largeur relative pour écrans gigantesques */
                                    }
                                }
                            </style>

                            <div class="col-md-12 box-item">
                                <div class="item-categorie" style="background-color: #90cbb9;text-align: center;">
                                    <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                        <span style="display: inline-block; color: white; font-size: 25px;" class="slider-span2">METHODE D'APPRENTISSAGE</span>
                                    <?php } else { ?>
                                        <span style="display: inline-block; color: white; font-size: 25px;" class="slider-span2">LEARNING METHOD</span>
                                    <?php } ?>

                                </div>
                            </div>

                            <div  style="background-color: white;margin-top: 1rem !important;border-radius: 5px 5px 0px 0px;">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                            <ul class="timeline">
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Première étape: Schémas</h2>
                                                    <p class="step_timeline_desc">
                                                        Les schémas constituent le principal moyen d’apprentissage de l’anatomie. Il est donc recommandé de visionner les vidéos autant de fois que nécessaire jusqu’à la maîtrise complète des légendes des schémas, inclus dans votre programme. (Les vidéos sont disponibles dans les rubriques : Atlas d’Anatomie : Calques ; Atlas d’Embryologie : Calques).
                                                    </p>
                                                </li>


                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Deuxième étape : QROC</h2>
                                                    <p class="step_timeline_desc">
                                                        Approfondissez vos études des cours, en intégrant le texte et les schémas pour une compréhension complète.
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Troisième étape : COURS</h2>
                                                    <p class="step_timeline_desc">
                                                        Il est fortement conseillé de visionner les vidéos des QROC, car elles permettent de clarifier et de mémoriser les principales structures des régions correspondantes. (Les vidéos sont disponibles dans les rubriques : Cours d’Anatomie : QROC ; Cours d’Embryologie : QROC).
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Quatrième étape : QCM</h2>
                                                    <p class="step_timeline_desc">
                                                        Visionnez les vidéos des QCM autant de fois que nécessaire pour maîtriser un maximum de combinaisons. (Les vidéos sont disponibles dans les rubriques : Cours d’Anatomie : QCM ; Cours d’Embryologie : QCM).
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Cinquième étape :  Examens blancs</h2>
                                                    <p class="step_timeline_desc">
                                                        Il est fortement recommandé de réaliser plusieurs examens blancs pour vous familiariser avec les types d’examens de votre établissement. (Les examens sont disponibles dans les rubriques : Cours d’Anatomie ; Atlas d’Anatomie ; Cours d’Embryologie ; Atlas d’Embryologie).
                                                    </p>
                                                </li>
                                            </ul>
                                        <?php } else { ?>
                                            <ul class="timeline">
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">First Step : Schema</h2>
                                                    <p class="step_timeline_desc">
                                                        Diagrams are the main learning tool for anatomy. Therefore, it is recommended to watch the videos as many times as necessary until you fully master the labels of the diagrams included in your program. (The videos are available in the sections: Anatomy Atlas: Layers; Embryology Atlas: Layers).
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Second Step: MCQ</h2>
                                                    <p class="step_timeline_desc">
                                                        Deepen your studies of the courses by integrating the text and diagrams for a complete understanding.
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Third Step: Courses</h2>
                                                    <p class="step_timeline_desc">
                                                        It is highly recommended to watch the QROC videos, as they help clarify and memorize the main structures of the corresponding regions. (The videos are available in the sections: Anatomy Course: QROC; Embryology Course: QROC).
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Fourth Step: MCQ</h2>
                                                    <p class="step_timeline_desc">
                                                        Watch the QCM videos as many times as necessary to master a maximum of combinations. (The videos are available in the sections: Anatomy Course: QCM; Embryology Course: QCM).
                                                    </p>
                                                </li>
                                                <li class="step-item">
                                                    <h2 class="step_timeline_title">Fifth Step: Mock exams</h2>
                                                    <p class="step_timeline_desc">
                                                        It is strongly recommended to take several mock exams to familiarize yourself with the types of exams at your institution. (The exams are available in the sections: Anatomy Course; Anatomy Atlas; Embryology Course; Embryology Atlas).
                                                    </p>
                                                </li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div style="min-height: 2.5rem; background-color: white;border-radius: 0px 0px 5px 5px;"></div>
                        </div>

                    </div>

                    <div class="row covertures">

                        <div class="col-sm-4">
                            <div class="covertures-item">
                                <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Anatomy-courses">
                                        <img src="<?php echo HTTP_IMAGES_COUV; ?>COURS%20PA.jpg" style="width:100%;" class="image-couverture">
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Anatomy-courses">
                                        <img src="/assets/couvertures ENG/PRESENTATION_EN/COURSPA_EN.jpg" style="width:100%;" class="image-couverture">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="covertures-item">
                                <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Atlas-of-Anatomy">
                                        <img src="<?php echo HTTP_IMAGES_COUV; ?>ATLAS%20PA.jpg" style="width:100%;" class="image-couverture">
                                    </a>

                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Atlas-of-Anatomy">
                                        <img src="/assets/couvertures ENG/PRESENTATION_EN/ATLAS_PA_EN.jpg" style="width:100%;" class="image-couverture">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="covertures-item">
                                <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Embryologie">
                                        <img src="<?php echo HTTP_IMAGES_COUV; ?>EM%20PA.jpg" style="width:100%;" class="image-couverture">
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>FR/category/Embryologie">
                                        <img src="/assets/couvertures ENG/PRESENTATION_EN/EMBR_PA_EN–1.jpg" style="width:100%;" class="image-couverture">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                    <div class="row ">

                    </div>
            </section>

            <section  hidden class="videos">
                <div class="content">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 style="text-align:center; color:gray;"> <?php echo($this->lang->line('videos')) ?> </h1>
                                <br>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">

                                    <?php $ok = 0;
                                    foreach ($listCat as $value) { ?>
                                        <?php if ($value['Cats']['OrdreCat'] > 0 && $ok == 0) { ?>
                                            <?php foreach ($value['items'] as $valItem) { ?>
                                                <!-- <a class="nav-link
                <?php if (sizeof($value['items']) > 0) { ?> dropdown-toggle  <?php } ?>"
                <?php if ($value['Cats']['EstActifMenu'] == false) { ?> style="display: none" <?php } ?>
                href="<?php echo base_url(); ?><?= $valItem['items']['url']; ?>" id="navbarDropdown" role="button" data-hover="dropdown"
               aria-haspopup="true" aria-expanded="false" >

               <span class="style-font-header-categorie"> <?= $valItem['items']['LibelleTheme'];
                                                $ok = 1 ?> </span>
             </a> -->

                                                <?php if (sizeof($value['items']) > 0) { ?>
                                                    <!-- <div class="dropdown-divider"></div> -->
                                                    <div class="tilesWrap row">
                                                        <?php
                                                        $couleurs = ["#00FFFF", "#7FFFD4", "#4682B4", "#0000FF", "#8A2BE2", "#A52A2A", "rgba(9, 138, 99)", "#5F9EA0", "#FFA500", "#D2691E", "#FF7F50", "#6495ED"];
                                                        $compteurCouleurs = 0;
                                                        $compter = -1;
                                                        foreach ($valItem['books'] as $valLiv) {
                                                            $compter++; if ($compter < 10 || $compter == 12) {?>
                                                                <div class="col-lg-3 col-md-5 col-sm-6 col-9 li-item">
                                                                    <?php if (strlen($this->session->userdata('passTok')) == 200) {  ?>

                                                                        <div class="dropdown ">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?> couverture vidéo">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <form name="pageForm_up<?php print $valLiv['IDLivre']; ?>" id="pageForm_up<?php print $valLiv['IDLivre']; ?>" action="" >

                                                                                            <input type="file" name="vFile[]" id="vFile" readonly class="btn btn-info btn-sm" accept="image/png, image/jpeg" >
                                                                                            <input type="hidden" name="attach_file[]" id="attach_file" value="<?php print $valLiv['IDLivre']; ?>">
                                                                                        </form>
                                                                                    </div>
                                                                                    <br>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_Couv_Video('#pageForm_up<?php print $valLiv['IDLivre']; ?>')"><i class="fas fa-upload"></i> Upload couverture vidéo </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>

                                                                    <div class="sous-li-item">
                                                                        <?php if (strlen($valLiv['encryptCouvertureVideo']) > 0) {  ?>
                                                                            <img src="data:image/jpeg;base64, <?=$valLiv['encryptCouvertureVideo'];?>" style="width:100%;">
                                                                        <?php }else{ ?>
                                                                            <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                                                                <img src="<?php echo HTTP_IMAGES_COUV; ?>COURS%20PA.jpg" style="width:100%;">
                                                                            <?php } else { ?>
                                                                                <img src="/assets/couvertures ENG/PRESENTATION_EN/COURSPA_EN.jpg" style="width:100%;">
                                                                            <?php } ?>
                                                                        <?php } ?>

                                                                        <div class="couche-tilesWrap"> </div>

                                                                        <div class="titreAndImage">

                                                                            <button>
                                                                                <?php if (strlen($this->session->userdata('passTok')) == 200) {  ?>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= $valLiv['IDLivre']; ?>" >
                                                                                        <?php echo($this->lang->line('voirVideos')) ?>
                                                                                    </a>
                                                                                <?php }else{ ?>
                                                                                    <a href="#" data-toggle="modal" onclick="redirectLogLivr(0)" data-target="#centeredModalPrimary">
                                                                                        <?php echo($this->lang->line('voirVideos')) ?>
                                                                                    </a>
                                                                                <?php } ?>

                                                                            </button>

                                                                            <h2 style="text-align:right; height:50px !important;">
                                                                                <?php if (strlen($this->session->userdata('passTok')) == 200) {  ?>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= $valLiv['IDLivre']; ?>" >
                                                                                        <div style="background:transparent;">
                                                                                            <!-- <img src="<?php echo base_url(); ?>/assets/img/icons/Video-Icon-PNG-HD.png" alt="Logo HubSpot" width=30% height=30% title="Découvrez notre logo !"/>
                                                                                 -->
                                                                                            <i class="fa fa-play-circle-o"></i>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php }else{ ?>
                                                                                    <a data-toggle="modal" onclick="redirectLogLivr(0)" data-target="#centeredModalPrimary">
                                                                                        <div style="background:transparent;">
                                                                                            <!-- <img src="<?php echo base_url(); ?>/assets/img/icons/Video-Icon-PNG-HD.png" alt="Logo HubSpot" width=30% height=30% title="Découvrez notre logo !"/>
                                                                                 -->
                                                                                            <i class="fa fa-play-circle-o"></i>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php } ?>
                                                                            </h2>

                                                                            <h2 style="color:transparent;" >55</h2>

                                                                            <!-- <h3 style="">
		                                                                     <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= $valLiv['IDLivre']; ?>" >
                                                                                <?php print $valLiv['Titre']; ?>
                                                                             </a>
		                                                                </h3> -->


                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            <?php } } ?>
                                                    </div>




                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </section>

            <section style="position:relative;" class="formulaire">
                <div class="container">
                    <div class="col-12">
                        <div class="row">

                            <?php if (sizeof($listActualites) > 0) { ?>

                            <div class="col-sm-4 formulaire-2" style="border-right:1px white solid;">
                                <h1 class="label-page-categorie"> <?= $this->lang->line('videoconference') ?>
                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                        <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryADDFigure">
                                            <i class="fa fa-plus" style="float:right; font-size:15px; margin-top:15px;"></i>
                                        </a>
                                    <?php } ?>
                                </h1>

                                <?php
                                $compteur = 1;
                                foreach ($listActualites as $value) { ?>
                                    <div style="display:flex; fex-direction:raw; flex-wrap:nowrap; color:white; font-size:20px;">
                                        <?= $compteur;
                                        $compteur++; ?>-
                                        <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                            <span> <?= $value['FR_title']; ?> </span>
                                        <?php } else { ?>
                                            <span> <?= $value['EN_title']; ?> </span>
                                        <?php } ?>

                                        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

                                            <a href="#" class="" title="Modifier" data-toggle="modal" data-target="#centeredModalPrimaryUpdateFigure<?= $value['id']; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                </svg>
                                            </a>
                                            <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryDeleteFigure<?= $value['id']; ?>">
                                                <i class="fa fa-trash" style="font-size:15px; margin-top:15px;"></i>
                                            </a>

                                        <?php } ?>


                                    </div>
                                <?php } ?>
                            </div>


                            <div class="col-sm-8 formulaire-2">
                                <?php } else { ?>
                                <div class="col-sm-12 formulaire-2">
                                    <?php } ?>

                                    <form id="comptform2" name="comptform2" class="needs-validation" action="" method="post" novalidate="novalidate">

                                        <div class="row">
                                            <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                                <label class="label-page-categorie"> Nom Prénom : </label>
                                            <?php } else { ?>
                                                <label class="label-page-categorie"> First and last name : </label>
                                            <?php } ?>
                                            <input class="input-page-categorie" type="text" name="inputName" required="" id="inputName" placeholder="">
                                        </div>

                                        <div class="row">
                                            <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                                <label class="label-page-categorie"> E-mail : </label>
                                            <?php } else { ?>
                                                <label class="label-page-categorie"> Email : </label>
                                            <?php } ?>
                                            <input class="input-page-categorie" type="email" name="inputEmail" id="inputEmail" placeholder="">
                                        </div>

                                        <div class="row">
                                            <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                                                <label class="label-page-categorie"> Message : </label>
                                            <?php } else { ?>
                                                <label class="label-page-categorie"> Message : </label>
                                            <?php } ?>
                                            <textarea class="textarea-page-categorie" name="inputMssg" id="inputMssg" rows="4" cols="33"></textarea>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary button-modal-login" style="font-size:25px;"><?php echo $this->lang->line('contactSend'); ?></button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

            </section>

        </main>
    </div>
</div>
<?php
include('footer.php');
?>

<?php
include('actualitesmodals.php');
?>

</body>

</html>

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
        function set_ItemBack() {

            var data_plat = new FormData($('#pageForm_up')[0]);
            //console.log(data_plat);
            Swal.fire({
                title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/set_ItemBack",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 3000000,
                success: function(html) {

                    //console.log(html);
                    var resu = JSON.parse(html);
                    //console.log(resu);

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
                                location.reload();
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

            return false;
        }

        function delLiv(idL) {
            var tit = document.getElementById(idL).name
            Swal.fire({
                title: '<?php echo $this->lang->line('supp_title'); ?>' + ' <br> ' + tit,
                text: '<?php echo $this->lang->line('supp_text'); ?>',
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
                        url: "<?php echo base_url(); ?>home/delLiv",
                        data: {
                            idL: idL
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
                                        location.reload();
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

        function set_Couv() {

            var data_plat = new FormData($('#pageForm_up')[0]);

            Swal.fire({
                title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/upload_Attach_Save",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
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
                                $('#setCouv').load(" #setCouv > *");
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



            return false;
        }

        function set_ChapCatItem() {

            var data_plat = new FormData($('#pageForm_up')[0]);

            Swal.fire({
                title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/set_ChapCatItem",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {

                    console.log(html);
                    var resu = JSON.parse(html);
                    console.log(resu);

                    if (resu[0]["id"] == 1) {
                        $('#sizedModalSm').modal('hide');
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
                                location.reload();
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



            return false;
        }

        function set_LivItem(mod_) {

            var data_plat = new FormData($('#pageForm_up')[0]);

            Swal.fire({
                title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/set_LivItem",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {

                    console.log(html);
                    var resu = JSON.parse(html);
                    console.log(resu);

                    if (resu[0]["id"] == 1) {
                        $('#modalItem_' + mod_).modal('hide');
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
                                location.reload();
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



            return false;
        }

        function delBook(iTH, xx) {
            var elem = document.getElementsByClassName('row ' + xx);
            $("#" + iTH + '_' + xx).remove(); //Remove field html
            //x--; //Decrement field counter
        }

        $(document).ready(function()

        {
            var x = 0; //Initial field counter
            var list_maxField = 10; //Input fields increment limitation

            //Once add button is clicked
            $('.list_add_button').click(function() {
                var idTh = $(this).val();
                //Check maximum number of input fields
                //if(x < list_maxField){
                x++; //Increment field counter
                var cmp = x + 1;
                var list_fieldHTML = '<div style="margin-top: 0.5em" class="row ' + x + '" id=' + idTh + '_' + x + '><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="list[' + idTh + '][]" type="text" placeholder="Livre ' + cmp + '" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><button type="button" class="btn btn-danger list_remove_button" onclick="delBook(' + idTh + ',' + x + ')" value="' + idTh + '">-</button></div></div>'; //New input field html
                $(".list_wrapper_" + idTh).append(list_fieldHTML); //Add field html
                //}
            });


        });
    </script>

<?php } ?>

<!-- jQuery (une seule version, pas deux) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- jQuery Validation Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<!-- Ton script qui appelle .validate() -->
<script src="<?php echo base_url('assets/js/signup.js'); ?>"></script>

<script>
    $(document).ready(function() {

        $("body").on("contextmenu", function(e) {
            return false;
        });
        $('body').bind('cut copy', function(e) {
            e.preventDefault();
        });
        $('body').bind('cut copy', function(e) {
            e.preventDefault();
        });
        //* validation
        $('#comptform2').validate({

            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                inputName: {
                    required: true
                },
                inputEmail: {
                    required: true
                },
                inputMssg: {
                    required: true
                },
            },
            messages: {
                inputName: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputEmail: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputMssg: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            },
            highlight: function(element, errorClass, validClass) {
                $(element).removeClass(validClass).addClass(errorClass).
                next('label').removeAttr('data-success').attr('data-error', 'Incorrect!');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass).
                next('label').removeAttr('data-error').attr('data-success', 'Correct!');
            },
            submitHandler: function() {

                Swal.fire({
                    title: "<?php echo $this->lang->line('contactMsg1'); ?>",
                    text: "<?php echo $this->lang->line('contactMsg2'); ?>",
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>home/contactUS_process2",
                    data: $('#comptform2').serialize(),
                    timeout: 30000,
                    success: function(html) {
                        console.log(html);
                        Swal.close();
                        var ar = JSON.parse(html);

                        if (ar[0]["id"] == 1) {

                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: "<?php echo $this->lang->line('contactMsg1'); ?>",
                                text: "<?php echo $this->lang->line('contactMsg3'); ?>",
                                showConfirmButton: true
                            }).then(function() {
                                window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login';
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: ar[0]["desc"],
                                showConfirmButton: true
                            })
                        }
                        Swal.hideLoading();
                    },
                    error: function() {
                        Swal.hideLoading();
                    }
                });
                return false;
            }

        });

    });


    function set_Couv_Video(idForm)
    {

        var data_plat = new FormData($(idForm)[0]);

        Swal.fire({
            title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
            allowOutsideClick: false,
            allowEscapeKey: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })

        $.ajax({

            type: "POST",
            url: "<?php echo base_url(); ?>home/upload_Attach_Save_Couverture_Video",
            data: data_plat ,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 30000000,
            success: function(html) {

                console.log(html);
                var resu = JSON.parse(html);
                console.log(resu);

                if(resu[0]["id"]==1)
                {
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
                            $(idForm).load(" #setCouv > *");
                            location.reload();
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



        return false;
    }
</script>


