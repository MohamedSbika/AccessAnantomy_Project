<?php if ((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

    <?php
    include('header.php');
    ?>

    <style>
        .table > tbody > tr > td{
            padding: 0.05rem;
        }
        hr{
            margin: 0.3rem 0;
        }
        #datatables-ajax_info{
            display: none;
        }
        #indc{
            font-size: 0.4em;
            color: green;
        }
    </style>

    <?php
    include('header_steppes.php');
    ?>
    <body data-theme="default" data-layout="boxed" data-sidebar="left"   >
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid">
                    <?php
                    include('header_nav.php');
                    ?>
                    <div class="row">
                        <table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" role="grid" aria-describedby="datatables-ajax_info">
                            <thead style="display: none">
                            <tr>
                                <th><?php echo $this->lang->line('question'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                </div>
            </main>

            <?php
            include('footer.php');
            ?>
        </div>
    </div>

    </body>

    </html>
    <script type="text/javascript" >

        var list_maxField = 10; //Input fields increment limitation
        var table_middleware_main ;
        $(document).ready(function () {

            table_middleware_main = $('#datatables-ajax').dataTable({

                "bLengthChange": false,
                "bFilter": false,
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 10000,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_QROC_listEdit",
                    "type": "POST",
                    "data": function(d){
                        d.typeQ 	= "QROC";
                        d.typeC 	= "<?php print $OneBook[0]['IDChapitre']; ?>";
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "sClass": "text-left",
                        "orderable": false,
                    },{"sClass": "text-center", "aTargets": [0]},
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo $this->lang->line('table_lang'); ?>.json"
                },
                "initComplete": function(settings, json) {
                    var ddd = document.getElementById("titleQ").innerHTML;
                    document.getElementById("titleQu").innerHTML = ddd;
                }

            });

            function refresh_table(){
                table_middleware_main.fnDraw();
            }

            //Once add button is clicked

        });

        function suppQ(idQ,idCh)
        {
            var tit = document.getElementById("quesNam_"+idQ).name
            Swal.fire({
                title: '<?php echo $this->lang->line('supp_title'); ?>'+' <br> '+tit,
                text: '',
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
                        url: "<?php echo base_url(); ?>home/suppQuestionQrc",
                        data: { idC: idQ , idCh: idCh} ,
                        timeout: 300000,
                        success: function(html) {

                            console.log(html);
                            var resu = JSON.parse(html);
                            console.log(resu);

                            if(resu[0]["id"]==1)
                            {
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
                                        table_middleware_main.fnDraw();
                                        //location.reload();
                                    }
                                })

                            }else{
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
        function upd_QuestionQroc(idQues)
        {
            var data_plat = new FormData($('#pageForm_UpQuestQcm_'+idQues)[0]);

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
                url: "<?php echo base_url(); ?>home/upd_QuestionQroc",
                data: data_plat ,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
                success: function(html) {

                    var resu = JSON.parse(html);
                    if(resu[0]["id"]==1)
                    {
                        $('#modal_'+idQues).modal('hide');
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
                                table_middleware_main.fnDraw();
                            }
                        })

                    }else{
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

<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>
