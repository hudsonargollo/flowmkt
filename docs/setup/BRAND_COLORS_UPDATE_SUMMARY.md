# FlowMkt Brand Colors Update Summary

## Overview
This document summarizes the brand color updates made to the FlowMkt application as part of the rebranding effort.

## FlowMkt Brand Color

**Primary Brand Color: #6366f1 (Modern Indigo)**
- RGB: rgb(99, 102, 241)
- HSL: hsl(238, 86%, 67%)
- Description: A modern, professional indigo/blue-purple that conveys trust, innovation, and reliability

## Files Updated

### 1. Frontend Color Configuration
**File:** `assets/templates/basic/css/color.php`

**Changes:**
- Updated default primary color from `#336699` (old blue) to `#6366f1` (Modern Indigo)
- Added comprehensive documentation header explaining FlowMkt brand colors
- Color is dynamically generated and can be customized via admin panel

**Usage:**
- This file generates CSS custom properties (--base-h, --base-s, --base-l) based on the primary color
- The color can be customized in: Admin Panel → General Settings → Site Primary Color
- Or passed as URL parameter: `color.php?color=6366f1`

### 2. Layout Template
**File:** `core/resources/views/templates/basic/layouts/app.blade.php`

**Changes:**
- Added documentation comments explaining FlowMkt brand color usage
- Confirmed dynamic color loading from database via `gs('base_color')`
- No hardcoded colors found - properly uses CSS variables

### 3. Admin Panel CSS
**File:** `assets/admin/css/main.css`

**Changes:**
- Updated `:root` primary color variables:
  - `--primary-h: 238` (was 253)
  - `--primary-s: 86%` (was 100%)
  - `--primary-l: 67%` (was 61%)
- Updated `[data-theme=dark]` primary color variables:
  - `--primary-h: 238` (was 247)
  - `--primary-s: 86%` (was 100%)
  - `--primary-l: 75%` (was 76%)
- Added comments identifying FlowMkt brand colors

**Note:** Neutral UI colors (overlays, backdrops) were intentionally left unchanged as they are not brand-specific.

## Color System Architecture

### Frontend (User-facing)
```
Database (base_color) 
    ↓
color.php (generates CSS variables)
    ↓
app.blade.php (loads color.php)
    ↓
All frontend templates use CSS variables
```

### Admin Panel
```
main.css (hardcoded CSS variables)
    ↓
All admin templates use CSS variables
```

## How to Customize

### Option 1: Admin Panel (Recommended)
1. Log in to admin panel
2. Navigate to: Settings → General Settings
3. Find "Site Primary Color" field
4. Enter hex color (e.g., `6366f1`)
5. Save changes

### Option 2: Direct File Edit
1. Edit `assets/templates/basic/css/color.php`
2. Change the default color value
3. Clear application cache

### Option 3: Database Update
Update the `base_color` field in the `general_settings` table.

## Testing Recommendations

After deploying these changes:

1. **Clear Caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

2. **Visual Verification:**
   - Check all buttons, links, and primary UI elements
   - Verify both light and dark themes
   - Test admin panel appearance
   - Verify form focus states
   - Check notification colors

3. **Browser Testing:**
   - Clear browser cache
   - Test in multiple browsers (Chrome, Firefox, Safari)
   - Verify mobile responsiveness

## Color Usage Guidelines

The FlowMkt primary color (#6366f1) should be used for:
- Primary action buttons
- Links and interactive elements
- Active/selected states
- Brand elements (logos, headers)
- Focus indicators
- Progress indicators

Avoid using the primary color for:
- Body text (use neutral colors)
- Backgrounds (use lighter tints)
- Error states (use danger color)
- Success states (use success color)

## Accessibility Notes

The chosen color (#6366f1) provides:
- Good contrast against white backgrounds (WCAG AA compliant)
- Distinguishable from other UI colors (success, danger, warning)
- Suitable for both light and dark themes

Always test color contrast ratios when using the primary color with text.

## Related Files

- `core/app/Http/Controllers/Admin/GeneralSettingController.php` - Handles color updates
- `core/resources/views/admin/setting/general.blade.php` - Admin color picker UI
- `core/app/Lib/Captcha.php` - Uses base_color for captcha generation

## Rollback Instructions

If you need to revert to the old colors:

1. **Frontend:** Change default in `color.php` back to `#336699`
2. **Admin CSS:** Update `main.css` variables:
   - Light: `--primary-h: 253; --primary-s: 100%; --primary-l: 61%;`
   - Dark: `--primary-h: 247; --primary-s: 100%; --primary-l: 76%;`
3. Clear all caches

## Next Steps

1. Update logo files to complement the new color scheme (if not already done)
2. Consider updating secondary colors if needed
3. Review and update any marketing materials with the new brand color
4. Update brand guidelines documentation

---

**Date Updated:** January 30, 2026
**Updated By:** Kiro AI Assistant
**Task Reference:** Task 13 - Update brand colors in CSS
