#!/bin/bash

# Quick Deploy Script - Simple version
# Run this on your server to pull latest changes

echo "🚀 Pulling latest changes from GitHub..."

# Pull latest code
git pull origin main

# Navigate to core
cd core

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✓ Deployment complete!"
