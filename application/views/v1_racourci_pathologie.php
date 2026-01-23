<style>
    .pathologies-accordion {
        margin: 5px 0;
        background-color: transparent;
        border-radius: 5px;
        overflow: hidden;
    }

    .pathologies-header {
        padding: 8px 15px;
        font-size: 13px;
        font-weight: normal;
        color: #2c2c2c;
        background-color: transparent;
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
        max-height: 500px;
        opacity: 1;
    }
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

    .chapter-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .chapter-item-title {
        flex: 1;
        cursor: pointer;
    }

    .chapter-item {
    display: block; 
    position: relative;
    }


    .accordion-arrow {
        font-size: 14px;
        transition: transform 0.3s ease;
        color: #1d3557;
        margin-left: 8px;
        cursor: pointer;
        padding: 5px;
        flex-shrink: 0;
    }

    .accordion-arrow.expanded {
        transform: rotate(90deg);
    }

    .sous-chapitres-list {
        position: relative; 
        list-style: none;
        padding-left: 20px; 
        margin: 5px 0 0 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.3s ease, margin 0.3s ease;
        opacity: 0;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .sous-chapitres-list.expanded {
        max-height: 600px;
        opacity: 1;
        margin-top: 5px;
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
    }

    .sous-chapitre-item:hover {
        background-color: #e3f2fd;
        border-left-color: #1d3557;
        color: #1d3557;
        transform: translateX(3px);
    }

    .sous-chapitre-item.selected {
        background-color: #d6e9f5;
        font-weight: bold;
        color: #1d3557;
    }

    .loading-sous-chapitres {
        padding: 8px;
        text-align: center;
        font-size: 11px;
        color: #666;
        font-style: italic;
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
            data-resum-rappel="<?= $value['NbreResumeRappel'] ?? 0; ?>">
            
            <div class="chapter-item-header"
                onclick="toggleSousChapitres(<?= $value['IDChapitre']; ?>, this.querySelector('.accordion-arrow'), event)">
                <div class="chapter-item-title">
                    <?= htmlspecialchars($value['TitreChapitre']); ?>
                </div>
                <span class="accordion-arrow">▶</span>
            </div>

            <ul class="sous-chapitres-list" id="sous-chap-<?= $value['IDChapitre']; ?>">
            </ul>
        </li>
    <?php } ?>
</ul>


</div>

<div class="sidebar-racc collapsed" id="sidebar-racc">
    <div class="toggle_bloc left" style="display: none">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <span class="s_plan_retour"
                style="display: block; width: 100%; text-align: center;padding-top: 30px;height: 35px;">
                <?php echo $this->lang->line('sidebar_plan'); ?>
            </span>
            <span class="arrow"
                style="display: block; width: 100%; text-align: center;height: 20px;padding-bottom: 33px;">&#8594;</span>
        </button>
    </div>

    <div style="display: flex;justify-content: space-between; align-items: flex-start; width: 100%;">
        <div id="listRacc">
            <div style="display: grid; flex-wrap: wrap; gap: 10px; justify-content: center;">
                <span class="carreaux" style="background-color: #657379 ;color: white;" id="fullscreen_btn"
                    onclick="toggleFullscreen(this)">
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
                        } else {
                            document.exitFullscreen();
                            icon.classList.replace("fa-compress", "fa-expand");
                            text.innerHTML = "<?php echo $this->lang->line('sidebar_agrandir'); ?>";
                        }
                    }
                </script>

<?php /*
<span class="carreaux" style="background-color: #1E88E5;color: white"
    onclick="selectUniqueCarreau(this,'e_a')"
    title="<?php echo $this->lang->line('sidebar_ad_tooltip'); ?>">
    <div class="title_carr"><?php echo $this->lang->line('sidebar_anatomie'); ?></div>
    <!--<i class="fa fa-notes-medical"></i>-->
</span>
*/ ?>

                <span class="carreaux" style="background-color: #207c51ff;color: white"
                    onclick="selectUniqueCarreau(this,'e_a')"
                    title="<?php echo $this->lang->line('sidebar_ad_tooltip'); ?>">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_pathologie'); ?></div>
                    <!--<i class="fa fa-virus"></i>-->
                </span>
            </div>
        </div>
    </div>
