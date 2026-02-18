<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

<?php
include('header.php');
?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:900i');

    /**************SVG****************/

    path.one {
        transition: 0.4s;
        transform: translateX(-60%);

        animation: color_anim 1s infinite 0.4s;
    }

    path.two {
        transition: 0.5s;
        transform: translateX(-30%);
    }

    path.three {
        animation: color_anim 1s infinite 0.2s;
    }

    path.one {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.6s;
    }

    path.two {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.4s;
    }

    /* SVG animations */

    @keyframes color_anim {
        0% {
            fill: white;
        }
        50% {
            fill: #FBC638;
        }
        100% {
            fill: white;
        }
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

<body  oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" >

<?php
include('header_steppes.php');
?>

<div class="wrapper">

    <div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false"   ondragstart="return false" >
        <main class="content">
            <div class="container-fluid">
                <?php
                include('header_nav.php');
                ?>

                <div class="row" style="padding-top: 1em; padding-left:15px; padding-right:15px;">

                    <div class="col-12 col-lg-6 col-xl-3" id="setCouv">
                        <form name="pageForm_up" id="pageForm_up" action="">
                            <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                <div class="dropdown " style="padding-left: 1.5em">
                                    <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="file" name="mFile[]" id="mFile" readonly class="btn btn-info btn-sm" accept="image/png">
                                                <input type="hidden" name="attach_file[]" id="attach_file" value="<?php print $OneBook[0]['IDLivre']; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-2" style=" text-align: center;">
                                                <span class="btn btn-info" onclick="set_Couv()"><i class="fas fa-upload"></i> Upload (.PNG)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="card"  style="height: 100%;">
                                <div class="">
                                    <?php if($OneBook[0]["encryptCouverture"] =='') { ?>
                                        <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/NoPicture.png" alt="">
                                    <?php } else { ?>
                                        <img class="card-img-top"  src="data:image/png;base64,<?php print $OneBook[0]["encryptCouverture"]; ?> "></img>
                                    <?php }?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-lg-6 col-xl-6" id="serDesc">
                        <form name="pageForm_desc" id="pageForm_desc" action="">
                            <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                <div class="col-2" style="display: flex;justify-content: left;">
                                    <div class="dropdown " style="">
                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        </a>
                                        <div class="dropdown-menu">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="file" name="mFile[]" id="mFile" readonly class="btn btn-info btn-sm" accept=".docx" >
                                                    <input type="hidden" name="attach_file[]" id="attach_file" value="<?php print $OneBook[0]['IDLivre']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mt-2" style=" text-align: center;">
                                                    <span class="btn btn-info" onclick="set_Desc()"><i class="fas fa-upload"></i> Upload (.docx)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown" style=""  onclick="event.stopPropagation()" >
                                        <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                            <i class="align-middle me-2 fas fa-fw fa-key" title="<?php echo $this->lang->line('actionCle'); ?>"></i>
                                        </a>
                                        <div class="dropdown-menu" style="min-width: 25rem;">
                                            <input type="text" style="width: 100%" class="form-control" id="tokenfieldBook_<?php print $OneBook[0]['IDLivre']; ?>" name="tokenfield[]" value="<?php print $OneBook[0]['indexKeysBook']; ?>" />
                                            <div class="row">
                                                <div class="mt-2" style=" text-align: center;">
                                                    <span class="btn btn-info" onclick="set_KeysIndex('<?php print $OneBook[0]['IDLivre']; ?>','book')" > Valider</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <?php } ?>
                            <div class="col-12 col-lg-12 col-xl-12" id="cnxTok">

                            </div>
                            <div class="card" style="height: 100%;">

                                <?php if(strlen($this->session->userdata('passTok'))==200) { ?>
                                    <a id="showBK" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$OneBook[0]['IDLivre'];?>"  class="btn btn-primary btn-block" style="font-size: 1.4em;display: block;margin: auto;font-weight: bold;background-color: background-color:#8d93f7;">
                                        <?php echo $this->lang->line('showBook'); ?>
                                        <span>
      										<svg width="30px" height="20px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        										<g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          											<path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
													<path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          											<path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        										</g>
      										</svg>
    									</span>
                                    </a>
                                <?php }else{ ?>
                                    <button type="button"  class="btn btn-primary btn-block" style="background-color:#8d93f7;display: block;margin: auto; font-size: 1.4em;font-weight: bold;" data-toggle="modal" data-target="#centeredModalPrimary">
                                        <?php echo $this->lang->line('showBook'); ?>
                                        <span>
      										<svg width="30px" height="20px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        										<g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          											<path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
													<path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          											<path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        										</g>
      										</svg>
    									</span>
                                    </button>

                                <?php } ?>

                                <div class="card-body" style="padding: 0rem;">
                                    <div id="tasks-progress">
                                        <div class="card mb-3 bg-light cursor-grab border">
                                            <div class="card-body p-4" id="demo" style="background-color: white;overflow-y: scroll;height: 100vh;">
                                                <?php
                                                $html = $OneBook[0]["Description"];
                                                if(!empty($html)){
                                                    preg_match('/<div class=WordSection1>(.*?)<\/div>/s', $html, $match);
                                                    if(sizeof($match)>0){
                                                        echo $match[0];
                                                    }else{
                                                        preg_match('/<body>(.*?)<\/body>/s', $html, $match2);
                                                        if(sizeof($match2)>0){
                                                            echo $match2[0];
                                                        }else{echo $html;}

                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3" id="serVid">
                        <form name="pageForm_Vid" id="pageForm_Vid" action="">
                            <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                <div class="dropdown " style="padding-left: 1.5em">
                                    <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                        <i class="fas fa-plus" title="<?php echo $this->lang->line('actionAjout'); ?>"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">https://www.youtube.com/watch?v=</span>
                                                    <input type="text" class="form-control" name="newVid" placeholder="JiyWnjrFqhc">
                                                </div>
                                                <input type="hidden" name="attach_file" id="attach_file" value="<?php print $OneBook[0]['IDLivre']; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-2" style=" text-align: center;">
                                                <span class="btn btn-info" onclick="set_Vid()"><i class="fas fa-upload"></i> Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="card" style="height: 100%;">

                                <div class="card-body">
                                    <div id="tasks-completed">
                                        <div class="card mb-3 bg-light cursor-grab border">
                                            <?php foreach ($ListPub as $valPub) { ?>
                                                <div class="card-body p-3" style="height: 300px;">
                                                    <?php if($valPub['URL'] !='0') { ?>
                                                        <iframe style=" top: 0;  left: 0;  bottom: 0;  right: 0;  width: 100%;  height: 100%;"  src="<?=$valPub['URL'];?>" frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen></iframe>
                                                    <?php }?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

    <script type="text/javascript" >

        var pElemsErvc = document.getElementsByName("tokenfield[]");
        for ( var i = 0; i < pElemsErvc.length; i++) {
            var idCurs = pElemsErvc[i].id;
            $('#'+idCurs).tokenfield({
                autocomplete: {
                    source: [''],
                    delay: 100
                },
                showAutocompleteOnFocus: true
            })
        }

        function set_KeysIndex(idChp,typeKeys)
        {
            var tit =   '';
            switch (typeKeys){
                case "book":
                    tit = document.getElementById("tokenfieldBook_"+idChp).value ;
                    break;

                default :
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
                url: "<?php echo base_url(); ?>home/set_KeysIndexBook",
                data: { idC: idChp , tit: tit , typeKeys: typeKeys } ,
                timeout: 300000,
                success: function(html) {

                    //console.log(html);
                    var resu = JSON.parse(html);
                    //console.log(resu);

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
                                location.reload();
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
        function set_Couv()
        {

            var data_plat = new FormData($('#pageForm_up')[0]);
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
                url: "<?php echo base_url(); ?>home/upload_Attach_Save",
                data: data_plat ,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
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
                                $('#setCouv').load(" #setCouv > *");
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

        function set_Desc()
        {

            var data_plat = new FormData($('#pageForm_desc')[0]);
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
                url: "<?php echo base_url(); ?>home/upload_Attach_Save_Desc",
                data: data_plat ,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
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
                                $('#serDesc').load(" #serDesc > *");
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

        function set_Vid()
        {
            var data_plat = new FormData($('#pageForm_Vid')[0]);
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
                url: "<?php echo base_url(); ?>home/upload_Attach_Save_Vid",
                data: data_plat ,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 30000000,
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
                                $('#serVid').load(" #serVid > *");
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
<?php }?>

<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>