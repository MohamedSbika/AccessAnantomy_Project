<style>
	/* Panneau vidéo flottant */
	.video-panel {
		position: absolute;
		display: none;
		top: 70px !important;
		left: 85px !important;
		z-index: 1000;
		width: 45%;
		background-color: white;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
		transition: transform 0.3s ease, opacity 0.3s ease;
		overflow: hidden;
		flex-direction: column; /* 👈 aligne header + body en colonne */
		height: 90vh;

	}

	/* Slide-in animation */
	.video-panel.slide-in {
		transform: translateX(0);
		opacity: 1;
	}

	.video-panel.hidden {
		transform: translateX(100%);
		opacity: 0;
	}

	/* En-tête */
	.panel-header {
		background: #f1f1f1;
		padding: 10px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		cursor: move;
		user-select: none;
	}

	.panel-title {
		font-size: 18px;
		font-weight: bold;
		color: #222;
	}

	.panel-actions button {
		background: none;
		border: none;
		font-size: 20px;
		cursor: pointer;
		margin-left: 5px;
	}

	/* Corps du panneau */
	.panel-body {
		padding: 15px;
		max-height: 80vh;
		overflow-y: auto;
	}

	/* Liste vidéos */
	.video-grid {
		display: grid;
		grid-template-columns: 1fr;
		gap: 15px;
	}

	.video-item {
		background-color: #f9f9f9;
		padding: 10px;
		border-radius: 8px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
	}

	.video-item video {
		width: 100%;
		border-radius: 6px;
	}

	.video-item h4 {
		margin: 10px 0 5px;
		color: #222;
	}

	.video-item p {
		color: #666;
		font-size: 14px;
	}

</style>

<!-- Modal -->
<!-- Panneau vidéo flottant -->
<div id="customModal_videos" class="video-panel">
	<div class="panel-header" id="modalHeader">
		<h2 class="modal-title"><?php echo $this->lang->line('lecture_synchro'); ?></h2>
		<div class="panel-actions">
			<button onclick="togglePanelSize()" id="toggleBtn">–</button>
			<button onclick="closeVideoPanel()">×</button>
		</div>
	</div>
	<div class="panel-body" id="videoPanelBody">
		<div id="videoListContainer">
			<!-- Contenu vidéo injecté ici -->
		</div>
	</div>
</div>

<script>

    function showVideoPanelNextToSidebar() {
        const panel 	= document.getElementById("customModal_videos");
        const sidebar 	= document.getElementById("sidebar-racc");
        const rect 		= sidebar.getBoundingClientRect();

        // Positionner à droite du sidebar
        // panel.style.top 	= `${window.scrollY + rect.top}px`;
        // panel.style.left 	= `${window.scrollX + rect.right}px`;
		//
        const sidebarRect = sidebar.getBoundingClientRect();
        panel.style.top = `${sidebarRect.top}px`;
        panel.style.left = `${sidebarRect.right + 20}px`;

        // Afficher avec effet slide
        panel.classList.add("slide-in");
        panel.classList.remove("hidden");
        panel.style.display = "block";
    }

    function closeVideoPanel() {
        const panel = document.getElementById("customModal_videos");
        panel.classList.remove("slide-in");
        setTimeout(() => {
            panel.style.display = "none";
        }, 300); // Attendre que la transition se termine
    }

    // Réduction/agrandissement du panneau
    function togglePanelSize() {
        const body = document.getElementById("videoPanelBody");
        const btn = document.getElementById("toggleBtn");
        if (body.style.display === "none") {
            body.style.display = "block";
            btn.textContent = "–";
        } else {
            body.style.display = "none";
            btn.textContent = "+";
        }
    }

    // Draggable
    const panel = document.getElementById("customModal_videos");
    const header = document.getElementById("modalHeader");
    let isDragging = false, offsetX = 0, offsetY = 0;

    header.addEventListener("mousedown", (e) => {
        isDragging = true;
        const rect = panel.getBoundingClientRect();
        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;
        document.body.style.userSelect = "none";
    });

    document.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        panel.style.left = `${e.clientX - offsetX}px`;
        panel.style.top = `${e.clientY - offsetY}px`;
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        document.body.style.userSelect = "auto";
    });

</script>
