# Language Addition Playbook

Concrete, step-by-step recipe for adding a new language to Access Anatomy. This is what was actually executed when adding **Italian (IT)**, **German (DE)**, and **Polish (PL)** in 2026-05.

> For deeper rationale and history see `ADD_NEW_LANGUAGE_GUIDE.md`. This playbook is the executable cheat-sheet.

---

## 0. Reservation Table

Each new language gets a 4-number block of category IDs and a unique URL slug per category.

| Lang | Cat IDs | First slot in `urls.json` | Atlas theme ID |
|------|---------|---------------------------|----------------|
| FR   | 3, 4, 5, 7         | 0  | 16 |
| EN   | 8, 9, 10, 11       | 4  | 27 |
| ES   | 2596–2599          | 8  | 34 |
| RU   | 2700–2703          | 12 | 42 |
| TR   | 2800–2803          | 16 | 46 |
| PT   | 2900–2903          | 20 | 50 |
| IT   | 3000–3003          | 24 | 54 |
| DE   | 3100–3103          | 28 | 58 |
| PL   | 3200–3203          | 32 | 62 |
| **NEXT** | **3300–3303** | **36** | **66** |

**Pattern:** Each new language adds 4 categories (consecutive IDs), 4 themes (one per category — atlas theme ID = `prev_atlas + 4`), 35 livres, ~643 chapters. The first urls.json index = `prev_first + 4`.

Before starting, decide:

| Item | Example |
|---|---|
| `{LANG}` (2-letter uppercase) | `JA` |
| `{LangName}` (native) | `日本語` |
| `{Flag}` emoji | `🇯🇵` |
| `{NEW_CAT_BASE}` | `3300` |
| `{NEW_FIRST_INDEX}` | `36` |
| `{NEW_ATLAS_THEME}` | `66` |
| URL slugs | `Anatomy-Course-JA`, `Anatomy-Atlas-JA`, `Embryology-JA`, `Pathology-JA` (pick natively, must be unique across all langs) |
| Native category names | `解剖学コース`, `解剖学アトラス`, `胎生学`, `病理学` |

---

## Phase A — Filesystem (5 min)

### A.1. Create `setup_{lang}_language.sh`

Copy `setup_pl_language.sh` and replace `PL`→`{LANG}`, `Polish`→`{LangName-English}`. Then:

```bash
bash setup_{lang}_language.sh
```

This creates:
- `application/language/{LANG}/`
- `assets/couverture_{LANG}/PR_{ATLAS,COURSES,EMBR,PATHO}_{LANG}.jpg` (copied from ES)
- `assets/img/flags/{LANG}.png` (copied from EN — replace later)

### A.2. Copy the 5 CodeIgniter system language files

```bash
cp application/language/EN/email_lang.php          application/language/{LANG}/email_lang.php
cp application/language/EN/rest_controller_lang.php application/language/{LANG}/rest_controller_lang.php
cp application/language/RU/db_lang.php             application/language/{LANG}/db_lang.php
cp application/language/RU/imglib_lang.php         application/language/{LANG}/imglib_lang.php
cp application/language/FR/index.html              application/language/{LANG}/index.html
```

---

## Phase B — `application/language/{LANG}/content_lang.php`

This is the bulk-translation file (~383 keys). **Don't copy from FR mechanically** — translate every value into `{LangName}`.

Quickest path:
1. `cp application/language/PL/content_lang.php application/language/{LANG}/content_lang.php` (PL is the most up-to-date reference)
2. Change first line: `$lang['siteLang'] = '{LANG}/';`
3. Change `$lang['table_lang'] = '{LangNameEnglish}';`
4. Replace every Polish value with the native translation. Keep the keys, structure, and emoji literals (`🤖`, `📌`, `🩺`, `✨`, `<br>`) intact.
5. Validate: `php -l application/language/{LANG}/content_lang.php`

**Apostrophe trap:** Strings containing apostrophes must use double quotes or `\'` escapes. PHP single-quoted strings will break otherwise.

---

## Phase C1 — `assets/urls.json` (PHP one-liner)

Run from project root:

