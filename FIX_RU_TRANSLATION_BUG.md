# Fix: Russian Translations Overwriting English Chapters on Server

## Problem Summary

Screenshot (2026-04-15) showed EN **Pathology** dropdown containing `1-Общая анатомия` (Russian: "General Anatomy") mixed with English chapter titles. This happens because the legacy script `update_ru_translations.sql` used **hardcoded AUTO_INCREMENT primary keys** (e.g. `WHERE IDLivre = 135`, `WHERE IDChapitre = 1346`) that matched Russian rows on the local dev DB but matched **English / Spanish rows** on the production DB.

**Scope of damage:**
- Only the Russian deploy was affected. `update_tr_translations.sql` and `update_pt_translations.sql` use safe title-matching and did not corrupt data.
- Corrupted tables: `_livre`, `_chapitre` — some EN/ES rows now hold Russian text.

**Files to keep / discard:**

| File | Status | Action |
|------|--------|--------|
| `update_ru_translations.sql` | BROKEN — hardcoded IDs | Delete or rename to `.broken` |
| `update_ru_translations_server.sql` | SAFE — title-matching scoped by `IDCategory IN (2700..2703)` | Use this |
| `setup_ru_database.sql` | SAFE — fixed IDs 2700–2703 for new RU categories | Use this |
| `server_cleanup.sql` | SAFE — deletes RU/TR/PT rows in categories 2700–2903 | Use this |
| `perfect_deploy_ru.sql` | SAFE — monolithic cleanup + rebuild + translate | Optional alternative |
| `setup_*_language.sh` | SAFE — only copies files, no DB writes | Not the cause |

---

## Step 1 — Connect to the Server and Take a Backup

```bash
ssh ubuntu@vps-19860d4f
cd /var/www/access-anatomy/public_html
```

Dump the current DB **before touching anything**:

```bash
# Replace USER / DATABASE with real values
mysqldump -u USER -p DATABASE > /tmp/backup_before_fix_$(date +%Y%m%d_%H%M%S).sql
ls -lh /tmp/backup_before_fix_*.sql
```

Keep this dump. If a step goes wrong you can restore with:

```bash
mysql -u USER -p DATABASE < /tmp/backup_before_fix_YYYYMMDD_HHMMSS.sql
```

---

## Step 2 — Identify the Corrupted Non-RU Rows

Log into MySQL:

```bash
mysql -u USER -p DATABASE
```

Run these diagnostic queries and save the output:

```sql
-- Books whose title contains Cyrillic but are NOT in RU categories
SELECT l.IDLivre, l.Titre, t.IDCategory, c.Libelle AS category_name, c.multi_lingue
FROM _livre l
JOIN _theme t ON t.IDTheme = l.IDTheme
JOIN _category c ON c.IDCategory = t.IDCategory
WHERE l.Titre REGEXP '[А-Яа-я]'
  AND t.IDCategory NOT IN (2700, 2701, 2702, 2703);

-- Chapters whose title contains Cyrillic but are NOT in RU categories
SELECT ch.IDChapitre, ch.TitreChapitre, l.IDLivre, l.Titre AS livre_title,
       t.IDCategory, c.multi_lingue
FROM _chapitre ch
JOIN _livre l   ON l.IDLivre = ch.IDLivre
JOIN _theme t   ON t.IDTheme = l.IDTheme
JOIN _category c ON c.IDCategory = t.IDCategory
WHERE ch.TitreChapitre REGEXP '[А-Яа-я]'
  AND t.IDCategory NOT IN (2700, 2701, 2702, 2703);
```

Every row returned is a corrupted **English / Spanish / French** record whose original title was overwritten with Russian.

Export the list to a file for reference:

```bash
mysql -u USER -p DATABASE -e "
SELECT l.IDLivre, l.Titre, t.IDCategory
FROM _livre l JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE l.Titre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);
" > /tmp/corrupted_livres.tsv

mysql -u USER -p DATABASE -e "
SELECT ch.IDChapitre, ch.TitreChapitre, ch.IDLivre
FROM _chapitre ch
JOIN _livre l ON l.IDLivre = ch.IDLivre
JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE ch.TitreChapitre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);
" > /tmp/corrupted_chapitres.tsv
```

---

## Step 3 — Restore the Corrupted Non-RU Titles

Pick **one** of the two options below based on what you have available.

### Option A — Restore from an older backup (PREFERRED)

If you have any DB dump taken **before** `update_ru_translations.sql` was run on the server:

