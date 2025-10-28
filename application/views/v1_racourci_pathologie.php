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
        top: 110px;
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

    .carreaux.selected,
    .carreaux:hover {
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

    .title_carr {
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

        .chapter-list {
            max-height: 70vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #1d3557 #f0f0f0;
        }

    .tooltip-chapitre .chapter-item {
        padding: 8px 10px;
        font-size: 13px;
        border-bottom: 1px solid #cccccc4f;
        cursor: pointer;
        transition: background 0.2s;
        color: #2c2c2c;
        text-align: left;
        position: relative;
    }

    .tooltip-chapitre .chapter-item:hover {
        background-color: #f2f4f8;
    }

    /* Styles pour l'accordéon */
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
    display: block; /* au lieu de flex s’il y avait du flex hérité */
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
        position: relative; /* au lieu d’absolute */
        list-style: none;
        padding-left: 20px; /* pour un léger retrait, bien aligné sous le titre */
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

    /* Loader pour les sous-chapitres */
    .loading-sous-chapitres {
        padding: 8px;
        text-align: center;
        font-size: 11px;
        color: #666;
        font-style: italic;
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
            <li class="chapter-item <?= $selected; ?>" id="curs_<?= $value['IDChapitre']; ?>"
                data-id="<?= $value['IDChapitre']; ?>" data-curs="<?= $value['NbreCours']; ?>"
                data-resum="<?= $value['NbreResume']; ?>">
                <div class="chapter-item-header"
                    onclick="toggleSousChapitres(<?= $value['IDChapitre']; ?>, this.querySelector('.accordion-arrow'), event)">
                    <div class="chapter-item-title">
                        <?= htmlspecialchars($value['TitreChapitre']); ?>
                    </div>
                    <span class="accordion-arrow">
                        ▶
                    </span>
                </div>

                <ul class="sous-chapitres-list" id="sous-chap-<?= $value['IDChapitre']; ?>">
                    <!-- Les sous-chapitres seront chargés ici dynamiquement -->
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
                <span class="carreaux" style="background-color:#657379 ;color: white;" id="fullscreen_btn"
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

                <span class="carreaux" style="background-color: #1E88E5;color: white"
                    onclick="selectUniqueCarreau(this,'e_a')"
                    title="<?php echo $this->lang->line('sidebar_ad_tooltip'); ?>">
                    <div class="title_carr"><?php echo $this->lang->line('sidebar_cours'); ?></div>
                    <i class="fa fa-play-circle"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<?php include('v1_modal_test_calque.php'); ?>

<script>
    // Cache pour éviter de recharger les sous-chapitres
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

        // Fermer si déjà ouvert
        if (isExpanded) {
            sousChapList.classList.remove('expanded');
            arrowElement.classList.remove('expanded');
            return;
        }

        // Vérifier si déjà en cache
        if (sousChapitresCache[idChapitre]) {
            afficherSousChapitres(sousChapList, sousChapitresCache[idChapitre]);
            sousChapList.classList.add('expanded');
            arrowElement.classList.add('expanded');
            return;
        }

        // Afficher un loader
        sousChapList.innerHTML = '<li class="loading-sous-chapitres">Chargement...</li>';
        sousChapList.classList.add('expanded');
        arrowElement.classList.add('expanded');

        // Charger via AJAX
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

    // Fonction pour afficher les sous-chapitres
    function afficherSousChapitres(sousChapList, data) {
        if (!data || data.length === 0) {
            sousChapList.innerHTML = '<li class="loading-sous-chapitres">Aucun sous-chapitre</li>';
            return;
        }

        let html = '';
        data.forEach(sousChap => {
            html += `<li class="sous-chapitre-item" onclick="selectSousChapitre('${sousChap.IDSousChapitre}', '${sousChap.IDChapitre}', this, event)">
                ${sousChap.TitreSousChapitre || sousChap.desc || 'Sans titre'}
            </li>`;
        });
        sousChapList.innerHTML = html;
    }

// Sélection sous-chapitre
// Sélection sous-chapitre
function selectSousChapitre(idSousChapitre, idChapitre, element, event) {
    event.stopPropagation(); // Empêche la propagation au chapitre parent

    // Mettre à jour la sélection visuelle
    document.querySelectorAll('.sous-chapitre-item').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');

    // Vérifier si un type est sélectionné
    const type_sel = window.selectedType;
    if (!type_sel) {
        Swal.fire({
            icon: 'warning',
            title: 'Aucune action sélectionnée',
            text: 'Veuillez d\'abord sélectionner une action (par exemple, cours).'
        });
        return;
    }

    // Récupérer les informations du sous-chapitre via AJAX
    fetch(`<?php echo base_url(); ?>home/getContentSousChapitre`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChap: idChapitre, idSousChap: idSousChapitre })
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau: ' + response.status);
        return response.json();
    })
    .then(data => {
        // Cacher le tooltip
        document.getElementById("listChapTooltip").style.display = 'none';

        // Vérifier si FichierHTML existe
        const fichierHTML = data.FichierHTML || null;

        if (fichierHTML) {
            // Rediriger vers l'URL du fichier HTML avec le préfixe de langue
            const lang = '<?php echo $this->lang->line('siteLang'); ?>';
            const redirectUrl = `<?php echo base_url(); ?>${lang}/PlatFormeConvert/${fichierHTML}`;
            window.location.href = redirectUrl;
        } else {
            // Gérer le cas où FichierHTML est NULL
            Swal.fire({
                icon: 'warning',
                title: 'Aucun contenu disponible',
                text: 'Ce sous-chapitre n’a pas encore de fichier attaché.'
            });
            // Optionnel : rediriger vers une page par défaut
            // const lang = '<?php echo $this->lang->line('siteLang'); ?>';
            // const redirectUrl = `<?php echo base_url(); ?>${lang}/livreCours/${idChapitre}/${idSousChapitre}`;
            // window.location.href = redirectUrl;
        }
    })
    .catch(err => {
        console.error('Erreur lors de la récupération du sous-chapitre:', err);
        Swal.fire({
            icon: 'error',
            title: 'Erreur de chargement',
            text: 'Impossible de charger le contenu du sous-chapitre.'
        });
    });
}

    // Fermer si clic en dehors
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
</script>