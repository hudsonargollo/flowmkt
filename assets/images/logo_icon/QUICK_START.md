# Quick Start: Replace FlowMkt Logos

## 🚀 Fast Track (5 Minutes)

### 1. Generate Logos
Copy this prompt into ChatGPT (DALL-E 3):

```
Create a professional logo for "FlowMkt" - a marketing automation platform.
Horizontal layout, 200x60 pixel aspect ratio, transparent background.
Modern sans-serif font for "FlowMkt" text.
Simple icon showing flowing lines or connected nodes.
Blue (#2563eb) and green (#10b981) color scheme.
Minimalist, flat design, professional, suitable for SaaS.
Clear and legible at small sizes.
```

Generate 3 versions:
- **Logo** (for light backgrounds)
- **Logo Dark** (for dark backgrounds - use white/light blue text)
- **Favicon** (32x32px, simplified "F" or "FM" icon)

### 2. Download & Resize
- Download images
- Resize to exact dimensions:
  - logo.png: 200x60px
  - logo_dark.png: 200x60px
  - favicon.png: 32x32px
- Use https://squoosh.app or Photoshop

### 3. Replace Files
```bash
# Save as .new.png files
cd assets/images/logo_icon
./replace_logos.sh
```

### 4. Clear Cache
```bash
cd ../../../core
php artisan cache:clear
php artisan view:clear
```

### 5. Verify
- Open homepage - check logo
- Open /admin - check logo
- Check browser tab - check favicon
- Hard refresh: Ctrl+Shift+R

## ✅ Done!

---

**Need more details?** See `README.md` or `AI_GENERATION_PROMPTS.md`
