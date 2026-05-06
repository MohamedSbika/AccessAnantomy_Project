# Guide: Adding a New Language to Access Anatomy

This document describes **literally every step** required to add a new language to the platform. The process was designed and validated with Russian (RU) and Turkish (TR) and works identically for any language.

> **Convention used in this guide:**
> - `{LANG}` = the 2-letter uppercase ISO code (e.g. `PT`, `ZH`, `DE`, `IT`, `AR`)
> - `{LangName}` = the language native name (e.g. `Português`, `中文`, `Deutsch`, `Italiano`, `العربية`)
> - `{Flag}` = the flag emoji or country code (e.g. `🇵🇹`, `🇨🇳`, `🇩🇪`)
> - `{NEW_CAT_BASE}` = a free numeric range for category IDs. Used so far: FR=3-7, EN=8-11, ES=2596-2599, RU=2700-2703, TR=2800-2803. **Use the next free 4-number block (e.g. 2900-2903 for the next language).**

---

## Table of Contents

1. [Prerequisites & Planning](#1-prerequisites--planning)
2. [Filesystem Setup](#2-filesystem-setup)
3. [Language Translation Files](#3-language-translation-files)
4. [Update urls.json](#4-update-urlsjson)
5. [Update routes.php](#5-update-routesphp)
6. [Update Home.php Controller](#6-update-homephp-controller)
7. [Update View Files](#7-update-view-files)
8. [Update Pathology / Atlas Detection](#8-update-pathology--atlas-detection)
9. [Database Setup Script](#9-database-setup-script)
10. [Database Translation Script](#10-database-translation-script)
11. [Run on Local](#11-run-on-local)
12. [Deploy to Server](#12-deploy-to-server)
13. [Testing Checklist](#13-testing-checklist)
14. [Troubleshooting](#14-troubleshooting)

---

## 1. Prerequisites & Planning

Before starting, decide:

| Item | Example for Portuguese |
|---|---|
| Language code (`{LANG}`) | `PT` |
| Native name (`{LangName}`) | `Português` |
| Flag emoji (`{Flag}`) | `🇵🇹` |
| Category ID base (`{NEW_CAT_BASE}`) | `2900` (next free range after TR's 2800-2803) |
| URL slug — Anatomy Course | `Curso-Anatomia-PT` |
| URL slug — Anatomy Atlas | `Atlas-Anatomia-PT` |
| URL slug — Embryology | `Embriologia-PT` |
| URL slug — Pathology | `Patologia-PT` |
| Native name for "Anatomy Courses" | `Cursos de Anatomia` |
| Native name for "Anatomy Atlas" | `Atlas de Anatomia` |
| Native name for "Embryology" | `Embriologia` |
| Native name for "Pathology" | `Patologia` |

**Existing category IDs (DO NOT REUSE):**

| Lang | Anatomy | Atlas | Embryology | Pathology |
|---|---|---|---|---|
| FR | 3 | 4 | 5 | 7 |
| EN | 8 | 9 | 10 | 11 |
| ES | 2596 | 2597 | 2598 | 2599 |
| RU | 2700 | 2701 | 2702 | 2703 |
| TR | 2800 | 2801 | 2802 | 2803 |
| **{LANG}** | **{NEW_CAT_BASE}** | **{NEW_CAT_BASE}+1** | **{NEW_CAT_BASE}+2** | **{NEW_CAT_BASE}+3** |

---

## 2. Filesystem Setup

Create directories and copy default assets. From the project root:

```bash
# Create language directory
mkdir -p application/language/{LANG}

# Create cover images directory
mkdir -p assets/couverture_{LANG}

# Copy cover images from ES as placeholders
cp assets/couverture_ES/PR_ATLAS_ES.jpg     assets/couverture_{LANG}/PR_ATLAS_{LANG}.jpg
cp assets/couverture_ES/PR_COURSES_ES.jpg   assets/couverture_{LANG}/PR_COURSES_{LANG}.jpg
cp assets/couverture_ES/PR_EMBR_ES.jpg      assets/couverture_{LANG}/PR_EMBR_{LANG}.jpg
cp assets/couverture_ES/PR_PATHO_ES.jpg     assets/couverture_{LANG}/PR_PATHO_{LANG}.jpg

# Copy a placeholder flag (replace with the real one later)
cp assets/img/flags/EN.png assets/img/flags/{LANG}.png
```

You may also create a shell script `setup_{lang}_language.sh` that automates this — see existing `setup_ru_language.sh` and `setup_tr_language.sh` as templates.

---

## 3. Language Translation Files

Create **6 files** in `application/language/{LANG}/`:

### 3.1 — `content_lang.php` (REQUIRED — ~383 entries)

The main UI translation file. Start by copying from FR and translating every value:

```bash
cp application/language/FR/content_lang.php application/language/{LANG}/content_lang.php
```

Then **translate every value** in the file. The first line that MUST change:

```php
$lang['siteLang']			= '{LANG}/';
```

Categories of translations needed:
- Navigation/UI (~30 strings): `accueil`, `chapitres`, `cours`, `search`, etc.
- Auth/Login (~15 strings): `sign_in`, `sign_up`, `password`, `forgot_password`...
- Medical terms (~10): `qcm`, `qroc`, `figur`, `resume`, `Calques`...
- Home page content (~40): `desc_access`, `learning_steps_*`, `step_*_title/desc`...
- Pricing plans (~25): `basic_*`, `premium_*`, `institutional_*`...
- Contact form (~15): `form_*`, `contact*`...
- Footer (~10): `footer_*`...
- Sidebar (~15): `sidebar_*`...
- Admin/Settings (~20): `usersList`, `paramsList`, `settings`...
- Delete/Confirm (~15): `supp_*`, `titleSupprission`, `messageSupprission`...
- Tests/Evaluation (~20): `test*`, `lecture_*`...
- Email templates (~10): `mail_insc_*`, `mail_msg_*`...
- Chatbot section (~8): `chatbot_*`...
- Pathology section (~8): `pathologie_*`...
- Videos (~6): `voirVideos`, `videos`, `add_video`...
- Misc (~20): `oui`, `non`, `save`, `wait`...

### 3.2 — `db_lang.php`, `email_lang.php`, `imglib_lang.php`, `rest_controller_lang.php`

These are CodeIgniter system message files (DB/email/image/REST errors). They are rarely shown. Easiest path: copy from EN.

```bash
cp application/language/EN/email_lang.php          application/language/{LANG}/email_lang.php
cp application/language/EN/rest_controller_lang.php application/language/{LANG}/rest_controller_lang.php
# db_lang and imglib_lang may not exist in EN — copy from another language that has them
cp application/language/RU/db_lang.php             application/language/{LANG}/db_lang.php
cp application/language/RU/imglib_lang.php         application/language/{LANG}/imglib_lang.php
```

### 3.3 — `index.html`

Empty security placeholder (CodeIgniter convention):

```bash
cp application/language/FR/index.html application/language/{LANG}/index.html
```

---

## 4. Update urls.json

File: `assets/urls.json`

This file maps URL slugs to category IDs per language. You must do **TWO things**:

### 4.1 — Add `{LANG}_id` field to ALL existing entries

Every existing entry must get a new `{LANG}_id` key pointing to the appropriate `{NEW_CAT_BASE}+N` value:

```json
{
    "url": "Cours-Anatomie",
    "id": 3,
    "FR_id": 3,
    "EN_id": 8,
    "ES_id": 2596,
    "RU_id": 2700,
    "TR_id": 2800,
    "{LANG}_id": {NEW_CAT_BASE}
}
```

Repeat for `Atlas-Anatomie` (`+1`), `Embryologie` (`+2`), `Pathologie-FR` (`+3`), and the same pattern for all `EN`, `ES`, `RU`, `TR` URL entries.

### 4.2 — Add 4 NEW entries for the new language URL slugs

Append these at the end of the array:

```json
{
    "url": "Curso-Anatomia-{LANG}",
    "id": {NEW_CAT_BASE},
    "FR_id": 3,
    "EN_id": 8,
    "ES_id": 2596,
    "RU_id": 2700,
    "TR_id": 2800,
    "{LANG}_id": {NEW_CAT_BASE}
},
{
    "url": "Atlas-Anatomia-{LANG}",
    "id": {NEW_CAT_BASE+1},
    "FR_id": 4,
    "EN_id": 9,
    "ES_id": 2597,
    "RU_id": 2701,
    "TR_id": 2801,
    "{LANG}_id": {NEW_CAT_BASE+1}
},
{
    "url": "Embriologia-{LANG}",
    "id": {NEW_CAT_BASE+2},
    "FR_id": 5,
    "EN_id": 10,
    "ES_id": 2598,
    "RU_id": 2702,
    "TR_id": 2802,
    "{LANG}_id": {NEW_CAT_BASE+2}
},
{
    "url": "Patologia-{LANG}",
    "id": {NEW_CAT_BASE+3},
    "FR_id": 7,
    "EN_id": 11,
    "ES_id": 2599,
    "RU_id": 2703,
    "TR_id": 2803,
    "{LANG}_id": {NEW_CAT_BASE+3}
}
```

The numeric position of the FIRST `{LANG}` entry in `urls.json` is needed in step 6 (used by `pageCategory()` fallback). For example:
- FR → `$json[0]`
- EN → `$json[4]`
- ES → `$json[8]`
- RU → `$json[12]`
- TR → `$json[16]`
- **Next ({LANG}) → `$json[20]`**

---

## 5. Update routes.php

File: `application/config/routes.php`

CodeIgniter routes need a `^{LANG}/` prefix for every existing route. There are **~40 routes** that must be duplicated.

### 5.1 — Top routes (around line 79-91)

Add after the RU lines:

```php
$route['^{LANG}/testFigure/(:any)']  = "home/getFigure/$1";
$route['^{LANG}/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^{LANG}/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
```

### 5.2 — Main route block (after the entire `^RU/...` block, before `$route['404_override']`)

Add the full block (copy the `^RU/` block and replace RU with {LANG}):

```php
$route['^{LANG}/switchPlatform/(:any)']    = "home/switchPlatform/$1";
$route['^{LANG}/login']                    = "home/login";
$route['^{LANG}/category/(:any)']          = "home/pageCategory/$1";
$route['^{LANG}/livreList/(:any)/(:any)']  = "home/livreList/$1/$2";
$route['^{LANG}/livre/(:any)']             = "home/livre/$1";
$route['^{LANG}/livreDetails/(:any)']      = "home/livreDetails/$1";
$route['^{LANG}/livreCours/(:any)/(:any)'] = "home/livreCours/$1/$2";
$route['^{LANG}/livreCours/(:any)']        = "home/livreCours/$1";
$route['^{LANG}/livreResume/(:any)/(:any)']= "home/livreResume/$1/$2";
$route['^{LANG}/livreResume/(:any)']       = "home/livreResume/$1";
$route['^{LANG}/livreFigures/(:any)']      = "home/livreFigures/$1";
$route['^{LANG}/figuresOnly/(:any)']       = "home/figuresOnly/$1";
$route['^{LANG}/livreQcm/(:any)']          = "home/livreQcm/$1";
$route['^{LANG}/livreQroc/(:any)']         = "home/livreQroc/$1";
$route['^{LANG}/signUp']                   = "home/signUp";
$route['^{LANG}/resetUp']                  = "home/resetUp";
$route['^{LANG}/forgot_password']          = "home/forgot_password";
$route['^{LANG}/pagesSetting']             = "home/settingPaltform";
$route['^{LANG}/logout']                   = "home/logout";
$route['^{LANG}/settingUsers']             = "home/settingUsers";
$route['^{LANG}/settingUsersEtab']         = "home/settingUsersEtab";
$route['^{LANG}/settingCurs']              = "home/settingCurs";
$route['^{LANG}/settingPlat']              = "home/settingPlat";
$route['^{LANG}/settingActualites']        = "home/settingActualites";
$route['^{LANG}/settingTest/(:any)']       = "home/settingFigures/$1";
$route['^{LANG}/cursHTML/(:any)/(:any)']   = "home/cursHTML/$1/$2";
$route['^{LANG}/cursHTML/(:any)']          = "home/cursHTML/$1";
$route['^{LANG}/figHTML/(:any)']           = "home/figHTML/$1";
$route['^{LANG}/livreQcmEdit/(:any)']      = "home/livreQcmEdit/$1";
$route['^{LANG}/livreQrocEdit/(:any)']     = "home/livreQrocEdit/$1";
$route['^{LANG}/searchIndex']              = "home/searchIndex";
$route['^{LANG}/listOffers/(:any)']        = "home/listOffers/$1";
$route['^{LANG}/evaluatQCM/(:any)/(:any)/(:any)']  = "home/evaluatQCM/$1/$2/$3";
$route['^{LANG}/evaluatQROC/(:any)/(:any)/(:any)'] = "home/evaluatQROC/$1/$2/$3";
$route['^{LANG}/evaluatTEST/(:any)']       = "home/getListTestByChapitres4/$1";
$route['^{LANG}/evaluatCalque/(:any)']     = "home/getListCalqueByChapitres2/$1";
$route['^{LANG}/contactUS']                = "home/contactUS";
$route['^{LANG}/v1_livre']                 = "home/v1_livre";
```

### 5.3 — Bottom routes

After the `$route['^TR/PlatFormeConvert/...']` line, add:

```php
$route['^{LANG}/PlatFormeConvert/(:any)']  = 'home/PlatFormeConvert/$1';
$route['^{LANG}/products/buyProduct/(:any)'] = "home/products/buyProduct/$1";
```

---

## 6. Update Home.php Controller

File: `application/controllers/Home.php`

### 6.1 — `switchLang()` method (~line 1098)

Add a block after the existing TR block:

```php
if ($lang == '{LANG}') {
    $this->session->set_userdata('site_lang_lib', '{LangName}');
}
```

### 6.2 — `setLang()` method (~line 1121)

Update the regex to include `{LANG}`:

```php
// BEFORE
if (preg_match('#/(FR|EN|ES|DE|RU|TR)/#', $uri, $matches)) {
// AFTER
if (preg_match('#/(FR|EN|ES|DE|RU|TR|{LANG})/#', $uri, $matches)) {
```

And add a block after the existing TR block:

```php
if ($lang == '{LANG}') {
    $this->session->set_userdata('site_lang_lib', '{LangName}');
    $lang = '{LANG}';
}
```

### 6.3 — `pageCategory()` fallback redirect (~line 1270)

Add an `elseif` for `{LANG}`:

```php
} elseif ($lang == "{LANG}") {
    redirect('{LANG}/category/' . $json[20]['url']);  // 20 = position of first {LANG} entry in urls.json
}
```

> Replace `20` with the actual array index of the first `{LANG}` entry in `urls.json`. With Russian and Turkish already present, the next language's first entry will be at index `20`.

### 6.4 — `add_Actualite()` method (~line 2724)

Add `{LANG}_title` handling:

```php
$title{LANG} = isset($_POST["{LANG}_title"]) ? $_POST["{LANG}_title"] : '';

$data = ['FR_title' => $titleFR, 'EN_title' => $titleEN, 'RU_title' => $titleRU, 'TR_title' => $titleTR, '{LANG}_title' => $title{LANG}];
```

### 6.5 — `update_Actualite()` method (~line 2745)

Same modification as `add_Actualite()`.

---

## 7. Update View Files

### 7.1 — `application/views/v1_header_langauge.php` (header language switcher)

Add `{LANG}` to the `$flags` array:

```php
$flags = [
    'FR' => '🇫🇷',
    'EN' => '🇬🇧',
    'ES' => '🇪🇸',
    'RU' => '🇷🇺',
    'TR' => '🇹🇷',
    '{LANG}' => '{Flag}'
];
```

Add a new dropdown item after the TR item:

```php
<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/{LANG}" style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
    {Flag} &nbsp;{LangName}
</a>
```

### 7.2 — `application/views/header_steppes.php` (admin globe selector)

Add a new `<a>` link after the Türkçe one:

```php
<a style="padding:0px 2px;" class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/{LANG}">
    <span class="align-middle">{LangName}</span>
</a>
```

### 7.3 — `application/views/page_category.php` (category cover image logic)

There are **2 locations** (around lines 84 and 161). For each, add a `{LANG}` branch.

**Pathology cover (after the RU/TR line):**

```php
elseif ($lang == '{LANG}') $couv = 'assets/couverture_{LANG}/PR_PATHO_{LANG}.jpg';
```

**Per-category cover (after the RU/TR block):**

```php
if ($lang == '{LANG}') {
    if (stripos($value['Cats']['Libelle'], 'Curso') !== false || stripos($value['Cats']['Libelle'], 'Cours') !== false) $couv = 'assets/couverture_{LANG}/PR_COURSES_{LANG}.jpg';
    elseif (stripos($value['Cats']['Libelle'], 'Atlas') !== false) $couv = 'assets/couverture_{LANG}/PR_ATLAS_{LANG}.jpg';
    elseif (stripos($value['Cats']['Libelle'], 'Embr') !== false) $couv = 'assets/couverture_{LANG}/PR_EMBR_{LANG}.jpg';
}
```

Repeat the same modification for the second location (`$couv2`/`$lang2` block).

### 7.4 — `application/views/page_home.php` (home page category cards)

There are **4 category card blocks** (Anatomy, Atlas, Embryology, Pathology). Each block has `if FR / elseif ES / elseif RU / elseif TR / else EN`. Add `{LANG}` branches after the TR ones:

```php
<?php } elseif ($this->session->userdata('site_lang') == '{LANG}') { ?>
    <a href="<?php echo base_url(); ?>{LANG}/category/Curso-Anatomia-{LANG}">
        <img src="<?php echo base_url(); ?>assets/couverture_{LANG}/PR_COURSES_{LANG}.jpg" style="width:100%;" class="image-couverture">
    </a>
```

Repeat for Atlas, Embryology, and Pathology cards using the matching URL slugs.

Also update the actualites display block (~line 1174):

```php
<?php } elseif ($this->session->userdata('site_lang') == '{LANG}' && !empty($value['{LANG}_title'])) { ?>
    <span> <?= $value['{LANG}_title']; ?> </span>
```

### 7.5 — `application/views/livreDetails.php`

Find every `in_array($category['multi_lingue'], ['EN', 'ES', 'RU', 'TR'])` (3 occurrences) and add `'{LANG}'`:

```php
in_array($category['multi_lingue'], ['EN', 'ES', 'RU', 'TR', '{LANG}'])
```

Find every `$estPathologieBook` and `$estPathologie` block (3 places: lines ~954, ~1003, ~2268) and add the new language Libelle to the stripos chain (only if your language has its own native word for "Pathology" — see step 8).

### 7.6 — `application/views/actualitesmodals.php`

Add a `Titre_{LANG}` textarea in **both** modals (Add and Update). Pattern (mirror the RU/TR block):

```php
<div class="col-sm-12">
    <div class="mb-2">
        <label class="form-label label-modal-login">Titre_{LANG}</label>
        <textarea rows="2" cols="33" class="form-control form-control-lg input-modal-login" type="text" name="{LANG}_title" placeholder="" style="font-size: 0.8rem;min-height: calc(1px);padding: 0.2rem 0.2rem;"><?= isset($value['{LANG}_title']) ? $value['{LANG}_title'] : ''; ?></textarea>
    </div>
</div>
```

In the Add modal omit the `<?= ... ?>` (no existing value).

### 7.7 — `application/views/settingActualites.php`

Add a header column:

```html
<th style="text-align: left;">{LANG} Titre</th>
```

And a body column inside the foreach:

```php
<td style="text-align: left;">
    <?= isset($value['{LANG}_title']) ? $value['{LANG}_title'] : ''; ?>
</td>
```

---

## 8. Update Pathology / Atlas Detection

The platform has **hardcoded pathology / atlas category detection** that must include the new language. If your language uses a Latin-script word that already starts with "Pathologie", "Patologia", or "Pathology" you can skip the pathology Libelle additions.

### 8.1 — `Home.php::isPathologieCategory()` (~line 2816)

Add `stripos` checks for the native pathology word:

```php
|| stripos($cat['Libelle'], '{NativePathologyName}') !== false
```

### 8.2 — `Home.php::getPathologieByRappel()` (~line 9042)

Add to the OR-LIKE chain:

```php
$this->db->or_like('_category.Libelle', '{NativePathologyName}');
```

Also at the fallback (~line 9061).

### 8.3 — `application/views/livreDetails.php`

Three places (`$estPathologieBook`, `$estPathologie`, `window.estPathologieCategory`):

```php
|| stripos($category['Libelle'], '{NativePathologyName}') !== false
```

### 8.4 — `application/views/v1_racourci.php` (lecture mode book sidebar)

This file routes to `v1_racourci_pathologie.php` or `v1_racourci_atlas.php` based on category. Add the new language category IDs to the arrays:

```php
// Atlas categories: FR=4, EN=9, ES=2597, RU=2701, TR=2801
$atlasCategories = [4, 9, 2597, 2701, 2801, {NEW_CAT_BASE+1}];
// Pathology categories: FR=7, EN=11, ES=2599, RU=2703, TR=2803
$pathoCategories = [7, 11, 2599, 2703, 2803, {NEW_CAT_BASE+3}];
```

And add native words to the stripos chains:

```php
$isPathology = ... || stripos($catLibelle, '{NativePathologyName}') !== false;
$isAtlas     = ... || stripos($catLibelle, '{NativeAtlasName}') !== false;
```

### 8.5 — `application/views/v1_bloc_figures.php`

Add the new language atlas theme ID. Theme IDs follow this pattern (each language's atlas theme gets a new auto-increment ID — find it in the DB after running the setup script):

```php
// Atlas themes: FR=16, EN=27, ES=34, RU=42, TR=46, {LANG}={NEW_THEME_ID}
if (in_array($idLivre, [70, 71]) || in_array($idTheme, [16, 27, 34, 42, 46, {NEW_THEME_ID}])) {
```

### 8.6 — `application/views/v1_bloc_figures_atlas.php` and `v1_header_nav.php`

Both files have:

```php
in_array((int)$OneBook[0]["IDCategory"], [4, 9, 2597, 2701, 2801])
```

Add `{NEW_CAT_BASE+1}` (the new language's Atlas category ID).

---

## 9. Database Setup Script

Create a file `setup_{lang}_database.sql` (lowercase). This is the **structural** script that creates categories, themes, livres and chapters mirroring the FR layout. Use `setup_tr_database.sql` as a starting template — it is the latest validated version.

Key points to update:
- All occurrences of `2800/2801/2802/2803` → `{NEW_CAT_BASE}/{NEW_CAT_BASE+1}/{NEW_CAT_BASE+2}/{NEW_CAT_BASE+3}`
- `multi_lingue = 'TR'` → `multi_lingue = '{LANG}'`
- `'Anatomi Dersleri'` and the other Turkish names in the INSERTs are placeholders that will be overwritten by `update_{lang}_translations.sql` later — you can leave the FR names there as we did originally.
- Procedure name: `setup_tr_books` → `setup_{lang}_books`
- `TR_Description` column → `{LANG}_Description`
- `TR_title` column on `actualites` → `{LANG}_title`
- Uses `SET NAMES utf8;` (REQUIRED for non-Latin scripts like Cyrillic, Chinese, Arabic)
- Includes the `ALTER TABLE ... CONVERT TO CHARACTER SET utf8` block at the start (do not skip this — Latin1 columns cannot store non-Latin characters)

The script does the following in order:
1. **STEP -1** — Convert relevant text columns to `utf8`
2. **STEP 0** — Add `{LANG}_Description` column to `_category` if not exists
3. **STEP 1** — Insert 4 new `_category` rows (with full feature flags `EstActifMenu`, `EstActifQSM`, `EstActifQROC`, `EstActifResume`, `EstActifCalques`, `EstActifTest` copied from FR — **do not omit these**)
4. **STEP 2** — Insert themes mirroring the 4 FR categories
5. **STEP 3** — Stored procedure that loops over each FR theme, creates a matching `_livre` row in the new language theme, copies all `_chapitre` rows for that livre, and copies the `encryptCouverture` and `Description` from the FR livre
6. **STEP 4** — Add `{LANG}_title` column to `actualites` if not exists
7. **STEP 5** — Verification SELECTs

---

## 10. Database Translation Script

Create a file `update_{lang}_translations.sql`. This script translates all category, theme, livre, and chapter names from FR to the target language.

Use `update_tr_translations.sql` as a template. Pattern:

```sql
SET NAMES utf8;

-- Categories
UPDATE `_category` SET `Libelle` = '{NativeAnatomyName}' WHERE IDCategory = {NEW_CAT_BASE};
UPDATE `_category` SET `Libelle` = '{NativeAtlasName}'   WHERE IDCategory = {NEW_CAT_BASE+1};
UPDATE `_category` SET `Libelle` = '{NativeEmbryoName}'  WHERE IDCategory = {NEW_CAT_BASE+2};
UPDATE `_category` SET `Libelle` = '{NativePathologyName}' WHERE IDCategory = {NEW_CAT_BASE+3};

-- Themes
UPDATE `_theme` SET `LibelleTheme` = '{NativeAnatomyName}' WHERE IDCategory = {NEW_CAT_BASE};
... etc.

-- Use a temporary translation table to translate Livres and Chapitres via JOIN
DROP TEMPORARY TABLE IF EXISTS _tmp_{lang}_trans;
CREATE TEMPORARY TABLE _tmp_{lang}_trans (
    fr_title VARCHAR(150) NOT NULL,
    {lang}_title VARCHAR(150) NOT NULL,
    UNIQUE KEY uniq_fr (fr_title)
) CHARACTER SET utf8;

INSERT IGNORE INTO _tmp_{lang}_trans (fr_title, {lang}_title) VALUES
('1-Anatomie générale', '1-{Translation}'),
... (35 livre titles) ...;

UPDATE `_livre` l
JOIN `_theme` t ON t.IDTheme = l.IDTheme
JOIN _tmp_{lang}_trans m ON m.fr_title = l.Titre
SET l.Titre = m.{lang}_title
WHERE t.IDCategory IN ({NEW_CAT_BASE}, {NEW_CAT_BASE+1}, {NEW_CAT_BASE+2}, {NEW_CAT_BASE+3});

-- Same approach for chapters (~500-600 unique titles)
DROP TEMPORARY TABLE IF EXISTS _tmp_{lang}_chap_trans;
CREATE TEMPORARY TABLE _tmp_{lang}_chap_trans (
    fr_title VARCHAR(100) NOT NULL,
    {lang}_title VARCHAR(100) NOT NULL,
    UNIQUE KEY uniq_fr (fr_title)
) CHARACTER SET utf8;

INSERT IGNORE INTO _tmp_{lang}_chap_trans (fr_title, {lang}_title) VALUES
('1-Généralités anatomiques', '1-{Translation}'),
... (~500 chapter titles) ...;

UPDATE `_chapitre` ch
JOIN `_livre` l ON l.IDLivre = ch.IDLivre
JOIN `_theme` t ON t.IDTheme = l.IDTheme
JOIN _tmp_{lang}_chap_trans m ON m.fr_title = ch.TitreChapitre
SET ch.TitreChapitre = m.{lang}_title
WHERE t.IDCategory IN ({NEW_CAT_BASE}, {NEW_CAT_BASE+1}, {NEW_CAT_BASE+2}, {NEW_CAT_BASE+3});
```

**Important notes about the translation map:**
- `INSERT IGNORE` is used because some FR chapter titles are duplicated across livres
- `UNIQUE KEY` (not `PRIMARY KEY`) avoids hard failures
- Use `_tmp_{lang}_trans` not `rows` (reserved word) for column names
- After running, check for any chapter still containing French characters (`é`, `è`, `ê`, `à`, `ç`, etc. with `BINARY LIKE`) — these usually have apostrophes that broke the JOIN. Add explicit UPDATE statements at the end of the file for those edge cases.

The full list of ~500 unique FR titles can be obtained from the existing `update_tr_translations.sql` — copy it and translate all the right-hand sides.

---

## 11. Run on Local

Test the entire flow on your local XAMPP MySQL **before** deploying to production.

```bash
# 1. Run the setup (creates structure)
/c/xampp/7.4/mysql/bin/mysql.exe -u root --skip-password DATABASE_NAME < setup_{lang}_database.sql

# 2. Run the translations
/c/xampp/7.4/mysql/bin/mysql.exe -u root --skip-password DATABASE_NAME < update_{lang}_translations.sql

# 3. Verify
/c/xampp/7.4/mysql/bin/mysql.exe -u root --skip-password DATABASE_NAME -e "SET NAMES utf8; SELECT IDCategory, Libelle FROM _category WHERE multi_lingue = '{LANG}';"
```

You should see your 4 categories with proper native names (no garbled characters).

Then test in the browser:
- `http://localhost/public_html/{LANG}/login`
- `http://localhost/public_html/{LANG}/category/Curso-Anatomia-{LANG}`
- (and the other 3 category URLs)

---

## 12. Deploy to Server

```bash
# 1. Commit and push
git add -A
git commit -m "Add {LangName} ({LANG}) language support"
git push

# 2. On the server
git pull
bash setup_{lang}_language.sh                                    # creates dirs/copies assets
mysql -u USER -p DATABASE < setup_{lang}_database.sql            # creates DB structure
mysql -u USER -p DATABASE < update_{lang}_translations.sql       # applies translations
```

---

## 13. Testing Checklist

### Routing
- [ ] `base_url/{LANG}/login` loads (HTTP 200)
- [ ] All 4 category URLs return HTTP 200
- [ ] Direct URL access without prior session works
- [ ] All 40+ routes work with `{LANG}` prefix

### Language switcher
- [ ] Header dropdown shows the new flag
- [ ] Admin globe selector shows the new language name
- [ ] Clicking switches session and redirects to `/{LANG}/login`
- [ ] Session persists across page navigation

### Content
- [ ] All UI strings display in the new language (no missing keys / no FR fallback)
- [ ] Home page renders properly (4 category cards point to correct URLs)
- [ ] Category page shows the new language cover images
- [ ] Navbar shows the 4 native category names with chapter dropdowns

### Database / Navigation
- [ ] Category → Theme → Livre → Chapter navigation works
- [ ] Books have cover images (no "NoPicture" placeholder)
- [ ] Pathology category loads with pathology layout (not Cours layout)
- [ ] Atlas category loads with atlas layout
- [ ] Lecture mode (`v1_*` views) renders correctly for all 4 categories

### Admin
- [ ] Actualites form has `Titre_{LANG}` field
- [ ] Actualites table has `{LANG} Titre` column
- [ ] livreDetails.php pathology reference dropdown shows for `{LANG}` books

### Edge cases
- [ ] Switching from `{LANG}` to FR and back preserves navigation
- [ ] Direct URL access to a non-existent slug redirects to the first `{LANG}` category
- [ ] Books in lecture mode (`/livre/ID`) load the right sidebar (`v1_racourci_atlas.php` for Atlas, `v1_racourci_pathologie.php` for Pathology, default for Cours/Embryology)

---

## 14. Troubleshooting

### Symptom: Native characters appear garbled (Ð?Ð°Ð²...)

**Cause**: Database column charset is `latin1`. Non-Latin characters (Cyrillic, Chinese, Arabic, etc.) cannot be stored in latin1.

**Fix**: The `setup_{lang}_database.sql` script includes `ALTER TABLE ... CONVERT TO CHARACTER SET utf8` — make sure it ran. If you forgot it:

```sql
ALTER TABLE `_category`  MODIFY `Libelle`        VARCHAR(150) CHARACTER SET utf8 NOT NULL;
ALTER TABLE `_theme`     MODIFY `LibelleTheme`   VARCHAR(150) CHARACTER SET utf8 NOT NULL;
ALTER TABLE `_livre`     MODIFY `Titre`          VARCHAR(50)  CHARACTER SET utf8 NOT NULL;
ALTER TABLE `_chapitre`  MODIFY `TitreChapitre`  VARCHAR(100) CHARACTER SET utf8 NOT NULL;
```

Then re-run `update_{lang}_translations.sql` with `SET NAMES utf8;` at the top.

### Symptom: Categories don't appear in the navbar

**Cause**: `EstActifMenu = 0` in the new categories.

**Fix**:
```sql
UPDATE _category SET EstActifMenu = 1 WHERE IDCategory IN ({NEW_CAT_BASE}, {NEW_CAT_BASE+1}, {NEW_CAT_BASE+2}, {NEW_CAT_BASE+3});
```

### Symptom: Books show "NoPicture" instead of cover images

**Cause**: `encryptCouverture` is empty for the new language livres.

**Fix**: The `setup_{lang}_database.sql` procedure includes a step that copies `encryptCouverture` and `Description` from FR. Make sure the procedure ran without errors.

### Symptom: Clicking on Atlas/Pathology shows the Cours layout

**Cause**: `v1_racourci.php` doesn't recognize the new category as Atlas/Pathology.

**Fix**: See section 8.4 — add the new category IDs and/or native names to `v1_racourci.php`.

### Symptom: All tabs (QCM, QROC, Resume) are missing on the book page

**Cause**: Feature flags `EstActifQSM`, `EstActifQROC`, etc. are NULL on the new categories.

**Fix**: The setup script copies them from FR. If you manually inserted categories, run:

```sql
UPDATE _category dst
JOIN _category src ON src.IDCategory = (CASE dst.IDCategory
    WHEN {NEW_CAT_BASE}   THEN 3
    WHEN {NEW_CAT_BASE+1} THEN 4
    WHEN {NEW_CAT_BASE+2} THEN 5
    WHEN {NEW_CAT_BASE+3} THEN 7
END)
SET dst.EstActifQSM     = src.EstActifQSM,
    dst.EstActifQROC    = src.EstActifQROC,
    dst.EstActifResume  = src.EstActifResume,
    dst.EstActifCalques = src.EstActifCalques,
    dst.EstActifTest    = src.EstActifTest
WHERE dst.multi_lingue = '{LANG}';
```

### Symptom: Translation script fails with "Duplicate entry for key 'PRIMARY'"

**Cause**: Some FR titles are duplicated across livres (e.g. "10-Rectum" appears in both Cours and Atlas).

**Fix**: Use `UNIQUE KEY uniq_fr` instead of `PRIMARY KEY`, and use `INSERT IGNORE` instead of `INSERT`.

### Symptom: Translation script fails with "syntax error near 'rows'"

**Cause**: `rows` is a reserved word in MariaDB.

**Fix**: Rename the column alias: `ROW_COUNT() AS nb_rows`.

### Symptom: Some chapters were not translated (still in French)

**Cause**: FR chapter titles with apostrophes (`l'appareil digestif`) confuse the JOIN.

**Fix**: Add explicit UPDATE statements at the end of `update_{lang}_translations.sql` for those edge cases. You can find them with:

```sql
SELECT ch.IDChapitre, ch.TitreChapitre, ch.IDLivre
FROM _chapitre ch
JOIN _livre l ON l.IDLivre = ch.IDLivre
JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE t.IDCategory IN ({NEW_CAT_BASE}, {NEW_CAT_BASE+1}, {NEW_CAT_BASE+2}, {NEW_CAT_BASE+3})
  AND (ch.TitreChapitre LIKE BINARY '%é%' OR ch.TitreChapitre LIKE BINARY '%è%'
       OR ch.TitreChapitre LIKE BINARY '%ê%' OR ch.TitreChapitre LIKE BINARY '%à%');
```

---

## File Reference Summary

### Files to CREATE (per new language)

| File | Purpose |
|---|---|
| `application/language/{LANG}/content_lang.php` | Main UI translations (~383 entries) |
| `application/language/{LANG}/db_lang.php` | DB error messages |
| `application/language/{LANG}/email_lang.php` | Email error messages |
| `application/language/{LANG}/imglib_lang.php` | Image library error messages |
| `application/language/{LANG}/rest_controller_lang.php` | REST API messages |
| `application/language/{LANG}/index.html` | CodeIgniter security placeholder |
| `assets/couverture_{LANG}/PR_ATLAS_{LANG}.jpg` | Atlas cover (replace with proper graphic) |
| `assets/couverture_{LANG}/PR_COURSES_{LANG}.jpg` | Courses cover |
| `assets/couverture_{LANG}/PR_EMBR_{LANG}.jpg` | Embryology cover |
| `assets/couverture_{LANG}/PR_PATHO_{LANG}.jpg` | Pathology cover |
| `assets/img/flags/{LANG}.png` | Flag image |
| `setup_{lang}_language.sh` | Optional setup shell script |
| `setup_{lang}_database.sql` | DB structure setup |
| `update_{lang}_translations.sql` | DB translations |

### Files to MODIFY (per new language)

| File | What to add |
|---|---|
| `assets/urls.json` | `{LANG}_id` field on every entry + 4 new entries |
| `application/config/routes.php` | ~40 new route entries with `^{LANG}/` prefix |
| `application/controllers/Home.php` | switchLang/setLang/regex blocks + pageCategory fallback + actualites add/update |
| `application/views/v1_header_langauge.php` | Add to `$flags` array + dropdown item |
| `application/views/header_steppes.php` | Add to admin globe selector |
| `application/views/page_category.php` | Add cover image branches (2 places) |
| `application/views/page_home.php` | Add 4 category card branches + actualites display |
| `application/views/livreDetails.php` | Add `'{LANG}'` to `multi_lingue` checks (3 places) + native pathology word in stripos chains (3 places) |
| `application/views/actualitesmodals.php` | Add `Titre_{LANG}` field in Add + Update modals |
| `application/views/settingActualites.php` | Add `{LANG} Titre` table column |
| `application/views/v1_racourci.php` | Add new language to atlas/pathology category arrays + Libelle stripos chains |
| `application/views/v1_bloc_figures.php` | Add new language atlas theme ID |
| `application/views/v1_bloc_figures_atlas.php` | Add new language atlas category ID |
| `application/views/v1_header_nav.php` | Add new language atlas category ID |

### Database Changes (per new language)

- 4 new rows in `_category`
- 4 new rows in `_theme`
- 35 new rows in `_livre` (mirroring FR)
- ~643 new rows in `_chapitre` (mirroring FR)
- 1 new column on `_category`: `{LANG}_Description`
- 1 new column on `actualites`: `{LANG}_title`
- Charset converted to `utf8` on: `_category.Libelle`, `_theme.LibelleTheme`, `_livre.Titre`, `_chapitre.TitreChapitre`

---

## Effort Estimate (per new language)

| Phase | Effort | Bottleneck |
|---|---|---|
| 1. Filesystem setup | 5 minutes | mechanical |
| 2. Translation files (`content_lang.php`) | **Large** | translating 383 strings |
| 3. URL/routes/controller updates | 15 minutes | mechanical |
| 4. View updates | 20 minutes | mechanical (search & replace) |
| 5. SQL setup script | 10 minutes | copy-modify existing |
| 6. SQL translation script | **Largest** | translating ~640 medical terms |
| 7. Local testing | 15 minutes | manual |
| 8. Deployment | 5 minutes | runs the same scripts |

The translations dominate the effort. Everything else is mechanical and predictable.

---

**Last validated**: 2026-04-10 with the addition of Russian (RU) and Turkish (TR).
