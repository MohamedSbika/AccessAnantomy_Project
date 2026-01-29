<?php if (strlen($this->session->userdata('passTok')) == 200) {  ?>


    <?php
    include('header.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

        .card-video {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 300px;
            margin: auto;
            margin-top: 5px;
            padding:5px;
            text-align: center;
            font-family: arial;
            flex: 0 1 24%;
        }

        .card-video p{
            color:white;
        }

        .card-video:hover{
            background: blue;
            cursor: pointer;
        }

        .card-video:hover p{
            color:white;
        }

        .card-video-active{
            background: #11d79b;
            cursor: pointer;
        }

        .card-video-active p{
            color:white;
        }

        .card-video p {
            text-align: justify;
            word-break:break-all;

        }

        .card-video div {
            flex-grow: 1;
            height: 100%;
            flex: 1 1 auto;

        }

        .price {
            color: grey;
            font-size: 22px;
        }

        .card-video button {
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

        .card-video button:hover {
            opacity: 0.7;
        }

        #bloc-repertoire-videos2{
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

        .modal
        {
            overflow: scroll !important;
        }

        .select-chapitre-associe option,
.select-chapitre-associe optgroup {
    color: #000 !important;
    background: #fff !important;
}
    </style>


    <div class="modal fade" id="popupAdminListVideos" tabindex="-1" style="display: none; overflow:scroll !important;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 class="modal-title h2-modal-login"> <span id="idTitreListVideo"></span></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3" style="padding:0px;">

                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

                        <div style="width:100%; text-align: right;">
                            <button type="button" onclick="open_add_video();" class="btn btn-primary button-modal-login" data-toggle="modal" data-target="#addVideoModal"><?php echo $this->lang->line('add_video'); ?></button>
                            <hr>
                        </div>

                    <?php } ?>

                    <input type="hidden" name="TitreChapitreVideo" id="TitreChapitreVideo" value="">

                    <div id="tabVideos">

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="centeredModalDisplayVideo" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:auto;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 id="titreDisplayVideoModal27" name="0" class="modal-title h2-modal-login">Video</h2>

                    <div>
                        <button type="button" class="style-button-modal" id="titreDisplayVideoModal27Next" onclick="openVideoPlainEcranPrevious()">
                            < </button>
                        <button type="button" class="style-button-modal" id="titreDisplayVideoModal27Previous" onclick="openVideoPlainEcranNext()"> > </button>

                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>

                    </div>
                </div>
                <div class="modal-body m-3" style="padding:0px;">

                    <div class="col-sm-12">
                        <div class="row">

                            <div class="col-sm-12" id="divContainerVideoDisplay" style="text-align:center">


                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="centeredModalPrimaryDeleteVideo" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('titleSupprission'); ?></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3">
                    <form id="deleteVideoModal" name="addFigure" method="POST">

                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <input type="hidden" name="idVideoSuppression" id="idVideoSuppression" value="-1">
                            </div>
                        </div>

                        <label class="form-label label-modal-login"> <?php echo $this->lang->line('messageSupprission'); ?>
                        </label>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-danger button-modal-login" onclick="deleteVideo('88')" id="buttonDeleteVideo"><?php echo $this->lang->line('supp_title'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="centeredModalPrimaryDeleteVideo" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:auto;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 id="titreAddVideoModal25" class="modal-title h2-modal-login"><?php echo $this->lang->line('titleSupprission'); ?></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3" style="padding:0px;">
                    <form id="deleteVideoModal" name="video_upload" method="POST">

                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-12">

                                    <label class="form-label label-modal-login"> <?php echo $this->lang->line('messageSupprission'); ?>
                                    </label>

                                    <div class="mb-2 text-center">
                                        <input type="hidden" name="idVideoSuppression" id="idVideoSuppression" value="-1">
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary button-modal-login" onclick="delete_video('#video_upload')"><?php echo $this->lang->line('actionAjout'); ?></button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addVideoModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:auto;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 id="titreAddVideoModal" class="modal-title h2-modal-login"><?php echo $this->lang->line('add_video'); ?></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3" style="padding:0px;">
                    <form id="video_upload" name="video_upload" method="POST">

                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="mb-2">
                                        <label class="form-label label-modal-login"><?php echo $this->lang->line('titreFigure'); ?></label>
                                        <textarea id="idTitreFormVideo" rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="titre" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label label-modal-login">Description</label>
                                        <textarea id="idDescriptionFormVideo" rows="15" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="description" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                    </div>
                                    <div class="mb-2" style="display:flex;">
                                        <button type="button" class="btn btn-primary button-modal-login" onclick="refreshRepertoire(true);" data-toggle="modal" data-target="#selectVideoModal"> <?php echo $this->lang->line('select_video'); ?> </button>
                                        <input type="text" name="video_path2" id="pathVideoAdd2" style="width:100%" disabled>
                                        <input type="hidden" name="video_path" id="pathVideoAdd" style="width:100%">
                                    </div>
                                    <div class="mb-2 text-center">
                                        <input type="hidden" name="IDChapitre" id="IDChapitreVideo" value="">
                                        <input type="hidden" name="type" id="IDTypeVideo" value="">
                                        <input type="hidden" name="IDVideo" id="IDVideoForm" value="">
                                    </div>

                                </div>

                            </div>
                        </div>

                        <br>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary button-modal-login" onclick="addEdit_video('#video_upload')"><?php echo $this->lang->line('save'); ?></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RAPPEL ANATOMIQUE -->
    <div class="modal fade" id="addRappelModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:auto;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 class="modal-title h2-modal-login">Ajouter/Modifier Rappel Anatomique</h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3">
                    <form id="formRappelManuel" name="formRappelManuel" enctype="multipart/form-data">
                        <input type="hidden" id="rappelChapitre" name="rappelChapitre" value="">
                        
                        <div class="form-group">
                            <label>Fichier Rappel Anatomique (.docx)</label>
                            <input type="file" class="form-control" id="rappelFichier" name="rappelFichier" accept=".docx" required>
                            <small class="form-text text-muted">Sélectionnez un fichier Word (.docx)</small>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary button-modal-login" onclick="saveRappelManuel()">Enregistrer</button>
                            <button type="button" class="btn btn-secondary button-modal-login" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="addImageRappelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
        <div class="modal-content" style="background-color: rgb(9,138,99); box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
            
            <div class="modal-header">
                <h2 class="modal-title h2-modal-login">Gérer les images de rappel</h2>
                <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close">x</button>
            </div>

            <div class="modal-body m-3">
                
                <!-- Liste des images existantes -->
                <div id="listeImagesRappel" style="margin-bottom: 20px;">
                    <h4 style="color: white;">Images existantes</h4>
                    <div id="imagesContainer" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <!-- Les images seront chargées ici via JavaScript -->
                    </div>
                </div>
                
                <hr style="border-color: white;">
                
                <!-- Formulaire d'ajout -->
                <h4 style="color: white;">Ajouter une nouvelle image</h4>
                <form id="formRappelImage" name="formRappelImage" enctype="multipart/form-data">
                    
                    <!-- ID Chapitre -->
                    <input type="hidden" id="rappelChapitreImage" name="rappelChapitre">

                    <!-- Image -->
                    <div class="form-group">
                        <label style="color: white;">Image anatomique (JPG, PNG, WEBP)</label>
                        <input
                            type="file"
                            class="form-control"
                            id="rappelImage"
                            name="rappelImage"
                            accept="image/png, image/jpeg, image/webp"
                            onchange="previewImageRappel(event)"
                        >
                        <small class="form-text" style="color: #ddd;">
                            Formats autorisés : JPG, PNG, WEBP â€“ max recommandé : 2MB
                        </small>
                    </div>

                    <!-- Aperçu -->
                    <div class="form-group text-center">
                        <img id="previewRappelImage" src="" alt="" style="max-width:100%; max-height:300px; display:none; border-radius:8px;">
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <button type="button" class="btn btn-primary button-modal-login" onclick="saveRappelImage()">
                            Enregistrer
                        </button>
                        <button type="button" class="btn btn-secondary button-modal-login" data-dismiss="modal">
                            Fermer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SOUS-CHAPITRE (PATHOLOGIE) -->
<div class="modal fade" id="modalSousChap" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:800px;">
        <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
            <div class="modal-header">
                <h2 class="modal-title h2-modal-login">Ajouter Sous-Chapitre(s) / Pathologie(s)</h2>
                <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
            </div>
            <div class="modal-body m-3">
                <form id="formSousChap" name="formSousChap">
                    <input type="hidden" id="sousChap_bookID" name="bookID" value="">
                    <input type="hidden" id="sousChap_chapID" name="chapID" value="">
                    
                    <div class="form-group">
                        <label class="form-label label-modal-login">Titres des sous-chapitres / pathologies</label>
                        <textarea 
                            id="sousChaps" 
                            name="sousChaps" 
                            rows="4" 
                            class="form-control form-control-lg input-modal-login" 
                            placeholder="Entrez les titres séparés par des virgules. Exemple: Pathologie 1, Pathologie 2, Pathologie 3"
                            style="font-size: 0.9rem; padding: 0.5rem;"
                        ></textarea>
                        <small class="form-text text-muted" style="color: #ddd;">
                            Séparez chaque titre par une virgule (,)
                        </small>
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary button-modal-login" onclick="submitSousChap()">Enregistrer</button>
                        <button type="button" class="btn btn-secondary button-modal-login" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="selectVideoModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:5000;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 id="titreAddVideoModal" class="modal-title h2-modal-login"><?php echo $this->lang->line('select_video'); ?></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> x </button>
                </div>
                <div class="modal-body m-3" style="padding:0px;">

                    <form id="uploads_video" name="uploads_video" method="POST">

                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="mb-2 text-center">
                                        <input type="file" name="video_name" id="mFile" accept="video/mp4">
                                        <input type="hidden" name="path_folder_video" id="pathFolderVideo" value="">
                                        <button type="button" class="btn btn-primary button-modal-login" onclick="uploads_video_function('#uploads_video')"><?php echo $this->lang->line('add_video'); ?></button>
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
                            <button type="button" class="btn btn-primary button-modal-login" onclick="valideSelectedVideo()"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                        <br>

                        <div  class="col-md-12">
                            <div  class="row">
                                <div  class="bloc-repertoire-videos col-md-4" id="bloc-repertoire-videos">

                                </div>

                                <div  class="col-md-8">
                                    <h1>Liste Videos</h1>
                                    <div id="bloc-repertoire-videos2">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php foreach ($listChap as $value) { ?>

        <div class="modal fade" id="centeredModalPrimaryAddFigure<?= $value['IDChapitre']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                    <div class="modal-header">
                        <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('actionAjout'); ?> Test</h2>
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close">  x </button>
                    </div>
                    <div class="modal-body m-3" style="padding:0px;">
                        <form id="addFigure<?= $value['IDChapitre']; ?>" name="addFigure" method="POST">

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

                                            <label for="mFile2" class="btn btn-primary button-modal-login"><?php echo $this->lang->line('selectImage'); ?></label>
                                            <button type="button" class="btn btn-primary button-modal-login" onclick="reset_Image(event, 'image<?= $value['IDChapitre']; ?>')"><?php echo $this->lang->line('annulerImage'); ?></button>
                                            <input type="file" name="mFile[]" id="mFile2" style="visibility:hidden;" accept="image/jpeg, image/png" onchange="loadFile(event, 'image58<?= $value['IDChapitre']; ?>')">
                                            <input type="hidden" name="IDChapitre" id="IDChapitre" value="<?= $value['IDChapitre']; ?>">
                                        </div>

                                        <div class="mb-2 text-center" style="height:200px; position:relative;">
                                            <img style="max-width:100%; max-height:100%; margin:auto;" id="image58<?= $value['IDChapitre']; ?>">
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
                                <button type="button" class="btn btn-primary button-modal-login" onclick="add_Figure('addFigure<?= $value['IDChapitre']; ?>')"><?php echo $this->lang->line('actionAjout'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>



    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

    <body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">

    <?php
    include('header_steppes.php');
    ?>

    <div class="wrapper">

        <div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">
            <main class="content">
                <div class="container-fluid p-0">
                    <?php
                    include('header_nav.php');
                    ?>
                    <div class="row">
                        <div class="col-xl-12" style="margin: auto; ">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="card-actions float-right">

                                    </div>
                                </div>
                                <!-- Zone supérieure au-dessus du tableau -->
<div style="
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 8px;
    margin-top: 1px;
    margin-bottom: -20px;
">
    <div style="flex: 1;">
    </div>

    <div style="flex: 1; text-align: center;">
        <button type="button"
                class="btn btn-primary"
        onclick="window.open('http://localhost:3000/admin/?token=<?= $jwt ?>', '_blank');">
            <?= $this->lang->line('actionAjout'); ?> Chapitres
        </button>
    </div>

    <div style="flex: 1; text-align: right;">
    </div>

</div>

















                                <div class="card-body" style=" display: flex;  justify-content: center;">
                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
<form name="pageForm_SetChap" id="pageForm_SetChap_<?= $OneBook[0]['IDLivre']; ?>" action="">
    <div class="row" style="flex: 1 0 0%;">
        <a href="#" data-toggle="modal" data-target="#modalChap_<?= $OneBook[0]['IDLivre']; ?>">
            <i class="fa fa-plus" title="<?= $this->lang->line('actionAjout'); ?>"></i>
        </a>

        <div class="modal fade" id="modalChap_<?= $OneBook[0]['IDLivre']; ?>" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="h2 mb-1" style="font-family: Georgia, serif;font-size: 180%;">
                            <?= $OneBook[0]['Titre']; ?>
                        </h3>
                        <input type="hidden" name="bookID" id="bookID_<?= $OneBook[0]['IDLivre']; ?>" value="<?= $OneBook[0]['IDLivre']; ?>">
                    </div>

                    <div class="card-body">
                        <?php 
                        $idTheme = $OneBook[0]['IDTheme'];
                        
                        if (in_array($idTheme, [20, 31, 36])): 
                            $themesCibles = [];
                            if ($idTheme == 20) $themesCibles = [1];   
                            if ($idTheme == 31) $themesCibles = [21];  
                            if ($idTheme == 36) $themesCibles = [33];  

                            $livres = $this->db->where_in('IDTheme', $themesCibles)->get('_livre')->result_array();
                        ?>
                            <div class="form-group mb-3">
                                <label for="chapitreAssocie_<?= $OneBook[0]['IDLivre']; ?>" style="font-weight:bold;">
                                    Sélectionner un chapitre associé <span style="color:red;">*</span>
                                </label>

                                <select name="chapitreAssocie" 
                                        id="chapitreAssocie_<?= $OneBook[0]['IDLivre']; ?>" 
                                        class="form-control select-chapitre-associe" 
                                        required>
                                    <option value="">-- Choisissez un chapitre --</option>

                                    <?php
                                    foreach ($livres as $livre) {
                                        echo "<optgroup label='" . htmlspecialchars($livre['Titre']) . "'>";

                                        $chapitres = $this->db
                                            ->where('IDLivre', $livre['IDLivre'])
                                            ->get('_chapitre')
                                            ->result_array();

                                        if (count($chapitres) > 0) {
                                            foreach ($chapitres as $chapitre) {
echo "<option value='" . $chapitre['IDChapitre'] . "'>" . htmlspecialchars($chapitre['TitreChapitre']) . "</option>";
                                            }
                                        } else {
                                            echo "<option disabled>(Aucun chapitre)</option>";
                                        }

                                        echo "</optgroup>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <style>
                            .select-chapitre-associe,
                            .select-chapitre-associe option,
                            .select-chapitre-associe optgroup {
                                color: #000 !important;
                                background-color: #fff !important;
                            }
                            .select-chapitre-associe {
                                -webkit-appearance: menulist !important;
                                appearance: menulist !important;
                            }
                            </style>
                        <?php endif; ?>

                        <div class="list_wrapper_<?= $OneBook[0]['IDLivre']; ?>">
                            <div class="row">
                                <div class="col-xs-7 col-sm-7 col-md-7">
                                    <div class="form-group">
                                        Chapitre 1
                                        <input name="list[]" type="text" placeholder="Titre de chapitre" class="form-control" id="list_<?= $OneBook[0]['IDLivre']; ?>_0">
                                    </div>
                                </div>

                                <div class="col-xs-1 col-sm-1 col-md-1">
                                    <br>
                                    <button class="btn btn-primary list_add_button" type="button" data-bookid="<?= $OneBook[0]['IDLivre']; ?>">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" onclick="set_LivChap(<?= $OneBook[0]['IDLivre']; ?>)">Enregistrer</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

                                    <?php } ?>

                                    <table class="table table-striped" style="width: 95%; align-self: center;">
                                        <thead>
                                        <tr>
                                            <?php 
                                            $estPathologieBook = in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31]);
                                            if ($estPathologieBook): ?>
                                                <th width="5%" style="text-align: left;"></th>
                                                <th width="30%" style="text-align: center;">Titre Chapitre</th>
                                                <th width="20%" style="text-align: center;">Anatomie - Cours fondamental complet</th>
                                                <th width="20%" style="text-align: center;">Anatomie - synthèse structurée</th>
                                                <th width="25%" style="text-align: center;">Pathologies</th>
                                            <?php else: ?>
                                                <!-- ✅ PATCH : Ajouter une colonne vide pour la colonne des icônes d'administration -->
                                                <th width="5%" style="text-align: left;"></th>
                                                <th width="15%">Cours</th>
                                                <?php if ($category['EstActifResume'] == 1) { ?>
                                                    <th width="15%">Résumé</th>
                                                <?php } ?>

                                                <?php if ($category['EstActifQSM'] == 1) { ?>
                                                    <th width="15%">QCM B</th>
                                                    <th width="15%">QCM I</th>
                                                    <th width="15%">QCM A</th>
                                                <?php } ?>

                                                <?php if ($category['EstActifQROC'] == 1) { ?>
                                                    <th width="15%">QROC</th>
                                                <?php } ?>

                                                <?php if ($category['EstActifCalques'] == 1) { ?>
                                                    <th width="15%">Calques</th>
                                                <?php } ?>

                                                <?php if ($category['EstActifTest'] == 1) { ?>
                                                    <th width="15%">Test</th>
                                                <?php } elseif ($category['EstActifTest'] == 2) { ?>
                                                    <th width="15%">
                                                        <input type="button" class="btn btn-outline-primary" style="border-color: #f8f9fa;color: #000000;" value="Test" data-toggle="modal" data-target="#centeredModalPrimaryTestFigure">
                                                    </th>
                                                <?php } ?>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>
                                        <tbody id="serChap">
                                        <form name="pageForm_Chap" id="pageForm_Chap" action="">
                                            <?php foreach ($listChap as $value) { 
                $estPathologie = in_array($value['IDLivre'], [20, 30, 31]) || in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31]);
            ?>
                <tr>
                    <?php if (!$estPathologie): ?>

                    <td style="text-align: left; ">
                                                       <div class="row">
 <div class="col-md-4">
        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" title="<?php echo $this->lang->line('actionEdit'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>

                <a href="#" onclick="return suppCh('<?php print base64_encode($value['IDChapitre']); ?>')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>">
                    <i class="fa fa-trash-alt" title="<?php echo $this->lang->line('actionSupp'); ?>"></i>
                </a>
                <?php if ((strlen($this->session->userdata('passTok')) == 200) 
                        && ($this->session->userdata('EstAdmin') == 1) 
                        && (in_array($value['IDLivre'], [20, 30, 31]) 
                            || in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31]))) { ?>
                    <a href="#" onclick="openSousChapForm('<?php print $value['IDChapitre']; ?>', '<?php print $value['IDLivre']; ?>')" title="Ajouter Sous-Chapitre">
                        <i class="fa fa-plus"></i>
                    </a>
                <?php } ?>
                <div class="dropdown-menu">
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 1.4em; padding-right: 1.4em;">
                            <input type="text" class="form-control my-3" name="setTitreChap[]" id="setTitreChap">
                            <input type="hidden" name="set_IdCh[]" id="set_IdCh" value="<?php print $value['IDChapitre']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-2" style="text-align: center;">
                            <span class="btn btn-info" onclick="set_ChapBack()"><i class="fas fa-check"></i> Valider</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-md-8" style="font-size: 0.97rem; display: flex; align-items: center;">
        <!-- <?php if (in_array($value['IDLivre'], [20, 30, 31]) || in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31])): ?>
            <span class="toggle-souschap" style="cursor: pointer; margin-right: 0.5em;">&#9654;</span>
        <?php endif; ?> -->
        <span><?= $value['TitreChapitre']; ?></span>
    </div>
