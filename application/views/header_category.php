
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

    .nav-item-menu{
		display: none;
	}

	@media only screen and (min-width: 992px){
		.nav-item-menu-li:hover .nav-item-menu{
	     	display: block;
	    }
    }

	@font-face {
       font-family: "League Spartan Black";
       src: url(/assets/TYPO/LeagueSpartan-Black.ttf) format("truetype");
    }

	@font-face {
       font-family: "League Spartan Regular";
       src: url(<?php echo base_url('assets/TYPO/LeagueSpartan-Regular.ttf'); ?>) format("truetype");
    }

	li{
		font-family: "League Spartan Regular" !important;
     	font-size:14px;
	}

	@media only screen and (min-width: 992px){
		.ul-margin-top{
			margin-top: 70px;
	    }
    }

	.style-font-header-categorie{
		font-family: League Spartan Black; 
		font-weight: bold;
		 font-size:18px;
	}
			

</style>

<ul class="navbar-nav mr-auto ul-margin-top" style="align-items: flex-start;">

	<?php foreach ($listCat as $value) { ?>
		<?php if($value['Cats']['OrdreCat'] > 0) { ?>
			<li class="nav-item nav-item-menu-li <?php if(sizeof($value['items'] ) > 0) { ?> dropdown <?php }?>      ">
			<?php foreach ($value['items'] as $valItem) { ?>
				<a class="nav-link
					<?php if(sizeof($value['items'] ) > 0) { ?> dropdown-toggle  <?php }?>"
					<?php if($value['Cats']['EstActifMenu'] ==false) { ?> style="display: none" <?php }?>
					href="<?php echo base_url(); ?><?=$valItem ['items'] ['url'];?>" id="navbarDropdown" role="button" data-hover="dropdown"
				   aria-haspopup="true" aria-expanded="false" >
				
				   <span class="style-font-header-categorie"><?=$valItem ['items'] ['LibelleTheme'];?></span>
			 	</a>
				
			    <?php if(sizeof($value['items'] ) > 0) { ?>
					<div class="dropdown-menu nav-item-menu" aria-labelledby="navbarDropdown" style="top:35px;">
                        <?php foreach ($valItem['books'] as $valLiv) { ?>
                            <!-- <div class="dropdown-divider"></div> -->
                            <?php if($valItem ['items'] ['EstUnLivre'] == 1) { ?>
                                <a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$valLiv['IDLivre'];?>" class="list-group-item" style="width: 85%;">
                                    <?php print $valLiv ['Titre']; ?>
                                </a>
                            <?php }else { ?>
                                <a class="dropdown-item"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?=$valLiv['IDLivre'];?>" class="list-group-item" style="width: 85%;">
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

    <?php if (1==2) { ?>
        <?php $ok = 0; foreach ($listCat as $value) { ?>
            <?php if($value['Cats']['OrdreCat'] > 0 && $ok == 0 ) { $ok++; ?>
                <li class="nav-item nav-item-menu-li <?php if(sizeof($value['items'] ) > 0) { ?> dropdown <?php }?>      ">
                    <?php foreach ($value['items'] as $valItem) { ?>
                        <a class="nav-link
					<?php if(sizeof($value['items'] ) > 0) { ?> dropdown-toggle  <?php }?>"
                            <?php if($value['Cats']['EstActifMenu'] ==false) { ?> style="display: none" <?php }?>
                           href="#" id="navbarDropdown" role="button" data-hover="dropdown"
                           aria-haspopup="true" aria-expanded="false" >

                            <span class="style-font-header-categorie"><?php echo($this->lang->line('videos')) ?></span>
                        </a>

                        <?php if(sizeof($value['items'] ) > 0) { ?>
                            <div class="dropdown-menu nav-item-menu" aria-labelledby="navbarDropdown" style="top:35px;">
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
