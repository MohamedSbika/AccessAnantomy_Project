<?php if(strlen($this->session->userdata('passTok'))==200 || strlen($this->session->userdata('passTok'))<200) {  ?>

	<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Membre Supérieur - Atlas d'Anatomie Humaine</title>
		<!-- ✅ Lien vers Font Awesome pour les icônes -->
		<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">

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

	</head>
	<header style=" /*position: fixed;*/  z-index: 1000;  width: 100%;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
		<?php include('v1_header_menu.php'); ?>
	</header>
	<body  data-theme="default" data-layout="boxed" data-sidebar="left" >

    <div class="wrapper">

        <div class="main">

            <main class="content">
                <div class="container-fluid p-4">

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

	<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
	<script src="<?php echo HTTP_JS; ?>app.js"></script>

	<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>

	</body>
	</html>

<?php }else{ ?>

    <?php
    header('Location: '. base_url().$this->lang->line('siteLang').'login');
    exit();
    ?>

<?php } ?>

