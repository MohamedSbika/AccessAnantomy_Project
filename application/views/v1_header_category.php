
<style>
	/* Style de la navbar */
	.ul-margin-top {
		margin-top: 10px;
	}

	/* Style des éléments de menu */
	.nav-item-menu-li {
		position: relative;
		list-style: none;
	}

	/* Style des liens de navigation */
	.nav-link {
		color: #333;
		text-decoration: none;
		font-size: 13px;
		font-weight: bold;
		padding: 10px 15px;
		transition: color 0.3s ease-in-out;
	}

	.nav-link:hover {
		color: #0E2A47;
	}


	/* Affichage du dropdown au survol */
	.nav-item-menu-li:hover .dropdown-menu {
		display: block;
	}

	/* Style des éléments du dropdown */
	.dropdown-menu {
		display: none;
		position: absolute;
		top: 35px;
		left: 0;
		background: white;
		box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
		border-radius: 8px;
		min-width: max-content; /* Adapte la largeur au contenu */
		max-width: 300px; /* Limite la largeur pour éviter qu'elle devienne trop grande */
		padding: 10px 0;
		z-index: 1000;
		border: 1px solid #ddd;
		white-space: nowrap; /* Empêche les retours à la ligne */
	}

	/* Ajustement des éléments du dropdown */
	.dropdown-item {
		padding: 10px 15px;
		color: #333;
		text-decoration: none;
		font-size: 14px;
		display: block;
		transition: background 0.3s ease-in-out;
		border-radius: 5px; /* Arrondi sur les éléments */
	}

	.dropdown-item:hover {
		background: #f1f1f1;
		color: #007bff;
	}


	/* Style du texte dans les catégories */
	.style-font-header-categorie {
		font-size: 14px;
		font-weight: bold;
	}

	/* Responsive Design */
	@media (max-width: 768px) {
		.nav-item-menu-li {
			text-align: left;
		}

		.dropdown-menu {
			position: static;
			box-shadow: none;
			width: 100%;
		}

		.dropdown-item {
			width: 100%;
		}
	}

	/* Ajout d'une flèche pour indiquer un sous-menu */
	.nav-link.dropdown-toggle::after {
		content: " ▼"; /* Petite flèche */
		font-size: 12px;
		margin-left: 5px;
		color: inherit; /* Garde la couleur du texte */
		transition: transform 0.2s ease-in-out;
	}

	/* Animation de la flèche au survol */
	.nav-item-menu-li:hover .nav-link.dropdown-toggle::after {
		transform: rotate(180deg);
	}

	/* Main navigation bar */

	.main-nav ul {
		list-style: none;
		padding: 0;
		display: flex;
	}

	.main-nav ul li a {
		color: #120E47;
		text-decoration: none;
		font-weight: bold;
	}

	.main-nav ul li {
		margin: 0 5px;
	}
</style>

<ul class="navbar-nav mr-auto ul-margin-top" style="align-items: flex-start;margin-left: 20px;">

	<?php foreach ($listCat as $value) { ?>
		<?php if($value['Cats']['OrdreCat'] > 0) { ?>
			<li class="nav-item nav-item-menu-li <?php if(sizeof($value['items'] ) > 0) { ?> dropdown <?php }?>      ">
				<?php foreach ($value['items'] as $valItem) { ?>
					<a class="nav-link
					<?php if(sizeof($value['items'] ) > 0) { ?> dropdown-toggle  <?php }?>"
						<?php if($value['Cats']['EstActifMenu'] ==false) { ?> style="display: none" <?php }?>
					   href="#" id="navbarDropdown" role="button" data-hover="dropdown"
					   aria-haspopup="true" aria-expanded="false" >

						<span class="style-font-header-categorie"><?=$valItem ['items'] ['LibelleTheme'];?></span>
					</a>

					<?php if(sizeof($value['items'] ) > 0) { ?>
						<div class="dropdown-menu nav-item-menu" aria-labelledby="navbarDropdown" style="top:30px;">
							<?php foreach ($valItem['books'] as $valLiv) { ?>
								<!-- <div class="dropdown-divider"></div> -->
								<?php if($valItem ['items'] ['EstUnLivre'] == 1) { ?>
									<a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$valLiv['IDLivre'];?>"
									 >
										<?php print $valLiv ['Titre']; ?>
									</a>
								<?php }else { ?>
									<a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?=$valLiv['IDLivre'];?>"
									 >
										<?php print $valLiv ['Titre']; ?>
									</a>
								<?php }?>
							<?php }?>
						</div>
					<?php }?>
				<?php }?>
			</li>
		<?php }?>
	<?php }?>

	<?php if (1==22) { ?>
		<?php $ok = 0; foreach ($listCat as $value) { ?>
			<?php if($value['Cats']['OrdreCat'] > 0 && $ok == 0 ) { $ok++; ?>
				<li class="nav-item nav-item-menu-li <?php if(sizeof($value['items'] ) > 0) { ?> dropdown <?php }?>      ">
					<?php foreach ($value['items'] as $valItem) { ?>
						<a class="nav-link
					<?php if(sizeof($value['items'] ) > 0) { ?> dropdown-toggle  <?php }?>"
							<?php if($value['Cats']['EstActifMenu'] ==false) { ?> style="display: none" <?php }?>
						   href="#" id="navbarDropdown" role="button" data-hover="dropdown"
						   aria-haspopup="true" aria-expanded="false" >

							<span class="style-font-header-categorie"><?php echo($this->lang->line('videos')) ?>ss</span>
						</a>

						<?php if(sizeof($value['items'] ) > 0) { ?>
							<div class="dropdown-menu nav-item-menu" aria-labelledby="navbarDropdown" style="top:25px;">
								<?php $compteur = 0; foreach ($valItem['books'] as $valLiv) { $compteur++; if($compteur < 10) { ?>
									<!-- <div class="dropdown-divider"></div> -->
									<?php if($valItem ['items'] ['EstUnLivre'] == 1) { ?>
										<a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$valLiv['IDLivre'];?>" class="list-group-item" style="width: 85%;">
											<?php print $valLiv ['Titre']; ?>
										</a>
									<?php }else { ?>
										<a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$valLiv['IDLivre'];?>" class="list-group-item" style="width: 85%;">
											<?php print $valLiv ['Titre']; ?>
										</a>
									<?php }?>
								<?php } }?>
							</div>
						<?php }?>
					<?php }?>
				</li>

			<?php }?>
		<?php }?>
	<?php }?>


</ul>
