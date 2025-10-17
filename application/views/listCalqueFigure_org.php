<?php
include('header.php');
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

    p {
        color: green;
    }

    .inactive {
        display: none;
    }

    .selected-figure {
        border: 3px green solid;
    }

    .block-images {
        text-align: center;
        background-color: lightgrey;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .image-figure {
        display: inline-block;
        width: 80px;
        height: 80px;
        margin-left: 5px;
        margin-right: 5px;
        padding: 5px;
        transition: padding 0.3s;
        cursor: pointer;
    }



    .image-figure img {
        width:100%;
        height:100%;
    }

    .image-figure:hover {
        padding: 10px;
    }

    .btn-corriger{
        background-color: #86C4AF;
    }

    .btn-corriger:hover{
        background-color: rgba(9,138,99);
    }

    .rond {
        display: inline-flex;          /* Utiliser flexbox pour un meilleur alignement */
        align-items: center;           /* Aligner verticalement l'icône et le texte */
        justify-content: center;       /* Centrer horizontalement */
        width: 40px;                   /* Largeur du cercle */
        height: 40px;                  /* Hauteur du cercle */
        background-color: #0077b5;     /* Couleur de fond (à personnaliser) */
        color: white;                  /* Couleur du texte */
        font-weight: bold;             /* Poids du texte */
        text-align: center;            /* Centrer le texte horizontalement */
        font-size: 14px;               /* Taille du texte */
        min-width: 40px;
    }

    .rond i {
        font-size: 15px;               /* Taille de l'icône */
        margin-right: 5px;             /* Espacement entre l'icône et le texte */
    }
    .Toastify {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        z-index: 9999; /* Optionnel : assure que le toast soit bien au-dessus de tout autre élément */
    }
</style>

<body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">
<?php include('header_steppes.php'); ?>

<div class="wrapper">

    <div class="main" style="min-height:auto;" ondragstart="return false">

        <main class="content">
            <?php include('header_nav.php'); ?>

            <section>
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="block-images">
                                <?php $compteurFigure = 0;
                                foreach ($arrayFigures as $figure) {

                                if ($compteurFigure === 0) { ?>
                                <div class="image-figure selected-figure" onclick="afficheFigure(<?= $compteurFigure ?>)">
                                    <?php } else { ?>
                                    <div class="image-figure " onclick="afficheFigure(<?= $compteurFigure ?>)">
                                        <?php } $compteurFigure++; ?>

                                        <img src="data:image/png;base64,<?php print $figure['image'] ?> "></img>

                                    </div>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>
            </section>

            <section>
                <!-- Div qui affichera le message du title -->
                <div id="toastMessage" style="display: none; position: absolute; z-index: 9999; background-color: #0077b5; color: white; padding: 10px; border-radius: 5px; max-width: 300px; box-sizing: border-box;">
                </div>
                <?php $compteurFigure = 0;
                foreach ($arrayFigures as $figure) {
                if ($compteurFigure === 0) { 	?>

                <div class="content block-figure">
                    <?php } else { ?>
                    <div class="content block-figure inactive">
                        <?php } $compteurFigure++; ?>

                        <div class="row">
                            <div class="col-sm-4">
                            </div>

                            <div class="col-sm-4" style="margin-top:20px; display:flex; justify-content:center; align-items:center;">
                                <?php if($figure['pathAudio']) { ?>
                                    <audio style="padding-right: 1rem;width: 100%;" width="100%" height="auto" controls id="<?php echo 'audio'. $compteurFigure; ?>" allow="autoplay"
                                           onplay="handleAudioPlay(<?php echo $compteurFigure; ?>)">
                                        <source src="<?php echo base_url() .'uploads/'. $figure['pathAudio']; ?>" type="audio/mp3">
                                    </audio>

                                    <?php if($compteurFigure == 1) { ?>
                                        <button style="visibility:hidden; height:0px; width:0px; padding:0px;" id="buttonPlayAudioId" onclick="document.getElementById('audio1').play()"></button>
                                    <?php } ?>

                                <?php } ?>
                                <button class="btn btn-info beginTest" style="background-color: #0077b5"  >TEST</button>
                            </div>

                            <div class="col-sm-4">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <?php $compteurEssai = 0;
                                $compteurReponse = 0;
                                foreach ($figure['textGauche'] as $itemBlock) { ?>

                                    <div class="row" style="margin-top:10px; position:relative; padding-left:1px;">
                                        <hr>
                                        <button style="padding:0px; right:0px; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-gauche" id="btn-corriger-<?php echo $compteurFigure; ?>" onclick="afficheReponseBlock(event,true)">
                                            <?php echo $this->lang->line('decouv_respons'); ?>
                                        </button>
                                        <div class="col-12">
                                            <?php
                                            $compteur = 0;
                                            foreach ($itemBlock as $item) {
                                                $compteurEssai++;
                                                $compteur++; ?>
                                                <div class="row" style="margin-top:1px;margin-right: 2px;margin-left: 1px;">

                                                    <div class="col-6 text_saisie_gauche" style="display: none;width: auto;">

                                                        <div style="display: none; flex-direction: row; flex-wrap: nowrap; padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
    														<span class="rond" data-title="<?= $item['mot']; ?>" onclick="showToast(this)">
        														<i class="fas fa-eye"></i> <?= $compteurEssai; ?>
    														</span>

                                                            <textarea style="width: 100%;" rows="1" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
                                                        </div>

                                                    </div>

                                                    <div class="col-6 text_response" style="width: auto;">
                                                        <p><?= $item['mot']; ?></p>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                <?php } ?>
                            </div>
                            <div class="col-sm-6" style="position:relative; padding-top:10px;">
                                <img style="display:block;margin:auto; max-width:100%;border-left:2px solid #d0d2d4; border-right:2px solid #d0d2d4;" src="data:image/png;base64,<?php print $figure['image'] ?> "></img>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                foreach ($figure['textDroite'] as $itemBlock) { ?>
                                    <div class="row" style="margin-top:10px; position:relative;padding-left: 25px;">
                                        <hr>

                                        <button style="padding:0px; left:0px; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-droite" onclick="afficheReponseBlock(event,true)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>

                                        <div class="col-12">
                                            <?php
                                            $compteur = 0;
                                            foreach ($itemBlock as $item) {
                                                $compteurEssai++;
                                                $compteur++; ?>
                                                <div class="row" style="margin-top:1px; padding-right:0px;">

                                                    <div class="col-6 text_response" style="width: auto;">
                                                        <p><?= $item['mot']; ?></p>
                                                    </div>

                                                    <div class="col-6" style="padding-left: inherit;width: 100%;">

                                                        <div style="display: none; fex-direction:raw; flex-wrap:nowrap;padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
															<span class="rond" data-title="<?= $item['mot']; ?>" onclick="showToast(this)">
        														<i class="fas fa-eye"></i> <?= $compteurEssai; ?>
    														</span>
                                                            <textarea style="width: 100%" rows="1" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
                                                        </div>

                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6" style="margin:20px; margin-left:auto; margin-right:auto;">
                                <div class="row" style="margin-right: 0rem; margin-left: 1rem;">
                                    <div class="col-12" style="position:relative; padding-left:0px; padding-right:0px; margin-bottom:5px;">

                                        <div style="display: none; fex-direction:raw; flex-wrap:nowrap;padding-bottom: 5px;" class="textGauche textGaucheCoteDroite">
											<span class="rond" style="min-width: 46px" data-title="<?= $figure['titre']; ?>" onclick="showToast(this)">
        									<i class="fas fa-eye"></i> Fig-
    									</span>
                                            <textarea rows="1" cols="33" class="form-control form-control-lg text_titre"
                                                      style="display: none;"
                                                      type="text" name="FR_textGauche" placeholder=""></textarea>
                                        </div>

                                        <br>
                                    </div>

                                    <div class="col-12 bloc_titre" style="position:relative; padding-left:0px; padding-right:0px; min-height:30px;" >

                                        <button style="padding:0px; float:right; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger btn-titre" onclick="afficheReponseBlock(event,true)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>

                                        <span style="color:green;"><?= $figure['titre']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                    </div>
                    <?php } ?>
            </section>

        </main>
    </div>
</div>
<?php
include('footer.php');
?>

<script>

    function showToast(element) {
        // Récupère le contenu du titre à partir de l'élément cliqué
        var titleContent = element.getAttribute('data-title');

        // Récupère la position du span cliqué avec getBoundingClientRect
        var spanRect = element.getBoundingClientRect();

        // Trouve la div du toast (message à afficher)
        var toastDiv = document.getElementById('toastMessage');

        // Place la div toast à la position du span cliqué
        toastDiv.style.top = (spanRect.top + window.scrollY ) + 'px';  // Un peu au-dessus du span
        toastDiv.style.left = (spanRect.left + window.scrollX + 44) + 'px';     // Juste à droite du span

        // Affiche le contenu du toast
        toastDiv.textContent =  titleContent;

        // Affiche la div (au lieu d'un toast classique)
        toastDiv.style.display = 'block';

        // Masquer le toast après 3 secondes
        setTimeout(function() {
            toastDiv.style.display = 'none';
        }, 5000); // Masque après 3 secondes
    }


    // Function triggered by clicking the "Begin Test" button
    // Select all buttons with the class 'beginTest'
    var testButtons = document.querySelectorAll('.beginTest');

    // Loop through each button and add an event listener
    testButtons.forEach(function(button) {
        button.addEventListener('click', function() {

            var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
            for (let sais of text_saisie_gauche) {
                sais.style.display = 'flex';
            }

            // 1. Hide all buttons with class 'btn-gauche'
            var btnGaucheButtons = document.getElementsByClassName('btn-gauche');
            for (let btn of btnGaucheButtons) {
                btn.style.display = 'none';
            }

            var correctionButtonsD = document.getElementsByClassName('btn-droite');
            // Mettre tous les boutons de correction sur display: none
            for (let btn of correctionButtonsD) {
                btn.style.display = 'none';
            }

            // 2. Show all divs with class 'textGauche'
            var textGaucheDivs = document.getElementsByClassName('textGauche');
            for (let div of textGaucheDivs) {
                div.style.visibility = 'visible';
            }

            var textResponses = document.getElementsByClassName('text_response');
            for (let div of textResponses) {
                div.style.display = 'none'; // Hide all text responses
            }

            var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
            for (let div of textGaucheDrDivs) {
                div.style.display = 'flex';
                div.style.flexWrap = "nowrap";
            }

            var correctionButtonsTT = document.getElementsByClassName('text_titre');
            // Display all correction buttons
            for (let j = 0; j < correctionButtonsTT.length; j++) {
                correctionButtonsTT[j].style.display = 'flex';
            }

            var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
            // Hide all bloc_titre buttons
            for (let btn of correctionButtonsBT) {
                btn.style.display = 'none';
            }

            // Additional logic can go here, for example, to trigger other actions or animations
        });
    });


    var afficheFigure = function(position) {

        var audio_path = null;
        var figures = document.getElementsByClassName('block-figure');
        var buttons = document.getElementsByClassName('image-figure');
        for(let i = 0; i < figures.length; i++){
            if(i == position){
                figures[i].classList.remove("inactive");
                buttons[i].setAttribute("class", "image-figure selected-figure");
                let audio = document.getElementById('audio' + (i+1));
                console.log("audio 2")
                console.log(audio)
                audio_path = audio;
                // if (audio) audio.play();  // Play the audio
            }else{
                figures[i].classList.add("inactive");
                buttons[i].setAttribute("class", "image-figure");
                let audio = document.getElementById('audio' + (i+1));
                if (audio) {
                    audio.pause();         // Pause the audio
                    audio.currentTime = 0; // Reset the audio to the beginning
                }
            }
        }

        var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
        for (let sais of text_saisie_gauche) {
            sais.style.display = 'none';
        }


        var correctionButtonsG = document.getElementsByClassName('btn-gauche');
        // Mettre tous les boutons de correction sur display: block
        for (let j = 0; j < correctionButtonsG.length; j++) {
            correctionButtonsG[j].style = "padding: 0px;\n" +
                "  right: 0px;\n" +
                "  position: absolute;\n" +
                "  width: 100%;\n" +
                "  color: green;\n" +
                "  height: 100%;";
        }

        var correctionButtonsD = document.getElementsByClassName('btn-droite');
        // Mettre tous les boutons de correction sur display: block
        for (let j = 0; j < correctionButtonsD.length; j++) {
            correctionButtonsD[j].style = "padding: 0px;\n" +
                "  left: 0px;\n" +
                "  position: absolute;\n" +
                "  width: 100%;\n" +
                "  color: green;\n" +
                "  height: 100%;";
        }

        var correctionButtonsT = document.getElementsByClassName('btn-titre');
        // Mettre tous les boutons de correction sur display: block
        for (let j = 0; j < correctionButtonsT.length; j++) {
            correctionButtonsT[j].style = "padding: 0px;\n" +
                " float: right;\n" +
                "  position: absolute;\n" +
                "  width: 100%;\n" +
                "  height: 100%;\n" ;
        }

        ///display:flex; fex-direction:raw; flex-wrap:nowrap;" id="textGauche"
// Now loop through all elements with the class 'textGauche'
        var correctionButtonsTG = document.getElementsByClassName('textGauche');
// Adjust display based on the value of audio_path
        for (let j = 0; j < correctionButtonsTG.length; j++) {
            correctionButtonsTG[j].style.display =   "flex"  ;
            // correctionButtonsTG[j].style.display = (audio_path == null ) ? "flex" : "none";
            correctionButtonsTG[j].style.visibility = (audio_path === null) ? "visible" : "hidden";
            correctionButtonsTG[j].style.flexDirection = "row"; // Ensure flex-direction is applied
            correctionButtonsTG[j].style.flexWrap = "nowrap"; // Ensure flex-wrap is applied
        }

        var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
        for (let div of textGaucheDrDivs) {
            div.style.display = 'none';
        }

        var correctionButtonsTT = document.getElementsByClassName('text_titre');
        // Mettre tous les boutons de correction sur display: block
        for (let j = 0; j < correctionButtonsTT.length; j++) {
            correctionButtonsTT[j].style.display =  "none";
            // correctionButtonsTT[j].style.display = (audio_path === null) ? "flex" : "none";
        }

        var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
        // Mettre tous les boutons de correction sur display: block
        for (let btn of correctionButtonsBT) {
            btn.style.display = 'flex';
        }

        var textResponses = document.getElementsByClassName('text_response');
        for (let div of textResponses) {
            div.style.display =  'flex'; // Show if 'show' is true, otherwise hide
        }


    }

    var afficheReponseBlock = function(event,isHide) {

        if(isHide=='1'){
            event.target.setAttribute("style", "display:none;")
            var textResponses = document.getElementsByClassName('text_response');
            for (let div of textResponses) {
                div.style.display =  'block'; // Show if 'show' is true, otherwise hide
            }

        }else{
            event.target.setAttribute("style", "display:block;")
        }

    }

    var afficheReponse = function(posInitiale, size, direction) {

        var idButton = "button" + direction + posInitiale + "-" + size

        var button = document.getElementById("button" + direction + posInitiale + "-" + size);
        button.setAttribute("style", "display:none;")

        for (let numero = posInitiale; numero < (size + posInitiale); numero++) {
            var proposition = document.getElementById("proposition" + direction + numero);
            var reponse = document.getElementById("reponse" + direction + numero);

            console.log(proposition.value);

            var allTextReponse = reponse.textContent;
            var posEspace = allTextReponse.indexOf(" ");
            var textReponse = allTextReponse.substring(posEspace + 1);

            reponse.textContent = reponse.textContent
            reponse.setAttribute("style", "color:green;")

            /*if(textReponse == proposition.value){
			   reponse.textContent = "(Vrai) " + reponse.textContent
			   reponse.setAttribute("style","color:green;")
			}else{
			   reponse.textContent = "(Faux) " + reponse.textContent
			   reponse.setAttribute("style","color:red;")
			}*/
        }
    }

    window.onload = function() {
        // playAudio();
        // setTimeout(function() {
        //     let firstButtonPlayAudio = document.getElementById('buttonPlayAudioId')
        //     if(firstButtonPlayAudio) firstButtonPlayAudio.click()
        // }, 3000);  // Delay set to 1000 milliseconds (1 second)
    };

    function playAudio() {
        setTimeout(function() {
            let firstButtonPlayAudio = document.getElementById('buttonPlayAudioId')
            if(firstButtonPlayAudio) firstButtonPlayAudio.click()
        }, 3000);  // Delay set to 1000 milliseconds (1 second)
    }

    // Fonction pour déclencher un clic sur le bouton lorsque l'audio commence à jouer
    function handleAudioPlay(compteurFigure) {
        // Sélectionner tous les boutons avec la classe `btn-corriger`
        var buttons = document.getElementsByClassName('btn-corriger');

        // // Itérer sur chaque bouton et simuler un clic
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].click();
        }

        var textResponses = document.getElementsByClassName('text_response');
        for (let div of textResponses) {
            div.style.display =  'flex'; // Show if 'show' is true, otherwise hide
        }

        var correctionButtonsBT = document.getElementsByClassName('bloc_titre');
        // Mettre tous les boutons de correction sur display: block
        for (let btn of correctionButtonsBT) {
            btn.style.display = 'flex';
        }

        // 2. Show all divs with class 'textGauche'
        var textGaucheDivs = document.getElementsByClassName('textGauche');
        for (let div of textGaucheDivs) {
            div.style.visibility = 'hidden';
        }

        var textGaucheDrDivs = document.getElementsByClassName('textGaucheCoteDroite');
        for (let div of textGaucheDrDivs) {
            div.style.display = 'none';
            div.style.flexWrap = "nowrap";
        }

        var correctionButtonsTT = document.getElementsByClassName('text_titre');
        // Display all correction buttons
        for (let j = 0; j < correctionButtonsTT.length; j++) {
            correctionButtonsTT[j].style.display = 'none';
        }

        var text_saisie_gauche = document.getElementsByClassName('text_saisie_gauche');
        for (let sais of text_saisie_gauche) {
            sais.style.display = 'none';
        }

        console.log('Audio is playing, all correction buttons clicked!'); // Log pour vérification
    }


</script>
</body>

</html>
