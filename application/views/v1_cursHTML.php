<?php if(strlen($this->session->userdata('passTok'))==200) { ?>

    <style>
        body{
            padding-left: 3em;
            padding-right: 3em;
        }
        ::-moz-selection { /* Code for Firefox */
            color: red;
            background: yellow;
        }

        ::selection {
            color: red;
            background: yellow;
        }
    </style>

    <div>
        <input  id="keywords" hidden value="<?php print urldecode($indexSearch); ?>">
        <button hidden name="btn_search" id="btn_search" onclick="highlightAll(this.value);">Find!</button>
    </div>

    <div id="ifrm" hidden >
        <?= htmlspecialchars_decode(str_replace("font-family: 'Symbol'","font-family: ''",$OneCurs));?>
    </div>

    <div id="ifrmAff"  style="line-height: 1.6;">

    </div>
    <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
        <button style="width: 100%;color: red; font-size: 20px; text-align: left;"  name="btn_offre" id="btn_offre" class="btn-success">
            <?php echo $this->lang->line('abbonementInfo1'); ?> <?php print $paramsCurs; ?>% <?php echo $this->lang->line('abbonementInfo2'); ?><br>
        </button>
        <?php  foreach ($resOffers as $valOff) { ?>
            <div class="mt-auto">
                <a target="_parent"  href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>listOffers/<?php print base64_encode($valOff["id"]); ?>" class="btn btn-lg btn-outline-primary"
                   style="margin-top: 1.2em;width:100%;background-color: rgba(0, 0, 0, 0);
border-bottom-color: rgb(59, 125, 221);
border-bottom-left-radius: 4.8px;
border-bottom-right-radius: 4.8px;
border-bottom-style: solid;
border-bottom-width: 1px;
border-image-outset: 0;
border-image-repeat: stretch;
border-image-slice: 100%;
border-image-source: none;
border-image-width: 1;
border-left-color: rgb(59, 125, 221);
border-left-style: solid;
border-left-width: 1px;
border-right-color: rgb(59, 125, 221);
border-right-style: solid;
border-right-width: 1px;
border-top-color: rgb(59, 125, 221);
border-top-left-radius: 4.8px;
border-top-right-radius: 4.8px;
border-top-style: solid;
border-top-width: 1px;
box-sizing: border-box;
color: rgb(59, 125, 221);
cursor: pointer;
direction: ltr;
display: inline-block;
font-family: Inter, Helvetica Neue, Arial, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
			font-size: 14.8px;
			font-weight: 400;
			line-height: 22.2px;
			overflow-wrap: break-word;
			padding-bottom: 6.4px;
			padding-left: 16px;
			padding-right: 16px;
			padding-top: 6.4px;
			text-align: center;
			text-decoration: rgb(59, 125, 221);
			text-decoration-color: rgb(59, 125, 221);
			text-decoration-line: none;
			text-decoration-style: solid;
			text-decoration-thickness: auto;
			transition-delay: 0s, 0s, 0s, 0s;
			transition-duration: 0.15s, 0.15s, 0.15s, 0.15s;
			transition-property: color, background-color, border-color, box-shadow;
			transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out;
			user-select: none;
			vertical-align: middle;" >
                    <?php print $valOff["name"]; ?>
                </a>
            </div>
        <?php  } ?>
    <?php  } ?>
    <script>
        var iframess = document.getElementById("ifrm")
        var c = iframess.children;
        var txt = "";
        var i;
        var lengShow = (c.length * <?php print $paramsCurs; ?> ) / 100;
        for (i = 0; i < lengShow; i++) {
            txt = txt + c[i].outerHTML ;
        }
        document.getElementById("ifrmAff").innerHTML = txt ;
        document.getElementById("ifrm").remove()   ;

    </script>

	<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>


    <script>

        var TRange=null;
        function highlightAll(keyWords) {
            var str = document.getElementById ("keywords").value;
            findString (str);
        }
        function findString (str) {
            if (parseInt(navigator.appVersion)<4) return;
            var strFound;
            if (window.find) {

                // CODE FOR BROWSERS THAT SUPPORT window.find

                strFound=self.find(str);
                if (!strFound) {
                    strFound=self.find(str,0,1);
                    while (self.find(str,0,1)) continue;
                }
            }
            else if (navigator.appName.indexOf("Microsoft")!=-1) {

                // EXPLORER-SPECIFIC CODE

                if (TRange!=null) {
                    TRange.collapse(false);
                    strFound=TRange.findText(str);
                    if (strFound) TRange.select();
                }
                if (TRange==null || strFound==0) {
                    TRange=self.document.body.createTextRange();
                    strFound=TRange.findText(str);
                    if (strFound) TRange.select();
                }
            }
            else if (navigator.appName=="Opera") {
                alert ("Opera browsers not supported, sorry...")
                return;
            }
            if (!strFound) {
                alert ("<?php echo $this->lang->line('searchEnd'); ?>\n" + str);
            }
            return;
        }

        window.onload = setAutoSearch();

        function setAutoSearch(){
            var str = document.getElementById ("keywords").value;
            if (str != "") {
                var elmnt = document.getElementById("btn_search");
                elmnt.click();
            }
        }

    </script>

	<script>
        // Variable pour garder la référence de l'instance de SpeechSynthesisUtterance
        // Variable pour suivre l'instance en cours
        let currentUtterance = null;

        document.getElementById("ifrmAff").addEventListener("click", function (event) {
            let synth = window.speechSynthesis;
            synth.cancel(); // Stopper toute lecture immédiatement

            setTimeout(() => {
                let selection = window.getSelection();
                let selectedText = selection.toString().trim();

                if (selectedText.length > 0) {
                    console.log("Mot cliqué :", selectedText);

                    let content = document.getElementById("ifrmAff").textContent;
                    let position = content.indexOf(selectedText);

                    if (position !== -1) {
                        let textToRead = content.substring(position).replace(/[♦\u2022\u25AA\u2023]/g, '').trim();
                        console.log("Texte à lire :", textToRead);

                        let confirmation = confirm(`Voulez-vous commencer la lecture à partir de : "${selectedText}" ?`);
                        if (confirmation) {
                            if (synth.speaking) {
                                synth.cancel();
                                console.log("Lecture en cours arrêtée.");
                                setTimeout(() => lireTexte(textToRead), 300); // Attendre 300ms avant de relancer
                            } else {
                                lireTexte(textToRead);
                            }
                        }
                    } else {
                        console.log("Mot non trouvé dans le texte.");
                    }
                }
            }, 200); // Attendre 200ms après `cancel()` pour éviter un conflit
        });

        // Fonction pour lire le texte
        function lireTexte(texte) {
            let synth = window.speechSynthesis;
            currentUtterance = new SpeechSynthesisUtterance(texte);

            let voices = synth.getVoices();
            let maleVoice = voices.find(voice => voice.name.includes("Paul") && voice.lang === "fr-FR");
            if (maleVoice) {
                currentUtterance.voice = maleVoice;
            } else {
                console.log("Aucune voix masculine spécifique trouvée, utilisation de la voix par défaut.");
            }

            currentUtterance.lang = 'fr-FR';
            currentUtterance.rate = 1.0;
            currentUtterance.pitch = 2.0;

            synth.speak(currentUtterance);
        }

        // Charger les voix après le chargement des données de synthèse vocale
        window.speechSynthesis.onvoiceschanged = function () {
            let voices = window.speechSynthesis.getVoices();
            console.log("Voix disponibles :", voices);
        };


	</script>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
