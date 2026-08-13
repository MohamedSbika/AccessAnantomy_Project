<?php
/**
 * AccessAnatomy — source unique de la navigation.
 *
 * L'en-tête (aa_header.php), le tiroir (aa_sidebar.php) et le pied de page
 * (aa_footer.php) rendent tous les trois CES tableaux. C'est le point clé de
 * la refonte : v1_header_menu.php portait le menu en double — une version
 * `d-md-none` pour le mobile, une version `d-none d-md-flex` pour le desktop
 * — soit ~200 lignes à modifier deux fois à chaque changement.
 *
 * Ajouter une entrée ici la fait apparaître partout.
 *
 * Ce fichier ne produit aucun HTML : il ne définit que des variables.
 * Il est inclus avec include_once, il peut donc être appelé par plusieurs
 * composants sur la même page sans recalcul.
 */

$aa_ci = (isset($this) && is_object($this)) ? $this : get_instance();

$aa_lang     = $aa_ci->lang->line('siteLang');            // ex. « FR/ »
$aa_code     = rtrim((string) $aa_lang, '/') ?: 'FR';     // ex. « FR »
$aa_base     = base_url() . $aa_lang;
$aa_estAdmin = ($aa_ci->session->userdata('EstAdmin') == 1);
$aa_connecte = (bool) $aa_ci->session->userdata('user_id');

/** Mode lecture au sens switchPlatform (jeu de vues v1_*), pas la bascule CSS. */
$aa_mode_lecture_plateforme = (bool) $aa_ci->session->userdata('typePlatform');

/**
 * Traduit une clé si elle existe dans les fichiers de langue, sinon retombe
 * sur le libellé fourni. Les vues appellent lang->line() sans garde ailleurs,
 * ce qui affiche la clé brute quand la traduction manque.
 */
if (!function_exists('aa_trad')) {
    function aa_trad($ci, $cle, $defaut)
    {
        $valeur = $ci->lang->line($cle);
        return ($valeur !== FALSE && $valeur !== '' && $valeur !== $cle) ? $valeur : $defaut;
    }
}

/** Échappement court, utilisé partout dans les composants. */
if (!function_exists('aa_e')) {
    function aa_e($texte)
    {
        return htmlspecialchars((string) $texte, ENT_QUOTES, 'UTF-8');
    }
}


/* --------------------------------------------------------------------------
   Liens principaux
   -------------------------------------------------------------------------- */

$aa_nav = array(
    array(
        'cle'     => 'accueil',
        'libelle' => aa_trad($aa_ci, 'accueil', 'Accueil'),

        // « …/login » est l'accueil du site : c'est la route que sert
        // Home::login(), qui rend la page d'accueil. Cible inchangée par
        // rapport aux en-têtes qu'on remplace.
        'url'     => $aa_base . 'login',
        'admin'   => false,
    ),
    array(
        'cle'     => 'recherche',
        'libelle' => aa_trad($aa_ci, 'search', 'Recherche'),
        'url'     => $aa_base . 'searchIndex',
        'admin'   => false,

        // Même règle que le champ de recherche de l'en-tête et du tiroir :
        // les résultats portent sur des ouvrages réservés aux comptes.
        'connecte' => true,
    ),
    array(
        'cle'     => 'contact',
        'libelle' => aa_trad($aa_ci, 'footer_contact', 'Contact'),
        'url'     => $aa_base . 'contactUS',
        'admin'   => false,
    ),
    array(
        'cle'     => 'admin',
        'libelle' => aa_trad($aa_ci, 'settings', 'Administration'),
        'url'     => $aa_base . 'pagesSetting',
        'admin'   => true,
    ),
);

/** Entrées réellement visibles pour cet utilisateur. */
$aa_nav_visible = array();
foreach ($aa_nav as $aa_item) {
    if ($aa_item['admin'] && !$aa_estAdmin) {
        continue;
    }
    if (!empty($aa_item['connecte']) && !$aa_connecte) {
        continue;
    }
    $aa_nav_visible[] = $aa_item;
}


