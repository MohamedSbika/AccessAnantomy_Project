
<style>
	/* Barre de navigation en position fixe à gauche et en pleine largeur */
	nav[aria-label="breadcrumb"] {
		left: 0;
		top: 0;
		width: 100%;
 		padding: 10px 20px;
		border-bottom: 2px solid #cac4c4; /* Légère séparation */
		height: 5px;
		padding-top: 1rem;
		padding-bottom: 1rem;
		z-index: inherit;
	}

	/* Style du breadcrumb */
	.breadcrumb {
		display: flex;
		flex-wrap: wrap;
		list-style: none;
		padding: 0;
		margin: 0;
		align-items: center;
		justify-content: flex-start; /* Aligner les éléments à gauche */
		width: 100%; /* S'assurer que la largeur est pleine */
	}

	/* Style des éléments de la breadcrumb */
	.breadcrumb-item {
		text-align: left;
		/*padding: 5px 10px;*/
		color: #6c757d;
	}

	/* Séparateur entre les éléments */
	.breadcrumb-item + .breadcrumb-item::before {
		content: "›";
		color: #6c757d;
		padding: 0 8px;
		font-weight: bold;
	}

	/* Style des liens */
	.breadcrumb-item a {
		color: #007bff;
		text-decoration: none;
		transition: color 0.3s;
	}

	.breadcrumb-item a:hover {
		color: #0056b3;
		text-decoration: underline;
	}

	/* Timer positionné à droite */
	#setMinut {
		color: red;
		font-size: 18px;
		font-weight: bold;
		position: fixed;
		right: 20px;
		top: 10px;
		z-index: 1000;
		background-color: #465975;
		padding: 5px 10px;
		border-radius: 5px;
	}
	ul {
		padding-left: 0rem;
	}

	.carreaux_lec{
		width: 170px;
		height: 30px;
		background: linear-gradient(135deg, #1d3557, #989c9eff);
		color: white;
		justify-content: center;
		box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
		border-radius: 10px;
		display: flex;
	}
</style>

	<nav aria-label="breadcrumb"   style="display: none">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login"><?php echo $this->lang->line('accueil'); ?></a></li>
			<?php if($page =='livreList') { ?>
				<li class="breadcrumb-item"><?php print $OneBook[0]["Libelle"]; ?></li>
			<?php }?>
			<?php if($page =='livre') { ?>
				<li class="breadcrumb-item active"><?php print $OneBook[0]["Titre"]; ?></li>
			<?php }?>
			<?php if($page =='livreDetails') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>
				<li class="breadcrumb-item active"><?php echo $this->lang->line('chapitres'); ?></li>
			<?php }?>
			<?php if($page =='livreCours') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('cours'); ?></li>
			<?php }?>
			<?php if($page =='livreResume') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('resume'); ?></li>
			<?php }?>
			<?php if($page =='livreQcm') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('qcm'); ?></li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
			<?php }?>
			<?php if($page =='livreQroc') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('qroc'); ?> </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
			<?php }?>

			<?php if($page =='test') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : Liste Test </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
			<?php }?>

			<?php if($page =='page_test_Figure') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>


				<?php if($this->session->userdata('EstAdmin') == 1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>settingTest/<?php print $OneBook[0]["IDChapitre"]; ?>"><?php print $OneBook[0]["TitreChapitre"]; ?> :List Test </a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["TitreChapitre"]; ?> :List Test</li>
				<?php }?>

				<li class="breadcrumb-item active"> Test  <?php print $idFigure; ?> </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>


			<?php }?>

			<?php if($page =='listTestFigure') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"> Test  </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>


			<?php }?>

			<?php if($page =='listCalqueFigure') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item"><?php echo $this->lang->line('Calques'); ?></li>

				<li class="breadcrumb-item active"> <?php print $OneBook[0]["TitreChapitre"]; ?> </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>


			<?php }?>

			<?php if($page =='evaluatQCM') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php echo $this->lang->line('testQCM'); ?></li>
			<?php }?>
			<?php if($page =='evaluatQROC') { ?>
				<?php if($this->session->userdata('EstAdmin') ==1) { ?>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
				<?php }else{ ?>
					<li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
				<?php }?>

				<li class="breadcrumb-item active"><?php echo $this->lang->line('testQROC'); ?></li>
			<?php }?>
		</ol>

		<?php
		if (in_array((int)$OneBook[0]["IDLivre"], [70, 71]) || in_array((int)$OneBook[0]["IDCategory"], [4, 9])) {
			// Code si la condition est vraie
		} else {
			if ($page != 'livre') {  // Vérification de la condition pour $page
				?>
				<div style="width: 60%;display: flex; gap: 45px;margin-right: 20px;">
					<button class="carreaux_lec"  onclick="openModalModeLecture(); return false;">Mode lecture</button>

				</div>
				<?php
			}
		}
		?>

	</nav>
	<?php if($page =='evaluatQCM' || $page =='evaluatQROC') { ?>
		<li class="breadcrumb-item active" style="top:-1;text-align: right ; float: right"><p style="padding-left: 1rem;color:red;text-align: right ; position: fixed" id="setMinut"></p></li>
	<?php }?>

<?php include('v1_modal_mode_lecture.php'); ?>
