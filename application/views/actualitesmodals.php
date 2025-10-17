<?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

   
    <style>
        thead input {
            width: 100%;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>


    <div class="modal fade" id="centeredModalPrimaryADDFigure" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
            <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                <div class="modal-header">
                    <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('actionAjout'); ?> Actualite</h2>
                    <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                </div>
                <div class="modal-body m-3">
                    <form id="addActualite" name="addActualite" method="POST">

                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <label class="form-label label-modal-login">Titre_FR</label>
                                        <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="FR_title" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <label class="form-label label-modal-login">Titre_EN</label>
                                        <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="EN_title" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary button-modal-login" onclick="add_Actualite()"><?php echo $this->lang->line('actionAjout'); ?> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php foreach ($listActualites as $value) { ?>

        <div class="modal fade" id="centeredModalPrimaryUpdateFigure<?= $value['id']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">
                <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
                    <div class="modal-header">
                        <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('actionEdit'); ?> Actualite </h2>
                        <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="updateFigure<?= $value['id']; ?>" name="addFigure" method="POST">

                            <div class="col-sm-12">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label label-modal-login">Titre_FR</label>
                                            <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="FR_title" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= $value['FR_title']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label label-modal-login">Titre_EN</label>
                                            <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="EN_title" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= $value['EN_title']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id" value="<?= $value['id']; ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary button-modal-login" onclick="update_Actualite('updateFigure<?= $value['id']; ?>')"><?php echo $this->lang->line('validerModification'); ?> </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>


    <?php foreach ($listActualites as $value) { ?>

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
                                    <input type="hidden" name="id" id="id" value="<?= $value['id']; ?>">

                                </div>
                            </div>

                            <label class="form-label label-modal-login"> <?php echo $this->lang->line('messageSupprission'); ?>
                            </label>




                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-danger button-modal-login" onclick="delete_Actualite('deleteFigure<?= $value['id']; ?>')"><?php echo $this->lang->line('supp_title'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>





    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

        });


        //add Figure
        function add_Actualite() {

            var data_plat = new FormData($('#addActualite')[0]);

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
                url: "<?php echo base_url(); ?>home/add_Actualite",
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


        function update_Actualite(idFormulaire) {

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
                url: "<?php echo base_url(); ?>home/update_Actualite",
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


        //delete figure

        function delete_Actualite(idFormulaire) {

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
                url: "<?php echo base_url(); ?>home/delete_Actualite",
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

    </script>

    </html>
<?php } else { ?>


<?php } ?>