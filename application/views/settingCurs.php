<?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

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
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <div class="row">
                                    <div class="col-sm-12">

                                        <table id="datatables-reponsive" class="table table-striped dataTable no-footer dt-responsive nowrap" role="grid" aria-describedby="datatables-reponsive_info">
                                            <thead>
                                                <tr>
                                                    <th>Libelle</th>
                                                    <th>Ordre</th>
                                                    <th>Menu</th>
                                                    <th>Accueil</th>
                                                    <th>Est un livre</th>
                                                    <th style="text-align: left;"><?php echo $this->lang->line('resume'); ?></th>
                                                    <th style="text-align: left;"><?php echo $this->lang->line('testQCM'); ?></th>
                                                    <th style="text-align: left;"><?php echo $this->lang->line('testQROC'); ?></th>
                                                    <th style="text-align: left;"><?php echo $this->lang->line('Calques'); ?></th>
                                                    <th style="text-align: left;">Test</th>

                                                    <th hidden="hidden"><?php echo $this->lang->line('bloquee'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listCat as $value) { ?>
                                                    <tr role="row" class="odd">
                                                        <td><?= $value['Cats']['Libelle']; ?></td>
                                                        <td>
                                                            <?php if ($value['Cats']['OrdreCat'] == -1) { ?>
                                                                <?= $value['Cats']['OrdreCat']; ?>
                                                            <?php  } else {  ?>
                                                                <select class="form-select" style="width: auto" onchange="updatOrdCat(this,<?= $value['Cats']['IDCategory']; ?>)">
                                                                    <?php $comp = 1;
                                                                    foreach ($listCat as $key => $p) { ?>
                                                                        <option value="<?= $comp; ?>" <?php if ($comp == $value['Cats']['OrdreCat']) { ?>selected <?php } ?>><?= $comp; ?></option>
                                                                    <?php $comp++;
                                                                    } ?>
                                                                </select>
                                                            <?php  } ?>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatMenu(<?= $value['Cats']['IDCategory']; ?>);" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifMenu'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAcc(<?= $value['Cats']['IDCategory']; ?>);" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifAccueil'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($value['items'] as $valItem) { ?>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" onclick="updatUnLivre(<?= $valItem['items']['IDTheme']; ?>);" type="checkbox" id="flexSwitchCheckDefault" <?php if ($valItem['items']['EstUnLivre'] == true) { ?> checked <?php } ?>>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAccGlobal(<?= $value['Cats']['IDCategory']; ?>, 'EstActifResume');" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifResume'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAccGlobal(<?= $value['Cats']['IDCategory']; ?>, 'EstActifQSM');" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifQSM'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAccGlobal(<?= $value['Cats']['IDCategory']; ?>, 'EstActifQROC');" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifQROC'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAccGlobal(<?= $value['Cats']['IDCategory']; ?>, 'EstActifCalques');" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifCalques'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" onclick="updatAccGlobal(<?= $value['Cats']['IDCategory']; ?>, 'EstActifTest');" type="checkbox" id="flexSwitchCheckDefault" <?php if ($value['Cats']['EstActifTest'] == true) { ?> checked <?php } ?>>
                                                            </div>
                                                        </td>

                                                        <td hidden="hidden"><?= $value['Cats']['EstActifMenu']; ?></td>
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
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#datatables-reponsivee thead tr').clone(true).appendTo('#datatables-reponsive thead');
            $('#datatables-reponsivee thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                if (i < 2) {
                    $(this).html('<input type="text" placeholder="' + title + '" class="form-control" style="width: auto" />');
                    $('input', this).on('keyup change', function() {
                        if (table.column(i).search() !== this.value) {
                            table
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                } else {
                    //$(this).html('<input name="checkBoxActif" type="checkbox" placeholder="" class="form-check-input" />');
                    $(this).html('<select class="form-select" style="width: auto"><option value="">Tous</option><option value="0">Actif</option><option value="1">bloque</option></select>');
                    $('select', this).on('change', function() {
                        var bloq = $(this).children("option:selected").val()
                        //table.columns(5).search(bloq).draw();
                    });

                }


            });



            var table = $('#datatables-reponsive').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo $this->lang->line('table_lang'); ?>.json"
                }
            });



        });


        function updatOrdCat(elemn, ids = '0') {

            var numOrdC = $(elemn).find(":selected").val();
            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setOrderCat",
                data: {
                    idUS: ids,
                    numOrd: numOrdC
                },
                timeout: 3000,
                success: function(html) {

                    console.log(html);

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.close();
                    } else {
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

        function updatMenu(ids = '0') {

            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setActifMenu",
                data: {
                    idUS: ids
                },
                timeout: 3000,
                success: function(html) {

                    console.log(html);

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.close();
                    } else {
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

        function updatAcc(ids = '0') {

            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setActifAcc",
                data: {
                    idUS: ids
                },
                timeout: 3000,
                success: function(html) {

                    console.log(html);

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.close();
                    } else {
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

        function updatAccGlobal(ids = '0', champs = '') {

            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setActifAccGlobal",
                data: {
                    idUS: ids,
                    champs: champs,
                },
                timeout: 3000,
                success: function(html) {

                    console.log(html);

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.close();
                    } else {
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


        function updatUnLivre(ids = '0') {

            Swal.fire({
                title: "<?php echo $this->lang->line('majprog'); ?>",
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/setUnLvire",
                data: {
                    idUS: ids
                },
                timeout: 30000,
                success: function(html) {

                    console.log(html);

                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.close();
                    } else {
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
<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>