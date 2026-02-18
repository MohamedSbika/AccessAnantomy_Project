
<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>

<?php
include('adm_nav.php');
?>

<style>
	thead input {
		width: 100%;
	}
	.table-striped tbody tr:nth-of-type(odd) {
		background-color: rgba(0, 0, 0, 0.05);
	}


</style>

		<main class="content">
			<div class="container-fluid">
				<div class="row">

					<div class="col-12">
						<div class="card">

							<div class="card-body">
								<div id="datatables-column-search-select-inputs_wrapper" class="dataTables_wrapper dt-bootstrap4">

									<div class="row">
										<div class="col-sm-12">
											<div class="col-md-8" id="treeview_json" hidden>

											</div>

										</div>
									</div>
							</div>
						</div>
					</div>
				</div>




			</div>
		</main>

		<?php
		include('footer.php');
		?>
	</div>
</div>

</body>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function(){



			var treeData;



			$.ajax({

				type: "GET",

				url: "<?php echo base_url(); ?>home/getItem",

				dataType: "json",

				success: function(response)

				{

					initTree(response)

				}

			});



			function initTree(treeData) {

				$('#treeview_json').treeview({data: treeData});

			}



		});

	</script>


	</html>
<?php }else{ ?>

	<?php
	header('Location: '. base_url().$this->lang->line('siteLang').'login');
	exit();
	?>

<?php } ?>
