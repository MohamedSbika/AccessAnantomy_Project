<?php
if (strlen($this->session->userdata('passTok')) == 200) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($OneBook[0]['TitreLivre']) ? $OneBook[0]['TitreLivre'] : 'Cours' ?> - Plateforme</title>

    <!-- Fonts + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- JS & CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="<?php echo HTTP_CSS; ?>v1_app.css" rel="stylesheet">

    <style>
        body { 
            margin: 0; 
            font-size: 0px; 
            padding-bottom: 30px; 
            height: 100%; 
        }

        .row { --bs-gutter-x: 0px; }
        .container { position: relative; width: 95%; margin: 0 auto; text-align: center; overflow-x: hidden; display: block; }
        #element { display: flex; flex-wrap: wrap; justify-content: space-between; padding: 1px; background-color: white; }

        .col-12.col-lg-6.col-xl-6 { padding: 10px; }
        @media (max-width: 768px) {
            .col-12.col-lg-6.col-xl-6 { width: 95% !important; margin-left: 2.5% !important; float: none !important; }
        }
        @media (min-width: 769px) {
            .col-12.col-lg-6.col-xl-6:first-of-type { width: 45% !important; margin-left: 30px !important; }
            .col-12.col-lg-6.col-xl-6:last-of-type { width: 45% !important; margin-left: 2% !important; }
        }

        /* Bloc Figures */
        .bloc-figures { overflow-y: auto; max-height: 80vh; padding: 10px; }
        .figure-item { margin-bottom: 20px; text-align: center; }
        .figure-item img { width: 100%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .figure-item p { font-weight: bold; font-size: 13px; margin-top: 5px; color: #333; }

        /* Bloc Cours */
        .bloc-cours { 
            overflow-y: auto; 
            max-height: 90vh; 
            padding: 10px; 
            padding-left: 55px;
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        /* Barre recherche */
        .search-bar { 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            margin-left: auto; 
        }
        .search-bar input { 
            border: 1px solid #ced4da; 
            transition: 0.3s; 
            max-width: 170px; 
            height: 28px; 
            padding: 4px; 
            border-radius: 5px;
        }
        .search-bar input:focus {
            border-color: #1d3557;
            outline: none;
            box-shadow: 0 0 5px rgba(29, 53, 87, 0.3);
        }
        .search-bar button { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 28px; 
            padding: 4px 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .search-bar button:hover {
            background-color: #f0f0f0;
            border-radius: 5px;
            /* transform: scale(1.05); */
        }

        /* Styles pour la recherche */
        .search-highlight {
            background-color: #ffeb3b;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .search-highlight:hover {
            background-color: #ffc107;
        }

        /* @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-10px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-10px); }
        } */

        /* Boutons navigation recherche */
        .search-navigation {
            display: none;
            gap: 5px;
        }

        .search-navigation.active {
            display: flex;
        }

        .search-nav-btn {
            background: #1d3557;
            color: white;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
            transition: all 0.3s;
            height: 28px;
        }

        .search-nav-btn:hover {
            background: #457b9d;
            /* transform: scale(1.05); */
        }

        .clear-search-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
            transition: all 0.3s;
            height: 28px;
            display: none;
        }

        .clear-search-btn.active {
            display: block;
        }

        .clear-search-btn:hover {
            background: #c82333;
        }
    </style>
</head>

<header style="z-index: 1000; width: 100%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #120E47 30%, #182540 100%);">
    <?php include('v1_header_menu.php'); ?>
</header>

<body>
    <div id="element">
        <!-- === Barre latérale gauche === -->
        <?php include('v1_racourci_pathologie.php'); ?>

        <!-- === Zone principale : cours === -->
        <div class="col-12 col-lg-6 col-xl-6" style="float: left;">
            <!-- Recherche -->
            <div class="row">
                <li class="breadcrumb-item">
                    <div class="search-bar">
                        <input name="keywordsIN" id="keywordsIN" type="text"
                               value="<?php echo isset($indexSearch) ? urldecode($indexSearch) : ''; ?>"
                               class="form-control" placeholder="<?php echo $this->lang->line('search'); ?>…">
                        <button class="btn" onclick="mySearchIndx();" title="Rechercher">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-search align-middle">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        
                        <!-- Navigation entre résultats -->
                        <div class="search-navigation" id="searchNavigation">
                            <button class="search-nav-btn" onclick="previousSearchResult()" title="Résultat précédent">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button class="search-nav-btn" onclick="nextSearchResult()" title="Résultat suivant">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </div>
                        
                        <!-- Bouton effacer -->
                        <button class="clear-search-btn" id="clearSearchBtn" onclick="clearSearch()" title="Effacer la recherche">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </li>
            </div>

            <!-- Contenu du cours scrollable -->
            <div class="row" id="cours-container">
                <div class="bloc-cours">
                    <?php echo isset($CursShow) ? $CursShow : '<p>Aucun contenu à afficher.</p>'; ?>
                </div>
            </div>
        </div>

        <!-- === Zone droite : Figures === -->
<div class="col-12 col-lg-6 col-xl-6" style="float: right;">
    <?php include('v1_bloc_figures.php'); ?>
</div>
    </div>

    <?php include('v1_modal_mode_lecture.php'); ?>
</body>

<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="<?php echo HTTP_JS; ?>app.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>DataTables/datatables.js"></script>

<script>
    // === SYSTÈME DE RECHERCHE DANS LE CONTENU ===
    var currentHighlightIndex = 0;
    var highlights = [];

    var isSearchActive = false;

    var input = document.getElementById("keywordsIN");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            
            if (isSearchActive && highlights.length > 0) {
                nextSearchResult();
            } else {
                mySearchIndx();
            }
        }
    });

    function mySearchIndx() {
        var searchTerm = document.getElementById("keywordsIN").value.trim();
        var coursContainer = document.querySelector('.bloc-cours');
        
        if (!searchTerm) {
            removeHighlights();
            isSearchActive = false;
            return;
        }
        
        removeHighlights();
        
        highlightText(coursContainer, searchTerm);
        
        highlights = document.querySelectorAll('.search-highlight');
        
        if (highlights.length > 0) {
            isSearchActive = true;
            
            document.getElementById('searchNavigation').classList.add('active');
            document.getElementById('clearSearchBtn').classList.add('active');
            
            currentHighlightIndex = 0;
            highlights[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            highlightCurrent();
            
            showSearchMessage(highlights.length);
        } else {
            isSearchActive = false;
            
            Swal.fire({
                icon: 'info',
                title: 'Aucun résultat',
                text: 'Aucune correspondance trouvée pour "' + searchTerm + '"',
                timer: 2000,
                showConfirmButton: false
            });
            
            document.getElementById('searchNavigation').classList.remove('active');
            document.getElementById('clearSearchBtn').classList.remove('active');
        }
    }

    function highlightText(container, searchTerm) {
        var regex = new RegExp('(' + escapeRegex(searchTerm) + ')', 'gi');
        var walker = document.createTreeWalker(
            container,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        var nodesToReplace = [];
        var node;
        
        while (node = walker.nextNode()) {
            if (node.nodeValue.match(regex)) {
                nodesToReplace.push(node);
            }
        }
        
        nodesToReplace.forEach(function(node) {
            var span = document.createElement('span');
            span.innerHTML = node.nodeValue.replace(regex, '<mark class="search-highlight">$1</mark>');
            node.parentNode.replaceChild(span, node);
        });
    }

    function removeHighlights() {
        var highlights = document.querySelectorAll('.search-highlight');
        highlights.forEach(function(highlight) {
            var parent = highlight.parentNode;
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize();
        });
        
        isSearchActive = false;
        currentHighlightIndex = 0;
        highlights = [];
        
        document.getElementById('searchNavigation').classList.remove('active');
        document.getElementById('clearSearchBtn').classList.remove('active');
    }

    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function showSearchMessage(count) {
        var message = count + (count > 1 ? ' résultats trouvés' : ' résultat trouvé');
        
        var badge = document.createElement('div');
        badge.className = 'search-results-badge';
        badge.textContent = message;
        badge.style.cssText = `
            position: fixed;
            top: 120px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: fadeInOut 3s ease-in-out;
        `;
        
        document.body.appendChild(badge);
        
        setTimeout(function() {
            badge.remove();
        }, 3000);
    }

    function showPositionBadge() {
        var oldBadge = document.querySelector('.position-badge');
        if (oldBadge) oldBadge.remove();
        
        var badge = document.createElement('div');
        badge.className = 'position-badge';
        badge.textContent = (currentHighlightIndex + 1) + ' / ' + highlights.length;
        badge.style.cssText = `
            position: fixed;
            top: 120px;
            right: 20px;
            background: #2196F3;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: opacity 0.3s;
        `;
        
        document.body.appendChild(badge);
        
        setTimeout(function() {
            badge.style.opacity = '0';
            setTimeout(function() {
                badge.remove();
            }, 300);
        }, 1500);
    }

    function nextSearchResult() {
        if (highlights.length === 0) return;
        
        currentHighlightIndex = (currentHighlightIndex + 1) % highlights.length;
        highlights[currentHighlightIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
        highlightCurrent();
        
        showPositionBadge();
    }

    function previousSearchResult() {
        if (highlights.length === 0) return;
        
        currentHighlightIndex = (currentHighlightIndex - 1 + highlights.length) % highlights.length;
        highlights[currentHighlightIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
        highlightCurrent();
        
        showPositionBadge();
    }

    function highlightCurrent() {
        highlights.forEach(function(h, index) {
            if (index === currentHighlightIndex) {
                h.style.backgroundColor = '#ff9800';
                h.style.fontWeight = 'bold';
            } else {
                h.style.backgroundColor = '#ffeb3b';
                h.style.fontWeight = 'normal';
            }
        });
    }

    function clearSearch() {
        document.getElementById("keywordsIN").value = '';
        removeHighlights();
    }

    document.getElementById("keywordsIN").addEventListener('input', function() {
        if (this.value.trim() === '') {
            clearSearch();
        } else {
            if (isSearchActive) {
                isSearchActive = false;
            }
        }
    });
</script>
</html>

<?php } else { ?>
    <?php
    header('Location: ' . base_url() . $this->lang->line('siteLang') . 'login');
    exit();
    ?>
<?php } ?>