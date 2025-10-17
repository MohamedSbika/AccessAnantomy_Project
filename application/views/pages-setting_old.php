
<?php
include('header.php');
?>
<style>
	.footer{
		position: absolute;
		bottom: 0;
		width: 100%;
	}
</style>
<body data-theme="default" data-layout="fluid" data-sidebar="left">
<div class="wrapper">
	<?php
	include('menu_nav.php');
	?>
	<main class="main" style="min-height: 0vh;">

		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-1">
							<a class="navbar-brand" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
								<img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/mezidxlogo.png"  style="width: 200px ; margin-top: -1em;">
							</a>
						</div>

						<div class="card">
							<div class="card-body" style="padding: 0.6rem;">
								<div class="m-sm-4">
									<button type="submit" class="btn btn-primary" onclick="refreshPlatfom();">Synchroniser la platforme</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
</div>


<?php
include('footer.php');
?>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type='text/javascript'>

	$(document).ready(function () {

	});

	function refreshPlatfom() {

		Swal.fire({
			title: 'Veuillez patienter ...',
			text: 'Synchronisation de platforme en cours ..',
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			onOpen: () => {
				Swal.showLoading()
			}
		})

		$.ajax({

			type: "POST",
			url: "<?php echo base_url(); ?>home/setParamsAutoFromFloders",
			timeout: 900000,
			success: function(html) {

				console.log(html);
				var ar =  JSON.parse(html);

				if(ar[0]["id"]==1)
				{
					Swal.hideLoading();
					Swal.fire({
						position: 'center',
						type: 'success',
						title: 'Synchronisation OK',
						showConfirmButton: false,
						timer: 4000
					}).then(function() {
						//alert(ar[0]["desc"]);

					})
				}else{
					alert(ar[0]["desc"]);
				}
			},
			error: function() {
				alert("Error when call webservice to get Platform . ") ;
			}

		});


	}

</script>