```bash
php -r '
$file = "assets/urls.json";
$j = json_decode(file_get_contents($file), true);
$map = [3 => {NEW_CAT_BASE}, 4 => {NEW_CAT_BASE}+1, 5 => {NEW_CAT_BASE}+2, 7 => {NEW_CAT_BASE}+3];
foreach ($j as &$entry) {
    $entry["{LANG}_id"] = $map[$entry["FR_id"]];
}
unset($entry);
$newSlugs = [
    ["url" => "{Slug-Course}", "id" => {NEW_CAT_BASE},   "FR_id" => 3, /* ...all *_id keys mapped... */, "{LANG}_id" => {NEW_CAT_BASE}],
    ["url" => "{Slug-Atlas}",  "id" => {NEW_CAT_BASE}+1, "FR_id" => 4, /* ... */, "{LANG}_id" => {NEW_CAT_BASE}+1],
    ["url" => "{Slug-Embry}",  "id" => {NEW_CAT_BASE}+2, "FR_id" => 5, /* ... */, "{LANG}_id" => {NEW_CAT_BASE}+2],
    ["url" => "{Slug-Patho}",  "id" => {NEW_CAT_BASE}+3, "FR_id" => 7, /* ... */, "{LANG}_id" => {NEW_CAT_BASE}+3],
];
$j = array_merge($j, $newSlugs);
file_put_contents($file, json_encode($j, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
echo count($j) . " entries\n";
echo "Index {NEW_FIRST_INDEX}: " . $j[{NEW_FIRST_INDEX}]["url"] . "\n";
'
```

**Important:** When constructing `$newSlugs`, copy ALL `*_id` keys from the most recent existing entry of the corresponding FR category — every previously-added language must be represented (or the cross-language redirect logic in `pageCategory()` will break for that language).

Verify: the final `count` should be `prev_count + 4`, and index `{NEW_FIRST_INDEX}` should be `{Slug-Course}`.

---

## Phase C2 — `application/config/routes.php`

Three specific spots, each adding the new lang to the existing chain:

### C2.1. Top routes — `testFigure`, `listCalque`, `listTest` (around line 76)
Add `$route['^{LANG}/testFigure/(:any)']  = "home/getFigure/$1";` after the last existing `^XX/testFigure` line, and the same for `listCalque` and `listTest` blocks.

### C2.2. Main route block (before `$route['404_override']`)
Duplicate the entire `^PL/` block (or whichever was added last) as `^{LANG}/`. ~38 routes.

### C2.3. Bottom routes (after `404_override`)
Add `^{LANG}/PlatFormeConvert/(:any)` and `^{LANG}/products/buyProduct/(:any)`.

Validate: `php -l application/config/routes.php`

---

## Phase C3 — `application/controllers/Home.php` (5 spots)

### C3.1. `switchLang()` (~line 1118)
After the last existing `if ($lang == 'XX')` block, add:
```php
if ($lang == '{LANG}') {
    $this->session->set_userdata('site_lang_lib', '{LangName}');
}
```

### C3.2. `setLang()` regex (~line 1127)
```php
if (preg_match('#/(FR|EN|ES|DE|RU|TR|PT|IT|PL|{LANG})/#', $uri, $matches)) {
```

### C3.3. `setLang()` second block (just before `$this->session->set_userdata('site_lang', $lang);`)
```php
if ($lang == '{LANG}') {
    $this->session->set_userdata('site_lang_lib', '{LangName}');
    $lang = '{LANG}';
}
```

### C3.4. `pageCategory()` fallback (~line 1300)
Add an `elseif` before the final `else FR` branch:
```php
} elseif ($lang == "{LANG}") {
    redirect('{LANG}/category/' . $json[{NEW_FIRST_INDEX}]['url']);
}
```

### C3.5. `add_Actualite()` and `update_Actualite()` (~line 2760, ~line 2790)
After the last `$titleXX = isset($_POST["XX_title"])...` line, add:
```php
$title{LANG} = isset($_POST["{LANG}_title"]) ? $_POST["{LANG}_title"] : '';
```
And add `'{LANG}_title' => $title{LANG}` to the `$data` array.

