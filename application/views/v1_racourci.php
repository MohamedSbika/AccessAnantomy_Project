<?php
$bookId = 0;
$themeId = 0;
$categoryId = 0;

if (isset($OneBook) && is_array($OneBook) && !empty($OneBook) && isset($OneBook[0])) {
    $bookId = isset($OneBook[0]['IDLivre']) ? (int)$OneBook[0]['IDLivre'] : 0;
    $themeId = isset($OneBook[0]['IDTheme']) ? (int)$OneBook[0]['IDTheme'] : 0;
    $categoryId = isset($OneBook[0]['IDCategory']) ? (int)$OneBook[0]['IDCategory'] : 0;
}
if (in_array($bookId, [20, 30, 31]) || in_array((int)$OneBook[0]["IDTheme"], [20, 30, 31])) {
	include('v1_racourci_pathologie.php');
} 
elseif (in_array($bookId, [70, 71]) || in_array((int)$OneBook[0]["IDCategory"], [4, 9])) {
	include('v1_racourci_atlas.php');
} 
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
		}
		.carreaux i {
			font-size: 21px; 
		}
		.carreaux.selected, .carreaux:hover {
			background-color: #7387b8;
		}

		.toggle-btn {
			position: relative;
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
		<div id="difficultyBox" style="display:none; padding:10px 5px 15px;">
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
                            const text = element.querySelector("div");

                            if (!document.fullscreenElement) {
                                document.documentElement.requestFullscreen();
                                icon.classList.replace("fa-expand", "fa-compress");
                                text.innerHTML = "<?php echo $this->lang->line('sidebar_reduire'); ?>";
                                document.exitFullscreen();
                                icon.classList.replace("fa-compress", "fa-expand");
                                text.innerHTML = "<?php echo $this->lang->line('sidebar_agrandir'); ?>"; 
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
            const btn 			= document.querySelector('.toggle-btn');
            const arrow 		= btn.querySelector('.arrow');
            const s_plan_retour = btn.querySelector('.s_plan_retour');
            const toggleBloc 	= document.querySelector('.toggle_bloc');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                arrow.style.transform = "rotate(0deg)";

                s_plan_retour.innerHTML = "<?php echo $this->lang->line('sidebar_plan'); ?>";

                toggleBloc.classList.remove('right');
                toggleBloc.classList.add('left'); 
            } else {
                arrow.style.transform = "rotate(180deg)";

                s_plan_retour.innerHTML = "<?php echo $this->lang->line('sidebar_retour'); ?>";

                toggleBloc.classList.remove('left');
                toggleBloc.classList.add('right'); 
            }

        }

        function selectUniqueCarreau__(selectedElement, type_sel) {
            toggleSidebar();
            document.querySelectorAll('.carreaux').forEach(carreau => carreau.classList.remove('selected'));
            selectedElement.classList.add('selected');

            window.selectedType = type_sel;

            document.getElementById('chapterList').scrollIntoView({ behavior: "smooth" });
        }


        function selectUniqueChapter__(selectedItem, idChapitre) {
            document.querySelectorAll('.chapter-item').forEach(chap => chap.classList.remove('selected'));
            selectedItem.classList.add('selected');

            const type_sel = window.selectedType;

            if (!type_sel) {
                alert("Veuillez d'abord sélectionner une action (cours, QCM...)");
                return;
            }

            const NbreCours = selectedItem.getAttribute('data-curs');
            const NbreResume = selectedItem.getAttribute('data-resum');

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

            window.location.href = redirectUrl;
        }

        function goFullscreen() {
            var elem = document.documentElement;  

            // Vérifier si l'API Fullscreen est disponible et activer le plein écran
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { 
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { 
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        }

       /********************************/

        window.selectedType = null;
        window.selectedCarreauElement = null;
        window.selectedChapterId = null;

        function selectUniqueCarreau(element, type_sel) {
            if (window.selectedCarreauElement) {
                window.selectedCarreauElement.classList.remove('selected');
            }
            element.classList.add('selected');
            window.selectedCarreauElement = element;

            window.selectedType = type_sel;
			const diffBox = document.getElementById("difficultyBox");


if (type_sel === 'qcm') {
    diffBox.style.display = "block";

    diffBox.innerHTML = `
        <h4 style="margin-bottom:10px; font-weight:bold; text-align:center; color:#1d3557;">
            Sélectionner le niveau de difficulté
        </h4>

        <div style="display:flex; gap:10px;">

            <label class="diff-label" data-diff="basique" style="
                flex:1; padding:10px; text-align:center;
                border:1px solid #cccccc66;
                border-radius:8px; cursor:pointer;
                background:#f8f9fb;
                color:#1d3557;
            ">
                <input type="radio" name="difficulty" value="basique" style="margin-right:6px;">
                Basique
            </label>

            <label class="diff-label" data-diff="intermediaire" style="
                flex:1; padding:10px; text-align:center;
                border:1px solid #cccccc66;
                border-radius:8px; cursor:pointer;
                background:#f8f9fb;
                color:#1d3557;
            ">
                <input type="radio" name="difficulty" value="intermediaire" style="margin-right:6px;">
                Intermédiaire
            </label>

            <label class="diff-label" data-diff="avance" style="
                flex:1; padding:10px; text-align:center;
                border:1px solid #cccccc66;
                border-radius:8px; cursor:pointer;
                background:#f8f9fb;
                color:#1d3557;
            ">
                <input id="defaultDiff" type="radio" name="difficulty" value="avance" checked style="margin-right:6px;">
                Avancé
            </label>

        </div>
    `;

    // Gestion des clics sur les labels — popup si autre niveau
    diffBox.querySelectorAll(".diff-label").forEach(label => {
        label.addEventListener("click", function (e) {
            const selected = this.dataset.diff;

            if (selected !== "avance") {
                e.preventDefault();
                showDifficultyPopup(`Le niveau <b>${selected}</b> sera bientôt disponible`);
                document.getElementById("defaultDiff").checked = true;
            }
        });
    });

} else {
    diffBox.style.display = "none";
}

            const sidebar = document.getElementById("sidebar-racc");
            const tooltip = document.getElementById("listChapTooltip");

            const sidebarRect = sidebar.getBoundingClientRect();
            tooltip.style.top = `${sidebarRect.top}px`;
            tooltip.style.left = `${sidebarRect.right + 10}px`;
            tooltip.style.minHeight ='50%'; 
            tooltip.style.maxHeight ='80%'; 
            tooltip.style.display = 'block';

            document.querySelectorAll('.carreaux').forEach(carreau => carreau.classList.remove('selected'));
            element.classList.add('selected');

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

            document.querySelectorAll('.chapter-item').forEach(el => el.classList.remove('selected'));
            chapterElement.classList.add('selected');
            window.selectedChapterId = idChapitre;

            chapterElement.setAttribute('data-id', idChapitre);

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

            document.getElementById("listChapTooltip").style.display = 'none';

            window.location.href = redirectUrl;
        }


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

<div id="difficultyPopup"
     style="
        display:none;
        position:fixed;
        top:30%;
        left:50%;
        transform:translate(-50%, -50%);
        background:white;
        padding:20px 25px;
        border-radius:12px;
        border:1px solid #1d3557;
        box-shadow:0 6px 20px rgba(0,0,0,0.2);
        z-index:5000;
        font-size:16px;
        font-weight:bold;
        color:#1d3557;
        text-align:center;
     ">
</div>

<script>
function showDifficultyPopup(text) {
    const popup = document.getElementById("difficultyPopup");
    popup.innerHTML = text;
    popup.style.display = "block";

    setTimeout(() => {
        popup.style.display = "none";
    }, 1500);
}
</script>
