<style>
	/* Style de base du modal (caché par défaut) */
	.modal {
		display: none;
		position: fixed;
		z-index: 1000;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* Contenu du modal */
	.modal-content {
		background-color: white;
		padding: 20px;
		border-radius: 8px;
		width: 90%;
		/* Prend 90% de la largeur de l'écran */
		max-width: 400px;
		/* Limite la largeur à 400px */
		text-align: center;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		position: relative;
	}

	/* Bouton de fermeture */
	.close {
		position: absolute;
		top: 10px;
		right: 15px;
		font-size: 20px;
		cursor: pointer;
	}

	/* Styles pour le formulaire */
	.modal-body input {
		width: 100%;
		/* Les inputs prendront toute la largeur disponible */
		padding: 12px;
		/* Plus de padding pour un meilleur confort */
		margin-top: 10px;
		border-radius: 4px;
		border: 1px solid #ccc;
		font-size: 14px;
		box-sizing: border-box;
		/* Inclut le padding dans la largeur totale */
	}

	/* Bouton de connexion */
	.btn-log {
		background-color: #007bff;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		font-size: 16px;
		width: 100%;
		/* Le bouton occupe toute la largeur disponible */
		margin-top: 10px;
	}

	/* Styles sur les petites tailles d'écran (mobile) */
	@media (max-width: 600px) {
		.modal-content {
			width: 90%;
			/* Prend 90% de la largeur pour les petits écrans */
			padding: 15px;
		}

		.modal-header h2 {
			font-size: 18px;
		}

		.modal-body input {
			padding: 10px;
			font-size: 14px;
			/* Ajuste la taille de la police sur mobile */
		}

		.btn-log {
			padding: 12px 0;
			font-size: 16px;
		}
	}

	/* Sur les très petits écrans, réduire encore la taille du formulaire */
	@media (max-width: 400px) {
		.modal-content {
			padding: 10px;
		}

		.modal-body input {
			padding: 8px;
			font-size: 13px;
			/* Réduit la taille des champs */
		}

		.btn-log {
			font-size: 14px;
		}
	}
</style>

<!-- Modal -->
<div id="customModal" class="modal" style="display: none;">
	<div class="modal-content">
		<span class="close" onclick="closeModal()">&times;</span>
		<div class="modal-header">
			<h2 class="modal-title" style="color: black">Authentification requise</h2>
		</div>
		<div class="modal-body">
			<form id="loginform" name="loginformA" method="post">
				<input type="hidden" value="0" id="redirectLog">
				<div id="user_message_error" class="alert alert-danger" style="display: none;">
					Une erreur est survenue.
				</div>
				<div class="mb-2">
					<label>Email</label>
					<input type="email" name="email" id="email" placeholder="Votre email" required>
				</div>
				<div class="mb-3">
					<label>Mot de passe</label>
					<input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
				</div>
				<div class="text-center mt-3">
					<button type="submit" class="btn-log">Se connecter</button>
				</div>
			</form>

		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	// Fonction pour ouvrir le modal
	function openModalLogin() {
		document.getElementById("customModal").style.display = "flex";
	}

	// Fonction pour fermer le modal
	function closeModal() {
		document.getElementById("customModal").style.display = "none";
	}

	// Ferme le modal en cliquant à l'extérieur
	window.onclick = function (event) {
		let modal = document.getElementById("customModal");
		if (event.target === modal) {
			closeModal();
		}
	};
</script>
<script>
	document.addEventListener("DOMContentLoaded", function () {

		// Fonction pour valider le formulaire
		function validateForm() {
			// Récupérer les valeurs des champs
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;

			// Vérifier si l'email est valide
			var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			if (!emailPattern.test(email)) {
				alert("Veuillez entrer un email valide.");
				return false;
			}

			// Vérifier si le mot de passe est vide
			if (password.trim() === "") {
				alert("Veuillez entrer un mot de passe.");
				return false;
			}

			// Si tout est valide, retourner true
			return true;
		}

		// Gestionnaire d'événement pour l'envoi du formulaire
		document.getElementById("loginform").addEventListener("submit", function (e) {
			e.preventDefault();

			if (validateForm()) {
				$("#user_message_error").hide();

				Swal.fire({
					title: "Connexion en cours...",
					didOpen: () => Swal.showLoading()
				});

				var formData = new FormData(document.getElementById("loginform"));

$.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>home/login_process",
    data: formData,
    processData: false,
    contentType: false,
    xhrFields: { withCredentials: true },
    timeout: 30000,
    success: function(response) {
        console.log("Réponse brute :", response);

        var data = typeof response === "string" ? JSON.parse(response) : response;
        console.log("Objet JSON parsé :", data);

        console.log("Cookies avant redirection :", document.cookie);

        if (data && data.length > 0 && parseInt(data[0]["id"]) === 1) {
            Swal.fire({
                icon: 'success',
                title: 'Connexion réussie !',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
            window.location.href = window.location.href;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: data && data[0]["desc"] ? data[0]["desc"] : "Erreur de connexion",
                showConfirmButton: true
            });
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX ERROR :", status, error);
        console.log("ResponseText :", xhr.responseText);
        Swal.fire("Erreur", "Une erreur s'est produite. Veuillez réessayer.", "error");
    },
    complete: function(xhr, status) {
        console.log("AJAX COMPLETE, status :", status);
    }
});

			}
		});

	});
</script>