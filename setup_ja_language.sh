#!/bin/bash
# =============================================================
# Setup Script: Japanese (JA) Language Support
# Run from project root (public_html/)
# Usage: cd /path/to/public_html && bash setup_ja_language.sh
# =============================================================

set -e

echo "======================================"
echo "  Setting up Japanese (JA) Language"
echo "======================================"

echo ""
echo "[1/5] Creating language directory..."
mkdir -p application/language/JA
echo "  -> application/language/JA/ created"

echo ""
echo "[2/5] Creating cover images directory..."
mkdir -p assets/couverture_JA

if [ -d "assets/couverture_ES" ]; then
    cp -f assets/couverture_ES/PR_ATLAS_ES.jpg assets/couverture_JA/PR_ATLAS_JA.jpg
    cp -f assets/couverture_ES/PR_COURSES_ES.jpg assets/couverture_JA/PR_COURSES_JA.jpg
    cp -f assets/couverture_ES/PR_EMBR_ES.jpg assets/couverture_JA/PR_EMBR_JA.jpg
    cp -f assets/couverture_ES/PR_PATHO_ES.jpg assets/couverture_JA/PR_PATHO_JA.jpg
    echo "  -> Copied 4 cover images from couverture_ES to couverture_JA"
else
    echo "  -> WARNING: assets/couverture_ES not found!"
fi

echo ""
echo "[3/5] Creating flag image..."
mkdir -p assets/img/flags

if [ -f "assets/img/flags/EN.png" ]; then
    cp -f assets/img/flags/EN.png assets/img/flags/JA.png
    echo "  -> Copied flag placeholder from EN.png"
fi

echo ""
echo "[4/5] Setting file permissions..."
find application/language/JA/ -type f -exec chmod 644 {} \; 2>/dev/null
find application/language/JA/ -type d -exec chmod 755 {} \; 2>/dev/null
find assets/couverture_JA/ -type f -exec chmod 644 {} \; 2>/dev/null
find assets/couverture_JA/ -type d -exec chmod 755 {} \; 2>/dev/null
chmod 644 assets/img/flags/JA.png 2>/dev/null
echo "  -> Permissions set"

echo ""
echo "[5/5] Verification..."
ALL_OK=true
for f in content_lang.php email_lang.php db_lang.php rest_controller_lang.php imglib_lang.php index.html; do
    if [ -f "application/language/JA/$f" ]; then
        echo "  [OK] $f"
    else
        echo "  [MISSING] $f"
        ALL_OK=false
    fi
done

echo ""
if [ "$ALL_OK" = true ]; then
    echo "All files present. Japanese language is ready!"
else
    echo "Some files are missing. Deploy your code (git pull) and re-run this script."
fi
