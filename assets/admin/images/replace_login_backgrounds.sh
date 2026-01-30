#!/bin/bash

# FlowMkt Login Background Replacement Script
# This script helps replace the old admin login backgrounds with new FlowMkt branding

set -e  # Exit on error

ADMIN_IMG_DIR="assets/admin/images"

echo "=========================================="
echo "FlowMkt Login Background Replacement"
echo "=========================================="
echo ""

# Function to check if file exists
check_file() {
    if [ -f "$1" ]; then
        size=$(du -h "$1" | cut -f1)
        echo "✓ Found: $1 ($size)"
        return 0
    else
        echo "✗ Missing: $1"
        return 1
    fi
}

# Function to set file permissions
set_permissions() {
    if [ -f "$1" ]; then
        chmod 644 "$1"
        echo "✓ Set permissions 644 on: $1"
    fi
}

# Function to backup existing files
backup_file() {
    if [ -f "$1" ]; then
        backup_name="${1}.backup.$(date +%Y%m%d_%H%M%S)"
        cp "$1" "$backup_name"
        echo "✓ Backed up: $1 → $backup_name"
    fi
}

# Function to check file size
check_file_size() {
    if [ -f "$1" ]; then
        size_bytes=$(stat -f%z "$1" 2>/dev/null || stat -c%s "$1" 2>/dev/null)
        size_kb=$((size_bytes / 1024))
        
        if [ $size_kb -gt 500 ]; then
            echo "⚠ Warning: $1 is ${size_kb}KB (recommended: under 500KB)"
            echo "  Consider optimizing with TinyPNG or Squoosh"
            return 1
        else
            echo "✓ File size OK: $1 (${size_kb}KB)"
            return 0
        fi
    fi
}

echo "Step 1: Checking current login background files..."
echo "----------------------------------------"

# Change to project root
cd "$(dirname "$0")/../../.." || exit 1

check_file "$ADMIN_IMG_DIR/login-bg.png"
BG_EXISTS=$?

check_file "$ADMIN_IMG_DIR/login-dark.png"
BG_DARK_EXISTS=$?

echo ""
echo "Step 2: Checking for new FlowMkt background files..."
echo "----------------------------------------"

# Check if new background files are ready
NEW_BG="$ADMIN_IMG_DIR/login-bg.new.png"
NEW_BG_DARK="$ADMIN_IMG_DIR/login-dark.new.png"

NEW_FILES_READY=true

if [ ! -f "$NEW_BG" ]; then
    echo "✗ New light background not found: $NEW_BG"
    echo "  Please create login-bg.new.png with your new FlowMkt background"
    NEW_FILES_READY=false
fi

if [ ! -f "$NEW_BG_DARK" ]; then
    echo "✗ New dark background not found: $NEW_BG_DARK"
    echo "  Please create login-dark.new.png with your new FlowMkt background"
    NEW_FILES_READY=false
fi

if [ "$NEW_FILES_READY" = false ]; then
    echo ""
    echo "=========================================="
    echo "INSTRUCTIONS:"
    echo "=========================================="
    echo "1. Generate your FlowMkt backgrounds using the prompts in LOGIN_BACKGROUNDS_GUIDE.md"
    echo "2. Save them with .new.png extension in $ADMIN_IMG_DIR:"
    echo "   - login-bg.new.png (1920x1080px, light theme)"
    echo "   - login-dark.new.png (1920x1080px, dark theme)"
    echo "3. Optimize images to under 500KB using TinyPNG or Squoosh"
    echo "4. Run this script again to replace the old backgrounds"
    echo ""
    exit 1
fi

echo "✓ All new background files found!"
echo ""

# Check file sizes
echo "Step 3: Checking file sizes..."
echo "----------------------------------------"

check_file_size "$NEW_BG"
check_file_size "$NEW_BG_DARK"

echo ""

# Verify image dimensions (requires ImageMagick)
if command -v identify &> /dev/null; then
    echo "Step 4: Verifying image dimensions..."
    echo "----------------------------------------"
    
    BG_SIZE=$(identify -format "%wx%h" "$NEW_BG" 2>/dev/null || echo "unknown")
    BG_DARK_SIZE=$(identify -format "%wx%h" "$NEW_BG_DARK" 2>/dev/null || echo "unknown")
    
    echo "login-bg.new.png: $BG_SIZE (recommended: 1920x1080 or larger)"
    echo "login-dark.new.png: $BG_DARK_SIZE (recommended: 1920x1080 or larger)"
    
    # Check if dimensions are adequate
    if [[ $BG_SIZE =~ ^([0-9]+)x([0-9]+)$ ]]; then
        width=${BASH_REMATCH[1]}
        height=${BASH_REMATCH[2]}
        if [ $width -lt 1920 ] || [ $height -lt 1080 ]; then
            echo "⚠ Warning: login-bg.new.png is smaller than recommended (1920x1080)"
        fi
    fi
    
    if [[ $BG_DARK_SIZE =~ ^([0-9]+)x([0-9]+)$ ]]; then
        width=${BASH_REMATCH[1]}
        height=${BASH_REMATCH[2]}
        if [ $width -lt 1920 ] || [ $height -lt 1080 ]; then
            echo "⚠ Warning: login-dark.new.png is smaller than recommended (1920x1080)"
        fi
    fi
    
    echo ""
else
    echo "Step 4: Skipping dimension verification (ImageMagick not installed)"
    echo "----------------------------------------"
    echo "Install ImageMagick to verify image dimensions: brew install imagemagick"
    echo ""
fi

# Ask for confirmation
echo "Step 5: Ready to replace login backgrounds"
echo "----------------------------------------"
echo "This will:"
echo "  1. Backup existing background files"
echo "  2. Replace them with new FlowMkt backgrounds"
echo "  3. Set correct file permissions (644)"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Cancelled by user."
    exit 0
fi

echo ""
echo "Step 6: Backing up existing files..."
echo "----------------------------------------"

backup_file "$ADMIN_IMG_DIR/login-bg.png"
backup_file "$ADMIN_IMG_DIR/login-dark.png"

echo ""
echo "Step 7: Replacing background files..."
echo "----------------------------------------"

cp "$NEW_BG" "$ADMIN_IMG_DIR/login-bg.png"
echo "✓ Replaced: login-bg.png"

cp "$NEW_BG_DARK" "$ADMIN_IMG_DIR/login-dark.png"
echo "✓ Replaced: login-dark.png"

echo ""
echo "Step 8: Setting file permissions..."
echo "----------------------------------------"

set_permissions "$ADMIN_IMG_DIR/login-bg.png"
set_permissions "$ADMIN_IMG_DIR/login-dark.png"

echo ""
echo "Step 9: Cleaning up..."
echo "----------------------------------------"

# Optionally remove .new files
read -p "Remove .new.png files? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    rm -f "$NEW_BG" "$NEW_BG_DARK"
    echo "✓ Removed temporary .new.png files"
fi

echo ""
echo "=========================================="
echo "✓ Background replacement complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Clear Laravel cache: cd core && php artisan cache:clear"
echo "2. Clear view cache: php artisan view:clear"
echo "3. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)"
echo "4. Navigate to /admin/login to verify backgrounds"
echo "5. Test both light and dark themes (if applicable)"
echo ""
echo "Backup files are saved with .backup.TIMESTAMP extension"
echo "You can restore them if needed."
echo ""