/* --------------------------------------------------------------------------
   Catégories de contenu (Cours d'Anatomie, Atlas, Embryologie, Pathologie…)
   -------------------------------------------------------------------------- */

/**
 * Ces entrées venaient de header_category.php, qui dépendait de la variable
 * `$listCat` fournie par le contrôleur. Une bonne moitié des vues ne la
 * reçoit pas : c'est pour ça que les pages de cours n'avaient aucune
 * navigation de contenu. On la réutilise si elle est là, sinon on interroge
 * la base — la requête est mise en cache statique pour ne pas la refaire
 * dans le tiroir puis dans le pied de page.
 */
if (!function_exists('aa_categories')) {
    function aa_categories($ci, $listCat = null)
    {
        static $cache = null;
        if ($cache !== null) {
            return $cache;
        }

        $brut = $listCat;

        if (!is_array($brut)) {
            $lang = $ci->session->userdata('site_lang');
            if ($lang == '') {
                $lang = 'FR';
            }

            /**
             * Trois requêtes, pas une par catégorie puis une par thème.
             * Home::getListCategory() procède en cascade (1 + N + N×M) ; ici
             * l'appel a lieu sur CHAQUE page du site, une trentaine de
             * requêtes par affichage n'était pas acceptable.
             */
            $ci->db->select('IDCategory, Libelle, OrdreCat, EstActifMenu');
            $ci->db->from('_category');
            $ci->db->where('multi_lingue', $lang);
            $ci->db->where('EstActifMenu', 1);
            $ci->db->where('OrdreCat >', 0);
            $ci->db->order_by('OrdreCat', 'ASC');
            $ci->db->order_by('Libelle', 'ASC');
            $categories = $ci->db->get()->result_array();

            if (empty($categories)) {
                $cache = array();
                return $cache;
            }

            $ci->db->select('IDTheme, LibelleTheme, url, EstUnLivre, IDCategory');
            $ci->db->from('_theme');
            $ci->db->where_in('IDCategory', array_column($categories, 'IDCategory'));
            $ci->db->order_by('OrderTheme', 'ASC');
            $themes = $ci->db->get()->result_array();

            $livres_par_theme = array();
            if ($themes) {
                // Les titres sont préfixés d'un numéro (« 2-Membre supérieur ») :
                // un tri alphabétique placerait 10 avant 2.
                $ci->db->select('IDLivre, Titre, IDTheme, CAST(SUBSTRING_INDEX(Titre, "-", 1) AS SIGNED) AS ord', false);
                $ci->db->from('_livre');
                $ci->db->where_in('IDTheme', array_column($themes, 'IDTheme'));
                $ci->db->order_by('ord', 'ASC');

                foreach ($ci->db->get()->result_array() as $livre) {
                    $livres_par_theme[$livre['IDTheme']][] = $livre;
                }
            }

            $themes_par_cat = array();
            foreach ($themes as $theme) {
                $themes_par_cat[$theme['IDCategory']][] = array(
                    'items' => $theme,
                    'books' => isset($livres_par_theme[$theme['IDTheme']])
                        ? $livres_par_theme[$theme['IDTheme']]
                        : array(),
                );
            }

            $brut = array();
            foreach ($categories as $cat) {
                $brut[] = array(
                    'Cats'  => $cat,
                    'items' => isset($themes_par_cat[$cat['IDCategory']])
                        ? $themes_par_cat[$cat['IDCategory']]
                        : array(),
                );
            }
        }

        /**
         * Mise à plat : header_category.php imbriquait catégorie > thème >
         * livres et rendait un <li> par thème. On garde la même hiérarchie
         * mais sous une forme directement rendable.
         */
        $lang_prefix = $ci->lang->line('siteLang');
        $sortie      = array();

        foreach ((array) $brut as $categorie) {
            if (empty($categorie['Cats']['OrdreCat']) || $categorie['Cats']['OrdreCat'] <= 0) {
                continue;
            }
            if (empty($categorie['Cats']['EstActifMenu'])) {
                continue;
            }

            foreach ((array) $categorie['items'] as $theme) {
                if (empty($theme['items']['LibelleTheme'])) {
                    continue;
                }

                $livres = array();
                foreach ((array) $theme['books'] as $livre) {
                    $vue = !empty($theme['items']['EstUnLivre']) ? 'livreDetails/' : 'livre/';
                    $livres[] = array(
                        'libelle' => $livre['Titre'],
                        'url'     => base_url() . $lang_prefix . $vue . $livre['IDLivre'],
                    );
                }

                $sortie[] = array(
                    'libelle' => $theme['items']['LibelleTheme'],
                    'url'     => base_url() . (isset($theme['items']['url']) ? $theme['items']['url'] : ''),
                    'livres'  => $livres,
                );
            }
        }

        $cache = $sortie;
        return $cache;
    }
}