</div>

<div class="souschap-container" style="display: none; padding-left: 2em; margin-bottom: 1em;"></div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6" style="font-size: 0.97rem;">
                                                                <?php if ($value['NbreCours'] > 0) { ?>
                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreCours/<?= $value['IDChapitre']; ?>"
                                                                       class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;">
                                                                        <?php echo $this->lang->line('cour'); ?>
                                                                    </a>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                    <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                            <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu" style="min-width: 25rem;">
                                                                            <input type="text" style="width: 100%" class="form-control" id="tokenfieldCrs_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysCurs']; ?>" />
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','curs')"> Valider</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dropdown " style="">
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                            </svg>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="mFile[]" id="mFile" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                    <input type="hidden" name="attach_file[]" id="attach_file" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_Curs()"><i class="fas fa-upload"></i> Upload (COURS.docx)</span>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppCurs('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                    <div class="dropdown " style="">
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a>

                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="<?php print $value['IDChapitre']; ?>_mFileFig[]" id="mFileFig" readonly class="btn btn-info btn-sm" accept="image/jpeg" multiple>
                                                                                    <input type="hidden" name="attach_fileFig[]" id="attach_fileFig" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_Fig()"><i class="fas fa-upload"></i> Upload Max 7Mo (Figure.JPG)</span>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppAllFigu('<?php print base64_encode($value['IDChapitre']); ?>')" title="<?php print $value['TitreChapitre']; ?>" id="FigS_<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>


                                                                <?php } ?>

                                                                <div class="col-2">
                                                                    <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'cours')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                        <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <?php if ($category['EstActifResume'] == 1) { ?>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreResume'] > 0) { ?>
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreResume/<?= $value['IDChapitre']; ?>" 
                                                                           class="btn btn-outline-primary mr-1" 
                                                                           style="border-color: #f8f9fa;color: #000000;">
                                                                            <?php echo $this->lang->line('resume'); ?>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreFigures/<?= $value['IDChapitre']; ?>" 
                                                                           class="btn btn-outline-primary mr-1" 
                                                                           style="border-color: #eb7648ff;color: #eb7648ff;">
                                                                            vide
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu" style="min-width: 25rem;">
                                                                                <input type="text" style="width: 100%" class="form-control" id="tokenfieldRsm_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysResum']; ?>" />
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','resum')"> Valider</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown " style="">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="mFileResum[]" id="mFileResum" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                        <input type="hidden" name="attach_fileResum[]" id="attach_fileResum" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_Resum()"><i class="fas fa-upload"></i> Upload (Resume.docx)</span>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppResum('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print $value['TitreChapitre']; ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropdown " style="">
                                                                            <!-- <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                                <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                            </a> -->
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="<?php print $value['IDChapitre']; ?>_mFileFigResum[]" id="mFileFigResum" readonly class="btn btn-info btn-sm" accept="image/jpeg" multiple>
                                                                                        <input type="hidden" name="attach_fileFigResum[]" id="attach_fileFigResum" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_FigResum()"><i class="fas fa-upload"></i> Upload Max 7Mo (Figure.JPG)</span>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppAllFiguRSM('<?php print base64_encode($value['IDChapitre']); ?>')" title="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="FigSR_<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="dropdown ">
                                                                        <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'cours')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                            <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </td>

                                                    <?php } ?>

                                                    <?php if ($category['EstActifQSM'] == 1) { ?>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreQcm'] > 0) { ?>
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcm/<?= $value['IDChapitre']; ?>"
                                                                           class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;">B -<?php echo $this->lang->line('qcm'); ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu" style="min-width: 25rem;">
                                                                                <input type="text" style="width: 100%" class="form-control" id="tokenfieldQcm_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysQcm']; ?>" />
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','qcm')"> Valider</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown " style="">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="mFileQCM[]" id="mFileQCM" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                        <input type="hidden" name="attach_fileQCM[]" id="attach_fileQCM" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_QCM()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>" class="btn btn-info">Editer</a>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppQCM('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>

                                                                <div class="col-2">
                                                                    <div class="dropdown " style="">
                                                                        <!-- <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a> -->

                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="mFileQCM_Fig_Ass[]" id="mFileQCM_Fig_Ass" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                    <input type="hidden" name="attach_fileQCM_Fig_Ass[]" id="attach_fileQCM_Fig_Ass" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_QCM_Fig_Ass()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>"
                                                                                       class="btn btn-info">Editer</a>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppQCM_Fig_Ass('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dropdown ">
                                                                        <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'QCM')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                            <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                       <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreQcm'] > 0) { ?>
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcm/<?= $value['IDChapitre']; ?>"
                                                                           class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;">I -<?php echo $this->lang->line('qcm'); ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu" style="min-width: 25rem;">
                                                                                <input type="text" style="width: 100%" class="form-control" id="tokenfieldQcm_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysQcm']; ?>" />
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','qcm')"> Valider</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown " style="">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="mFileQCM[]" id="mFileQCM" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                        <input type="hidden" name="attach_fileQCM[]" id="attach_fileQCM" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_QCM()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>" class="btn btn-info">Editer</a>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppQCM('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>

                                                                <div class="col-2">
                                                                    <div class="dropdown " style="">
                                                                        <!-- <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a> -->

                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="mFileQCM_Fig_Ass[]" id="mFileQCM_Fig_Ass" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                    <input type="hidden" name="attach_fileQCM_Fig_Ass[]" id="attach_fileQCM_Fig_Ass" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_QCM_Fig_Ass()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>"
                                                                                       class="btn btn-info">Editer</a>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppQCM_Fig_Ass('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dropdown ">
                                                                        <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'QCM')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                            <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                                                                                <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreQcm'] > 0) { ?>
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcm/<?= $value['IDChapitre']; ?>"
                                                                           class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;">A -<?php echo $this->lang->line('qcm'); ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu" style="min-width: 25rem;">
                                                                                <input type="text" style="width: 100%" class="form-control" id="tokenfieldQcm_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysQcm']; ?>" />
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','qcm')"> Valider</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown " style="">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="mFileQCM[]" id="mFileQCM" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                        <input type="hidden" name="attach_fileQCM[]" id="attach_fileQCM" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_QCM()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>" class="btn btn-info">Editer</a>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppQCM('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>

                                                                <div class="col-2">
                                                                    <div class="dropdown " style="">
                                                                        <!-- <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a> -->

                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="mFileQCM_Fig_Ass[]" id="mFileQCM_Fig_Ass" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                    <input type="hidden" name="attach_fileQCM_Fig_Ass[]" id="attach_fileQCM_Fig_Ass" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_QCM_Fig_Ass()"><i class="fas fa-upload"></i> Upload (QCM.docx)</span>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcmEdit/<?= $value['IDChapitre']; ?>"
                                                                                       class="btn btn-info">Editer</a>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppQCM_Fig_Ass('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dropdown ">
                                                                        <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'QCM')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                            <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                    <?php } ?>

                                                    <?php if ($category['EstActifQROC'] == 1) { ?>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreQroc'] > 0) { ?> <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQroc/<?= $value['IDChapitre']; ?>" class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;"><?php echo $this->lang->line('qroc'); ?></a> <?php } ?>
                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu" style="min-width: 25rem;">
                                                                                <input type="text" style="width: 100%" class="form-control" id="tokenfieldQrc_<?php print $value['IDChapitre']; ?>" name="tokenfield[]" value="<?php print $value['indexKeysQroc']; ?>" />
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_KeysIndex('<?php print $value['IDChapitre']; ?>','qroc')"> Valider</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown " style="">
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="file" name="mFileQROC[]" id="mFileQROC" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                        <input type="hidden" name="attach_fileQROC[]" id="attach_fileQROC" value="<?php print $value['IDChapitre']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-info" onclick="set_QROC()"><i class="fas fa-upload"></i> Upload (QROC.docx)</span>
                                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQrocEdit/<?= $value['IDChapitre']; ?>" class="btn btn-info">Editer</a>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="mt-2" style=" text-align: center;">
                                                                                        <span class="btn btn-danger" onclick="suppQROC('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="col-2">

                                                                    <div class="dropdown " style="">
                                                                        <!-- <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a> -->

                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-10">
                                                                                    <input type="file" name="mFileQROC_Fig_Ass[]" id="mFileQROC_Fig_Ass" readonly class="btn btn-info btn-sm" accept=".docx">
                                                                                    <input type="hidden" name="attach_fileQROC_Fig_Ass[]" id="attach_fileQROC_Fig_Ass" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_QROC_Fig_Ass()"><i class="fas fa-upload"></i> Upload (QROC.docx)</span>
                                                                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQrocEdit/<?= $value['IDChapitre']; ?>"
                                                                                       class="btn btn-info">Editer</a>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-danger" onclick="suppQROC_Fig_Ass('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>"><i class="fa fa-trash-alt"></i> <?php echo $this->lang->line('supp_title'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="dropdown ">
                                                                        <a href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>',  'QROC')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                            <i style="font-size:17px; margin:3px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </td>

                                                    <?php } ?>

                                                    <?php if ($category['EstActifCalques'] == 1) { ?>

                                                        <td>

                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreTest'] > 0) { ?> <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>listCalque/<?= $value['IDChapitre']; ?>" class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;"><?php echo $this->lang->line('Calques'); ?></a> <?php } ?>
                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                        <div class="dropleft" style="" onclick="event.stopPropagation()">
                                                                            <a href="#" data-toggle="modal" data-target="#centeredModalPrimaryAddFigure<?= $value['IDChapitre']; ?>" class="">
                                                                                <i class="align-middle me-2 fas fa-fw fa-plus" title="Ajouter Test"></i>
                                                                            </a>

                                                                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>settingTest/<?= $value['IDChapitre']; ?>" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <a style=" margin-left:40px;" href="#" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'Calque')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                        <i style="font-size:17px; margin:3px 10px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                            <div class="dropdown ">

                                                            </div>

                                                        </td>

                                                    <?php } ?>

                                                    <?php if ($category['EstActifTest'] == 2) { ?>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-6" style="font-size: 0.97rem;">
                                                                    <?php if ($value['NbreTest'] > 0) { ?> <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>listTest/<?= $value['IDChapitre']; ?>" class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;">Test</a> <?php } ?>
                                                                </div>
                                                                <div class="col-2">
                                                                    <a href="#" style=" margin-top:15px;" data-toggle="modal" onclick="chargeVideos(<?= $value['IDChapitre']; ?>, '<?= $value['TitreChapitre']; ?>', 'Test')" data-target="#popupAdminListVideos" class="" title="<?php echo $this->lang->line('videos'); ?>">
                                                                        <i style="font-size:17px; margin:5px 0px;" class="fa fa-play-circle" aria-hidden="true"></i>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                            <div class="dropdown ">
                                                            </div>

                                                        </td>
                                                    <?php } ?>
<?php else: ?>

<!-- Six colonnes pour les thèmes pathologiques, alignées avec le header -->
    <!-- 1. ADMIN OUTILS (Aligné gauche) -->
    <td style="text-align: left;">
        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" title="<?php echo $this->lang->line('actionEdit'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>
                <a href="#" onclick="return suppCh('<?php print base64_encode($value['IDChapitre']); ?>')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?>" title="<?php echo $this->lang->line('actionSupp'); ?>">
                    <i class="fa fa-trash-alt"></i>
                </a>
                <a href="#" onclick="openSousChapForm('<?php print $value['IDChapitre']; ?>', '<?php print $value['IDLivre']; ?>')" title="Ajouter Sous-Chapitre">
                    <i class="fa fa-plus"></i>
                </a>
                <div class="dropdown-menu">
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 1.4em; padding-right: 1.4em;">
                            <input type="text" class="form-control my-3" name="setTitreChap[]" id="setTitreChap" placeholder="Titre">
                            <input type="hidden" name="set_IdCh[]" id="set_IdCh" value="<?php print $value['IDChapitre']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-2" style="text-align: center;">
                            <span class="btn btn-info" onclick="set_ChapBack()"><i class="fas fa-check"></i> Valider</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </td>
    <!-- 2. TITRE (Centré, Gras) -->
    <td style="text-align: center; font-weight: bold; color: #333;">
        <?= $value['TitreChapitre']; ?>
    </td>

    <!-- 3. VERSION DÉTAILLÉE (Centré) -->
    <td style="text-align: center;">
        <div id="rappel-detail-zone-<?= $value['IDChapitre']; ?>">
            <span style="color: #999; font-size: 0.75rem;"><i class="fas fa-spinner fa-spin"></i></span>
        </div>
    </td>

    <!-- 4. RÉSUMÉ (Centré) -->
    <td style="text-align: center;">
        <div id="rappel-resume-zone-<?= $value['IDChapitre']; ?>">
            <span style="color: #999; font-size: 0.75rem;"><i class="fas fa-spinner fa-spin"></i></span>
        </div>
    </td>

    <!-- 5. PATHOLOGIES (fusionné) -->
    <td style="text-align: center;">
         <div style="display: flex; align-items: center; justify-content: center; gap: 5px; cursor: pointer; padding: 6px 10px; border-radius: 6px; display: inline-flex; color: #4b5563;" onclick="togglePathoContainer(<?= $value['IDChapitre']; ?>)">
            <span style="font-weight: 600; font-size: 0.85rem;">Pathologies</span>
            <i class="fas fa-chevron-right" id="patho-arrow-<?= $value['IDChapitre']; ?>" style="font-size: 0.75rem; transition: transform 0.2s;"></i>
         </div>
    </td>

</tr>
<!-- Ligne suivante pour le contenu accordéon (masqué par défaut) -->
<tr>
    <td colspan="5" style="padding: 0; border-top: none;">
        
        <script>
        $(document).ready(function() {
            const estAdmin = <?= ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) ? 'true' : 'false'; ?>;
            checkAndDisplayRappel(<?= $value['IDChapitre']; ?>, '<?= $value['IdChapterRappel'] ?? ''; ?>', <?= $value['IDLivre']; ?>, <?= (int)$OneBook[0]["IDTheme"]; ?>, estAdmin, <?= (int)($value['NbreCoursRappel'] ?? 0); ?>, <?= (int)($value['NbreResumeRappel'] ?? 0); ?>);
        });
        </script>
        
        <!-- Container unique pour Pathologies (fusionné) -->
        <div class="souschap-container" 
             id="patho-container-<?= $value['IDChapitre']; ?>"
             style="display:none; padding: 15px; background: #fafafa; border-bottom: 2px solid #efefef;">
        </div>
    </td>
<?php endif; ?>

                                                </tr>
                                            <?php } ?>
                                        </form>
                                        </tbody>

