<?php
if (strlen($this->session->userdata('passTok')) == 200) {
?>

<!DOCTYPE html>
<html <?php echo aa_html_attrs(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membre Supérieur - Atlas d'Anatomie Humaine</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-size: 0px;
            padding-bottom: 30px;
            height: 400px;
            margin-bottom: 30px;
        }
        .row {
            --bs-gutter-x: 0px;
        }
        .card-header {
            padding: 0rem 0rem;
        }
        #element {
            padding-bottom: 30px;
            height: 120px;
            width: 100%;
            background-color: white;
            text-align: center;
            box-sizing: border-box;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
        }
        .table.dataTable th {
            display: none;
        }
        .my-1 {
            margin-top: .0rem !important;
        }
        .toolbar {
            display: none !important;
        }
        .table.dataTable {
            clear: both;
            margin-top: 0px !important;
            margin-bottom: 1px !important;
        }
        .dataTables_info {
            visibility: hidden;
        }
        .table td, .table tfoot, .table th, .table thead, .table tr {
            padding: .0rem;
        }
        .btn-outline-primary:hover {
            background-color: #c5daef;
        }
        .btn-outline-primary.active {
            background-color: #c5daef;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .container {
            position: relative;
            width: 95%;
            height: 16rem;
            margin: 0px auto;
            text-align: center;
            overflow-x: hidden;
            overflow-y: auto;
            display: block;
        }
        @media (max-width: 480px) {
            .container {
                width: 90%;
                height: 25vh;
            }
            body {
                height: 300px;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
            #element {
                height: 100px;
                padding-bottom: 20px;
            }
            .carreaux_lec {
                width: 140px;
                height: 25px;
                font-size: 10px;
            }
        }
        @media (min-width: 481px) and (max-width: 768px) {
            .container {
                width: 88%;
                height: 30vh;
            }
            body {
                height: 350px;
                padding-bottom: 25px;
                margin-bottom: 25px;
            }
            #element {
                height: 110px;
                padding-bottom: 25px;
            }
            .carreaux_lec {
                width: 150px;
                height: 28px;
                font-size: 11px;
            }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .container {
                width: 85%;
                height: 50vh;
            }
            body {
                height: 400px;
            }
            #element {
                height: 120px;
            }
        }
        @media (min-width: 1025px) and (max-width: 1440px) {
            .container {
                width: 80%;
                height: 55vh;
            }
            body {
                height: 450px;
            }
            #element {
                height: 130px;
            }
        }
        @media (min-width: 1441px) {
            .container {
                width: 75%;
                height: 60vh;
            }
            body {
                height: 500px;
            }
            #element {
                height: 140px;
            }
        }
        .carreaux_lec {
            width: 160px;
            height: 28px;
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: white;
            justify-content: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            display: flex;
            font-size: 11px;
            letter-spacing: 0.2px;
            align-items: center;
            font-weight: bold;
        }
        * {
            box-sizing: border-box;
        }
        #element {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 1px;
        }
        .left-column {
            flex: 1 1 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }
        @media(min-width: 768px) {
            .left-column {
                flex: 0 0 45%;
                max-width: 45%;
                margin-left: 2%;
            }
        }
        .right-column {
            flex: 1 1 100%;
            max-width: 100%;
        }
        @media(min-width: 768px) {
            .right-column {
                flex: 0 0 45%;
                max-width: 45%;
                margin-left: 2%;
            }
        }
        .input-group-navbar {
            flex-wrap: wrap;
        }
        .col-12.col-lg-6.col-xl-6 {
            padding: 5px;
        }
        @media (max-width: 768px) {
            .col-12.col-lg-6.col-xl-6 {
                width: 95% !important;
                margin-left: 2.5% !important;
                float: none !important;
            }
        }
        @media (min-width: 769px) {
            .col-12.col-lg-6.col-xl-6:first-of-type {
                width: 40% !important;
                margin-left: 5% !important;
            }
            .col-12.col-lg-6.col-xl-6:last-of-type {
                width: 55% !important;
                margin-left: 0% !important;
            }
        }

        /* Cours : un SEUL scroll, sur le wrapper externe (#demo) — boîte à hauteur fixe.
           Les iframes internes (#iframeID + srcdoc) sont agrandies en JS pour ne pas créer
           de scrolls imbriqués : #demo défile alors la totalité du contenu. */
        #demo {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: calc(100vh - 120px) !important;
        }

        /* La colonne figures passe à 60%, mais on NE grossit PAS la figure : on plafonne la
           figure et la bande de miniatures à leur largeur actuelle (≈40vw) et on les centre
           dans la colonne. L'affichage interne du bloc reste donc identique. */
        #element .container-fig,
        #element .scroll-container {
            max-width: 40vw !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    </style>

    <?php include('components/aa_cours_responsive.php'); ?>
