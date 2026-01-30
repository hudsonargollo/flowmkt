# FlowMkt Logo Specifications

This document outlines the specifications for FlowMkt brand assets that need to be created and placed in this directory.

## Required Logo Files

### 1. logo.png
- **Purpose**: Main header logo for light backgrounds
- **Format**: PNG with transparency
- **Recommended Size**: 200x60px
- **Color**: Should work well on light/white backgrounds
- **Usage**: Used in main application header, admin panel, and user interface

### 2. logo_dark.png
- **Purpose**: Main header logo for dark backgrounds
- **Format**: PNG with transparency
- **Recommended Size**: 200x60px
- **Color**: Should work well on dark backgrounds
- **Usage**: Used when dark mode is enabled or on dark background sections

### 3. favicon.png
- **Purpose**: Browser tab icon
- **Format**: PNG or ICO
- **Size**: 32x32px or 16x16px
- **Usage**: Displayed in browser tabs, bookmarks, and browser history

## Design Guidelines

### Logo Design
- Keep the design simple and recognizable at small sizes
- Ensure good contrast with both light and dark backgrounds
- Use the FlowMkt brand colors (to be defined in CSS)
- Include the "FlowMkt" text or brand mark
- Maintain transparency for non-logo areas

### Favicon Design
- Should be a simplified version of the main logo or brand mark
- Must be recognizable at 16x16px size
- Use high contrast colors
- Avoid fine details that won't be visible at small sizes

## File Permissions

After placing the files, ensure they have the correct permissions:
```bash
chmod 644 logo.png
chmod 644 logo_dark.png
chmod 644 favicon.png
```

## Verification Checklist

- [ ] logo.png created with correct dimensions (200x60px)
- [ ] logo.png has transparency
- [ ] logo.png works well on light backgrounds
- [ ] logo_dark.png created with correct dimensions (200x60px)
- [ ] logo_dark.png has transparency
- [ ] logo_dark.png works well on dark backgrounds
- [ ] favicon.png created with correct size (32x32px or 16x16px)
- [ ] favicon.png is recognizable at small size
- [ ] All files have 644 permissions
- [ ] Files are optimized for web (compressed)

## Additional Assets

### Admin Login Backgrounds (Optional)
If you want to customize the admin login page backgrounds:

#### login-bg.png
- **Location**: assets/admin/images/login-bg.png
- **Purpose**: Background for admin login page (light theme)
- **Recommended Size**: 1920x1080px or larger
- **Format**: PNG or JPG

#### login-dark.png
- **Location**: assets/admin/images/login-dark.png
- **Purpose**: Background for admin login page (dark theme)
- **Recommended Size**: 1920x1080px or larger
- **Format**: PNG or JPG

## Tools for Creating Logos

### Online Tools
- Canva (https://www.canva.com) - Easy-to-use design tool
- Figma (https://www.figma.com) - Professional design tool
- Adobe Express (https://www.adobe.com/express) - Quick logo creation

### Desktop Tools
- Adobe Photoshop - Professional image editing
- GIMP - Free alternative to Photoshop
- Inkscape - Vector graphics editor (export to PNG)

### Favicon Generators
- Favicon.io (https://favicon.io) - Generate favicons from text or images
- RealFaviconGenerator (https://realfavicongenerator.net) - Comprehensive favicon generator

## Implementation Steps

1. Create or obtain the FlowMkt logo design
2. Export logo.png (200x60px, PNG with transparency)
3. Export logo_dark.png (200x60px, PNG with transparency, optimized for dark backgrounds)
4. Create favicon.png (32x32px or 16x16px)
5. Replace the existing files in this directory
6. Set file permissions to 644
7. Clear browser cache and Laravel cache
8. Verify logos display correctly across the application

## Notes

- The current placeholder files are from the previous brand (OvoWpp/FlowZap)
- Replacing these files will immediately update the branding across the entire application
- Make sure to test on both light and dark backgrounds
- Consider creating multiple favicon sizes for better browser compatibility
- Keep backup copies of your logo files in a safe location
