
<style>
	a::after {
		color:#0c85d0;
	}
	.dropdown-submenu {
		position: relative;
	}

	.dropdown-submenu>.dropdown-menu {
		top: 0;
		left: 100%;
	}

	.dropdown-submenu:hover>.dropdown-menu {
		display: block;
	}

	.dropdown-submenu>a:after {
		display: block;
		content: " ";
		float: right;
		width: 0;
		height: 0;
		border-color: transparent;
		border-style: solid;
		border-width: 5px 0 5px 5px;
		border-left-color: #ccc;
		margin-top: 5px;
		margin-right: -10px;
	}

	.dropdown-submenu:hover>a:after {
		border-left-color: #fff;
	}

	.dropdown-submenu.pull-left {
		float: none;
	}

	.dropdown-submenu.pull-left>.dropdown-menu {
		left: -100%;
		margin-left: 10px;
		-webkit-border-radius: 6px 0 6px 6px;
		-moz-border-radius: 6px 0 6px 6px;
		border-radius: 6px 0 6px 6px;
	}
</style>

<ul class="navbar-nav mr-auto" style="align-items: flex-start;margin-bottom: 1.5em;">

	<?php foreach ($listCat as $value) { ?>
		<?php if($value['Cats']['OrdreCat'] > 0) { ?>
			<li class="nav-item  <?php if(sizeof($value['items'] ) > 0) { ?> dropdown <?php }?>      ">
				<a class="nav-link
					<?php if(sizeof($value['items'] ) > 0) { ?> dropdown-toggle  <?php }?>
					<?php if($value['Cats']['EstActifMenu'] ==false) { ?> disabled <?php }?> "
				   href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
				   aria-haspopup="true" aria-expanded="false" >
					<span style="font-family: cursive; font-weight: bold"><?=$value['Cats']['Libelle'];?></span>
				</a>
				<?php if(sizeof($value['items'] ) > 0) { ?>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php foreach ($value['items'] as $valItem) { ?>
							<?php if(sizeof($valItem['books'] ) > 0) { ?>
								<ul class="navbar-nav mr-auto">
									<li class="dropdown-submenu">
										<a  class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreList/<?php print $valItem ['items']["IDCategory"]; ?>/<?php print $valItem ['items']["IDTheme"]; ?>"><?=$valItem ['items'] ['LibelleTheme'];?></a>
										<ul class="dropdown-menu">
											<?php foreach ($valItem['books'] as $valLiv) { ?>
												<li>

													<a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?=$valLiv['IDLivre'];?>" class="list-group-item" style="width: 85%;">
														<?php print $valLiv ['Titre']; ?>
													</a>
												</li>
											<?php }?>
										</ul>
									</li>
								</ul>
							<?php }else{ ?>
								<a  class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreList/<?php print $valItem ['items']["IDCategory"]; ?>/<?php print $valItem ['items']["IDTheme"]; ?>"><?=$valItem ['items'] ['LibelleTheme'];?></a>
							<?php }?>

						<?php }?>

					</div>
				<?php }?>

			</li>
		<?php }?>
	<?php }?>



</ul>