<?php echo aa_rtl_assets(); ?>
</head>

<header style="z-index: 1000; width: 100%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
    <?php include('v1_header_menu.php'); ?>
</header>

<body>
    <div id="element">
        <?php include('v1_racourci.php'); ?>

<div class="col-12 col-lg-6 col-xl-6" style="float: left; width: 40%; margin-left: 5%;">
                <div class="row">
                <li class="breadcrumb-item">
                    &nbsp;&nbsp;
                    <div style="display: flex; align-items: center; gap: 5px; margin-left: auto;">
                        <?php if ($this->session->userdata('EstAdmin') == 1): ?>
                            <button class="badge bg-info text-white border-0"
                                    onclick="openAddImageRappelModal('<?= $OneBook[0]['IDChapitre']; ?>')"
                                    style="cursor:pointer; background-color: #457b9d !important; font-size: 10px; height: 28px; padding: 0 10px; border-radius: 5px;">
                                <i class="fa fa-image"></i> <?php echo $this->lang->line('btn_manage_recall_images'); ?>
                            </button>
                            <button class="badge bg-info text-white border-0"
                                    onclick="openFigureSvgModal()"
                                    style="cursor:pointer; background-color: #1d3557 !important; font-size: 10px; height: 28px; padding: 0 10px; border-radius: 5px;">
                                <i class="fa fa-vector-square"></i> <?php echo $this->lang->line('btn_manage_svg_figures'); ?>
                            </button>
                        <?php endif; ?>
                        <div style="display: flex; gap: 15px; padding-top: 5px;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <input name="keywordsIN" id="keywordsIN" type="text"
                                    style="border: 1px solid #ced4da; transition: 0.3s; max-width: 170px; height: 28px; padding: 2px;"
                                    value="<?php echo isset($indexSearch) ? urldecode($indexSearch) : ''; ?>"
                                    class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…" >
                                <button class="btn" onclick="mySearchIndx();"
                                    style="display: flex; align-items: center; justify-content: center; height: 28px; padding: 2px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        var input = document.getElementById("keywordsIN");
                        input.addEventListener("keyup", function(event) {
                            if (event.keyCode === 13) {
                                event.preventDefault();
                                mySearchIndx();
                            }
                            document.getElementById("keywordsIN").focus();
                        });

                        function mySearchIndx() {
                            var iframe = document.getElementById("iframeID");
                            var elmnt = iframe.contentWindow.document.getElementById("btn_search");
                            var elmntSearchIN = document.getElementById("keywordsIN");
                            var elmntSearch = iframe.contentWindow.document.getElementById("keywords");
                            elmntSearch.value = elmntSearchIN.value;
                            elmnt.click();
                        }
                    </script>
                </li>
            </div>
            <div class="row">
                <?php if (isset($showBannerFigures) && $showBannerFigures === true): ?>
                    <!-- ✅ Forcer l'affichage du banner informatif -->
                    <?php echo $CursShow; ?>
                <?php else: ?>
                    <?php echo isset($CursShow) ? $CursShow : '<p>Aucun contenu à afficher.</p>'; ?>
                <?php endif; ?>
            </div>
        </div>