$aa_categories = aa_categories($aa_ci, isset($listCat) ? $listCat : null);


/* --------------------------------------------------------------------------
   Langues
   Reprend la liste de header_steppes.php. Ajouter une langue = une ligne.
   -------------------------------------------------------------------------- */

$aa_langues = array(
    'FR' => array('drapeau' => '🇫🇷', 'nom' => 'Français'),
    'EN' => array('drapeau' => '🇬🇧', 'nom' => 'English'),
    'ES' => array('drapeau' => '🇪🇸', 'nom' => 'Español'),
    'RU' => array('drapeau' => '🇷🇺', 'nom' => 'Русский'),
    'TR' => array('drapeau' => '🇹🇷', 'nom' => 'Türkçe'),
    'PT' => array('drapeau' => '🇵🇹', 'nom' => 'Português'),
    'IT' => array('drapeau' => '🇮🇹', 'nom' => 'Italiano'),
    'DE' => array('drapeau' => '🇩🇪', 'nom' => 'Deutsch'),
    'PL' => array('drapeau' => '🇵🇱', 'nom' => 'Polski'),
    'JA' => array('drapeau' => '🇯🇵', 'nom' => '日本語'),
    'KO' => array('drapeau' => '🇰🇷', 'nom' => '한국어'),
);

$aa_langue_active = $aa_ci->session->userdata('site_lang') ?: 'FR';
$aa_drapeau       = isset($aa_langues[$aa_langue_active])
    ? $aa_langues[$aa_langue_active]['drapeau']
    : '🌐';


/* --------------------------------------------------------------------------
   Réseaux sociaux
   Les URL sont posées en session par Home::get_social_links(). Une entrée
   sans URL n'est pas rendue, au lieu d'être rendue puis masquée en CSS.
   -------------------------------------------------------------------------- */

$aa_socials = array();
foreach (array(
    'facebook'  => 'social_media/fb_40.png',
    'instagram' => 'social_media/instagram_40.png',
    'twitter'   => 'social_media/twitter_40.png',
    'linkedin'  => 'social_media/linkedin.png',
    'youtube'   => 'social_media/youtube_40.png',
) as $aa_reseau => $aa_icone) {
    $aa_url = $aa_ci->session->userdata('social_' . $aa_reseau);
    if ($aa_url) {
        $aa_socials[] = array(
            'nom'   => ucfirst($aa_reseau),
            'url'   => $aa_url,
            'icone' => HTTP_IMAGES . $aa_icone,
        );
    }
}


/* --------------------------------------------------------------------------
   Contexte
   -------------------------------------------------------------------------- */

/**
 * $aa_page_active peut être posé par la vue AVANT l'include pour surligner
 * l'entrée courante :  $aa_page_active = 'recherche';
 * À défaut on retombe sur $page, que la plupart des contrôleurs passent déjà.
 */
if (!isset($aa_page_active)) {
    $aa_page_active = isset($page) ? $page : '';
}

/**
 * URL courante chiffrée, attendue par switchPlatform() pour revenir sur la
 * même page après la bascule. header_steppes.php la calculait dans son
 * markup ; elle est ici pour que l'en-tête et le tiroir la partagent.
 */
$aa_url_retour = urlencode(base64_encode($aa_ci->uri->uri_string()));
