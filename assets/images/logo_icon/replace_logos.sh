#!/bin/bash

# FlowMkt Logo Replacement Script
# This script helps replace the old brand logos with new FlowMkt logos
# and sets the correct file permissions

set -e  # Exit on error

LOGO_DIR="assets/images/logo_icon"
ADMIN_DIR="assets/admin/images"

echo "=========================================="
echo "FlowMkt Logo Replacement Script"
echo "=========================================="
echo ""

# Function to check if file exists
check_file() {
    if [ -f "$1" ]; then
        echo "✓ Found: $1"
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

echo "Step 1: Checking current logo files..."
echo "----------------------------------------"

# Check main logo directory
cd "$(dirname "$0")/../../.." || exit 1

check_file "$LOGO_DIR/logo.png"
LOGO_EXISTS=$?

check_file "$LOGO_DIR/logo_dark.png"
LOGO_DARK_EXISTS=$?

check_file "$LOGO_DIR/favicon.png"
FAVICON_EXISTS=$?

echo ""
echo "Step 2: Checking for new FlowMkt logo files..."
echo "----------------------------------------"

# Check if new logo files are ready (you should place them with .new extension first)
NEW_LOGO="$LOGO_DIR/logo.new.png"
NEW_LOGO_DARK="$LOGO_DIR/logo_dark.new.png"
NEW_FAVICON="$LOGO_DIR/favicon.new.png"

NEW_FILES_READY=true

if [ ! -f "$NEW_LOGO" ]; then
    echo "✗ New logo not found: $NEW_LOGO"
    echo "  Please create logo.new.png with your new FlowMkt logo"
    NEW_FILES_READY=false
fi

if [ ! -f "$NEW_LOGO_DARK" ]; then
    echo "✗ New dark logo not found: $NEW_LOGO_DARK"
    echo "  Please create logo_dark.new.png with your new FlowMkt dark logo"
    NEW_FILES_READY=false
fi

if [ ! -f "$NEW_FAVICON" ]; then
    echo "✗ New favicon not found: $NEW_FAVICON"
    echo "  Please create favicon.new.png with your new FlowMkt favicon"
    NEW_FILES_READY=false
fi

if [ "$NEW_FILES_READY" = false ]; then
    echo ""
    echo "=========================================="
    echo "INSTRUCTIONS:"
    echo "=========================================="
    echo "1. Generate your FlowMkt logos using the prompts in AI_GENERATION_PROMPTS.md"
    echo "2. Save them with .new.png extension in $LOGO_DIR:"
    echo "   - logo.new.png (200x60px)"
    echo "   - logo_dark.new.png (200x60px)"
    echo "   - favicon.new.png (32x32px)"
    echo "3. Run this script again to replace the old logos"
    echo ""
    exit 1
fi

echo "✓ All new logo files found!"
echo ""

# Verify image dimensions (requires ImageMagick)
if command -v identify &> /dev/null; then
    echo "Step 3: Verifying image dimensions..."
    echo "----------------------------------------"
    
    LOGO_SIZE=$(identify -format "%wx%h" "$NEW_LOGO" 2>/dev/null || echo "unknown")
    LOGO_DARK_SIZE=$(identify -format "%wx%h" "$NEW_LOGO_DARK" 2>/dev/null || echo "unknown")
    FAVICON_SIZE=$(identify -format "%wx%h" "$NEW_FAVICON" 2>/dev/null || echo "unknown")
    
    echo "logo.new.png: $LOGO_SIZE (recommended: 200x60)"
    echo "logo_dark.new.png: $LOGO_DARK_SIZE (recommended: 200x60)"
    echo "favicon.new.png: $FAVICON_SIZE (recommended: 32x32 or 16x16)"
    echo ""
fi

# Ask for confirmation
echo "Step 4: Ready to replace logos"
echo "----------------------------------------"
echo "This will:"
echo "  1. Backup existing logo files"
echo "  2. Replace them with new FlowMkt logos"
echo "  3. Set correct file permissions (644)"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Cancelled by user."
    exit 0
fi

echo ""
echo "Step 5: Backing up existing files..."
echo "----------------------------------------"

backup_file "$LOGO_DIR/logo.png"
backup_file "$LOGO_DIR/logo_dark.png"
backup_file "$LOGO_DIR/favicon.png"

echo ""
echo "Step 6: Replacing logo files..."
echo "----------------------------------------"

cp "$NEW_LOGO" "$LOGO_DIR/logo.png"
echo "✓ Replaced: logo.png"

cp "$NEW_LOGO_DARK" "$LOGO_DIR/logo_dark.png"
echo "✓ Replaced: logo_dark.png"

cp "$NEW_FAVICON" "$LOGO_DIR/favicon.png"
echo "✓ Replaced: favicon.png"

echo ""
echo "Step 7: Setting file permissions..."
echo "----------------------------------------"

set_permissions "$LOGO_DIR/logo.png"
set_permissions "$LOGO_DIR/logo_dark.png"
set_permissions "$LOGO_DIR/favicon.png"

echo ""
echo "Step 8: Cleaning up..."
echo "----------------------------------------"

# Optionally remove .new files
read -p "Remove .new.png files? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    rm -f "$NEW_LOGO" "$NEW_LOGO_DARK" "$NEW_FAVICON"
    echo "✓ Removed temporary .new.png files"
fi

echo ""
echo "=========================================="
echo "✓ Logo replacement complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Clear Laravel cache: php artisan cache:clear"
echo "2. Clear view cache: php artisan view:clear"
echo "3. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)"
echo "4. Verify logos display correctly across the application"
echo ""
echo "Backup files are saved with .backup.TIMESTAMP extension"
echo "You can restore them if needed."
echo ""
