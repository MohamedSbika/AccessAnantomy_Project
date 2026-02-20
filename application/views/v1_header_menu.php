
<style>
	* {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}
	body {
		font-family: 'Roboto', sans-serif;
		margin: 0;
		padding: 0;
		overflow-x: hidden; /* Prevent horizontal scrolling */
	/*	transform: scale(0.9); */
		transform-origin: top left;
	/*	width: 111.11%; /* Pour compenser la réduction de taille */
        background-color: white;
	}
	.container {
		margin: auto;
		background: white;
		padding: 5px;
	}
	h1, h2, h3, h4, h5, h6 {
		font-family: 'Unbounded', sans-serif;
		margin: 0;
		padding: 0;
	}

	h1 {
		font-weight: 600; /* Pour un titre plus bold */
	}

	h2 {
		font-weight: 500; /* Moins bold que h1 */
	}

	h3 {
		font-weight: 400; /* Poids normal pour h3 */
	}
	h4 {
		font-weight: 300; /* Poids normal pour h3 */
	}

	h5 {
		font-weight: 200; /* Poids normal pour h3 */
	}

	h1 {
		text-align: center;
		color: #2c3e50;
		margin-bottom: 5px;
	}

	.main-content {
		display: flex;
		flex-direction: row;
		gap: 20px;
	}

	.main-section {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		width: 100%;
		gap: 20px;
	}

	.image-section {
		width: 100%;
		margin-left: 90px;
	}

	.image-section img {
		/*width: 100%;*/
		width: 400px;
		border-radius: 10px;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.62);
		margin-bottom: 20px; /* Ajoute un espace sous l'image */
	}
	.chapter-section {
		background: white;
		border-radius: 10px;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
		padding: 20px;
	}

	.chapter-header {
		background: #1d3557;
		color: white;
		font-size: 18px;
		font-weight: bold;
		/*padding: 10px;*/
		border-radius: 10px 10px 0 0;
		text-align: center;
	}
	.chapter-item {
		display: flex;
		align-items: center;
		padding: 10px;
		border-bottom: 1px solid #f0f0f0;
		cursor: pointer;
		transition: background-color 0.3s ease;
		color: #1d3557;
	}
	.chapter-item.selected, .chapter-item:hover {
		background-color: #7387b8;
		color: white;
	}
	.top-bar {
		color: white;
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap; /* Allows stacking on small screens */
	}

	.top-bar nav a {
		color: white;
		margin-left: 15px;
		text-decoration: none;
	}

	/* Sidebar (initially hidden) */
	.side-nav {
		position: fixed;
		top: 0;
		left: -250px; /* Hidden offscreen initially */
		width: 250px;
		height: 100%;
		background-color: #0E2A47;
		transition: 0.3s;  /* Smooth transition */
		z-index: 1000;
		padding-top: 60px;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
	}
	.side-nav a {
		padding: 8px 8px 8px 32px;
		text-decoration: none;
		font-size: 22px;
		color: white;
		display: block;
		transition: 0.3s;
	}

	.side-nav a:hover {
		background-color: #575757;
	}

	/* Close button inside the sidebar */
	.side-nav .close-btn {
		position: absolute;
		top: 20px;
		right: 25px;
		font-size: 36px;
		margin-left: 50px;
		color: white;
	}
	/* Hamburger menu button */
	.menu-btn {
		display: none;  /* Hide by default */
		font-size: 30px;
		color: white;
		background: none;
		border: none;
		cursor: pointer;
	}

	.main-nav ul {
		list-style: none;
		padding: 0;
		display: flex;
	}

	.main-nav ul li {
		margin: 0 15px;
	}

	.main-nav ul li a {
		color: #120E47;
		text-decoration: none;
		font-weight: bold;
	}


	/* Media Queries for Mobile */
	@media (max-width: 768px) {
		.menu-btn {
			display: flex;
			position: absolute;
			top: 5px;
			left: 10px;
			width: 40px;
			color: #203b6f;
			border: 2px solid #203b6f;
		}
		/* Sidebar navigation visible when toggled */
		.side-nav {
			padding-top: 80px;
		}
	}
	/* Adjust the layout for larger screens */
	@media (min-width: 769px) {
		.side-nav {
			display: none;  /* Sidebar hidden by default on large screens */
		}

		.main-nav ul {
			display: flex;
		}
	}

	/* Show the toggle button on smaller screens */
	@media (max-width: 768px) {
		.menu-btn {
			display: flex;
			position: absolute;
			top: 5px;
			left: 10px;
		}

		.main-nav {
			display: none;  /* Hide default nav on small screens */
		}

		.side-nav {
			padding-top: 80px;  /* Adjust padding for mobile */
		}
	}
	/* Adjust main-nav for mobile */
	@media (min-width: 769px) {
		.main-nav ul {
			display: flex;
		}
	}

	.top-bar nav a {
		color: white;
		margin-left: 15px;
		text-decoration: none;
	}
	.main-nav {
		background: #008b6a;
		color: #120E47;
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap; /* Wraps navigation items on small screens */
		padding: 1px 20px;
	}

	.main-nav ul {
		list-style: none;
		padding: 0;
		display: flex;
		flex-wrap: wrap;
	}

	.main-nav ul li {
		margin: 0 15px;
	}

	.main-nav ul li a {
		color: white;
		text-decoration: none;
		font-weight: bold;
	}

	.hero {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 50px 5%;
		background: linear-gradient(135deg, #7e7e86ff 30%, #0c2d26e8 100%);
		flex-wrap: wrap; /* Allow elements to stack on small screens */
	}

	.hero-text {
		max-width: 45%;
		margin-left: 90px;
	}

	.hero-text h1 {
		font-size: 2.2em;
		font-weight: bold;
		line-height: 1.2;
		color: #120E47;
	}

	.hero-text p {
		font-size: 1.2em;
		margin-bottom: 20px;
	}

	.buttons {
		display: flex;
		gap: 15px;
	}

	.hero-image img {
		max-width: 100%;
		border-radius: 12px;
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
	}

	/* Media Queries for Responsiveness */
	@media (max-width: 1200px) {
		.hero {
			flex-direction: column;
			padding: 80px 5%;
		}

		.hero-text {
			max-width: 100%;
			text-align: center;
			margin-left: 5px;
		}

		.hero-image {
			margin-top: 20px;
			width: 100%;
		}

		.hero-text h1 {
			font-size: 2em;
		}

		.hero-text p {
			font-size: 1em;
		}
	}

	@media (max-width: 768px) {
		.main-nav {
			display: none;
		}
		.hero {
			padding: 80px 5%;
		}

		.hero-text h1 {
			font-size: 1.8em;
		}

		.hero-text p {
			font-size: 1em;
		}

		.hero-image img {
			width: 100%;
		}

		.buttons {
			flex-direction: column;
			gap: 10px;
		}

		.main-nav ul {
			flex-direction: column;
			align-items: center;
			width: 100%;
		}

		.main-nav ul li {
			margin: 10px 0;
		}

		.main-nav ul li a {
			font-size: 1.1em;
		}

		.top-bar nav {
			/* flex-direction: column; */
			align-items: center;
		}
	}

	@media (max-width: 480px) {
		.hero {
			padding: 80px 5%;
		}

		.hero-text h1 {
			font-size: 1.6em;
		}

		.hero-text p {
			font-size: 0.9em;
		}

		.buttons {
			gap: 8px;
		}

		.main-nav ul li a {
			font-size: 0.9em;
		}

		.top-bar {
			flex-direction: column;
			align-items: center;
		}

		.top-bar nav a {
			margin: 5px 0;
		}

		.hero-image img {
			max-width: 100%;
			border-radius: 8px;
		}

		.hero-text p {
			line-height: 1.4;
		}
	}

	nav {
		display: flex;  /* Utilisation de Flexbox pour aligner les éléments horizontalement */
		justify-content: flex-end;  /* Aligne tous les éléments à droite */
		align-items: center;  /* Aligne verticalement les éléments */
	}

	nav a {
		text-decoration: none;
		color: white;
		font-weight: bold;
	}

	.social-link {
		display: inline-block;
	}

	.social-icon {
		width: 40px;  /* Taille des icônes sociales */
		height: 40px;
		border-radius: 50%;  /* Rendre les icônes circulaires */
	}

	.flag {
		font-size: 1.5em;
	}

	.search-bar {
		display: flex;
		align-items: center;
		background: white;
		padding: 5px;
		border-radius: 20px;
		width: 250px;
		margin-right: 10px;
	}

	.search-bar input {
		border: none;
		outline: none;
		padding: 5px;
		width: 250px;
	}

	.search-bar button {
		background: none;
		border: none;
		cursor: pointer;
	}

	.user-section {
		display: flex;
		align-items: center;
		gap: 15px;
	}

	.user-section img {
		width: 20px;
		height: 15px;
	}

	.user-section .user-icon {
		font-size: 20px;
		cursor: pointer;
		color: white;
	}
    hr {
        margin:	0.2rem 0;
    }
    .card-body {
        padding-top: 0rem;
        padding-bottom: 0rem;
    }
    .form-check-label{
        font-size: 0.8em !important;
    }

    .btn .p {
        font-size: .7rem !important;
    }
    .top{
        display: none;
    }
    .table > :not(caption) > * > * {
        border-bottom-width: 0px;
    }
    .table.dataTable {
        /*margin-bottom: -10px !important;*/
        margin-top: 10px !important;
    }
    .mb-2 {
        margin-bottom: .0rem !important;
    }
</style>
<!-- Hamburger Menu Icon -->
<button class="menu-btn" onclick="toggleNav()">☰</button>

<!-- Sidebar Navigation (Initially hidden)-->
<!--<div class="side-nav" id="sideNav">-->
<!--	<a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>-->
<!--	<a href="#">Accueil</a>-->
<!--	<a href="#">Anatomie ▼</a>-->
<!--	<a href="#">Embryologie ▼</a>-->
<!--	<a href="#">ELearning</a>-->
<!--	<a href="#">Contact</a>-->
<!--</div>-->

<!-- Main Navigation for larger screens -->
<div class="side-nav new-side-nav livre-side-nav d-md-none d-flex" id="sideNav">

	<img   src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" width="100px"
		   onclick="window.location.href='<?php echo base_url() . $this->lang->line('siteLang'); ?>login';" >
    <a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>


	<?php include('v1_header_category.php'); ?>

	<?php if($this->session->userdata('user_id') > 0) { ?>

		<div>
			<form style="margin-top:5px; width:100%;" action="<?php echo base_url(); ?><?php echo $this->session->userdata('site_lang'); ?>/searchIndex" method="post">
				<div class="input-group input-group-navbar" style="display: flex; align-items: center; padding-right: 0.5em; border-bottom: 1px solid rgba(9,138,99);">
					<input style="background-color:white; border:none; padding:5px 10px; height:30px; font-size:12px; flex:1;"
						   name="indexSearch" id="indexSearch" type="text"
						   value="<?php if(isset($indexSearch)){print $indexSearch; } ?>"
						   class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…"
						   aria-label="<?php echo $this->lang->line('search'); ?>">
					<button style="background-color:white; border:none; padding:5px 10px; height:31px; display: flex; align-items: center; justify-content: center;"
							class="btn" type="submit" id="validSearch">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle" style="transform: rotate(-20deg); color:rgba(9,138,99);">
							<circle cx="11" cy="11" r="6"></circle>
							<line x1="17" y1="17" x2="15" y2="15"></line>
						</svg>
					</button>
				</div>
			</form>
		</div>


		<div style="display:flex; flex-direction:column; max-width: 300px; width: auto;padding-top: 10px;">

			<div class="language-user-navbar language-class"  style="justify-content: space-between;">

				<?php if($this->session->userdata('user_id') > 0) { ?>

					<li class="nav-item dropdown" style="list-style: none;float: right;">

						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
						</a>

						<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
							<i class="fas fa-user-circle user-icon" style="color: white"></i>
							<span class="text-dark"><?php echo $this->session->userdata('logged_in_name'); ?> </span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" style="min-width: 10rem">
							<style>
								.dropdown .dropdown-menu.show {
									top: 33px !important;
								}

							</style>
							<div class="m-sm-1">

								<?php if($this->session->userdata('EstAdmin') ==1) { ?>

									<a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>pagesSetting"  class="dropdown-item" style="padding: .5rem 0.2rem;">
										<i class="fa fa-tools"></i>
										<span class="text-dark"><?php echo $this->lang->line('settings'); ?></span>
									</a>
									<?php
									// Exemple de cryptage de l'URL à transmettre
									$encrypted_url = urlencode(base64_encode($this->uri->uri_string()));
									?>

									<a href="<?php echo base_url() . $this->lang->line('siteLang') . 'switchPlatform/' . $encrypted_url; ?>"
									   class="dropdown-item"
									   style="padding: .5rem 0.2rem;">
										<?php if ($this->session->userdata('typePlatform') == true) { ?>
											<i class="fa fa-tools"></i>
											<span class="text-dark" style="margin-left: 10px">Mode admin</span>
										<?php } else { ?>
											<i class="fa fa-book-open"></i>
											<span class="text-dark" style="margin-left: 10px">Mode lecture</span>
										<?php } ?>
									</a>
								<?php } ?>
								<a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>logout" class="dropdown-item" style="padding: .5rem 0.2rem;">
									<i class="fa fa-sign-out-alt"></i>
									<span class="text-dark">Déconnexion</span>
								</a>
							</div>
						</div>

					</li>

				<?php }else{ ?>
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
						</a>

						<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="modal"
						   onclick="redirectLogLivr(0)" data-target="#centeredModalPrimary">
                            <span class="text-dark">
							    <img src="<?php echo HTTP_IMAGES; ?>photos/user-icon.png" class="mr-1" alt="Avatar" width="25" data-toggle="dropdown" style=" margin-top:auto; margin-bottom:auto">
                                Connexion
							</span>
						</a>

					</li>
				<?php } ?>

			</div>

		</div>

	<?php }else{ ?>
		<a href="#" onclick="openModal(); return false;">Se connecter</a>
	<?php } ?>

	<?php include('v1_header_langauge.php'); ?>

</div>

<nav class="main-nav d-md-flex d-none">

    <img   src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png" width="100px"
           onclick="window.location.href='<?php echo base_url() . $this->lang->line('siteLang'); ?>login';" >
    <a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>


    <?php include('v1_header_category.php'); ?>

    <?php if($this->session->userdata('user_id') > 0) { ?>

        <div>
            <form style="margin-top:5px; width:100%;" action="<?php echo base_url(); ?><?php echo $this->session->userdata('site_lang'); ?>/searchIndex" method="post">
                <div class="input-group input-group-navbar" style="display: flex; align-items: center; padding-right: 0.5em; border-bottom: 1px solid rgba(9,138,99);">
                    <input style="background-color:white; border:none; padding:5px 10px; height:30px; font-size:12px; flex:1;"
                           name="indexSearch" id="indexSearch" type="text"
                           value="<?php if(isset($indexSearch)){print $indexSearch; } ?>"
                           class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…"
                           aria-label="<?php echo $this->lang->line('search'); ?>">
                    <button style="background-color:white; border:none; padding:5px 10px; height:31px; display: flex; align-items: center; justify-content: center;"
                            class="btn" type="submit" id="validSearch">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle" style="transform: rotate(-20deg); color:rgba(9,138,99);">
                            <circle cx="11" cy="11" r="6"></circle>
                            <line x1="17" y1="17" x2="15" y2="15"></line>
                        </svg>
                    </button>
                </div>
            </form>
        </div>


        <div style="display:flex; flex-direction:column; max-width: 300px; width: auto;padding-top: 10px;">

            <div class="language-user-navbar language-class"  style="justify-content: space-between;">

                <?php if($this->session->userdata('user_id') > 0) { ?>

                    <li class="nav-item dropdown" style="list-style: none;float: right;">

                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                            <i class="fas fa-user-circle user-icon" style="color: white"></i>
                            <span class="text-dark"><?php echo $this->session->userdata('logged_in_name'); ?> </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" style="min-width: 10rem">
                            <style>
                                .dropdown .dropdown-menu.show {
                                    top: 33px !important;
                                }

                            </style>
                            <div class="m-sm-1">

                                <?php if($this->session->userdata('EstAdmin') ==1) { ?>

                                    <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>pagesSetting"  class="dropdown-item" style="padding: .5rem 0.2rem;">
                                        <i class="fa fa-tools"></i>
                                        <span class="text-dark"><?php echo $this->lang->line('settings'); ?></span>
                                    </a>
                                    <?php
                                    // Exemple de cryptage de l'URL à transmettre
                                    $encrypted_url = urlencode(base64_encode($this->uri->uri_string()));
                                    ?>

                                    <a href="<?php echo base_url() . $this->lang->line('siteLang') . 'switchPlatform/' . $encrypted_url; ?>"
                                       class="dropdown-item"
                                       style="padding: .5rem 0.2rem;">
                                        <?php if ($this->session->userdata('typePlatform') == true) { ?>
                                            <i class="fa fa-tools"></i>
                                            <span class="text-dark" style="margin-left: 10px">Mode admin</span>
                                        <?php } else { ?>
                                            <i class="fa fa-book-open"></i>
                                            <span class="text-dark" style="margin-left: 10px">Mode lecture</span>
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>logout" class="dropdown-item" style="padding: .5rem 0.2rem;">
                                    <i class="fa fa-sign-out-alt"></i>
                                    <span class="text-dark">Déconnexion</span>
                                </a>
                            </div>
                        </div>

                    </li>

                <?php }else{ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="modal"
                           onclick="redirectLogLivr(0)" data-target="#centeredModalPrimary">
                            <span class="text-dark">
							    <img src="<?php echo HTTP_IMAGES; ?>photos/user-icon.png" class="mr-1" alt="Avatar" width="25" data-toggle="dropdown" style=" margin-top:auto; margin-bottom:auto">
                                Connexion
							</span>
                        </a>

                    </li>
                <?php } ?>

            </div>

        </div>

    <?php }else{ ?>
        <a href="#" onclick="openModal(); return false;">Se connecter</a>
    <?php } ?>

    <?php include('v1_header_langauge.php'); ?>

</nav>

<script>
    // Function to open the sidebar menu
    function toggleNav() {
        var sideNav = document.getElementById("sideNav");
        if (sideNav.style.left === "0px") {
            sideNav.style.left = "-250px";  // Close menu
        } else {
            sideNav.style.left = "0";  // Open menu
        }
    }

    // Function to close the sidebar
    function closeNav() {
        document.getElementById("sideNav").style.left = "-250px";  // Close menu
    }
</script>
