#!/usr/bin/env python3
"""
Access Anatomy -- Arabic (AR) database migration.

Run this ONCE when first starting the application after pulling the Arabic
support. It is idempotent: every step checks the current state first, so
re-running it is harmless and is the normal way to repair a partial install.

    python3 tools/setup_ar_language.py --dry-run     # show what would change
    python3 tools/setup_ar_language.py               # apply, using database.php
    python3 tools/setup_ar_language.py --host db.prod.example --user root -p

Connection settings default to application/config/database.php, so on a normal
checkout no flags are needed. Any flag overrides the file (use this for prod).

What it does, in order:
  1. schema    _category.AR_Description, actualites.AR_title,
               _etablissement.AR_Libelle
  2. category  4 rows, IDs 3500-3503
  3. theme     4 rows, one per category (IDs assigned automatically)
  4. livre     clone every French livre into the Arabic themes
  5. chapitre  clone every French chapter into the new Arabic livres
  6. verify    report counts + the atlas theme ID

Step 1 is the one that fixes the "Unknown column" fatals -- Home.php builds
those column names dynamically ($lang . "_Description" in pageCategory(),
$lang . "_Libelle" in signUp()).

Requires a MySQL driver: PyMySQL (pip install pymysql) or mysql-connector-python.
"""

import argparse
import os
import re
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(HERE)
DB_CONFIG = os.path.join(ROOT, "application", "config", "database.php")

# ---------------------------------------------------------------- constants

AR_CATEGORIES = [
    # IDCategory, Libelle,          Couverture,                             Ordre, QSM,  QROC, Resume, Calques, Test
    (3500, "دروس التشريح",  "photos/PRESENTATION/prcours.jpg",        1, 1,    1,    1,    None, None),
    (3501, "أطلس التشريح",  "photos/PRESENTATION/pratlas.jpg",        2, None, None, None, 1,    0),
    (3502, "علم الأجنة",    "photos/PRESENTATION/prem.jpg",           3, 1,    1,    1,    None, 0),
    (3503, "علم الأمراض",   "photos/PRESENTATION_EN/pathologie.png",  4, 1,    1,    1,    None, None),
]

# French source theme -> the Arabic category it clones into.
# (FR: cat 3 -> theme 1, cat 4 -> theme 16, cat 5 -> theme 18, cat 7 -> theme 20)
FR_THEME_TO_AR_CAT = {1: 3500, 16: 3501, 18: 3502, 20: 3503}

AR_THEME_LIBELLE = {
    3500: "دروس التشريح",
    3501: "أطلس التشريح",
    3502: "علم الأجنة",
    3503: "علم الأمراض",
}

# The theme url column mirrors the French one (JA and KO both do this).
FR_THEME_URL = {
    1:  "FR/category/Cours-Anatomie",
    16: "FR/category/Atlas-Anatomie",
    18: "FR/category/Embryologie",
    20: "FR/category/Pathologie-FR",
}

# Hardcoded in application/views/v1_bloc_figures.php -- we verify against it.
EXPECTED_ATLAS_THEME = 74

# Arabic fits in 3-byte utf8, and we match the charset of the columns that
# already work (Libelle, ES_Description). The TR..KO _Description columns were
# created without an explicit charset and so inherited the table's latin1 --
# that is why non-Latin descriptions are mangled for those languages.
UTF8 = "CHARACTER SET utf8 COLLATE utf8_general_ci"


# ------------------------------------------------------------------ helpers

def parse_php_db_config(path):
    """Pull hostname/username/password/database out of CodeIgniter's config."""
    if not os.path.exists(path):
        return {}
    text = open(path, encoding="utf-8", errors="replace").read()
    # Strip comments first: database.php ships a commented-out $db['default']
    # holding the PRODUCTION credentials above the active one. Matching that by
    # accident would point this migration at the wrong server.
    text = re.sub(r"/\*.*?\*/", "", text, flags=re.S)
    text = re.sub(r"(?m)^\s*//.*$", "", text)
    text = re.sub(r"(?m)^\s*#.*$", "", text)
    # only look at the $db['default'] array
    m = re.search(r"\$db\['default'\]\s*=\s*array\((.*?)\n\);", text, re.S)
    block = m.group(1) if m else text
    out = {}
    for key in ("hostname", "username", "password", "database"):
        km = re.search(r"'%s'\s*=>\s*'((?:[^'\\]|\\.)*)'" % key, block)
        if km:
            out[key] = km.group(1).replace("\\'", "'").replace("\\\\", "\\")
    return out


