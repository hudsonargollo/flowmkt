# Marketplace Installation Guide

## You Downloaded from CodeCanyon/Marketplace

If you purchased this application from a marketplace (CodeCanyon, etc.), it came with the `vendor/` directory already included. However, when you pushed to GitHub, the `vendor/` directory was excluded (it's in `.gitignore`).

## The Problem

```
Your Local Files (from marketplace):
├── core/
│   ├── vendor/          ← EXISTS (came with download)
│   ├── .env             ← EXISTS
│   └── app/

GitHub Repository:
├── core/
│   ├── vendor/          ← NOT PUSHED (in .gitignore)
│   ├── .env             ← NOT PUSHED (in .gitignore)
│   └── app/

Server (pulled from GitHub):
├── core/
│   ├── vendor/          ← MISSING (wasn't in GitHub)
│   ├── .env             ← MISSING (wasn't in GitHub)
│   └── app/
```

## Solutions

### Solution 1: Upload vendor/ via cPanel (Recommended for Now)

Since you have the complete vendor directory locally, upload it:

**Steps:**

1. **Compress vendor directory locally:**
   ```bash
   cd core
   tar -czf vendor.tar.gz vendor/
   ```
   This creates a compressed file (~20-50 MB instead of 100+ MB)

2. **Upload via cPanel:**
   - Go to cPanel → File Manager
   - Navigate to `/home/clubemkt/flow.clubemkt.digital/core/`
   - Click "Upload"
   - Upload `vendor.tar.gz`

3. **Extract on server:**
   - Right-click `vendor.tar.gz` → Extract
   - Delete `vendor.tar.gz` after extraction

4. **Upload .env file:**
   - Upload `core/.env` to `/home/clubemkt/flow.clubemkt.digital/core/.env`
   - Or use the `docs/setup/production.env` file

5. **Test:** Visit https://flow.clubemkt.digital

### Solution 2: Use Composer on Server (Proper Way)

Even though you have vendor locally, it's better to regenerate it on the server:

**Why?**
- Server might have different PHP version
- Ensures all dependencies are compatible
- Smaller upload (just run one command)

**How:**

Contact TurboCloud support:
```
Olá,

Preciso instalar as dependências do Composer no meu projeto Laravel.

Por favor, executar:
cd /home/clubemkt/flow.clubemkt.digital/core
composer install --no-dev --optimize-autoloader
php artisan config:cache
chmod -R 755 storage bootstrap/cache

Obrigado!
```

### Solution 3: Exclude vendor/ from .gitignore (NOT Recommended)

You could remove `vendor/` from `.gitignore` and push it to GitHub, but this is **not recommended** because:

❌ Makes repository huge (100+ MB)
❌ Slow git operations
❌ GitHub has file size limits
❌ Not standard practice
❌ Causes merge conflicts

## Recommended Approach

### For Now (Quick Fix):
1. **Upload vendor.tar.gz** via cPanel (Solution 1)
2. **Upload .env** file
3. Site works immediately

### For Future (Proper Setup):
1. Keep `vendor/` in `.gitignore`
2. Set up automated deployment with GitHub Actions
3. Deployment automatically runs `composer install`
4. No manual uploads needed

## Why Marketplace Downloads Include vendor/

Marketplace sellers include `vendor/` so buyers can:
- Install immediately without Composer knowledge
- Works out of the box
- No technical setup required

But for **development and deployment**, it's better to:
- Keep `vendor/` out of Git
- Regenerate with `composer install`
- Use automated deployment

## Step-by-Step: Upload vendor/ Now

### On Your Local Machine:

```bash
# Navigate to core directory
cd core

# Compress vendor directory
tar -czf vendor.tar.gz vendor/

# This creates vendor.tar.gz (much smaller than the folder)
ls -lh vendor.tar.gz
```

### On cPanel:

1. **File Manager** → Navigate to `/home/clubemkt/flow.clubemkt.digital/core/`
2. **Upload** → Select `vendor.tar.gz`
3. **Wait** for upload to complete
4. **Right-click** `vendor.tar.gz` → **Extract**
5. **Delete** `vendor.tar.gz` after extraction
6. **Upload** your `core/.env` file
7. **Test** your site

### Verify:

Run diagnostic again:
```
https://flow.clubemkt.digital/diagnose.php
```

Should show:
- ✅ vendor directory: EXISTS
- ✅ .env file: EXISTS

## Alternative: Use FTP/SFTP

If cPanel upload is slow:

1. **Use FileZilla or similar FTP client**
2. **Connect** to your server
3. **Upload** `core/vendor/` directory directly
4. **Upload** `core/.env` file
5. Faster for large directories

## After Site is Working

Once your site works, set up proper deployment:

1. **Whitelist your IP** on TurboCloud
2. **Add GitHub secrets** (see docs/deployment/GITHUB_SECRETS_SETUP.md)
3. **Future deployments** will be automatic
4. **No more manual uploads** needed

## Summary

**Your situation:**
- ✅ Downloaded complete app from marketplace
- ✅ Has vendor/ directory locally
- ❌ vendor/ not in GitHub (correct behavior)
- ❌ vendor/ not on server (needs upload or composer install)

**Quick fix:**
1. Compress: `tar -czf vendor.tar.gz vendor/`
2. Upload via cPanel
3. Extract on server
4. Upload .env file
5. Done!

**Proper fix:**
- Contact TurboCloud to run `composer install`
- Set up automated deployment
- Never manually upload again

---

**Next:** Upload vendor/ and .env, then your site will work! 🚀
