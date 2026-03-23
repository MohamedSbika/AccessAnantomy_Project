<?php
include('header.php');
?>

<body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" onmousedown="return false" >
<?php
include('header_steppes.php');
?>
<div class="wrapper">

	<div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" onmousedown="return false" ondragstart="return false" >
		<main class="content">
			<div class="container-fluid p-0">
				<?php
				include('header_nav.php');
				?>

					<?php foreach ($ListItem as $valItem) { ?>
						<h1 class="h2 mb-1" style="font-family: cursive;"><?=$valItem ['items'] ['LibelleTheme'];?></h1>
						<div class="row">
							<?php foreach ($valItem['books'] as $valBook) { ?>
								<div class="col-12 col-md-6 col-lg-3">
								<a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?=$valBook['IDLivre'];?>" class="list-group-item" >
									<div class="card" style="height: 100%;">
										<?php if($valBook['Couverture'] =='') { ?>
											<img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/NoPicture.png"  alt="">
										<?php } else { ?>
											<img class="card-img-top"  src="data:image/png;base64,<?php print $valBook['encryptCouverture']; ?> "></img>
										<?php }?>
										<div class="card-header px-2 pt-2">
											<h4 style="text-align: center;"><?=$valBook['Titre'];?></h4>
										</div>
									</div>
								</a>
							</div>
							<?php }?>
						</div>
					<?php }?>


			</div>
		</main>

	</div>
</div>

<?php
include('footer.php');
?>

</body>
</html>

<script language="JavaScript">
    window.onload = function () {

        document.addEventListener("contextmenu", function (e) {
            e.preventDefault();
        }, false);
        document.addEventListener("keydown", function (e) {
//document.onkeydown = function(e) {
//"I" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                disabledEvent(e);
            }
//"J" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                disabledEvent(e);
            }
//"S" key + macOS
            if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                disabledEvent(e);
            }
//"U" key
            if (e.ctrlKey && e.keyCode == 85) {
                disabledEvent(e);
            }
//"F12" key
            if (event.keyCode == 123) {
                disabledEvent(e);
            }
        }, false);
        function disabledEvent(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            } else if (window.event) {
                window.event.cancelBubble = true;
            }
            e.preventDefault();
            return false;
        }
    }
    //edit: removed ";" from last "}" because of javascript error
</script>