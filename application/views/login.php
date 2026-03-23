<?php
include('header.php');
?>
<style>
    #couvImg{
        transition: transform 0.3s;
    }
    #couvImg:hover{
        transform: scale(1.1);
        /*box-shadow: 1px 1px 2px grey, -1px -1px 2px grey;*/
        box-shadow: 10px 10px 5px #ccc;
    }
    .containerSo {
        position: relative;
    }

    /* Bottom right text */
    .text-block {
        position: absolute;
        color: white;
        top: 8px;
        left: 16px;
    }
    @import url('https://fonts.googleapis.com/css?family=Poppins:900i');

    /**************SVG****************/

    path.one {
        transition: 0.4s;
        transform: translateX(-60%);

        animation: color_anim 1s infinite 0.4s;
    }

    path.two {
        transition: 0.5s;
        transform: translateX(-30%);
    }

    path.three {
        animation: color_anim 1s infinite 0.2s;
    }

    path.one {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.6s;
    }

    path.two {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.4s;
    }

    /* SVG animations */

    @keyframes color_anim {
        0% {
            fill: white;
        }
        50% {
            fill: #FBC638;
        }
        100% {
            fill: white;
        }
    }
</style>
<body oncontextmenu="return false" onbeforeprint="return false" onselectstart="return false" ondragstart="return false">
<?php
include('header_steppes.php');
?>
<div class="wrapper">

    <div class="main"   ondragstart="return false">
        <main class="content">
            <div class="container-fluid p-0" id="setCouv">
                <form name="pageForm_up" id="pageForm_up" action="">
                    <?php foreach ($listCat as $value) { ?>
                        <?php if($value['Cats']['EstActifAccueil'] == 1) { ?>
                            <?php if($value['Cats']['OrdreCat'] < 0) { ?>
                                <div class="row">
                                    <h1 class="h2 mb-3" style="font-family: Georgia, serif;font-size: 190%;margin-top: 0.3em;width: 12em;"><?=$value['Cats']['Libelle'];?></h1>
                                    <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                        <div class="row" style="flex: 1 0 0%;padding-left: 0em;">

                                            <a href="#" data-toggle="modal" data-target="#sizedModalSm">
                                                <i class="fa fa-plus" title="<?php echo $this->lang->line('actionAjout'); ?>"></i>
                                            </a>
                                            <div class="modal fade" id="sizedModalSm" tabindex="-1" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Thème</label>
                                                                <input type="text" class="form-control" name="titreItem" id="titreItem" placeholder="Saisir un thème">
                                                            </div>
                                                            <div class="mb-3">
                                                                <div <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="EstActifMenu" checked="" name="EstActifMenu" >
                                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activer dans le menu</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="EstActifAccueil" checked="" name="EstActifAccueil">
                                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activer dans le contenue</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Ordre</label>
                                                                <input type="number" class="form-control" min="1" value="<?php echo count($listCat) ?>"  style="text-align: left;" name="inputOrdreCat">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="set_ChapCatItem()" >Save changes</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="containerSo">
                                    <img class="card-img-top" src="<?php echo HTTP_IMAGES; ?><?=$value['Cats']['Couverture'];?>" alt="">

                                    <div class="text-block" style="top: -0px;">
                                        <div class="row" style="vertical-align: middle;">
                                            <?=$value['Cats']['Description'];?>
                                        </div>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <h2 class="h2 mb-1" style="font-family: Georgia, serif;display: none;font-size: 180%;"><?=$value['Cats']['Libelle'];?></h2>

                            <?php }?>

                            <?php foreach ($value['items'] as $valItem) { ?>
                                <div class="row">
                                    <h1 class="h2 mb-1" style="font-family: Georgia, serif;font-size: 180%;width: 13em;"><?=$valItem ['items'] ['LibelleTheme'];?></h1>
                                    <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                        <div class="row" style="flex: 1 0 0%;padding-left: 0em;">
                                            <div class="dropdown " style="">
                                                <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="">
                                                    <i class="fa fa-pencil-alt" title="<?php echo $this->lang->line('actionEdit'); ?>"></i>
                                                </a>
                                                <a href="#" data-toggle="modal" data-target="#modalItem_<?=$valItem ['items'] ['IDTheme'];?>">
                                                    <i class="fa fa-plus" title="<?php echo $this->lang->line('actionAjout'); ?>"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding-left: 1.4em;padding-right: 1.4em;">
                                                            <input type="text" class="form-control my-3" name="setTitreItem[]" id="setTitreItem"  >
                                                            <input type="hidden" name="set_IdItm[]" id="set_IdItm" value="<?php print $valItem ['items'] ['IDTheme']; ?>">
                                                            <input type="hidden" name="set_IdCat[]" id="set_IdCat" value="<?php print $value['Cats']['IDCategory']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mt-2" style=" text-align: center;">
                                                            <span class="btn btn-info" onclick="set_ItemBack()" ><i class="fas fa-check" ></i> Valider</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="modalItem_<?=$valItem ['items'] ['IDTheme'];?>" tabindex="<?=$valItem ['items'] ['IDTheme'];?>" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="h2 mb-1" style="font-family: Georgia, serif;font-size: 180%;"><?=$valItem ['items'] ['LibelleTheme'];?></h3>
                                                            <input type="hidden" name="itemID[]" id="itemID[]" value="<?=$valItem ['items'] ['IDTheme'];?>">
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="list_wrapper_<?=$valItem ['items'] ['IDTheme'];?>">
                                                                <div class="row">

                                                                    <div class="col-xs-7 col-sm-7 col-md-7">
                                                                        <div class="form-group">
                                                                            Livre 1
                                                                            <input name="list[<?=$valItem ['items'] ['IDTheme'];?>][]" type="text" placeholder="Titre de livre" class="form-control"/>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xs-1 col-sm-1 col-md-1">
                                                                        <br>
                                                                        <button class="btn btn-primary list_add_button" type="button" value="<?=$valItem ['items'] ['IDTheme'];?>">+</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="set_LivItem(<?=$valItem ['items'] ['IDTheme'];?>)" >Save changes</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="row">

                                    <?php foreach ($valItem['books'] as $valBook) { ?>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                                <div class="dropdown " style="padding-left: 1.5em">
                                                    <a href="#" data-toggle="dropdown" data-display="static" aria-expanded="false" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                    </a>
                                                    <a href="#" onclick="delLiv('<?php print base64_encode($valBook['IDLivre']); ?>')" id="<?php print base64_encode($valBook['IDLivre']); ?>" name="<?php print $valBook['Titre']; ?>" >
                                                        <i class="fa fa-trash-alt" title="<?php echo $this->lang->line('actionSupp'); ?>"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <input type="file" name="mFile[]" id="mFile" readonly class="btn btn-info btn-sm" accept="image/png" >
                                                                <input type="hidden" name="attach_file[]" id="attach_file" value="<?php print $valBook['IDLivre']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mt-2" style=" text-align: center;">
                                                                <span class="btn btn-info" onclick="set_Couv()"><i class="fas fa-upload"></i> Upload (.PNG)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <a href="#descBKL_<?php print $valBook['IDLivre']; ?>" data-toggle="modal" data-target="#descBKL_<?php print $valBook['IDLivre']; ?>"
                                               class="list-group-item" style="width: 85%;border: white;padding-top: 0.8rem">
                                                <?php if($valBook['encryptCouverture'] =='') { ?>
                                                    <img  id="couvImg" class="card-img-top" src="<?php echo HTTP_IMAGES; ?>photos/NoPicture.png" alt="" title="<?=$valBook['Titre'];?>">
                                                <?php } else { ?>
                                                    <img id="couvImg" class="card-img-top"  src="data:image/png;base64,<?php print $valBook['encryptCouverture']; ?> "></img>
                                                    <h4></h4>
                                         <!-- <h4><?=$valBook['Titre'];?></h4>-->
                                                <?php }?>
                                            </a>
                                            <div class="modal fade" id="descBKL_<?php print $valBook['IDLivre']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog" role="document">
                                                    <div class="modal-content" style="box-shadow: 0 0 0 50vmax rgba(0,0,0,.0);">
                                                        <form name="pageForm_desc" id="pageForm_desc" action="">
                                                            <?php if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) { ?>
                                                                <div class="col-2" style="display: flex;justify-content: left;">
                                                                    <div class="dropdown " style="">
                                                                        <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livre/<?=$valBook['IDLivre'];?>" class="" title="<?php echo $this->lang->line('actionEdit'); ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="card" style="height: 100%;" >
                                                                <?php if(strlen($this->session->userdata('passTok'))==200) { ?>
                                                                    <a id="showBK" href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?=$valBook['IDLivre'];?>"  class="btn btn-primary btn-block" style="font-size: 1.4em;display: block;margin: auto;font-weight: bold;background-color: background-color:#8d93f7;">
                                                                        <?php echo $this->lang->line('showBook'); ?>
                                                                        <span>
      																		<svg width="30px" height="20px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        										<g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          											<path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
													<path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          											<path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        										</g>
      										</svg>
    																	</span>
                                                                    </a>
                                                                <?php }else{ ?>
                                                                    <button type="button" onclick="redirectLogLivr(<?=$valBook['IDLivre'];?>)"  class="btn btn-primary btn-block" style="background-color:#8d93f7;display: block;margin: auto; font-size: 1.4em;font-weight: bold;" data-toggle="modal" data-target="#centeredModalPrimary">
                                                                        <?php echo $this->lang->line('showBook'); ?>
                                                                        <span>
      																		<svg width="30px" height="20px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        										<g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          											<path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
													<path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          											<path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        										</g>
      										</svg>
    																	</span>
                                                                    </button>
                                                                <?php } ?>
                                                                <div class="card-body" style="padding: 0rem;">
                                                                    <div id="tasks-progress">
                                                                        <div class="card mb-3 bg-light cursor-grab border">
                                                                            <div class="card-body p-4" id="demo" style="background-color: white;overflow-y: scroll;height: 75vh;">
                                                                                <?php
                                                                                $html = $valBook["Description"];
                                                                                if(!empty($html)){
                                                                                    preg_match('/<div class=WordSection1>(.*?)<\/div>/s', $html, $match);
                                                                                    if(sizeof($match)>0){
                                                                                        echo $match[0];
                                                                                    }else{
                                                                                        preg_match('/<body>(.*?)<\/body>/s', $html, $match2);
                                                                                        if(sizeof($match2)>0){
                                                                                            echo $match2[0];
                                                                                        }else{echo $html;}

                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>

                                </div>

                            <?php }?>

                            <hr>
                        <?php }?>
                    <?php }?>
                </form>
            </div>
        </main>

    </div>
</div>

<?php
include('footer.php');
?>

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

        function set_ItemBack()
        {

            var data_plat = new FormData($('#pageForm_up')[0]);
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
                url: "<?php echo base_url(); ?>home/set_ItemBack",
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

        function delLiv(idL)
        {
            var tit = document.getElementById(idL).name
            Swal.fire({
                title: '<?php echo $this->lang->line('supp_title'); ?>'+' <br> '+tit,
                text: '<?php echo $this->lang->line('supp_text'); ?>',
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
                        url: "<?php echo base_url(); ?>home/delLiv",
                        data: { idL: idL} ,
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

        function set_Couv()
        {

            var data_plat = new FormData($('#pageForm_up')[0]);

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
                url: "<?php echo base_url(); ?>home/upload_Attach_Save",
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
                                $('#setCouv').load(" #setCouv > *");
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

        function set_ChapCatItem()
        {

            var data_plat = new FormData($('#pageForm_up')[0]);

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
                url: "<?php echo base_url(); ?>home/set_ChapCatItem",
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
                        $('#sizedModalSm').modal('hide');
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

        function set_LivItem(mod_)
        {

            var data_plat = new FormData($('#pageForm_up')[0]);

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
                url: "<?php echo base_url(); ?>home/set_LivItem",
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
                        $('#modalItem_'+mod_).modal('hide');
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

        function delBook(iTH,xx)
        {
            var elem= document.getElementsByClassName('row '+xx);
            $("#"+iTH+'_'+xx).remove(); //Remove field html
            //x--; //Decrement field counter
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
                var list_fieldHTML = '<div style="margin-top: 0.5em" class="row '+x+'" id='+idTh+'_'+x+'><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="list['+idTh+'][]" type="text" placeholder="Livre '+cmp+'" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><button type="button" class="btn btn-danger list_remove_button" onclick="delBook('+idTh+','+x+')" value="'+idTh+'">-</button></div></div>'; //New input field html
                $(".list_wrapper_"+idTh).append(list_fieldHTML); //Add field html
                //}
            });


        });

    </script>

<?php }?>
