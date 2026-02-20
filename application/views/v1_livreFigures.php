<?php
if (strlen($this->session->userdata('passTok')) == 200) {
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Figures - Atlas d'Anatomie Humaine</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
    <link href="<?php echo HTTP_CSS; ?>responsive.css" rel="stylesheet">
    <style>
        body { margin: 0; padding-bottom: 30px; background-color: white; }
        #element { display: flex; flex-wrap: wrap; width: 100%; background-color: white; min-height: 100vh; }
        .col-text { flex: 0 0 48%; max-width: 48%; margin-left: 2%; padding-top: 20px; }
        .col-figures { flex: 0 0 48%; max-width: 48%; margin-right: 2%; }
        @media (max-width: 768px) {
            .col-text, .col-figures { flex: 0 0 100%; max-width: 100%; margin: 0; }
        }
    </style>
</head>

<header style="z-index: 1000; width: 100%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
    <?php include('v1_header_menu.php'); ?>
</header>

<body>
    <div id="element">
        <?php include('v1_racourci.php'); ?>

        <!-- Partie Gauche : Banner -->
        <div class="col-text">
            <?php echo $CursShow; ?>
        </div>

        <!-- Partie Droite : Figures -->
        <div class="col-figures">
            <?php include('v1_bloc_figures.php'); ?>
        </div>
    </div>
</body>

<script src="<?php echo HTTP_JS; ?>app.js"></script>
<script>
    // Initialisation automatique de la première figure
    $(document).ready(function() {
        if ($('.column img').length > 0) {
            $('.column img').first().click();
        }
    });
</script>
</html>

<?php } else { header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login'); exit(); } ?>