<script>
$(document).ready(function() {
    // L'ancien code .toggle-patho a été supprimé car nous utilisons maintenant togglePathoContainer() directement
});

// Function to toggle pathology container (simplifié - un seul accordéon)
function togglePathoContainer(idChapitre) {
    const container = $('#patho-container-' + idChapitre);
    const arrow = $('#patho-arrow-' + idChapitre);

    // Si le container est déjà visible, on le ferme
    if (container.is(':visible')) {
        arrow.css('transform', 'rotate(0deg)');
        container.slideUp();
        return;
    }

    // Fermer tous les autres chapitres
    $('[id^="patho-container-"]').each(function() {
        const containerId = $(this).attr('id');
        if ($(this).is(':visible') && containerId !== container.attr('id')) {
            $(this).slideUp();
            const idPart = containerId.split('-').pop();
            $('#patho-arrow-' + idPart).css('transform', 'rotate(0deg)');
        }
    });

    // Si déjà chargé, juste afficher
    if (container.html().trim() !== '') {
        container.slideDown();
        arrow.css('transform', 'rotate(90deg)');
        return;
    }

    // Charger le contenu via AJAX
    const endpoint = "home/get_SousChapitres";
    
    $.ajax({
        url: "<?= base_url(); ?>" + endpoint,
        type: "POST",
        data: JSON.stringify({ idChap: idChapitre }),
        contentType: "application/json",
        dataType: "json",
        success: function(sousChaps) {
            container.html("");
            
            if (sousChaps.length === 0) {
                container.append(
                    `<div style="font-style:italic; color:#888; padding: 15px; text-align: center;">Aucune pathologie trouvée</div>`
                );
                container.slideDown();
                arrow.css('transform', 'rotate(90deg)');
                return;
            }
//
            // Ajout d'un en-tête pour la clarté si c'est le début
            if (sousChaps.length > 0) {
                    container.append(`
                        <div style="display: flex; width: 100%; padding: 5px 0; border-bottom: 2px solid #e2e8f0; margin-bottom: 5px; font-weight: bold; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            <div style="width: 5%;"></div>
                            <div style="width: 25%; padding-left: 10px;">Titre Pathologie</div>
                            <div style="width: 35%; text-align: center;">Version Intégrale</div>
                            <div style="width: 35%; text-align: center;">Version Essentielle</div>
                        </div>
                    `);
                }

                sousChaps.forEach(sc => {
                    const idEncoded = sc.IDSousChapitre;
                    const titre = (sc.TitreSousChapitre || '').replace(/'/g, "&#39;");
                    const estAdmin = <?= ($this->session->userdata('EstAdmin') == 1) ? 'true' : 'false'; ?>;
                    const siteLang = "<?= $this->lang->line('siteLang'); ?>";
                    
                    let html = `
                    <div class="pathologie-item" style="margin-bottom: 4px; background: #fff; border: 1px solid #f1f5f9; border-radius: 6px; padding: 10px 0; transition: all 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; width: 100%;">
                            
                            <!-- 1. ADMIN OUTILS (5%) -->
                            <div style="width: 5%; display: flex; justify-content: center; align-items: center;">
                                ${estAdmin ? `
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" aria-expanded="false" title="Gérer">
                                            <i class="fa fa-ellipsis-v" style="color: #94a3b8; font-size: 0.85rem;"></i>
                                        </a>
                                        <div class="dropdown-menu p-3" style="min-width:18rem; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); border: none;">
                                            <div class="mb-3">
                                                <label style="font-size: 0.75rem; font-weight: bold; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase;">Contenu (.docx)</label>
                                                <div class="d-flex gap-1">
                                                    <input type="file" id="mFile_${idEncoded}" class="form-control form-control-sm" style="font-size: 0.7rem;">
                                                    <button class="btn btn-primary btn-xs" onclick="set_SubChapCurs('${idEncoded}')" style="white-space:nowrap;">Valider</button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label style="font-size: 0.75rem; font-weight: bold; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase;">Résumé (.docx)</label>
                                                <div class="d-flex gap-1">
                                                    <input type="file" id="mFileResume_${idEncoded}" class="form-control form-control-sm" style="font-size: 0.7rem;">
                                                    <button class="btn btn-warning btn-xs" onclick="set_SubChapResume('${idEncoded}')" style="white-space:nowrap;">Valider</button>
                                                </div>
                                            </div>
                                            <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 12px; display: flex; justify-content: space-between;">
                                                <button class="btn btn-outline-danger btn-xs" onclick="return suppSousChap('${idEncoded}');"><i class="fa fa-trash-alt"></i> Supprimer</button>
                                                <button class="btn btn-outline-primary btn-xs" onclick="openRenomeModal('${idEncoded}', '${titre}');"><i class="fa fa-edit"></i> Renommer</button>
                                            </div>
                                        </div>
                                    </div>
                                ` : '<i class="fas fa-circle" style="color: #e2e8f0; font-size: 0.4rem;"></i>'}
                            </div>

                            <!-- 2. TITRE (25%) -->
                            <div style="width: 25%; display: flex; align-items: center; padding-left: 10px; overflow: hidden;">
                                <span id="${idEncoded}" name="${titre}" style="font-weight: 600; color: #334155; font-size: 0.85rem; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;" title="${titre}">${titre}</span>
                            </div>

                            <!-- 3. ZONE CONTENU (35%) -->
                            <div style="width: 35%; display: flex; align-items: center; padding: 0 10px; border-left: 1px solid #f1f5f9;">
                                <div class="row align-items-center" style="width: 100%; margin: 0;">
                                    <div class="col-8" style="padding: 0; text-align: center;">
                                        ${sc.FichierHTML ? `
                                            <a href="<?= base_url('PlatFormeConvert/'); ?>${sc.FichierHTML}" 
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary" 
                                               style="font-size: 0.75rem; padding: 4px 10px; width: 90%; border-radius: 4px; font-weight: 600;">
                                               Contenu
                                            </a>
                                        ` : '<span style="color: #cbd5e1; font-size: 0.75rem; font-style: italic;">Indisponible</span>'}
                                    </div>
                                    <div class="col-4" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; padding: 0; justify-items: center;">
                                        <a href="#" onclick="return false;"><i class="fas fa-key" style="color: #3085d6; font-size: 0.8rem;"></i></a>
                                        <a href="#" onclick="openRenomeModal('${idEncoded}', '${titre}'); return false;"><i class="fas fa-edit" style="color: #3085d6; font-size: 0.8rem;"></i></a>
                                        <a href="#" onclick="return false;"><i class="fa fa-play-circle" style="color: #3085d6; font-size: 0.8rem;"></i></a>
                                        <a href="#" onclick="openTranslationModal('${sc.IDSousChapitre}'); return false;"><i class="fa fa-globe" style="color: #3085d6; font-size: 1rem;"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. ZONE RÉSUMÉ (35%) -->
                            <div style="width: 35%; display: flex; align-items: center; padding: 0 10px; border-left: 1px solid #f1f5f9;">
                                <div class="row align-items-center" style="width: 100%; margin: 0;">
                                    <div class="col-8" style="padding: 0; text-align: center;">
                                        ${sc.FichierHTML_Resume ? `
                                            <a href="<?= base_url('PlatFormeConvert/'); ?>${sc.FichierHTML_Resume}" 
                                               target="_blank"
                                               class="btn btn-sm btn-outline-warning" 
                                               style="font-size: 0.75rem; padding: 4px 10px; width: 90%; border-radius: 4px; font-weight: 600; color: #92400e;">
                                               Résumé
                                            </a>
                                        ` : '<span style="color: #cbd5e1; font-size: 0.75rem; font-style: italic;">Indisponible</span>'}
                                    </div>
                                    <div class="col-4" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; padding: 0; justify-items: center;">
                                        <a href="#" onclick="return false;"><i class="fas fa-key" style="color: #3085d6; font-size: 0.8rem;"></i></a>
                                        <a href="#" onclick="return false;"><i class="fas fa-edit" style="color: #3085d6; font-size: 0.8rem;"></i></a>
                                        <a href="#" onclick="return false;"><i class="fa fa-play-circle" style="color: #3085d6; font-size: 1rem;"></i></a>
                                        <a href="#" onclick="openTranslationModal('${sc.IDSousChapitre}'); return false;"><i class="fa fa-globe" style="color: #3085d6; font-size: 1rem;"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    container.append(html);
                });

                container.slideDown();
                arrow.css('transform', 'rotate(90deg)');
            },
        error: function(xhr, status, error) {
            console.error('Erreur chargement pathologies:', error);
            container.html('<div style="color:red; font-style:italic; padding: 15px; text-align: center;">Erreur de chargement</div>');
            container.slideDown();
            arrow.css('transform', 'rotate(90deg)');
        }
    });
}
</script>

   
                                    </table>
                                </div>




                                
                                <div class="row" style="padding-top: 5rem ; background-color: white"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>
    <?php
    include('footer.php');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<div class="modal fade" id="modalSousChap" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-3">
      <h5>Ajouter des sous-chapitres</h5>
      <form id="formSousChap">
        <input type="hidden" name="bookID" id="sousChap_bookID">
        <input type="hidden" name="chapters[0][idChap]" id="sousChap_chapID">

        <div class="form-group mt-3">
          <label for="sousChaps">Sous-chapitres (séparés par une virgule)</label>
          <input type="text" class="form-control" id="sousChaps" placeholder="Ex: Introduction, Développement, Conclusion">
        </div>

        <div class="text-end mt-4">
          <button type="button" class="btn btn-secondary" onclick="closeSousChapModal()">Annuler</button>
          <button type="button" class="btn btn-primary" onclick="submitSousChap()">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.toggle-souschap', function() {
        const arrow = $(this);
        const container = arrow.closest('.row').next('.souschap-container');

        if (container.is(':visible')) {
            container.slideUp();
            arrow.html('&#9654;');
            return;
        }

        const chapID = arrow.closest('.row').find('input[name="set_IdCh[]"]').val();

        $.ajax({
            url: "<?= base_url('home/get_SousChapitres'); ?>",
            type: "POST",
            data: JSON.stringify({ idChap: chapID }),
            contentType: "application/json",
            dataType: "json",
            success: function(sousChaps) {
                container.html('');

                if (sousChaps.length > 0) {
                    sousChaps.forEach(sc => {
                        const idEncoded = sc.IDSousChapitre;
                        const titre = sc.TitreSousChapitre.replace(/'/g, '&#39;');

// Dans la génération HTML :
let html = `
<div class="souschap-item" 
     style="display:flex;align-items:center;padding:0.5em 0;border-bottom:1px solid #eee;">
    
    <div style="flex:1;display:flex;align-items:center;gap:0.5em;">
        
        <div class="dropdown" style="position:relative;">
            <a href="#" data-toggle="dropdown" data-display="static" 
               aria-expanded="false" title="Modifier / gérer le fichier">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" 
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
            </a>

            <div class="dropdown-menu p-2" style="min-width:18rem;">
                <div class="row">
                    <div class="col-md-12">
                        <!-- ðŸ”¥ Ajout de l'attribut ID -->
                        <input type="file" 
                               id="mFile_${idEncoded}"
                               name="mFile_${idEncoded}" 
                               class="form-control form-control-sm mb-2" 
                               accept=".docx">
                        <input type="hidden" 
                               name="attach_file_${idEncoded}" 
                               value="${idEncoded}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <span class="btn btn-info btn-sm mt-1" 
                              onclick="set_SubChapCurs('${idEncoded}')">
                            <i class="fas fa-upload"></i> Upload (COURS.docx)
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 text-center">
                        <!-- ðŸ”¥ Correction : suppSousChap au lieu de suppCurs -->
                        <span class="btn btn-danger btn-sm" 
                              onclick="suppSousChap('${idEncoded}')"
                              name="${titre}" 
                              id="del_${idEncoded}">
                            <i class="fa fa-trash-alt"></i> Supprimer
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <span>- ${sc.TitreSousChapitre}</span>
    </div>
`;
                         if (sc.FichierHTML && sc.FichierHTML.length > 0) {
                                html += `
                                    <div style="margin-left: 1em;">
                                        <a href="<?= base_url('PlatFormeConvert/'); ?>${sc.FichierHTML}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            Voir cours
                                        </a>
                                    </div>
                                `;
                            }
                        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                        html += `
                            <div style="margin-left: auto; display: flex; gap: 0.8em;">
                                <!-- Édition simple du titre -->
<div class="dropdown" 
     style="position: relative;" 
     onclick="event.stopPropagation()">
                                    <a href="#" data-toggle="dropdown" aria-expanded="false" title="Modifier le titre">
                                        <i class="fa fa-edit" style="color: #3085d6; font-size: 1.1em;"></i>
                                    </a>
                                    <div class="dropdown-menu" style="min-width: 20rem; padding: 1rem;">
                                        <input type="text" id="editSousChap_${idEncoded}" 
                                            class="form-control" 
                                            placeholder="Nouveau titre..." 
                                            value="${sc.TitreSousChapitre}" />
                                        <div class="mt-2 text-center">
                                            <span class="btn btn-info btn-sm" 
                                                onclick="validerEditSousChap('${idEncoded}')">
                                                Valider
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Suppression du sous-chapitre -->
                                <a href="#" onclick="return suppSousChap('${idEncoded}');"
                                   name="${titre}"
                                   id="${idEncoded}"
                                   title="Supprimer le sous-chapitre"
                                   style="text-decoration: none;">
                                    <i class="fa fa-trash-alt" style="color: #d33; font-size: 1.1em;"></i>
                                </a>
                            </div>
                        `;
                        <?php } ?>

                        html += `</div>`;
                        container.append(html);
                    });
                } else {
                    container.append('<div style="font-style:italic; color:#888; padding: 0.5em 0;">Aucun sous-chapitre</div>');
                }

                container.slideDown();
                arrow.html('&#9660;');
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur AJAX',
                    text: 'Impossible de charger les sous-chapitres'
                });
            }
        });
    });
});

// ===== FONCTIONS POUR GÉRER LES SOUS-CHAPITRES/PATHOLOGIES =====
function openSousChapForm(chapID, bookID) {
    document.getElementById('sousChap_bookID').value = bookID;
    document.getElementById('sousChap_chapID').value = chapID;
    document.getElementById('sousChaps').value = '';
    $('#modalSousChap').modal('show');
}

function closeSousChapModal() {
    $('#modalSousChap').modal('hide');
}

function submitSousChap() {
    console.log("Submit sous-chapitre initié");
    const bookID = $('#sousChap_bookID').val();
    const chapID = $('#sousChap_chapID').val();
    const sousChapsText = $('#sousChaps').val();

    if (!sousChapsText.trim()) {
        Swal.fire({
            icon: 'warning',
            title: 'Veuillez saisir au moins un sous-chapitre.'
        });
        return;
    }

    const sousChapsArray = sousChapsText.split(',').map(s => s.trim()).filter(Boolean);

    const dataToSend = {
        bookID: bookID,
        chapters: [{
            idChap: chapID,
            sousChaps: sousChapsArray
        }]
    };

    Swal.fire({
        title: 'Veuillez patienter...',
        text: 'Ajout des sous-chapitres en cours',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        type: "POST",
        url: "<?= base_url('home/set_LivSousChap'); ?>",
        data: JSON.stringify(dataToSend),
        contentType: "application/json",
        success: function (response) {
            console.log("Réponse serveur submitSousChap:", response);
            try {
                const res = JSON.parse(response);
                if (res[0].id == 1) {
                    $('#modalSousChap').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: res[0].desc,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: res[0].desc
                    });
                }
            } catch (err) {
                console.error("Erreur parsing JSON:", err, response);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur serveur',
                    text: 'La réponse du serveur est invalide.'
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Erreur AJAX submitSousChap:", status, error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur AJAX',
                text: "Impossible d'envoyer la requête au serveur."
            });
        }
    });
}

// ===== FONCTIONS POUR RENOMMER LES PATHOLOGIES =====
function openRenomeModal(idSousChap, oldTitle) {
    Swal.fire({
        title: 'Modifier le titre',
        input: 'text',
        inputValue: oldTitle,
        showCancelButton: true,
        confirmButtonText: 'Valider',
        cancelButtonText: 'Annuler',
        preConfirm: (newTitle) => {
            if (!newTitle) {
                Swal.showValidationMessage('Veuillez entrer un titre');
            }
            return newTitle;
        }
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?= base_url('home/update_SousChapitre'); ?>",
                type: "POST",
                data: JSON.stringify({ idSousChap: idSousChap, titre: result.value }),
                contentType: "application/json",
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Titre mis à jour', timer: 1000, showConfirmButton: false })
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Erreur', res.message || 'Impossible de renommer', 'error');
                    }
                }
            });
        }
    });
}

function openTranslationModal(idSousChap) {
    Swal.fire({
        title: 'Gestion des Traductions',
        html: `
            <div style="display: grid; grid-template-columns: 70px 1fr 1fr; gap: 20px; align-items: center; padding: 20px; text-align: left;">
                <!-- Header (Optional, for clarity) -->
                <div style="font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px;">Lang</div>
                <div style="font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px; text-align: center;">Action</div>
                <div style="font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px; text-align: center;">Contenu</div>

                <!-- Row EN -->
                <div style="font-weight: bold; color: #1d3557; font-size: 1.1rem;">EN</div>
                <div style="text-align: center;">
                    <button class="btn btn-primary btn-lg" style="width: 100%;" onclick="lancerTraduction('${idSousChap}', 'en')">
                        <i class="fas fa-magic"></i> Lancer traduction
                    </button>
                </div>
                <div style="text-align: center;">
                    <button class="btn btn-outline-info btn-lg" style="width: 100%;" onclick="voirTraduction('${idSousChap}', 'en')">
                        <i class="fas fa-eye"></i> Voir traduction
                    </button>
                </div>

                <!-- Row ES -->
                <div style="font-weight: bold; color: #1d3557; font-size: 1.1rem;">ES</div>
                <div style="text-align: center;">
                    <button class="btn btn-primary btn-lg" style="width: 100%;" onclick="lancerTraduction('${idSousChap}', 'es')">
                        <i class="fas fa-magic"></i> Lancer traduction
                    </button>
                </div>
                <div style="text-align: center;">
                    <button class="btn btn-outline-info btn-lg" style="width: 100%;" onclick="voirTraduction('${idSousChap}', 'es')">
                        <i class="fas fa-eye"></i> Voir traduction
                    </button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        width: '750px',
        height: '500px',
        customClass: {
            container: 'my-swal-container'
        }
    });
}

function lancerTraduction(idSousChap, lang) {
    Swal.fire({
        icon: 'info',
        title: 'Information',
        text: 'La traduction (' + lang.toUpperCase() + ') sera bientôt disponible pour ce sous-chapitre.'
    });
}

function voirTraduction(idSousChap, lang) {
    Swal.fire({
        icon: 'info',
        title: 'Information',
        text: 'L\'affichage de la traduction (' + lang.toUpperCase() + ') sera bientôt disponible.'
    });
}

function validerEditSousChap(idSousChap) {
    const newTitle = $('#editSousChap_' + idSousChap).val();
    if (!newTitle) {
        Swal.fire('Erreur', 'Le titre ne peut pas être vide', 'error');
        return;
    }

    $.ajax({
        url: "<?= base_url('home/update_SousChapitre'); ?>",
        type: "POST",
        data: JSON.stringify({ idSousChap: idSousChap, titre: newTitle }),
        contentType: "application/json",
        dataType: "json",
        success: function(res) {
            if (res.success) {
                Swal.fire({ icon: 'success', title: 'Titre mis à jour', timer: 1000, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire('Erreur', res.message || 'Impossible de renommer', 'error');
            }
        },
        error: function() {
            Swal.fire('Erreur', 'Erreur lors de la requête', 'error');
        }
    });
}
</script>



    <script language="JavaScript">

        var reset_Image = function(event, id) {
            var parent = event.target.parentElement
            var input = parent.children[0]
            input.value = '';
            var image = document.getElementById(id);
            image.src = '';
        }

        var loadFile = function(event, id) {
            var image = document.getElementById(id);
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        function add_Figure(id) {

            var data_plat = new FormData($('#' + id)[0]);

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
                                window.location.reload()
                            }
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

                    $('.modal-message').html("Sorry, File not Uploaded");
                    $('#modal-confirm-all').modal('show');
                }

            });

            return false;
        }

        function chargeVideos(idChapitre, titreChapitre, idType) {

            document.getElementById("IDChapitreVideo").value = idChapitre
            document.getElementById("IDTypeVideo").value = idType
            document.getElementById("TitreChapitreVideo").value = titreChapitre
            var formData = new FormData();
            formData.append('idChapitre', idChapitre);
            formData.append('idType', idType);

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
                url: "<?php echo base_url(); ?>video/listVideos",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {

                    console.log("sucess");
                    console.log(html);
                    console.log(html["id"]);

                    var res = JSON.parse(html)

                    var listVideos = res["desc"]

                    for(let i = 0; i < listVideos.length; i++){
                        listVideos[i].path = "uploads/"+listVideos[i].path
                    }

                    localStorage.setItem("listvideos", JSON.stringify(listVideos))

                    var somme = `
                    <div class="col-sm-12">`

                    for (let i = 0; i < res["desc"].length; i++) {
                        somme += `
                            <div class="row">
                            <div class="col-sm-4" style="text-align:center;">
                                <video width="100%" height="auto" controls id="list`+res["desc"][i]['id']+`">
                                      <source src="<?php echo base_url(); ?>`+res["desc"][i]['path']+`" type="video/mp4" >
                                      <!--<source src="movie.ogg" type="video/ogg">-->
                        Your browser does not support the video tag.
                        </video>
                        <!--<button onclick="open_video_plain_ecran(` + res["desc"][i]['id'] + `)" data-toggle="modal" data-target="#centeredModalDisplayVideo" class="btn btn-primary button-modal-login" style="padding:20px;">
                        <i style="font-size:40px;" class="fa fa-play" aria-hidden="true"></i>
                        </button>-->
                        </div>

                        <div class="col-sm-8">
                        <h2 style="color:white;"> ` + res["desc"][i]['titre'] + ` </h2>
                        <p style="color:white;"> ` + res["desc"][i]['description'] + ` </p>

                        <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

                        <button onclick="open_edit_video(` + res["desc"][i]['id'] + `);" data-toggle="modal" data-target="#addVideoModal" class="btn btn-primary button-modal-login" > Modifier </button>
                        <button onclick="open_delete_video(` + res["desc"][i]['id'] + `)" data-toggle="modal" data-target="#centeredModalPrimaryDeleteVideo" class="btn btn-primary button-modal-login" > Supprimer </button>

                        <?php } ?>
                        </div>

                        <hr>
                        </div>

                        `
                    }

                    if (res["desc"].length === 0) {
                        somme += `<h2 style="text-align:center"> Aucune vidéo </h2>`
                    }

                    somme += `</div>`

                    swal.close()

                    var htmlContent = document.getElementById("tabVideos");

                    htmlContent.innerHTML = somme

                    var idTitreListVideo = document.getElementById("idTitreListVideo")
                    idTitreListVideo.innerHTML = titreChapitre +" ( "+ idType +" )"

                    refereshVideos()

                },
                error: function() {

                    $('.modal-message').html("Sorry, File not Uploaded");
                    $('#modal-confirm-all').modal('show');
                }

            });

            return false;
        }

        function open_add_video() {
            document.getElementById("titreAddVideoModal").innerHTML = "<?php echo $this->lang->line('add_video'); ?>"
            document.getElementById("IDVideoForm").value = -1
        }

        function open_edit_video(id) {
            var listVideos = JSON.parse(localStorage.getItem("listvideos"))

            for (let i = 0; i < listVideos.length; i++) {
                if (Number(listVideos[i]['id']) === Number(id)) {
                    document.getElementById("idTitreFormVideo").value = listVideos[i]['titre']
                    document.getElementById("idDescriptionFormVideo").value = listVideos[i]['description']
                    document.getElementById("pathVideoAdd2").value = listVideos[i]['path']
                    document.getElementById("pathVideoAdd").value = listVideos[i]['path']
                    document.getElementById("IDVideoForm").value = id
                }
            }

            document.getElementById("titreAddVideoModal").innerHTML = "<?php echo $this->lang->line('edit_video'); ?>"
        }

        function open_delete_video(id) {
            var listVideos = JSON.parse(localStorage.getItem("listvideos"))

            for (let i = 0; i < listVideos.length; i++) {
                if (Number(listVideos[i]['id']) === Number(id)) {
                    document.getElementById("idVideoSuppression").value = id
                }
            }
        }


        function openVideoPlainEcranNext() {
            var id = document.getElementById("titreDisplayVideoModal27").name
            var listVideos = JSON.parse(localStorage.getItem("listvideos"))

            for (let i = 0; i < listVideos.length; i++) {
                if (Number(listVideos[i]['id']) === Number(id)) {
                    if (i + 1 >= listVideos.length) {
                        open_video_plain_ecran(listVideos[0]['id'])
                        return
                    } else {
                        open_video_plain_ecran(listVideos[i + 1]['id'])
                        return
                    }
                }
            }
        }

        function openVideoPlainEcranPrevious() {
            var id = document.getElementById("titreDisplayVideoModal27").name
            var listVideos = JSON.parse(localStorage.getItem("listvideos"))

            for (let i = 0; i < listVideos.length; i++) {
                if (Number(listVideos[i]['id']) === Number(id)) {
                    if (i - 1 < 0) {
                        open_video_plain_ecran(listVideos[listVideos.length - 1]['id'])
                        return
                    } else {
                        open_video_plain_ecran(listVideos[i - 1]['id'])
                        return
                    }
                }
            }
        }

        function open_video_plain_ecran(id) {
            var listVideos = JSON.parse(localStorage.getItem("listvideos"))


            for (let i = 0; i < listVideos.length; i++) {
                if (Number(listVideos[i]['id']) === Number(id)) {

                    document.getElementById("titreDisplayVideoModal27").innerHTML = listVideos[i]['titre']
                    document.getElementById("titreDisplayVideoModal27").name = id

                    var contener = document.getElementById("divContainerVideoDisplay")
                    contener.innerHTML = `

                    <video width="320" height="240" controls autoplay>
                      <source src="<?php echo base_url(); ?>` + listVideos[i]['path'] + `" type="video/mp4">
                      Your browser does not support the video tag.
                    </video> `

                }
            }
        }




        function addEdit_video(id) {

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
                url: "<?php echo base_url(); ?>video/video2",
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
                                $('#addVideoModal').modal('hide');
                                var idChapitre = document.getElementById("IDChapitreVideo").value
                                var idType = document.getElementById("IDTypeVideo").value
                                var titreChapitre = document.getElementById("TitreChapitreVideo").value
                                chargeVideos(idChapitre, titreChapitre, idType)
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

            return false;
        }


    </script>

    <script type="text/javascript">
        function deleteVideo(id) {

            var data_plat = new FormData($("#deleteVideoModal")[0]);

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
                url: "<?php echo base_url(); ?>video/deleteVideo",
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

                    if (resu["id"] == 1) {
                        console.log("sucess");
                        Swal.fire({
                            title: resu["desc"],
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
                                $('#centeredModalPrimaryDeleteVideo').modal('hide');
                                var idChapitre = document.getElementById("IDChapitreVideo").value
                                var idType = document.getElementById("IDTypeVideo").value
                                var titreChapitre = document.getElementById("TitreChapitreVideo").value
                                chargeVideos(idChapitre, titreChapitre, idType)
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

                    $('.modal-message').html("Sorry, File not Uploaded");
                    $('#modal-confirm-all').modal('show');
                }

            });

            return false;
        }
    </script>

    <script language="JavaScript">
        window.onload = function() {
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function(e) {
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                    disabledEvent(e);
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                    disabledEvent(e);
                }
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    disabledEvent(e);
                }
                if (e.ctrlKey && e.keyCode == 85) {
                    disabledEvent(e);
                }
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

            // ===== INITIALISER TOUS LES INDICES RAPPEL =====
            checkAllRappels();
        }

        // ===== RAPPEL ANATOMIQUE MANUEL =====

        function checkAllRappels() {
            // Vérifier tous les chapitres pour voir s'il y a un rappel manuel
            const elements = document.querySelectorAll('[id^="type-rappel-"]');
            elements.forEach(el => {
                const match = el.id.match(/type-rappel-(\d+)/);
                if (match) {
                    const idChapitre = match[1];
                    checkRappelManuel(idChapitre);
                }
            });
        }

