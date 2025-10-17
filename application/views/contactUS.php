
<?php
include('header.php');
?>
<style>
    input.error {
        border:1px solid red;
    }
    .error {
        color: red;
    }
</style>
<body data-theme="default" data-layout="fluid" data-sidebar="left"   oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false">
<main class="main" style="min-height: 0vh;">
    <div class="container d-flex flex-column">

        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-1">
                    <a class="navbar-brand" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
                        <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/mezidxlogo.jpg"  style="width: 200px ; margin-top: -1em;">
                    </a>
                </div>

                <div class="card">
                    <div class="card-body" style="padding: 0.6rem;background-color: #f7f7f7e0;">
                        <div class="m-sm-6" style="margin: 1.5rem !important;">
                            <form id="comptform" name="comptform"  class="needs-validation"  action="" method="post" novalidate="novalidate" >
                                <h2 class="text-center"><?php echo $this->lang->line('contactDesc_cmpt'); ?><small style="color: #aaa8a8;">&nbsp;&nbsp;<b>*</b>&nbsp;&nbsp;<?php echo $this->lang->line('chmp_oblg'); ?></small></h2><hr>
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputName"><?php echo $this->lang->line('contactName'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="text" name="inputName" class="form-control" required="" id="inputName" placeholder="">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputPren"><?php echo $this->lang->line('contactLastName'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="text" name="inputPren" class="form-control" id="inputPren" placeholder="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label class="form-label" for="inputEmail"><?php echo $this->lang->line('contactEmail'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label class="form-label" for="inputCG"><?php echo $this->lang->line('contactCG'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="text" name="inputCG" class="form-control" id="inputCG" placeholder="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="inputMssg"><?php echo $this->lang->line('contactMessage'); ?>&nbsp;<b>*</b></label>
                                        <textarea name="inputMssg" class="form-control"  id="inputMssg" placeholder="<?php echo $this->lang->line('contactInfMessage'); ?>" rows="5"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('contactSend'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>


</body>
<?php
include('footer.php');
?>

</html>
<script>
    $(document).ready(function(){

        $("body").on("contextmenu",function(e){
            return false;
        });
        $('body').bind('cut copy', function (e) {
            e.preventDefault();
        });
        $('body').bind('cut copy', function (e) {
            e.preventDefault();
        });
        //* validation
        $('#comptform').validate({

            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                inputName	: { required: true },
                inputPren	: { required: true },
                inputEmail	: { required: true },
                inputCG		: { required: true },
                inputMssg	: { required: true },
            },messages: {
                inputName	: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputPren	: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputEmail	: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputCG		: "<?php echo $this->lang->line('saisi_oblg'); ?>",
                inputMssg	: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            }, highlight: function(element, errorClass, validClass) {
                $(element).removeClass(validClass).addClass(errorClass).
                next('label').removeAttr('data-success').attr('data-error', 'Incorrect!');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass).
                next('label').removeAttr('data-error').attr('data-success', 'Correct!');
            },
            submitHandler: function() {

                Swal.fire({
                    title: "<?php echo $this->lang->line('contactMsg1'); ?>",
                    text: 	"<?php echo $this->lang->line('contactMsg2'); ?>",
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>home/contactUS_process",
                    data: $('#comptform').serialize(),
                    timeout: 30000,
                    success: function(html) {
                        console.log(html);
                        Swal.close();
                        var ar =  JSON.parse(html);

                        if(ar[0]["id"]==1)
                        {

                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: "<?php echo $this->lang->line('contactMsg1'); ?>",
                                text: "<?php echo $this->lang->line('contactMsg3'); ?>",
                                showConfirmButton: true
                            }).then(function() {
                                window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login';
                            })
                        }else{
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: ar[0]["desc"],
                                showConfirmButton: true
                            })
                        }
                        Swal.hideLoading();
                    },
                    error: function() {
                        Swal.hideLoading();
                    }
                });
                return false;
            }

        });

    });

</script>
