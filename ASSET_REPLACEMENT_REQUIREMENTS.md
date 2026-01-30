# FlowMkt Asset Replacement Requirements

## Overview

This document provides comprehensive requirements and specifications for all brand assets that need to be created and replaced as part of the FlowMkt rebranding project. It consolidates information from multiple sources and provides a complete checklist for asset management.

**Last Updated**: 2026-01-30  
**Version**: 1.0

---

## Table of Contents

1. [Required Assets](#required-assets)
2. [Logo Specifications](#logo-specifications)
3. [Favicon Specifications](#favicon-specifications)
4. [Login Background Specifications](#login-background-specifications)
5. [File Locations](#file-locations)
6. [Technical Requirements](#technical-requirements)
7. [Design Guidelines](#design-guidelines)
8. [Creation Tools and Resources](#creation-tools-and-resources)
9. [Implementation Checklist](#implementation-checklist)
10. [Verification Steps](#verification-steps)

---

## Required Assets

### Priority 1: Essential Assets (Must Have)

These assets are required for the application to display FlowMkt branding correctly:

| Asset | File Name | Size | Format | Priority |
|-------|-----------|------|--------|----------|
| Main Logo | logo.png | 200x60px | PNG | Critical |
| Dark Logo | logo_dark.png | 200x60px | PNG | Critical |
| Favicon | favicon.png | 32x32px | PNG/ICO | Critical |

### Priority 2: Optional Assets (Nice to Have)

These assets enhance the branding but are not strictly required:

| Asset | File Name | Size | Format | Priority |
|-------|-----------|------|--------|----------|
| Admin Login BG (Light) | login-bg.png | 1920x1080px | PNG/JPG | Optional |
| Admin Login BG (Dark) | login-dark.png | 1920x1080px | PNG/JPG | Optional |

---

## Logo Specifications

### 1. Main Logo (logo.png)

**Purpose**: Primary logo displayed throughout the application on light backgrounds

**Technical Specifications**:
- **Dimensions**: 200 x 60 pixels (width x height)
- **Format**: PNG-24 with alpha channel (transparency)
- **Color Mode**: RGB
- **File Size**: Target under 50KB (optimized)
- **DPI**: 72 (web standard)

**Design Requirements**:
- Must include "FlowMkt" text or brand mark
- Should work well on white and light-colored backgrounds
- Must be legible at actual size (200x60px)
- Should maintain brand colors (see Color Palette section)
- Must have transparent background (no white backdrop)
- Should be simple enough to remain clear at smaller sizes

**Usage Locations**:
- Main application header
- User dashboard header
- Admin panel header
- Email templates
- PDF exports
- Documentation

**Color Recommendations**:
- Primary: Blue (#2563eb)
- Secondary: Green (#10b981) or Purple (#8b5cf6)
- Text: Dark gray (#1e293b) or brand color
- Background: Transparent

### 2. Dark Mode Logo (logo_dark.png)

**Purpose**: Logo variant optimized for dark backgrounds and dark mode

**Technical Specifications**:
- **Dimensions**: 200 x 60 pixels (width x height)
- **Format**: PNG-24 with alpha channel (transparency)
- **Color Mode**: RGB
- **File Size**: Target under 50KB (optimized)
- **DPI**: 72 (web standard)

**Design Requirements**:
- Same design as main logo but with inverted/adjusted colors
- Must work well on dark backgrounds (#0f172a, #1e293b)
- Should use light colors for text and elements
- Must maintain high contrast for visibility
- Must have transparent background

**Usage Locations**:
- Dark mode interface
- Dark-themed admin sections
- Dark backgrounds in marketing materials

**Color Recommendations**:
- Primary: Light Blue (#60a5fa) or White (#ffffff)
- Secondary: Cyan (#22d3ee) or Light Green (#4ade80)
- Text: White (#ffffff) or very light gray (#f1f5f9)
- Background: Transparent

---

## Favicon Specifications

### favicon.png

**Purpose**: Browser tab icon, bookmarks, and browser history

**Technical Specifications**:
- **Dimensions**: 32 x 32 pixels (recommended) or 16 x 16 pixels
- **Format**: PNG or ICO
- **Color Mode**: RGB with alpha channel
- **File Size**: Target under 10KB
- **DPI**: 72 (web standard)

**Design Requirements**:
- Must be recognizable at 16x16 pixels when scaled down
- Should be a simplified version of the main logo or brand mark
- Avoid fine details that won't be visible at small sizes
- Use high contrast colors
- Should work on both light and dark browser themes
- Must have transparent or solid background

**Design Options**:
1. **Letter Mark**: Stylized "F" or "FM" monogram
2. **Symbol**: Abstract flow icon or connected nodes
3. **Simplified Logo**: Icon element from main logo without text

**Color Recommendations**:
- Use brand primary color (#2563eb)
- Keep it simple - single color or simple gradient
- Ensure good contrast with browser UI

**Additional Formats** (Optional but Recommended):
- favicon.ico (multi-size ICO file: 16x16, 32x32, 48x48)
- apple-touch-icon.png (180x180px for iOS devices)
- android-chrome-192x192.png (192x192px for Android)
- android-chrome-512x512.png (512x512px for Android)

---

## Login Background Specifications

### 1. Light Theme Background (login-bg.png)

**Purpose**: Background image for admin login page (light theme)

**Technical Specifications**:
- **Dimensions**: 1920 x 1080 pixels (16:9 aspect ratio)
- **Format**: PNG or JPG
- **Color Mode**: RGB
- **File Size**: Target under 500KB (optimized)
- **DPI**: 72 (web standard)

**Design Requirements**:
- Should provide good contrast for dark text and login forms
- Use light colors and subtle patterns
- Should not be too busy or distracting
- Must align with FlowMkt brand identity
- Should work well at various screen sizes

**Design Elements**:
- Abstract flowing lines or gradient mesh
- Geometric patterns
- Subtle branding elements
- Soft blues, whites, and light colors

**Color Palette**:
- Background: Light blue (#dbeafe, #bfdbfe)
- Accents: White (#ffffff), Soft blue (#93c5fd)
- Gradients: Subtle blue to white transitions

### 2. Dark Theme Background (login-dark.png)

**Purpose**: Background image for admin login page (dark theme)

**Technical Specifications**:
- **Dimensions**: 1920 x 1080 pixels (16:9 aspect ratio)
- **Format**: PNG or JPG
- **Color Mode**: RGB
- **File Size**: Target under 500KB (optimized)
- **DPI**: 72 (web standard)

**Design Requirements**:
- Should provide good contrast for light text and login forms
- Use dark colors with subtle lighting effects
- Should not be too bright or distracting
- Must align with FlowMkt brand identity
- Should convey professionalism and technology

**Design Elements**:
- Abstract tech patterns
- Flowing gradients
- Connected network nodes
- Subtle glows or lighting effects

**Color Palette**:
- Background: Dark blue (#0f172a, #1e293b)
- Accents: Blue (#3b82f6), Purple (#8b5cf6)
- Highlights: Cyan (#22d3ee), Light blue (#60a5fa)

---

## File Locations

### Logo Files

```
assets/images/logo_icon/
├── logo.png              (Main logo - light backgrounds)
├── logo_dark.png         (Dark mode logo)
├── favicon.png           (Browser favicon)
├── LOGO_SPECIFICATIONS.md (This documentation)
├── AI_GENERATION_PROMPTS.md (AI prompts for logo generation)
└── replace_logos.sh      (Replacement script)
```

### Login Background Files

```
assets/admin/images/
├── login-bg.png          (Light theme login background)
├── login-dark.png        (Dark theme login background)
├── LOGIN_BACKGROUND_SPECIFICATIONS.md (Documentation)
├── LOGIN_BACKGROUNDS_GUIDE.md (Implementation guide)
├── LOGIN_BACKGROUNDS_STATUS.md (Status tracking)
└── replace_login_backgrounds.sh (Replacement script)
```

---

## Technical Requirements

### File Format Requirements

**PNG Files**:
- Use PNG-24 format (24-bit color with 8-bit alpha channel)
- Enable transparency/alpha channel
- Optimize with tools like TinyPNG or Squoosh
- Avoid PNG-8 (limited color palette)

**JPG Files** (for backgrounds only):
- Use high quality (85-95%)
- RGB color mode
- Progressive encoding (optional)
- Optimize file size without visible quality loss

**ICO Files** (for favicon):
- Multi-size ICO containing 16x16, 32x32, 48x48
- Can be generated from PNG using online tools

### File Size Optimization

**Target File Sizes**:
- Logos: Under 50KB each
- Favicon: Under 10KB
- Login backgrounds: Under 500KB each

**Optimization Tools**:
- TinyPNG (https://tinypng.com) - PNG compression
- Squoosh (https://squoosh.app) - Multi-format optimization
- ImageOptim (Mac) - Batch optimization
- RIOT (Windows) - Image optimization tool

### File Permissions

After placing files on the server, set correct permissions:

```bash
# For logo files
chmod 644 assets/images/logo_icon/logo.png
chmod 644 assets/images/logo_icon/logo_dark.png
chmod 644 assets/images/logo_icon/favicon.png

# For login backgrounds
chmod 644 assets/admin/images/login-bg.png
chmod 644 assets/admin/images/login-dark.png
```

---

## Design Guidelines

### Brand Colors

Use these colors consistently across all assets:

#### Primary Colors
- **Primary Blue**: #2563eb (rgb(37, 99, 235))
- **Primary Green**: #10b981 (rgb(16, 185, 129))
- **Primary Purple**: #8b5cf6 (rgb(139, 92, 246))

#### Secondary Colors
- **Light Blue**: #60a5fa (rgb(96, 165, 250))
- **Teal**: #14b8a6 (rgb(20, 184, 166))
- **Cyan**: #22d3ee (rgb(34, 211, 238))

#### Neutral Colors
- **Dark**: #0f172a (rgb(15, 23, 42))
- **Medium Dark**: #1e293b (rgb(30, 41, 59))
- **Light Gray**: #f1f5f9 (rgb(241, 245, 249))
- **White**: #ffffff (rgb(255, 255, 255))

### Typography Guidelines

**Recommended Fonts** (for logo text):
- **Modern Sans-Serif**: Inter, Poppins, Montserrat, Roboto
- **Geometric**: Outfit, Space Grotesk, DM Sans
- **Bold/Strong**: Raleway Bold, Nunito Bold, Work Sans Bold

**Font Characteristics**:
- Clean and modern
- Good legibility at small sizes
- Professional appearance
- Tech-forward aesthetic

### Design Principles

1. **Simplicity**: Keep designs clean and uncluttered
2. **Scalability**: Ensure logos work at various sizes
3. **Consistency**: Maintain brand colors and style
4. **Professionalism**: Convey trust and reliability
5. **Modernity**: Use contemporary design trends
6. **Clarity**: Ensure all elements are clearly visible

### Visual Themes

**FlowMkt Brand Themes**:
- **Flow**: Flowing lines, curves, connections
- **Automation**: Gears, arrows, automated processes
- **Connectivity**: Networks, nodes, links
- **Technology**: Modern, digital, innovative
- **Marketing**: Communication, messaging, engagement

---

## Creation Tools and Resources

### Professional Design Tools

#### Desktop Applications
- **Adobe Photoshop** - Industry standard for image editing
- **Adobe Illustrator** - Vector graphics and logo design
- **Figma** - Collaborative design tool (free tier available)
- **Sketch** - Mac-only design tool
- **GIMP** - Free alternative to Photoshop
- **Inkscape** - Free vector graphics editor

#### Online Tools
- **Canva** (https://www.canva.com) - Easy-to-use design tool
- **Adobe Express** (https://www.adobe.com/express) - Quick design creation
- **Figma** (https://www.figma.com) - Browser-based design tool
- **Photopea** (https://www.photopea.com) - Free online Photoshop alternative

### AI Image Generation Tools

#### Text-to-Image AI
- **DALL-E 3** (via ChatGPT Plus) - High-quality AI image generation
- **Midjourney** - Artistic AI image generation
- **Stable Diffusion** - Open-source AI image generation
- **Adobe Firefly** - Adobe's AI image generator

#### Logo-Specific AI Tools
- **Looka** (https://looka.com) - AI-powered logo maker
- **Brandmark** (https://brandmark.io) - AI logo design
- **Tailor Brands** (https://www.tailorbrands.com) - AI branding platform

**See**: `assets/images/logo_icon/AI_GENERATION_PROMPTS.md` for ready-to-use AI prompts

### Favicon Generators

- **Favicon.io** (https://favicon.io) - Generate favicons from text or images
- **RealFaviconGenerator** (https://realfavicongenerator.net) - Comprehensive favicon generator
- **Favicon Generator** (https://www.favicon-generator.org) - Simple favicon creation

### Image Optimization Tools

- **TinyPNG** (https://tinypng.com) - PNG and JPG compression
- **Squoosh** (https://squoosh.app) - Google's image optimizer
- **ImageOptim** (https://imageoptim.com) - Mac batch optimizer
- **RIOT** (https://riot-optimizer.com) - Windows image optimizer

### Freelance Design Services

If you need professional help:

- **Fiverr** (https://www.fiverr.com) - Starting at $5-50
- **Upwork** (https://www.upwork.com) - Hourly or project-based
- **99designs** (https://99designs.com) - Design contests
- **Dribbble** (https://dribbble.com) - Hire designers from portfolio site

---

## Implementation Checklist

### Phase 1: Asset Creation

- [ ] **Design main logo** (logo.png)
  - [ ] Create design concept
  - [ ] Export at 200x60px
  - [ ] Ensure transparency
  - [ ] Optimize file size
  - [ ] Test on light backgrounds

- [ ] **Design dark mode logo** (logo_dark.png)
  - [ ] Adapt main logo for dark backgrounds
  - [ ] Export at 200x60px
  - [ ] Ensure transparency
  - [ ] Optimize file size
  - [ ] Test on dark backgrounds

- [ ] **Create favicon** (favicon.png)
  - [ ] Design simplified icon
  - [ ] Export at 32x32px
  - [ ] Test at 16x16px scale
  - [ ] Optimize file size
  - [ ] Verify clarity at small size

- [ ] **Create login backgrounds** (optional)
  - [ ] Design light theme background (1920x1080px)
  - [ ] Design dark theme background (1920x1080px)
  - [ ] Optimize file sizes
  - [ ] Test at various screen sizes

### Phase 2: File Preparation

- [ ] **Verify file specifications**
  - [ ] Check dimensions are correct
  - [ ] Verify file formats (PNG/JPG)
  - [ ] Confirm transparency where needed
  - [ ] Check file sizes are optimized

- [ ] **Optimize files**
  - [ ] Run through TinyPNG or Squoosh
  - [ ] Verify quality after optimization
  - [ ] Ensure no visible artifacts

- [ ] **Organize files**
  - [ ] Name files correctly
  - [ ] Keep backup copies
  - [ ] Document any variations

### Phase 3: Deployment

- [ ] **Backup existing assets**
  - [ ] Copy current logo files
  - [ ] Store in safe location
  - [ ] Document original file names

- [ ] **Replace asset files**
  - [ ] Upload logo.png to assets/images/logo_icon/
  - [ ] Upload logo_dark.png to assets/images/logo_icon/
  - [ ] Upload favicon.png to assets/images/logo_icon/
  - [ ] Upload login backgrounds (if created)

- [ ] **Set file permissions**
  - [ ] Set 644 permissions on all files
  - [ ] Verify files are readable by web server

- [ ] **Clear caches**
  - [ ] Run: `php artisan config:clear`
  - [ ] Run: `php artisan cache:clear`
  - [ ] Run: `php artisan view:clear`
  - [ ] Clear browser cache

### Phase 4: Verification

- [ ] **Test logo display**
  - [ ] Check main logo on homepage
  - [ ] Check logo in user dashboard
  - [ ] Check logo in admin panel
  - [ ] Verify logo in emails (if applicable)

- [ ] **Test dark mode logo**
  - [ ] Enable dark mode
  - [ ] Verify logo switches correctly
  - [ ] Check contrast and visibility

- [ ] **Test favicon**
  - [ ] Check browser tab icon
  - [ ] Verify in bookmarks
  - [ ] Test on mobile devices

- [ ] **Test login backgrounds**
  - [ ] Check admin login page (light theme)
  - [ ] Check admin login page (dark theme)
  - [ ] Verify backgrounds load correctly

- [ ] **Cross-browser testing**
  - [ ] Test in Chrome/Edge
  - [ ] Test in Firefox
  - [ ] Test in Safari
  - [ ] Test on mobile browsers

---

## Verification Steps

### Visual Verification

1. **Homepage Check**
   - Navigate to: https://flow.clubemkt.digital
   - Verify: Logo displays correctly in header
   - Check: Logo is clear and not pixelated

2. **Dashboard Check**
   - Login as user
   - Navigate to: User dashboard
   - Verify: Logo displays in navigation
   - Check: Logo maintains quality

3. **Admin Panel Check**
   - Login as admin
   - Navigate to: Admin dashboard
   - Verify: Logo displays correctly
   - Check: Login page background (if updated)

4. **Favicon Check**
   - Open any page
   - Check: Browser tab shows FlowMkt icon
   - Verify: Icon is recognizable
   - Test: Create bookmark and check icon

5. **Dark Mode Check** (if applicable)
   - Enable dark mode
   - Verify: Logo switches to dark variant
   - Check: Logo is clearly visible
   - Test: Toggle between light/dark modes

### Technical Verification

1. **File Existence Check**
   ```bash
   ls -lh assets/images/logo_icon/logo.png
   ls -lh assets/images/logo_icon/logo_dark.png
   ls -lh assets/images/logo_icon/favicon.png
   ```

2. **File Size Check**
   ```bash
   du -h assets/images/logo_icon/*.png
   ```
   - Verify: Logos under 50KB
   - Verify: Favicon under 10KB

3. **Image Dimensions Check**
   ```bash
   file assets/images/logo_icon/logo.png
   ```
   - Verify: 200x60 pixels for logos
   - Verify: 32x32 pixels for favicon

4. **Transparency Check**
   - Open files in image editor
   - Verify: Alpha channel exists
   - Check: No white background

5. **Browser Console Check**
   - Open browser developer tools
   - Check: No 404 errors for logo files
   - Verify: Assets load successfully

### Performance Verification

1. **Page Load Speed**
   - Use browser dev tools Network tab
   - Check: Logo files load quickly
   - Verify: No significant delay

2. **Cache Verification**
   - Check: Assets are cached properly
   - Verify: Cache headers are set
   - Test: Reload page and check cache hit

3. **Mobile Performance**
   - Test on mobile device
   - Check: Assets load on mobile
   - Verify: No layout issues

---

## Troubleshooting

### Common Issues and Solutions

#### Issue: Logo not displaying

**Possible Causes**:
- File path incorrect
- File permissions wrong
- Cache not cleared
- File name mismatch

**Solutions**:
1. Verify file exists at correct path
2. Check file permissions (should be 644)
3. Clear Laravel cache: `php artisan cache:clear`
4. Clear browser cache (Ctrl+Shift+R)
5. Check file name matches exactly (case-sensitive)

#### Issue: Logo appears pixelated

**Possible Causes**:
- File dimensions too small
- Image over-compressed
- Browser scaling issues

**Solutions**:
1. Verify file is 200x60px (not smaller)
2. Re-export at higher quality
3. Check CSS doesn't force scaling
4. Use PNG format (not JPG for logos)

#### Issue: Favicon not updating

**Possible Causes**:
- Browser cache
- Favicon cached by browser
- File not replaced correctly

**Solutions**:
1. Hard refresh browser (Ctrl+Shift+R)
2. Clear browser cache completely
3. Try incognito/private window
4. Wait 5-10 minutes for browser to refresh
5. Check file was actually replaced

#### Issue: Transparent background shows as white

**Possible Causes**:
- File saved without alpha channel
- Wrong PNG format (PNG-8 instead of PNG-24)
- Background not actually transparent

**Solutions**:
1. Re-export as PNG-24 with alpha channel
2. Use image editor to verify transparency
3. Check "Save transparency" option when exporting
4. Use online tool to add transparency if needed

#### Issue: File size too large

**Possible Causes**:
- Image not optimized
- Too many colors
- Unnecessary metadata

**Solutions**:
1. Use TinyPNG or Squoosh to compress
2. Reduce color palette if possible
3. Remove metadata/EXIF data
4. Consider reducing dimensions slightly

---

## Maintenance and Updates

### When to Update Assets

- **Rebranding**: Major brand identity changes
- **Design Refresh**: Modernizing visual identity
- **New Products**: Adding product-specific logos
- **Seasonal**: Holiday or seasonal variations (optional)

### Version Control

Keep track of asset versions:

```
assets/images/logo_icon/
├── logo.png (current version)
├── logo_v1.png (backup - original)
├── logo_v2.png (backup - previous version)
└── CHANGELOG.md (document changes)
```

### Backup Strategy

1. **Before Replacement**:
   - Copy current files to backup folder
   - Document date and reason for change
   - Keep at least 2 previous versions

2. **After Replacement**:
   - Verify new assets work correctly
   - Keep backups for at least 30 days
   - Document any issues encountered

---

## Additional Resources

### Documentation Files

- **Logo Specifications**: `assets/images/logo_icon/LOGO_SPECIFICATIONS.md`
- **AI Generation Prompts**: `assets/images/logo_icon/AI_GENERATION_PROMPTS.md`
- **Login Background Guide**: `assets/admin/images/LOGIN_BACKGROUNDS_GUIDE.md`
- **Replacement Scripts**: 
  - `assets/images/logo_icon/replace_logos.sh`
  - `assets/admin/images/replace_login_backgrounds.sh`

### Related Documents

- **Design Document**: `.kiro/specs/flowmlkt-rebranding-localization/design.md`
- **Requirements**: `.kiro/specs/flowmlkt-rebranding-localization/requirements.md`
- **Tasks**: `.kiro/specs/flowmlkt-rebranding-localization/tasks.md`
- **Manual Verification**: `MANUAL_VERIFICATION_CHECKLIST.md`

### External Resources

- **Brand Guidelines**: (To be created)
- **Style Guide**: (To be created)
- **Marketing Assets**: (To be created)

---

## Support and Contact

For questions or issues with asset replacement:

1. Review this documentation thoroughly
2. Check the troubleshooting section
3. Consult the related documentation files
4. Test in a development environment first
5. Contact the development team if issues persist

---

**Document Version**: 1.0  
**Last Updated**: 2026-01-30  
**Maintained By**: FlowMkt Development Team