// ===== RAPPEL ANATOMIQUE MANUEL =====

function checkAndDisplayRappel(idChapitre, idChapterRappelDefaut, idLivre, idTheme, estAdmin, nbreCoursRappel = 0, nbreResumeRappel = 0) {
    console.log('checkAndDisplayRappel - Chapitre:', idChapitre, 'Défaut:', idChapterRappelDefaut, 'Livre:', idLivre, 'Theme:', idTheme, 'Admin:', estAdmin, 'CoursRappel:', nbreCoursRappel, 'ResumeRappel:', nbreResumeRappel);
    
    // Vérifier si c'est un thème pathologique
    const estPathologie = (idLivre && [20, 30, 31].includes(parseInt(idLivre))) || 
                          (idTheme && [20, 30, 31].includes(parseInt(idTheme)));
    
    $.ajax({
        url: "<?= base_url('home/check_rappel_manuel'); ?>",
        type: "POST",
        data: JSON.stringify({idChapitre: idChapitre}),
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
            console.log('Réponse check_rappel_manuel:', response);
            
            if (estPathologie) {
                const detailZone = $('#rappel-detail-zone-' + idChapitre);
                const resumeZone = $('#rappel-resume-zone-' + idChapitre);
                const baseUrl = "<?= base_url(); ?>";
                const siteLang = "<?= $this->lang->line('siteLang'); ?>";
                
                // --- 1. VERSION DÉTAILLÉE (ZONE GAUCHE) ---
                let detailHtml = '<div class="row align-items-center" style="width: 100%; margin: 0;">';
                detailHtml += '<div class="col-md-7" style="text-align: center; padding: 0;">';
                
                if (idChapterRappelDefaut && idChapterRappelDefaut !== '') {
                    // Redirection vers le résumé si existant, sinon figures (Lien demandé par l'utilisateur)
                    const targetUrlDet = (parseInt(nbreResumeRappel) > 0) 
                                      ? `${baseUrl}${siteLang}livreResume/${idChapterRappelDefaut}`
                                      : `${baseUrl}${siteLang}livreFigures/${idChapterRappelDefaut}`;
                    detailHtml += `
                        <a href="${targetUrlDet}" 
                           class="btn btn-outline-primary" 
                           style="border-color: #f8f9fa; color: #000000; font-size: 0.8rem; padding: 4px 8px; width: 90%;">
                           Vers. Détaillée
                        </a>`;
                } else if (response.exists && response.data.Fichier) {
                    // Fallback sur le rappel manuel si aucun chapitre lié n'existe
                    const htmlFile = response.data.Fichier.replace('.docx', '.HTML');
                    detailHtml += `
                        <a href="${baseUrl}PlatFormeConvert/${htmlFile}" 
                           target="_blank"
                           class="btn btn-outline-primary" 
                           style="border-color: #f8f9fa; color: #000000; font-size: 0.8rem; padding: 4px 8px; width: 90%;">
                           Vers. Détaillée
                        </a>`;
                } else {
                    // ✅ Rien à afficher si aucun rappel (lié ou manuel)
                    detailHtml += ''; 
                }
                detailHtml += '</div>';

                if (estAdmin) {
                    detailHtml += '<div class="col-md-5" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; padding: 0; justify-items: center;">';
                    detailHtml += `<a href="#" onclick="return false;"><i class="fas fa-key" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    // detailHtml += `<a href="#" onclick="return false;"><i class="far fa-images" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    detailHtml += `<a href="#" onclick="return false;"><i class="fas fa-edit" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    detailHtml += `<a href="#" onclick="event.preventDefault(); return false;"><i class="fa fa-play-circle" style="color: #3085d6; font-size: 0.8rem; cursor: pointer;"></i></a>`;
                    detailHtml += '</div>';
                }
                detailHtml += '</div>';
                detailZone.html(detailHtml);

                // --- 2. RÉSUMÉ RAPPEL (ZONE DROITE) ---
                let resumeHtml = '<div class="row align-items-center" style="width: 100%; margin: 0;">';
                resumeHtml += '<div class="col-md-7" style="text-align: center; padding: 0;">';
                
                if (idChapterRappelDefaut && idChapterRappelDefaut !== '') {
                    // ✅ PATCH : Redirige vers livreResume si nbreResume > 0, sinon livreFigures
                    const targetUrl = (parseInt(nbreResumeRappel) > 0) 
                                      ? `${baseUrl}${siteLang}livreResume/${idChapterRappelDefaut}`
                                      : `${baseUrl}${siteLang}livreFigures/${idChapterRappelDefaut}`;
                    resumeHtml += `
                        <a href="${targetUrl}" 
                           class="btn btn-outline-warning" 
                           style="border-color: #f8f9fa; color: #000000; font-size: 0.8rem; padding: 4px 8px; width: 90%;">
                           Résumé
                        </a>`;
                } else {
                    resumeHtml += `
                        <button class="btn btn-outline-secondary" disabled
                           style="border-color: #e5e7eb; color: #9ca3af; font-size: 0.8rem; padding: 4px 8px; width: 90%; cursor: not-allowed;">
                           Résumé
                        </button>`;
                }
                resumeHtml += '</div>';

                if (estAdmin) {
                    resumeHtml += '<div class="col-md-5" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; padding: 0; justify-items: center;">';
                    resumeHtml += `<a href="#" onclick="return false;"><i class="fas fa-key" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    // resumeHtml += `<a href="#" onclick="openAddImageRappelModal(${idChapitre}); return false;" title="Images"><i class="far fa-images" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    resumeHtml += `<a href="#" onclick="openAddRappelModal(${idChapitre}); return false;" title="Modifier"><i class="fas fa-edit" style="color: #3085d6; font-size: 0.8rem;"></i></a>`;
                    resumeHtml += `<a href="#" onclick="event.preventDefault(); return false;" title="Vidéos"><i class="fa fa-play-circle" style="color: #3085d6; font-size: 0.8rem; cursor: pointer;"></i></a>`;
                    resumeHtml += '</div>';
                }
                
                resumeHtml += '</div>';
                resumeZone.html(resumeHtml);

            } else {
                // ========== AFFICHAGE HORIZONTAL SIMPLE POUR AUTRES THÈMES ==========
                let html = '';
                const zoneID = '#rappel-zone-' + idChapitre;
                html += '<div style="display: flex; gap: 10px; height: 100%;">';
                
                // ========== SECTION 1 : RAPPEL MANUEL (Anatomie cours résumé) ==========
                // ✅ PATCH : Afficher "Version détaillée" dans tous les cas
                html += '<div style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">';
                html += '<div style="font-weight: bold; margin-bottom: 6px; font-size: 0.9rem;">Anatomie cours résumé</div>';
                
                // ✅ Toujours afficher "Version détaillée" (redirige vers le résumé du chapitre actuel)
                // La page affichera les figures même si le texte résumé est vide
                html += `
                    <a href="<?= base_url() . $this->lang->line('siteLang'); ?>livreResume/${idChapitre}" 
                       class="btn btn-outline-success btn-sm"
                       style="margin-bottom: 6px;">
                        <i class="fas fa-eye"></i> Version détaillée
                    </a>
                `;
                
                // ✅ Icônes d'administration (si admin)
                html += `
                    <?php if ($this->session->userdata('EstAdmin') == 1): ?>
                    <div style="margin-top: 6px;">
                        <a href="#" data-toggle="dropdown" title="Clés" style="margin-right: 8px;">
                            <i class="fas fa-key" style="color:#3085d6;"></i>
                        </a>
                        <a href="#" data-toggle="dropdown" title="Modifier résumé" style="margin-right: 8px;">
                            <i class="fa fa-edit" style="color:#3085d6;"></i>
                        </a>
                        <a href="#" data-toggle="dropdown" title="Figures" style="margin-right: 8px;">
                            <i class="fa fa-images" style="color:#3085d6;"></i>
                        </a>
                        <a href="#" data-toggle="modal" title="Vidéos">
                            <i class="fa fa-play-circle" style="color:#3085d6;"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                `;
                
                html += '</div>';
                
                // ========== SECTION 2 : RAPPEL ANATOMIQUE (Anatomie cours complet) ==========
                html += '<div style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">';
                html += '<div style="font-weight: bold; margin-bottom: 6px; font-size: 0.9rem;">Anatomie cours complet</div>';
                
                if (idChapterRappelDefaut && idChapterRappelDefaut !== '') {
                    html += `
                        <a href="<?= base_url() . $this->lang->line('siteLang'); ?>livreCours/${idChapterRappelDefaut}"
                           class="btn btn-outline-primary btn-sm">
                            Voir le cours complet
                        </a>
                    `;
                } else {
                    html += `
                        <span style="font-size: 0.85rem; color: #6c757d; font-style: italic;">
                            Non disponible
                        </span>
                    `;
                }
                html += '</div>';
                html += '</div>'; 
                $(zoneID).html(html);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX:', status, error, xhr.responseText);
            $('#rappel-detail-zone-' + idChapitre).html('<span style="color:red; font-size:0.6rem;">Erreur</span>');
            $('#rappel-resume-zone-' + idChapitre).html('<span style="color:red; font-size:0.6rem;">Erreur</span>');
        }
    });
}