</div>

<?php include('v1_modal_test_calque.php'); ?>

<script>
    const sousChapitresCache = {};

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar-racc');
        const btn = document.querySelector('.toggle-btn');
        const arrow = btn.querySelector('.arrow');
        const s_plan_retour = btn.querySelector('.s_plan_retour');
        const toggleBloc = document.querySelector('.toggle_bloc');

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

        const sidebar = document.getElementById("sidebar-racc");
        const tooltip = document.getElementById("listChapTooltip");

        const sidebarRect = sidebar.getBoundingClientRect();
        tooltip.style.top = `${sidebarRect.top}px`;
        tooltip.style.left = `${sidebarRect.right + 10}px`;
        tooltip.style.minHeight = '50%';
        tooltip.style.maxHeight = '80%';
        tooltip.style.display = 'block';

        document.querySelectorAll('.carreaux').forEach(carreau => carreau.classList.remove('selected'));
        element.classList.add('selected');
    }

    // function selectUniqueChapter(chapterElement) {
    //     const idChapitre = chapterElement.getAttribute('data-id');
    //     const type_sel = window.selectedType;

    //     if (!type_sel) {
    //         alert("Veuillez d'abord sélectionner une action.");
    //         return;
    //     }

    //     document.querySelectorAll('.chapter-item').forEach(el => el.classList.remove('selected'));
    //     chapterElement.classList.add('selected');
    //     window.selectedChapterId = idChapitre;

    //     let baseUrl = "<?php echo base_url(); ?>";
    //     let lang = "<?php echo $this->lang->line('siteLang'); ?>";
    //     let redirectUrl = "";

    //     switch (type_sel) {
    //         case 'theme':
    //             redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
    //             break;
    //         case 'e_a':
    //             redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
    //             break;
    //         case 'calque':
    //             redirectUrl = `${baseUrl}${lang}listCalque/${idChapitre}`;
    //             break;
    //         case 'test':
    //             redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
    //             break;
    //         default:
    //             redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;
    //     }

    //     document.getElementById("listChapTooltip").style.display = 'none';
    //     window.location.href = redirectUrl;
    // }

    // Fonction pour charger et afficher les sous-chapitres
    function toggleSousChapitres(idChapitre, arrowElement, event) {
        event.stopPropagation(); // Empêche la sélection du chapitre

        const sousChapList = document.getElementById(`sous-chap-${idChapitre}`);
        const isExpanded = sousChapList.classList.contains('expanded');

        // Fermer tous les autres sous-chapitres
        document.querySelectorAll('.sous-chapitres-list.expanded').forEach(list => {
            if (list !== sousChapList) {
                list.classList.remove('expanded');
                const arrow = list.closest('.chapter-item').querySelector('.accordion-arrow');
                if (arrow) arrow.classList.remove('expanded');
            }
        });

        if (isExpanded) {
            sousChapList.classList.remove('expanded');
            arrowElement.classList.remove('expanded');
            return;
        }

        if (sousChapitresCache[idChapitre]) {
            afficherSousChapitres(sousChapList, sousChapitresCache[idChapitre]);
            sousChapList.classList.add('expanded');
            arrowElement.classList.add('expanded');
            return;
        }

        sousChapList.innerHTML = '<li class="loading-sous-chapitres">Chargement...</li>';
        sousChapList.classList.add('expanded');
        arrowElement.classList.add('expanded');

        fetch("<?php echo base_url(); ?>home/get_SousChapitres", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idChap: idChapitre })
        })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau: ' + response.status);
                return response.json();
            })
            .then(result => {
                const data = result.data ? result.data : result;
                sousChapitresCache[idChapitre] = data;
                afficherSousChapitres(sousChapList, data);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des sous-chapitres:', error);
                sousChapList.innerHTML = '<li class="loading-sous-chapitres" style="color: red;">Erreur de chargement</li>';
            });
    }
