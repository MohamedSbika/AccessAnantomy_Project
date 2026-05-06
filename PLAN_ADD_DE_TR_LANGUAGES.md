# Plan: Adding German (DE) & Turkish (TR) Languages

> **Date**: 2026-04-08  
> **Branch**: sbika-clean  
> **Status**: Preparation — no files modified yet

---

## Current State

| Component | FR | EN | ES | DE | TR |
|---|---|---|---|---|---|
| Language folder (`application/language/`) | OK | OK | OK | -- | -- |
| Routes (`routes.php`) | OK | OK | OK | -- | -- |
| Language switcher UI (`v1_header_langauge.php`) | OK | OK | OK | -- | -- |
| `urls.json` IDs | OK | OK | OK | -- | -- |
| Controller `setLang()` / `switchLang()` | OK | OK | OK | **OK** | -- |
| Cover images | OK | OK | OK | -- | -- |
| `page_home.php` conditionals | OK | OK | OK | -- | -- |
| `page_category.php` conditionals | OK | OK | OK | -- | -- |
| `google_translate_images.js` data attributes | OK | OK | OK | -- | -- |

> `Home.php` already handles DE in `setLang()` (line 1136) and `switchLang()` (line 1104). Only TR is missing there.

---

## PHASE 1 — Controller & Configuration (Foundation)

### 1.1 — `application/controllers/Home.php`

**`switchLang()` method (line 1092-1113)**

- [ ] Add TR block after the ES block (after line 1109):

```php
if ($lang == 'TR') {
    $this->session->set_userdata('site_lang_lib', 'Türkçe');
}
```

**`setLang()` method (line 1114-1147)**

- [ ] Update regex at line 1118 to include TR:

```php
// BEFORE
if (preg_match('#/(FR|EN|ES|DE)/#', $uri, $matches))
// AFTER
if (preg_match('#/(FR|EN|ES|DE|TR)/#', $uri, $matches))
```

- [ ] Add TR block after the DE block (after line 1139):

```php
if ($lang == 'TR') {
    $this->session->set_userdata('site_lang_lib', 'Türkçe');
    $lang = 'TR';
}
```

---

### 1.2 — `application/config/routes.php`

- [ ] Duplicate ALL `^FR/` routes (lines 89-127) with `^DE/` prefix
- [ ] Duplicate ALL `^FR/` routes (lines 89-127) with `^TR/` prefix
- [ ] Duplicate shared top routes for DE and TR (lines 76-87): `testFigure`, `listCalque`, `listTest`
- [ ] Duplicate `products/buyProduct` route (line 169) for DE and TR
- [ ] Duplicate `PlatFormeConvert` route (line 217) for DE and TR

Full list of routes to duplicate (40 per language):

```
switchPlatform/(:any)
login
category/(:any)
livreList/(:any)/(:any)
livre/(:any)
livreDetails/(:any)
livreCours/(:any)/(:any)
livreCours/(:any)
livreResume/(:any)/(:any)
livreResume/(:any)
livreFigures/(:any)
figuresOnly/(:any)
livreQcm/(:any)
livreQroc/(:any)
signUp
resetUp
forgot_password
pagesSetting
logout
settingUsers
settingUsersEtab
settingCurs
settingPlat
settingActualites
settingTest/(:any)
cursHTML/(:any)/(:any)
cursHTML/(:any)
figHTML/(:any)
livreQcmEdit/(:any)
livreQrocEdit/(:any)
searchIndex
listOffers/(:any)
evaluatQCM/(:any)/(:any)/(:any)
evaluatQROC/(:any)/(:any)/(:any)
evaluatTEST/(:any)
evaluatCalque/(:any)
contactUS
testFigure/(:any)
listCalque/(:any)
listTest/(:any)
products/buyProduct/(:any)
PlatFormeConvert/(:any)
```

---

## PHASE 2 — Language Translation Files

### 2.1 — CREATE `application/language/DE/` folder

- [ ] `content_lang.php` — Copy from `EN/content_lang.php` (384 lines), translate all values to German, set `$lang['siteLang'] = 'DE/';`
- [ ] `email_lang.php` — Copy from `EN/email_lang.php`, translate to German
- [ ] `rest_controller_lang.php` — Copy from `EN/rest_controller_lang.php`, translate to German
- [ ] `db_lang.php` — Copy from `FR/db_lang.php`, translate to German
- [ ] `imglib_lang.php` — Copy from `FR/imglib_lang.php`, translate to German
- [ ] `index.html` — Copy from `FR/index.html` (security placeholder, no change needed)

