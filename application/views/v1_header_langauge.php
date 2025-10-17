<?php
// Vérifier si une langue est déjà enregistrée dans la session
$lang = $this->session->userdata('site_lang') ?: 'FR';

// Sélectionner le drapeau en fonction de la langue
$flags = [
	'FR' => '🇫🇷',
	'EN' => '🇬🇧',
	'ES' => '🇪🇸'
];

$flag = isset($flags[$lang]) ? $flags[$lang] : '🌐';
?>
<div>
	<ul class="navbar-nav mr-auto ul-margin-top" style="align-items: flex-start; margin-left: 20px;">


		<!-- Dropdown pour la sélection de la langue -->
		<li class="nav-item  nav-item-menu-li dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?= $flag; ?> <!-- Affiche le drapeau actuel -->
			</a>
			<div class="dropdown-menu" aria-labelledby="languageDropdown" style="top: 35px;">
				<style>
					.dropdown-menu{
						left: -45px !important  ;
					}
				</style>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/FR" style="color: #120e47;margin-left: 0px;">
					🇫🇷 &nbsp;Français
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/EN" style="color: #120e47;margin-left: 0px;">
					🇬🇧 &nbsp;English
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/ES" style="color: #120e47;margin-left: 0px;">
					🇪🇸 &nbsp;Español
				</a>
			</div>

		</li>

	</ul>
</div>