function afficherSousChapitres(sousChapList, data) {
    const chapterEl = sousChapList.closest('.chapter-item');
    const idChapter = chapterEl.getAttribute('data-id');
    const idChapterRappel = chapterEl.getAttribute('data-id-rappel');
    const nbreResumeRappel = chapterEl.getAttribute('data-resum-rappel') || 0;

    let html = '';
        
// Rappel Anatomique (par défaut) -> Version Essentielle?
html += `
    <li class="sous-chapitre-item rappel-item" 
        style="font-weight:bold; color:#1d3557; background-color:#dce6f1; cursor:pointer;"
        onclick="chargerRappelDefaut('${idChapterRappel || ''}', event)">
        Anatomie - Cours fondamental complet
    </li>
`;

// Rappel Manuel -> Version Intégrale?
const lang = '<?php echo strtoupper($this->uri->segment(1)); ?>';
const baseUrl = '<?php echo base_url(); ?>';

html += `
    <li class="sous-chapitre-item rappel-manuel-item" 
        style="font-weight:bold; color:#457b9d; background-color:#e8f4f8; cursor:pointer;"
        onclick="redirectToAnatomyResume('${idChapterRappel}', '${nbreResumeRappel}', event)">
        Anatomie - synthèse structurée
    </li>
`;
    html += `
        <li class="pathologies-accordion">
            <div class="pathologies-header" onclick="togglePathologies(event)">
                <span>Pathologies</span>
                <span class="accordion-arrow">▶</span>
            </div>

            <ul class="pathologies-content">
    `;

    if (!data || data.length === 0) {
        html += `
                <li class="loading-sous-chapitres">
                    Aucune pathologie trouvée
                </li>
        `;
    } else {
        data.forEach(sousChap => {
            html += `
                <li style="padding: 10px; border-bottom: 1px solid #f1f5f9; list-style:none;">
                    <span class="patho-item-title">${sousChap.TitreSousChapitre || 'Sans titre'}</span>
                    <div class="patho-version-container">
                        ${sousChap.FichierHTML ? `
                            <a href="#" class="patho-version-link essential" 
                               onclick="selectSousChapitre('${sousChap.IDSousChapitre}', '${sousChap.IDChapitre}', this, event, 'essential')">
                                <span>Version essentielle</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        ` : ''}
                        ${sousChap.FichierHTML_Resume ? `
                            <a href="#" class="patho-version-link integral" 
                               onclick="selectSousChapitre('${sousChap.IDSousChapitre}', '${sousChap.IDChapitre}', this, event, 'integral')">
                                <span>Version intégrale</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        ` : ''}
                        ${(!sousChap.FichierHTML && !sousChap.FichierHTML_Resume) ? '<span style="font-size: 10px; font-style: italic; color: #94a3b8;">Aucun contenu disponible</span>' : ''}
                    </div>
                </li>
            `;
        });
    }

    html += `
            </ul>
        </li>
    `;

    sousChapList.innerHTML = html;


    // setTimeout(() => {
    //     const rappelItem = sousChapList.querySelector('.rappel-item');
    //     if (rappelItem) {
    //         rappelItem.addEventListener('click', (e) => {
    //             e.stopPropagation();

    //             if (!idChapterRappel) {
    //                 Swal.fire({
    //                     icon: 'warning',
    //                     title: 'Aucun rappel disponible',
    //                     text: 'Ce chapitre n\'a pas de cours de rappel.'
    //                 });
    //                 return;
    //             }

    //             const lang = "<?php echo $this->lang->line('siteLang'); ?>";
    //             const baseUrl = "<?php echo base_url(); ?>";

    //             window.location.href = baseUrl + lang + "/livreCours/" + idChapterRappel;
    //         });
    //     }
    // }, 0);
}