```bash
# 1. Extract only the _livre and _chapitre tables from the old backup
mysqldump -u USER -p --no-create-info DATABASE _livre _chapitre \
    --where="1" < /path/to/old_backup.sql > /tmp/old_livre_chapitre.sql

# Easier: restore the whole DB into a TEMP database, then copy rows back
mysql -u USER -p -e "CREATE DATABASE DATABASE_tmp"
mysql -u USER -p DATABASE_tmp < /path/to/old_backup.sql
```

Then copy the clean titles row-by-row back into production, scoped to the corrupted IDs:

```sql
-- For each corrupted IDLivre X, Y, Z that you found in Step 2:
UPDATE DATABASE._livre dst
JOIN DATABASE_tmp._livre src ON src.IDLivre = dst.IDLivre
SET dst.Titre = src.Titre
WHERE dst.IDLivre IN (X, Y, Z, ...);

UPDATE DATABASE._chapitre dst
JOIN DATABASE_tmp._chapitre src ON src.IDChapitre = dst.IDChapitre
SET dst.TitreChapitre = src.TitreChapitre
WHERE dst.IDChapitre IN (A, B, C, ...);
```

Drop the temp DB when done:

```bash
mysql -u USER -p -e "DROP DATABASE DATABASE_tmp"
```

### Option B — Restore from the local dev DB

Your XAMPP DB still has the correct EN/ES titles (the bug only hit the server). Export just the non-RU rows:

On your **Windows machine** (XAMPP):

```bash
cd /c/xampp/7.4/htdocs/public_html
# Export the two tables (full, no RU filtering needed — local is clean)
mysqldump -u root -p --no-create-info --skip-triggers \
    YOUR_LOCAL_DB _livre _chapitre > local_livre_chapitre.sql

# Upload to the server
scp local_livre_chapitre.sql ubuntu@vps-19860d4f:/tmp/
```

On the server, import into a temp DB, then repair:

```bash
mysql -u USER -p -e "CREATE DATABASE repair_tmp"
mysql -u USER -p repair_tmp -e "
  CREATE TABLE _livre    LIKE PRODUCTION_DB._livre;
  CREATE TABLE _chapitre LIKE PRODUCTION_DB._chapitre;"
mysql -u USER -p repair_tmp < /tmp/local_livre_chapitre.sql
```

Run the repair JOIN (only fixes rows currently holding Cyrillic in non-RU categories):

```sql
UPDATE PRODUCTION_DB._livre dst
JOIN repair_tmp._livre src ON src.IDLivre = dst.IDLivre
JOIN PRODUCTION_DB._theme t ON t.IDTheme = dst.IDTheme
SET dst.Titre = src.Titre
WHERE dst.Titre REGEXP '[А-Яа-я]'
  AND t.IDCategory NOT IN (2700, 2701, 2702, 2703);

UPDATE PRODUCTION_DB._chapitre dst
JOIN repair_tmp._chapitre src ON src.IDChapitre = dst.IDChapitre
JOIN PRODUCTION_DB._livre l   ON l.IDLivre = dst.IDLivre
JOIN PRODUCTION_DB._theme t   ON t.IDTheme = l.IDTheme
SET dst.TitreChapitre = src.TitreChapitre
WHERE dst.TitreChapitre REGEXP '[А-Яа-я]'
  AND t.IDCategory NOT IN (2700, 2701, 2702, 2703);
```

Drop the temp DB:

```bash
mysql -u USER -p -e "DROP DATABASE repair_tmp"
```

### Verify repair

Re-run the diagnostic from Step 2 — both queries should now return **0 rows**:

```sql
SELECT COUNT(*) AS still_corrupted FROM _livre l
JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE l.Titre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);

SELECT COUNT(*) AS still_corrupted FROM _chapitre ch
JOIN _livre l ON l.IDLivre = ch.IDLivre
JOIN _theme t ON t.IDTheme = l.IDTheme
WHERE ch.TitreChapitre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);
```

---

## Step 4 — Wipe Any Partial RU Data on the Server

```bash
cd /var/www/access-anatomy/public_html
mysql -u USER -p DATABASE < server_cleanup.sql
```

This deletes all rows in `_category` / `_theme` / `_livre` / `_chapitre` belonging to categories 2700–2703 (and also 2800–2803 TR and 2900–2903 PT, which is harmless because the safe scripts will recreate them).

---

## Step 5 — Rebuild RU Structure (SAFE)

