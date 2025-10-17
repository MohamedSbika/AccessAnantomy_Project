
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
	.modal-header {padding: 0.1rem;}
	.modal-body {
		position: relative;
		flex: 1 1 auto;
		padding: 1rem;
		max-height: 400px;
		overflow-y: auto;
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

	.checkLecture { font-size: medium; color: black; }
	.swal2-title{font-size: 20px !important ;}
	.table > tbody > tr > td { padding: 0.05rem; }
	.btn_test{
		display: inline-block;
		font-weight: 400;
		line-height: 1.5;
		text-align: center;
		user-select: none;
		border: 1px solid transparent;
		border-top-color: transparent;
		border-right-color: transparent;
		border-bottom-color: transparent;
		border-left-color: transparent;
		padding: .25rem .7rem;
		font-size: .875rem;
		border-radius: .2rem;
		transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
</style>

<!-- SweetAlert2 CSS (optionnel mais recommandé) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div id="modalTestQCM" class="modal" style="display: none;">
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title" style="color: black; text-align: center; width: 100%;"><?php echo $this->lang->line('testChoicCurs'); ?></h2>
		</div>
		<div class="modal-body">
			<div>
				<form name="pageForm_TestQCM" id="pageForm_TestQCM" action="">
					<input type="hidden" name="bookID" id="bookID" value="<?= base64_encode($OneBook[0]['IDLivre']); ?>">
					<div class="row">

						<div>
							<label class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="typeQCM" value="1" checked>
								<span class="form-check-label"><?php echo $this->lang->line('testQcmPair'); ?></span>
							</label>
							<label class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="typeQCM" value="2">
								<span class="form-check-label"><?php echo $this->lang->line('testQcmImpair'); ?></span>
							</label>
						</div>

					</div>
					<hr>
					<div class="row">
						<table class="table table-striped">
							<thead>
							<tr>

							</tr>
							</thead>
							<?php foreach ($listChap as $value) { ?>
								<?php if ($value['NbreQcm'] > 0) { ?>
									<tbody id="serChapTest">
									<tr>
										<td style="text-align: left;">
											<div class="col-md-12" style="font-size: 0.97rem;">
												<label class="form-check">
													<input class="form-check-input" type="checkbox" name="listIDsTest[]" value="<?php print base64_encode($value['IDChapitre']); ?>">
													<span class="form-check-label"><?= $value['TitreChapitre']; ?></span>
												</label>
											</div>
										</td>
									</tr>
									</tbody>
								<?php } ?>
							<?php } ?>
						</table>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn-secondary btn_test" onclick="closeCustomModalQcm()"><?php echo $this->lang->line('testClose'); ?></button>
			<button type="button" class="btn-primary btn_test" 	onclick="set_testQcmChap()"><?php echo $this->lang->line('testBegin'); ?></button>
		</div>
	</div>
</div>

<?php if ((strlen($this->session->userdata('passTok')) == 200)) { ?>
	<script type="text/javascript">
    function set_testQcmChap() {

        var data_plat = new FormData($('#pageForm_TestQCM')[0]);

        Swal.fire({
            title: '<?php echo $this->lang->line('testPopPat'); ?>',
            allowOutsideClick: false,
            allowEscapeKey: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })

        $.ajax({

            type: "POST",
            url: "<?php echo base_url(); ?>home/set_testQCMChap",
            data: data_plat,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 30000000,
            success: function(html) {

                console.log(html);
                var resu = JSON.parse(html);
                console.log(resu);

                if (resu[0]["id"] == 1) {
                    $('#modalChap').modal('hide');
                    Swal.fire({
                        title: "<?php echo $this->lang->line('testPopInfo'); ?>",
                        position: 'center',
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<?php echo $this->lang->line('testPopBeg'); ?>',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>evaluatQCM/<?= base64_encode($OneBook[0]['IDLivre']); ?>/" + resu[0]["listIDS"] + "/" + resu[0]["typeImp"];
                        }
                    })

                } else {
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
</script>
<?php } ?>

<script>
    function closeCustomModalQcm() {
        document.getElementById('modalTestQCM').style.display = 'none';
    }
</script>