function togglePathologies(event) {
    event.stopPropagation();

    const header = event.currentTarget;
    const content = header.nextElementSibling;
    const arrow = header.querySelector('.accordion-arrow');
    const isExpanded = content.classList.contains('expanded');

    // Fermer les autres pathologies ouvertes
    document.querySelectorAll('.pathologies-content.expanded').forEach(other => {
        if (other !== content) {
            other.classList.remove('expanded');
            const otherArrow = other.previousElementSibling.querySelector('.accordion-arrow');
            if (otherArrow) otherArrow.classList.remove('expanded');
        }
    });

    // Toggle
    if (isExpanded) {
        content.classList.remove('expanded');
        arrow.classList.remove('expanded');
    } else {
        content.classList.add('expanded');
        arrow.classList.add('expanded');
    }
}


// Sélection sous-chapitre
function selectSousChapitre(idSousChapitre, idChapitre, element, event, version = 'essential') {
    if (event && typeof event.stopPropagation === 'function') {
        event.stopPropagation();
    }
    if (event && event.preventDefault) event.preventDefault();

    document.querySelectorAll('.patho-version-link').forEach(el => el.classList.remove('selected'));
    if (element) element.classList.add('selected');

    const baseUrl = "<?php echo base_url(); ?>";

    fetch(`${baseUrl}home/getContentSousChapitre`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChap: idChapitre, idSousChap: idSousChapitre })
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

function selectSousChapitrePatho(idSousChap, idChap, event) {
    if (event && event.stopPropagation) event.stopPropagation();
    const baseUrl = "<?php echo base_url(); ?>";
    
    fetch(`${baseUrl}home/getContentSousChapitre`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChap: idChap, idSousChap: idSousChap })
    })
    .then(response => response.json())
    .then(data => {
        const tooltip = document.getElementById("listChapTooltip");
        if (tooltip) tooltip.style.display = 'none';

        if (data.FichierHTML) {
            const lang = "<?php echo strtoupper($this->uri->segment(1)); ?>";
            window.location.href = `${baseUrl}${lang}/PlatFormeConvert/${data.FichierHTML}`;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Aucun contenu disponible',
                text: 'Ce sous-chapitre n’a pas encore de fichier attaché.'
            });
        }
    })
    .catch(err => {
        console.error('Erreur:', err);
        Swal.fire({ icon: 'error', title: 'Erreur', text: 'Impossible de charger le contenu.' });
    });
}

    document.addEventListener("click", function (e) {
        const tooltip = document.getElementById("listChapTooltip");
        const sidebar = document.getElementById("sidebar-racc");

        if (!tooltip.contains(e.target) && !sidebar.contains(e.target)) {
            tooltip.style.display = "none";
        }
    });

    function goFullscreen() {
        var elem = document.documentElement;
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

    function updateScroll() {
        document.documentElement.style.setProperty('--scroll-y', window.scrollY + 'px');
    }
    window.addEventListener('scroll', updateScroll);

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

// === FONCTION POUR CHARGER LE RAPPEL MANUEL ===
function chargerRappelManuel(idChapter, event) {
    if (event) event.stopPropagation();

    if (!idChapter || isNaN(idChapter)) {
        Swal.fire({
            icon: 'warning',
            title: 'Aucun rappel manuel',
            text: 'Ce chapitre n\'a pas de rappel manuel pour le moment.'
        });
        return;
    }

    const baseUrl = "<?php echo base_url(); ?>";
    const coursContainer = document.querySelector('.bloc-cours');

    // CAS 1 : PAS dans la page cours
    if (!coursContainer) {
        // Vérifier s'il y a un rappel manuel
        fetch(`${baseUrl}home/getRappelCoursFile`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idChapterRappel: idChapter })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.fichier) {
                // Rappel manuel trouvé - charger le contenu en modal
                chargerRappelEnModal(data.fichier, baseUrl);
            } else {
                // Pas de rappel manuel
                Swal.fire({
                    icon: 'info',
                    title: 'Rappel manuel non disponible',
                    text: 'Il n\'y a pas de rappel manuel pour ce chapitre pour le moment.'
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de vérifier le rappel manuel.'
            });
        });
        return;
    }

    // CAS 2 : DANS le bloc cours
    const originalContent = coursContainer.innerHTML;

    coursContainer.innerHTML = `
        <div style="text-align:center; padding:50px;">
            <i class="fas fa-spinner fa-spin" style="font-size:40px; color:#1d3557;"></i>
            <p style="margin-top:15px;">Chargement du rappel anatomique...</p>
        </div>
    `;

    let hasContent = false;

    // 1. Charger le texte (HTML converti)
    fetch(`${baseUrl}home/getRappelAnatomiqueCours`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapterRappel: idChapter })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.content) {
            coursContainer.innerHTML = data.content;
            hasContent = true;
        } else {
            coursContainer.innerHTML = ''; // Nettoyer le spinner si pas de texte
        }
        
        // 2. Toujours essayer de charger les images
        return chargerImagesRappel(idChapter, coursContainer);
    })
    .then(imagesFound => {
        if (!hasContent && !imagesFound) {
            // Ni texte ni images trouvés
            coursContainer.innerHTML = originalContent;
            Swal.fire({
                icon: 'info',
                title: 'Rappel manuel non disponible',
                text: 'Il n\'y a ni texte ni image pour ce chapitre.'
            });
        } else {
            coursContainer.scrollTop = 0;
        }
    })
    .catch(err => {
        console.error(err);
        coursContainer.innerHTML = originalContent;
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Impossible de charger le rappel manuel.'
        });
    });
}

