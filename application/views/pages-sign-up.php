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
<body style="min-height: 0vh; overflow: auto; height:auto;">
<main class="main">
    <div class="container d-flex flex-column">

        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-1">
                    <a class="navbar-brand" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login">
                        <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/mezidxlogo.jpg" style="width: 200px ; margin-top: -1em;">
                    </a>
                </div>

                <div class="card">
                    <div class="card-body" style="padding: 0.6rem;background-color: #f7f7f7e0;">
                        <div class="m-sm-6" style="margin: 1.5rem !important;">
                            <form id="comptform" name="comptform" class="needs-validation" action="" method="post" novalidate="novalidate">
                                <h2 class="text-center">
                                    <?php echo $this->lang->line('desc_cmpt'); ?>
                                    <small style="color: #aaa8a8;">
                                        &nbsp;&nbsp;<b>*</b>&nbsp;&nbsp;<?php echo $this->lang->line('chmp_oblg'); ?>
                                    </small>
                                </h2>
                                <hr>

                                <!-- NOM & PRENOM -->
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputName"><?php echo $this->lang->line('name'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="text" name="inputName" class="form-control" id="inputName">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputPren"><?php echo $this->lang->line('lastname'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="text" name="inputPren" class="form-control" id="inputPren">
                                    </div>
                                </div>

                                <!-- EMAIL & CONFIRMATION -->
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputEmail"><?php echo $this->lang->line('email'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="email" name="inputEmail" class="form-control" id="inputEmail">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputEmailCF"><?php echo $this->lang->line('email_conf'); ?></label>
                                        <input type="email" name="inputEmailCF" class="form-control" id="inputEmailCF">
                                    </div>
                                </div>

                                <!-- PASSWORD -->
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputPassword"><?php echo $this->lang->line('passwd'); ?>&nbsp;&nbsp;<b>*</b></label>
                                        <input type="password" name="inputPassword" class="form-control" id="inputPassword">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label" for="inputPasswordCF"><?php echo $this->lang->line('password_conf'); ?></label>
                                        <input type="password" name="inputPasswordCF" class="form-control" id="inputPasswordCF">
                                    </div>
                                </div>

                                <!-- ADDRESS -->
                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="inputAddress"><?php echo $this->lang->line('adresse1'); ?></label>
                                        <input type="text" name="inputAddress" class="form-control" id="inputAddress">
                                    </div>
                                </div>

                                <!-- COUNTRY / CITY / ZIP -->
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="inputState"><?php echo $this->lang->line('country'); ?></label>
                                        <input type="text" name="inputState" class="form-control" id="inputState">
                                    </div>
                                    <div class="mb-3 col-md-5">
                                        <label class="form-label" for="inputCity"><?php echo $this->lang->line('city'); ?></label>
                                        <input type="text" name="inputCity" class="form-control" id="inputCity">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label" for="inputZip"><?php echo $this->lang->line('zipcd'); ?></label>
                                        <input type="number" name="inputZip" class="form-control" id="inputZip">
                                    </div>
                                </div>

                                <!-- LEGAL TERMS -->
                                <label class="form-check" style="background-color: #f1eeff;">
                                    <span class="form-check-label">
                                        En fournissant des informations personnelles et en terminant cette procédure,
                                        vous acceptez les Conditions d'utilisation et la politique de Protection des données personnelles de Access Anatomy.
                                    </span>
                                    <input class="form-check-input" type="checkbox" name="inputLegal" id="inputLegal">
                                </label>

                                <?php echo $widget;?>
                                <?php echo $script;?>

                                <button type="submit" class="btn btn-primary mt-3">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

<?php include('footer.php'); ?>

<!-- Scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
$(document).ready(function(){

    $("body").on("contextmenu", function(e){ return false; });
    $('body').bind('cut copy', function (e) { e.preventDefault(); });

    $('#comptform').validate({
        onkeyup: false,
        errorClass: 'error',
        validClass: 'valid',
        rules: {
            inputName: { required: true },
            inputPren: { required: true },
            inputEmail: { required: true, email: true },
            inputEmailCF: { required: true, equalTo: "#inputEmail" },
            inputPassword: { required: true, minlength: 6 },
            inputPasswordCF: { required: true, equalTo: "#inputPassword" },
        },
        messages: {
            inputName: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            inputPren: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            inputEmail: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            inputEmailCF: "Les emails doivent correspondre",
            inputPassword: "<?php echo $this->lang->line('saisi_oblg'); ?>",
            inputPasswordCF: "Les mots de passe doivent correspondre",
        },
        submitHandler: function() {

            Swal.fire({
                title: 'Création de compte',
                text: 'Envoi de la demande en cours...',
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/compte_process",
                data: $('#comptform').serialize(),
                success: function(html) {
                    Swal.close();
                    var ar = JSON.parse(html);

                    if (ar[0]["id"] == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Validation de compte',
                            text: 'Veuillez vérifier votre email pour confirmer votre inscription.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: ar[0]["desc"],
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur serveur',
                        text: 'Veuillez réessayer plus tard.'
                    });
                }
            });
            return false;
        }
    });

});
</script>

</body>
</html>
