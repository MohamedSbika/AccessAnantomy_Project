<?php if(strlen($this->session->userdata('passTok'))==200) {  ?>


	<?php
	include('header.php');
	?>
	<style>
		.table th {
			text-align: center;
		}
		.table tr {
			text-align: center;
		}
		.btn-outline-primary {
			color: #000000;
			font-size: 80%;
		}
		.btn-outline-primary:hover{
			background: #ADD8E6;
			color: #000000;
		}
		.btn-outline-primary:active{
			background: #ADD8E6;
			color: #000000;
		}

	</style>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

	<body  oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false"  ondragstart="return false"  >

	<?php
	include('header_steppes.php');
	?>

	<div class="wrapper">

		<div class="main" oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false"  ondragstart="return false" >
			<main class="content">
				<div class="container-fluid p-0">
					<?php
					include('header_nav.php');
					?>
					<div class="row">
						<div class="col-xl-12" style="margin: auto; ">
							<div class="card">
								<div class="card-header pb-0">
									<div class="card-actions float-right">

									</div>

								</div>
								<div class="card-body" style=" display: flex;  justify-content: center;" >
									<div class="col-md-10 col-xl-8 mx-auto">
										<h1 class="text-center">Liste des abonnements</h1>
										<p class="lead text-center mb-4">Veuillez valider votre abonnement .</p>
										<form name="pageForm_Chap" id="pageForm_Chap" action="">
											<div class="row py-4">
												<?php foreach ($resOffers as $valOff) { ?>
													<div class="col-sm-4 mb-3 mb-md-0">
														<div class="card text-center h-100" style="background-color:
														<?php if ($valOff["id"]==$selOffr) { ?> #d8dcde <?php }else{ ?>
																#f8f5f5  <?php } ?>  ">
															<div class="card-body d-flex flex-column">
																<div class="mb-8">
																	<h5>Free</h5>
																	<span class="display-6" style="font-size: xx-large">$<?php print $valOff["price"]; ?></span>
																</div>
																<h4><?php print $valOff["name"]; ?></h4>
																<ul class="list-unstyled">
																	<li class="mb-2">

																	</li>
																	<li class="mb-2">

																	</li>
																	<li class="mb-2">

																	</li>
																</ul>
																<div class="mt-auto">
																	<a href="<?php echo base_url().'products/buyProduct/'.base64_encode($valOff["id"]); ?>" class="btn btn-lg btn-outline-primary">Valider</a>
																</div>
															</div>
														</div>
													</div>
												<?php }?>
											</div>
										</form>
									</div>

								</div>
								<div class="row" style="padding-top: 5rem ; background-color: white"></div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>



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
	<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

		<script type="text/javascript" >

			var pElemsErvc = document.getElementsByName("tokenfield[]");
			for ( var i = 0; i < pElemsErvc.length; i++) {
				var idCurs = pElemsErvc[i].id;
				$('#'+idCurs).tokenfield({
					autocomplete: {
						source: [''],
						delay: 100
					},
					showAutocompleteOnFocus: true
				})
			}


			function suppAllFiguRSM(idC)
			{
				var tit = document.getElementById('FigSR_'+idC).title;
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('figur'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textAllFig'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppAllFiguRSM",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppAllFigu(idC)
			{
				var tit = document.getElementById('FigS_'+idC).title;
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('figur'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textAllFig'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppAllFigu",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppQROC(idC)
			{
				var tit = document.getElementById(idC).name
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('qroc'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textCRQ'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppQROC",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppQCM(idC)
			{
				var tit = document.getElementById(idC).name
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('qcm'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textQC'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppQCM",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppCurs(idC)
			{
				var tit = document.getElementById(idC).name
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('cours'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textCRS'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppCurs",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppResum(idC)
			{
				var tit = document.getElementById(idC).name
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?> '+'<?php echo $this->lang->line('resume'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textRSM'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppResum",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function suppCh(idC)
			{
				var tit = document.getElementById(idC).name
				Swal.fire({
					title: '<?php echo $this->lang->line('supp_title'); ?>'+' <br> '+tit,
					text: '<?php echo $this->lang->line('supp_textC'); ?>',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php echo $this->lang->line('supp_OK'); ?>'
				}).then((result) => {
					if (result.value) {

						Swal.fire({
							title: '<?php echo $this->lang->line('supp_Inprgs'); ?>',
							allowOutsideClick: false,
							allowEscapeKey: false,
							onBeforeOpen: () => {
								Swal.showLoading()
							}
						})

						$.ajax({

							type: "POST",
							url: "<?php echo base_url(); ?>home/suppCh",
							data: { idC: idC} ,
							timeout: 300000,
							success: function(html) {

								console.log(html);
								var resu = JSON.parse(html);
								console.log(resu);

								if(resu[0]["id"]==1)
								{
									Swal.fire({
										title: resu[0]["desc"],
										position: 'center',
										type: 'success',
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'OK',
										allowOutsideClick: false,
										allowEscapeKey: false
									}).then((result) => {
										if (result.value) {
											location.reload();
										}
									})

								}else{
									Swal.fire({
										position: 'center',
										type: 'error',
										title: resu[0]["desc"],
										showConfirmButton: false,
										timer: 4000
									})
								}


							},
							error: function() {
								// SHOW AN ERROR { if php failed to fetch }

								//$("#user_message_error_pretech").show();
								$('.modal-message').html("Sorry, File not Uploaded");
								$('#modal-confirm-all').modal('show');
							}

						});

					}
				})
				return false;
			}
			function set_ChapBack()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/set_ChapBack",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 3000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}

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

			function set_Curs()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_Curs",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						Swal.fire({
							title: resu[0]["desc"],
							position: 'center',
							type: 'success',
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'OK',
							allowOutsideClick: false,
							allowEscapeKey: false
						}).then((result) => {
							if (result.value) {
								//$('#serChap').load(" #serChap > *");
								location.reload();
							}
						})


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
			function set_Resum()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_Resum",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						Swal.fire({
							title: resu[0]["desc"],
							position: 'center',
							type: 'success',
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'OK',
							allowOutsideClick: false,
							allowEscapeKey: false
						}).then((result) => {
							if (result.value) {
								//$('#serChap').load(" #serChap > *");
								location.reload();
							}
						})


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

			function set_FigResum()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_FigResum",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									//$('#serChap').load(" #serChap > *");
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}


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

			function set_Fig()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_Fig",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									//$('#serChap').load(" #serChap > *");
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}


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

			function set_QCM()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_QCM",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}

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

			function set_QROC()
			{

				var data_plat = new FormData($('#pageForm_Chap')[0]);
				//console.log(data_plat);
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
					url: "<?php echo base_url(); ?>home/upload_Attach_Save_QROC",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}

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


			function set_LivChap()
			{

				var data_plat = new FormData($('#pageForm_SetChap')[0]);

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
					url: "<?php echo base_url(); ?>home/set_LivChap",
					data: data_plat ,
					cache: false,
					contentType: false,
					processData: false,
					timeout: 30000000,
					success: function(html) {

						console.log(html);
						var resu = JSON.parse(html);
						console.log(resu);

						if(resu[0]["id"]==1)
						{
							$('#modalChap').modal('hide');
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}
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

			function delChap(iTH,xx)
			{
				var elem= document.getElementsByClassName('row '+xx);
				$("#"+iTH+'_'+xx).remove(); //Remove field html
				//x--; //Decrement field counter
			}

			function set_KeysIndex(idChp,typeKeys)
			{
				var tit =   '';
				switch (typeKeys){
					case "curs":
						tit = document.getElementById("tokenfieldCrs_"+idChp).value ;
						break;

					case "resum":
						tit = document.getElementById("tokenfieldRsm_"+idChp).value ;
						break;

					case "qcm":
						tit = document.getElementById("tokenfieldQcm_"+idChp).value ;
						break;

					case "qroc":
						tit = document.getElementById("tokenfieldQrc_"+idChp).value ;
						break;

					default :
						break;
				}

				//console.log(data_plat);
				Swal.fire({
					title: 'Veuillez patienter ...<br> Envoi des index en cours .. ',
					allowOutsideClick: false,
					allowEscapeKey: false,
					onBeforeOpen: () => {
						Swal.showLoading()
					}
				})

				$.ajax({

					type: "POST",
					url: "<?php echo base_url(); ?>home/set_KeysIndex",
					data: { idC: idChp , tit: tit , typeKeys: typeKeys } ,
					timeout: 300000,
					success: function(html) {

						//console.log(html);
						var resu = JSON.parse(html);
						//console.log(resu);

						if(resu[0]["id"]==1)
						{
							Swal.fire({
								title: resu[0]["desc"],
								position: 'center',
								type: 'success',
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'OK',
								allowOutsideClick: false,
								allowEscapeKey: false
							}).then((result) => {
								if (result.value) {
									location.reload();
								}
							})

						}else{
							Swal.fire({
								position: 'center',
								type: 'error',
								title: resu[0]["desc"],
								showConfirmButton: false,
								timer: 4000
							})
						}

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

			$(document).ready(function()

			{
				var x = 0; //Initial field counter
				var list_maxField = 10; //Input fields increment limitation

				//Once add button is clicked
				$('.list_add_button').click(function()
				{
					var idTh = $(this).val();
					//Check maximum number of input fields
					//if(x < list_maxField){
					x++; //Increment field counter
					var cmp = x+1;
					var list_fieldHTML = '<div style="margin-top: 0.5em" class="row '+x+'" id='+idTh+'_'+x+'><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="list[]" type="text" placeholder="Chapitre '+cmp+'" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><button type="button" class="btn btn-danger list_remove_button" onclick="delChap('+idTh+','+x+')" value="'+idTh+'">-</button></div></div>'; //New input field html
					$(".list_wrapper_"+idTh).append(list_fieldHTML); //Add field html
					//}
				});

			});

		</script>
	<?php }?>

<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>