function openAddRappelModal(idChapitre) {
    console.log('openAddRappelModal - Chapitre:', idChapitre);
    document.getElementById('rappelChapitre').value = idChapitre;
    document.getElementById('rappelFichier').value = '';
    $('#addRappelModal').modal('show');
}

// Les fonctions de gestion d'images ont été déplacées à la fin du fichier pour plus de clarté.

function saveRappelManuel() {
    const idChapitre = document.getElementById('rappelChapitre').value;
    const fichier = document.getElementById('rappelFichier').files[0];

    console.log('saveRappelManuel - ID:', idChapitre, 'Fichier:', fichier ? fichier.name : 'aucun');

    if (!fichier) {
        Swal.fire({
            title: 'Erreur',
            text: 'Veuillez sélectionner un fichier .docx',
            icon: 'error'
        });
        return;
    }

    if (!fichier.name.endsWith('.docx')) {
        Swal.fire({
            title: 'Erreur',
            text: 'Seuls les fichiers .docx sont acceptés',
            icon: 'error'
        });
        return;
    }

    const formData = new FormData();
    formData.append('rappelChapitre', idChapitre);
    formData.append('rappelFichier', fichier);

    Swal.fire({
        title: 'Enregistrement...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: "<?= base_url('home/add_rappel_manuel'); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log('Réponse brute:', response);
            
            try {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                console.log('Réponse parsée:', res);
                
if (res[0].id == '1') {
    $('#addRappelModal').modal('hide');
    
    Swal.fire({
        title: 'Succès',
        text: res[0].desc,
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        // âœ… Recharger toute la page pour mettre Ã  jour l'affichage
        location.reload();
    });
} else {
                    Swal.fire({
                        title: 'Erreur',
                        text: res[0].desc,
                        icon: 'error'
                    });
                }
            } catch (e) {
                console.error('Erreur parsing JSON:', e, response);
                Swal.fire({
                    title: 'Erreur serveur',
                    text: 'Réponse invalide du serveur',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX:', status, error, xhr.responseText);
            Swal.fire({
                title: 'Erreur',
                text: 'Erreur lors de l\'enregistrement: ' + error,
                icon: 'error'
            });
        }
    });
}

function deleteRappelManuel(idChapitre) {
    Swal.fire({
        title: 'Confirmation',
        text: 'Êtes-vous sûr de vouloir supprimer ce rappel anatomique manuel?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?= base_url('home/delete_rappel_manuel'); ?>",
                type: "POST",
                data: JSON.stringify({idChapitre: idChapitre}),
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    if (response.id == '1') {
                        Swal.fire({
                            title: 'Succès',
                            text: response.desc,
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            // Recharger l'affichage (retour au défaut)
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Erreur',
                            text: response.desc,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Erreur lors de la suppression: ' + error,
                        icon: 'error'
                    });
                }
            });
        }
    });
    return false;
}
    </script>
    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

        <script type="text/javascript">
            var pElemsErvc = document.getElementsByName("tokenfield[]");
            for (var i = 0; i < pElemsErvc.length; i++) {
                var idCurs = pElemsErvc[i].id;
                $('#' + idCurs).tokenfield({
                    autocomplete: {
                        source: [''],
                        delay: 100
                    },
                    showAutocompleteOnFocus: true
                })
            }

            function suppAllFiguRSM(idC) {
                var tit = document.getElementById('FigSR_' + idC).title;
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('figur'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textAllFig'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppAllFiguRSM",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppAllFigu(idC) {
                var tit = document.getElementById('FigS_' + idC).title;
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('figur'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textAllFig'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppAllFigu",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppQROC(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('qroc'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textCRQ'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppQROC",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppQROC_Fig_Ass(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('qroc'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textCRQ'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppQROC_Fig_Ass",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppQCM_Fig_Ass(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('qcm'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textQC'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppQCM_Fig_Ass",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppQCM(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('qcm'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textQC'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppQCM",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppCurs(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('cours'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textCRS'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppCurs",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppResum(idC) {
                var tit = document.getElementById(idC).name
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?> ' + '<?php echo $this->lang->line('resume'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textRSM'); ?>',
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
                            url: "<?php echo base_url(); ?>home/suppResum",
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

                                $('.modal-message').html("Sorry, File not Uploaded");
                                $('#modal-confirm-all').modal('show');
                            }

                        });

                    }
                })
                return false;
            }

            function suppCh(idC) {
                var elem = document.getElementById(idC);
                var tit = elem ? elem.getAttribute('name') : 'ce chapitre';
                
                Swal.fire({
                    title: '<?php echo $this->lang->line('supp_title'); ?>' + ' <br> ' + tit,
                    text: '<?php echo $this->lang->line('supp_textC'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.value || result.isConfirmed) {

                        Swal.fire({
                            title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>home/suppCh",
                            data: {
                                idC: idC
                            },
                            success: function(html) {
                                try {
                                    var resu = typeof html === 'string' ? JSON.parse(html) : html;
                                    if (resu[0]["id"] == 1) {
                                        Swal.fire({
                                            title: resu[0]["desc"] || 'Supprimé avec succès',
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Erreur',
                                            text: resu[0]["desc"]
                                        });
                                    }
                                } catch (e) {
                                    console.error('Erreur parsing JSON:', e, html);
                                    Swal.fire({ icon: 'error', title: 'Erreur', text: 'Réponse serveur invalide' });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: 'Erreur lors de la suppression'
                                });
                            }
                        });
                    }
                })
                return false;
            }
       function suppSousChap(idS) {
    var elem = document.getElementById(idS);
    var tit = elem ? elem.getAttribute('name') : 'cet élément';
    
    Swal.fire({
        title: '<?php echo $this->lang->line('supp_title'); ?>' + ' <br> ' + tit,
        text: '<?php echo $this->lang->line('supp_textC'); ?>',
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
            });

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/suppSousChap",
                data: {
                    idS: idS
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
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: resu[0]["desc"],
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Erreur lors de la suppression',
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
            });
        }
    });
    
    return false;
}

