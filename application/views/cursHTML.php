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
<script type='text/javascript'>

	$("body").on("drop",function(e){
		return false;
	});
	$("body").on("dragstart",function(e){
		return false;
	});
	$("body").on("selectstart",function(e){
		return false;
	});
	$("body").on("contextmenu",function(e){
		return false;
	});
	$('body').bind('cut copy', function (e) {
		e.preventDefault();
	});
	$('body').bind('cut copy', function (e) {
		e.preventDefault();
	});
		if (document.getElementById('iframeID') instanceof Object){

		}
	if(top.location.href== window.location.href){
		window.location.href='<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>'+'login';
	}

//disable cut copy past
			var message = "";
	function clickIE() { if (document.all) { (message); return false; } }
	function clickNS(e) {
		if(document.layers || (document.getElementById && !document.all)) {
			if (e.which == 2 || e.which == 3) { (message); return false; }
		}
	}
	if (document.layers)
	{ document.captureEvents(Event.MOUSEDOWN); document.onmousedown = clickNS; }
	else { document.onmouseup = clickNS; document.oncontextmenu = clickIE; }
	document.oncontextmenu = new Function("return false")


	//for disable select option
	document.onselectstart = new Function('return false');
	function dMDown(e) { return false; }
	function dOClick() { return true; }
	document.onmousedown = dMDown;
	document.onclick = dOClick;

    replaceAccented();
    function replaceAccented(){
        var e = document.getElementsByTagName('*'), l = e.length, i;
        if( typeof getComputedStyle == "undefined")
            getComputedStyle = function(e) {return e.currentStyle;};
        for( i=0; i<l; i++) {
            if( getComputedStyle(e[i]).textTransform == "uppercase") {
                // do stuff with e[i] here.
                e[i].innerHTML = greekReplaceAccented(e[i].innerHTML);
            }
        }
    }
    function greekReplaceAccented(str) {
        var charList = {'Ά':'Α','ά':'α','Έ':'Ε','é':'ε','Ή':'Η','ή':'η','Ί':'Ι','ί':'ι','ΐ':'ϊ','Ό':'Ο'
            ,'ό':'ο','Ύ':'Υ','ύ':'υ','ΰ':'ϋ','Ώ':'Ω','ώ':'ω','ς':'Σ'
        };
        return str.replace(/./g, function(c) {return c in charList? charList[c] : c}) ;
    }

    function greekUppercase(str) {
        var charList = {'α':'Α', 'β':'Β', 'γ':'Γ', 'δ':'Δ', 'ε':'Ε', 'ζ':'Ζ', 'η':'Η', 'θ':'Θ', 'ι':'Ι', 'κ':'Κ', 'λ':'Λ', 'μ':'Μ',
            'ν':'Ν', 'ξ':'Ξ', 'ο':'Ο', 'π':'Π', 'ρ':'Ρ', 'σ':'Σ', 'τ':'Τ', 'υ':'Υ', 'φ':'Φ', 'χ':'Χ', 'ψ':'Ψ', 'ω':'Ω',
            'ς':'Σ', 'ά':'Α', 'έ':'Ε', 'ή':'Η', 'ί':'Ι', 'ό':'Ο', 'ύ':'Υ', 'ώ':'Ω', 'ϊ':'Ϊ', 'ϋ':'Ϋ', 'ΐ':'Ϊ', 'ΰ':'Ϋ',
        };
        return str.replace(/./g, function(c) {return c in charList? charList[c] : c}) ;
    }

</script>

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

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
