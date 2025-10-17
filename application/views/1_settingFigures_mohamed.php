<?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

    <?php
    include('header.php');
    ?>

    <body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">

        <?php
            include('header_steppes.php');
        ?>

        <style>
            thead input {
                width: 70rem;
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05);
            }

            th,
            td {
                font-size: 12px;
            }

            .class-hidden {
                display: none;
            }

            .class-block {
                display: block;
            }

            
            .card-audio {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                max-width: 300px;
                margin: auto;
                margin-top: 5px;
                padding:5px;
                text-align: center;
                font-family: arial;
                flex: 0 1 24%;
            /* flex-grow: 1; */
            }

            .card-audio p{
                color:white;
            }

            .card-audio:hover{
                background: blue;
                cursor: pointer;
            }

            .card-audio:hover p{
                color:white;
            }

            .card-audio-active{
                background: #11d79b;
                cursor: pointer;
            }

            .card-audio-active p{
                color:white; 
            }

            .card-audio p {
                text-align: justify;
                word-break:break-all;
            
            }

            .card-audio div {
                flex-grow: 1;
                height: 100%;
                flex: 1 1 auto;

            }

            .price {
                color: grey;
                font-size: 22px;
            }

            .card-audio button {
                border: none;
                outline: 0;
                padding: 12px;
                color: white;
                background-color: #000;
                text-align: center;
                cursor: pointer;
                width: 100%;
                font-size: 18px;
            }

            .card-audio button:hover {
                opacity: 0.7;
            }

            #bloc-repertoire-audios2{
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .bloc-repertoire-videos ul{
                padding-left:5px !important;
                padding-top:5px !important;
            }

            .lien-repartoir{
                padding: 5px;
            } 

            .lien-repartoir:hover{
                color:blue;
                cursor: pointer; 
            }

            .active-lien-repartoir{
                font-weight: bold;
                background: #11d79b;
                color:white;
            }

            .active-icon{
                display: none;
            }

            .desactive-sous-list .active-icon{
                display: block;
            }

            .desactive-sous-list .desactive-icon{
                display: none;
            }

            .desactive-sous-list > ul{
                display: none;
            }
            .bloc-repertoire-videos{
                background-color: white;
                padding:3px;
            }
            .span-inline-block {
                display: block;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 100%;
                overflow: hidden;
                margin-bottom: 2px;
            }

            .span-inline-block >  ul{
                border-left:1px solid black;
            }

            .table th {
                text-align: center;
            }

            .table tr {
                text-align: center;
            }

            .btn-outline-primary {
                color: #000000;
                font-size: 80%;
            }

            .btn-outline-primary:hover {
                background: #ADD8E6;
                color: #000000;
            }

            .btn-outline-primary:active {
                background: #ADD8E6;
                color: #000000;
            }

            .modal {
                overflow: scroll !important;
            }
        </style>




        <div class="modal fade" id="centeredModalPrimaryADDFigure" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                    <div class="modal-header">
                        <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('actionAjout'); ?> Test</h2>
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="addFigure" name="addFigure" method="POST">

                            <div class="col-sm-12">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="mb-2">
                                            <label class="form-label label-modal-login"><?php echo $this->lang->line('textGauche'); ?></label>
                                            <textarea rows="15" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="textGauche" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-4" style="padding:0px;">

                                        <div class="mb-2 text-center">
                                            <label for="mFile" class="btn btn-primary button-modal-login"><?php echo $this->lang->line('selectImage'); ?></label>
                                            <button type="button" class="btn btn-primary button-modal-login" onclick="reset_Image(event, 'image' , 'ff')"><?php echo $this->lang->line('annulerImage'); ?></button>
                                            <input type="file" name="mFile[]" id="mFile" style="visibility:hidden;" accept="image/jpeg, image/png" onchange="loadFile(event, 'image', 'ff')">
                                            <input type="hidden" name="IDChapitre" id="IDChapitre" value="<?= $IDChapitre; ?>">
                                        </div>

                                        <div class="mb-2 text-center" style="height:200px; position:relative;">
                                            <img style="max-width:100%; max-height:100%; margin:auto;" id="image">
                                        </div>

                                        <div class="mb-2" style="margin-top:auto;">
                                            <label class="form-label label-modal-login"><?php echo $this->lang->line('titreFigure'); ?></label>
                                            <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="titre" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                        </div>

                                    </div>
                                   
                                    <div class="col-sm-4">
                                        <div class="mb-2">
                                            <label class="form-label label-modal-login"><?php echo $this->lang->line('textDroite'); ?></label>
                                            <textarea rows="15" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="textDroite" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                        </div>

                                    </div>


                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary button-modal-login" onclick="set_Figure()"><?php echo $this->lang->line('actionAjout'); ?> </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php foreach ($listFigures as $value) { ?>

            <div class="modal fade" id="centeredModalPrimaryUpdateFigure<?= $value['id']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                    <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                        <div class="modal-header">
                            <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('actionEdit'); ?> Test </h2>
                            <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                        </div>
                        <div class="modal-body m-3">
                            <form id="updateFigure<?= $value['id']; ?>" name="addFigure" method="POST">

                                <div class="col-sm-12">
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="mb-2">
                                                <label class="form-label label-modal-login"><?php echo $this->lang->line('textGauche'); ?></label>
                                                <textarea rows="15" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="textGauche" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= $value['textGauche']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" style="padding:0px;">

                                            <div class="mb-2 text-center">

                                                <label for="mFileUpdate<?= $value['id']; ?>" class="btn btn-primary button-modal-login"><?php echo $this->lang->line('selectImage'); ?></label>
                                                <button type="button" class="btn btn-primary button-modal-login" onclick="reset_ImageModalModification(event, 'newImage<?= $value['id']; ?>', 'oldImage<?= $value['id']; ?>')"><?php echo $this->lang->line('annulerImage'); ?></button>

                                                <input style="visibility:hidden;" type="file" name="mFileUpdate[]" id="mFileUpdate<?= $value['id']; ?>" readonly class="btn btn-info btn-sm" accept="image/jpeg, image/png" onchange="loadFile(event, 'newImage<?= $value['id']; ?>', 'oldImage<?= $value['id']; ?>')">
                                                <input type="hidden" name="idFigure" id="idFigure" value="<?= $value['id']; ?>">
                                                <input type="hidden" name="isOriginImageSupprimer" id="isOriginImageSupprimer" value="0">

                                            </div>

                                            <div class="mb-2 text-center" style="height:200px; position:relative;">
                                                <img style="max-width:100%; max-height:100%; margin:auto;" id="newImage<?= $value['id']; ?>" src="">
                                                <img style="max-width:100%; max-height:100%; margin:auto;" id="oldImage<?= $value['id']; ?>" src="data:image/png;base64,<?= $value['image']; ?> ">
                                            </div>

                                            <div class="mb-2" style="margin-top:auto;">
                                                <label class="form-label label-modal-login"><?php echo $this->lang->line('titreFigure'); ?></label>
                                                <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="titre" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= $value['titre']; ?></textarea>
                                            </div>

                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-2">
                                                <label class="form-label label-modal-login"><?php echo $this->lang->line('textDroite'); ?></label>
                                                <textarea rows="15" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="textDroite" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= $value['textDroite']; ?></textarea>
                                            </div>
                                        </div>


                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-primary button-modal-login" onclick="update_Figure('updateFigure<?= $value['id']; ?>')"><?php echo $this->lang->line('validerModification'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php } ?>


        <?php foreach ($listFigures as $value) { ?>

            <div class="modal fade" id="centeredModalPrimaryDeleteFigure<?= $value['id']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                        <div class="modal-header">
                            <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('titleSupprission'); ?></h2>
                            <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                        </div>
                        <div class="modal-body m-3">
                            <form id="deleteFigure<?= $value['id']; ?>" name="addFigure" method="POST">


                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-12">
                                        <input type="hidden" name="idFigure" id="idFigure" value="<?= $value['id']; ?>">
                                        <input type="hidden" name="IDChapitre" id="IDChapitre" value="<?= $value['IDChapitre']; ?>">

                                    </div>
                                </div>

                                <label class="form-label label-modal-login"> <?php echo $this->lang->line('messageSupprission'); ?>
                                </label>




                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-danger button-modal-login" onclick="delete_Figure('deleteFigure<?= $value['id']; ?>')"><?php echo $this->lang->line('supp_title'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <main class="content">
            <div class="container-fluid p-0">

                <?php
                include('header_nav.php');
                ?>

                <div class="row">

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body" style="min-height:100vh">
                                <div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryADDFigure">
                                                <i class="fa fa-plus" style="float:right; font-size:15px; margin-top:15px;"></i>
                                            </a>
                                            <br>
                                            <hr>
                                            <table class="table table-striped dataTable no-footer dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th><?php echo $this->lang->line('titreFigure'); ?></th>
                                                        <th><?php echo $this->lang->line('textGauche'); ?></th>
                                                        <th><?php echo $this->lang->line('textDroite'); ?></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($listFigures as $value) { ?>
                                                        <tr role="row" class="odd">
                                                            <td>
                                                                <img style="width:100px;" src="data:image/png;base64,<?php print $value['image']; ?> "></img>
                                                            </td>

                                                            <td><?= $value['titre']; ?></td>
                                                            <td><?= $value['textGauche']; ?></td>
                                                            <td><?= $value['textDroite']; ?></td>
                                                            <td>
                                                                <a href="#" class="" title="Modifier" data-toggle="modal" data-target="#centeredModalPrimaryUpdateFigure<?= $value['id']; ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                    </svg>
                                                                </a>
                                                                <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryDeleteFigure<?= $value['id']; ?>">
                                                                    <i class="fa fa-trash" style="font-size:15px; margin-top:15px;"></i>
                                                                </a>

                                                              <!--  <a href="<?php echo base_url(); ?>FR/testFigure/<?= $value['id']; ?>" class="" title="Test">
                                                                    <i class="fa fa-eye" style="font-size:15px; margin-top:15px;"></i>
                                                                </a>-->

                                                                <a href="#" data-toggle="modal" onclick="chargeAudio(<?= $value['id']; ?>, '<?= $value['titre']; ?>')" data-target="#popupAdminShowAudio" class="" title="Audio">
                                                                    <i style="font-size:17px; margin:3px 0px;" class="fa fa-volume-up" aria-hidden="true"></i>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
        </main>

        <?php
        include('footer.php');
        ?>
        </div>
        </div>

        <!-- start Modal select audio -->
        <div class="modal fade" id="popupAdminShowAudio" tabindex="-1" style="display: none; overflow:scroll !important;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                    <div class="modal-header">
                        <h2 class="modal-title h2-modal-login"> <span id="idTitreChoisirAudio"></span></h2>
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                    </div>
                    <div class="modal-body m-3" style="padding:0px;">

                        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

                            <div style="width:100%; text-align: right;" id="idBlockButtonAddAudio">
                                <button type="button" onclick="open_add_audio();" class="btn btn-primary button-modal-login" data-toggle="modal" data-target="#addAudioModal">Selectionner audio</button>
                                <hr>
                            </div>

                        <?php } ?>
                    
                        <div id="tabVideos">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addAudioModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:auto;">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                    <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                        <div class="modal-header">
                            <h2 id="titreAddVideoModal" class="modal-title h2-modal-login">Sélectionner Audio</h2>
                            <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                        </div>
                        <div class="modal-body m-3" style="padding:0px;">
                            <form id="video_upload" name="video_upload" method="POST">

                                <div class="col-sm-12">
                                    <div class="row">

                                        <div class="col-sm-12">

                                            <div class="mb-2" style="display:flex;">
                                                <button type="button" class="btn btn-primary button-modal-login" onclick="refreshRepertoire(true);" data-toggle="modal" data-target="#selectAudioModal"> Sélectionner </button>
                                                <input type="text" name="video_path2" id="pathVideoAdd2" style="width:100%" disabled>
                                                <input type="hidden" name="video_path" id="pathVideoAdd" style="width:100%">
                                            </div>
                                            <div class="mb-2 text-center">
                                                <input type="hidden" name="idFigure" id="idFigureAudio" value="">
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <br>
                                
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary button-modal-login" onclick="addEdit_audio('#video_upload')"><?php echo $this->lang->line('save'); ?></button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
        </div>

        <div class="modal fade" id="selectAudioModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:5000;">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                    <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                        <div class="modal-header">
                            <h2 id="titreAddVideoModal" class="modal-title h2-modal-login">Sélectionner Audio</h2>
                            <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                        </div>
                        <div class="modal-body m-3" style="padding:0px;">
                            
                            <form id="uploads_audio" name="uploads_audio" method="POST">

                                <div class="col-sm-12">
                                    <div class="row">

                                        <div class="col-sm-12">

                                            <div class="mb-2 text-center">
                                                <input type="file" name="audio_name" id="mFile" accept="audio/mp3">
                                                <input type="hidden" name="path_folder_audio" id="pathFolderAudio" value="">
                                                <button type="button" class="btn btn-primary button-modal-login" onclick="uploads_audio_function('#uploads_audio')">Ajouter</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <br>

                                <div class="progress">
                                    <div class="progress-bar">
                            
                                    </div>
                                </div>
                                <br>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary button-modal-login" onclick="valideSelectedAudio()"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <br>

                                <div  class="col-md-12">
                                    <div  class="row">
                                        <div  class="bloc-repertoire-videos col-md-4" id="bloc-repertoire-videos">
                                            
                                        </div>
            
                                        <div  class="col-md-8">
                                            <h1>Liste Audio</h1>
                                            <div id="bloc-repertoire-audios2">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
        </div>

        <div class="modal fade" id="centeredModalPrimaryDeleteAudio" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                    <div class="modal-header">
                        <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('titleSupprission'); ?></h2>
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="deleteAudioModal" name="addFigure" method="POST">

                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-md-12">
                                    <input type="hidden" name="idFigureSuppression" id="idFigureSuppression" value="-1">
                                </div>
                            </div>

                            <label class="form-label label-modal-login"> <?php echo $this->lang->line('messageSupprission'); ?>
                            </label>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-danger button-modal-login" onclick="deleteAudio()" id="buttonDeleteVideo"><?php echo $this->lang->line('supp_title'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- end Modal select audio -->

    </body>
    <script>
        var reset_Image = function(event, newImage, oldImage) {
            var parent = event.target.parentElement
            var input = parent.children[2]

            input.value = '';
            var image = document.getElementById(newImage);
            image.src = '';

            image.setAttribute("class", "class-hidden")

            var image2 = document.getElementById(oldImage);
            
            if (image2 != null) {
                image2.setAttribute("class", "class-hidden")
            }
        }

        var reset_ImageModalModification = function(event, newImage, oldImage) {
            var parent = event.target.parentElement
            var input = parent.children[2]
            var isImageOriginSupprimer = parent.children[4]
            isImageOriginSupprimer.value = "1"
            input.value = '';
            var image = document.getElementById(newImage);
            image.src = '';

            image.setAttribute("class", "class-hidden")

            var image2 = document.getElementById(oldImage);
            
            if (image2 != null) {
                image2.setAttribute("class", "class-hidden")
            }
        }

        var loadFile = function(event, newImage, oldImage) {
            var image = document.getElementById(newImage);
 
            console.log(image)

            image.src = URL.createObjectURL(event.target.files[0]);
            image.setAttribute("class", "class-block")
            
            var image2 = document.getElementById(oldImage);
            if (image2 != null) {
                image2.setAttribute("class", "class-hidden")
            }
        };

        //delete figure
        function delete_Figure(idFormulaire) {

            var data_plat = new FormData($('#' + idFormulaire)[0]);

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
                url: "<?php echo base_url(); ?>home/delete_figure",
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
                                window.location.reload()
                       
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

        //update figure
        function update_Figure(idFormulaire) {

            var data_plat = new FormData($('#' + idFormulaire)[0]);

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
                url: "<?php echo base_url(); ?>home/update_figure",
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
                                window.location.reload()
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

        //add Figure
        function set_Figure() {

            var data_plat = new FormData($('#addFigure')[0]);

            console.log(data_plat)
            
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
                url: "<?php echo base_url(); ?>home/add_figure",
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
                                window.location.reload()
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

        //add mp3
        function chargeAudio(idFigure, titleFigure) {
            document.getElementById("idFigureAudio").value = idFigure
            document.getElementById("idTitreChoisirAudio").innerText  = titleFigure

            var formData = new FormData();
            formData.append('idFigure', idFigure);

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
                url: "<?php echo base_url(); ?>video/getAudioByFigure",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {

                    var res = JSON.parse(html)

                    var figure = res["desc"]
                    document.getElementById("idBlockButtonAddAudio").style="display:block; float:right;"
                    var somme = `
                    <div class="col-sm-12">`
                    if(!(figure && figure.pathAudio && figure.pathAudio != "")){
                        somme += `<h2 style="text-align:center"> Aucun audio </h2>`
                        somme += `</div>`

                        swal.close()

                        var htmlContent = document.getElementById("tabVideos");

                        htmlContent.innerHTML = somme

                        var idTitreListVideo = document.getElementById("idTitreListVideo")
                        return
                    }

                    figure.pathAudio = "uploads/"+figure.pathAudio
                    
                    document.getElementById("idBlockButtonAddAudio").style="display:none;"

                    somme += `
                        <div class="row">
                            <div style="text-align:center; width:calc(100% - 120px);">
                                <audio style="width: 100%;" width="100%" height="auto" controls id="list`+figure['id']+`">
                                    <source src="<?php echo base_url(); ?>`+figure['pathAudio']+`" type="audio/mp3" >
                                </audio>
                            </div>

                            <div class="col-sm-4" style="float:right; width:120px;">
                                <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                    <h2></h2>
                                    <button style="padding: 10px;" onclick="open_delete_audio(` + figure['id'] + `)" data-toggle="modal" data-target="#centeredModalPrimaryDeleteAudio" class="btn btn-primary button-modal-login" > 
                                       <i class="fa fa-trash" style="font-size:18px; color:white;" aria-hidden="true"></i>
                                    </button>
                                    <button  style="padding: 10px;" type="button" onclick="open_add_audio();" class="btn btn-primary button-modal-login" data-toggle="modal" data-target="#addAudioModal">
                                       <i class="fa fa-edit" style="font-size:18px; color:white;" aria-hidden="true"></i>
                                    </button>
                                <?php } ?>
                            </div>

                            <hr>
                        </div>
                    `

                    somme += `</div>`

                    swal.close()

                    var htmlContent = document.getElementById("tabVideos");

                    htmlContent.innerHTML = somme
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

        function open_add_audio() {
            //document.getElementById("titreAddAudioModal").innerHTML = "Ajouter Audio"
            //document.getElementById("idFigureAudio").value = document.getElementById("idFigureAudio").value
        }

        function open_delete_audio(id) {
            document.getElementById("idFigureSuppression").value = id
        }

        function refreshRepertoire(refreshFolder) {
                
            var data_plat = new FormData($('#pageForm_TestQCM')[0]);

            Swal.fire({
                title: '<?php echo $this->lang->line('testPopPat'); ?>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })
            
            $.ajax({    
            
                type: "POST",
                url: "<?php echo base_url(); ?>video/getSubDirectoriesAudio",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {
                    swal.close()
                    var resu = JSON.parse(html);
                    
                    if (resu["id"] == "1") {
                        // $('#modalChap').modal('hide');
                       
                        var result = resu["search_results"]

                        var newItems = [{path:"uploads", items:result, name:"uploads", isFolder:true}]
           
                        localStorage.setItem("listvideosSelectionnee", JSON.stringify(newItems))
                        
                        var inputPathRepartoire = document.getElementById("pathFolderAudio")
                        var pathRepartoire = "uploads"
                        if(inputPathRepartoire && inputPathRepartoire.value && inputPathRepartoire.value.length > 0){
                            pathRepartoire = inputPathRepartoire.value 
                        }
                        
                        if(refreshFolder){
                            setRepertoirAudioToHTML(newItems, pathRepartoire)
                            selecteRepertoirAudioToHTML(null, pathRepartoire)
                            var elements = document.getElementsByClassName("lien-repartoir") 
                            selecteRepertoirAudioToHTML(elements[0], pathRepartoire)
                        }else{
                            var elements = document.getElementsByClassName("active-lien-repartoir") 
                            selecteRepertoirAudioToHTML(elements[0], pathRepartoire)
                        }
                        
                       
                        
                      
                        // contener.innerHTML = setRepertoirAudioToHTML(result)

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

        function selecteRepertoirAudioToHTML(e, path){
            var elements = document.getElementsByClassName("active-lien-repartoir") 
            elements.forEach(x => {
                x.classList.remove("active-lien-repartoir")
            })  

            if(e && e.classList) e.classList.add("active-lien-repartoir")

            var items = JSON.parse(localStorage.getItem("listvideosSelectionnee"))
            var innerHTML = getAudiosToHTMLParTranche(items, path)

            var inputFolder = document.getElementById("pathFolderAudio")
            if(inputFolder) inputFolder.value = path
            
            var contener = document.getElementById("bloc-repertoire-audios2")
            contener.innerHTML = innerHTML
            refereshAudios()
        }

        function selecteAudio(e){
            var elements = document.getElementsByClassName("card-audio-active") 
            elements.forEach(x => {
                x.classList.remove("card-audio-active")
            })  

            if(e && e.classList) e.classList.add("card-audio-active")

        }

        function valideSelectedAudio(){
            var elements = document.getElementsByClassName("card-audio-active") 
            elements.forEach(x => {
                    var input = document.getElementById("pathVideoAdd")
                    input.value = x.getAttribute('name')
                     var input2 = document.getElementById("pathVideoAdd2")
                    input2.value = x.getAttribute('name')
                    $('#selectAudioModal').modal('hide');
                    return  
            })  
        }
         
        function opencloseRepertoirAudioToHTML(e){
            if(e.parentElement.classList == "span-inline-block"){
                e.parentElement.classList.add('desactive-sous-list')
            }else{
                e.parentElement.classList.remove('desactive-sous-list')
            }
        }

        function setRepertoirAudioToHTML(directories, path){
            var contener = document.getElementById("bloc-repertoire-videos")
            contener.innerHTML = setRepertoirAudioToHTMLParTranche(directories, path)
        }

        function getAudiosToHTMLParTranche(directories, path){
            var innerHTML = ``
            for (let i = 0; i < directories.length; i++) {
                if(directories[i].isFolder && directories[i].path != path){
                    if(directories[i].items.length > 0){
                        innerHTML += getAudiosToHTMLParTranche(directories[i].items, path)
                    }
                }else if(directories[i].path == path){
                    var innerHTML = ``
                    var compteur = 0
                    for (let j = 0; j < directories[i].items.length; j++) {
                       if(!directories[i].items[j].isFolder){
                        compteur++ 
                        innerHTML += `
                         <div class="card-audio" name="`+directories[i].items[j].path+`" onclick="selecteAudio(this)">
                            <audio style="padding-right:10px;" width="100%" height="auto" id="repartoir`+compteur+`" controls>
                              <source src="<?php echo base_url(); ?>`+directories[i].items[j].path+`" type="audio/mp3" >
                            </audio>   
                            <div> 
                               <p>`+ 
                                   directories[i].items[j].name 
                               +`</p> 
                            </div>
                         </div>`
                       }
                    }
                    innerHTML += ``
                    return innerHTML
                }
                // console.log("item[0].name = ", result)
            }

           return innerHTML
        }

        function checkRepartoir(directories){
            for (let i = 0; i < directories.length; i++) {
                if(directories[i].isFolder){
                   return true
                }
            }
            return false
        }

        function setRepertoirAudioToHTMLParTranche(directories, path){
           var innerHTML = `<ul>`
            for (let i = 0; i < directories.length; i++) {
                if(directories[i].isFolder){
                    if(checkRepartoir(directories[i].items)){
                        innerHTML += `<li class="span-inline-block desactive-sous-list"> <button type="button" onclick="opencloseRepertoirAudioToHTML(this)"> <span class="active-icon"> + </span> <span class="desactive-icon"> - </span> </button> <span class="lien-repartoir" onclick="selecteRepertoirAudioToHTML(this,'`+ directories[i].path +`')">`+ directories[i].name +`</span>`+setRepertoirAudioToHTMLParTranche(directories[i].items, path) +`</li>`
                    }else{
                        innerHTML += `<li class="span-inline-block"> <span class="lien-repartoir" onclick="selecteRepertoirAudioToHTML(this,'`+ directories[i].path +`')">`+ directories[i].name +`</span> </li>`
                    }
                }
                // console.log("item[0].name = ", result)
            }
            innerHTML += `</ul>`
            return innerHTML
        }

        function refereshAudios(){
            setTimeout(() => {
                $('video').off('play').on('play', function() {
                    var dd = this.id
                    console.log("dd = ",dd)
                    $('video').each(function( index ) {
                        
                        if(dd != this.id){
                            this.pause();
                            this.currentTime = 0;
                        }
                    });
                });
            }, "1 second");
        }

        function setPauseAllAudios(){
            setTimeout(() => {
                $('audio').each(function( index ) {
                    this.pause();
                });
            }, "1 second");
        }

        $("#popupAdminShowAudio").on('hide.bs.modal', function(){
            setPauseAllAudios()
        });

        $("#addAudioModal").on('show.bs.modal', function(){
          // document.getElementById("idTitreFormVideo").value = ""
          // document.getElementById("idDescriptionFormVideo").value = ""
          // document.getElementById("pathVideoAdd2").value = ""
            setPauseAllAudios()
        });

        $("#addAudioModal").on('hide.bs.modal', function(){
            setPauseAllAudios()
        });

        $("#selectAudioModal").on('show.bs.modal', function(){
            setPauseAllAudios()
        });
         
        $("#selectAudioModal").on('hide.bs.modal', function(){
            setPauseAllAudios()
        });

        $("#centeredModalPrimaryDeleteVideo").on('show.bs.modal', function(){
            setPauseAllAudios()
        });

         //add Video
        function addEdit_audio(id) {

            var data_plat = new FormData($(id)[0]);
            console.log(data_plat)

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
                url: "<?php echo base_url(); ?>video/audio2",
                data: data_plat,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                
                success: function(html) {

                    var resu = JSON.parse(html);
                
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
                                //window.location.reload()
                               //$('#addVideoModal').modal('hide');
                               //var idChapitre = document.getElementById("IDChapitreVideo").value
                               //var idType = document.getElementById("IDTypeVideo").value
                               //var titreChapitre = document.getElementById("TitreChapitreVideo").value
                               //chargeVideos(idChapitre, titreChapitre, idType)
                               $('#addAudioModal').modal('hide');
                               $('#popupAdminShowAudio').modal('hide');
                            }
                        })
                        //setTimeout(() => {
                        //    window.location.reload();
                        //}, 1000);
                        
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

        function uploads_audio_function(id) {

                var data_plat = new FormData($(id)[0]);
                console.log(data_plat)
                // Swal.fire({
                //     title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
                //     allowOutsideClick: false,
                //     allowEscapeKey: false,
                //     onBeforeOpen: () => {
                //         Swal.showLoading()
                //     }
                // })
                
                $.ajax({
                    xhr: function(){
                       var xhr = new window.XMLHttpRequest();
                       xhr.upload.addEventListener("progress", function(evt){
                          if(evt.lengthComputable){
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            $(".progress-bar").width(Math.trunc(percentComplete)+"%");
                            $(".progress-bar").html(Math.trunc(percentComplete)+"%");
                          }
                       }, false);
                
                       return xhr;
                    },
                    type: "POST",
                    url: "<?php echo base_url(); ?>video/uploadsAudio",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    beforeSend: function(){
                        $(".progress-bar").width('0%');
                        $(".progress-bar").html('<h1> Loading .... </h1>')
                    },
                
                    success: function(html) {
                
                        console.log("sucess");
                        console.log(html);
                        var resu = JSON.parse(html);
                        console.log(resu);
                
                        if (resu[0]["id"] == 1) {
                            console.log("sucess");
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

                                $(".progress-bar").width('0%');
                                // $(".progress-bar").html('<h1> Loading .... </h1>')
                    
                                refreshRepertoire(false)
                                // if (result.value) {
                                //     $('#setCouv').load(" #setCouv > *");
                                //     //window.location.reload()
                                //     $('#addVideoModal').modal('hide');
                                //     var idChapitre = document.getElementById("IDChapitreVideo").value
                                //     var idType = document.getElementById("IDTypeVideo").value
                                //     chargeVideos(idChapitre, idType)
                                // }
                            })
                
                        } else {
                            console.log("error");
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

            function deleteAudio() {

                var data_plat = new FormData($("#deleteAudioModal")[0]);

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
                    url: "<?php echo base_url(); ?>video/deleteAudio",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {
                    
                        console.log("sucess");
                        console.log(html);
                        var resu = JSON.parse(html);
                        console.log(resu);
                    
                        if (resu[0]["id"] == 1) {
                            console.log("sucess");
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
                                    $('#centeredModalPrimaryDeleteAudio').modal('hide');
                                    $('#addAudioModal').modal('hide');
                                    $('#popupAdminShowAudio').modal('hide');

                                    //setTimeout(() => {
                                    //    window.location.reload();
                                    //}, 1000);
                                }
                            })
                        
                        } else {
                            console.log("error");
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: resu["desc"],
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

    </html>
<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>