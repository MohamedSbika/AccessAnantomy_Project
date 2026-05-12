<?php
// Vérifier si une langue est déjà enregistrée dans la session
$lang = $this->session->userdata('site_lang') ?: 'FR';

// Sélectionner le drapeau en fonction de la langue
$flags = [
	'FR' => '🇫🇷',
	'EN' => '🇬🇧',
	'ES' => '🇪🇸',
	'RU' => '🇷🇺',
	'TR' => '🇹🇷',
	'PT' => '🇵🇹',
	'IT' => '🇮🇹',
	'DE' => '🇩🇪',
	'PL' => '🇵🇱',
	'JA' => '🇯🇵',
	'KO' => '🇰🇷'
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
					#languageDropdown + .dropdown-menu {
						left: -45px !important;
					}
					.dropdown-item-autre {
						border-top: 1px solid #e0e0e0;
						margin-top: 4px;
						padding-top: 8px !important;
					}
				</style>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/FR" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇫🇷 &nbsp;Français
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/EN" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇬🇧 &nbsp;English
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/ES" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇪🇸 &nbsp;Español
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/RU" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇷🇺 &nbsp;Русский
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/TR" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇹🇷 &nbsp;Türkçe
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/PT" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇵🇹 &nbsp;Português
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/IT" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇮🇹 &nbsp;Italiano
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/DE" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇩🇪 &nbsp;Deutsch
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/PL" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇵🇱 &nbsp;Polski
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/JA" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇯🇵 &nbsp;日本語
				</a>
				<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/KO" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
					🇰🇷 &nbsp;한국어
				</a>
				<a class="dropdown-item dropdown-item-autre" href="javascript:void(0)" style="color: #120e47;margin-left: 0px;" onclick="toggleGtBar()">
					🌐 &nbsp;Autre...
				</a>
			</div>

		</li>

	</ul>
</div>
