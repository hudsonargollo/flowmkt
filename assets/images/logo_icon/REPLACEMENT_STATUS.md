# Logo Replacement Status

**Date**: January 30, 2026  
**Task**: 11.2 Replace logo files in assets directory  
**Status**: Ready for user action

## Current State

### Existing Logo Files
The following files currently exist and contain the old brand (OvoWpp/FlowZap) logos:

- ✓ `logo.png` - 12,217 bytes (old brand)
- ✓ `logo_dark.png` - 10,994 bytes (old brand)
- ✓ `favicon.png` - 2,878 bytes (old brand)

### File Permissions
Current permissions: `rw-rw-r--` (664)  
Required permissions: `rw-r--r--` (644)

## What Needs to Be Done

### 1. Generate New FlowMkt Logos
Use the prompts in `AI_GENERATION_PROMPTS.md` to generate:
- [ ] logo.png (200x60px, PNG with transparency)
- [ ] logo_dark.png (200x60px, PNG with transparency)
- [ ] favicon.png (32x32px or 16x16px, PNG)

### 2. Replace the Files
Choose one of these methods:

#### Method A: Automated (Recommended)
```bash
# 1. Save your new logos with .new.png extension
# 2. Run the replacement script
./replace_logos.sh
```

#### Method B: Manual
```bash
# 1. Backup existing files
cp logo.png logo.png.backup
cp logo_dark.png logo_dark.png.backup
cp favicon.png favicon.png.backup

# 2. Copy your new logos (replace these with your actual files)
cp /path/to/your/new-logo.png logo.png
cp /path/to/your/new-logo-dark.png logo_dark.png
cp /path/to/your/new-favicon.png favicon.png

# 3. Set correct permissions
chmod 644 logo.png logo_dark.png favicon.png
```

### 3. Clear Caches
```bash
cd ../../../core
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### 4. Verify
- [ ] Check homepage displays new logo
- [ ] Check admin panel displays new logo
- [ ] Check browser tab shows new favicon
- [ ] Test on both light and dark backgrounds
- [ ] Verify no broken image links

## Documentation Created

The following documentation files have been created to help you:

1. **README.md** - Quick start guide and troubleshooting
2. **LOGO_SPECIFICATIONS.md** - Detailed specifications for all logo files
3. **AI_GENERATION_PROMPTS.md** - Ready-to-use prompts for AI image generators
4. **replace_logos.sh** - Automated replacement script
5. **REPLACEMENT_STATUS.md** - This file

## Next Steps

1. **Read** `AI_GENERATION_PROMPTS.md` for detailed prompts
2. **Generate** your FlowMkt logos using AI tools or design software
3. **Follow** the instructions in `README.md` to replace the files
4. **Verify** the logos display correctly
5. **Move to** Task 11.3 (Check and update admin login backgrounds)

## Important Notes

- The replacement script will automatically backup your old logos
- File permissions will be set to 644 automatically
- You must clear Laravel and browser caches after replacement
- Test on multiple pages to ensure logos display correctly
- Keep your logo source files in a safe location for future use

## Technical Details

### File Paths
- Logo directory: `assets/images/logo_icon/`
- Admin images: `assets/admin/images/`
- Public path: `public/assets/images/logo_icon/`

### Usage in Code
Logos are referenced in Blade templates as:
```blade
{{ asset('assets/images/logo_icon/logo.png') }}
{{ asset('assets/images/logo_icon/logo_dark.png') }}
{{ asset('assets/images/logo_icon/favicon.png') }}
```

### Cache Locations
- Config cache: `core/bootstrap/cache/config.php`
- View cache: `core/storage/framework/views/`
- Application cache: `core/storage/framework/cache/`

---

**Action Required**: User must generate and replace logo files  
**Blocking**: No - documentation and scripts are ready  
**Estimated Time**: 30-60 minutes (including logo generation)
