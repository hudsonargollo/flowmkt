# GitHub Deployment Guide

This guide will help you deploy your FlowMkt application from GitHub to your production server.

## Prerequisites

- SSH access to your server
- Git installed on the server
- Your GitHub repository: `https://github.com/hudsonargollo/flowmkt.git`

## Step 1: Connect to Your Server

```bash
ssh clubemkt@your-server-ip
# Or use the hostname
ssh clubemkt@turbocloud.host
```

## Step 2: Navigate to Your Web Directory

```bash
cd /home/clubemkt/public_html
```

## Step 3: Initial Setup (First Time Only)

### Option A: If directory is empty

```bash
# Clone the repository
git clone https://github.com/hudsonargollo/flowmkt.git .

# Note: The dot (.) at the end clones into current directory
```

### Option B: If directory has existing files

```bash
# Backup existing files first
mkdir ../backup_$(date +%Y%m%d)
cp -r * ../backup_$(date +%Y%m%d)/

# Initialize git and pull
git init
git remote add origin https://github.com/hudsonargollo/flowmkt.git
git fetch
git reset --hard origin/main
```

## Step 4: Set Up the Application

```bash
# Navigate to core directory
cd core

# Create necessary directories
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set correct permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# If you need to change owner (replace www-data with your web server user)
# chown -R www-data:www-data storage bootstrap/cache

# Copy environment file if needed
cp .env.production .env

# Edit .env with your production settings
nano .env
```

## Step 5: Configure .env File

Make sure these settings are correct in your `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://flow.clubemkt.digital

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clubemkt_zapflow
DB_USERNAME=clubemkt_zapflow
DB_PASSWORD=your_password_here
```

## Step 6: Clear and Cache

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Step 7: Test the Application

Visit your website: `https://flow.clubemkt.digital`

Check for errors in the log:
```bash
tail -f storage/logs/laravel.log
```

---

## Future Deployments (Updates)

For subsequent deployments, you can use the automated script:

### Method 1: Using the Deployment Script

```bash
cd /home/clubemkt/public_html
bash scripts/deployment/quick-deploy.sh
```

### Method 2: Manual Steps

```bash
cd /home/clubemkt/public_html

# Pull latest changes
git pull origin main

# Navigate to core
cd core

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Troubleshooting

### Permission Denied Errors

```bash
cd /home/clubemkt/public_html/core
chmod -R 775 storage bootstrap/cache
```

### Git Pull Conflicts

```bash
# Stash local changes
git stash

# Pull latest
git pull origin main

# If you need your local changes back
git stash pop
```

### 500 Server Error

```bash
# Check logs
tail -f core/storage/logs/laravel.log

# Clear all caches
cd core
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### File Not Found Errors

Make sure your web server is pointing to:
```
/home/clubemkt/public_html/index.php
```

Not to:
```
/home/clubemkt/public_html/core/public/index.php
```

---

## Automated Deployment with GitHub Actions (Optional)

If you want automatic deployments when you push to GitHub, you can set up GitHub Actions. Let me know if you want help with this!

---

## Quick Reference Commands

```bash
# Pull latest code
cd /home/clubemkt/public_html && git pull origin main

# Clear caches
cd core && php artisan config:clear && php artisan cache:clear

# Cache for production
php artisan config:cache && php artisan route:cache

# Check logs
tail -f core/storage/logs/laravel.log

# Set permissions
chmod -R 775 core/storage core/bootstrap/cache
```

---

## Need Help?

If you encounter any issues:
1. Check the Laravel logs: `core/storage/logs/laravel.log`
2. Check web server error logs
3. Verify file permissions
4. Ensure .env is configured correctly
