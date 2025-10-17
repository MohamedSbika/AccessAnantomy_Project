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

</style>

<body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">
    <?php
    include('header_steppes.php');
    ?>

    <div class="wrapper">

        <div class="main" style="min-height:auto;" ondragstart="return false">


            <main class="content">
                <?php
                include('header_nav.php');
                ?>


                <section>
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="block-images">
                                    <?php $compteurFigure = 0;
                                    foreach ($arrayFigures as $figure) {

                                        if ($compteurFigure === 0) {
                                            ?>
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

                    <?php $compteurFigure = 0;
                    foreach ($arrayFigures as $figure) {

                        if ($compteurFigure === 0) {
                    ?>

                            <div class="content block-figure">
                            <?php } else { ?>
                                <div class="content block-figure inactive">
                                <?php }
                            $compteurFigure++; ?>


                               
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?php $compteurEssai = 0;
                                        $compteurReponse = 0;
                                        foreach ($figure['textGauche'] as $itemBlock) { ?>

                                            <div class="row" style="margin-top:20px; position:relative; padding-left:15px;">
                                                <hr>
                                                <button style="padding:0px; right:0px; position:absolute; width:50%; height:100%;" class="btn btn-success btn-corriger" onclick="afficheReponseBlock(event)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>


                                                <div class="col-12">
                                                    <?php
                                                    $compteur = 0;
                                                    foreach ($itemBlock as $item) {
                                                        $compteurEssai++;
                                                        $compteur++; ?>
                                                        <div class="row" style="margin-top:5px;">

                                                            <div class="col-6">
                                                                <div style="display:flex; fex-direction:raw; flex-wrap:nowrap;">
                                                                    <?= $compteurEssai; ?>-
                                                                    <textarea rows="2" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
                                                
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <p><?= $item['mot']; ?></p>
                                                            </div>

                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            </div>


                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-4" style="position:relative; padding-top:20px;">
                                      
                                        <img style="display:block;margin:auto; max-width:100%;" src="data:image/png;base64,<?php print $figure['image'] ?> "></img>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php
                                        foreach ($figure['textDroite'] as $itemBlock) { ?>
                                            <div class="row" style="margin-top:20px; position:relative;">
                                                <hr>

                                                <button style="padding:0px; left:0px; position:absolute; width:50%; height:100%;" class="btn btn-success btn-corriger" onclick="afficheReponseBlock(event)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>

                                                <div class="col-12">
                                                    <?php
                                                    $compteur = 0;
                                                    foreach ($itemBlock as $item) {
                                                        $compteurEssai++;
                                                        $compteur++; ?>
                                                        <div class="row" style="margin-top:5px; padding-right:15px;">

                                                            <div class="col-6">
                                                                <p><?= $item['mot']; ?></p>
                                                            </div>

                                                            <div class="col-6">
                                                                <div style="display:flex; fex-direction:raw; flex-wrap:nowrap;">
                                                                    <?= $compteurEssai; ?>-
                                                                    <textarea rows="2" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
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
                                        <div class="row">
                                            <div class="col-12" style="position:relative; padding-left:0px; padding-right:0px; margin-bottom:5px;">
                                                <textarea rows="2" cols="33" class="form-control form-control-lg" type="text" name="FR_textGauche" placeholder=""></textarea>
                                                <br>
                                            </div>

                                            <div class="col-12" style="position:relative; padding-left:0px; padding-right:0px; min-height:30px;">
                                                <button style="padding:0px; float:right; position:absolute; width:100%; height:100%;" class="btn btn-success btn-corriger" onclick="afficheReponseBlock(event)"> <?php echo $this->lang->line('decouv_respons'); ?> </button>
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


        var afficheFigure = function(position) {
            var figures = document.getElementsByClassName('block-figure')
            var buttons = document.getElementsByClassName('image-figure')
            for(let i = 0; i < figures.length; i++){
                if(i == position){
                    figures[i].classList.remove("inactive")
                    buttons[i].setAttribute("class", "image-figure selected-figure")
                    
                }else{
                    figures[i].classList.add("inactive")
                    buttons[i].setAttribute("class", "image-figure")
                }
            }

        }


        var afficheReponseBlock = function(event) {
            event.target.setAttribute("style", "display:none;")

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

                console.log(textReponse);
                /*if(textReponse == proposition.value){
                   reponse.textContent = "(Vrai) " + reponse.textContent
                   reponse.setAttribute("style","color:green;")
                }else{
                   reponse.textContent = "(Faux) " + reponse.textContent
                   reponse.setAttribute("style","color:red;")
                }*/
            }
        }
    </script>
</body>

</html>