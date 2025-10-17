
<style>
	li::marker {
		color:#ffffff00;
	}

	body{
		font-family: var();
	}

	.language-user-navbar{
		display:flex; flex-direction:row; flex-wrap:nowrap;
	}

	@media only screen and (max-width: 992px){
		.button-language{
			padding: 10px;
	    }

		.language-user-navbar{
		    display:flex; flex-direction:column; flex-wrap:nowrap;
	    }
    }


</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white" style="background:#fff;padding: .5rem 1rem;padding-left :18px;" id="setNAVSTEPPS">
	<a class="navbar-brand" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
	    <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/logoNavbar.png"  style="width: 210px ; margin-top: -1em;">
	</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	
	<div class="collapse navbar-collapse" id="navbarSupportedContent" style="align-items: flex-start;">
		<!-- put navbar category -->
		<?php
		include('header_category.php');
		?>

        <style>
            .socials {
                display: flex;
                justify-content: flex-start; /* Align icons to the left */
                gap: 1rem; /* Space between icons */
                padding-right: 2rem;
            }

            .socials a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px; /* Icon's circle width */
                height: 30px; /* Icon's circle height */
                /* background-color: #ffffff;  Default background color (LinkedIn blue) */
                border-radius: 1%; /* Makes the icon round */
                color: white; /* Icon color */
                text-decoration: none; /* Remove underline from links */
                font-size: 1rem; /* Icon size */
                transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition */

                border-color: white;
                border-width: 0.5px;
                border-style: solid;
            }

            .socials a:hover {
                background-color: #ffffff; /* Darker blue when hovered */
                transform: translateY(-3px); /* Slight lift effect */
            }

        </style>

        <div class="socials">
            <!-- Facebook -->
            <a href="<?= $this->session->userdata('social_facebook') ? $this->session->userdata('social_facebook') : '#'; ?>"
               target="_blank"
               style="display: <?= $this->session->userdata('social_facebook') ? 'flex' : 'none'; ?>"
               title="Facebook" class="social-link" id="facebook-link">
                <img src="<?php echo HTTP_IMAGES; ?>social_media/fb_40.png"
                     class="rounded-circle social-icon"
                     alt="Facebook" />
            </a>

            <!-- Instagram -->
            <a href="<?= $this->session->userdata('social_instagram') ? $this->session->userdata('social_instagram') : '#'; ?>"
               target="_blank"
               style="display: <?= $this->session->userdata('social_instagram') ? 'flex' : 'none'; ?>"
               title="Instagram" class="social-link" id="instagram-link">
                <img src="<?php echo HTTP_IMAGES; ?>social_media/instagram_40.png"
                     class="rounded-circle social-icon"
                     alt="instagram" />
            </a>

            <!-- Twitter -->
            <a href="<?= $this->session->userdata('social_twitter') ? $this->session->userdata('social_twitter') : '#'; ?>"
               target="_blank"
               style="display: <?= $this->session->userdata('social_twitter') ? 'flex' : 'none'; ?>"
               title="Twitter" class="social-link" id="twitter-link">
                <img src="<?php echo HTTP_IMAGES; ?>social_media/twitter_40.png"
                     class="rounded-circle social-icon"
                     alt="twitter" />
            </a>

            <!-- LinkedIn -->
            <a href="<?= $this->session->userdata('social_linkedin') ? $this->session->userdata('social_linkedin') : '#'; ?>"
               target="_blank"
               style="display: <?= $this->session->userdata('social_linkedin') ? 'flex' : 'none'; ?>"
               title="LinkedIn" class="social-link" id="linkedin-link">
                <img src="<?php echo HTTP_IMAGES; ?>social_media/linkedin.png"
                     class="rounded-circle social-icon"
                     alt="linkedin" />
            </a>

            <!-- YouTube -->
            <a href="<?= $this->session->userdata('social_youtube') ? $this->session->userdata('social_youtube') : '#'; ?>"
               target="_blank"
               style="display: <?= $this->session->userdata('social_youtube') ? 'flex' : 'none'; ?>"
               title="YouTube" class="social-link" id="youtube-link">
                <img src="<?php echo HTTP_IMAGES; ?>social_media/youtube_40.png"
                     class="rounded-circle social-icon"
                     alt="youtube" />
            </a>

        </div>

	    <div style="display:flex; flex-direction:column; max-width: 300px; width: 100%;">

		    <div class="language-user-navbar"  style="justify-content: space-between;">

			    <li class="nav-item dropdown  button-language" style="display:flex; flex-direction:row; flex-wrap:nowrap;">
				    <img  src="<?php echo HTTP_IMAGES; ?>photos/language-icon.png" class="rounded-circle mr-1" alt="Avatar" width="40" data-toggle="dropdown" style="display:block; margin-top:auto; margin-bottom:auto; width:45px;">
                    <div style="padding-top:2px;">
			    		<a style="padding:0px 2px;" class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/FR">
            				<span class="align-middle">Français</span>
            			</a>
					    <a style="padding:0px 2px;" class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/EN">
            				<span class="align-middle">English</span>
            			</a>
                        <a style="padding:0px 2px;" class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/ES">
                            <span class="align-middle">Español</span>
                        </a>
                    </div>
                </li>
	
				<?php if($this->session->userdata('user_id') > 0) { ?>

                    <li class="nav-item dropdown">
						
                    	<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                    		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    	</a>
                    
                    	<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
						   <img src="<?php echo HTTP_IMAGES; ?>photos/user-icon.png" class="mr-1" alt="Avatar" width="25" data-toggle="dropdown" style=" margin-top:auto; margin-bottom:auto">
                               
						   <span class="text-dark"><?php echo $this->session->userdata('logged_in_name'); ?> </span>
                    	</a>
                    
                    	<div class="dropdown-menu dropdown-menu-right" style="min-width: 10rem;">
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

			<form style="margin-top:20px; width:100%;" action="<?php echo base_url(); ?><?php echo $this->session->userdata('site_lang'); ?>/searchIndex" method="post">
                <div class="input-group input-group-navbar" style="padding-right: 0.5em;">
			        <button  style="background-color:white; padding:5px 10px; padding-left:1px;" class="btn" type="submit" id="validSearch" >
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle" style="transform: rotate(-20deg); color:rgba(9,138,99);"><circle cx="11" cy="11" r="6"></circle><line x1="25" y1="25" x2="15" y2="15"></line></svg>
                    </button>
			      
					<input style="background-color:white; border-bottom:1px rgba(9,138,99) solid; padding:0px; height:20px; min-height:auto; font-size:15px; margin-top:5px; " name="indexSearch" id="indexSearch"  type="text"  value="<?php if(isset($indexSearch)){print $indexSearch; } ?>" class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…" aria-label="<?php echo $this->lang->line('search'); ?>">
                  
                </div>
            </form>

			
        </div>

	  

	   

	</div>

	
</nav>

<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>

