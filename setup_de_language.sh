#!/bin/bash
# =============================================================
# Setup Script: German (DE) Language Support
# Run this from the project root (public_html/)
# Usage: cd /path/to/public_html && bash setup_de_language.sh
# =============================================================

set -e

echo "======================================"
echo "  Setting up German (DE) Language"
echo "======================================"

# 1. Create DE language directory
echo ""
echo "[1/5] Creating language directory..."
mkdir -p application/language/DE
echo "  -> application/language/DE/ created"

# 2. Create DE cover images directory and copy from ES
echo ""
echo "[2/5] Creating cover images directory..."
mkdir -p assets/couverture_DE

if [ -d "assets/couverture_ES" ]; then
    cp -f assets/couverture_ES/PR_ATLAS_ES.jpg assets/couverture_DE/PR_ATLAS_DE.jpg
    cp -f assets/couverture_ES/PR_COURSES_ES.jpg assets/couverture_DE/PR_COURSES_DE.jpg
    cp -f assets/couverture_ES/PR_EMBR_ES.jpg assets/couverture_DE/PR_EMBR_DE.jpg
    cp -f assets/couverture_ES/PR_PATHO_ES.jpg assets/couverture_DE/PR_PATHO_DE.jpg
    echo "  -> Copied 4 cover images from couverture_ES to couverture_DE"
else
    echo "  -> WARNING: assets/couverture_ES not found!"
fi

# 3. Create DE flag
echo ""
echo "[3/5] Creating flag image..."
mkdir -p assets/img/flags

if [ -f "assets/img/flags/EN.png" ]; then
    cp -f assets/img/flags/EN.png assets/img/flags/DE.png
    echo "  -> Copied flag placeholder from EN.png"
fi

# 4. Set permissions
echo ""
echo "[4/5] Setting file permissions..."
find application/language/DE/ -type f -exec chmod 644 {} \; 2>/dev/null
find application/language/DE/ -type d -exec chmod 755 {} \; 2>/dev/null
find assets/couverture_DE/ -type f -exec chmod 644 {} \; 2>/dev/null
find assets/couverture_DE/ -type d -exec chmod 755 {} \; 2>/dev/null
chmod 644 assets/img/flags/DE.png 2>/dev/null
echo "  -> Permissions set"

# 5. Verify
echo ""
echo "[5/5] Verification..."
ALL_OK=true
for f in content_lang.php email_lang.php db_lang.php rest_controller_lang.php imglib_lang.php index.html; do
    if [ -f "application/language/DE/$f" ]; then
        echo "  [OK] $f"
    else
        echo "  [MISSING] $f"
        ALL_OK=false
    fi
done

echo ""
if [ "$ALL_OK" = true ]; then
    echo "All files present. German language is ready!"
else
    echo "Some files are missing. Deploy your code (git pull) and re-run this script."
fi
