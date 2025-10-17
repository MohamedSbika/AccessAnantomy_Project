<style>
    footer.footer {
        background: #f0f0f0;
        padding: 0px;
        display: block;
        margin-top: auto;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    @font-face {
        font-family: "League Spartan Regular";
        src: url(<?php echo base_url('assets/TYPO/LeagueSpartan-Regular.ttf'); ?>) format("truetype");
    }

    .connecte-span {
        font-family: "League Spartan Regular";
        float: right;
        margin: 10px;
        color: white;
        border-radius: 15px;
        padding: 10px;
        cursor: pointer;
        font-size: 20px;
        border: 1px solid rgba(9, 138, 99);
    }

    .connecte-span:hover {
        border: 1px solid white;
    }

    .label-modal-login {
        font-family: "League Spartan Regular";
        color: white;
        font-size: 18px;
    }

    .h2-modal-login {
        font-family: "League Spartan Regular";
        color: white;
        font-size: 25px;
        padding-top: 10px;
    }

    .input-modal-login {
        font-family: "League Spartan Regular";
        border: 1px solid rgb(60, 165, 134);
        background-color: rgb(60, 165, 134);
        border-radius: 15px;
        font-size: 15px !important;
        color: white !important;
    }

    .input-modal-login:focus {
        background-color: rgb(60, 165, 134);
    }

    .button-modal-login {
        font-family: "League Spartan Regular";
    }

    .small-modal-login a {
        font-family: "League Spartan Regular";
        color: white !important;
    }

    .style-button-modal {
        background: transparent;
        border: none;
        font-size: 30px;
        color: white;
    }

    .style-button-modal:hover {
        font-weight: 900;
    }

    .button-modal-login {
        background-color: rgb(60, 165, 134);
        border-radius: 20px;
        border: 1px solid rgb(9, 138, 99);
        font-size: 18px;
    }

    .button-modal-login:hover {
        background-color: rgb(9, 138, 99);
        border: 1px solid white;
    }
</style>
<div class="modal fade" id="centeredModalPrimary" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: rgb(9,138,99);box-shadow: 0 0 0 50vmax rgba(0,0,0,.7);">
            <div class="modal-header">
                <h2 class="modal-title h2-modal-login"><?php echo $this->lang->line('auth_req'); ?></h2>
                <button type="button" class="style-button-modal" data-dismiss="modal" aria-label="Close"> × </button>
            </div>
            <div class="modal-body m-3">
                <form id="loginform" name="loginformA" action="" method="post">
                    <input type="hidden" value="0" id="redirectLog">
                    <div id="user_message_error" style="display:none;margin-bottom:15px;" class="alert alert-danger alert-login">
                        <?php echo $this->lang->line('user_message_error'); ?>
                    </div>
                    <div class="mb-2">
                        <label class="form-label label-modal-login"><?php echo $this->lang->line('email'); ?></label>
                        <input class="form-control form-control-lg input-modal-login" type="email" name="email" placeholder="<?php echo $this->lang->line('in_email'); ?>" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label label-modal-login"><?php echo $this->lang->line('password'); ?></label>
                        <input class="form-control form-control-lg input-modal-login" type="password" name="password" placeholder="<?php echo $this->lang->line('in_password'); ?>" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;">
                        <small style="font-size: 1em;" class="small-modal-login">
                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>resetUp"><?php echo $this->lang->line('forgot_password'); ?></a>
                        </small>
                        <small style="float: right;font-size: 1em;" class="small-modal-login">
                            <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>signUp"><?php echo $this->lang->line('sign_up'); ?></a>
                        </small>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary button-modal-login"><?php echo $this->lang->line('sign_in'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<footer class="footer">
    <section style="background-color: rgba(9,138,99); overflow-x:hidden !important; padding:10px 0px;">

        <div class="content">
            <div style="display:flex; flex-direction:row;  align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <img src="/assets/img/icons/icon-logo.png" style="margin:5px;">

                <div class="socials" style="float: right;">
                    <!-- Facebook -->
                    <a href="<?= $this->session->userdata('social_facebook') ? $this->session->userdata('social_facebook') : '#'; ?>"
                       target="_blank"
                       style="display: <?= $this->session->userdata('social_facebook') ? 'flex' : 'none'; ?>"
                       title="Facebook" class="social-link" id="facebook-link">
                        <img src="<?php echo HTTP_IMAGES; ?>social_media/fb_40.png"
                             class="rounded-circle social-icon"
                             alt="Facebook" />
                    </a>

                    <!-- Instagram -->
                    <a href="<?= $this->session->userdata('social_instagram') ? $this->session->userdata('social_instagram') : '#'; ?>"
                       target="_blank"
                       style="display: <?= $this->session->userdata('social_instagram') ? 'flex' : 'none'; ?>"
                       title="Instagram" class="social-link" id="instagram-link">
                        <img src="<?php echo HTTP_IMAGES; ?>social_media/instagram_40.png"
                             class="rounded-circle social-icon"
                             alt="instagram" />
                    </a>

                    <!-- Twitter -->
                    <a href="<?= $this->session->userdata('social_twitter') ? $this->session->userdata('social_twitter') : '#'; ?>"
                       target="_blank"
                       style="display: <?= $this->session->userdata('social_twitter') ? 'flex' : 'none'; ?>"
                       title="Twitter" class="social-link" id="twitter-link">
                        <img src="<?php echo HTTP_IMAGES; ?>social_media/twitter_40.png"
                             class="rounded-circle social-icon"
                             alt="twitter" />
                    </a>

                    <!-- LinkedIn -->
                    <a href="<?= $this->session->userdata('social_linkedin') ? $this->session->userdata('social_linkedin') : '#'; ?>"
                       target="_blank"
                       style="display: <?= $this->session->userdata('social_linkedin') ? 'flex' : 'none'; ?>"
                       title="LinkedIn" class="social-link" id="linkedin-link">
                        <img src="<?php echo HTTP_IMAGES; ?>social_media/linkedin.png"
                             class="rounded-circle social-icon"
                             alt="linkedin" />
                    </a>

                    <!-- YouTube -->
                    <a href="<?= $this->session->userdata('social_youtube') ? $this->session->userdata('social_youtube') : '#'; ?>"
                       target="_blank"
                       style="display: <?= $this->session->userdata('social_youtube') ? 'flex' : 'none'; ?>"
                       title="YouTube" class="social-link" id="youtube-link">
                        <img src="<?php echo HTTP_IMAGES; ?>social_media/youtube_40.png"
                             class="rounded-circle social-icon"
                             alt="youtube" />
                    </a>

                </div>

                <?php if ($this->session->userdata('user_id') == 0) { ?>
                    <span class="connecte-span" data-toggle="modal" onclick="redirectLogLivr(0)" data-target="#centeredModalPrimary">
                        <img src="<?php echo HTTP_IMAGES; ?>photos/user-white-icon.png" class="rounded-circle mr-1" alt="Avatar" width="30" data-toggle="dropdown" style=" margin-top:auto; margin-bottom:auto">

                        <?php if ($this->session->userdata('site_lang') == '' || $this->session->userdata('site_lang') == 'FR') { ?>
                            Connectez-vous
                        <?php } else { ?>
                            Log in
                        <?php } ?>
                    </span>
                <?php } ?>
            </div>
    </section>

    <div class="container-fluid">
        <div class="row text-muted">
            <div class="col-6 text-left">
                <p class="mb-0">
                    <a href="<?php echo base_url() . $this->lang->line('siteLang'); ?>login" class="text-muted"><strong>BonGest </strong></a> &copy;
                </p>
            </div>
            <div class="col-6 text-right">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a class="text-muted" href="<?php echo base_url() . $this->lang->line('siteLang'); ?>contactUS">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo HTTP_JS; ?>jquery-3.5.1.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/jquery.dataTables.min.js"></script>
<script src="<?php echo HTTP_JS; ?>app.js"></script>

<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>Zoom/zoomove.min.js"></script>

<script src="<?php echo HTTP_JS; ?>jquery-validate/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        $("body").on("contextmenu", function(e) {
            return false;
        });
        $('body').bind('cut copy', function(e) {
            e.preventDefault();
        });
        $('body').bind('cut copy', function(e) {
            e.preventDefault();
        });
        //* validation
        $('#loginform').validate({

            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            submitHandler: function() {

                $("#user_message_error").hide();

                Swal.fire({
                    title: "<?php echo $this->lang->line('auth_prog'); ?>",
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>home/login_process",
                    data: $('#loginform').serialize(),
                    timeout: 3000,
                    success: function(html) {

                        console.log(html);
                        var ar = JSON.parse(html);

                        if (ar[0]["id"] == 1) {
                            var logTypeCNX = document.getElementById("redirectLog").value;
                            <?php if ($page == 'livre') { ?>
                                window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?= $OneBook[0]['IDLivre']; ?>";
                            <?php } else { ?>
                                <?php if ($page == 'searchIndex') { ?>
                                    var btnVlSear = document.getElementById("validSearch");
                                    btnVlSear.click();
                                <?php } else { ?>
                                    <?php if ($page == 'login') { ?>
                                        if (logTypeCNX > 0) {
                                            window.location.href = "<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/" + logTypeCNX;
                                        } else {
                                            window.location.href = '<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>' + 'login';

                                        }
                                    <?php } else { ?>
                                        $('#setNAVSTEPPS').load(" #setNAVSTEPPS > *");
                                        $('#cnxTok').load(" #cnxTok > *");
                                    <?php } ?>

                                <?php } ?>
                            <?php } ?>
                            $('#centeredModalPrimary').modal('hide')
                            Swal.close();
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: ar[0]["desc"],
                                showConfirmButton: true
                            })
                        }

                    },
                    error: function() {
                        // SHOW AN ERROR { if php failed to fetch }
                        $("#user_message_error").show();
                        Swal.hideLoading();
                        $('#centeredModalPrimary').modal('hide');
                    }

                });
                return false;

            }


        });

    });

    function redirectLogLivr(typeCNX = 0) {
        document.getElementById("redirectLog").value = typeCNX;
    }
</script>