def connect(host, port, user, password, database):
    try:
        import pymysql
        return pymysql.connect(
            host=host, port=port, user=user, password=password, database=database,
            charset="utf8mb4", autocommit=False,
        ), "pymysql"
    except ImportError:
        pass
    try:
        import mysql.connector
        return mysql.connector.connect(
            host=host, port=port, user=user, password=password, database=database,
            charset="utf8mb4", autocommit=False,
        ), "mysql-connector"
    except ImportError:
        pass
    # Last resort: the bundled minimal client, so this script works on a box
    # with no pip and no driver installed (which is the common case on the
    # XAMPP dev machine and on a locked-down production host).
    try:
        sys.path.insert(0, HERE)
        import _minimysql
        return _minimysql.connect(
            host=host, port=port, user=user, password=password, database=database
        ), "bundled _minimysql"
    except ImportError:
        pass
    sys.exit(
        "No MySQL driver found and the bundled fallback is missing.\n"
        "  pip install pymysql            (or)\n"
        "  pip install mysql-connector-python"
    )


class Runner:
    def __init__(self, conn, dry_run):
        self.conn = conn
        self.cur = conn.cursor()
        self.dry = dry_run
        self.changes = []

    def q(self, sql, args=None):
        self.cur.execute(sql, args or ())
        return self.cur.fetchall()

    def one(self, sql, args=None):
        rows = self.q(sql, args)
        return rows[0][0] if rows else None

    def do(self, label, sql, args=None, many=None):
        if self.dry:
            self.changes.append("WOULD " + label)
            return 0
        if many is not None:
            self.cur.executemany(sql, many)
        else:
            self.cur.execute(sql, args or ())
        self.changes.append(label)
        return self.cur.rowcount

    def column_exists(self, table, column):
        return self.one(
            "SELECT COUNT(*) FROM information_schema.COLUMNS "
            "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = %s AND COLUMN_NAME = %s",
            (table, column),
        )


# ------------------------------------------------------------------- steps

def step_schema(r):
    print("\n[1/6] schema")
    verb = "WOULD ADD" if r.dry else "ADDED"
    if r.column_exists("_category", "AR_Description"):
        print("      _category.AR_Description  already present")
    else:
        r.do("add _category.AR_Description",
             "ALTER TABLE `_category` ADD COLUMN `AR_Description` varchar(1000) "
             + UTF8 + " DEFAULT NULL")
        print(f"      _category.AR_Description  {verb}  <-- fixes the 'Unknown column' fatal")

    if r.column_exists("actualites", "AR_title"):
        print("      actualites.AR_title       already present")
    else:
        r.do("add actualites.AR_title",
             "ALTER TABLE `actualites` ADD COLUMN `AR_title` varchar(500) "
             "CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL")
        print(f"      actualites.AR_title       {verb}")

    # signUp() selects `$lang . "_Libelle"` from _etablissement to fill the
    # establishment dropdown. Only FR/EN/ES exist there, so the page is a hard
    # 500 in every language added after Spanish. Backfilled from FR_Libelle:
    # a NULL column would render the whole dropdown blank, and proper names
    # school by school are a translation job, not a schema one.
    if r.column_exists("_etablissement", "AR_Libelle"):
        print("      _etablissement.AR_Libelle already present")
    else:
        r.do("add _etablissement.AR_Libelle",
             "ALTER TABLE `_etablissement` ADD COLUMN `AR_Libelle` varchar(100) "
             + UTF8 + " NOT NULL DEFAULT ''")
        r.do("backfill _etablissement.AR_Libelle from FR_Libelle",
             "UPDATE `_etablissement` SET `AR_Libelle` = `FR_Libelle` "
             "WHERE `AR_Libelle` = ''")
        print(f"      _etablissement.AR_Libelle {verb}  <-- fixes the signUp() fatal")


def step_categories(r):
    print("\n[2/6] categories 3500-3503")
    existing = {row[0] for row in r.q(
        "SELECT IDCategory FROM `_category` WHERE IDCategory BETWEEN 3500 AND 3503")}
    for cid, libelle, couv, ordre, qsm, qroc, resume, calques, test in AR_CATEGORIES:
        if cid in existing:
            print(f"      {cid}  already present")
            continue
        if r.dry:
            print(f"      {cid}  WOULD INSERT  {libelle}")
            continue
        r.do(f"insert category {cid}",
             "INSERT INTO `_category` "
             "(IDCategory, Libelle, EstActifMenu, Couverture, OrdreCat, FR_Description, "
             " EstActifAccueil, EstActifQSM, EstActifQROC, EstActifResume, EstActifCalques, "
             " EstActifTest, multi_lingue, EN_Description, ES_Description, AR_Description) "
             "VALUES (%s,%s,1,%s,%s,'',1,%s,%s,%s,%s,%s,'AR','','','')",
             (cid, libelle, couv, ordre, qsm, qroc, resume, calques, test))
        print(f"      {cid}  INSERTED  {libelle}")


