# FlowMkt Logo Replacement Guide

This directory contains the brand assets for FlowMkt. Follow this guide to replace the old brand logos with new FlowMkt branding.

## Quick Start

### Option 1: Automated Replacement (Recommended)

1. **Generate your logos** using the prompts in `AI_GENERATION_PROMPTS.md`

2. **Save them with `.new.png` extension** in this directory:
   ```
   logo.new.png (200x60px)
   logo_dark.new.png (200x60px)
   favicon.new.png (32x32px)
   ```

3. **Run the replacement script**:
   ```bash
   ./replace_logos.sh
   ```

4. **Clear caches**:
   ```bash
   cd ../../../core
   php artisan cache:clear
   php artisan view:clear
   php artisan config:clear
   ```

5. **Verify** the logos display correctly in your browser (hard refresh with Ctrl+Shift+R)

### Option 2: Manual Replacement

1. **Generate your logos** using the prompts in `AI_GENERATION_PROMPTS.md`

2. **Backup existing files**:
   ```bash
   cp logo.png logo.png.backup
   cp logo_dark.png logo_dark.png.backup
   cp favicon.png favicon.png.backup
   ```

3. **Replace the files** with your new FlowMkt logos:
   - Replace `logo.png` with your new logo
   - Replace `logo_dark.png` with your new dark mode logo
   - Replace `favicon.png` with your new favicon

4. **Set correct permissions**:
   ```bash
   chmod 644 logo.png
   chmod 644 logo_dark.png
   chmod 644 favicon.png
   ```

5. **Clear caches** (see step 4 in Option 1)

## Files in This Directory

### Required Files
- **logo.png** - Main logo for light backgrounds (200x60px)
- **logo_dark.png** - Logo for dark backgrounds (200x60px)
- **favicon.png** - Browser tab icon (32x32px or 16x16px)

### Documentation Files
- **LOGO_SPECIFICATIONS.md** - Detailed specifications for all logo files
- **AI_GENERATION_PROMPTS.md** - Ready-to-use prompts for AI image generators
- **README.md** - This file
- **replace_logos.sh** - Automated replacement script

## Logo Specifications Summary

| File | Size | Format | Purpose |
|------|------|--------|---------|
| logo.png | 200x60px | PNG with transparency | Main header logo (light backgrounds) |
| logo_dark.png | 200x60px | PNG with transparency | Header logo (dark backgrounds) |
| favicon.png | 32x32px or 16x16px | PNG or ICO | Browser tab icon |

## Where These Logos Are Used

### logo.png
- Main application header
- Admin panel header
- User dashboard
- Email templates
- PDF documents
- Any light-themed pages

### logo_dark.png
- Dark mode header
- Dark-themed sections
- Admin panel dark mode
- Any dark-themed pages

### favicon.png
- Browser tabs
- Bookmarks
- Browser history
- Mobile home screen shortcuts
- PWA app icon

## Verification Checklist

After replacing the logos, verify:

- [ ] Logo displays correctly on the homepage
- [ ] Logo displays correctly in admin panel
- [ ] Logo displays correctly in user dashboard
- [ ] Dark logo displays correctly in dark mode (if applicable)
- [ ] Favicon shows in browser tab
- [ ] Favicon shows in bookmarks
- [ ] All logos are clear and not pixelated
- [ ] Logos have proper transparency
- [ ] No console errors related to missing images
- [ ] Logos load quickly (file sizes optimized)

## Troubleshooting

### Logo not displaying
1. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
2. Clear Laravel cache: `php artisan cache:clear`
3. Clear view cache: `php artisan view:clear`
4. Check file permissions: `ls -la` (should be 644)
5. Check file exists: `ls -lh logo.png`

### Logo appears pixelated
- Ensure you're using the correct dimensions (200x60px for logos)
- Use PNG format with high quality
- Don't scale up small images - create at the correct size

### Favicon not updating
- Clear browser cache completely
- Close and reopen browser
- Check favicon.png exists and is readable
- Try hard refresh (Ctrl+Shift+F5)
- Wait a few minutes for browser to update

### File permission errors
```bash
chmod 644 logo.png logo_dark.png favicon.png
```

### Transparency not working
- Ensure you saved as PNG-24 with alpha channel
- Don't use JPG format (doesn't support transparency)
- Check in image editor that background is truly transparent

## Need Help?

1. **Read the specifications**: See `LOGO_SPECIFICATIONS.md` for detailed requirements
2. **Use AI prompts**: See `AI_GENERATION_PROMPTS.md` for ready-to-use generation prompts
3. **Check the design document**: See `.kiro/specs/flowmlkt-rebranding-localization/design.md`
4. **Hire a designer**: Consider using Fiverr, Upwork, or 99designs for professional logos

## Backup and Restore

### Backup Files
The replacement script automatically creates backups with timestamps:
```
logo.png.backup.20260130_143022
logo_dark.png.backup.20260130_143022
favicon.png.backup.20260130_143022
```

### Restore from Backup
If you need to restore the old logos:
```bash
cp logo.png.backup.TIMESTAMP logo.png
cp logo_dark.png.backup.TIMESTAMP logo_dark.png
cp favicon.png.backup.TIMESTAMP favicon.png
chmod 644 logo.png logo_dark.png favicon.png
```

## Additional Resources

- [Canva Logo Maker](https://www.canva.com)
- [Figma](https://www.figma.com)
- [TinyPNG](https://tinypng.com) - Optimize PNG file sizes
- [Favicon.io](https://favicon.io) - Generate favicons
- [RealFaviconGenerator](https://realfavicongenerator.net) - Comprehensive favicon generator

---

**Last Updated**: January 30, 2026
**Related Task**: Task 11.2 - Replace logo files in assets directory
**Requirements**: 3.1, 12.5
