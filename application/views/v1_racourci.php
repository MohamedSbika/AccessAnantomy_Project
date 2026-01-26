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



    .sous-chapitre-item {
        padding: 8px 15px;
        font-size: 12px;
        color: #555;
        cursor: pointer;
        border-left: 3px solid #457b9d;
        margin: 3px 10px;
        background-color: white;
        border-radius: 3px;
        transition: all 0.2s;
        text-align: left;
    }

    .sous-chapitre-item:hover {
        background-color: #e3f2fd;
        border-left-color: #1d3557;
        color: #1d3557;
        transform: translateX(3px);
    }

    .pathologies-accordion {
        margin: 5px 0;
        background-color: transparent;
        border-radius: 5px;
        overflow: hidden;
    }

    .pathologies-header {
        padding: 10px 15px;
        font-size: 13px;
        font-weight: bold;
        color: #1d3557;
        background-color: #f8f9fa;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #cccccc4f;
        transition: all 0.2s;
    }

    .pathologies-header:hover {
        background-color: #f2f4f8;
    }

    .pathologies-header .accordion-arrow {
        font-size: 14px;
        transition: transform 0.3s ease;
        color: #1d3557;
    }

    .pathologies-header .accordion-arrow.expanded {
        transform: rotate(90deg);
    }

    .pathologies-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.3s ease;
        opacity: 0;
    }

    .pathologies-content.expanded {
        max-height: 800px;
        opacity: 1;
    }

    /* Styles pour les versions de pathologies */
    .patho-version-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: 5px;
        padding-left: 10px;
        border-left: 1px dashed #cbd5e1;
    }

    .patho-version-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 10px;
        font-size: 11px;
        border-radius: 4px;
        transition: all 0.2s;
        text-decoration: none !important;
    }

    .patho-version-link.essential {
        color: #1d4ed8;
        background-color: #eff6ff;
        border: 1px solid #dbeafe;
    }

    .patho-version-link.essential:hover {
        background-color: #dbeafe;
        transform: translateX(2px);
    }

    .patho-version-link.integral {
        color: #9a3412;
        background-color: #fff7ed;
        border: 1px solid #ffedd5;
    }

    .patho-version-link.integral:hover {
        background-color: #ffedd5;
        transform: translateX(2px);
    }

    .patho-version-link i {
        font-size: 10px;
    }

    .patho-item-title {
        font-weight: 600;
        color: #334155;
        font-size: 12px;
        margin-bottom: 5px;
        display: block;
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
					data-id-rappel="<?= $value['IdChapterRappel'] ?? '' ?>"
					data-curs="<?= $value['NbreCours']; ?>"
					data-resum="<?= $value['NbreResume']; ?>"
					data-resum-rappel="<?= $value['NbreResumeRappel'] ?? 0; ?>"
					onclick="selectUniqueChapter(this)">
					<div class="chapter-number"></div>
					<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
						<div><?= htmlspecialchars($value['TitreChapitre']); ?></div>
						<span class="patho-arrow" style="display: none;">▶</span>
					</div>
					<ul class="sous-chapitres-list" id="sous-chap-<?= $value['IDChapitre']; ?>" style="display: none; list-style: none; padding-left: 20px; margin-top: 5px;">
					</ul>
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
                <span class="carreaux" style="background-color: #43A047;color: white" onclick="selectUniqueCarreau(this,'pathologie')">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_pathologie_anatomie'); ?></div>
                    <!--<i class="fa fa-virus"></i>-->
                </span>
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
                        : `${baseUrl}${lang}livreFigures/${idChapitre}`;
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

            let selectedChapter = document.querySelector('.chapter-item.selected');
            let idChapitreSession = "<?php echo $this->session->userdata('curs_id'); ?>".replace(/^curs_/, "");
            let idChap_select = selectedChapter ? selectedChapter.getAttribute('data-id') : null;
            let currentIdChap = (idChap_select != null) ? idChap_select : idChapitreSession;


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

} else if (type_sel === 'pathologie') {
                if (currentIdChap) {
                    loadFeaturedPatho(currentIdChap, diffBox);
                } else {
                    loadFeaturedPatho(0, diffBox);
                }
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

            // Afficher ou masquer les flèches de pathologie
            document.querySelectorAll('.patho-arrow').forEach(arrow => {
                arrow.style.display = (type_sel === 'pathologie') ? 'block' : 'none';
            });

            // Masquer la liste complète des chapitres si on est en mode pathologie
            const fullChapterList = document.getElementById('chapterListTooltip');
            if (fullChapterList) {
                fullChapterList.style.display = (type_sel === 'pathologie') ? 'none' : 'block';
            }

            // Fermer tous les sous-chapitres ouverts
            document.querySelectorAll('.sous-chapitres-list').forEach(list => {
                list.style.display = 'none';
                list.innerHTML = '';
            });
            document.querySelectorAll('.patho-arrow').forEach(arrow => arrow.style.transform = 'rotate(0deg)');
        }


        function loadFeaturedPatho(idChapitre, container) {
            container.innerHTML = '<div style="text-align:center; padding:10px; font-style:italic; color:#1d3557;">Chargement du menu pathologie...</div>';
            container.style.display = 'block';

            let payload = { idChap: idChapitre };
            <?php if (isset($OneBook[0]['IDLivre'])) { ?>
                if (!idChapitre || idChapitre == 0) {
                    payload.idLivre = "<?php echo $OneBook[0]['IDLivre']; ?>";
                }
            <?php } ?>

            fetch("<?php echo base_url(); ?>home/getPathologieByRappel", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";
                    const baseUrl = "<?php echo base_url(); ?>";

                    let html = `<div style="background-color: #1d3557; color: white; padding: 8px; text-align: center; font-weight: bold; border-radius: 5px 5px 0 0; margin-bottom: 5px; font-size: 14px;">
                                    <?php echo $this->lang->line('sidebar_pathologie_anatomie'); ?>
                                </div>`;
                    
                    html += `<ul class="patho-menu-list" style="list-style:none; padding:0; margin:0; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px; overflow: hidden; background: white;">`;
                    
                    if (data.type === 'books') {
                        // Affichage de la liste des livres (Menu Global)
                        data.pathoBooks.forEach((book, index) => {
                            html += `
                                <li class="patho-chapter-item" style="border-bottom: 1px solid #eee;">
                                    <div class="patho-chapter-header" 
                                         onclick="window.location.href='${baseUrl}${lang}/livre/${book.IDLivre}'"
                                         style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; cursor: pointer; font-size: 13px; color: #333; transition: background 0.2s;">
                                        <span style="font-weight: 500;">${book.Titre}</span>
                                        <span style="font-size: 11px; color: #ccc;">➜</span>
                                    </div>
                                </li>`;
                        });
                    } else {
                        // Affichage contextuel par chapitres (Menu Cours)
                        data.pathoChapters.forEach((chap, index) => {
                            const isExpanded = (idChapitre != 0 && index === 0);
                            const displayStyle = isExpanded ? 'display: block;' : 'display: none;';
                            const arrowStyle = isExpanded ? 'transform: rotate(90deg);' : '';
                            const headerStyle = isExpanded ? 'background: #f1f4f9;' : '';

                            // 1. Anatomie cours complet - Utilise chap.IdChapterRappel
                            html += `
                                <li class="patho-chapter-item">
                                    <div class="patho-chapter-header" onclick="toggleFeaturedPathoAccordion(this)" 
                                         style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-bottom: 1px solid #eee; cursor: pointer; font-size: 13px; color: #333; transition: background 0.2s; ${headerStyle}">
                                        <span style="font-weight: 500;">${chap.TitreChapitre}</span>
                                        <span class="patho-arrow-feat" style="font-size: 12px; color: #1d3557; transition: transform 0.3s; ${arrowStyle}">▶</span>
                                    </div>
                                    <ul class="patho-sous-chap-list" style="${displayStyle} list-style: none; padding: 0; background: #fafafa; border-bottom: 1px solid #eee;">
                                        <li class="sous-chapitre-item" style="font-weight:bold; color:#1d3557; background-color:#dce6f1; border-left: 3px solid #1d3557;"
                                            onclick="window.location.href='${baseUrl}${lang}/livreCours/${chap.IdChapterRappel}'">
                                            Anatomie - Cours fondamental complet
                                        </li>`;

                            // 2. Anatomie version intégrale - Vérifie si le résumé existe
                            html += `
                                <li class="sous-chapitre-item" style="font-weight:bold; color:#457b9d; background-color:#e8f4f8; border-left: 3px solid #457b9d;"
                                    onclick="redirectToAnatomyResume('${chap.IdChapterRappel}', '${chap.NbreResumeRappel}', event)">
                                    Anatomie - synthèse structurée
                                </li>`;

                            // 3. Liste des pathologies réelles
                            if (chap.sousChaps && chap.sousChaps.length > 0) {
                                chap.sousChaps.forEach(sc => {
                                    html += `
                                        <li style="padding: 10px 15px; border-bottom: 1px solid #f1f5f9; list-style:none;">
                                            <span class="patho-item-title">${sc.TitreSousChapitre || 'Sans titre'}</span>
                                            <div class="patho-version-container">
                                                <a href="#" class="patho-version-link essential" 
                                                   onclick="selectSousChapitrePatho('${sc.IDSousChapitre}', '${chap.IDChapitre}', '${chap.IdChapterRappel}', event, 'essential', ${sc.FichierHTML ? 'true' : 'false'})">
                                                    <span>Version essentielle</span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                                <a href="#" class="patho-version-link integral" 
                                                   onclick="selectSousChapitrePatho('${sc.IDSousChapitre}', '${chap.IDChapitre}', '${chap.IdChapterRappel}', event, 'integral', ${sc.FichierHTML_Resume ? 'true' : 'false'})">
                                                    <span>Version intégrale</span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
                                        </li>`;
                                });
                            } else {
                                html += `<li style="padding: 10px 20px; font-style: italic; font-size: 12px; color: #888;">Aucune pathologie</li>`;
                            }
                            html += `</ul></li>`;
                        });
                    }
                    
                    html += `</ul>`;
                    container.innerHTML = html;
                } else {
                    container.innerHTML = `<div style="padding:15px; color:#d62828; text-align:center; font-weight:bold;">${data.message || 'Aucune pathologie liée'}</div>`;
                }
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<div style="padding:15px; color:#d62828; text-align:center;">Erreur de chargement.</div>`;
            });
        }

        function toggleFeaturedPathoAccordion(header) {
            const content = header.nextElementSibling;
            const arrow = header.querySelector('.patho-arrow-feat');
            const isOpen = content.style.display === 'block';
            
            // Fermer les autres chapitres dans le même menu
            header.parentElement.parentElement.querySelectorAll('.patho-sous-chap-list').forEach(list => {
                list.style.display = 'none';
                list.previousElementSibling.querySelector('.patho-arrow-feat').style.transform = 'rotate(0deg)';
                list.previousElementSibling.style.background = 'white';
            });
            
            if (!isOpen) {
                content.style.display = 'block';
                arrow.style.transform = 'rotate(90deg)';
                header.style.background = '#f1f4f9';
            }
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
                        : `${baseUrl}${lang}livreFigures/${idChapitre}`;
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

            if (type_sel === 'pathologie') {
                toggleSousChapitresPatho(idChapitre, chapterElement);
                const diffBox = document.getElementById("difficultyBox");
                loadFeaturedPatho(idChapitre, diffBox);
                return;
            }

            document.getElementById("listChapTooltip").style.display = 'none';

            window.location.href = redirectUrl;
        }

        function toggleSousChapitresPatho(idChapitre, chapterElement) {
            const sousChapList = document.getElementById(`sous-chap-${idChapitre}`);
            const arrow = chapterElement.querySelector('.patho-arrow');
            const isVisible = sousChapList.style.display === 'block';

            // Fermer les autres
            document.querySelectorAll('.sous-chapitres-list').forEach(list => {
                if (list !== sousChapList) {
                    list.style.display = 'none';
                    const parentItem = list.closest('.chapter-item');
                    if (parentItem) {
                        const otherArrow = parentItem.querySelector('.patho-arrow');
                        if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                    }
                }
            });

            if (isVisible) {
                sousChapList.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                sousChapList.style.display = 'block';
                arrow.style.transform = 'rotate(90deg)';
                
                if (sousChapList.innerHTML.trim() === "") {
                    sousChapList.innerHTML = '<li class="loading-sous-chapitres" style="padding: 10px; font-style: italic;">Chargement...</li>';
                    
                    fetch("<?php echo base_url(); ?>home/getPathologieByRappel", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ idChap: idChapitre })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.type === 'chapters' && data.pathoChapters.length > 0) {
                            const firstPathoChap = data.pathoChapters[0];
                            // On passe l'ID d'anatomie (idChapitre) ET l'ID de pathologie (firstPathoChap.IDChapitre)
                            afficherSousChapitresPatho(sousChapList, firstPathoChap.sousChaps, firstPathoChap.IDChapitre, idChapitre);
                        } else if (data.success && data.type === 'books') {
                             sousChapList.innerHTML = `<li class="sous-chapitre-item" onclick="window.location.href='<?php echo base_url(); ?><?php echo strtoupper($this->uri->segment(1)); ?>/livre/${data.pathoBooks[0].IDLivre}'">Voir pathologies</li>`;
                        } else {
                            sousChapList.innerHTML = `<li class="sous-chapitre-item" style="color: #d62828;">${data.message || 'Aucune pathologie liée'}</li>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        sousChapList.innerHTML = '<li class="sous-chapitre-item">Erreur de chargement</li>';
                    });
                }
            }
        }

        function afficherSousChapitresPatho(container, sousChaps, idChapitre, idAnatomy = null) {
            let html = '';
            let finalIdAnatomy = idAnatomy || idChapitre;
            
            const lang = '<?php echo strtoupper($this->uri->segment(1)); ?>';
            const baseUrl = '<?php echo base_url(); ?>';

            // Anatomie cours complet - Utilise chargerRappelDefaut (comme v1_racourci_pathologie)
            html += `
                <li class="sous-chapitre-item rappel-item" 
                    style="font-weight:bold; color:#1d3557; background-color:#dce6f1; cursor:pointer;"
                    onclick="chargerRappelDefaut('${finalIdAnatomy}', event)">
                    Anatomie - Cours fondamental complet
                </li>
            `;

            // Anatomie synthèse structurée - Utilise redirectToAnatomyResume (comme v1_racourci_pathologie)
            // On a besoin du NbreResume, on va le passer à 0 par défaut (sera géré dans la fonction)
            html += `
                <li class="sous-chapitre-item rappel-manuel-item" 
                    style="font-weight:bold; color:#457b9d; background-color:#e8f4f8; cursor:pointer;"
                    onclick="redirectToAnatomyResume('${finalIdAnatomy}', '0', event)">
                    Anatomie - synthèse structurée
                </li>
            `;

            html += `
                <li class="pathologies-accordion">
                    <div class="pathologies-header" onclick="togglePathologiesInternal(event, this)">
                        <span>Pathologies</span>
                        <span class="accordion-arrow expanded">▶</span>
                    </div>

                    <ul class="pathologies-content expanded">
            `;

            if (!sousChaps || sousChaps.length === 0) {
                html += `
                        <li class="loading-sous-chapitres" style="padding: 10px;">
                            Aucun sous-chapitre
                        </li>
                `;
            } else {
                sousChaps.forEach(sc => {
                    html += `
                        <li style="padding: 10px 15px; border-bottom: 1px solid #f1f5f9; list-style:none;">
                            <span class="patho-item-title">${sc.TitreSousChapitre || 'Sans titre'}</span>
                            <div class="patho-version-container">
                                <a href="#" class="patho-version-link essential" 
                                   onclick="selectSousChapitrePatho('${sc.IDSousChapitre}', '${idChapitre}', '${finalIdAnatomy}', event, 'essential', ${sc.FichierHTML ? 'true' : 'false'})">
                                    <span>Version essentielle</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                <a href="#" class="patho-version-link integral" 
                                   onclick="selectSousChapitrePatho('${sc.IDSousChapitre}', '${idChapitre}', '${finalIdAnatomy}', event, 'integral', ${sc.FichierHTML_Resume ? 'true' : 'false'})">
                                    <span>Version intégrale</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </li>
                    `;
                });
            }

            html += `
                    </ul>
                </li>
            `;

            container.innerHTML = html;
        }

        function togglePathologiesInternal(event, headerElement) {
            event.stopPropagation();
            const content = headerElement.nextElementSibling;
            const arrow = headerElement.querySelector('.accordion-arrow');
            
            content.classList.toggle('expanded');
            arrow.classList.toggle('expanded');
        }

        function selectSousChapitrePatho(idSousChap, idChap, idChapRappel, event, version = 'essential', hasContent = true) {
            if (event && typeof event.stopPropagation === 'function') {
                event.stopPropagation();
            }
            if (event && event.preventDefault) event.preventDefault();

            document.querySelectorAll('.patho-version-link').forEach(el => el.classList.remove('selected'));

            const baseUrl = "<?php echo base_url(); ?>";
            const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";

            // Si le contenu n'existe pas, rediriger vers livreFigures du chapitre rappel
            if (!hasContent) {
                const tooltip = document.getElementById("listChapTooltip");
                if (tooltip) tooltip.style.display = 'none';
                
                window.location.href = `${baseUrl}${lang}/livreFigures/${idChapRappel}`;
                return;
            }
            
            
            fetch(`${baseUrl}home/getContentSousChapitre`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idChap: idChap, idSousChap: idSousChap })
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau: ' + response.status);
                return response.json();
            })
            .then(data => {
                const tooltip = document.getElementById("listChapTooltip");
                if (tooltip) tooltip.style.display = 'none';

                console.log("🔹 Données du sous-chapitre :", data);

                const targetFile = (version === 'essential') ? data.FichierHTML : data.FichierHTML_Resume;
                
                if (targetFile) {
                    const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";
                    const redirectUrl = `${baseUrl}${lang}/PlatFormeConvert/${targetFile}`;
                    console.log("🔸 Redirection vers :", redirectUrl);
                    window.location.href = redirectUrl;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Contenu indisponible',
                        text: `La ${version === 'essential' ? 'version essentielle' : 'version intégrale'} de cette pathologie n'est pas disponible.`
                    });
                }
            })
            .catch(err => {
                console.error('❌ Erreur lors de la récupération du sous-chapitre:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de chargement',
                    text: 'Impossible de charger le contenu du sous-chapitre.'
                });
            });
        }



        // === FONCTION POUR CHARGER LE RAPPEL PAR DÉFAUT ===
        function chargerRappelDefaut(idChapterRappel, event) {
            if (event) event.stopPropagation();

            if (!idChapterRappel || isNaN(idChapterRappel)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aucun rappel disponible',
                    text: 'Ce chapitre n\'a pas de cours de rappel par défaut.'
                });
                return;
            }

            const baseUrl = "<?php echo base_url(); ?>";
            const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";
            const coursContainer = document.querySelector('.bloc-cours');

            // CAS 1 : PAS dans la page cours - redirection
            if (!coursContainer) {
                window.location.href = `${baseUrl}${lang}/livreCours/${idChapterRappel}`;
                return;
            }

            // CAS 2 : DANS le bloc cours - chargement AJAX
            const originalContent = coursContainer.innerHTML;

            coursContainer.innerHTML = `
                <div style="text-align:center; padding:50px;">
                    <i class="fas fa-spinner fa-spin" style="font-size:40px; color:#1d3557;"></i>
                    <p style="margin-top:15px;">Chargement du rappel anatomique...</p>
                </div>
            `;

            fetch(`${baseUrl}home/getRappelCoursContent`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idChapterRappel })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.content) {
                    coursContainer.innerHTML = data.content;
                    coursContainer.scrollTop = 0;
                    // Restaurer les figures originales dans la barre latérale
                    if (typeof restaurerFiguresOriginales === 'function') {
                        restaurerFiguresOriginales();
                    }
                } else {
                    coursContainer.innerHTML = originalContent;
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Impossible de charger le rappel anatomique.'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                coursContainer.innerHTML = originalContent;
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible de charger le rappel anatomique.'
                });
            });
        }

        // Chargement du résumé d'anatomie avec vérification
        function redirectToAnatomyResume(idChapitre, nbreResume, event) {
            if (event) event.stopPropagation();
            
            if (!idChapitre || idChapitre === '0' || idChapitre === '') {
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: 'Aucun cours d\'anatomie n\'est lié à ce chapitre.'
                });
                return;
            }

            const baseUrl = "<?php echo base_url(); ?>";
            const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";
            const coursContainer = document.querySelector('.bloc-cours');

            // CAS 1 : On est dans la page PlatFormeConvert (avec bloc-cours) - Chargement AJAX
            if (coursContainer) {
                const originalContent = coursContainer.innerHTML;
                
                coursContainer.innerHTML = `
                    <div style="text-align:center; padding:50px;">
                        <i class="fas fa-spinner fa-spin" style="font-size:40px; color:#1d3557;"></i>
                        <p style="margin-top:15px;">Chargement de la synthèse structurée...</p>
                    </div>
                `;

                fetch(`${baseUrl}home/getRappelResumeContent`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ idChapterRappel: idChapitre })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.content) {
                        coursContainer.innerHTML = data.content;
                        coursContainer.scrollTop = 0;
                        
                        // Message de confirmation
                        if (data.hasResume) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Synthèse chargée',
                                text: 'La synthèse structurée a été chargée avec succès.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        coursContainer.innerHTML = originalContent;
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: data.message || 'Impossible de charger le résumé.'
                        });
                    }
                })
                .catch(err => {
                    console.error('Erreur:', err);
                    coursContainer.innerHTML = originalContent;
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Impossible de charger le résumé.'
                    });
                });
                
                return;
            }

            // CAS 2 : Page normale (sans bloc-cours) - Redirection classique
            if (parseInt(nbreResume) > 0) {
                window.location.href = `${baseUrl}${lang}/livreResume/${idChapitre}`;
            } else {
                window.location.href = `${baseUrl}${lang}/livreFigures/${idChapitre}`;
            }
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