def step_themes(r):
    print("\n[3/6] themes")
    theme_of_cat = {}
    for fr_theme, ar_cat in sorted(FR_THEME_TO_AR_CAT.items()):
        existing = r.one("SELECT IDTheme FROM `_theme` WHERE IDCategory = %s LIMIT 1", (ar_cat,))
        if existing:
            theme_of_cat[ar_cat] = existing
            print(f"      cat {ar_cat} -> theme {existing}  already present")
            continue
        if r.dry:
            print(f"      cat {ar_cat} -> theme (would insert)")
            theme_of_cat[ar_cat] = None
            continue
        r.do(f"insert theme for category {ar_cat}",
             "INSERT INTO `_theme` (LibelleTheme, EstUnLivre, EstActif, IDCategory, OrderTheme, url) "
             "VALUES (%s, 0, 1, %s, 1, %s)",
             (AR_THEME_LIBELLE[ar_cat], ar_cat, FR_THEME_URL[fr_theme]))
        new_id = r.one("SELECT LAST_INSERT_ID()")
        theme_of_cat[ar_cat] = new_id
        print(f"      cat {ar_cat} -> theme {new_id}  INSERTED  {AR_THEME_LIBELLE[ar_cat]}")
    return theme_of_cat


def livre_columns(r):
    """Every _livre column except the auto-increment PK."""
    rows = r.q(
        "SELECT COLUMN_NAME FROM information_schema.COLUMNS "
        "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '_livre' "
        "AND COLUMN_NAME <> 'IDLivre' ORDER BY ORDINAL_POSITION")
    return [x[0] for x in rows]


def chapitre_columns(r):
    rows = r.q(
        "SELECT COLUMN_NAME FROM information_schema.COLUMNS "
        "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '_chapitre' "
        "AND COLUMN_NAME <> 'IDChapitre' ORDER BY ORDINAL_POSITION")
    return [x[0] for x in rows]


def step_livres(r, theme_of_cat):
    print("\n[4/6] livres (clone from French)")
    cols = livre_columns(r)
    idx_theme = cols.index("IDTheme")
    collist = ", ".join(f"`{c}`" for c in cols)
    holders = ", ".join(["%s"] * len(cols))
    mapping = {}          # old IDLivre -> new IDLivre

    for fr_theme, ar_cat in sorted(FR_THEME_TO_AR_CAT.items()):
        ar_theme = theme_of_cat.get(ar_cat)
        if ar_theme is None:
            n = r.one("SELECT COUNT(*) FROM `_livre` WHERE IDTheme = %s", (fr_theme,))
            c = r.one("SELECT COUNT(*) FROM `_chapitre` ch JOIN `_livre` l "
                      "ON l.IDLivre = ch.IDLivre WHERE l.IDTheme = %s", (fr_theme,))
            print(f"      FR theme {fr_theme}: would clone {n} livres / {c} chapitres")
            continue
        have = r.one("SELECT COUNT(*) FROM `_livre` WHERE IDTheme = %s", (ar_theme,))
        src = r.q(f"SELECT `IDLivre`, {collist} FROM `_livre` WHERE IDTheme = %s ORDER BY IDLivre",
                  (fr_theme,))
        if have:
            print(f"      FR theme {fr_theme} -> AR theme {ar_theme}: {have} already there, skipped")
            # still need the mapping for the chapter step
            for row in src:
                new_id = r.one("SELECT IDLivre FROM `_livre` WHERE IDTheme = %s AND Titre = %s LIMIT 1",
                               (ar_theme, row[1 + cols.index("Titre")]))
                if new_id:
                    mapping[row[0]] = new_id
            continue
        if r.dry:
            print(f"      FR theme {fr_theme} -> AR theme {ar_theme}: would clone {len(src)} livres")
            continue
        for row in src:
            vals = list(row[1:])
            vals[idx_theme] = ar_theme
            r.cur.execute(f"INSERT INTO `_livre` ({collist}) VALUES ({holders})", vals)
            mapping[row[0]] = r.one("SELECT LAST_INSERT_ID()")
        r.changes.append(f"clone {len(src)} livres into theme {ar_theme}")
        print(f"      FR theme {fr_theme} -> AR theme {ar_theme}: cloned {len(src)} livres")
    return mapping


