#!/bin/bash
# =============================================================
# Setup Script: Korean (KO) Language Support
# Run from project root (public_html/)
# =============================================================

set -e

echo "======================================"
echo "  Setting up Korean (KO) Language"
echo "======================================"

echo ""
echo "[1/5] Creating language directory..."
mkdir -p application/language/KO

echo ""
echo "[2/5] Creating cover images directory..."
mkdir -p assets/couverture_KO

if [ -d "assets/couverture_ES" ]; then
    cp -f assets/couverture_ES/PR_ATLAS_ES.jpg assets/couverture_KO/PR_ATLAS_KO.jpg
    cp -f assets/couverture_ES/PR_COURSES_ES.jpg assets/couverture_KO/PR_COURSES_KO.jpg
    cp -f assets/couverture_ES/PR_EMBR_ES.jpg assets/couverture_KO/PR_EMBR_KO.jpg
    cp -f assets/couverture_ES/PR_PATHO_ES.jpg assets/couverture_KO/PR_PATHO_KO.jpg
fi

echo ""
echo "[3/5] Creating flag image..."
mkdir -p assets/img/flags
[ -f "assets/img/flags/EN.png" ] && cp -f assets/img/flags/EN.png assets/img/flags/KO.png

echo ""
echo "[4/5] Setting file permissions..."
find application/language/KO/ -type f -exec chmod 644 {} \; 2>/dev/null
find application/language/KO/ -type d -exec chmod 755 {} \; 2>/dev/null
find assets/couverture_KO/ -type f -exec chmod 644 {} \; 2>/dev/null
find assets/couverture_KO/ -type d -exec chmod 755 {} \; 2>/dev/null
chmod 644 assets/img/flags/KO.png 2>/dev/null

echo ""
echo "[5/5] Verification..."
ALL_OK=true
for f in content_lang.php email_lang.php db_lang.php rest_controller_lang.php imglib_lang.php index.html; do
    if [ -f "application/language/KO/$f" ]; then echo "  [OK] $f"; else echo "  [MISSING] $f"; ALL_OK=false; fi
done
[ "$ALL_OK" = true ] && echo "Korean language is ready!" || echo "Some files missing — re-run after deploy."