<div class="col-12 col-lg-6 col-xl-6" style="float: right; width: 55%; margin-right: 0;">
            <?php include('v1_bloc_figures.php'); ?>
        </div>
    </div>

    <?php include('v1_modal_mode_lecture.php'); ?>

    <script>
        // Le cours est dans une iframe (#iframeID, même origine) elle-même dans un wrapper (#demo).
        // On agrandit l'iframe à la hauteur de son contenu : plus de scroll imbriqué, seule la page défile.
        function autoSizeCursOuter() {
            var iframe = document.getElementById('iframeID');
            if (!iframe) return;
            try {
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                if (doc) {
                    var h = Math.max(
                        doc.body ? doc.body.scrollHeight : 0,
                        doc.documentElement ? doc.documentElement.scrollHeight : 0
                    );
                    if (h > 0) iframe.style.height = (h + 20) + 'px';
                }
            } catch (e) {
                // Cross-origin : on ne peut pas lire la hauteur, on laisse tel quel.
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            var iframe = document.getElementById('iframeID');
            if (iframe) iframe.addEventListener('load', autoSizeCursOuter);
        });
        window.addEventListener('load', autoSizeCursOuter);
        // L'iframe interne et ses images se mettent en page après coup : on réessaie plusieurs fois.
        [400, 900, 1600, 2500, 3500].forEach(function (t) { setTimeout(autoSizeCursOuter, t); });
    </script>
</body>