### 2.2 — CREATE `application/language/TR/` folder

- [ ] `content_lang.php` — Copy from `EN/content_lang.php` (384 lines), translate all values to Turkish, set `$lang['siteLang'] = 'TR/';`
- [ ] `email_lang.php` — Copy from `EN/email_lang.php`, translate to Turkish
- [ ] `rest_controller_lang.php` — Copy from `EN/rest_controller_lang.php`, translate to Turkish
- [ ] `db_lang.php` — Copy from `FR/db_lang.php`, translate to Turkish
- [ ] `imglib_lang.php` — Copy from `FR/imglib_lang.php`, translate to Turkish
- [ ] `index.html` — Copy from `FR/index.html` (security placeholder, no change needed)

### Key translation categories in `content_lang.php` (384 strings):

| Category | Example keys | Count |
|---|---|---|
| Navigation / UI | `accueil`, `chapitres`, `cours`, `search` | ~30 |
| Auth / Login | `sign_in`, `sign_up`, `password`, `forgot_password` | ~15 |
| Medical terms | `qcm`, `qroc`, `figur`, `resume`, `Calques` | ~10 |
| Home page content | `desc_access`, `learning_steps_*`, `step_*_title/desc` | ~40 |
| Pricing plans | `basic_*`, `premium_*`, `institutional_*` | ~25 |
| Contact form | `form_*`, `contact*` | ~15 |
| Footer | `footer_*` | ~10 |
| Sidebar | `sidebar_*` | ~15 |
| Admin / Settings | `usersList`, `paramsList`, `settings` | ~20 |
| Delete / Confirm | `supp_*`, `titleSupprission`, `messageSupprission` | ~15 |
| Tests / Evaluation | `test*`, `lecture_*` | ~20 |
| Email templates | `mail_insc_*`, `mail_msg_*` | ~10 |
| Chatbot section | `chatbot_*` | ~8 |
| Pathology section | `pathologie_*` | ~8 |
| Videos | `voirVideos`, `videos`, `add_video`, etc. | ~6 |
| Misc | `oui`, `non`, `save`, `wait`, etc. | ~20 |

---

## PHASE 3 — Language Switcher UI

### 3.1 — `application/views/v1_header_langauge.php`

- [ ] Add DE and TR to `$flags` array (line 6-10):

```php
$flags = [
    'FR' => '🇫🇷',
    'EN' => '🇬🇧',
    'ES' => '🇪🇸',
    'DE' => '🇩🇪',
    'TR' => '🇹🇷'
];
```

- [ ] Add 2 new dropdown items after the ES item (after line 41):

```html
<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/DE"
   style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
    🇩🇪 &nbsp;Deutsch
</a>
<a class="dropdown-item" href="<?php echo base_url(); ?>login/switchLang/TR"
   style="color: #120e47;margin-left: 0px;" onclick="resetTranslate()">
    🇹🇷 &nbsp;Türkçe
</a>
```

---

## PHASE 4 — Database & URL Mapping

### 4.1 — Database: Create DE and TR book/course entries

Current IDs per language:

| Book | FR_id | EN_id | ES_id | DE_id | TR_id |
|---|---|---|---|---|---|
| Cours Anatomie | 3 | 8 | 2596 | **TBD** | **TBD** |
| Atlas Anatomie | 4 | 9 | 2597 | **TBD** | **TBD** |
| Embryologie | 5 | 10 | 2598 | **TBD** | **TBD** |
| Pathologie | 7 | 11 | 2599 | **TBD** | **TBD** |

- [ ] Create 4 new DB records for German books (via admin panel or SQL INSERT)
- [ ] Create 4 new DB records for Turkish books (via admin panel or SQL INSERT)
- [ ] Note down the new IDs for use in `urls.json`

### 4.2 — `assets/urls.json`

- [ ] Add `"DE_id"` and `"TR_id"` fields to ALL 12 existing entries
- [ ] Add 4 new German URL slug entries:

```json
{ "url": "Anatomie-Kurse",   "id": <DE_ID>, "FR_id": 3, "EN_id": 8, "ES_id": 2596, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Anatomie-Atlas",   "id": <DE_ID>, "FR_id": 4, "EN_id": 9, "ES_id": 2597, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Embryologie-DE",   "id": <DE_ID>, "FR_id": 5, "EN_id": 10, "ES_id": 2598, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Pathologie-DE",    "id": <DE_ID>, "FR_id": 7, "EN_id": 11, "ES_id": 2599, "DE_id": <DE_ID>, "TR_id": <TR_ID> }
```

