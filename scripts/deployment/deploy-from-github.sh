#!/bin/bash

# FlowMkt Deployment Script - Pull from GitHub
# This script pulls the latest code from GitHub and sets up the application

set -e  # Exit on any error

echo "🚀 Starting FlowMkt Deployment from GitHub..."
echo "================================================"

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Configuration
REPO_URL="https://github.com/hudsonargollo/flowmkt.git"
BRANCH="main"
APP_DIR="/home/clubemkt/public_html"
CORE_DIR="$APP_DIR/core"

# Function to print colored output
print_status() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

# Check if we're in the right directory
if [ ! -d "$APP_DIR" ]; then
    print_error "Directory $APP_DIR does not exist!"
    exit 1
fi

cd "$APP_DIR"
print_status "Changed to directory: $APP_DIR"

# Check if git is installed
if ! command -v git &> /dev/null; then
    print_error "Git is not installed. Please install git first."
    exit 1
fi

# Check if this is a git repository
if [ ! -d ".git" ]; then
    print_warning "Not a git repository. Cloning from GitHub..."
    
    # Backup existing files if any
    if [ "$(ls -A)" ]; then
        print_warning "Directory not empty. Creating backup..."
        BACKUP_DIR="$APP_DIR/../backup_$(date +%Y%m%d_%H%M%S)"
        mkdir -p "$BACKUP_DIR"
        cp -r * "$BACKUP_DIR/" 2>/dev/null || true
        print_status "Backup created at: $BACKUP_DIR"
    fi
    
    # Clone the repository
    print_status "Cloning repository from GitHub..."
    git clone "$REPO_URL" temp_clone
    
    # Move files from temp_clone to current directory
    mv temp_clone/.git .
    mv temp_clone/* . 2>/dev/null || true
    mv temp_clone/.gitignore . 2>/dev/null || true
    rm -rf temp_clone
    
    print_status "Repository cloned successfully!"
else
    print_status "Git repository detected. Pulling latest changes..."
    
    # Stash any local changes
    if ! git diff-index --quiet HEAD --; then
        print_warning "Local changes detected. Stashing..."
        git stash
    fi
    
    # Pull latest changes
    git fetch origin
    git reset --hard origin/$BRANCH
    print_status "Latest changes pulled from GitHub!"
fi

# Navigate to core directory
cd "$CORE_DIR"
print_status "Changed to core directory: $CORE_DIR"

# Set correct permissions
print_status "Setting correct permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage/framework/sessions 2>/dev/null || true
chmod -R 775 storage/framework/views 2>/dev/null || true
chmod -R 775 storage/framework/cache 2>/dev/null || true
chmod -R 775 storage/logs 2>/dev/null || true

# Create necessary directories if they don't exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p bootstrap/cache

print_status "Permissions set successfully!"

# Clear Laravel caches
print_status "Clearing Laravel caches..."
php artisan config:clear 2>/dev/null || print_warning "Could not clear config cache"
php artisan cache:clear 2>/dev/null || print_warning "Could not clear application cache"
php artisan view:clear 2>/dev/null || print_warning "Could not clear view cache"
php artisan route:clear 2>/dev/null || print_warning "Could not clear route cache"

# Optimize for production
print_status "Optimizing for production..."
php artisan config:cache 2>/dev/null || print_warning "Could not cache config"
php artisan route:cache 2>/dev/null || print_warning "Could not cache routes"
php artisan view:cache 2>/dev/null || print_warning "Could not cache views"

print_status "Optimization complete!"

# Check .env file
if [ ! -f ".env" ]; then
    print_warning ".env file not found!"
    if [ -f ".env.production" ]; then
        print_status "Copying .env.production to .env..."
        cp .env.production .env
    else
        print_error "No .env or .env.production file found. Please create one!"
    fi
fi

echo ""
echo "================================================"
echo -e "${GREEN}✓ Deployment completed successfully!${NC}"
echo "================================================"
echo ""
echo "📋 Post-deployment checklist:"
echo "  1. Verify .env configuration"
echo "  2. Check file permissions"
echo "  3. Test the application"
echo "  4. Monitor error logs: tail -f storage/logs/laravel.log"
echo ""
echo "🌐 Your application should now be updated!"