function editSousChap(idEncoded) {
    console.log('Édition:', idEncoded);
    // À implémenter
}



            function set_ChapBack() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/set_ChapBack",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 3000000,
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_Curs() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Curs",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {

                        var resu = JSON.parse(html);

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


                    },
                    error: function() {

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_Resum() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Resum",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {

                        var resu = JSON.parse(html);

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


                    },
                    error: function() {

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_SubChapCurs(idSousChap) {
                const fileInput = document.getElementById(`mFile_${idSousChap}`);

                if (!fileInput || !fileInput.files.length) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Aucun fichier sélectionné',
                        text: 'Veuillez choisir un fichier .docx avant de continuer.'
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('mFile[]', fileInput.files[0]);
                formData.append('attach_file[]', idSousChap);

                Swal.fire({
                    title: 'Veuillez patienter...',
                    html: 'Upload et conversion du fichier en cours...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "<?= base_url('home/upload_Attach_Save_SubChap'); ?>", 
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        try {
                            const res = JSON.parse(response);

                            if (res[0]?.id == '1') {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Fichier attaché avec succès',
                                    text: 'Le fichier du sous-chapitre a été converti et enregistré.',
                                    confirmButtonText: 'OK'
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Erreur',
                                    text: res[0]?.desc || 'Une erreur est survenue.'
                                });
                            }
                        } catch (e) {
                            console.error('Erreur JSON:', e, response);
                            Swal.fire({
                                type: 'error',
                                title: 'Erreur serveur',
                                text: 'Réponse du serveur invalide.'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur AJAX:', error);
                        Swal.fire({
                            type: 'error',
                            title: 'Erreur lors de lâ€™envoi du fichier',
                            text: 'Veuillez réessayer plus tard.'
                        });
                    }
                });
            }


            function set_SubChapResume(idSousChap) {
                const fileInput = document.getElementById(`mFileResume_${idSousChap}`);

                if (!fileInput || !fileInput.files.length) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Aucun fichier sélectionné',
                        text: 'Veuillez choisir un fichier .docx avant de continuer.'
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('mFile[]', fileInput.files[0]);
                formData.append('attach_file[]', idSousChap);
                formData.append('file_type', 'resume'); // Marquer comme résumé

                Swal.fire({
                    title: 'Veuillez patienter...',
                    html: 'Upload et conversion du fichier résumé en cours...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "<?= base_url('home/upload_Attach_Save_SubChap'); ?>", 
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        try {
                            const res = JSON.parse(response);

                            if (res[0]?.id == '1') {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Résumé attaché avec succès',
                                    text: 'Le fichier résumé a été converti et enregistré.',
                                    confirmButtonText: 'OK'
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Erreur',
                                    text: res[0]?.desc || 'Une erreur est survenue.'
                                });
                            }
                        } catch (e) {
                            console.error('Erreur JSON:', e, response);
                            Swal.fire({
                                type: 'error',
                                title: 'Erreur serveur',
                                text: 'Réponse du serveur invalide.'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur AJAX:', error);
                        Swal.fire({
                            type: 'error',
                            title: "Erreur lors de l'envoi du fichier",
                            text: 'Veuillez réessayer plus tard.'
                        });
                    }
                });
            }

            function set_FigResum() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_FigResum",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_Fig() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Fig",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_QCM_Fig_Ass() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QCM_Fig_Ass",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_QCM() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QCM",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_QROC() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QROC",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            function set_QROC_Fig_Ass() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QROC_Fig_Ass",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

          function set_LivChap(bookID) {
    var form = $('#pageForm_SetChap_' + bookID)[0]; 
    var data_plat = new FormData(form);

    var chapitreAssocieField = form.chapitreAssocie;
    if (chapitreAssocieField && !chapitreAssocieField.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Sélection obligatoire',
            text: 'Veuillez choisir un chapitre associé avant de continuer.'
        });
        return false; 
    }

    Swal.fire({
        title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });

    $.ajax({
        type: "POST",
        url: "<?= base_url('home/set_LivChap'); ?>",
        data: data_plat,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000000,
        success: function(html) {
            console.log(html); 
            try {
                var resu = JSON.parse(html);
            } catch(e) {
                console.error("Erreur JSON :", e, html);
                Swal.fire({
                    title: 'Erreur serveur',
                    text: 'Impossible de traiter la réponse',
                    icon: 'error'
                });
                return;
            }

            if (resu[0]["id"] == 1) {
                $('#modalChap_' + bookID).modal('hide');
                Swal.fire({
                    title: resu[0]["desc"],
                    icon: 'success',
                    text: 'Chapitre(s) ajoutés avec succès',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: resu[0]["desc"],
                    timer: 4000
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Erreur lors de lâ€™envoi du formulaire',
            });
        }
    });

    return false;
}

