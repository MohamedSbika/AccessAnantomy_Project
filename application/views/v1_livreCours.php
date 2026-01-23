<?php
if (strlen($this->session->userdata('passTok')) == 200) {
?>

<!DOCTYPE html>
<html lang="fr">
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
            justify-content: space-between;
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
                width: 45% !important;
                margin-left: 30px !important;
            }
            .col-12.col-lg-6.col-xl-6:last-of-type {
                width: 45% !important;
                margin-left: 2% !important;
            }
        }
    </style>
</head>

<header style="z-index: 1000; width: 100%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
    <?php include('v1_header_menu.php'); ?>
</header>

<body>
    <div id="element">
        <?php include('v1_racourci.php'); ?>

<div class="col-12 col-lg-6 col-xl-6" style="float: left; width: 48%; margin-left: 3%;">
                <div class="row">
                <li class="breadcrumb-item">
                    &nbsp;&nbsp;
                    <div style="display: flex; align-items: center; gap: 5px; margin-left: auto;">
                        <?php if ($this->session->userdata('EstAdmin') == 1): ?>
                            <button class="badge bg-info text-white border-0" 
                                    onclick="openAddImageRappelModal('<?= $OneBook[0]['IDChapitre']; ?>')" 
                                    style="cursor:pointer; background-color: #457b9d !important; font-size: 10px; height: 28px; padding: 0 10px; border-radius: 5px;">
                                <i class="fa fa-image"></i> Gérer Images Rappel
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

<div class="col-12 col-lg-6 col-xl-6" style="float: right; width: 48%; margin-right: 2%;">
            <?php include('v1_bloc_figures.php'); ?>
        </div>
    </div>

    <?php include('v1_modal_mode_lecture.php'); ?>
</body>

<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="<?php echo HTTP_JS; ?>app.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>
    <!-- Modal GÃ©rer les images de rappel -->
    <div class="modal fade" id="addImageRappelModal" tabindex="-1" aria-hidden="true" style="z-index: 10000; position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: none; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div class="modal-dialog modal-dialog-centered" style="max-width:800px; width: 90%; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background: #1d3557; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="modal-title" style="margin: 0; font-size: 1.25rem;">GÃ©rer les images de rappel</h2>
                    <button type="button" onclick="$('#addImageRappelModal').hide()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
                <div class="modal-body" style="padding: 20px; color: #333;">
                    <div id="listeImagesRappel" style="margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px; font-size: 1rem; color: #1d3557; border-bottom: 2px solid #f1f1f1; padding-bottom: 5px;">Images existantes</h4>
                        <div id="imagesContainer" style="display: flex; flex-wrap: wrap; gap: 10px; min-height: 50px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                            <!-- JS Content -->
                        </div>
                    </div>
                    <form id="formRappelImage" enctype="multipart/form-data">
                        <input type="hidden" id="rappelChapitreImage" name="rappelChapitre">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Ajouter une image (JPG, PNG, WEBP)</label>
                            <input type="file" id="rappelImage" name="rappelImage" accept="image/*" onchange="previewImageRappel(event)" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div style="text-align: center; margin-bottom: 15px;">
                            <img id="previewRappelImage" src="" alt="" style="max-width:100%; max-height:200px; display:none; border-radius:8px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                        <div style="text-align: center;">
                            <button type="button" onclick="saveRappelImage()" style="background: #1d3557; color: white; border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; cursor: pointer;">Enregistrer</button>
                            <button type="button" onclick="$('#addImageRappelModal').hide()" style="background: #ccc; border: none; padding: 10px 25px; border-radius: 6px; margin-left: 10px; cursor: pointer;">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    Swal.fire({ icon: 'success', title: 'Image ajoutÃ©e', timer: 1000, showConfirmButton: false });
                    loadRappelImages(idChapitre);
                    document.getElementById('formRappelImage').reset();
                    document.getElementById('previewRappelImage').style.display = 'none';
                }
            }
        });
    }

    function deleteRappelImageItem(idImage, idChapitre) {
        if (!confirm('Supprimer cette image ?')) return;
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
</html>

<?php } else { ?>
    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>
<?php } ?>