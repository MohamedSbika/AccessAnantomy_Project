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
            /* flex-grow: 1; */
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
    </style>


    <div class="modal fade" id="popupAdminListVideos" tabindex="-1" style="display: none; overflow:scroll !important;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 class="modal-title h2-modal-login"> <span id="idTitreListVideo"></span></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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

                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>

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
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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

    <div class="modal fade" id="selectVideoModal" tabindex="-1" style="display: none;" aria-hidden="true" style="z-index:5000;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 id="titreAddVideoModal" class="modal-title h2-modal-login"><?php echo $this->lang->line('select_video'); ?></h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
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
                                <div class="card-body" style=" display: flex;  justify-content: center;">

                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                        <form name="pageForm_SetChap" id="pageForm_SetChap" action="">
                                            <div class="row" style="flex: 1 0 0%;">
                                                <a href="#" data-toggle="modal" data-target="#modalChap">
                                                    <i class="fa fa-plus" title="<?php echo $this->lang->line('actionAjout'); ?>"></i>
                                                </a>
                                                <div class="modal fade" id="modalChap" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="h2 mb-1" style="font-family: Georgia, serif;font-size: 180%;"><?= $OneBook[0]['Titre']; ?></h3>
                                                                <input type="hidden" name="bookID" id="bookID" value="<?= $OneBook[0]['IDLivre']; ?>">
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="list_wrapper_<?= $OneBook[0]['IDLivre']; ?>">
                                                                    <div class="row">

                                                                        <div class="col-xs-7 col-sm-7 col-md-7">
                                                                            <div class="form-group">
                                                                                Chapitre 1
                                                                                <input name="list[]" type="text" placeholder="Titre de chapitre" class="form-control" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1 col-md-1">
                                                                            <br>
                                                                            <button class="btn btn-primary list_add_button" type="button" value="<?= $OneBook[0]['IDLivre']; ?>">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="set_LivChap()">Save changes</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>

                                    <table class="table table-striped" style="width: 70%; align-self: center;">
                                        <thead>
                                        <tr>
                                            <th style="text-align: left;"></th>
                                            <th width="15%"></th>
                                            <?php if ($category['EstActifResume'] == 1) { ?>
                                                <th width="15%"></th>
                                            <?php } ?>

                                            <?php if ($category['EstActifQSM'] == 1) { ?>
                                                <th width="15%">
                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) &&  ($resNBR[0]['QcmNBR'] > 0)) { ?>
                                                        <div class="row">
                                                            <div class="col-md-6" style="width: 100%;font-size: 0.97rem;">
                                                                <a href="#" data-toggle="modal" data-target="#modalTestQCM" class="btn btn-outline-primary mr-1" style="border-color: red;color: red;"><?php echo $this->lang->line('testQCM'); ?></a>
                                                            </div>
                                                            <div class="modal fade" id="modalTestQCM" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 style="font-family: Georgia, serif;"><?php echo $this->lang->line('testChoicCurs'); ?></h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div>
                                                                                <form name="pageForm_TestQCM" id="pageForm_TestQCM" action="">
                                                                                    <input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">
                                                                                    <div class="row">

                                                                                        <div>
                                                                                            <label class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="typeQCM" value="1" checked>
                                                                                                <span class="form-check-label"><?php echo $this->lang->line('testQcmPair'); ?></span>
                                                                                            </label>
                                                                                            <label class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="typeQCM" value="2">
                                                                                                <span class="form-check-label"><?php echo $this->lang->line('testQcmImpair'); ?></span>
                                                                                            </label>
                                                                                        </div>

                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <table class="table table-striped">
                                                                                            <thead>
                                                                                            <tr>

                                                                                            </tr>
                                                                                            </thead>
                                                                                            <?php foreach ($listChap as $value) { ?>
                                                                                                <?php if ($value['NbreQcm'] > 0) { ?>
                                                                                                    <tbody id="serChapTest">
                                                                                                    <tr>
                                                                                                        <td style="text-align: left;">
                                                                                                            <div class="col-md-8" style="font-size: 0.97rem;">
                                                                                                                <label class="form-check">
                                                                                                                    <input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print base64_encode($value['IDChapitre']); ?>">
                                                                                                                    <span class="form-check-label"><?= $value['TitreChapitre']; ?></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('testClose'); ?></button>
                                                                            <button type="button" class="btn btn-primary" onclick="set_testQcmChap()"><?php echo $this->lang->line('testBegin'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </th>

                                            <?php } ?>

                                            <?php if ($category['EstActifQROC'] == 1) { ?>

                                                <th width="15%">
                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) &&  ($resNBR[0]['QrocNBR'] > 0)) { ?>
                                                        <div class="row">
                                                            <div class="col-md-6" style="width: 100%;font-size: 0.97rem;">
                                                                <a href="#" data-toggle="modal" data-target="#modalTestQROC" class="btn btn-outline-primary mr-1" style="border-color: red;color: red;"><?php echo $this->lang->line('testQROC'); ?></a>
                                                            </div>
                                                            <div class="modal fade" id="modalTestQROC" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 style="font-family: Georgia, serif;"><?php echo $this->lang->line('testChoicCurs'); ?></h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div>
                                                                                <form name="pageForm_TestQROC" id="pageForm_TestQROC" action="">
                                                                                    <input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">
                                                                                    <div class="row">

                                                                                        <div>
                                                                                            <label class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="typeQCM" value="1" checked>
                                                                                                <span class="form-check-label"><?php echo $this->lang->line('testQrqPair'); ?></span>
                                                                                            </label>
                                                                                            <label class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="typeQCM" value="2">
                                                                                                <span class="form-check-label"><?php echo $this->lang->line('testQrqImpair'); ?></span>
                                                                                            </label>
                                                                                        </div>

                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <table class="table table-striped">
                                                                                            <thead>
                                                                                            <tr>

                                                                                            </tr>
                                                                                            </thead>
                                                                                            <?php foreach ($listChap as $value) { ?>
                                                                                                <?php if ($value['NbreQroc'] > 0) { ?>
                                                                                                    <tbody id="serChapTest">
                                                                                                    <tr>
                                                                                                        <td style="text-align: left;">
                                                                                                            <div class="col-md-8" style="font-size: 0.97rem;">
                                                                                                                <label class="form-check">
                                                                                                                    <input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print base64_encode($value['IDChapitre']); ?>">
                                                                                                                    <span class="form-check-label"><?= $value['TitreChapitre']; ?></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('testClose'); ?></button>
                                                                            <button type="button" class="btn btn-primary" onclick="set_testQrocChap()"><?php echo $this->lang->line('testBegin'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </th>

                                            <?php } ?>

                                            <?php if ($category['EstActifCalques'] == 1) { ?>

                                                <th>

                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) &&  ($resNBR[0]['test'] > 0)) { ?>
                                                        <div class="row">
                                                            <div class="col-md-6" style="width: 100%;font-size: 0.97rem;">
                                                                <a href="#" data-toggle="modal" data-target="#modalCalqueFigure" class="btn btn-outline-primary mr-1" style="border-color: red;color: red;"><?php echo $this->lang->line('Calques'); ?></a>
                                                            </div>
                                                            <div class="modal fade" id="modalCalqueFigure" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 style="font-family: Georgia, serif;"><?php echo $this->lang->line('testChoicCurs'); ?></h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div>
                                                                                <form name="pageForm_CalqueFigure" id="pageForm_CalqueFigure" action="">
                                                                                    <input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">

                                                                                    <div class="row">
                                                                                        <table class="table table-striped">
                                                                                            <thead>
                                                                                            <tr>

                                                                                            </tr>
                                                                                            </thead>

                                                                                            <?php foreach ($listChap as $value) { ?>
                                                                                                <?php if ($value['NbreTest'] > 0) { ?>
                                                                                                    <tbody id="serChapTest">
                                                                                                    <tr>
                                                                                                        <td style="text-align: left;">
                                                                                                            <div class="col-md-8" style="font-size: 0.97rem;">
                                                                                                                <label class="form-check">
                                                                                                                    <input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print $value['IDChapitre']; ?>">
                                                                                                                    <span class="form-check-label"><?= $value['TitreChapitre']; ?></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                <?php } ?>
                                                                                            <?php } ?>

                                                                                        </table>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('testClose'); ?></button>
                                                                            <button type="button" class="btn btn-primary" onclick="set_CalqueFigure()"><?php echo $this->lang->line('testBegin'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </th>

                                            <?php } ?>

                                            <?php if ($category['EstActifTest'] == 2) { ?>

                                                <th>

                                                    <?php if ((strlen($this->session->userdata('passTok')) == 200) &&  ($resNBR[0]['test'] > 0)) { ?>
                                                        <div class="row">
                                                            <div class="col-md-6" style="width: 100%;font-size: 0.97rem;">
                                                                <a href="#" data-toggle="modal" data-target="#modalTestFigure" class="btn btn-outline-primary mr-1" style="border-color: red;color: red;">Test</a>
                                                            </div>
                                                            <div class="modal fade" id="modalTestFigure" tabindex="<?= $OneBook[0]['IDLivre']; ?>" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 style="font-family: Georgia, serif;"><?php echo $this->lang->line('testChoicCurs'); ?></h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div>
                                                                                <form name="pageForm_TestFigure" id="pageForm_TestFigure" action="">
                                                                                    <input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">

                                                                                    <div class="row">
                                                                                        <table class="table table-striped">
                                                                                            <thead>
                                                                                            <tr>

                                                                                            </tr>
                                                                                            </thead>
                                                                                            <?php foreach ($listChap as $value) { ?>
                                                                                                <?php if ($value['NbreTest'] > 0) { ?>
                                                                                                    <tbody id="serChapTest">
                                                                                                    <tr>
                                                                                                        <td style="text-align: left;">
                                                                                                            <div class="col-md-8" style="font-size: 0.97rem;">
                                                                                                                <label class="form-check">
                                                                                                                    <input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print $value['IDChapitre']; ?>">
                                                                                                                    <span class="form-check-label"><?= $value['TitreChapitre']; ?></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('testClose'); ?></button>
                                                                            <button type="button" class="btn btn-primary" onclick="set_testFigure()"><?php echo $this->lang->line('testBegin'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </th>
                                            <?php } ?>

                                        </tr>
                                        </thead>
                                        <tbody id="serChap">
                                        <form name="pageForm_Chap" id="pageForm_Chap" action="">
                                            <?php foreach ($listChap as $value) { ?>
                                                <tr>

                                                    <td style="text-align: left;">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>
                                                                    <div class="dropdown " style="">
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                            </svg>
                                                                        </a>
                                                                        <a href="#" onclick="suppCh('<?php print base64_encode($value['IDChapitre']); ?> ')" name="<?php print str_replace("'", '&#39;', $value['TitreChapitre']); ?>" id="<?php print base64_encode($value['IDChapitre']); ?> ">
                                                                            <i class="fa fa-trash-alt" title="<?php echo $this->lang->line('actionSupp'); ?>"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                            <div class="row">
                                                                                <div class="col-md-12" style="padding-left: 1.4em;padding-right: 1.4em;">
                                                                                    <input type="text" class="form-control my-3" name="setTitreChap[]" id="setTitreChap">
                                                                                    <input type="hidden" name="set_IdCh[]" id="set_IdCh" value="<?php print $value['IDChapitre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="mt-2" style=" text-align: center;">
                                                                                    <span class="btn btn-info" onclick="set_ChapBack()"><i class="fas fa-check"></i> Valider</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-md-8" style="font-size: 0.97rem;">
                                                                <?= $value['TitreChapitre']; ?>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6" style="font-size: 0.97rem;">
                                                                <?php if ($value['NbreCours'] > 0) { ?>
                                                                    <a href="<?php echo base_url(); ?>
																		<?php echo $this->lang->line('siteLang'); ?>livreCours/<?= $value['IDChapitre']; ?>"
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
                                                                    <?php if ($value['NbreResume'] > 0) { ?> <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreResume/<?= $value['IDChapitre']; ?>" class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;"><?php echo $this->lang->line('resume'); ?></a> <?php } ?>
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
                                                                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                                <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                            </a>
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
                                                                           class="btn btn-outline-primary mr-1" style="border-color: #f8f9fa;color: #000000;"><?php echo $this->lang->line('qcm'); ?>
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
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a>

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
                                                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionFigure'); ?>">
                                                                            <i class="align-middle mr-2 far fa-fw fa-images"></i>
                                                                        </a>

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

                                                </tr>
                                            <?php } ?>
                                        </form>
                                        </tbody>
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



    </body>

    </html>

    <script language="JavaScript">
        //script for add test

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


        //add Figure
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
                    // SHOW AN ERROR { if php failed to fetch }

                    //$("#user_message_error_pretech").show();
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
                    // SHOW AN ERROR { if php failed to fetch }

                    //$("#user_message_error_pretech").show();
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




        //add Video
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
                                //window.location.reload()
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
                    // SHOW AN ERROR { if php failed to fetch }

                    //$("#user_message_error_pretech").show();
                    $('.modal-message').html("Sorry, File not Uploaded");
                    $('#modal-confirm-all').modal('show');
                }

            });

            return false;
        }


    </script>

    <script type="text/javascript">
        //add Video
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
                    // SHOW AN ERROR { if php failed to fetch }

                    //$("#user_message_error_pretech").show();
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

            function suppCh(idC) {
                var tit = document.getElementById(idC).name
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
                        })

                        $.ajax({

                            type: "POST",
                            url: "<?php echo base_url(); ?>home/suppCh",
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

            function set_ChapBack() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/set_ChapBack",
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

            function set_Curs() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Curs",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {

                        //console.log(html);
                        var resu = JSON.parse(html);
                        //console.log(resu);

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
                                //$('#serChap').load(" #serChap > *");
                                location.reload();
                            }
                        })


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

            function set_Resum() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Resum",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
                    success: function(html) {

                        //console.log(html);
                        var resu = JSON.parse(html);
                        //console.log(resu);

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
                                //$('#serChap').load(" #serChap > *");
                                location.reload();
                            }
                        })


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

            function set_FigResum() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_FigResum",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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
                                    //$('#serChap').load(" #serChap > *");
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

            function set_Fig() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_Fig",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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
                                    //$('#serChap').load(" #serChap > *");
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

            function set_QCM_Fig_Ass() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QCM_Fig_Ass",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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

            function set_QCM() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QCM",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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

            function set_QROC() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QROC",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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

            function set_QROC_Fig_Ass() {

                var data_plat = new FormData($('#pageForm_Chap')[0]);
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
                    url: "<?php echo base_url(); ?>home/upload_Attach_Save_QROC_Fig_Ass",
                    data: data_plat,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 30000000,
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

            function set_LivChap() {

                var data_plat = new FormData($('#pageForm_SetChap')[0]);

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
                    url: "<?php echo base_url(); ?>home/set_LivChap",
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

            function delChap(iTH, xx) {
                var elem = document.getElementsByClassName('row ' + xx);
                $("#" + iTH + '_' + xx).remove(); //Remove field html
                //x--; //Decrement field counter
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

                //console.log(data_plat);
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
                    var list_fieldHTML = '<div style="margin-top: 0.5em" class="row ' + x + '" id=' + idTh + '_' + x + '><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="list[]" type="text" placeholder="Chapitre ' + cmp + '" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><button type="button" class="btn btn-danger list_remove_button" onclick="delChap(' + idTh + ',' + x + ')" value="' + idTh + '">-</button></div></div>'; //New input field html
                    $(".list_wrapper_" + idTh).append(list_fieldHTML); //Add field html
                    //}
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
                        // SHOW AN ERROR { if php failed to fetch }

                        //$("#user_message_error_pretech").show();
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
                        // SHOW AN ERROR { if php failed to fetch }

                        //$("#user_message_error_pretech").show();
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
                        // SHOW AN ERROR { if php failed to fetch }

                        //$("#user_message_error_pretech").show();
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
                        // SHOW AN ERROR { if php failed to fetch }

                        //$("#user_message_error_pretech").show();
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
                        // SHOW AN ERROR { if php failed to fetch }

                        //$("#user_message_error_pretech").show();
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
                            // $('#modalChap').modal('hide');

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




                            // contener.innerHTML = setRepertoirVideoToHTML(result)

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
                    // console.log("item[0].name = ", result)
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
    <?php } ?>

<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>
