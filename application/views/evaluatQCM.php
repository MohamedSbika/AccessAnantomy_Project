<?php if(strlen($this->session->userdata('passTok'))==200) { ?>

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

    </style>

    <?php
    include('header_steppes.php');
    ?>

    <body data-theme="default" data-layout="boxed" data-sidebar="left"   oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" onmousedown="return false">

    <div class="wrapper">
        <div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" onmousedown="return false" ondragstart="return false">
            <main class="content">
                <div class="container-fluid">
                    <?php
                    include('header_nav.php');
                    ?>

                    <div class="row">

                        <input type="hidden" value="0" id="numrws">
                        <table id="datatables-ajax" class="table table-striped dataTable" style="width: 100%;" 	role="grid" aria-describedby="datatables-ajax_info">
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

        $(document).ready(function () {

            $("body").on("contextmenu",function(e){
                return false;
            });
            $('body').bind('cut copy', function (e) {
                e.preventDefault();
            });
            $('body').bind('cut copy', function (e) {
                e.preventDefault();
            });

            var table_middleware_main = $('#datatables-ajax').dataTable({

                "bLengthChange": false,
                "bFilter": false,
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 100,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                    null
                ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>home/ajax_QuestionTypeTest_list",
                    "type": "POST",
                    "data": function(d){
                        d.typeQ 	= "QCM";
                        d.typeC 	= "<?php print $OneBook[0]['IDLivre']; ?>";
                        d.listDIS 	= "<?php print $listDIS; ?>";
                        d.typeImp 	= "<?php print $typeImp; ?>";
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
                    var api = this.api();
                    var numRows = api.rows( ).count();

                    //var ddd = document.getElementById("titleQ").innerHTML;
                    document.getElementById("numrws").value = numRows;
                    beginTest();
                }

            });

            function refresh_table(){
                table_middleware_main.fnDraw();
            }

        });

        function myFunction(id=0) {

            // var elmsResp		= document.querySelector("[id='setKeyResp']");
            //elmsResp.style.visibility = 'visible';
            var kpp 		= "setKeyResp";//+id;
            var elmsResp	= document.querySelectorAll("[id='"+kpp+"']");
            for(var i = 0; i < elmsResp.length; i++)
            {
                elmsResp[i].style.visibility = 'visible';
            }

            var kks 		= "setInf";//+id;
            var elms 		= document.querySelectorAll("[id='"+kks+"']");
            for(var i = 0; i < elms.length; i++)
            {
                elms[i].style.color 		= 'green';
                elms[i].style.fontWeight 	= 'bold';
            }
            var kkD 	= "indCT";//+id;
            var elmCDT 	= document.querySelectorAll("[id='"+kkD+"']");
            for(var i = 0; i < elmCDT.length; i++)
            {elmCDT[i].style.visibility = 'visible';}

            var kks 	= "setValTEST";//+id;
            var reqst 	= '';
            var resp  	= '';
            var nbrQ  	= 0;
            var nbrQR  	= 0;
            var kksj 	= "quest_";//+id;
            var markedCheckboxj = document.querySelectorAll("[id='"+kksj+"']");
            for (var checkbox of markedCheckboxj) {

                nbrQ++ ;
                //alert("Question id "+checkbox.getAttribute('data-quest'));
                var ids = checkbox.getAttribute('data-quest');
                var kks = "setValTEST_"+ids;
                reqst	= '';
                resp  	= '';
                var markedCheckbox = document.querySelectorAll("[id='"+kks+"']");
                for (var checkboxxx of markedCheckbox) {

                    reqst = reqst+";"+checkboxxx.getAttribute('data-setTST');
                    resp  = resp+";"+checkboxxx.checked;
                }
                if(reqst != resp){nbrQ--;}
                //alert("Ligne id "+reqst+'<br>'+resp);
                nbrQR++;
            }

            Swal.fire({
                title				: '<?php echo $this->lang->line('testPopRslt'); ?>'+nbrQ+"/"+nbrQR,
                position			: 'center',
                type				: 'success',
                confirmButtonColor	: '#3085d6',
                cancelButtonColor	: '#d33',
                confirmButtonText	: '<?php echo $this->lang->line('testPopEnd'); ?>',
                allowOutsideClick	: false,
                allowEscapeKey		: false
            }).then((result) => {
                if (result.value) {
                    //window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= base64_encode($OneBook[0]['IDLivre']);?>";
                }
            })

        }
        function beginTest(){
            // Set the date we're counting down to

            var today 		= new Date();
            var tomorrow 	= new Date();

            var numrws = document.getElementById("numrws").value;
            tomorrow.setSeconds(today.getSeconds()+1);
            tomorrow.setMinutes(today.getMinutes()+Number(numrws));
            var countDownDate = tomorrow.getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days 	= Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours 	= Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="setMinut"
                document.getElementById("setMinut").innerHTML = minutes + "m " + seconds + "s ";

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("setMinut").innerHTML = "EXPIRED";
                    myFunction(0);
                }
            }, 1000);
        }

    </script>
    <script language="JavaScript">
        window.onload = function () {

            document.addEventListener("contextmenu", function (e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function (e) {
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
    <script>
        // When the user scrolls down 50px from the top of the document, resize the header's font size
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                document.getElementById("setMinut").style.fontSize = "1.3em";
            } else {
                document.getElementById("setMinut").style.fontSize = "1.3em";
            }
        }
    </script>


<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>
