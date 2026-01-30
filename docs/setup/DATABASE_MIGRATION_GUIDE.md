# Database Migration Guide

## Problem

Your local database has FlowMkt branding and Portuguese translations, but the server database still has OvoWpp and English content.

## Solution: Export Local DB → Import to Server

### Step 1: Export Local Database

**Option A: Using phpMyAdmin (Easiest)**

1. Open phpMyAdmin locally
2. Select your database (the one in your local .env)
3. Click "Export" tab
4. Choose "Quick" export method
5. Format: SQL
6. Click "Go"
7. Save the file (e.g., `flowmkt_local.sql`)

**Option B: Using Command Line**

```bash
# Find your local database credentials in core/.env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

mysqldump -u [username] -p [database_name] > flowmkt_local.sql
```

### Step 2: Backup Server Database (Important!)

Before importing, backup the current server database:

1. Go to cPanel → phpMyAdmin
2. Select database: `clubemkt_zapflow`
3. Click "Export"
4. Save as `server_backup_[date].sql`

### Step 3: Import to Server

**Option A: Using cPanel phpMyAdmin**

1. Go to cPanel → phpMyAdmin
2. Select database: `clubemkt_zapflow`
3. Click "Import" tab
4. Choose your `flowmkt_local.sql` file
5. Click "Go"
6. Wait for import to complete

**Option B: Using cPanel File Manager + SQL**

If the file is too large for phpMyAdmin:

1. Upload `flowmkt_local.sql` to server via cPanel File Manager
2. Go to cPanel → Terminal (or SSH)
3. Run:
   ```bash
   cd /home/clubemkt
   mysql -u clubemkt_zapflow -p clubemkt_zapflow < flowmkt_local.sql
   # Enter password: tF4s8*7KnB*2
   ```

### Step 4: Clear Cache

After importing, clear all caches:

1. Visit: https://flow.clubemkt.digital/quick_cache_clear.php
2. Or via SSH:
   ```bash
   cd /home/clubemkt/flow.clubemkt.digital/core
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### Step 5: Test

Visit: https://flow.clubemkt.digital

You should now see:
- ✅ FlowMkt branding
- ✅ Portuguese translations
- ✅ All your local changes

## Alternative: Fresh Install

If you want to start fresh with the marketplace database:

1. Keep the server database as-is
2. Login to admin panel
3. Manually update:
   - Site name: Admin → Settings → General
   - Language: Admin → Settings → Language
   - Frontend content: Admin → Frontend Management

## Troubleshooting

**Import fails with "max_allowed_packet" error:**
- Split the SQL file into smaller parts
- Or increase max_allowed_packet in MySQL settings

**Import takes too long:**
- Use SSH/Terminal method instead of phpMyAdmin
- Or use cPanel "Import" feature which handles large files better

**Site breaks after import:**
- Restore the backup: Import `server_backup_[date].sql`
- Check that database credentials in .env match the server

## Important Notes

- ⚠️ Importing will **replace all data** on the server
- ⚠️ Any users/data on the server will be lost
- ⚠️ Always backup before importing
- ✅ Your local database has all the FlowMkt branding
- ✅ Your local database has Portuguese translations
- ✅ This is the fastest way to get everything working

---

**Recommended:** Export local DB and import to server. This brings all your changes at once.