// Fonction pour charger et afficher les images du rappel
function chargerImagesRappel(idChapter, container) {
    const baseUrl = "<?php echo base_url(); ?>";
    
    return fetch(`${baseUrl}home/getRappelImages`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapter: idChapter })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            let imagesHtml = `
                <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                    <h3 style="color: #1d3557; margin-bottom: 15px; font-size: 1.2rem;">Images anatomiques</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            `;
            
            data.data.forEach(img => {
                imagesHtml += `
                    <div style="text-align: center; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <img src="data:image/jpeg;base64,${img.ImageData}" 
                             alt="${img.NomImage}"
                             style="width: 100%; height: auto; max-height: 400px; object-fit: contain; border-radius: 3px; cursor: pointer;"
                             onclick="afficherImageEnGrand(this.src, '${img.NomImage}')">
                        <p style="margin-top: 10px; font-size: 13px; color: #333; font-weight: 500;">${img.NomImage}</p>
                    </div>
                `;
            });
            
            imagesHtml += `
                    </div>
                </div>
            `;
            
            container.innerHTML += imagesHtml;

            // --- Nouveauté : Mettre à jour aussi la barre latérale droite (figures) ---
            // DÉSACTIVÉ : On garde les mêmes figures pour chapitre, sous-chapitre et résumé
            // updateFiguresSidebar(data.data);

            return true; // Images trouvées
        }
        return false; // Pas d'images
    })
    .catch(err => {
        console.error('Erreur chargement images rappel:', err);
        return false;
    });
}

// Fonction pour afficher une image en grand
function afficherImageEnGrand(src, nom) {
    Swal.fire({
        imageUrl: src,
        imageAlt: nom,
        title: nom,
        width: '80%',
        showCloseButton: true,
        showConfirmButton: false
    });
}