### C3.6. Pathology detection (CHECK FIRST — usually skip)
`isPathologieCategory()`, `getPathologieByRappel()`, and the stripos chains in `livreDetails.php` already cover any Latin-script word that contains `Pathologie` / `Patologia` / `Pathology` (case-insensitive). Only add a new `stripos` if your language's pathology word is not a substring of one of those (e.g. Russian `Патология`, Turkish `Patoloji`).

Validate: `php -l application/controllers/Home.php`

---

## Phase C4 — 11 View Files

For each file, find the most recently added language's branch and append a `{LANG}` branch right after it. Always validate with `php -l` after.

### C4.1. `application/views/v1_header_langauge.php`
- Add `'{LANG}' => '{Flag}'` to the `$flags` array.
- Add a new `<a class="dropdown-item" href="...switchLang/{LANG}">{Flag} &nbsp;{LangName}</a>` before the "Autre..." dropdown item.

### C4.2. `application/views/header_steppes.php`
**(NOTE: the admin dropdown was refactored in 2026-05 to a data-driven collapsible — see "Admin Language Dropdown" section below.) Append one entry to the `$adminLangs` array near line 137:**
```php
'{LANG}' => ['flag' => '{Flag}', 'name' => '{LangName}'],
```
The dropdown items are auto-rendered via `foreach`, so this is the only edit needed in this file.

### C4.3. `application/views/page_category.php` (4 edits — 2 pathology covers + 2 per-category blocks)
- After `elseif ($lang == 'PL') $couv = 'assets/couverture_PL/PR_PATHO_PL.jpg';` add:
  `elseif ($lang == '{LANG}') $couv = 'assets/couverture_{LANG}/PR_PATHO_{LANG}.jpg';`
- Same for `$couv2`/`$lang2` (2nd location).
- After the `if ($lang == 'PL') { ... }` block, add a similar block for `{LANG}` matching the native words for "Course" / "Atlas" / "Embryology". Same for the `$lang2`/`$couv2` second location.

### C4.4. `application/views/page_home.php` (5 edits — 4 cards + 1 actualites)
After each `<?php } elseif ($this->session->userdata('site_lang') == 'PL') { ?>` card block, insert a `'{LANG}'` block with the matching slug and cover. Repeat for the actualites display block at the bottom.

### C4.5. `application/views/livreDetails.php` (1 edit, replace_all)
Replace `['EN', 'ES', 'RU', 'TR', 'PT', 'IT', 'DE', 'PL']` with `['EN', 'ES', 'RU', 'TR', 'PT', 'IT', 'DE', 'PL', '{LANG}']`.

### C4.6. `application/views/actualitesmodals.php` (2 edits — Add modal + Update modal)
After the `Titre_PL` block in each modal, add a `Titre_{LANG}` block. In the Update modal include `<?= isset($value['{LANG}_title']) ? $value['{LANG}_title'] : ''; ?>`.

### C4.7. `application/views/settingActualites.php` (2 edits — header + body)
- Add `<th style="text-align: left;">{LANG} Titre</th>` after the PL header `<th>`.
- Add the matching `<td>` row in the foreach body.

### C4.8. `application/views/v1_racourci.php` (2 edits — both arrays)
- `$atlasCategories`: append `{NEW_CAT_BASE}+1`.
- `$pathoCategories`: append `{NEW_CAT_BASE}+3`.

### C4.9. `application/views/v1_bloc_figures.php` (1 edit)
- Append `{NEW_ATLAS_THEME}` to `in_array($idTheme, [16, 27, 34, 42, 46, 50, 54, 58, 62, {NEW_ATLAS_THEME}])`.

### C4.10. `application/views/v1_bloc_figures_atlas.php` (1 edit)
- Append `{NEW_CAT_BASE}+1` to the `IDCategory` `in_array`.

### C4.11. `application/views/v1_header_nav.php` (1 edit)
- Same as C4.10.

### Final view validation
```bash
for f in v1_header_langauge.php header_steppes.php page_category.php page_home.php livreDetails.php actualitesmodals.php settingActualites.php v1_racourci.php v1_bloc_figures.php v1_bloc_figures_atlas.php v1_header_nav.php; do
    php -l "application/views/$f"
done
```

---

## Phase D1 — `setup_{lang}_database.sql`

