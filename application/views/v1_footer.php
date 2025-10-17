<section>
	<style>
		.footer {
			background-color: #073b3a;
			color: white;
			padding: 20px 20px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			flex-wrap: wrap;
		}

		.footer .logo-section {
			max-width: 400px;
			flex: 1;
			min-width: 250px;
			margin-bottom: 20px;
		}

		.footer h3 {
			font-size: 18px;
		}

		.footer p {
			font-size: 14px;
			margin: 5px 0;
		}

		.social-icons {
			margin-top: 10px;
		}

		.social-icons img {
			width: 40px;
			margin-right: 5px;
		}

		.newsletter {
			flex: 1;
			min-width: 250px;
			margin-bottom: 20px;
			margin-left: 200px;
		}

		.newsletter input {
			padding: 12px;
			border: none;
			border-radius: 5px;
			max-width: 40%;
			margin-right: 5px;
		}

		.newsletter button {
			background-color: #28a745;
			color: white;
			border: none;
			padding: 8px 12px;
			border-radius: 5px;
			cursor: pointer;
			max-width: 20%;
		}

		.quick-links {
			/*flex: 1;*/
			min-width: 200px;
			margin-bottom: 20px;
		}

		.quick-links a {
			display: block;
			color: white;
			text-decoration: none;
			margin-bottom: 5px;
		}

		.footer-bottom {
			text-align: center;
			background-color: #062d2c;
			color: white;
			padding: 10px;
			font-size: 14px;
		}

		.flag {
			width: 25px;
			margin-left: 10px;
		}

		/* Responsive Design */
		@media screen and (max-width: 768px) {
			.footer {
				flex-direction: column;
				align-items: center;
				text-align: center;
			}

			.newsletter input,
			.newsletter button {
				width: 100%;
				margin-top: 5px;
			}

			.social-icons img {
				width: 25px;
			}

			.flag {
				margin-top: 10px;
			}
		}

		@media screen and (max-width: 768px) {
			.footer {
				flex-direction: column;
				align-items: baseline;
				text-align: center;
			}
			.newsletter {
				margin-left: auto;
			}

			.newsletter button {
				max-width: initial;
			}
			.quick-links{width: 100%;}
		}

	</style>

	<footer class="footer">
		<div class="logo-section">
			<div class="logo">
				<img style="width: 70%;" src="<?php echo HTTP_IMAGES; ?>icons/icon-logo.png" alt="Access Anatomy Logo">
			</div>
			<p><?php echo $this->lang->line('footer_logo_description'); ?></p>
			<div class="social-icons">
				<a href="https://www.facebook.com/AccessAnatomyFB" target="_blank"  title="<?php echo $this->lang->line('footer_facebook_title'); ?>" class="social-link" id="facebook-link">
					<img src="<?php echo HTTP_IMAGES; ?>social_media/fb_40.png" class="rounded-circle social-icon" alt="Facebook">
				</a>
				<a href="https://www.instagram.com/accessanatomy_com/" target="_blank"  title="<?php echo $this->lang->line('footer_instagram_title'); ?>" class="social-link" id="instagram-link">
					<img src="<?php echo HTTP_IMAGES; ?>social_media/instagram_40.png" class="rounded-circle social-icon" alt="Instagram">
				</a>
			</div>
		</div>

		<div class="newsletter">
			<h3><?php echo $this->lang->line('footer_newsletter_title'); ?></h3>
			<p><?php echo $this->lang->line('footer_newsletter_description'); ?></p>
			<input type="email" placeholder="<?php echo $this->lang->line('footer_newsletter_placeholder'); ?>">
			<button><?php echo $this->lang->line('footer_newsletter_button'); ?></button>
		</div>

		<div class="quick-links">
			<h3><?php echo $this->lang->line('footer_quick_links'); ?></h3>
			<a href="#"><?php echo $this->lang->line('footer_home'); ?></a>
			<a href="#"><?php echo $this->lang->line('footer_account'); ?></a>
			<a href="#"><?php echo $this->lang->line('footer_contact'); ?></a>
		</div>
	</footer>



	<div class="footer-bottom">
		Access Anatomy © 2025
	</div>
</section>
