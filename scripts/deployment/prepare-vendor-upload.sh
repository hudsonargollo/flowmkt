#!/bin/bash

# Script to prepare vendor directory for upload to server

set -e

echo "=== Prepare vendor/ for Server Upload ==="
echo ""

# Check if we're in the right directory
if [ ! -d "core/vendor" ]; then
    echo "❌ Error: core/vendor directory not found!"
    echo "   Please run this script from the project root directory."
    exit 1
fi

echo "✓ Found core/vendor directory"
echo ""

# Get vendor directory size
VENDOR_SIZE=$(du -sh core/vendor | cut -f1)
echo "Vendor directory size: $VENDOR_SIZE"
echo ""

# Compress vendor directory
echo "Compressing vendor directory..."
cd core
tar -czf vendor.tar.gz vendor/

if [ $? -eq 0 ]; then
    COMPRESSED_SIZE=$(du -sh vendor.tar.gz | cut -f1)
    echo "✓ Compression successful!"
    echo ""
    echo "Original size: $VENDOR_SIZE"
    echo "Compressed size: $COMPRESSED_SIZE"
    echo ""
    echo "File created: core/vendor.tar.gz"
    echo ""
    echo "=== Next Steps ==="
    echo ""
    echo "1. Upload core/vendor.tar.gz to your server via cPanel:"
    echo "   - Go to cPanel → File Manager"
    echo "   - Navigate to: /home/clubemkt/flow.clubemkt.digital/core/"
    echo "   - Click 'Upload'"
    echo "   - Select vendor.tar.gz"
    echo ""
    echo "2. Extract on server:"
    echo "   - Right-click vendor.tar.gz → Extract"
    echo "   - Delete vendor.tar.gz after extraction"
    echo ""
    echo "3. Upload .env file:"
    echo "   - Upload core/.env to the same location"
    echo "   - Or use docs/setup/production.env"
    echo ""
    echo "4. Test your site:"
    echo "   - Visit: https://flow.clubemkt.digital"
    echo ""
else
    echo "❌ Compression failed!"
    exit 1
fi
