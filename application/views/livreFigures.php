<?php if (strlen($this->session->userdata('passTok')) == 200) { ?>
<!DOCTYPE html>
<html>
<?php include('header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style type="text/css">
    body { margin: 0; font-size: 0px; background-color: white; overflow-x: hidden; }
    .row { --bs-gutter-x: 0px; }
    #element { width: 100%; background-color: white; font-size: 20px; text-align: center; box-sizing: border-box; display: flex; min-height: 100vh; }
    
    /* Division 50/50 */
    .col-left { width: 55%; padding: 10px; border-right: 1px solid #f1f1f1; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; background-color: #fafafa; overflow-y: auto; }
    .col-right { width: 45%; padding: 10px; position: relative; display: flex; flex-direction: column; align-items: center; }

    .slideshow-container { width: 100%; max-width: 100%; position: relative; margin-top: 20px; }
    .mySlides { display: none; width: 100%; text-align: center; }
    
    /* Suppression des animations fade pour éviter les bugs de disparition */
    .mySlides img { width: 100%; height: auto; max-height: 85vh; object-fit: contain; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border-radius: 8px; }

    .prev, .next { cursor: pointer; position: absolute; top: 50%; width: auto; margin-top: -22px; padding: 16px; color: #1d3557; font-weight: bold; font-size: 24px; transition: 0.3s; user-select: none; z-index: 100; border-radius: 50%; background: rgba(255,255,255,0.7); }
    .prev { left: 10px; }
    .next { right: 10px; }
    .prev:hover, .next:hover { background: #1d3557; color: white; }

    .dot-container { text-align: center; padding: 10px; background: white; width: 100%; border-bottom: 1px solid #eee; margin-bottom: 10px; }
    .dot { cursor: pointer; margin: 0 5px; padding: 5px 12px; border-radius: 20px; display: inline-block; transition: 0.3s; font-size: 0.9rem; font-weight: 600; color: #666; background: #f8f9fa; border: 1px solid #dee2e6; }
    .dot.active, .dot:hover { background-color: #1d3557; color: white; border-color: #1d3557; }
    
    .nav-links { position: absolute; top: 20px; left: 20px; font-size: 14px; z-index: 10; }
    .nav-links a { color: #457b9d; text-decoration: none; font-weight: 600; }
</style>
<body>
    <div id="element">
        <!-- Partie Gauche (50%) -->
        <div class="col-left">
            <div class="nav-links">
                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>login"><?php echo $this->lang->line('accueil'); ?></a>
                &nbsp; / &nbsp;
                <a href="<?php echo base_url(); ?><?php echo $this->lang->line('siteLang'); ?>livreDetails/<?php print $OneBook[0]["IDLivre"]; ?>"><?php echo $this->lang->line('chapitres'); ?></a>
            </div>
            <div style="width: 100%; max-width: 1000px; padding-top: 20px;">
                <?php echo $CursShow; ?>
            </div>
        </div>

        <!-- Partie Droite (50%) -->
        <div class="col-right">
            <div class="dot-container" id="namelistFig">
                <?php $counter = 1; foreach ($listFig as $value) { ?>
                    <span id="Nam_<?php print base64_encode($value['IDFigure']); ?>" class="dot" onclick="currentSlide(<?= $counter; ?>)">
                        <?= $value['TitreFigure']; ?>
                    </span>
                <?php $counter++; } ?>
            </div>

            <div class="slideshow-container">
                <?php $counter = 1; foreach ($listFig as $value) { ?>
                    <div class="mySlides" id="Fig_<?php print base64_encode($value['IDFigure']); ?>">
                        <img src="data:image/png;base64,<?= $value['encryptFigure']; ?>" />
                    </div>
                <?php $counter++; } ?>

                <?php if (count($listFig) > 1) { ?>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
<script>
    var slideIndex = 1;
    
    $(document).ready(function() {
        showSlides(slideIndex);
    });

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        
        if (n > slides.length) { slideIndex = 1; }
        if (n < 1) { slideIndex = slides.length; }
        
        // Cacher tous les slides
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        
        // Retirer la classe active de tous les points
        for (i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
        }
        
        // Afficher le slide courant
        if (slides[slideIndex - 1]) {
            slides[slideIndex - 1].style.display = "block";
        }
        
        // Activer le point courant
        if (dots[slideIndex - 1]) {
            dots[slideIndex - 1].classList.add("active");
        }
    }
</script>
</html>
<?php } else { header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login'); exit(); } ?>