<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="<?php echo HTTP_JS; ?>app.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
    <!-- Modal Gérer les images de rappel -->
    <div class="modal fade" id="addImageRappelModal" tabindex="-1" aria-hidden="true" style="z-index: 10000; position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: none; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div class="modal-dialog modal-dialog-centered" style="max-width:800px; width: 90%; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background: #1d3557; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="modal-title" style="margin: 0; font-size: 1.25rem;"><?php echo $this->lang->line('modal_recall_images'); ?></h2>
                    <button type="button" onclick="$('#addImageRappelModal').hide()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
                <div class="modal-body" style="padding: 20px; color: #333;">
                    <div id="listeImagesRappel" style="margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px; font-size: 1rem; color: #1d3557; border-bottom: 2px solid #f1f1f1; padding-bottom: 5px;"><?php echo $this->lang->line('existing_images'); ?></h4>
                        <div id="imagesContainer" style="display: flex; flex-wrap: wrap; gap: 10px; min-height: 50px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                            <!-- JS Content -->
                        </div>
                    </div>
                    <form id="formRappelImage" enctype="multipart/form-data">
                        <input type="hidden" id="rappelChapitreImage" name="rappelChapitre">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;"><?php echo $this->lang->line('add_image_formats'); ?></label>
                            <input type="file" id="rappelImage" name="rappelImage" accept="image/*" onchange="previewImageRappel(event)" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div style="text-align: center; margin-bottom: 15px;">
                            <img id="previewRappelImage" src="" alt="" style="max-width:100%; max-height:200px; display:none; border-radius:8px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                        <div style="text-align: center;">
                            <button type="button" onclick="saveRappelImage()" style="background: #1d3557; color: white; border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; cursor: pointer;"><?php echo $this->lang->line('save'); ?></button>
                            <button type="button" onclick="$('#addImageRappelModal').hide()" style="background: #ccc; border: none; padding: 10px 25px; border-radius: 6px; margin-left: 10px; cursor: pointer;"><?php echo $this->lang->line('fermer'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    /* Libelles des deux modales d'administration (images de rappel, figures
       interactives) : ils vivent dans des Swal.fire() et des confirm(), hors de
       portee d'un echo PHP au fil du texte, et plusieurs contiennent une
       apostrophe -- json_encode les echappe correctement. */
    var AA_COURS_I18N = <?php echo json_encode(array(
        'image_added'             => $this->lang->line('image_added'),
        'image_delete_confirm'    => $this->lang->line('image_delete_confirm'),
        'files_missing'           => $this->lang->line('files_missing'),
        'fig_select_files'        => $this->lang->line('fig_select_files'),
        'unexpected_response'     => $this->lang->line('unexpected_response'),
        'fig_html_saved'          => $this->lang->line('fig_html_saved'),
        'fig_svg_saved'           => $this->lang->line('fig_svg_saved'),
        'reload_to_view'          => $this->lang->line('reload_to_view'),
        'refused'                 => $this->lang->line('refused'),
        'error_title'             => $this->lang->line('error_title'),
        'upload_failed'           => $this->lang->line('upload_failed'),
        'fields_missing'          => $this->lang->line('fields_missing'),
        'fig_title_file_required' => $this->lang->line('fig_title_file_required'),
        'fig_created'             => $this->lang->line('fig_created'),
        'reload_to_display'       => $this->lang->line('reload_to_display'),
        'fig_delete_confirm'      => $this->lang->line('fig_delete_confirm'),
        'fig_status_png_only'     => $this->lang->line('fig_status_png_only'),
    ), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    function openAddImageRappelModal(idChapitre) {
        document.getElementById('rappelChapitreImage').value = idChapitre;
        document.getElementById('rappelImage').value = '';
        document.getElementById('previewRappelImage').style.display = 'none';
        loadRappelImages(idChapitre);
        $('#addImageRappelModal').css('display', 'flex');
    }

    function loadRappelImages(idChapitre) {
        const baseUrl = "<?php echo base_url(); ?>";
        fetch(`${baseUrl}home/getRappelImages`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idChapter: idChapitre })
        })
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('imagesContainer');
            if (data.success && data.data.length > 0) {
                let html = '';
                data.data.forEach(img => {
                    html += `
                        <div style="position: relative; width: 100px;">
                            <img src="data:image/jpeg;base64,${img.ImageData}" style="width: 100%; height: 80px; object-fit: cover; border-radius: 4px;">
                            <button type="button" onclick="deleteRappelImageItem(${img.IDImageRappel}, ${idChapitre})" style="position: absolute; top: -5px; right: -5px; background: #e63946; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
                        </div>`;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p style="font-size: 12px; color: #999; font-style: italic;">Aucune image</p>';
            }
        });
    }

    function previewImageRappel(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewRappelImage');
        if (file) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(file);
        }
    }

    function saveRappelImage() {
        const formData = new FormData(document.getElementById('formRappelImage'));
        const idChapitre = document.getElementById('rappelChapitreImage').value;
        if (!document.getElementById('rappelImage').files[0]) return;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/saveRappelImage',
            data: formData,
            cache: false, contentType: false, processData: false,
            success: function(response) {
                const result = JSON.parse(response);
                if (result[0].id == '1') {
                    Swal.fire({ icon: 'success', title: AA_COURS_I18N.image_added, timer: 1000, showConfirmButton: false });
                    loadRappelImages(idChapitre);
                    document.getElementById('formRappelImage').reset();
                    document.getElementById('previewRappelImage').style.display = 'none';
                }
            }
        });
    }

    function deleteRappelImageItem(idImage, idChapitre) {
        if (!confirm(AA_COURS_I18N.image_delete_confirm)) return;
        fetch('<?php echo base_url(); ?>home/deleteRappelImage', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idImage: idImage })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) loadRappelImages(idChapitre);
        });
    }
    </script>

    <?php if ($this->session->userdata('EstAdmin') == 1): ?>
    <!-- Modal Gérer les figures SVG interactives (paire .svg + .json par figure) -->
    <!-- NB : aucune classe Bootstrap ici ("modal fade" rend invisible via .fade{opacity:0},
         et .modal-dialog/.modal-content cassent la largeur) : tout est stylé inline, fluide. -->
    <div id="figureSvgModal" tabindex="-1" aria-hidden="true" style="z-index: 10000; position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: none; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
        <div style="background: #fff; border-radius: 12px; width: min(1050px, 96vw); max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="background: #1d3557; color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex: 0 0 auto;">
                <h2 style="margin: 0; font-size: 1.15rem;"><?php echo $this->lang->line('modal_svg_figures'); ?></h2>
                <button type="button" onclick="$('#figureSvgModal').hide()" style="background: none; border: none; color: #fff; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div style="padding: 16px 20px; color: #333; overflow-y: auto; flex: 1 1 auto;">
                <p style="font-size: 12px; color: #6b7280; margin-top: 0;">
                    <?php echo $this->lang->line('fig_intro'); ?>
                </p>
                <!-- data-label sur chaque cellule : sous 768px, cours-responsive.css
                     replie le tableau en fiches et affiche ces libellés à la place
                     de l'en-tête (voir "Modale figures interactives"). -->
                <table class="aa-fig-table" style="width: 100%; border-collapse: collapse; font-size: 13px; table-layout: fixed;">
                    <thead>
                        <tr style="border-bottom: 2px solid #1d3557; text-align: left;">
                            <th style="padding: 6px; width: 13%;"><?php echo $this->lang->line('fig_col_figure'); ?></th>
                            <th style="padding: 6px; width: 10%;"><?php echo $this->lang->line('fig_col_status'); ?></th>
                            <th style="padding: 6px; width: 19%;"><?php echo $this->lang->line('fig_col_html'); ?></th>
                            <th style="padding: 6px; width: 19%;"><?php echo $this->lang->line('fig_col_svg'); ?></th>
                            <th style="padding: 6px; width: 19%;"><?php echo $this->lang->line('fig_col_json'); ?></th>
                            <th style="padding: 6px; width: 20%;"><?php echo $this->lang->line('fig_col_actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($listFig) && is_array($listFig)) foreach ($listFig as $figRow): ?>
                        <tr id="svgRow_<?= (int) $figRow['IDFigure']; ?>" style="border-bottom: 1px solid #eee;">
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_figure')); ?>" style="padding: 6px; font-weight: 600; color: #1d3557; overflow: hidden; text-overflow: ellipsis;"><?= html_escape($figRow['TitreFigure']); ?></td>
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_status')); ?>" style="padding: 6px;">
                                <?php
                                    $figPngOnly   = empty($figRow['hasHtml']) && empty($figRow['hasSvg']);
                                    $figStatus    = !empty($figRow['hasHtml']) ? 'HTML ✓' : (!empty($figRow['hasSvg']) ? 'SVG ✓' : $this->lang->line('fig_status_png_only'));
                                    $figStatusCss = $figPngOnly ? 'background:#f3f4f6; color:#6b7280;' : 'background:#d1fae5; color:#065f46;';
                                ?>
                                <span class="svg-status" style="display:inline-block; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; <?= $figStatusCss; ?>">
                                    <?= $figStatus; ?>
                                </span>
                            </td>
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_html')); ?>" style="padding: 6px;"><input type="file" accept=".html,.htm,text/html" class="htmlFileInput" style="width: 100%; font-size: 11px;"></td>
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_svg')); ?>" style="padding: 6px;"><input type="file" accept=".svg,image/svg+xml" class="svgFileInput" style="width: 100%; font-size: 11px;"></td>
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_json')); ?>" style="padding: 6px;"><input type="file" accept=".json,application/json" class="jsonFileInput" style="width: 100%; font-size: 11px;"></td>
                            <td data-label="<?php echo html_escape($this->lang->line('fig_col_actions')); ?>" style="padding: 6px; white-space: nowrap;">
                                <button type="button" onclick="saveFigureSvgRow(<?= (int) $figRow['IDFigure']; ?>)"
                                        style="background: #1d3557; color: white; border: none; padding: 4px 10px; border-radius: 5px; cursor: pointer; font-size: 12px;"><?php echo $this->lang->line('save'); ?></button>
                                <button type="button" onclick="deleteFigureSvgRow(<?= (int) $figRow['IDFigure']; ?>)"
                                        style="background: #e63946; color: white; border: none; padding: 4px 10px; border-radius: 5px; cursor: pointer; font-size: 12px; margin-left: 4px;"><?php echo $this->lang->line('supprimer'); ?></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Ajout d'une NOUVELLE figure (crée la ligne _figure + HTML autonome OU paire SVG/JSON) -->
                <div style="margin-top: 20px; border-top: 2px solid #1d3557; padding-top: 14px;">
                    <h3 style="font-size: 1rem; color: #1d3557; margin: 0 0 10px;"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('add_new_figure'); ?></h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;">
                        <div style="flex: 1 1 150px; min-width: 130px;">
                            <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px;"><?php echo $this->lang->line('fig_title_free'); ?></label>
                            <input type="text" id="newFigTitle" placeholder="Ex : Fig9" maxlength="50" autocomplete="off"
                                   onclick="this.focus();"
                                   style="width: 100%; border: 1px solid #1d3557; border-radius: 4px; padding: 7px 8px; box-sizing: border-box; font-size: 13px; color: #1d3557; background: #fff;">
                        </div>
                        <div style="flex: 1 1 180px; min-width: 160px;">
                            <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px;"><?php echo $this->lang->line('fig_file_html_priority'); ?></label>
                            <input type="file" id="newFigHtml" accept=".html,.htm,text/html" style="width: 100%; font-size: 11px;">
                        </div>
                        <div style="flex: 1 1 180px; min-width: 160px;">
                            <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px;"><?php echo $this->lang->line('fig_col_svg'); ?></label>
                            <input type="file" id="newFigSvg" accept=".svg,image/svg+xml" style="width: 100%; font-size: 11px;">
                        </div>
                        <div style="flex: 1 1 180px; min-width: 160px;">
                            <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px;"><?php echo $this->lang->line('fig_col_json'); ?></label>
                            <input type="file" id="newFigJson" accept=".json,application/json" style="width: 100%; font-size: 11px;">
                        </div>
                        <button type="button" onclick="addFigureSvgNew()"
                                style="background: #2d5e51; color: white; border: none; padding: 7px 16px; border-radius: 5px; cursor: pointer; font-size: 13px; font-weight: 600; flex: 0 0 auto;"><?php echo $this->lang->line('ajouter'); ?></button>
                    </div>
                    <p style="font-size: 11px; color: #6b7280; margin: 8px 0 0;">
                        <?php echo $this->lang->line('fig_hint'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openFigureSvgModal() {
        $('#figureSvgModal').css('display', 'flex');
    }

    /* interactif = un booleen explicite : comparer le libelle au texte
       « PNG seul » cassait des que celui-ci etait traduit. */
    function setSvgRowStatus(idFigure, label, isInteractive) {
        const badge = document.querySelector('#svgRow_' + idFigure + ' .svg-status');
        if (!badge) return;
        badge.textContent = label;
        badge.style.background = isInteractive ? '#d1fae5' : '#f3f4f6';
        badge.style.color = isInteractive ? '#065f46' : '#6b7280';
    }

    function saveFigureSvgRow(idFigure) {
        const row = document.getElementById('svgRow_' + idFigure);
        const htmlInput = row.querySelector('.htmlFileInput');
        const svgInput = row.querySelector('.svgFileInput');
        const jsonInput = row.querySelector('.jsonFileInput');

        // Aiguillage : un .html sélectionné est prioritaire ; sinon la paire .svg + .json
        const isHtml = !!htmlInput.files[0];
        if (!isHtml && (!svgInput.files[0] || !jsonInput.files[0])) {
            Swal.fire({ icon: 'warning', title: AA_COURS_I18N.files_missing, text: AA_COURS_I18N.fig_select_files });
            return;
        }

        const formData = new FormData();
        formData.append('IDFigure', idFigure);
        if (isHtml) {
            formData.append('htmlFile', htmlInput.files[0]);
        } else {
            formData.append('svgFile', svgInput.files[0]);
            formData.append('jsonFile', jsonInput.files[0]);
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/' + (isHtml ? 'saveFigureHtml' : 'saveFigureSvg'),
            data: formData,
            cache: false, contentType: false, processData: false,
            success: function(response) {
                let result;
                try {
                    result = JSON.parse(response);
                } catch (e) {
                    // Réponse non-JSON (warning PHP, page d'erreur…) : on l'affiche au lieu d'échouer en silence
                    Swal.fire({ icon: 'error', title: AA_COURS_I18N.unexpected_response, html: '<pre style="text-align:left; font-size:10px; max-height:200px; overflow:auto;">' + String(response).substring(0, 800).replace(/</g, '&lt;') + '</pre>' });
                    return;
                }
                if (result[0].id == '1') {
                    Swal.fire({ icon: 'success', title: isHtml ? AA_COURS_I18N.fig_html_saved : AA_COURS_I18N.fig_svg_saved, text: AA_COURS_I18N.reload_to_view, timer: 2500, showConfirmButton: false });
                    setSvgRowStatus(idFigure, isHtml ? 'HTML ✓' : 'SVG ✓', true);
                    htmlInput.value = '';
                    svgInput.value = '';
                    jsonInput.value = '';
                } else {
                    Swal.fire({ icon: 'error', title: AA_COURS_I18N.refused, text: result[0].desc });
                }
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: AA_COURS_I18N.error_title, text: AA_COURS_I18N.upload_failed + ' (HTTP ' + (xhr && xhr.status ? xhr.status : '?') + ').' });
            }
        });
    }

    function addFigureSvgNew() {
        const titre = document.getElementById('newFigTitle').value.trim();
        const htmlF = document.getElementById('newFigHtml').files[0];
        const svgF = document.getElementById('newFigSvg').files[0];
        const jsonF = document.getElementById('newFigJson').files[0];

        // Aiguillage : un .html sélectionné est prioritaire ; sinon la paire .svg + .json
        if (!titre || (!htmlF && (!svgF || !jsonF))) {
            Swal.fire({ icon: 'warning', title: AA_COURS_I18N.fields_missing, text: AA_COURS_I18N.fig_title_file_required });
            return;
        }

        const formData = new FormData();
        formData.append('IDCours', '<?= (isset($OneCurs[0]['IDCours'])) ? (int) $OneCurs[0]['IDCours'] : 0; ?>');
        formData.append('titre', titre);
        if (htmlF) {
            formData.append('htmlFile', htmlF);
        } else {
            formData.append('svgFile', svgF);
            formData.append('jsonFile', jsonF);
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/' + (htmlF ? 'addFigureHtml' : 'addFigureSvg'),
            data: formData,
            cache: false, contentType: false, processData: false,
            success: function(response) {
                let result;
                try {
                    result = JSON.parse(response);
                } catch (e) {
                    // Réponse non-JSON (warning PHP, page d'erreur…) : on l'affiche au lieu d'échouer en silence
                    Swal.fire({ icon: 'error', title: AA_COURS_I18N.unexpected_response, html: '<pre style="text-align:left; font-size:10px; max-height:200px; overflow:auto;">' + String(response).substring(0, 800).replace(/</g, '&lt;') + '</pre>' });
                    return;
                }
                if (result[0].id == '1') {
                    Swal.fire({ icon: 'success', title: AA_COURS_I18N.fig_created, text: AA_COURS_I18N.reload_to_display, timer: 2000, showConfirmButton: false })
                        .then(() => location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: AA_COURS_I18N.refused, text: result[0].desc });
                }
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: AA_COURS_I18N.error_title, text: AA_COURS_I18N.upload_failed + ' (HTTP ' + (xhr && xhr.status ? xhr.status : '?') + ').' });
            }
        });
    }

    function deleteFigureSvgRow(idFigure) {
        if (!confirm(AA_COURS_I18N.fig_delete_confirm)) return;
        fetch('<?php echo base_url(); ?>home/deleteFigureSvg', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idFigure: idFigure })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                setSvgRowStatus(idFigure, AA_COURS_I18N.fig_status_png_only, false);
                Swal.fire({ icon: 'success', title: data.message, timer: 2000, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: AA_COURS_I18N.error_title, text: data.message });
            }
        });
    }
    </script>
    <?php endif; ?>
</html>

<?php } else { ?>
    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>
<?php } ?>