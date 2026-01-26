
<!-- Modal -->
<div id="customModal" class="modal" style="display: none;">
	<div class="modal-content" style="background-color: white;
		width: 90%;	max-width: 390px; text-align: center;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);	position: relative;">
		<span class="close" onclick="closeModal()">&times;</span>
		<div class="modal-header" style="display: none">
			<h2 class="modal-title" style="color: black"></h2>
		</div>
		<div class="modal-body">

			<h3 style="font-size: 12px; color: #007bff; text-align: center; margin-top: 10px; padding: 1px;  border-left: 4px solid #007bff;
  					background-color: #f0f8ff;  border-radius: 4px;  width: 300px;">
				Utile pour la recherche approfondie, les thèses et les publications scientifiques
			</h3>

			<div style="display: flex; justify-content: center;margin-top: 20px">
				<button class="carreaux_lec" onclick="showCurs()">Voir la version détaillée</button>
			</div>

		</div>
	</div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openModalDetailsCurs() {
        document.getElementById("customModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("customModal").style.display = "none";
    }

    function showCurs(){

        let idChapitre = "<?php echo $this->session->userdata('curs_id'); ?>".replace(/^curs_/, "");
        let baseUrl 	= "<?php echo base_url(); ?>";
        let lang 		= "<?php echo $this->lang->line('siteLang'); ?>";
        let redirectUrl = `${baseUrl}${lang}livreCours/${idChapitre}`;

        window.location.href = redirectUrl;
	}

    window.onclick = function(event) {
        let modal = document.getElementById("customModal");
        if (event.target === modal) {
            closeModal();
        }
    };
</script>