- [ ] Add 4 new Turkish URL slug entries:

```json
{ "url": "Anatomi-Dersleri", "id": <TR_ID>, "FR_id": 3, "EN_id": 8, "ES_id": 2596, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Anatomi-Atlasi",   "id": <TR_ID>, "FR_id": 4, "EN_id": 9, "ES_id": 2597, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Embriyoloji",      "id": <TR_ID>, "FR_id": 5, "EN_id": 10, "ES_id": 2598, "DE_id": <DE_ID>, "TR_id": <TR_ID> },
{ "url": "Patoloji-TR",      "id": <TR_ID>, "FR_id": 7, "EN_id": 11, "ES_id": 2599, "DE_id": <DE_ID>, "TR_id": <TR_ID> }
```

---

## PHASE 5 — Views with Language Conditionals

### 5.1 — `application/views/page_category.php`

**2 locations** with language-based cover image logic (lines ~82-90 and ~154-160).

- [ ] Add DE and TR branches at both locations:

```php
// After the ES elseif (around line 86 and line 157)
elseif ($lang == 'DE') $couv = 'assets/couverture_DE/PR_PATHO_DE.jpg';
elseif ($lang == 'TR') $couv = 'assets/couverture_TR/PR_PATHO_TR.jpg';
```

### 5.2 — `application/views/page_home.php`

**22 conditional blocks** checking `site_lang == '' || site_lang == 'FR'`.

These blocks show FR-specific content (YouTube embeds, images). The `else` branches handle non-FR languages.

- [ ] Review each block to confirm DE and TR fall through to the `else` (EN-like) branch correctly
- [ ] For blocks with `elseif ($this->session->userdata('site_lang') == 'ES')` specific handling (lines 916, 935, 953, 971): decide if DE/TR need their own branch or can share the default `else`

**Decision per block:**

| Lines | Content | DE/TR action |
|---|---|---|
| 562 | YouTube video embed | Falls to else = OK, no change |
| 581 | Image/banner | Falls to else = OK |
| 602, 612, 629, 648, 666 | Presentation content | Falls to else = OK |
| 819, 831 | Feature section | Falls to else = OK |
| 912-920 | ES-specific block | Verify DE/TR falls to else |
| 930-940 | ES-specific block | Verify DE/TR falls to else |
| 949-957 | ES-specific block | Verify DE/TR falls to else |
| 967-975 | ES-specific block | Verify DE/TR falls to else |
| 1056 | Content block | Falls to else = OK |
| 1158, 1191, 1200, 1209 | Bottom sections | Falls to else = OK |

### 5.3 — `application/views/footer.php`

- [ ] Check for any hardcoded language conditionals and add DE/TR if needed

### 5.4 — `application/views/footer_org.php`

- [ ] Check for any hardcoded language conditionals and add DE/TR if needed

---

## PHASE 6 — Assets (Images & Flags)

### 6.1 — CREATE German cover images folder `assets/couverture_DE/`

- [ ] `PR_ATLAS_DE.jpg` — German Atlas cover
- [ ] `PR_COURSES_DE.jpg` — German Courses cover (or `PR_COUSES_DE.jpg` to match EN typo pattern)
- [ ] `PR_EMBR_DE.jpg` — German Embryology cover
- [ ] `PR_PATHO_DE.jpg` — German Pathology cover

### 6.2 — CREATE Turkish cover images folder `assets/couverture_TR/`

- [ ] `PR_ATLAS_TR.jpg` — Turkish Atlas cover
- [ ] `PR_COURSES_TR.jpg` — Turkish Courses cover
- [ ] `PR_EMBR_TR.jpg` — Turkish Embryology cover
- [ ] `PR_PATHO_TR.jpg` — Turkish Pathology cover

### 6.3 — Pathology-specific cover images

- [ ] `assets/img/photos/pathologie_cov/PR_PATHO_DE.jpg`
- [ ] `assets/img/photos/pathologie_cov/PR_PATHO_TR.jpg`

### 6.4 — Flag images in `assets/img/flags/`

- [x] `DE.png` — **Already exists**
- [ ] `TR.png` — **Needs to be created** (Turkish flag)

### 6.5 — Google Translate image swap (`data-src-*` attributes)

In any view where `<img>` tags already use `data-src-en` / `data-src-es`, add:

- [ ] `data-src-de="path/to/german_image.jpg"`
- [ ] `data-src-tr="path/to/turkish_image.jpg"`

> No change needed in `assets/js/google_translate_images.js` itself — it reads `data-src-{lang}` dynamically.

