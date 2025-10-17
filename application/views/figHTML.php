<?php if(strlen($this->session->userdata('passTok'))==200) { ?>

<style>
	.demo_container {
		margin: 0 auto;
	}

	.zoom {

		position: relative;
		clear: both;
        cursor: zoom-in;
	}

	/* magnifying glass icon */
	.zoom:after {
		content:'';
		display:block;
		width:100px;
		height:100px;
		position:absolute;
		top:0;
		right:0;

	}

	.zoom img {
		display: block;
	}

	.zoom img::selection {
		background-color: transparent;
	}


</style>

	<div class="demo_container" style="text-align: center">
		<span class='zoom' id='ex2' style="overflow-y: scroll;display: inline-block;width: 40em;">
			<img src="data:image/png;base64,<?=$OneFig;?>"  height="auto" style="width: 100%"/>
		</span>
	</div>

	<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/zoom_js.js"></script>

<script type='text/javascript'>

	$(document).ready(function () {
		//$('#ex1').zoom();
		//$('#ex2').zoom({ on:'grab' });
		$('#ex2').zoom({ on:'click' });
		//$('#ex4').zoom({ on:'toggle' });

	});

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


</script>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
