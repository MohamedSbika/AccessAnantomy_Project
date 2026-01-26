\u003cscript>
// ========== FONCTIONS GESTION IMAGES RAPPEL ANATOMIQUE ==========

function openImageRappelModal(idChapitre) {
    document.getElementById('rappelChapitreImage').value = idChapitre;
    const rappelImageInput = document.getElementById('rappelImage');
    if (rappelImageInput) {
        rappelImageInput.value = '';
        rappelImageInput.removeAttribute('required');
    }
    document.getElementById('previewRappelImage').style.display = 'none';
    
    // Charger les images existantes
    loadRappelImages(idChapitre);
    
    $('#addImageRappelModal').modal('show');
}

function loadRappelImages(idChapitre) {
    const baseUrl = "\u003c?php echo base_url(); ?>";
    
    fetch(`${baseUrl}home/getRappelImages`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapter: idChapitre })
    })
    .then(r => r.json())
    .then(data => {
        const container = document.getElementById('imagesContainer');
        
        if (data.success && data.data.length > 0) {
            let html = '';
            data.data.forEach(img => {
                html += `
                    \u003cdiv style="position: relative; width: 150px;">
                        \u003cimg src="data:image/jpeg;base64,${img.ImageData}" 
                             style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                        \u003cbutton type="button" 
                                onclick="deleteRappelImageItem(${img.IDImageRappel}, ${idChapitre})"
                                style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer;">
                            ×
                        \u003c/button>
                        \u003cp style="color: white; font-size: 11px; margin-top: 5px; text-align: center;">${img.NomImage}\u003c/p>
                    \u003c/div>
                `;
            });
            container.innerHTML = html;
        } else {
            container.innerHTML = '\u003cp style="color: white;">Aucune image pour ce chapitre\u003c/p>';
        }
    })
    .catch(err => {
        console.error('Erreur chargement images:', err);
        document.getElementById('imagesContainer').innerHTML = '\u003cp style="color: red;">Erreur de chargement\u003c/p>';
    });
}

function previewImageRappel(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('previewRappelImage');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function saveRappelImage() {
    const form = document.getElementById('formRappelImage');
    const formData = new FormData(form);
    const idChapitre = document.getElementById('rappelChapitreImage').value;
    
    if (!document.getElementById('rappelImage').files[0]) {
        Swal.fire({
            icon: 'warning',
            title: 'Aucune image sélectionnée',
            text: 'Veuillez sélectionner une image'
        });
        return;
    }
    
    Swal.fire({
        title: 'Envoi en cours...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        type: 'POST',
        url: '\u003c?php echo base_url(); ?>home/saveRappelImage',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            const result = JSON.parse(response);
            
            if (result[0].id == '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: result[0].desc
                }).then(() => {
                    // Recharger les images
                    loadRappelImages(idChapitre);
                    // Réinitialiser le formulaire
                    form.reset();
                    document.getElementById('previewRappelImage').style.display = 'none';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: result[0].desc
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Erreur lors de l\'envoi'
            });
        }
    });
}

function deleteRappelImageItem(idImage, idChapitre) {
    Swal.fire({
        title: 'Confirmer la suppression?',
        text: 'Cette action est irréversible',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('\u003c?php echo base_url(); ?>home/deleteRappelImage', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idImage: idImage })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé',
                        text: data.message
                    }).then(() => {
                        loadRappelImages(idChapitre);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                console.error('Erreur:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur lors de la suppression'
                });
            });
        }
    });
}
\u003c/script>
