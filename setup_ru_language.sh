#!/bin/bash
# =============================================================
# Setup Script: Russian (RU) Language Support
# Run this from the project root (public_html/)
# Usage: cd /path/to/public_html && bash setup_ru_language.sh
# =============================================================

set -e

echo "======================================"
echo "  Setting up Russian (RU) Language"
echo "======================================"

# 1. Create RU language directory
echo ""
echo "[1/5] Creating language directory..."
mkdir -p application/language/RU
echo "  -> application/language/RU/ created"

# 2. Create RU cover images directory and copy from ES
echo ""
echo "[2/5] Creating cover images directory..."
mkdir -p assets/couverture_RU

if [ -d "assets/couverture_ES" ]; then
    cp -f assets/couverture_ES/PR_ATLAS_ES.jpg assets/couverture_RU/PR_ATLAS_RU.jpg
    cp -f assets/couverture_ES/PR_COURSES_ES.jpg assets/couverture_RU/PR_COURSES_RU.jpg
    cp -f assets/couverture_ES/PR_EMBR_ES.jpg assets/couverture_RU/PR_EMBR_RU.jpg
    cp -f assets/couverture_ES/PR_PATHO_ES.jpg assets/couverture_RU/PR_PATHO_RU.jpg
    echo "  -> Copied 4 cover images from couverture_ES to couverture_RU"
else
    echo "  -> WARNING: assets/couverture_ES not found!"
    echo "     Please copy cover images manually to assets/couverture_RU/"
fi

# 3. Create RU flag
echo ""
echo "[3/5] Creating flag image..."
mkdir -p assets/img/flags

if [ -f "assets/img/flags/EN.png" ]; then
    cp -f assets/img/flags/EN.png assets/img/flags/RU.png
    echo "  -> Copied flag placeholder from EN.png"
elif [ -f "assets/img/flags/FR.png" ]; then
    cp -f assets/img/flags/FR.png assets/img/flags/RU.png
    echo "  -> Copied flag placeholder from FR.png"
else
    echo "  -> WARNING: No flag source found"
fi

# 4. Set permissions
echo ""
echo "[4/5] Setting file permissions..."
find application/language/RU/ -type f -exec chmod 644 {} \; 2>/dev/null
find application/language/RU/ -type d -exec chmod 755 {} \; 2>/dev/null
find assets/couverture_RU/ -type f -exec chmod 644 {} \; 2>/dev/null
find assets/couverture_RU/ -type d -exec chmod 755 {} \; 2>/dev/null
chmod 644 assets/img/flags/RU.png 2>/dev/null
echo "  -> Permissions set (dirs: 755, files: 644)"

# 5. Verify
echo ""
echo "[5/5] Verification..."
echo ""
echo "--- Language Files ---"
ls -la application/language/RU/ 2>/dev/null || echo "  ERROR: RU language directory missing!"

echo ""
echo "--- Cover Images ---"
ls -la assets/couverture_RU/ 2>/dev/null || echo "  ERROR: couverture_RU directory missing!"

echo ""
echo "--- Flag ---"
ls -la assets/img/flags/RU.png 2>/dev/null || echo "  ERROR: RU flag missing!"

echo ""
echo "======================================"
echo "  ✅ Setup Complete!"
echo "======================================"
echo ""
echo "Checklist of PHP files that must exist in application/language/RU/:"
echo "  [required] content_lang.php (main UI translations)"
echo "  [required] email_lang.php"
echo "  [required] db_lang.php"
echo "  [required] rest_controller_lang.php"
echo "  [required] imglib_lang.php"
echo "  [required] index.html"
echo ""

# Check if all files exist
ALL_OK=true
for f in content_lang.php email_lang.php db_lang.php rest_controller_lang.php imglib_lang.php index.html; do
    if [ -f "application/language/RU/$f" ]; then
        echo "  ✅ $f"
    else
        echo "  ❌ $f - MISSING!"
        ALL_OK=false
    fi
done

echo ""
if [ "$ALL_OK" = true ]; then
    echo "All files present. Russian language is ready!"
else
    echo "Some files are missing. Deploy your code (git pull) and re-run this script."
fi