---

## PHASE 7 — Testing Checklist

### Routing

- [ ] `base_url()/DE/login` loads German login page
- [ ] `base_url()/TR/login` loads Turkish login page
- [ ] `base_url()/DE/category/Anatomie-Kurse` loads German category
- [ ] `base_url()/TR/category/Anatomi-Dersleri` loads Turkish category
- [ ] All 40+ routes work with DE prefix
- [ ] All 40+ routes work with TR prefix

### Language switcher

- [ ] Dropdown shows 5 flags: FR, EN, ES, DE, TR
- [ ] Clicking DE flag switches to German and redirects to `/DE/login`
- [ ] Clicking TR flag switches to Turkish and redirects to `/TR/login`
- [ ] Session persists language across page navigation
- [ ] "Autre..." Google Translate still works

### Content

- [ ] All UI strings display in German when DE is active
- [ ] All UI strings display in Turkish when TR is active
- [ ] No missing translation keys (check for empty strings or PHP warnings)
- [ ] Home page renders properly for DE and TR (no broken conditionals)
- [ ] Category pages show correct DE/TR cover images
- [ ] Navigation breadcrumbs use `/DE/` or `/TR/` prefix in links

### Assets

- [ ] German cover images load correctly
- [ ] Turkish cover images load correctly
- [ ] Flag images display in switcher

### Edge cases

- [ ] Direct URL access without prior session works (e.g., first visit to `/DE/login`)
- [ ] Switching from DE to FR and back preserves navigation
- [ ] Switching from TR to EN and back preserves navigation
- [ ] Google Translate image swap works with `data-src-de` and `data-src-tr`

---

## Files Summary

### Files to CREATE (14 new files + 10 images)

| File | Description |
|---|---|
| `application/language/DE/content_lang.php` | German UI translations (384 lines) |
| `application/language/DE/email_lang.php` | German email templates |
| `application/language/DE/rest_controller_lang.php` | German API messages |
| `application/language/DE/db_lang.php` | German DB error messages |
| `application/language/DE/imglib_lang.php` | German image lib messages |
| `application/language/DE/index.html` | Security placeholder |
| `application/language/TR/content_lang.php` | Turkish UI translations (384 lines) |
| `application/language/TR/email_lang.php` | Turkish email templates |
| `application/language/TR/rest_controller_lang.php` | Turkish API messages |
| `application/language/TR/db_lang.php` | Turkish DB error messages |
| `application/language/TR/imglib_lang.php` | Turkish image lib messages |
| `application/language/TR/index.html` | Security placeholder |
| `assets/img/flags/TR.png` | Turkish flag image |
| `assets/couverture_DE/*.jpg` | 4 German cover images |
| `assets/couverture_TR/*.jpg` | 4 Turkish cover images |
| `assets/img/photos/pathologie_cov/PR_PATHO_DE.jpg` | German pathology cover |
| `assets/img/photos/pathologie_cov/PR_PATHO_TR.jpg` | Turkish pathology cover |

### Files to MODIFY (6 files)

| File | Lines affected | Change |
|---|---|---|
| `application/controllers/Home.php` | 1109, 1118, 1139 | Add TR to switchLang, setLang regex, setLang block |
| `application/config/routes.php` | +80 new lines | Duplicate all routes for ^DE/ and ^TR/ |
| `application/views/v1_header_langauge.php` | 6-10, 41 | Add DE/TR flags and dropdown items |
| `application/views/page_category.php` | ~86, ~157 | Add DE/TR cover image branches |
| `application/views/page_home.php` | Multiple blocks | Verify else branches handle DE/TR |
| `assets/urls.json` | All entries + 8 new | Add DE_id, TR_id fields + German/Turkish URL slugs |

---

## Effort Estimate

| Phase | Effort | Bottleneck |
|---|---|---|
| Phase 1 — Controller & Routes | Small | Mechanical duplication |
| Phase 2 — Translation files | **Large** | Translating 384 strings x2 languages |
| Phase 3 — Language switcher | Small | 2 lines of HTML + array update |
| Phase 4 — Database & urls.json | Medium | Requires creating DB records first |
| Phase 5 — View conditionals | Medium | Review 22 blocks in page_home.php |
| Phase 6 — Cover images & flags | Medium | Design/graphic work |
| Phase 7 — Testing | Medium | Manual testing all routes |

**Recommended execution order**: Phase 1 → Phase 2 → Phase 3 → Phase 4 → Phase 5 → Phase 6 → Phase 7