function set_LivSousChap(bookID) {
    var form = $('#pageForm_SetChap_' + bookID)[0];
    var data_plat = new FormData(form);

    Swal.fire({
        title: 'Veuillez patienter ...<br>Envoi des données en cours...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        type: "POST",
        url: "<?= base_url('home/set_LivSousChap'); ?>", 
        data: data_plat,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000000,
        success: function (html) {
            console.log("Réponse serveur :", html);

            let resu;
            try {
                resu = JSON.parse(html);
            } catch (e) {
                console.error("Erreur de parsing JSON :", e, html);
                Swal.fire({
                    title: 'Erreur serveur',
                    text: 'Impossible de traiter la réponse',
                    icon: 'error'
                });
                return;
            }

            if (resu[0]["id"] == 1) {
                $('#modalChap_' + bookID).modal('hide');
                Swal.fire({
                    title: resu[0]["desc"],
                    icon: 'success',
                    text: 'Sous-chapitres ajoutés avec succès',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: resu[0]["desc"],
                    timer: 4000
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Erreur AJAX :", status, error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur lors de lâ€™envoi du formulaire',
            });
        }
    });

    return false;
}

 function getSousChapitres(idChap) {
    Swal.fire({
        title: 'Veuillez patienter ...<br> Chargement des sous-chapitres en cours ...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>home/get_SousChapitres",
        data: JSON.stringify({ idChap: idChap }),
        contentType: "application/json; charset=UTF-8",
        timeout: 10000,
        success: function(html) {
            console.log("Réponse serveur :", html);
            let resu;
            try {
                resu = JSON.parse(html);
            } catch (e) {
                console.error("Erreur de parsing JSON :", e, html);
                Swal.fire({
                    title: 'Erreur serveur',
                    text: 'Impossible de traiter la réponse',
                    icon: 'error'
                });
                return;
            }

            if (resu.length > 0 && resu[0].id !== '0') {
                let sousChapHTML = '<ul>';
                resu.forEach(sousChap => {
                    sousChapHTML += `<li>${sousChap.TitreSousChapitre || 'Sous-chapitre sans titre'}</li>`;
                });
                sousChapHTML += '</ul>';
                $('.souschap-container').html(sousChapHTML);
                Swal.fire({
                    title: 'Sous-chapitres chargés avec succès',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: resu[0]?.desc || 'Aucun sous-chapitre trouvé',
                    timer: 4000
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Erreur AJAX :", status, error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur lors de la récupération des sous-chapitres',
                showConfirmButton: true
            });
        }
    });

    return false;
}

            function delChap(iTH, xx) {
                var elem = document.getElementsByClassName('row ' + xx);
                $("#" + iTH + '_' + xx).remove(); 
            }

            function set_KeysIndex(idChp, typeKeys) {
                var tit = '';
                switch (typeKeys) {
                    case "curs":
                        tit = document.getElementById("tokenfieldCrs_" + idChp).value;
                        break;

                    case "resum":
                        tit = document.getElementById("tokenfieldRsm_" + idChp).value;
                        break;

                    case "qcm":
                        tit = document.getElementById("tokenfieldQcm_" + idChp).value;
                        break;

                    case "qroc":
                        tit = document.getElementById("tokenfieldQrc_" + idChp).value;
                        break;

                    default:
                        break;
                }

                Swal.fire({
                    title: 'Veuillez patienter ...<br> Envoi des index en cours .. ',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({

                    type: "POST",
                    url: "<?php echo base_url(); ?>home/set_KeysIndex",
                    data: {
                        idC: idChp,
                        tit: tit,
                        typeKeys: typeKeys
                    },
                    timeout: 300000,
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
            }

            $(document).ready(function()

            {
                var x = 0; 
                var list_maxField = 10; 

                $('.list_add_button').click(function() {
                    var idTh = $(this).val();
                    x++; 
                    var cmp = x + 1;
                    var list_fieldHTML = '<div style="margin-top: 0.5em" class="row ' + x + '" id=' + idTh + '_' + x + '><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="list[]" type="text" placeholder="Chapitre ' + cmp + '" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><button type="button" class="btn btn-danger list_remove_button" onclick="delChap(' + idTh + ',' + x + ')" value="' + idTh + '">-</button></div></div>'; //New input field html
                    $(".list_wrapper_" + idTh).append(list_fieldHTML);
                });

            });
        </script>
    <?php } ?>
    <?php if ((strlen($this->session->userdata('passTok')) == 200)) { ?>
        <script type="text/javascript">
            function set_testQcmChap() {

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
                    url: "<?php echo base_url(); ?>home/set_testQCMChap",
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
                            $('#modalChap').modal('hide');
                            Swal.fire({
                                title: "<?php echo $this->lang->line('testPopInfo'); ?>",
                                position: 'center',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<?php echo $this->lang->line('testPopBeg'); ?>',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>evaluatQCM/<?= base64_encode($OneBook[0]['IDLivre']); ?>/" + resu[0]["listIDS"] + "/" + resu[0]["typeImp"];
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

                return false;
            }

            function set_testQrocChap() {

                var data_plat = new FormData($('#pageForm_TestQROC')[0]);

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
                    url: "<?php echo base_url(); ?>home/set_testQROCChap",
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
                            $('#modalChap').modal('hide');
                            Swal.fire({
                                title: "<?php echo $this->lang->line('testPopInfo'); ?>",
                                position: 'center',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<?php echo $this->lang->line('testPopBeg'); ?>',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>evaluatQROC/<?= base64_encode($OneBook[0]['IDLivre']); ?>/" + resu[0]["listIDS"] + "/" + resu[0]["typeImp"];
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

                return false;
            }

            function set_CalqueFigure() {

                var data_plat = new FormData($('#pageForm_CalqueFigure')[0]);

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
                    url: "<?php echo base_url(); ?>home/set_testFigure",
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
                            $('#modalChap').modal('hide');
                            Swal.fire({
                                title: "<?php echo $this->lang->line('testPopInfo'); ?>",
                                position: 'center',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<?php echo $this->lang->line('testPopBeg'); ?>',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>evaluatCalque/" + resu[0]["listIDS"];
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


                return false;
            }

            function set_testFigure() {

                var data_plat = new FormData($('#pageForm_TestFigure')[0]);

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
                    url: "<?php echo base_url(); ?>home/set_testFigure",
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
                            $('#modalChap').modal('hide');
                            Swal.fire({
                                title: "<?php echo $this->lang->line('testPopInfo'); ?>",
                                position: 'center',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<?php echo $this->lang->line('testPopBeg'); ?>',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>evaluatTEST/" + resu[0]["listIDS"];
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


                return false;
            }

            function uploads_video_function(id) {

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
                    url: "<?php echo base_url(); ?>video/uploadsVideo",
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

                        $('.modal-message').html("Sorry, File not Uploaded");
                        $('#modal-confirm-all').modal('show');
                    }

                });

                return false;
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
                    url: "<?php echo base_url(); ?>video/getSubDirectoriesVideos",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {
                        swal.close()
                        var resu = JSON.parse(html);

                        if (resu["id"] == "1") {

                            var result = resu["search_results"]

                            var newItems = [{path:"uploads", items:result, name:"uploads", isFolder:true}]

                            localStorage.setItem("listvideosSelectionnee", JSON.stringify(newItems))

                            var inputPathRepartoire = document.getElementById("pathFolderVideo")
                            var pathRepartoire = "uploads"
                            if(inputPathRepartoire && inputPathRepartoire.value && inputPathRepartoire.value.length > 0){
                                pathRepartoire = inputPathRepartoire.value
                            }

                            if(refreshFolder){
                                setRepertoirVideoToHTML(newItems, pathRepartoire)
                                selecteRepertoirVideoToHTML(null, pathRepartoire)
                                var elements = document.getElementsByClassName("lien-repartoir")
                                selecteRepertoirVideoToHTML(elements[0], pathRepartoire)
                            }else{
                                var elements = document.getElementsByClassName("active-lien-repartoir")
                                selecteRepertoirVideoToHTML(elements[0], pathRepartoire)
                            }





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

                return false;

            }

            function selecteRepertoirVideoToHTML(e, path){
                var elements = document.getElementsByClassName("active-lien-repartoir")
                elements.forEach(x => {
                    x.classList.remove("active-lien-repartoir")
                })

                if(e && e.classList) e.classList.add("active-lien-repartoir")

                var items = JSON.parse(localStorage.getItem("listvideosSelectionnee"))
                var innerHTML = getVideosToHTMLParTranche(items, path)

                var inputFolder = document.getElementById("pathFolderVideo")
                if(inputFolder) inputFolder.value = path

                var contener = document.getElementById("bloc-repertoire-videos2")
                contener.innerHTML = innerHTML
                refereshVideos()
            }

            function selecteVideo(e){
                var elements = document.getElementsByClassName("card-video-active")
                elements.forEach(x => {
                    x.classList.remove("card-video-active")
                })

                if(e && e.classList) e.classList.add("card-video-active")

            }

            function valideSelectedVideo(){
                var elements = document.getElementsByClassName("card-video-active")
                elements.forEach(x => {
                    var input = document.getElementById("pathVideoAdd")
                    input.value = x.getAttribute('name')
                    var input2 = document.getElementById("pathVideoAdd2")
                    input2.value = x.getAttribute('name')
                    $('#selectVideoModal').modal('hide');
                    return
                })
            }

            function opencloseRepertoirVideoToHTML(e){
                if(e.parentElement.classList == "span-inline-block"){
                    e.parentElement.classList.add('desactive-sous-list')
                }else{
                    e.parentElement.classList.remove('desactive-sous-list')
                }
            }

            function setRepertoirVideoToHTML(directories, path){
                var contener = document.getElementById("bloc-repertoire-videos")
                contener.innerHTML = setRepertoirVideoToHTMLParTranche(directories, path)
            }

            function getVideosToHTMLParTranche(directories, path){
                var innerHTML = ``
                for (let i = 0; i < directories.length; i++) {
                    if(directories[i].isFolder && directories[i].path != path){
                        if(directories[i].items.length > 0){
                            innerHTML += getVideosToHTMLParTranche(directories[i].items, path)
                        }
                    }else if(directories[i].path == path){
                        var innerHTML = ``
                        var compteur = 0
                        for (let j = 0; j < directories[i].items.length; j++) {
                            if(!directories[i].items[j].isFolder){
                                compteur++
                                innerHTML += `
                             <div class="card-video" name="`+directories[i].items[j].path+`" onclick="selecteVideo(this)">
                                <video width="100%" height="auto" id="repartoir`+compteur+`" controls>
                                  <source src="<?php echo base_url(); ?>`+directories[i].items[j].path+`" type="video/mp4" >
                                  <!--<source src="movie.ogg" type="video/ogg">-->
                                Your browser does not support the video tag.
                                </video>
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

            function setRepertoirVideoToHTMLParTranche(directories, path){
                var innerHTML = `<ul>`
                for (let i = 0; i < directories.length; i++) {
                    if(directories[i].isFolder){
                        if(checkRepartoir(directories[i].items)){
                            innerHTML += `<li class="span-inline-block desactive-sous-list"> <button type="button" onclick="opencloseRepertoirVideoToHTML(this)"> <span class="active-icon"> + </span> <span class="desactive-icon"> - </span> </button> <span class="lien-repartoir" onclick="selecteRepertoirVideoToHTML(this,'`+ directories[i].path +`')">`+ directories[i].name +`</span>`+setRepertoirVideoToHTMLParTranche(directories[i].items, path) +`</li>`
                        }else{
                            innerHTML += `<li class="span-inline-block"> <span class="lien-repartoir" onclick="selecteRepertoirVideoToHTML(this,'`+ directories[i].path +`')">`+ directories[i].name +`</span> </li>`
                        }
                    }
                }
                innerHTML += `</ul>`
                return innerHTML
            }

            function refereshVideos(){
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

            function setPauseAllVideos(){
                setTimeout(() => {
                    $('video').each(function( index ) {
                        this.pause();
                    });
                }, "1 second");
            }

            $("#popupAdminListVideos").on('hide.bs.modal', function(){
                setPauseAllVideos()
            });

            $("#addVideoModal").on('show.bs.modal', function(){
                document.getElementById("idTitreFormVideo").value = ""
                document.getElementById("idDescriptionFormVideo").value = ""
                document.getElementById("pathVideoAdd2").value = ""
                setPauseAllVideos()
            });

            $("#addVideoModal").on('hide.bs.modal', function(){
                setPauseAllVideos()
            });

            $("#selectVideoModal").on('show.bs.modal', function(){
                setPauseAllVideos()
            });

            $("#selectVideoModal").on('hide.bs.modal', function(){
                setPauseAllVideos()
            });

            $("#centeredModalPrimaryDeleteVideo").on('show.bs.modal', function(){
                setPauseAllVideos()
            });



        </script>
    <?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>


<!-- Modal de sélection des chapitres pour le Test -->
<div class="modal fade" id="centeredModalPrimaryTestFigure" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-family: Georgia, serif;"><?php echo $this->lang->line('testChoicCurs'); ?></h3>
            </div>
            <div class="card-body">
                <form name="pageForm_TestFigure" id="pageForm_TestFigure" action="">
                    <input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">
                    <div class="row">
                        <table class="table table-striped">
                            <tbody id="serChapTest">
                                <?php foreach ($listChap as $val_test): ?>
                                    <?php if ($val_test['NbreTest'] > 0): ?>
                                        <tr>
                                            <td style="text-align: left;">
                                                <div class="col-md-12" style="font-size: 0.97rem;">
                                                    <label class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print $val_test['IDChapitre']; ?>">
                                                        <span class="form-check-label"><?= $val_test['TitreChapitre']; ?></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('testClose'); ?></button>
                <button type="button" class="btn btn-primary" onclick="set_testFigure()"><?php echo $this->lang->line('testBegin'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
// ========== FONCTIONS GESTION IMAGES RAPPEL ANATOMIQUE ==========

function openAddImageRappelModal(idChapitre) {
    document.getElementById('rappelChapitreImage').value = idChapitre;
    const rappelImageInput = document.getElementById('rappelImage');
    if (rappelImageInput) {
        rappelImageInput.value = '';
    }
    document.getElementById('previewRappelImage').style.display = 'none';
    loadRappelImages(idChapitre);
    $('#addImageRappelModal').modal('show');
}

function loadRappelImages(idChapitre) {
    const baseUrl = "<?php echo base_url(); ?>";
    
    fetch(`${baseUrl}home/getRappelImages`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapter: idChapitre })
    })
    .then(r => r.json())
    .then(data => {
        const container = document.getElementById('imagesContainer');
        
        if (data.success && data.data.length > 0) {
            let html = '';
            data.data.forEach(img => {
                html += `
                    <div style="position: relative; width: 120px; background: rgba(0,0,0,0.1); padding: 5px; border-radius: 5px;">
                        <img src="data:image/jpeg;base64,${img.ImageData}" 
                             style="width: 100%; height: 100px; object-fit: cover; border-radius: 5px;">
                        <button type="button" 
                                onclick="deleteRappelImageItem(${img.IDImageRappel}, ${idChapitre})"
                                style="position: absolute; top: 0px; right: 0px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 16px; line-height: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            &times;
                        </button>
                        <p style="color: white; font-size: 10px; margin-top: 5px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0;" title="${img.NomImage}">${img.NomImage}</p>
                    </div>
                `;
            });
            container.innerHTML = html;
        } else {
            container.innerHTML = '<p style="color: white; font-style: italic; font-size: 13px;">Aucune image pour ce chapitre</p>';
        }
    })
    .catch(err => {
        console.error('Erreur chargement images:', err);
    });
}

// Fonction pour charger et afficher les images inline dans la section résumé
function loadRappelImagesInline(idChapitre, containerElementId) {
    const baseUrl = "<?php echo base_url(); ?>";
    
    fetch(`${baseUrl}home/getRappelImages`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapter: idChapitre })
    })
    .then(r => r.json())
    .then(data => {
        const container = document.getElementById(containerElementId);
        if (!container) return;
        
        if (data.success && data.data.length > 0) {
            let html = '<div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">';
            data.data.forEach(img => {
                html += `
                    <div style="position: relative; width: 120px; background: rgba(0,0,0,0.05); padding: 5px; border-radius: 5px; border: 1px solid #e0e0e0;">
                        <img src="data:image/jpeg;base64,${img.ImageData}" 
                             style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px; cursor: pointer;"
                             onclick="window.open(this.src, '_blank')"
                             title="Cliquez pour agrandir">
                        <p style="color: #666; font-size: 10px; margin-top: 4px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0;" title="${img.NomImage}">${img.NomImage}</p>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<div style="font-size: 0.85rem; color: #999; font-style: italic; margin-top: 8px;">Aucune image disponible</div>';
        }
    })
    .catch(err => {
        console.error('Erreur chargement images:', err);
        const container = document.getElementById(containerElementId);
        if (container) {
            container.innerHTML = '<div style="font-size: 0.85rem; color: #d33; font-style: italic; margin-top: 8px;">Erreur lors du chargement des images</div>';
        }
    });
}

function previewImageRappel(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewRappelImage');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

function saveRappelImage() {
    const form = document.getElementById('formRappelImage');
    if(!form) return;
    const formData = new FormData(form);
    const idChapitreInput = document.getElementById('rappelChapitreImage');
    if(!idChapitreInput) return;
    const idChapitre = idChapitreInput.value;
    
    const fileInput = document.getElementById('rappelImage');
    if (!fileInput.files[0]) {
        Swal.fire({ icon: 'warning', title: 'Attention', text: 'Veuillez sélectionner une image' });
        return;
    }
    
    Swal.fire({
        title: 'Envoi en cours...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>home/saveRappelImage',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                const result = JSON.parse(response);
                if (result[0].id == '1') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: result[0].desc,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        loadRappelImages(idChapitre);
                        form.reset();
                        document.getElementById('previewRappelImage').style.display = 'none';
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Erreur', text: result[0].desc });
                }
            } catch(e) {
                Swal.fire({ icon: 'error', title: 'Erreur system', text: 'Réponse invalide' });
            }
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Erreur', text: 'Erreur lors de lenvoi' });
        }
    });
}

function deleteRappelImageItem(idImage, idChapitre) {
    Swal.fire({
        title: 'Supprimer cette image ?',
        text: 'Cette action est irréversible',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.value) {
            fetch('<?php echo base_url(); ?>home/deleteRappelImage', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idImage: idImage })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé',
                        text: data.message,
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        loadRappelImages(idChapitre);
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Erreur', text: data.message });
                }
            })
            .catch(err => {
                console.error('Erreur:', err);
                Swal.fire({ icon: 'error', title: 'Erreur', text: 'Erreur lors de la suppression' });
            });
        }
    });
}
</script>
<?php } 