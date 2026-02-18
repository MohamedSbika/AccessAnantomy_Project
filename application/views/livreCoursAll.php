
<?php
include('header.php');
?>

<body>

<?php
include('header_steppes.php');
?>

<div class="wrapper">

	<div class="main">
		<main class="content">
			<div class="container-fluid">
				<?php
				include('header_nav.php');
				?>
				<div class="row">
					<div class="col-xl-8">
						<div class="card">
							<div class="card-header pb-0">
								<div class="card-actions float-right">
									<div class="dropdown show">

									</div>
								</div>
								<h5 class="card-title mb-0">Liste des cours</h5>
							</div>
							<div class="card-body">
								<table class="table table-striped" style="width:100%">
									<thead>
									<tr>
										<th>#</th>
										<th>Titre</th>
										<th>URL</th>
										<th>Tags</th>
										<th>Figures</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>1</td>
										<td>Cours 1</td>
										<td>http://Cours1..</td>
										<td>Test cours 1</td>
										<td><a href="#" class="badge bg-primary mr-1 my-1">Vue</a></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Cours 2</td>
										<td>http://Cours2..</td>
										<td>Test cours 2</td>
										<td><a href="#" class="badge bg-primary mr-1 my-1">Vue</a></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Cours 3</td>
										<td>http://Cours3..</td>
										<td>Test cours 3</td>
										<td><a href="#" class="badge bg-primary mr-1 my-1">Vue</a></td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>
						<iframe src="<?php echo HTTP_FILES ?>poly-anatomie-pathologique.pdf" width="100%" height="500px">
						</iframe>
					</div>

					<div class="col-xl-4">
						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="headingOne">
									<h5 class="card-title my-2">
										<a href="#" data-toggle="collapse" data-target="#collapseFig" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
											<li class="timeline-item"><strong>Figure 1</strong></li>
										</a>
									</h5>
								</div>
								<div id="collapseFig" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
									<div class="card-body">
										<div class="card-body text-center">
											<img src="<?php echo HTTP_IMAGES; ?>photos/vet.png" class="img-fluid pr-2" alt="Unsplash">
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingTwo">
									<h5 class="card-title my-2">
										<a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
											<li class="timeline-item"><strong>Figure 2</strong></li>
										</a>
									</h5>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample" style="">
									<div class="card-body">
										<div class="card-body text-center">
											<img src="<?php echo HTTP_IMAGES; ?>photos/corps.png" class="img-fluid pr-2" alt="Unsplash">
										</div>
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

</body>
</html>
