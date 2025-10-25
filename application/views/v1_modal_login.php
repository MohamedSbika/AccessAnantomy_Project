<style>
	/* Style de base du modal */
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

	.modal-content {
		background-color: white;
		padding: 20px;
		border-radius: 8px;
		width: 90%;
		max-width: 400px;
		text-align: center;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		position: relative;
	}

	.close {
		position: absolute;
		top: 10px;
		right: 15px;
		font-size: 20px;
		cursor: pointer;
	}

	.modal-body input {
		width: 100%;
		padding: 12px;
		margin-top: 10px;
		border-radius: 4px;
		border: 1px solid #ccc;
		font-size: 14px;
		box-sizing: border-box;
	}

	.password-wrapper {
		position: relative;
	}

	.toggle-password {
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		width: 20px;
		height: 20px;
		fill: #555;
		transition: 0.2s ease;
	}

	.toggle-password:hover {
		fill: #000;
	}

	.btn-log {
		background-color: #007bff;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		font-size: 16px;
		width: 100%;
		margin-top: 10px;
	}

	@media (max-width: 600px) {
		.modal-content {
			width: 90%;
			padding: 15px;
		}
	}

	@media (max-width: 400px) {
		.modal-content {
			padding: 10px;
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
					<div class="password-wrapper">
						<input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
						<!-- Icône SVG œil -->
						<svg id="eyeIcon" class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path
								d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z" />
							<circle cx="12" cy="12" r="2.5" />
						</svg>
					</div>
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
	function openModalLogin() {
		document.getElementById("customModal").style.display = "flex";
	}
	function closeModal() {
		document.getElementById("customModal").style.display = "none";
	}
	window.onclick = function (event) {
		let modal = document.getElementById("customModal");
		if (event.target === modal) {
			closeModal();
		}
	};

	// 👁️ Fonction pour afficher / masquer le mot de passe
	function togglePassword() {
		const passwordInput = document.getElementById("password");
		const eyeIcon = document.getElementById("eyeIcon");

		if (passwordInput.type === "password") {
			passwordInput.type = "text";
			// Icône barrée
			eyeIcon.innerHTML =
				'<path d="M1 12s4-7 11-7c2.7 0 5.2 1.1 7.2 3l2.3-2.3 1.4 1.4-2.3 2.3C22 10.8 23 12 23 12s-4 7-11 7c-2.7 0-5.2-1.1-7.2-3l-2.3 2.3-1.4-1.4 2.3-2.3C2 13.2 1 12 1 12zm11 5a5 5 0 01-5-5c0-.9.2-1.7.6-2.4l6.8 6.8c-.7.4-1.5.6-2.4.6zm4.4-2.6l-6.8-6.8c.7-.4 1.5-.6 2.4-.6a5 5 0 015 5c0 .9-.2 1.7-.6 2.4z"/>';
		} else {
			passwordInput.type = "password";
			// Œil normal
			eyeIcon.innerHTML =
				'<path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/><circle cx="12" cy="12" r="2.5"/>';
		}
	}

	// Associer l’action au clic
	document.addEventListener("DOMContentLoaded", () => {
		document.getElementById("eyeIcon").addEventListener("click", togglePassword);
	});
</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		function validateForm() {
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;

			var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			if (!emailPattern.test(email)) {
				alert("Veuillez entrer un email valide.");
				return false;
			}

			if (password.trim() === "") {
				alert("Veuillez entrer un mot de passe.");
				return false;
			}

			return true;
		}

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
					success: function (response) {
						var data = typeof response === "string" ? JSON.parse(response) : response;
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
					error: function () {
						Swal.fire("Erreur", "Une erreur s'est produite. Veuillez réessayer.", "error");
					}
				});
			}
		});
	});
</script>