```bash
mysql -u USER -p DATABASE < setup_ru_database.sql
```

This creates categories 2700–2703, themes, books, and chapters using **fixed IDs for categories** (2700–2703) and **AUTO_INCREMENT for books/chapters** — but because the books/chapters are created with `INSERT ... SELECT` from the FR source inside a stored procedure, the new IDs are only referenced via title + category scope afterwards. No ID collision possible.

---

## Step 6 — Apply Russian Translations (SAFE script)

```bash
mysql -u USER -p DATABASE < update_ru_translations_server.sql
```

This is the fixed script. It uses:

```sql
UPDATE `_livre` l
  JOIN `_theme` t ON t.IDTheme = l.IDTheme
  JOIN _tmp_ru_trans m ON m.fr_title = l.Titre
  SET l.Titre = m.ru_title
  WHERE t.IDCategory IN (2700, 2701, 2702, 2703);   -- scoped → safe
```

Only rows inside RU categories are touched, regardless of their auto-generated IDs.

---

## Step 7 — Also Rebuild TR and PT (optional, for consistency)

If TR / PT deploys are also incomplete:

```bash
mysql -u USER -p DATABASE < setup_tr_database.sql
mysql -u USER -p DATABASE < update_tr_translations.sql

mysql -u USER -p DATABASE < setup_pt_database.sql
mysql -u USER -p DATABASE < update_pt_translations.sql
```

These are already safe (title-matching, scoped by `IDCategory`).

---

## Step 8 — Verify Everything in the Browser

- Open the site, switch to **English** → Pathology dropdown: all entries must be English.
- Switch to **Spanish** → all entries Spanish.
- Switch to **French** → all entries French.
- Switch to **Russian** → all entries Cyrillic.
- Switch to **Turkish** and **Portuguese** → same language purity test.

Run the diagnostic queries from Step 2 one more time — both should return `0`.

---

## Step 9 — Prevent the Bug from Ever Coming Back

On your dev machine:

```bash
cd /c/xampp/7.4/htdocs/public_html
# Rename the broken script so it cannot be run again by mistake
mv update_ru_translations.sql update_ru_translations.sql.BROKEN_DO_NOT_RUN
git add -A
git commit -m "mark legacy RU translation script as broken (hardcoded IDs corrupted EN rows on server)"
```

### Rule for future language deploys

Never write cross-environment scripts like:

```sql
-- BAD — auto-increment IDs are not portable
UPDATE _livre SET Titre = '...' WHERE IDLivre = 135;
```

Always use **stable keys** and **category scope**:

```sql
-- GOOD — scoped + portable
UPDATE _livre l
JOIN _theme t ON t.IDTheme = l.IDTheme
JOIN _tmp_trans m ON m.fr_title = l.Titre
SET l.Titre = m.xx_title
WHERE t.IDCategory IN (28xx, 28xx, 28xx, 28xx);
```

---

## Quick Reference — Full Command Sequence (copy/paste)

Assuming you already did Step 3 repair successfully:

```bash
ssh ubuntu@vps-19860d4f
cd /var/www/access-anatomy/public_html

# Safety backup
mysqldump -u USER -p DATABASE > /tmp/backup_$(date +%Y%m%d_%H%M%S).sql

# Wipe partial language data
mysql -u USER -p DATABASE < server_cleanup.sql

# Rebuild RU
mysql -u USER -p DATABASE < setup_ru_database.sql
mysql -u USER -p DATABASE < update_ru_translations_server.sql

# (optional) Rebuild TR and PT
mysql -u USER -p DATABASE < setup_tr_database.sql
mysql -u USER -p DATABASE < update_tr_translations.sql
mysql -u USER -p DATABASE < setup_pt_database.sql
mysql -u USER -p DATABASE < update_pt_translations.sql

# Verify
mysql -u USER -p DATABASE -e "
SELECT COUNT(*) AS corrupted_livres FROM _livre l
  JOIN _theme t ON t.IDTheme=l.IDTheme
  WHERE l.Titre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);
SELECT COUNT(*) AS corrupted_chapitres FROM _chapitre ch
  JOIN _livre l ON l.IDLivre=ch.IDLivre
  JOIN _theme t ON t.IDTheme=l.IDTheme
  WHERE ch.TitreChapitre REGEXP '[А-Яа-я]' AND t.IDCategory NOT IN (2700,2701,2702,2703);
"
```

Both counts must be `0`. If not, repeat Step 3 until they are.
