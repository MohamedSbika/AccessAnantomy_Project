
<?php
include('header.php');
?>

<style>
	#setNAVSTEPPS{
		display: none;
	}
	.footer{
		display: none;
	}
	.image-item{
		width: 500px;
		height: 350px;
		display: inline-block;
		margin-right: 3px;
		position: relative;
	}
	.image-item figure{
		margin-left: 0; margin-top: 0;
	}
	.zoo-item {
		position: initial;
	}

</style>

<body>

<?php
include('header_steppes.php');
?>

<div class="wrapper">

	<div class="main">
		<main class="content">
			<div class="container-fluid p-0">

				<div class="row">

					<div class="col-12 col-lg-6 col-xl-6">
						<div class="card" style="height: 100%;">
							<div class="card-header">
								<?php foreach ($ListPage as $val) { ?>
									<?php if($val["numeroPage"] =='1') { ?>
										<iframe src="<?php echo HTTP_FILES ?><?php print $val["ContenuPAge"]; ?>#zoom=auto"
												style=" display: block;margin-right: auto;margin-left: auto;  height: 500px;width: 100%; ">
										</iframe>
									<?php }?>
								<?php }?>
								<nav aria-label="Page navigation" style="padding: 1em;">
									<ul class="pagination pagination-sm" style="justify-content: center;">
										<li class="page-item"><a class="page-link" href=""><i class="fas fa-angle-left"></i></a></li>
										<?php foreach ($ListPage as $val) { ?>

											<li class="page-item  <?php if($val["numeroPage"] =='1') { ?>  active <?php }?>  ">
												<!-- <a class="page-link" href=""><?php print $val["numeroPage"]; ?></a> -->
												<button class="page-link"><?php print $val["numeroPage"]; ?></button>

											</li>

										<?php }?>
										<li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>

									</ul>
								</nav>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 col-xl-6">
						<div class="card" style="height: 100%;">
							<div class="card-header">
								<?php foreach ($listFig as $value) { ?>
									<button onclick="setFig('<?php echo HTTP_IMAGES; ?><?=$value['UrlFigure'];?>' ,'<?=$value['TitreFigure'];?>')" class="badge bg-primary mr-1 my-1"><strong><?=$value['TitreFigure'];?></strong></button>
								<?php }?>
								<div class="card-body text-center" style="overflow-y: scroll; height: 300px">
									<h4 id="setTitFig"></h4>
									<div class='image-item' id="figZoo">
										<figure class="zoo-item" id="zoom_01" data-zoo-image=""></figure>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</main>
	</div>
</div>
<?php
include('footer.php');
?>


<script type='text/javascript'>

function setFig(ur='',titur='') {

	$("#figZoo").html('<figure class="zoo-item" id="zoom_01" data-zoo-image="'+ur+'" ></figure>');
	$("#setTitFig").html('<h4>'+titur+'</h4>');

	$('.zoo-item').ZooMove({
		image: 'image1.jpg',
		scale: '3',
		move: 'true',
		over: 'false',
		cursor: 'true'
	});
}


</script>

</body>
</html>
