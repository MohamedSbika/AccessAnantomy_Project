<style>
	/* Style de base du modal (caché par défaut) */
	.modal {
		display: none;
		position: fixed;
		z-index: 1000;
		left: 0;
		top: 0;
		background-color: rgba(0, 0, 0, 0.5);
		align-items: center;
		justify-content: center;
	}

	/* Contenu du modal */
	.modal-content {
		background-color: white;
		border-radius: 8px;
		width: 90%;
		max-width: 450px;
		text-align: center;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		position: relative;
		padding: 20px;
	}

	/* Bouton de fermeture */
	.close {
		position: absolute;
		top: 10px;
		right: 15px;
		font-size: 20px;
		cursor: pointer;
	}

	/* Style des labels et inputs */
	.row {
		margin: 10px 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.row label {
		color: black;
		font-size: large;
	}

	.radio-group {
		display: flex;
		flex-direction: column;
		align-items: start;
		gap: 5px;
	}

	.radio-group input {
		margin-right: 10px;
	}

	/* Style du select */
	select {
		width: 100%;
		padding: 8px;
		font-size: 14px;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	/* Bouton de confirmation */
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

	.checkLecture {
		font-size: medium;
		color: black;
	}

</style>

<!-- Modal -->
<div id="customModal_Mode_Lecture" class="modal">
	<div class="modal-content">
		<span class="close" onclick="closeModalModeLecture()">&times;</span>

		<div class="modal-header">
			<h2 class="modal-title" style="color: black; text-align: center; width: 100%;"><?php echo $this->lang->line('lecture_mode'); ?></h2>
		</div>

		<div class="modal-body">
			<!-- Mode lecture (coche unique) -->
			<div class="radio-group">
				<label class="checkLecture"><input type="radio" name="modeLecture" value="seule"><?php echo $this->lang->line('lecture_perso'); ?></label>
				<label class="checkLecture"><input type="radio" name="modeLecture" value="schema"><?php echo $this->lang->line('lecture_auto_shemas'); ?></label>
				<label class="checkLecture"><input type="radio" name="modeLecture" value="texte"><?php echo $this->lang->line('lecture_auto_text'); ?></label>
				<label class="checkLecture"><input type="radio" name="modeLecture" value="video"><?php echo $this->lang->line('lecture_synchro'); ?></label>
			</div>
			<hr>

			<!-- Sélection de la vitesse de lecture -->
			<div class="row">
				<label for="vitesseLecture"><?php echo $this->lang->line('lecture_vitesse'); ?></label>
				<select id="vitesseLecture">
					<option value="0.5">0.5x</option>
					<option value="0.75">0.75x</option>
					<option value="1" selected>1x</option>
					<option value="1.25">1.25x</option>
					<option value="1.5">1.5x</option>
				</select>
			</div>

			<!-- Bouton de validation -->
			<button onclick="toggleSpeech()" class="btn-log"><?php echo $this->lang->line('lecture_valider'); ?></button>
		</div>

	</div>
</div>

<?php include('v1_modal_videos.php'); ?>

<script>
    let isPaused = false;
    let msg = null;

    function toggleSpeech() {
        let selectedMode = document.querySelector('input[name="modeLecture"]:checked');

        if (!selectedMode) {
            alert("Veuillez sélectionner un mode de lecture !");
        }

        if (selectedMode.value === "schema") {
            console.log("Mode Lecture shema activé → Arrêt de la lecture en cours puis lire schema");
            window.speechSynthesis.cancel();
            speak_shemas();
        }

        if (selectedMode.value === "seule") {
            console.log("Mode Lecture seule activé → Arrêt de la lecture");
            window.speechSynthesis.cancel();
        }


        if (selectedMode.value === "video") {
            console.log("Mode Lecture video");
            window.speechSynthesis.cancel();
            chargeVideos();
        }

        if (selectedMode.value === "texte") {
            window.speechSynthesis.resume();
            speak()
            // if (window.speechSynthesis.speaking) {
            //     if (isPaused) {
            //         window.speechSynthesis.resume();
            //         isPaused = false;
            //         console.log("Lecture reprise");
            //     } else {
            //         window.speechSynthesis.pause();
            //         isPaused = true;
            //         console.log("Lecture mise en pause");
            //     }
            // } else {
            //     speak();
            // }
        }

        closeModalModeLecture();
    }

    function speak() {
        window.speechSynthesis.cancel(); // Arrêter toute lecture en cours

        let iframe = document.getElementById('iframeID');

        if (iframe && iframe.contentWindow && iframe.contentWindow.document) {
            let textToRead = iframe.contentWindow.document.body.innerText.trim();

            if (textToRead.length > 0) {
                msg = new SpeechSynthesisUtterance();
                msg.text = textToRead.replace(/♦/g, '').replace(/\bcarreaux\b/gi, ''); // 🔹 Suppression de "carreaux" et du symbole ♦
               // msg.text = textToRead;

                let lang = "FR".toUpperCase();
                msg.lang = (lang === "FR") ? "fr-FR" : "en-US";

                // ✅ Récupération de la vitesse sélectionnée
                let vitesseSelectionnee = parseFloat(document.getElementById("vitesseLecture").value);
                msg.rate = vitesseSelectionnee;

                function setVoice() {
                    let voices = window.speechSynthesis.getVoices();
                   // console.log("Voices disponibles :", voices);

                    let maleVoiceKeywords = (lang === "FR")
                        ? ["Paul", "Thomas", "Yannick", "Google français", "Daniel", "Male", "Man"]
                        : ["David", "Mark", "John", "Google UK English Male", "Google US English Male"];

                    let maleVoice = voices.find(voice =>
                        voice.lang.startsWith(msg.lang) &&
                        maleVoiceKeywords.some(keyword => voice.name.toLowerCase().includes(keyword.toLowerCase()))
                    );

                    if (maleVoice) {
                        msg.voice = maleVoice;
                    } else {
                        let defaultVoice = voices.find(voice => voice.lang.startsWith(msg.lang));
                        if (defaultVoice) msg.voice = defaultVoice;
                    }

                  //  console.log("Voix sélectionnée :", msg.voice ? msg.voice.name : "Aucune voix trouvée");

                    // ✅ Détection des images dans le texte
                    msg.onboundary = function (event) {
                        let fullText = msg.text.substring(event.charIndex).replace(/[♦\u2022\u25AA\u2023]/g, '').trim();
                        // console.log("Texte en cours de lecture :", fullText);

                        let cleanedText = fullText.replace(/[\(\),;!?]/g, '').trim();

                        let regex = /\b[Ff]ig[\.\s]?(0?[1-9]|[1-9][0-9]|1[0-9]{2}|200)\b/g;

                        let match = cleanedText.match(regex);
                        if (match) {
                            let figName = match[0].replace(/\./g, '').replace(/\s/g, '');
                            figName = figName.replace(/Fig0+(\d+)/, "Fig$1");

                            let targetImg = document.querySelector(`img[data-name="${figName}"]`) ||
                                [...document.querySelectorAll('img[data-name]')].find(img => {
                                    let rangeMatch = img.getAttribute("data-name").match(/Fig(\d+)-(\d+)/);
                                    if (rangeMatch) {
                                        let start = parseInt(rangeMatch[1], 10);
                                        let end = parseInt(rangeMatch[2], 10);
                                        let detectedNumber = parseInt(figName.replace("Fig", ""), 10);
                                        return detectedNumber >= start && detectedNumber <= end;
                                    }
                                    return false;
                                });

                            if (targetImg) {
                              //  console.log("Image trouvée, déclenchement du clic :", targetImg);
                                targetImg.click();
                            } else {
                                console.warn("Aucune image trouvée avec data-name =", figName);
                            }
                        }
                    };

                    window.speechSynthesis.speak(msg);
                }

                if (window.speechSynthesis.getVoices().length > 0) {
                    setVoice();
                } else {
                    window.speechSynthesis.onvoiceschanged = () => {
                        setTimeout(setVoice, 100);
                    };
                }
            } else {
                alert("Aucun texte à lire !");
            }
        } else {
            alert("Impossible d'accéder au contenu !");
        }
    }

    async function speak_shemas() {
        // Sélectionner toutes les images ayant la classe "slider-image zoomable"
        let images = document.querySelectorAll(".slider-image.zoomable");

        // Parcourir chaque image et procéder à l'analyse
        for (let index = 0; index < images.length; index++) {
            let img = images[index];
            let imgSrc = img.src; // Récupérer l'URL de l'image
            img.click();
            // Vérifier si l'image est bien chargée avant d'appeler la fonction
            if (img.complete) {
                console.log(`🔍 Analyse de l'image ${index + 1}:`, imgSrc);
                await extractTextFromImage(imgSrc); // Attendre que l'extraction du texte soit terminée
            } else {
                // Si l'image n'est pas encore chargée, attendre son chargement
                await new Promise((resolve) => {
                    img.onload = function () {
                        console.log(`🔍 Analyse de l'image ${index + 1} après chargement:`, imgSrc);
                        extractTextFromImage(imgSrc);
                        resolve(); // Résoudre la promesse une fois l'image chargée et traitée
                    };
                });
            }
        }

        closeModalModeLecture(); // Fermer le modal après toutes les analyses
    }

</script>

<!-- Include Tesseract.js -->
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.1/dist/tesseract.min.js"></script>

<!-- Your custom JS -->
<script>

    function extractTextFromImage__v4(data_img, lang = 'fr-FR') {
        return new Promise(async (resolve) => {
            let img = new Image();
            img.src = data_img;
            img.onload = async function () {
                let canvas = document.createElement("canvas");
                let ctx = canvas.getContext("2d");
                canvas.width = img.width;
                canvas.height = img.height;

                let halfWidth = img.width / 2;
                let titleHeight = img.height * 0.15;
                let contentHeight = img.height - titleHeight;

                const createCanvasPart = (x, y, width, height) => {
                    let partCanvas = document.createElement("canvas");
                    partCanvas.width = width;
                    partCanvas.height = height;
                    partCanvas.getContext("2d").drawImage(img, x, y, width, height, 0, 0, width, height);
                    return partCanvas.toDataURL("image/png");
                };

                let titleDataURL = createCanvasPart(0, contentHeight, img.width, titleHeight);
                let leftDataURL = createCanvasPart(0, 0, halfWidth, contentHeight);
                let rightDataURL = createCanvasPart(halfWidth, 0, halfWidth, contentHeight);

                function cleanText(text) {
                    return text.replace(/[^a-zA-ZÀ-ÿ\s]/g, "").replace(/\s+/g, " ").trim();
                }

                let tesseractLang = lang === 'fr-FR' ? 'fra' : 'eng';

                // Extraction du texte de la partie titre (si nécessaire)
                let { data: { text: titleText } } = await Tesseract.recognize(titleDataURL, tesseractLang);
                let cleanedTitle = cleanText(titleText);
                console.log("Title:", cleanedTitle);

                // Extraction du texte de la partie gauche (gauche de l'image)
                let { data: { text: leftText } } = await Tesseract.recognize(leftDataURL, tesseractLang);
                let cleanedLeft = cleanText(leftText);
                console.log("Left Text:", cleanedLeft);

                // Diviser le texte extrait en blocs
                let leftTextBlocks = cleanedLeft.split(/(?<=\w[\s\S]{2,})\s/);  // Divise par bloc (phrase, groupe de mots)
                for (let block of leftTextBlocks) {
                    console.log("Left Block:", block);  // Affiche chaque bloc à gauche
                }
                console.log("Fin des blocs à gauche");

                // Extraction du texte de la partie droite (droite de l'image)
                let { data: { text: rightText } } = await Tesseract.recognize(rightDataURL, tesseractLang);
                let cleanedRight = cleanText(rightText);
                console.log("Right Text:", cleanedRight);

                // Diviser le texte extrait en blocs
                let rightTextBlocks = cleanedRight.split(/(?<=\w[\s\S]{2,})\s/);  // Divise par bloc (phrase, groupe de mots)
                for (let block of rightTextBlocks) {
                    console.log("Right Block:", block);  // Affiche chaque bloc à droite
                }
                console.log("Fin des blocs à droite");

                resolve();
            };
        });
    }

    function extractTextFromImage(data_img) {
        return new Promise((resolve) => {
            let img = new Image();
            img.src = data_img;
            img.onload = function () {
                let canvas = document.createElement("canvas");
                let ctx = canvas.getContext("2d");

                // Taille du canvas = taille de l'image
                canvas.width = img.width;
                canvas.height = img.height;

                let halfWidth = img.width / 2;
                let titleHeight = img.height * 0.15; // 15% de la hauteur pour le titre
                let contentHeight = img.height - titleHeight; // Le reste pour le contenu

                // 🎯 Partie Titre (bande du bas)
                let titleCanvas = document.createElement("canvas");
                titleCanvas.width = img.width;
                titleCanvas.height = titleHeight;
                let titleCtx = titleCanvas.getContext("2d");
                titleCtx.drawImage(img, 0, contentHeight, img.width, titleHeight, 0, 0, img.width, titleHeight);
                let titleDataURL = titleCanvas.toDataURL("image/png");

                // 🎯 Partie Gauche (sans le titre)
                let leftCanvas = document.createElement("canvas");
                leftCanvas.width = halfWidth;
                leftCanvas.height = contentHeight;
                let leftCtx = leftCanvas.getContext("2d");
                leftCtx.drawImage(img, 0, 0, halfWidth, contentHeight, 0, 0, halfWidth, contentHeight);
                let leftDataURL = leftCanvas.toDataURL("image/png");

                // 🎯 Partie Droite (sans le titre)
                let rightCanvas = document.createElement("canvas");
                rightCanvas.width = halfWidth;
                rightCanvas.height = contentHeight;
                let rightCtx = rightCanvas.getContext("2d");
                rightCtx.drawImage(img, halfWidth, 0, halfWidth, contentHeight, 0, 0, halfWidth, contentHeight);
                let rightDataURL = rightCanvas.toDataURL("image/png");

                // 📝 Fonction pour nettoyer le texte (évite les caractères spéciaux)
                function cleanText(text) {
                    return text.replace(/[^a-zA-ZÀ-ÿ\s]/g, "").replace(/\s+/g, " ").trim();
                }



                // Fonction pour choisir la voix selon la langue
                function selectVoice(lang) {
                    // Sélectionner la voix à utiliser
                    let voices = window.speechSynthesis.getVoices();
                    console.log("voices :", voices);
                    let maleVoiceKeywords = (lang === "FR")
                        ? ["Paul", "Thomas", "Yannick", "Google français", "Daniel", "Male", "Man"]
                        : ["David", "Mark", "John", "Google UK English Male", "Google US English Male"];

                    let maleVoice = voices.find(voice =>
                        voice.lang.startsWith(lang) &&
                        maleVoiceKeywords.some(keyword => voice.name.toLowerCase().includes(keyword.toLowerCase()))
                    );

                    return maleVoice || voices.find(voice => voice.lang.startsWith(lang));
                }

                // 🎯 Étape 1 : Analyse et lecture du **titre** en premier
                Tesseract.recognize(titleDataURL, 'fra', { logger: info => console.log("Titre:", info) })
                    .then(({ data: { text } }) => {
                        let cleanedText = cleanText(text);
                        console.log("Titre :", cleanedText);

                        // Sélectionner la voix en fonction de la langue (ici "fr" pour le français)
                        let selectedVoice = selectVoice("FR");

                        let utterance = new SpeechSynthesisUtterance("Titre: " + cleanedText);
                        utterance.lang = 'fr-FR';
                        utterance.voice = selectedVoice;  // Appliquer la voix sélectionnée
						console.log(selectedVoice)
                        window.speechSynthesis.speak(utterance);

                        // 🎯 Étape 2 : Après le titre, analyser la partie gauche
                        return Tesseract.recognize(leftDataURL, 'fra', { logger: info => console.log("Gauche:", info) });
                    })
                    .then(({ data: { text } }) => {
                        let cleanedText = cleanText(text);
                        console.log("Texte gauche :", cleanedText);

                        // Sélectionner la voix en fonction de la langue (ici "fr" pour le français)
                        let selectedVoice = selectVoice("fr");

                        let utterance = new SpeechSynthesisUtterance("Texte gauche: " + cleanedText);
                        utterance.lang = 'fr-FR';
                        utterance.voice = selectedVoice;  // Appliquer la voix sélectionnée
                        window.speechSynthesis.speak(utterance);

                        // 🎯 Étape 3 : Après la gauche, analyser la partie droite
                        return Tesseract.recognize(rightDataURL, 'fra', { logger: info => console.log("Droite:", info) });
                    })
                    .then(({ data: { text } }) => {
                        let cleanedText = cleanText(text);
                        console.log("Texte droite :", cleanedText);

                        // Sélectionner la voix en fonction de la langue (ici "fr" pour le français)
                        let selectedVoice = selectVoice("fr");

                        let utterance = new SpeechSynthesisUtterance("Texte droite: " + cleanedText);
                        utterance.lang = 'fr-FR';
                        utterance.voice = selectedVoice;  // Appliquer la voix sélectionnée
                        window.speechSynthesis.speak(utterance);

                        resolve(); // Résoudre la promesse après que tout le texte a été lu
                    });
            };
        });
    }

    function extractTextFromImage__v2(data_img) {
        let img = new Image();
        img.src = data_img;
        img.onload = function () {
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");

            // Définir la taille du canvas selon l'image
            canvas.width = img.width;
            canvas.height = img.height;

            // Diviser l'image en deux
            let halfWidth = img.width / 2;

            // Partie gauche
            let leftCanvas = document.createElement("canvas");
            leftCanvas.width = halfWidth;
            leftCanvas.height = img.height;
            let leftCtx = leftCanvas.getContext("3d");
            leftCtx.drawImage(img, 0, 0, halfWidth, img.height, 0, 0, halfWidth, img.height);
            let leftDataURL = leftCanvas.toDataURL("image/png");

            // Partie droite
            let rightCanvas = document.createElement("canvas");
            rightCanvas.width = halfWidth;
            rightCanvas.height = img.height;
            let rightCtx = rightCanvas.getContext("2d");
            rightCtx.drawImage(img, halfWidth, 0, halfWidth, img.height, 0, 0, halfWidth, img.height);
            let rightDataURL = rightCanvas.toDataURL("image/png");

            // Analyser la partie gauche
            Tesseract.recognize(leftDataURL, 'fra', { logger: info => console.log("Gauche:", info) })
                .then(({ data: { text } }) => {
                    console.log("Texte gauche :", text);
                    let utterance = new SpeechSynthesisUtterance("Texte gauche: " + text);
                    window.speechSynthesis.speak(utterance);
                });

            // Analyser la partie droite
            Tesseract.recognize(rightDataURL, 'fra', { logger: info => console.log("Droite:", info) })
                .then(({ data: { text } }) => {
                    console.log("Texte droite :", text);
                    let utterance = new SpeechSynthesisUtterance("Texte droite: " + text);
                    window.speechSynthesis.speak(utterance);
                });
        };
    }

    function extractTextFromImage__ok(data_img) {
        Tesseract.recognize(
            data_img,
            'fra',
            {
                logger: info => console.log(info)
            }
        ).then(({ data: { text } }) => {
            console.log("Texte détecté :", text);

            // Synthèse vocale
            let utterance = new SpeechSynthesisUtterance(text);
            window.speechSynthesis.speak(utterance);
        }).catch(error => console.error("Erreur de reconnaissance OCR :", error));
    }

</script>

<script>
    function chargeVideos(){
       	let idType 		= '<?php echo $page; ?>';
        let idChapitre 	= '<?= $OneBook[0]['IDChapitre']; ?>';
        let typeVideo 	= '';

        switch (idType) {
            case 'livreCours':
                typeVideo = 'cours';
                break;
            case 'livreResume':
                typeVideo = 'cours';
                break;
            case 'livreQcm':
                typeVideo = 'QCM';
                break;
            case 'livreQroc':
                typeVideo = 'QROC';
                break;
            case 'listCalque':
                typeVideo = 'Calque';
                break;
            case 'listCalqueFigure':
                typeVideo = 'Calque';
                break;
            default:
                typeVideo = 'inconnu';
        }
        var formData = new FormData();
        formData.append('idChapitre', idChapitre);
        formData.append('idType', typeVideo);

        Swal.fire({
            title: 'Veuillez patienter ...<br> Envoi des données en cours .. ',
            allowOutsideClick: false,
            allowEscapeKey: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>video/listVideos",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 30000000,
            success: function(html) {

                console.log("sucess");
                console.log(html);
                console.log(html["id"]);

                var res = JSON.parse(html)

                var listVideos = res["desc"]

                for(let i = 0; i < listVideos.length; i++){
                    listVideos[i].path = "uploads/"+listVideos[i].path
                }

                var videoHtml = "";
                if (listVideos.length === 0) {
                    videoHtml = "<p>Aucune vidéo disponible.</p>";
                } else {
                    videoHtml += `<div class="video-grid">`; // Ouvre la grille ici

                    listVideos.forEach(video => {
                        const fullPath = "<?php echo base_url(); ?>" + video.path;

                        videoHtml += `
            <div class="video-item">
                <video   controls controlsList="nodownload" oncontextmenu="return false;">
                    <source src="${fullPath}" type="video/mp4">
                    Votre navigateur ne prend pas en charge la lecture vidéo.
                </video>
                <h4>${video.titre}</h4>
                <p>${video.description || ""}</p>
            </div>
        `;
                    });

                    videoHtml += `</div>`; // Ferme la grille ici
                }


                document.getElementById("videoListContainer").innerHTML = videoHtml;

				// Afficher le modal des vidéos
                const modal = document.getElementById("customModal_videos");
                const sidebar = document.getElementById("sidebar-racc");
                const sidebarRect = sidebar.getBoundingClientRect();

				// Positionner le modal à droite du sidebar
                modal.style.top 	= `${window.scrollY + sidebarRect.top}px`;
                modal.style.left 	 = `${window.scrollX + sidebarRect.right + 15}px`;
                document.getElementById("customModal_videos").style.display = "flex";

                Swal.close(); // Ferme le loader si encore ouvert


            },
            error: function() {
                // SHOW AN ERROR { if php failed to fetch }

                //$("#user_message_error_pretech").show();
                $('.modal-message').html("Sorry, File not Uploaded");
                $('#modal-confirm-all').modal('show');
            }

        });

        return false;
	}

    function openModalModeLecture() {
        document.getElementById("customModal_Mode_Lecture").style.display = "flex";
    }

    function closeModalModeLecture() {
        document.getElementById("customModal_Mode_Lecture").style.display = "none";
    }
</script>
