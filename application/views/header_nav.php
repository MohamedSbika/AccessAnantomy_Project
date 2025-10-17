
<style>
    /*#pageForm_Livr .breadcrumb-item{
        color:white;
    }

    #pageForm_Livr .breadcrumb-item a{
        color:white;
    }*/
</style>


<form name="pageForm_Livr" id="pageForm_Livr" action="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #ffefef; ">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login"><?php echo $this->lang->line('accueil'); ?></a></li>
            <?php if($page =='livreList') { ?>
                <li class="breadcrumb-item"><?php print $OneBook[0]["Libelle"]; ?></li>
            <?php }?>
            <?php if($page =='livre') { ?>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                    <div class="row" style="flex: 1 0 0%;">
                        <div class="dropdown " style="">
                            <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            <div class="dropdown-menu">
                                <div class="row">
                                    <div class="col-md-12" style="padding-left: 1.4em;padding-right: 1.4em;">
                                        <input type="text" class="form-control my-3" name="titreLivre" id="titreLivre"  >
                                        <input type="hidden" name="idLivre" id="idLivre" value="<?php print $OneBook[0]['IDLivre']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mt-2" style=" text-align: center;">
                                        <span class="btn btn-info" onclick="set_LivreBack()" ><i class="fas fa-check" ></i> Valider</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>
            <?php }?>
            <?php if($page =='livreDetails') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('chapitres'); ?></li>
            <?php }?>
            <?php if($page =='livreCours') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('cours'); ?></li>
            <?php }?>
            <?php if($page =='livreResume') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('resume'); ?></li>
            <?php }?>
            <?php if($page =='livreQcm') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('qcm'); ?></li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            <?php }?>
            <?php if($page =='livreQroc') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : <?php echo $this->lang->line('qroc'); ?> </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            <?php }?>

            <?php if($page =='test') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php print $OneBook[0]["TitreChapitre"]; ?> : Liste Test </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            <?php }?>

            <?php if($page =='page_test_Figure') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
              
                
                <?php if($this->session->userdata('EstAdmin') == 1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>settingTest/<?php print $OneBook[0]["IDChapitre"]; ?>"><?php print $OneBook[0]["TitreChapitre"]; ?> :List Test </a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["TitreChapitre"]; ?> :List Test</li>
                <?php }?>

                <li class="breadcrumb-item active"> Test  <?php print $idFigure; ?> </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            
            
            <?php }?>

            <?php if($page =='listTestFigure') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
              
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
             
                <li class="breadcrumb-item active"> Test  </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            
            
            <?php }?>

            <?php if($page =='listCalqueFigure') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
              
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
             
                <li class="breadcrumb-item active"> <?php echo $this->lang->line('Calques'); ?>  </li><li class="breadcrumb-item"><div id="titleQu" style="color: green;"></div></li>
            
            
            <?php }?>

            <?php if($page =='evaluatQCM') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('testQCM'); ?></li>
            <?php }?>
            <?php if($page =='evaluatQROC') { ?>
                <?php if($this->session->userdata('EstAdmin') ==1) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?php print $OneBook[0]["IDLivre"]; ?>"><?php print $OneBook[0]["Titre"]; ?></a></li>
                <?php }else{ ?>
                    <li class="breadcrumb-item"><?php print $OneBook[0]["Titre"]; ?></li>
                <?php }?>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('testQROC'); ?></li>
            <?php }?>
        </ol>
    </nav>
    <?php if($page =='evaluatQCM' || $page =='evaluatQROC') { ?>
        <li class="breadcrumb-item active" style="top:-1;text-align: right ; float: right"><p style="padding-left: 1rem;color:red;text-align: right ; position: fixed" id="setMinut"></p></li>
    <?php }?>
</form>
<?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
    <script type="text/javascript" >

        function set_LivreBack()
        {

            var data_plat = new FormData($('#pageForm_Livr')[0]);
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
                url: "<?php echo base_url(); ?>home/set_LivreBack",
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

    </script>
<?php }?>
