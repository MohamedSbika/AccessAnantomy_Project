<?php
$bookId = (int)$OneBook[0]["IDLivre"];

// Vérification pour afficher v1_racourci_pathologie
if (in_array($bookId, [20, 30, 31]) || in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31])) {
	include('v1_racourci_pathologie.php');
} 
// Vérification pour afficher v1_racourci_atlas
elseif (in_array($bookId, [70, 71]) || in_array((int)$OneBook[0]["IDCategory"], [4, 9])) {
	include('v1_racourci_atlas.php');
} 
// Affichage du raccourci par défaut
else { ?>

	<style>
		.sidebar-racc {
			position: fixed;
			width: 35%;
			padding: 15px;
			border-radius: 10px;
			display: flex;
			flex-direction: column;
			align-items: center;
			overflow: hidden;
			z-index: 1000;
			top:110px;
			/*transform: translateY(calc(0px + var(--scroll-y, 0px))); /* Suivre le scroll */
			left: 5px;
			font-size: 13px;
			background: #eaebec94;
		}
		.sidebar-racc.collapsed {
			width: 5%;
			padding: 8px;
			opacity: 0.9;
		}
		.sidebar-racc.collapsed .chapter-item,
		.sidebar-racc.collapsed .chapter-header {
			display: none;
		}
		.sidebar-racc.collapsed .carreaux {
			font-size: 12px;
			text-align: center;
		}
		.carreaux {
			border-radius: 10px;
			width: 50px;
			height: 50px;
			background-color: #fff;
			padding: 10px;
			font-size: 0.9em;
			text-align: center;
			color: #1d3557;
			cursor: pointer;
			transition: background-color 0.3s ease;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			/*border: 1px solid #334867;*/
		}
		.carreaux i {
			font-size: 21px; /* ✅ Taille des icônes */
		}
		.carreaux.selected, .carreaux:hover {
			background-color: #7387b8;
		}

		.toggle-btn {
			position: relative;
			/*left: 55%;*/
			transform: translateX(-50%);
			background: linear-gradient(135deg, #1d3557, #457b9d);
			color: white;
			border: none;
			cursor: pointer;
			font-weight: bold;
			font-size: 14px;
			align-items: center;
			gap: 8px;
			transition: all 0.3s ease;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			border-radius: 10px;
			width: 60px;
			height: 40px;
			padding-bottom: 20px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}
		.toggle-btn:hover {
			background: linear-gradient(135deg, #457b9d, #1d3557);
			transform: translateX(-50%) scale(1.05);
		}
		.toggle-btn:active {
			transform: translateX(-50%) scale(0.95);
		}
		.toggle-btn .arrow {
			font-size: 18px;
			transition: transform 0.3s ease;
		}
		.sidebar-racc.collapsed .toggle-btn .arrow {
			transform: rotate(0deg);
		}
		.sidebar-racc:not(.collapsed) .toggle-btn .arrow {
			transform: rotate(180deg);
		}
		.title_carr{
			font-weight: bolder;
		}

		.toggle_bloc {
			display: flex;
			width: 100%;
			transition: justify-content 0.3s ease;
		}

		.toggle_bloc.left {
			justify-content: flex-start;
		}

		.toggle_bloc.right {
			justify-content: flex-end;
		}

		.toggle_bloc.left .toggle-btn {
			transform: none;
		}

		.toggle_bloc.right .toggle-btn {
			left: auto;
			transform: none;
		}

		/******************************************/

		.tooltip-chapitre {
			position: fixed;
			width: 30%;
			background: rgb(255, 255, 255);
			border: 1px solid #274668;
			border-radius: 10px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			padding: 12px;
			z-index: 3000;
			overflow-y: auto;
			backdrop-filter: blur(6px);
			transition: opacity 0.3s ease;
			top: 110px;
		}

		.tooltip-chapitre .chapter-header {
			font-weight: bold;
			margin-bottom: 10px;
			background: #1d3557;
			color: white;
			font-size: 15px;
			border-radius: 10px 10px 10px 10px;
			text-align: center;
		}

		.tooltip-chapitre .chapter-list {
			list-style: none;
			padding: 0;
			margin: 0;
			max-height: 100%;
		}

		.tooltip-chapitre .chapter-item {
			padding: 8px 10px;
			font-size: 13px;
			border-bottom: 1px solid #cccccc4f;
			cursor: pointer;
			transition: background 0.2s;
			color: #2c2c2c;
			text-align: left;
		}

		.tooltip-chapitre .chapter-item:hover {
			background-color: #f2f4f8;
		}


	</style>

	<div id="listChapTooltip" class="tooltip-chapitre" style="display: none;">
		<div class="chapter-header">
			<?php
			$curs_id = $this->session->userdata('curs_id');
			echo !empty($curs_id)
				? $this->lang->line('sidebar_choisir_cours')
				: $this->lang->line('sidebar_aucun_cours');
			?>
		</div>

		<ul class="chapter-list" id="chapterListTooltip">
			<?php foreach ($listChap as $value) {
				$selected = ($curs_id === "curs_" . $value['IDChapitre']) ? 'selected' : '';
				?>
				<li class="chapter-item <?= $selected; ?>"
					id="curs_<?= $value['IDChapitre']; ?>"
					data-id="<?= $value['IDChapitre']; ?>"
					data-curs="<?= $value['NbreCours']; ?>"
					data-resum="<?= $value['NbreResume']; ?>"
					onclick="selectUniqueChapter(this)">
					<div class="chapter-number"></div>
					<div><?= htmlspecialchars($value['TitreChapitre']); ?></div>
				</li>
			<?php } ?>
		</ul>
	</div>

	<div class="sidebar-racc collapsed" id="sidebar-racc">
		<div class="toggle_bloc left" style="display: none">
			<button class="toggle-btn" onclick="toggleSidebar()">
            <span class="s_plan_retour" style="display: block; width: 100%; text-align: center;padding-top: 30px;height: 35px;">
                <?php echo $this->lang->line('sidebar_plan'); ?>
            </span>
				<span class="arrow" style="display: block; width: 100%; text-align: center;height: 20px;padding-bottom: 33px;">&#8594;</span>
			</button>
		</div>

		<!-- ✅ Icônes ajoutées avec texte en bas -->
		<div style="display: flex;justify-content: space-between; align-items: flex-start; width: 100%;">
			<div id="listRacc">
				<div style="display: grid; flex-wrap: wrap; gap: 10px; justify-content: center;">
               		<span class="carreaux" style="background-color: #657379;color: white;" id="fullscreen_btn" onclick="toggleFullscreen(this)">
                    <div><?php echo $this->lang->line('sidebar_agrandir'); ?></div>
                    <i class="fas fa-expand" id="fullscreen-icon"></i>
                </span>
					<script>
                        function toggleFullscreen(element) {
                            const icon = document.getElementById("fullscreen-icon");
                            const text = element.querySelector("div"); // Récupère le texte du div

                            if (!document.fullscreenElement) {
                                document.documentElement.requestFullscreen();
                                icon.classList.replace("fa-expand", "fa-compress");
                                text.innerHTML = "<?php echo $this->lang->line('sidebar_reduire'); ?>"; // Nouveau texte pour réduire
                            } else {
                                document.exitFullscreen();
                                icon.classList.replace("fa-compress", "fa-expand");
                                text.innerHTML = "<?php echo $this->lang->line('sidebar_agrandir'); ?>"; // Nouveau texte pour agrandir
                            }
                        }
					</script>

					<span class="carreaux" style="background-color: #1E88E5;color: white" onclick="selectUniqueCarreau(this,'resume')">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_cours'); ?></div>
                    <i class="fas fa-headphones-alt"></i>
                </span>
					<span class="carreaux" style="background-color: #00ACC1;color: white" onclick="selectUniqueCarreau(this,'qcm')">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_qcm'); ?></div>
                    <i class="fa fa-play-circle"></i>
                </span>
					<span class="carreaux" style="background-color: #43A047;color: white" onclick="selectUniqueCarreau(this,'qroc')">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_qroc'); ?></div>
                    <i class="fa fa-play-circle"></i>
                </span>
					<span class="carreaux" style="background-color: #FB8C00;color: white" onclick="document.getElementById('modalTestQCM').style.display = 'flex';">
					<div class="title_carr"><?php echo $this->lang->line('testQCM'); ?></div>
				</span>
				<span class="carreaux" style="background-color: #E77845;color: white" onclick="document.getElementById('modalTestQROC').style.display = 'flex';">
					<div class="title_carr"><?php echo $this->lang->line('testQROC'); ?></div>
				</span>
				<?php if (in_array($page, ['livreCours', 'livreResume', 'livreQcm', 'livreQroc'])) { ?>
					<span class="carreaux" style="background-color: #A27561;color: white" onclick="document.getElementById('customModal_Mode_Lecture').style.display = 'flex';">
						<div class="title_carr">Mode lecture</div>
					</span>
				<?php } ?>
				</div>
			</div>


		</div>
	</div>

	<?php include('v1_modal_test_qcm.php'); ?>

	<?php include('v1_modal_test_qroc.php'); ?>

	<script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-racc');
            //  const mainSection = document.getElementById('mainSection');
            const btn 			= document.querySelector('.toggle-btn');
            const arrow 		= btn.querySelector('.arrow');
            const s_plan_retour = btn.querySelector('.s_plan_retour');
            const toggleBloc 	= document.querySelector('.toggle_bloc');

            // Basculer l'état de la sidebar
            sidebar.classList.toggle('collapsed');
            // mainSection.classList.toggle('expanded');

            // Vérifier si la sidebar est fermée ou ouverte
            if (sidebar.classList.contains('collapsed')) {
                // Flèche vers la droite
                arrow.style.transform = "rotate(0deg)";

                // Mettre à jour le texte en fonction de la langue
                s_plan_retour.innerHTML = "<?php echo $this->lang->line('sidebar_plan'); ?>";

                toggleBloc.classList.remove('right');
                toggleBloc.classList.add('left'); // Déplacement à gauche
            } else {
                // Flèche vers la gauche
                arrow.style.transform = "rotate(180deg)";

                // Mettre à jour le texte en fonction de la langue
                s_plan_retour.innerHTML = "<?php echo $this->lang->line('sidebar_retour'); ?>";

                toggleBloc.classList.remove('left');
                toggleBloc.classList.add('right'); // Déplacement à droite
            }

        }

        function selectUniqueCarreau__(selectedElement, type_sel) {
            // Marquage visuel
            toggleSidebar();
            document.querySelectorAll('.carreaux').forEach(carreau => carreau.classList.remove('selected'));
            selectedElement.classList.add('selected');

            // Enregistre le type (cours, qcm, etc.)
            window.selectedType = type_sel;

            // Optionnel : scroll vers la liste des chapitres
            document.getElementById('chapterList').scrollIntoView({ behavior: "smooth" });
        }


        function selectUniqueChapter__(selectedItem, idChapitre) {
            // Mise à jour visuelle
            document.querySelectorAll('.chapter-item').forEach(chap => chap.classList.remove('selected'));
            selectedItem.classList.add('selected');

            // Récupérer le type sélectionné
            const type_sel = window.selectedType;

            if (!type_sel) {
                alert("Veuillez d'abord sélectionner une action (cours, QCM...)");
                return;
            }

            // Données chapitre
            const NbreCours = selectedItem.getAttribute('data-curs');
            const NbreResume = selectedItem.getAttribute('data-resum');

            // Construction de l'URL
            let baseUrl = "<?php echo base_url(); ?>";
            let lang = "<?php echo $this->lang->line('siteLang'); ?>";
            let redirectUrl = "";

            switch (type_sel) {
                case 'theme':
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
                    goFullscreen();
                    break;
                case 'resume':
                    redirectUrl = parseInt(NbreResume) > 0
                        ? `${baseUrl}${lang}livreResume/${idChapitre}`
                        : `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
                case 'qcm':
                    redirectUrl = `${baseUrl}${lang}livreQcm/${idChapitre}`;
                    break;
                case 'qroc':
                    redirectUrl = `${baseUrl}${lang}livreQroc/${idChapitre}`;
                    break;
                case 'test':
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
                default:
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
            }

            // Redirection
            window.location.href = redirectUrl;
        }

        function goFullscreen() {
            var elem = document.documentElement;  // Cibler l'élément <html> pour mettre toute la page en plein écran

            // Vérifier si l'API Fullscreen est disponible et activer le plein écran
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { // Firefox
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { // Chrome, Safari, Opera
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { // Internet Explorer/Edge
                elem.msRequestFullscreen();
            }
        }

       /********************************/

        window.selectedType = null;
        window.selectedCarreauElement = null;
        window.selectedChapterId = null;

        function selectUniqueCarreau(element, type_sel) {
            // Mise à jour visuelle
            if (window.selectedCarreauElement) {
                window.selectedCarreauElement.classList.remove('selected');
            }
            element.classList.add('selected');
            window.selectedCarreauElement = element;

            // Stocker le type sélectionné
            window.selectedType = type_sel;

            // Afficher le tooltip à droite de la sidebar
            const sidebar = document.getElementById("sidebar-racc");
            const tooltip = document.getElementById("listChapTooltip");

            const sidebarRect = sidebar.getBoundingClientRect();
            tooltip.style.top = `${sidebarRect.top}px`;
            tooltip.style.left = `${sidebarRect.right + 10}px`;
            tooltip.style.minHeight ='50%'; // `${sidebarRect.height}px`;
            tooltip.style.maxHeight ='80%'; // `${sidebarRect.height}px`;
            tooltip.style.display = 'block';

            // Supprimer la sélection précédente
            document.querySelectorAll('.carreaux').forEach(carreau => carreau.classList.remove('selected'));
            element.classList.add('selected');

            // Trouver le chapitre actuellement sélectionné
            let selectedChapter = document.querySelector('.chapter-item.selected');

            let idChapitre = "<?php echo $this->session->userdata('curs_id'); ?>".replace(/^curs_/, "");
            let idChap_select = selectedChapter.getAttribute('data-id') ;

            idChapitre = (idChapitre != idChap_select) && idChap_select!= null ? idChap_select : idChapitre;
        }


        function selectUniqueChapter(chapterElement) {
            const idChapitre = chapterElement.getAttribute('data-id');
            const NbreCours = chapterElement.getAttribute('data-curs');
            const NbreResume = chapterElement.getAttribute('data-resum');
            const type_sel = window.selectedType;

            if (!type_sel) {
                alert("Veuillez d'abord sélectionner une action.");
                return;
            }

            // Marquer visuellement ce chapitre
            document.querySelectorAll('.chapter-item').forEach(el => el.classList.remove('selected'));
            chapterElement.classList.add('selected');
            window.selectedChapterId = idChapitre;

            // Ajouter l'ID du chapitre dans un attribut data pour récupération
            chapterElement.setAttribute('data-id', idChapitre);

            // Construction de l’URL
            let baseUrl = "<?php echo base_url(); ?>";
            let lang = "<?php echo $this->lang->line('siteLang'); ?>";
            let redirectUrl = "";

            switch (type_sel) {
                case 'theme':
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
                case 'resume':
                    redirectUrl = parseInt(NbreResume) > 0
                        ? `${baseUrl}${lang}livreResume/${idChapitre}`
                        : `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
                case 'qcm':
                    redirectUrl = `${baseUrl}${lang}livreQcm/${idChapitre}`;
                    break;
                case 'qroc':
                    redirectUrl = `${baseUrl}${lang}livreQroc/${idChapitre}`;
                    break;
                case 'test':
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
                    break;
                default:
                    redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
            }

            // Ferme le tooltip (facultatif)
            document.getElementById("listChapTooltip").style.display = 'none';

            // Rediriger
            window.location.href = redirectUrl;
        }


        // Fermer si clic en dehors
        document.addEventListener("click", function (e) {
            const tooltip = document.getElementById("listChapTooltip");
            const sidebar = document.getElementById("sidebar-racc");

            if (!tooltip.contains(e.target) && !sidebar.contains(e.target)) {
                tooltip.style.display = "none";
            }
        });


	</script>
	<script>
        function updateScroll() {
            document.documentElement.style.setProperty('--scroll-y', window.scrollY + 'px');
        }
        window.addEventListener('scroll', updateScroll);
	</script>

	<?php
}
?>

