#!/bin/bash

# FlowMkt Deployment Script
# This script deploys the application to cPanel via SSH

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration (can be overridden by environment variables)
CPANEL_HOST="${CPANEL_HOST:-clubemkt.digital}"
CPANEL_USER="${CPANEL_USER:-clubemkt}"
CPANEL_PATH="${CPANEL_PATH:-public_html/flow}"
SSH_PORT="${SSH_PORT:-22}"
SSH_KEY="${SSH_KEY:-$HOME/.ssh/flowmkt_deploy}"

# Function to print colored output
print_status() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# Check if required variables are set
if [ -z "$CPANEL_USER" ]; then
    print_error "CPANEL_USER environment variable is not set"
    echo "Usage: CPANEL_USER=your_username ./deploy.sh"
    exit 1
fi

# Check if SSH key exists
if [ ! -f "$SSH_KEY" ]; then
    print_error "SSH key not found at $SSH_KEY"
    exit 1
fi

print_status "Starting deployment to cPanel..."

# Test SSH connection
print_status "Testing SSH connection..."
if ssh -i "$SSH_KEY" -p "$SSH_PORT" -o ConnectTimeout=10 "$CPANEL_USER@$CPANEL_HOST" "echo 'Connection successful'" > /dev/null 2>&1; then
    print_status "SSH connection successful"
else
    print_error "Failed to connect via SSH"
    exit 1
fi

# Deploy via SSH
print_status "Deploying application..."

ssh -i "$SSH_KEY" -p "$SSH_PORT" "$CPANEL_USER@$CPANEL_HOST" << 'ENDSSH'
    set -e
    
    # Navigate to application directory
    cd ${CPANEL_PATH}
    
    echo "📦 Pulling latest changes from GitHub..."
    git pull origin main
    
    echo "📂 Navigating to core directory..."
    cd core
    
    echo "🎼 Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
    
    echo "📦 Installing NPM dependencies..."
    npm ci
    
    echo "🏗️  Building frontend assets..."
    npm run build
    
    echo "🔧 Running Laravel optimizations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    echo "🔐 Setting proper permissions..."
    chmod -R 755 storage bootstrap/cache
    
    echo "✅ Deployment completed successfully!"
ENDSSH

if [ $? -eq 0 ]; then
    print_status "Deployment completed successfully!"
    print_status "Application URL: https://$CPANEL_HOST"
else
    print_error "Deployment failed!"
    exit 1
fi