def step_chapitres(r, livre_map):
    print("\n[5/6] chapitres (clone from French)")
    if not livre_map:
        print("      nothing to do")
        return
    cols = chapitre_columns(r)
    idx_livre = cols.index("IDLivre")
    collist = ", ".join(f"`{c}`" for c in cols)
    holders = ", ".join(["%s"] * len(cols))
    total = 0
    for old_livre, new_livre in sorted(livre_map.items()):
        have = r.one("SELECT COUNT(*) FROM `_chapitre` WHERE IDLivre = %s", (new_livre,))
        if have:
            continue
        src = r.q(f"SELECT {collist} FROM `_chapitre` WHERE IDLivre = %s ORDER BY NumOrdre",
                  (old_livre,))
        if not src:
            continue
        if r.dry:
            total += len(src)
            continue
        batch = []
        for row in src:
            vals = list(row)
            vals[idx_livre] = new_livre
            batch.append(vals)
        r.cur.executemany(f"INSERT INTO `_chapitre` ({collist}) VALUES ({holders})", batch)
        total += len(batch)
    r.changes.append(f"clone {total} chapitres")
    print(f"      {'would clone' if r.dry else 'cloned'} {total} chapitres")


def step_verify(r):
    print("\n[6/6] verification")
    cats = r.q("SELECT IDCategory, Libelle, multi_lingue FROM `_category` "
               "WHERE IDCategory BETWEEN 3500 AND 3503 ORDER BY IDCategory")
    for cid, lib, ml in cats:
        print(f"      category {cid}  {ml}  {lib}")
    themes = r.q("SELECT IDTheme, IDCategory, LibelleTheme FROM `_theme` "
                 "WHERE IDCategory BETWEEN 3500 AND 3503 ORDER BY IDCategory")
    for tid, cid, lib in themes:
        print(f"      theme    {tid}  cat {cid}  {lib}")
    nl = r.one("SELECT COUNT(*) FROM `_livre` l JOIN `_theme` t ON t.IDTheme = l.IDTheme "
               "WHERE t.IDCategory BETWEEN 3500 AND 3503")
    nc = r.one("SELECT COUNT(*) FROM `_chapitre` c JOIN `_livre` l ON l.IDLivre = c.IDLivre "
               "JOIN `_theme` t ON t.IDTheme = l.IDTheme WHERE t.IDCategory BETWEEN 3500 AND 3503")
    print(f"      livres: {nl}    chapitres: {nc}")

    atlas = r.one("SELECT IDTheme FROM `_theme` WHERE IDCategory = 3501 LIMIT 1")
    if atlas is None:
        print("      atlas theme: not created yet")
    elif atlas == EXPECTED_ATLAS_THEME:
        print(f"      atlas theme {atlas} matches v1_bloc_figures.php")
    else:
        print(f"      !! atlas theme is {atlas}, but application/views/v1_bloc_figures.php")
        print(f"      !! hardcodes {EXPECTED_ATLAS_THEME}. Edit that in_array to use {atlas},")
        print(f"      !! or the Atlas figure blocks will not render for Arabic.")


# -------------------------------------------------------------------- main

def main():
    cfg = parse_php_db_config(DB_CONFIG)
    p = argparse.ArgumentParser(description="Install Arabic (AR) support in the database.")
    p.add_argument("--host", default=cfg.get("hostname", "127.0.0.1"))
    p.add_argument("--port", type=int, default=3306)
    p.add_argument("--user", default=cfg.get("username", "root"))
    p.add_argument("--password", default=cfg.get("password", ""))
    p.add_argument("--database", default=cfg.get("database", ""))
    p.add_argument("-p", "--prompt-password", action="store_true",
                   help="prompt for the password instead of reading database.php")
    p.add_argument("--dry-run", action="store_true", help="show changes without applying them")
    args = p.parse_args()

    if args.prompt_password:
        import getpass
        args.password = getpass.getpass("MySQL password: ")
    if not args.database:
        sys.exit("No database name: pass --database (could not read database.php)")

    print(f"Access Anatomy -- Arabic (AR) migration")
    print(f"  {args.user}@{args.host}:{args.port}/{args.database}"
          + ("   [DRY RUN -- nothing will be written]" if args.dry_run else ""))

    conn, driver = connect(args.host, args.port, args.user, args.password, args.database)
    print(f"  driver: {driver}")
    r = Runner(conn, args.dry_run)
    try:
        step_schema(r)
        step_categories(r)
        themes = step_themes(r)
        livre_map = step_livres(r, themes)
        step_chapitres(r, livre_map)
        if args.dry_run:
            conn.rollback()
        else:
            conn.commit()
        step_verify(r)
    except Exception:
        conn.rollback()
        print("\nFAILED -- rolled back, database unchanged.", file=sys.stderr)
        raise
    finally:
        conn.close()

    print("\n" + ("Dry run complete. Re-run without --dry-run to apply."
                  if args.dry_run else "Done. Arabic is installed."))
    print("Next: the livre and chapter titles are still French -- they are clones.")
    print("      Translate them with an UPDATE pass over categories 3500-3503.")


if __name__ == "__main__":
    main()
