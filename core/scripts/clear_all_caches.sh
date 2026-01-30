#!/bin/bash

###############################################################################
# Clear All Application Caches
# 
# This script clears all Laravel caches to ensure configuration and view
# changes are properly reflected after rebranding and localization.
#
# Usage: ./core/scripts/clear_all_caches.sh
###############################################################################

set -e  # Exit on error

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║              FlowMkt Cache Clearing Script                    ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Change to core directory
cd "$(dirname "$0")/.."

echo -e "${BLUE}🧹 Clearing Laravel caches...${NC}"
echo ""

###############################################################################
# 1. Clear Configuration Cache
###############################################################################

echo -e "${BLUE}1. Clearing configuration cache...${NC}"
if php artisan config:clear; then
    echo -e "${GREEN}✅ Configuration cache cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Warning: Could not clear configuration cache${NC}"
fi
echo ""

###############################################################################
# 2. Clear Application Cache
###############################################################################

echo -e "${BLUE}2. Clearing application cache...${NC}"
if php artisan cache:clear; then
    echo -e "${GREEN}✅ Application cache cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Warning: Could not clear application cache${NC}"
fi
echo ""

###############################################################################
# 3. Clear View Cache
###############################################################################

echo -e "${BLUE}3. Clearing view cache...${NC}"
if php artisan view:clear; then
    echo -e "${GREEN}✅ View cache cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Warning: Could not clear view cache${NC}"
fi
echo ""

###############################################################################
# 4. Clear Route Cache
###############################################################################

echo -e "${BLUE}4. Clearing route cache...${NC}"
if php artisan route:clear; then
    echo -e "${GREEN}✅ Route cache cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Warning: Could not clear route cache${NC}"
fi
echo ""

###############################################################################
# 5. Clear Compiled Classes
###############################################################################

echo -e "${BLUE}5. Clearing compiled classes...${NC}"
if php artisan clear-compiled; then
    echo -e "${GREEN}✅ Compiled classes cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Warning: Could not clear compiled classes${NC}"
fi
echo ""

###############################################################################
# 6. Clear Event Cache (if exists)
###############################################################################

echo -e "${BLUE}6. Clearing event cache...${NC}"
if php artisan event:clear 2>/dev/null; then
    echo -e "${GREEN}✅ Event cache cleared${NC}"
else
    echo -e "${YELLOW}⚠️  Event cache command not available (Laravel 11+)${NC}"
fi
echo ""

###############################################################################
# 7. Optimize Autoloader
###############################################################################

echo -e "${BLUE}7. Optimizing autoloader...${NC}"
if composer dump-autoload -o 2>/dev/null; then
    echo -e "${GREEN}✅ Autoloader optimized${NC}"
else
    echo -e "${YELLOW}⚠️  Composer not available, skipping autoloader optimization${NC}"
fi
echo ""

###############################################################################
# Summary
###############################################################################

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                    CACHE CLEARING COMPLETE                     ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${GREEN}✅ All caches have been cleared successfully!${NC}"
echo ""
echo -e "${BLUE}📋 Next Steps:${NC}"
echo "   1. Restart your web server (if using PHP-FPM or similar)"
echo "   2. Clear your browser cache"
echo "   3. Test the application to verify changes are visible"
echo ""
echo -e "${BLUE}💡 Tip:${NC} If changes are still not visible, you may need to:"
echo "   • Clear CDN cache (if using a CDN)"
echo "   • Clear reverse proxy cache (if using nginx/varnish)"
echo "   • Hard refresh browser (Ctrl+Shift+R or Cmd+Shift+R)"
echo ""
