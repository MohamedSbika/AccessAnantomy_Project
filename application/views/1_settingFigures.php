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
    </script>

    </html>
<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>