Generate from the most recent template (e.g. PL) using PHP:

```bash
php -r '
$src = file_get_contents("setup_pl_database.sql");
$out = $src;
// IDs first to avoid double-touching
$out = strtr($out, ["3200" => "{NEW_CAT_BASE}", "3201" => "{NEW_CAT_BASE}+1", "3202" => "{NEW_CAT_BASE}+2", "3203" => "{NEW_CAT_BASE}+3"]);
$out = strtr($out, [
    "Polish (PL)" => "{LangName-English} ({LANG})",
    "Polish" => "{LangName-English}",
    "setup_pl_database" => "setup_{lang}_database",
    "setup_pl_books" => "setup_{lang}_books",
    "_tmp_pl_" => "_tmp_{lang}_",
    "PL_Description" => "{LANG}_Description",
    "PL_title" => "{LANG}_title",
    " AS PL_id" => " AS {LANG}_id",
    "pl_theme_id" => "{lang}_theme_id",
    "m_pl_theme" => "m_{lang}_theme",
    "c_pl_theme" => "c_{lang}_theme",
    "c_pl_livre" => "c_{lang}_livre",
    "PL Categories" => "{LANG} Categories",
    "PL Themes" => "{LANG} Themes",
    "PL Livres" => "{LANG} Livres",
    "PL Chapters" => "{LANG} Chapters",
    "PL Atlas" => "{LANG} Atlas",
    "PL atlas" => "{LANG} atlas",
    "PL livre" => "{LANG} livre",
    "= '\''PL'\''" => "= '\''{LANG}'\''",
    "'\''PL'\''" => "'\''{LANG}'\''",
]);
// Fix the JOIN alias in the stored procedure
$out = str_replace("JOIN `_theme` pl ON pl.LibelleTheme", "JOIN `_theme` {lang} ON {lang}.LibelleTheme", $out);
$out = str_replace("SELECT ft.IDTheme, pl.IDTheme", "SELECT ft.IDTheme, {lang}.IDTheme", $out);
$out = str_replace("AND pl.IDCategory", "AND {lang}.IDCategory", $out);
file_put_contents("setup_{lang}_database.sql", $out);
'
```

Then **manually fix the comment header** to include all previous languages' category IDs (the strtr replaces `3200` everywhere including the IT/DE/PL reference comment):

```sql
-- IT Category IDs: 3000, 3001, 3002, 3003
-- DE Category IDs: 3100, 3101, 3102, 3103
-- PL Category IDs: 3200, 3201, 3202, 3203
-- {LANG} Category IDs: {NEW_CAT_BASE}, ..., {NEW_CAT_BASE}+3 (new)
```

Verify cleanliness: `grep -nE "PL [0-9]|3200|3201|3202|3203|setup_pl|pl\." setup_{lang}_database.sql` should return only the IT/DE/PL/etc reference comment lines.

---

## Phase D2 — `update_{lang}_translations.sql`

Bulk translation file. Fastest path: copy `update_pl_translations.sql`, change all `3200/3201/3202/3203` → `{NEW_CAT_BASE}+0/1/2/3`, change `_tmp_pl_` → `_tmp_{lang}_`, change `pl_title` → `{lang}_title`, then **translate every right-hand value** in the `INSERT IGNORE` statements.