// Fonction pour charger le rappel en modal/overlay avec le layout visible
function chargerRappelEnModal(fichier, baseUrl) {
    // Fermer le modal existant s'il y en a un
    const existingModal = document.getElementById('rappel-modal');
    if (existingModal) existingModal.remove();

    // Créer une structure modal
    const modal = document.createElement('div');
    modal.id = 'rappel-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2000;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        overflow-y: auto;
        padding-top: 140px;
    `;
    document.body.appendChild(modal);

    // Fermer au clic en dehors
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });

    // Contenu du modal
    const content = document.createElement('div');
    content.style.cssText = `
        background-color: white;
        width: 65%;
        max-width: 1000px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        margin-left: 35%;
        margin-bottom: 50px;
    `;

    // Bouton fermer
    const closeBtn = document.createElement('button');
    // // closeBtn.innerHTML = '✕ Fermer';
    // closeBtn.style.cssText = `
    //     position: fixed;
    //     top: 120px;
    //     right: 30px;
    //     background-color: #1d3557;
    //     color: white;
    //     border: none;
    //     padding: 10px 20px;
    //     border-radius: 5px;
    //     cursor: pointer;
    //     font-size: 13px;
    //     font-weight: bold;
    //     z-index: 2001;
    //     transition: background-color 0.3s;
    // `;
    // closeBtn.onmouseover = function() {
    //     closeBtn.style.backgroundColor = '#457b9d';
    // };
    // closeBtn.onmouseout = function() {
    //     closeBtn.style.backgroundColor = '#1d3557';
    // };
    // closeBtn.onclick = function(e) {
    //     e.stopPropagation();
    //     modal.remove();
    // };
    document.body.appendChild(closeBtn);

    // Charger le fichier HTML
    fetch(`${baseUrl}PlatFormeConvert/${fichier}`)
        .then(r => r.text())
        .then(html => {
            // Extraire le body du fichier HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const bodyContent = doc.body.innerHTML;

            const innerContent = document.createElement('div');
            innerContent.style.cssText = `
                padding: 30px 20px;
                overflow-y: auto;
                max-height: 70vh;
            `;
            innerContent.innerHTML = bodyContent;

            content.appendChild(innerContent);
            modal.appendChild(content);
        })
        .catch(err => {
            console.error('Erreur chargement rappel:', err);
            closeBtn.remove();
            modal.remove();
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de charger le rappel.'
            });
        });
}

// ========== SYNCHRONISATION BARRE LATÉRALE FIGURES ==========

var originalFiguresState = null;

function updateFiguresSidebar(images) {
    const container = document.getElementById('figures-scroll-container');
    if (!container) return;

    // Sauvegarder l'état original une seule fois
    if (!originalFiguresState) {
        originalFiguresState = {
            html: container.innerHTML,
            images: (typeof figImages !== 'undefined') ? [...figImages] : [],
            titles: (typeof figTitles !== 'undefined') ? [...figTitles] : []
        };
    }

    // Préparer les nouvelles données
    let newHtml = '';
    let newImages = [];
    let newTitles = [];

    images.forEach((img) => {
        let base64Src = `data:image/jpeg;base64,${img.ImageData}`;
        newImages.push(base64Src);
        newTitles.push(img.NomImage);

        newHtml += `
            <div class="image-container" style="position: relative; display: inline-block; text-align: center; padding-bottom: 7px;">
                <img src="${base64Src}" 
                     data-name="${img.NomImage}"
                     style="width: 60px; height: 60px; border: 0.1px solid #ccc; object-fit: contain;" 
                     class="slider-image zoomable" 
                     onclick="showFig(this);">
                <div><a href="#" class="btn" style="font-size: .75rem;">${img.NomImage}</a></div>
            </div>
        `;
    });

    container.innerHTML = newHtml;
    
    // Mettre à jour les variables globales de v1_bloc_figures.php
    if (typeof figImages !== 'undefined') figImages = newImages;
    if (typeof figTitles !== 'undefined') figTitles = newTitles;

    // Afficher la première image
    if (typeof showFigByIndex === 'function' && newImages.length > 0) {
        if (typeof currentIndex !== 'undefined') currentIndex = 0;
        showFigByIndex(0);
    }
}

function restaurerFiguresOriginales() {
    const container = document.getElementById('figures-scroll-container');
    if (container && originalFiguresState) {
        container.innerHTML = originalFiguresState.html;
        if (typeof figImages !== 'undefined') figImages = [...originalFiguresState.images];
        if (typeof figTitles !== 'undefined') figTitles = [...originalFiguresState.titles];
        
        if (typeof showFigByIndex === 'function' && figImages.length > 0) {
            if (typeof currentIndex !== 'undefined') currentIndex = 0;
            showFigByIndex(0);
        }
    }
}

</script>