
<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

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
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped" style="width: 70%; align-self: center;">
                                            <thead>
                                            <tr>
                                                <th style="text-align: left;">#ID</th>
                                                <th style="text-align: left;"><?php echo $this->lang->line('paramsLib'); ?></th>
                                                <th style="text-align: left;"><?php echo $this->lang->line('paramsVal'); ?></th>
                                                <th style="text-align: left;"><?php echo $this->lang->line('paramsAction'); ?></th>

                                            </tr>
                                            </thead>
                                            <tbody id="serChap">
                                            <form name="pageForm_Chap" id="pageForm_Chap" action="">
                                                <?php foreach ($listParams as $value) { ?>
                                                    <tr>
                                                        <td style="text-align: left;">
                                                            <?=$value['ID_Params'];?>
                                                        </td>
                                                        <td style="text-align: left;">
                                                            <?=$value['Libelle_Params'];?>
                                                        </td>
                                                        <td style="text-align: left;">
                                                            <?=$value['Value_Params'];?>
                                                        </td>
                                                        <td style="text-align: left;">
                                                            <div class="dropdown" style="">
                                                                <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="true" class="show">
                                                                    <i class="fa fa-pencil-alt"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <div class="row">
                                                                        <div class="col-md-12" style="padding-left: 1.4em;padding-right: 1.4em;">
                                                                            <input type="text" class="form-control my-3" name="setTitre<?=$value['ID_Params'];?>" id="setTitre<?=$value['ID_Params'];?>" value="<?=$value['Value_Params'];?>" >
                                                                            <input type="hidden" name="set_Id<?=$value['ID_Params'];?>" id="set_Id<?=$value['ID_Params'];?>" value="<?=$value['ID_Params'];?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="mt-2" style=" text-align: center;">
                                                                            <span class="btn btn-info" onclick="set_valParams('<?=$value['ID_Params'];?>')"><i class="fas fa-check"></i> Valider</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }?>
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
    </div>
    </div>

    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type='text/javascript'>

        $(document).ready(function () {

        });

        function set_valParams(idC=0) {

            var set_Id 		= document.getElementById("set_Id"+idC).value;
            var setTitre 	= document.getElementById("setTitre"+idC).value;

            Swal.fire({
                title: "<?php echo $this->lang->line('wait'); ?>",
                text: "<?php echo $this->lang->line('curSynchro'); ?>",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                onOpen: () => {
                    Swal.showLoading()
                }
            })

            $.ajax({

                type: "POST",
                url: "<?php echo base_url(); ?>home/set_valParams",
                data: { set_Id: set_Id ,setTitre: setTitre } ,
                timeout: 300000,
                success: function(html) {

                    console.log(html);
                    var ar =  JSON.parse(html);

                    if(ar[0]["id"]==1)
                    {
                        Swal.hideLoading();
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: "<?php echo $this->lang->line('synchroOK'); ?>",
                            showConfirmButton: false,
                            timer: 4000
                        }).then(function() {
                            location.reload();
                        })
                    }else{
                        alert(ar[0]["desc"]);
                    }
                },
                error: function() {
                    alert("Error when call webservice to get Platform . ") ;
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
