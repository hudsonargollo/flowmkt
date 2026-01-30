#!/bin/bash

# Script to find the working Laravel installation on the server

echo "=== Finding Working Laravel Installation ==="
echo ""

# Common paths to check
PATHS=(
    "/home/clubemkt/public_html"
    "/home/clubemkt/public_html/flow"
    "/home/clubemkt/flow.clubemkt.digital"
    "/home/clubemkt/www"
    "/home/clubemkt/htdocs"
)

echo "Checking common paths..."
echo ""

for path in "${PATHS[@]}"; do
    echo "Checking: $path"
    
    if [ -d "$path/core" ]; then
        echo "  ✓ Found core/ directory"
        
        if [ -d "$path/core/vendor" ]; then
            echo "  ✓ Found vendor/ directory (Composer installed)"
        else
            echo "  ✗ No vendor/ directory"
        fi
        
        if [ -f "$path/core/.env" ]; then
            echo "  ✓ Found .env file"
        else
            echo "  ✗ No .env file"
        fi
        
        if [ -f "$path/index.php" ]; then
            echo "  ✓ Found index.php"
        fi
        
        echo ""
    else
        echo "  ✗ No core/ directory found"
        echo ""
    fi
done

echo "=== Recommendation ==="
echo ""
echo "If you found a path with vendor/ and .env, that's your working installation."
echo "You can either:"
echo "  1. Copy vendor/ and .env from there to /home/clubemkt/flow.clubemkt.digital/core/"
echo "  2. Or run 'composer install' in the new location"
echo ""
