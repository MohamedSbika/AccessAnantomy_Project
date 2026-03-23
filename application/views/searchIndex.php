<?php if(strlen($this->session->userdata('passTok'))==200 || strlen($this->session->userdata('passTok'))<200) {  ?>


    <?php
    include('header.php');
    ?>
    <style>
        .table th {
            text-align: center;
        }
        .table tr {
            text-align: center;
        }
        .btn-outline-primary {
            color: #000000;
            font-size: 80%;
        }
        .btn-outline-primary:hover{
            background: #ADD8E6;
            color: #000000;
        }
        .btn-outline-primary:active{
            background: #ADD8E6;
            color: #000000;
        }

    </style>
    <body  oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false"  ondragstart="return false"  >

    <?php
    include('header_steppes.php');
    ?>

    <div class="wrapper">

        <div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false"  ondragstart="return false" >
            <main class="content">
                <div class="container-fluid p-0">
                    <?php
                    include('header_nav.php');
                    ?>
                    <div class="mb-3">
                        <h3 class="h3 d-inline align-middle"><?php echo $this->lang->line('searchTitle'); ?> : <?php print $indexSearch; ?></h3>
                    </div>
                    <?php if($indexSearch ==''){ ?>
                        <h4 style="color: red">Aucune donnée trouvée</h4>
                    <?php }else{?>
                        <div class="row" id="searchBloc">
                            <div class="col-xl-12" style="margin: auto; ">
                                <div class="card">
                                    <div class="card">
                                        <?php if(count($resSearchLiv)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('book'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchLiv as $val) { ?>
                                                        <li class="timeline-item">
                                                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $val["IDLivre"]; ?>">
                                                                <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?></strong>
                                                            </a>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <hr>
                                        <?php } ?>

                                        <?php if(count($resSearchCh)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('chapitres'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchCh as $val) { ?>
                                                        <li class="timeline-item">
                                                            <?php if($this->session->userdata('user_id') > 0) { ?>
                                                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $val["IDLivre"]; ?>">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a href="#" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php } ?>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <hr>
                                        <?php } ?>

                                        <?php if(count($resSearchCurs)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('cours'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchCurs as $val) { ?>
                                                        <li class="timeline-item">
                                                            <?php if($this->session->userdata('user_id') > 0) { ?>
                                                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreCours/<?php print $val["IDChapitre"]; ?>/<?php print $indexSearch; ?>">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a href="#" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php } ?>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <hr>
                                        <?php } ?>

                                        <?php if(count($resSearchResum)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('resume'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchResum as $val) { ?>
                                                        <li class="timeline-item">
                                                            <?php if($this->session->userdata('user_id') > 0) { ?>
                                                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreResume/<?php print $val["IDChapitre"]; ?>/<?php print $indexSearch; ?>">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a href="#" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?></strong>
                                                                </a>
                                                            <?php } ?>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <hr>
                                        <?php } ?>

                                        <?php if(count($resSearchQcm)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('qcm'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchQcm as $val) { ?>
                                                        <li class="timeline-item">
                                                            <?php if($this->session->userdata('user_id') > 0) { ?>
                                                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcm/<?php print $val["IDChapitre"]; ?>">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?> / <?php echo $this->lang->line('question'); ?> : <?php print $val["nameQ"] ?></strong>
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a href="#" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?> / <?php echo $this->lang->line('question'); ?> : <?php print $val["nameQ"] ?></strong>
                                                                </a>
                                                            <?php } ?>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <hr>
                                        <?php } ?>

                                        <?php if(count($resSearchQroc)>0) { ?>
                                            <div class="card-body">
                                                <strong><?php echo $this->lang->line('qroc'); ?></strong>
                                                <ul class="timeline mt-2 mb-0">
                                                    <?php foreach ($resSearchQroc as $val) { ?>
                                                        <li class="timeline-item">
                                                            <?php if($this->session->userdata('user_id') > 0) { ?>
                                                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreQcm/<?php print $val["IDChapitre"]; ?>">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?> / <?php echo $this->lang->line('question'); ?> : <?php print $val["nameQ"] ?></strong>
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a href="#" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                    <strong><?php print $val["LibelleTheme"] ?> / <?php print $val["Titre"] ?> / <?php print $val["TitreChapitre"] ?> / <?php echo $this->lang->line('question'); ?> : <?php print $val["nameQ"] ?></strong>
                                                                </a>
                                                            <?php } ?>
                                                            <!--
														<span class="float-end text-muted text-sm"> </span>
														<p><?php print $val["descr"] ?></p>
													 -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>


                </div>
            </main>
        </div>
    </div>
    <?php
    include('footer.php');
    ?>

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

            $(document).ready(function()

            {


            });

        </script>
    <?php }?>

<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>