Structure (don't change):
- 4 category UPDATEs
- 4 theme UPDATEs
- `_tmp_{lang}_trans` for ~35 livre titles
- `_tmp_{lang}_chap_trans` for ~500 unique chapter titles
- 4 fallback UPDATEs at the end (for the FR titles with apostrophes that the JOIN misses):
  - `1-Embryologie de l'appareil digestif` → translate
  - `28-Pénineé de la femme` → translate
  - `Etude synthétique des muscles/nerfs` REPLACE patterns
  - `4-Vascularisation et rapports de la moelle spinale` → translate

After running, in the verification SELECT block at the end, make sure the IDs reference `{NEW_CAT_BASE}` to `{NEW_CAT_BASE}+3`.

---

## Phase E — Run + Smoke Test (Local)

```bash
/c/xampp/7.4/mysql/bin/mysql.exe -u root mezidxco_db_local < setup_{lang}_database.sql
/c/xampp/7.4/mysql/bin/mysql.exe -u root mezidxco_db_local < update_{lang}_translations.sql
```

The setup script's last query reports the **actual atlas theme ID assigned** — confirm it matches `{NEW_ATLAS_THEME}` (the value you pre-set in `v1_bloc_figures.php`). If different, edit that file.

Verify chapters: list any chapter still matching a FR title (i.e. untranslated):

```sql
SELECT ch.TitreChapitre, COUNT(*) AS occ
FROM _chapitre ch
JOIN _livre l ON l.IDLivre = ch.IDLivre
JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE t.IDCategory IN ({NEW_CAT_BASE}, {NEW_CAT_BASE}+1, {NEW_CAT_BASE}+2, {NEW_CAT_BASE}+3)
  AND ch.TitreChapitre IN (
      SELECT DISTINCT c2.TitreChapitre
      FROM _chapitre c2
      JOIN _livre l2 ON l2.IDLivre=c2.IDLivre
      JOIN _theme t2 ON t2.IDTheme=l2.IDTheme
      WHERE t2.IDCategory IN (3,4,5,7)
  )
GROUP BY ch.TitreChapitre;
```

Each result row is either: (a) an anatomical term identical between FR and `{LANG}` (correct as-is — e.g. `Patella`, `Thalamus`), or (b) a real untranslated chapter (add an explicit fallback UPDATE in `update_{lang}_translations.sql`).

HTTP smoke test (XAMPP must be running):

```bash
curl -s -o /dev/null -w "%{http_code}\n" "http://localhost/public_html/login/switchLang/{LANG}"
curl -s -o /dev/null -w "%{http_code}\n" "http://localhost/public_html/{LANG}/login"
curl -s -o /dev/null -w "%{http_code}\n" "http://localhost/public_html/{LANG}/category/{Slug-Course}"
# ...repeat for atlas, embryology, pathology slugs
```

`switchLang/{LANG}` returns 307 (redirect — expected); the four others return 200.

---

## Phase F — Server Deployment

```bash
git add -A
git commit -m "Add {LangName-English} ({LANG}) language support"
git push

# On the server:
git pull
bash setup_{lang}_language.sh
mysql -u USER -p DATABASE < setup_{lang}_database.sql
mysql -u USER -p DATABASE < update_{lang}_translations.sql
```

---

## Admin Language Dropdown (added 2026-05)

The admin language switcher in `application/views/header_steppes.php` was refactored from a flat list (which grew taller with every new language) to a Bootstrap collapsible dropdown driven by the `$adminLangs` array. The trigger shows the language icon + the current language's flag emoji; clicking it opens the menu of all platform-supported languages.

To add a language, append one entry to the array (see C4.2). The `foreach` loop auto-renders the menu items.

**Difference vs client (`v1_header_langauge.php`):** the admin dropdown does **not** include the "Autre langue" / globe icon for triggering the Google Translate fallback widget, since admins work only with platform-supported languages.

---

## Quick checklist (TL;DR per new language)

- [ ] Choose `{LANG}`, `{LangName}`, `{Flag}`, slugs, native names. Reserve next `{NEW_CAT_BASE}`, `{NEW_FIRST_INDEX}`, `{NEW_ATLAS_THEME}`.
- [ ] `bash setup_{lang}_language.sh` (Phase A)
- [ ] Copy 5 system lang files
- [ ] Translate `content_lang.php` (Phase B)
- [ ] Update `urls.json` via PHP (Phase C1)
- [ ] Add 3 sets of routes in `routes.php` (Phase C2)
- [ ] 5 spots in `Home.php` (Phase C3)
- [ ] 11 view file edits (Phase C4) — last step is `php -l` validation loop
- [ ] Generate `setup_{lang}_database.sql` (Phase D1) + manual header fix
- [ ] Translate `update_{lang}_translations.sql` (Phase D2)
- [ ] Run both SQL files locally; verify atlas theme ID; re-list French residuals (Phase E)
- [ ] HTTP smoke test the 4 category URLs + login (Phase E)
- [ ] Commit, push, server-side execute (Phase F)

**Last verified:** 2026-05 (Polish addition).
