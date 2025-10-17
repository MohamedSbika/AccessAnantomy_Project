<?php if ((strlen($this->session->userdata('passTok')) == 200) && ($this->session->userdata('EstAdmin') == 1)) { ?>

    <?php
    include('adm_nav.php');
    ?>
    <style>
        thead input {
            width: 100%;
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

                                        <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryADDFigure">
                                            <i class="fa fa-plus" style="float:right; font-size:15px; margin-top:15px;"></i>
                                        </a>

                                        <table class="table table-striped" style="width: 70%; align-self: center;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">#ID</th>
                                                    <th style="text-align: left;">FR Titre</th>
                                                    <th style="text-align: left;">EN Titre</th>
                                                    <th style="text-align: left;"><?php echo $this->lang->line('paramsAction'); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody id="serChap">
                                                <form name="pageForm_Chap" id="pageForm_Chap" action="">
                                                    <?php foreach ($listActualites as $value) { ?>
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                <?= $value['id']; ?>
                                                            </td>
                                                            <td style="text-align: left;">
                                                                <?= $value['FR_title']; ?>
                                                            </td>
                                                            <td style="text-align: left;">
                                                                <?= $value['EN_title']; ?>
                                                            </td>
                                                            <td style="text-align: left;">
                                                                <div class="dropdown" style="">
                                                                    <a href="#" class="" title="Modifier" data-toggle="modal" data-target="#centeredModalPrimaryUpdateFigure<?= $value['id']; ?>">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle">
                                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                        </svg>
                                                                    </a>
                                                                    <a href="#" class="" title="Supprimer" data-toggle="modal" data-target="#centeredModalPrimaryDeleteFigure<?= $value['id']; ?>">
                                                                        <i class="fa fa-trash" style="font-size:15px; margin-top:15px;"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </form>
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

    <?php
    include('actualitesmodals.php');
    ?>

    </div>
    </div>

    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    
    </script>

    </html>
<?php } else { ?>

    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>

<?php } ?>