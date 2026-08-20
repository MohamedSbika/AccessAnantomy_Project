#!/bin/bash
# =============================================================
# Setup Script: Arabic (AR) Language Support
# Run from project root (public_html/)
# =============================================================

set -e

echo "======================================"
echo "  Setting up Arabic (AR) Language"
echo "======================================"

echo ""
echo "[1/5] Creating language directory..."
mkdir -p application/language/AR

echo ""
echo "[2/5] Creating cover images directory..."
mkdir -p assets/couverture_AR

if [ -d "assets/couverture_ES" ]; then
    cp -f assets/couverture_ES/PR_ATLAS_ES.jpg assets/couverture_AR/PR_ATLAS_AR.jpg
    cp -f assets/couverture_ES/PR_COURSES_ES.jpg assets/couverture_AR/PR_COURSES_AR.jpg
    cp -f assets/couverture_ES/PR_EMBR_ES.jpg assets/couverture_AR/PR_EMBR_AR.jpg
    cp -f assets/couverture_ES/PR_PATHO_ES.jpg assets/couverture_AR/PR_PATHO_AR.jpg
fi

echo ""
echo "[3/5] Creating flag image..."
mkdir -p assets/img/flags
[ -f "assets/img/flags/EN.png" ] && cp -f assets/img/flags/EN.png assets/img/flags/AR.png

echo ""
echo "[4/5] Setting file permissions..."
find application/language/AR/ -type f -exec chmod 644 {} \; 2>/dev/null
find application/language/AR/ -type d -exec chmod 755 {} \; 2>/dev/null
find assets/couverture_AR/ -type f -exec chmod 644 {} \; 2>/dev/null
find assets/couverture_AR/ -type d -exec chmod 755 {} \; 2>/dev/null
chmod 644 assets/img/flags/AR.png 2>/dev/null

echo ""
echo "[5/5] Verification..."
ALL_OK=true
for f in content_lang.php email_lang.php db_lang.php rest_controller_lang.php imglib_lang.php index.html; do
    if [ -f "application/language/AR/$f" ]; then echo "  [OK] $f"; else echo "  [MISSING] $f"; ALL_OK=false; fi
done
[ "$ALL_OK" = true ] && echo "Arabic language is ready!" || echo "Some files missing — re-run after deploy."
