
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

                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <div class="row">
                                    <div class="col-sm-12">

                                        <table id="datatables-reponsive" class="table table-striped dataTable no-footer dt-responsive nowrap"  role="grid" aria-describedby="datatables-reponsive_info" >												<thead>
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
    </main>

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



        } );



        function  updateUS(ids='0'){

            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
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
