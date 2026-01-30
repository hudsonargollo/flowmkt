# FlowMkt Server Setup Guide

## Current Issues Found

✅ PHP 8.4.7 - Good!
✅ All required PHP extensions - Good!
✅ File permissions - Good!
❌ .env file is MISSING
❌ vendor directory is MISSING (Composer dependencies)

## Fix Steps

### Step 1: Create .env File

You need to copy the `.env` file from your local project to the server.

**Option A: Via cPanel File Manager**

1. On your **local machine**, locate: `core/.env`
2. Open it and copy all contents
3. In **cPanel File Manager**, navigate to: `/home/clubemkt/flow.clubemkt.digital/core/`
4. Click "New File" and name it `.env`
5. Right-click the new `.env` file → Edit
6. Paste the contents
7. **IMPORTANT:** Update these values for production:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://flow.clubemkt.digital
   
   DB_HOST=localhost
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
8. Save the file

**Option B: Upload .env File**

1. In cPanel File Manager, navigate to: `/home/clubemkt/flow.clubemkt.digital/core/`
2. Click "Upload"
3. Upload your local `core/.env` file
4. Edit it to update database credentials

### Step 2: Install Composer Dependencies

You need to run `composer install` on the server. Here are your options:

**Option A: Contact TurboCloud Support (Easiest)**

Send this message to TurboCloud support:

```
Olá,

Preciso instalar as dependências do Composer no meu projeto Laravel.

Por favor, podem executar estes comandos:

cd /home/clubemkt/flow.clubemkt.digital/core
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache

Obrigado!
```

**Option B: Via SSH (Once Your IP is Whitelisted)**

```bash
# Connect to server
ssh -i ~/.ssh/flowmkt_deploy -p 2222 clubemkt@finn1080.com.br

# Navigate to project
cd /home/clubemkt/flow.clubemkt.digital/core

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

**Option C: Via cPanel Terminal (If Available)**

1. In cPanel, look for "Terminal" or "SSH Access"
2. Open terminal
3. Run the commands from Option B

### Step 3: Verify Database Configuration

Make sure your database exists and credentials are correct in `.env`:

1. In cPanel → MySQL Databases
2. Verify database name, username, and password
3. Update `.env` file with correct values

### Step 4: Run Database Migrations (If Needed)

After Composer is installed, you may need to run migrations:

```bash
cd /home/clubemkt/flow.clubemkt.digital/core
php artisan migrate --force
```

Or contact support to run this for you.

## Quick Fix Checklist

- [ ] Copy .env file to server
- [ ] Update .env with production database credentials
- [ ] Run `composer install` (via support or SSH)
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan config:cache`
- [ ] Verify database credentials
- [ ] Test site: https://flow.clubemkt.digital

## After Setup

Once everything is installed, delete the diagnostic file:

```
/home/clubemkt/flow.clubemkt.digital/diagnose.php
```

## Alternative: Deploy from GitHub

If you set up SSH access and GitHub secrets, you can use automated deployment:

1. Whitelist your IP on TurboCloud
2. Add GitHub secrets (see GITHUB_SECRETS_SETUP.md)
3. SSH into server and initialize Git:
   ```bash
   cd /home/clubemkt/flow.clubemkt.digital
   git init
   git remote add origin https://github.com/hudsonargollo/flowmkt.git
   git fetch
   git checkout main
   ```
4. Then push to GitHub to trigger automatic deployment

## Need Help?

Contact TurboCloud support with:
- Your domain: flow.clubemkt.digital
- Issue: Need to run composer install and setup Laravel
- Commands needed: (see Option A above)

---

**Next:** Once .env and vendor are set up, your site should work!
