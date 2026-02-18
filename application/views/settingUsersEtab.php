
<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

    <?php
    include('adm_nav.php');
    ?>
    <style>
        thead input {
            width: 70rem;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>

    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <h5 class="card-title mb-0">Importer des internautes
                        <span class="btn btn-sm btn-info pull-right upload-to-subUsers"><i class="fa fa-user"></i></span>
                    </h5>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatables-reponsive" class="table table-striped dataTable no-footer dt-responsive nowrap"  role="grid" aria-describedby="datatables-reponsive_info" >												<thead>
                                            <thead>
                                            <tr>
                                                <th width="20%"><?php echo $this->lang->line('name'); ?></th>
                                                <th><?php echo $this->lang->line('lastname'); ?></th>
                                                <th><?php echo $this->lang->line('email'); ?></th>
                                                <th hidden="hidden"><?php echo $this->lang->line('adresse1'); ?></th>
                                                <th hidden="hidden"><?php echo $this->lang->line('country'); ?></th>
                                                <th hidden="hidden"><?php echo $this->lang->line('city'); ?></th>
                                                <th hidden="hidden"><?php echo $this->lang->line('zipcd'); ?></th>
                                                <th><?php echo $this->lang->line('etabliss'); ?></th>
                                                <th><?php echo $this->lang->line('actif'); ?></th>
                                                <th hidden="hidden"><?php echo $this->lang->line('bloquee'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($listUsers as $value) { ?>
                                                <tr role="row" class="odd">
                                                    <td><?=$value['Nom'];?></td>
                                                    <td><?=$value['Prenom'];?></td>
                                                    <td><?=$value['Email'];?></td>
                                                    <td hidden="hidden"><?=$value['Adresse1'];?></td>
                                                    <td hidden="hidden"><?=$value['Pays'];?></td>
                                                    <td hidden="hidden"><?=$value['Ville'];?></td>
                                                    <td hidden="hidden"><?=$value['CodePostal'];?></td>
                                                    <td><?=$value['Etablissement'];?></td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input  class="form-check-input" onclick="updateUS(<?=$value['users_ID'];?>);" type="checkbox" id="flexSwitchCheckDefault" <?php if($value['Bloque']==false) { ?> checked <?php }?> >
                                                        </div>
                                                    </td>
                                                    <td hidden="hidden"><?=$value['Bloque'];?></td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal modal-max modal-medium modal-upload-subUsers" id="modal-upload-subUsers" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-confirm-title">Access Anatomy - Upload des étudiants</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form name="formUploadSubst" id="formUploadSubst" action="">
                    <div class="modal-body">
                        Vous pouvez ajouter des étudiants par import <span style="text-decoration: underline;"> fichier Excel</span>&nbsp;(.xls ou .xlsx) .<br>
                        Le fichier doit&nbsp;<span style="text-decoration: underline; color: rgb(255, 0, 0);">obligatoirement</span>&nbsp;
                        contenir les colonnes suivantes&nbsp;
                        <span style="text-decoration: underline;">dans l'ordre indiqué <strong>avec entête</strong></span> : <br><br>
                        "<strong>Nom & prénom</strong>", "<strong>Email</strong>","<strong>Matricule</strong>","<strong>CIN</strong>"  <br><br>
                        <div class="alert alert-success order-addedSubst" style="display:none;">
                            <strong>Succès!</strong> Données importés..
                        </div>

                        <div class="alert alert-danger order-not-addedSubst" style="display:none;">
                            <strong>Désolé!</strong> <span class="order-error-textSubst"> Les étudiants n'ont pas été ajoutés.</span>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileUploadSubst" id="fileUploadSubst">
                                <label style="display: none" class="custom-file-label">Choisir un fichier</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-info btn-sm upload-submitUsers">Télécharger</a>
                        <a href="#" data-dismiss="modal" class="btn btn-info btn-sm">Fermer</a>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php
    include('footer.php');
    ?>
    </div>
    </div>


    </body>
    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#datatables-reponsive thead tr').clone(true).appendTo( '#datatables-reponsive thead' );
            $('#datatables-reponsive thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                if(i<8) {
                    $(this).html('<input type="text" placeholder="' + title + '" class="form-control" style="width: auto" />');
                    $('input', this).on('keyup change', function () {
                        if (table.column(i).search() !== this.value) {
                            table
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                }else{
                    //$(this).html('<input name="checkBoxActif" type="checkbox" placeholder="" class="form-check-input" />');
                    $(this).html('<select class="form-select" style="width: auto"><option value="">Tous</option><option value="0">Actif</option><option value="1">bloque</option></select>');
                    $('select', this).on('change', function () {
                        var bloq = $(this).children("option:selected").val()
                        table.columns(9).search(bloq).draw();
                    });

                }


            } );

            var table = $('#datatables-reponsive').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo $this->lang->line('table_lang'); ?>.json"
                }
            } );

            $(document).on("click", ".upload-to-subUsers", function () {

                $('#fileUploadSubst').val("");
                $('.order-addedSubst').hide();
                $('.order-not-addedSubst').hide();
                $('#modal-upload-subUsers').modal('show');

            });
            $('#fileUploadSubst').on('change',function(e){
                var fileName = e.target.files[0].name;
                $(this).next('.custom-file-label').html(fileName);
            });

            $(".upload-submitUsers").on("click", function(ev) {

                var file_val = $('#fileUploadSubst').val();

                $('.order-addedSubst').hide();
                $('.order-not-addedSubst').hide();

                if(file_val == ""){

                    $('.modal-message').html("Merci de sélectionner un fichier à importer.");    //Please select a file to upload.
                    $('#modal-confirm-all').modal('show');

                }else{

                    Swal.fire({
                        title: 'Traitement en cours ..',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    var form = new FormData($('#formUploadSubst')[0]);

                    $.ajax({

                        type: "POST",
                        url: "<?php echo base_url(); ?>home/upload_subUsers",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 30000000,
                        success: function(html) {

                            console.log(html);

                            var result = JSON.parse(html);
                            ht = result["error"];

                            if(ht == true)
                            {
                                $('.order-addedSubst').show();
                                $('.order-not-addedSubst').hide();
                                Swal.fire({
                                    position: 'center',
                                    type: 'success',
                                    title: 'fichier bien synchronisé .',
                                    showConfirmButton: false,
                                    timer: 4000
                                })

                            }else if(ht == "fl_1_type" || ht == "file_error" || ht == "file_empty") {

                                $('.order-addedSubst').hide();
                                $('.order-error-textSubst').html("Format de fichier accepté : xls ou xlsx");
                                $('.order-not-addedSubst').show();

                            }else{
                                $('.order-addedSubst').hide();
                                $('.order-error-textSubst').html("Format de fichier accepté : xls ou xlsx");
                                $('.order-not-addedSubst').show();
                            }

                            $('#fileUploadSubst').val("");

                        },
                        error: function() {
                            // SHOW AN ERROR { if php failed to fetch }
                        }

                    });
                }


            });

        } );



        function  updateUS(ids='0'){

            Swal.fire({
                title: "<?php echo $this->lang->line('majuser'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setActifUser",
                data: { idUS: ids},
                timeout: 3000,
                success: function(html) {

                    console.log(html);

                    var ar =  JSON.parse(html);

                    if(ar[0]["id"]==1)
                    {
                        Swal.close();
                    }else {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: ar[0]["desc"],
                            showConfirmButton: true
                        })
                    }
                    //$('#setNAVSTEPPS').load(" #setNAVSTEPPS > *");
                },
                error: function() {
                    Swal.close();
                    // SHOW AN ERROR { if php failed to fetch }
                    $("#user_message_error").show();
                    Swal.hideLoading();
                    $('#centeredModalPrimary').modal('hide');
                }


            });


        }

    </script>
    </html>
<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>
