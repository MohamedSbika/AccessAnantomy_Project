# INSTRUCTIONS FINALES - Gestion d'images rappel anatomique

## ✅ Ce qui a été fait automatiquement

1. **Backend (Home.php)** - 3 fonctions ajoutées (lignes 8521-8660):
   - `saveRappelImage()`
   - `getRappelImages()`
   - `deleteRappelImage()`

2. **Modal dans livreDetails.php** - Modifié pour inclure:
   - Section "Images existantes"
   - Formulaire d'ajout avec aperçu

## 📝 À FAIRE MANUELLEMENT

### Étape 1: Créer la table SQL

Exécutez cette requête SQL dans votre base de données:

```sql
CREATE TABLE IF NOT EXISTS `_rappel_anatomique_images` (
  `IDImageRappel` int(11) NOT NULL AUTO_INCREMENT,
  `IDChapitre` int(11) NOT NULL,
  `NomImage` varchar(255) NOT NULL,
  `CheminImage` text NOT NULL,
  `ImageData` longtext,
  `OrdreAffichage` int(11) DEFAULT 1,
  `DateAjout` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDImageRappel`),
  KEY `IDChapitre` (`IDChapitre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Étape 2: Ajouter les fonctions JavaScript dans livreDetails.php

**OUVREZ** `c:\xampp\7.4\htdocs\public_html\application\views\livreDetails.php`

**TROUVEZ** la ligne 5502 qui contient: `\u003c?php } ?>`

**AJOUTEZ JUSTE AVANT** cette ligne, le code suivant:

```html
\u003cscript>
// ========== FONCTIONS GESTION IMAGES RAPPEL ANATOMIQUE ==========

function openImageRappelModal(idChapitre) {
    document.getElementById('rappelChapitreImage').value = idChapitre;
    const rappelImageInput = document.getElementById('rappelImage');
    if (rappelImageInput) {
        rappelImageInput.value = '';
    }
    document.getElementById('previewRappelImage').style.display = 'none';
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
                    loadRappelImages(idChapitre);
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
```

### Étape 3: Modifier v1_racourci_pathologie.php

**OUVREZ** `c:\xampp\7.4\htdocs\public_html\application\views\v1_racourci_pathologie.php`

**TROUVEZ** la ligne 858 qui contient:
```javascript
coursContainer.innerHTML = data.content;
```

**REMPLACEZ** par:
```javascript
coursContainer.innerHTML = data.content;

// Charger et afficher les images
chargerImagesRappel(idChapter, coursContainer);
```

**PUIS AJOUTEZ** ces deux fonctions après la fonction `chargerRappelManuel` (après la ligne 879):

```javascript
// Fonction pour charger et afficher les images du rappel
function chargerImagesRappel(idChapter, container) {
    const baseUrl = "\u003c?php echo base_url(); ?>";
    
    fetch(`${baseUrl}home/getRappelImages`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idChapter: idChapter })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            let imagesHtml = `
                \u003cdiv style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                    \u003ch3 style="color: #1d3557; margin-bottom: 15px;">Images anatomiques\u003c/h3>
                    \u003cdiv style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
            `;
            
            data.data.forEach(img => {
                imagesHtml += `
                    \u003cdiv style="text-align: center;">
                        \u003cimg src="data:image/jpeg;base64,${img.ImageData}" 
                             alt="${img.NomImage}"
                             style="width: 100%; height: auto; border-radius: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer;"
                             onclick="afficherImageEnGrand(this.src, '${img.NomImage}')">
                        \u003cp style="margin-top: 8px; font-size: 12px; color: #666;">${img.NomImage}\u003c/p>
                    \u003c/div>
                `;
            });
            
            imagesHtml += `
                    \u003c/div>
                \u003c/div>
            `;
            
            container.innerHTML += imagesHtml;
        }
    })
    .catch(err => {
        console.error('Erreur chargement images rappel:', err);
    });
}

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
```

## ✅ RÉSUMÉ

Après avoir fait ces 3 étapes manuelles:
1. ✅ Table SQL créée
2. ✅ Fonctions JS ajoutées dans livreDetails.php
3. ✅ Fonctions d'affichage ajoutées dans v1_racourci_pathologie.php

Vous pourrez:
- Gérer les images depuis l'admin (livreDetails.php)
- Les voir s'afficher automatiquement avec "Anatomie cours résumé"
- Les supprimer depuis l'admin
