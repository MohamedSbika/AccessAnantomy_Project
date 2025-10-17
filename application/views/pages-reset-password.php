
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
    .footer{
        position: absolute;
        bottom: 0;
        width: 100%;
    }
</style>
<body data-theme="default" data-layout="fluid" data-sidebar="left"   oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false">
<main class="main">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-1">
                        <a class="navbar-brand" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
                            <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/mezidxlogo.jpg"  style="width: 200px ; margin-top: -1em;">
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <form id="comptform" name="comptform"  class="needs-validation"  action="" method="post" novalidate="novalidate" >
                                    <div class="mb-3">
                                        <label class="form-label" for="inputEmail"><?php echo $this->lang->line('email'); ?></label>
                                        <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="">
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary">Reset password</button>
                                    </div>
                                </form>
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
</body>
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
                inputEmail: { required: true },
            },messages: {
                inputEmail: "<?php echo $this->lang->line('saisi_oblg'); ?>",
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
                    title: 'Création de compte',
                    text: 'Envoie de demande en cours ..',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>home/forgot_password_send",
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
                                title: 'Validation de compte'+ar[0]["desc"],
                                text: 'Veuillez vérifier votre boîte de réception pour un courriel de confirmation .',
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
