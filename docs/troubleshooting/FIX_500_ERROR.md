# Fix HTTP 500 Error - FlowMkt

Your site is showing a 500 error. Here's how to fix it.

## Quick Fix via cPanel File Manager

### Step 1: Check Laravel Logs

1. Go to cPanel → File Manager
2. Navigate to `public_html/flow/core/storage/logs/`
3. Open `laravel.log` (or the most recent log file)
4. Look at the last error message - this will tell us exactly what's wrong

### Step 2: Clear All Caches

In cPanel File Manager, navigate to `public_html/flow/core/` and delete these folders:

```
bootstrap/cache/config.php
bootstrap/cache/routes-v7.php
bootstrap/cache/services.php
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
```

### Step 3: Check .env File

1. Navigate to `public_html/flow/core/`
2. Make sure `.env` file exists
3. Check these critical settings:

```env
APP_NAME=FlowMkt
APP_ENV=production
APP_KEY=base64:... (must exist!)
APP_DEBUG=false
APP_URL=https://flow.clubemkt.digital

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

**CRITICAL:** If `APP_KEY` is missing, generate one:
- You'll need SSH access or ask hosting support to run: `php artisan key:generate`

### Step 4: Check File Permissions

Set correct permissions via cPanel File Manager:

```
storage/ → 755
storage/logs/ → 755
storage/framework/ → 755
storage/framework/cache/ → 755
storage/framework/sessions/ → 755
storage/framework/views/ → 755
bootstrap/cache/ → 755
```

## Fix via SSH (Once IP is Whitelisted)

If you have SSH access, run these commands:

```bash
# Navigate to your application
cd ~/public_html/flow/core

# Check what's wrong
tail -50 storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

# If APP_KEY is missing
php artisan key:generate
```

## Common 500 Error Causes & Solutions

### Error: "No application encryption key has been specified"

**Solution:**
```bash
cd ~/public_html/flow/core
php artisan key:generate
```

Or manually add to `.env`:
```env
APP_KEY=base64:SOME_RANDOM_32_CHARACTER_STRING_HERE
```

### Error: "Class 'App\View\Components\FlowMktForm' not found"

**Solution:**
```bash
cd ~/public_html/flow/core
composer dump-autoload
php artisan config:clear
```

### Error: "SQLSTATE[HY000] [1045] Access denied for user"

**Solution:** Check database credentials in `.env` file

### Error: "The stream or file could not be opened"

**Solution:** Fix storage permissions
```bash
chmod -R 755 storage bootstrap/cache
```

### Error: "Class 'Locale' not found"

**Solution:** PHP intl extension is missing. Contact TurboCloud support to enable it.

## Emergency Rollback

If nothing works, you can rollback to the previous version:

### Via cPanel File Manager

1. Rename current `core` folder to `core_backup`
2. Restore from your backup
3. Clear browser cache and try again

### Via SSH

```bash
cd ~/public_html/flow
git log --oneline -5  # See recent commits
git reset --hard HEAD~1  # Go back one commit
cd core
composer install --no-dev
php artisan cache:clear
```

## Debug Mode (Temporary)

To see the actual error message:

1. Edit `core/.env`
2. Change:
   ```env
   APP_DEBUG=true
   ```
3. Reload the page to see the detailed error
4. **IMPORTANT:** Set it back to `false` after fixing!

## Get Help from Logs

The Laravel log file will tell you exactly what's wrong:

**Location:** `public_html/flow/core/storage/logs/laravel.log`

Look for the most recent error (at the bottom of the file).

Common error patterns:
- `Class not found` → Run `composer dump-autoload`
- `No such file or directory` → Check file paths
- `Permission denied` → Fix file permissions
- `SQLSTATE` → Database connection issue
- `APP_KEY` → Generate application key

## Contact Support

If you can't fix it, contact TurboCloud support with:

1. Screenshot of the error
2. Last 50 lines of `storage/logs/laravel.log`
3. Your domain: flow.clubemkt.digital
4. What you changed recently

## Prevention

After fixing, run these commands to prevent future issues:

```bash
cd ~/public_html/flow/core

# Optimize for production
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set correct permissions
chmod -R 755 storage bootstrap/cache
```

---

**Most Likely Cause:** Missing APP_KEY or cache issues after the rebranding changes.

**Quick Fix:** Clear all caches and check the Laravel log file for the specific error.
