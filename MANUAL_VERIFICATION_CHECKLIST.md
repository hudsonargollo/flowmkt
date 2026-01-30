# FlowMkt Manual Verification Checklist

## Overview

This checklist provides a comprehensive guide for manually verifying that the FlowMkt rebranding and localization has been successfully implemented. Complete each section and check off items as you verify them.

**Production URL**: https://flow.clubemkt.digital

---

## Pre-Verification Steps

Before starting manual verification:

- [ ] All automated tests have passed
- [ ] Application cache has been cleared
- [ ] Web server has been restarted (if applicable)
- [ ] Browser cache has been cleared
- [ ] Using an incognito/private browsing window for testing

---

## 1. Branding Verification

### 1.1 Logo and Favicon

**What to Check**: Visual brand assets display correctly

- [ ] **Main logo** displays "FlowMkt" branding on all pages
  - Check: Homepage, Dashboard, Admin panel
  - Location: Header/navigation bar
  
- [ ] **Dark mode logo** displays correctly (if dark mode is available)
  - Toggle dark mode and verify logo switches
  
- [ ] **Favicon** shows FlowMkt icon in browser tab
  - Check: All pages
  - Verify: Icon is visible and not broken
  
- [ ] **Login page background** shows FlowMkt branding
  - Check: `/login` and `/admin/login`
  - Verify: No old brand imagery visible

**Notes**: _____________________________________________________

### 1.2 Text References

**What to Check**: No old brand names appear anywhere

- [ ] **No "FlowZap" references** visible to users
  - Search pages for "FlowZap" text
  - Check: Headers, footers, error messages
  
- [ ] **No "OvoWpp" references** visible to users
  - Search pages for "OvoWpp" text
  - Check: Documentation, help text
  
- [ ] **No standalone "Ovo" references** visible to users
  - Verify: "Novo" (new) and similar words are preserved
  - Check: Button labels, menu items
  
- [ ] **System info page** shows "FlowMkt Panel Version"
  - Navigate to: Admin → System → Info
  - Verify: Version label uses "FlowMkt"

**Notes**: _____________________________________________________

### 1.3 SEO and Meta Tags

**What to Check**: Search engine metadata reflects FlowMkt

- [ ] **Page titles** include "FlowMkt"
  - Check: Browser tab title on multiple pages
  - View source: `<title>` tag content
  
- [ ] **Meta description** is in Portuguese
  - View source: `<meta name="description">` tag
  - Expected: "FlowMkt - Sua plataforma de automação de marketing"
  
- [ ] **Canonical URLs** point to flow.clubemkt.digital
  - View source: `<link rel="canonical">` tag
  - Verify: Correct domain
  
- [ ] **Open Graph tags** show FlowMkt branding
  - View source: `<meta property="og:title">` and similar
  - Check: Social media preview (use debugger tools)

**Notes**: _____________________________________________________

---

## 2. Localization Verification

### 2.1 General Interface

**What to Check**: All text is in Brazilian Portuguese

- [ ] **Navigation menu** is in Portuguese
  - Check: All menu items, dropdowns
  - Examples: "Painel" (Dashboard), "Sair" (Logout)
  
- [ ] **Button labels** are in Portuguese
  - Check: "Enviar" (Submit), "Excluir" (Delete), "Editar" (Edit)
  - Verify: All pages with forms
  
- [ ] **Form labels** are in Portuguese
  - Check: Login form, registration form, settings forms
  - Verify: Field labels, placeholders, help text
  
- [ ] **Error messages** are in Portuguese
  - Trigger validation errors
  - Check: Form validation, 404 pages, error pages
  
- [ ] **Success messages** are in Portuguese
  - Complete actions (save, delete, update)
  - Check: Toast notifications, alert messages
  
- [ ] **No English text** visible to end users
  - Scan all pages carefully
  - Exception: Technical terms that are commonly used in English

**Notes**: _____________________________________________________

### 2.2 Admin Panel

**What to Check**: Admin interface is fully localized

- [ ] **Admin dashboard** displays in Portuguese
  - Navigate to: `/admin`
  - Check: Widget titles, statistics labels
  
- [ ] **Admin menu** is in Portuguese
  - Check: All menu items and sub-items
  - Verify: Settings, Users, Reports sections
  
- [ ] **Admin forms** are in Portuguese
  - Check: User management, settings forms
  - Verify: Labels, placeholders, validation messages
  
- [ ] **Admin tables** have Portuguese headers
  - Check: User lists, transaction lists
  - Verify: Column headers, action buttons
  
- [ ] **Admin notifications** are in Portuguese
  - Perform admin actions
  - Check: Success/error notifications

**Notes**: _____________________________________________________

### 2.3 User Dashboard

**What to Check**: User-facing interface is fully localized

- [ ] **User dashboard** displays in Portuguese
  - Navigate to: `/user/dashboard`
  - Check: Widget titles, menu items
  
- [ ] **User profile** forms are in Portuguese
  - Navigate to: Profile settings
  - Check: All form fields and labels
  
- [ ] **Transaction history** is in Portuguese
  - Check: Table headers, status labels
  - Verify: Date formats use Brazilian conventions
  
- [ ] **Withdrawal/Deposit** forms are in Portuguese
  - Navigate to: Saque (Withdraw) section
  - Check: All form fields, instructions

**Notes**: _____________________________________________________

### 2.4 Flow Builder

**What to Check**: React-based Flow Builder is localized

- [ ] **Flow Builder sidebar** is in Portuguese
  - Navigate to: Flow Builder
  - Check: Node type labels
  - Examples: "Enviar Mensagem de Texto", "Enviar Imagem"
  
- [ ] **Flow Builder buttons** are in Portuguese
  - Check: "Salvar Fluxo" (Save Flow), "Adicionar Nó" (Add Node)
  - Verify: All toolbar buttons
  
- [ ] **Node configuration forms** are in Portuguese
  - Click on different node types
  - Check: Form labels, placeholders
  - Examples: "Digite a mensagem", "Selecionar arquivo"
  
- [ ] **Flow Builder validation** messages are in Portuguese
  - Trigger validation errors
  - Check: Error messages display in Portuguese
  
- [ ] **Flow Builder tooltips** are in Portuguese
  - Hover over elements
  - Check: Tooltip text

**Notes**: _____________________________________________________

### 2.5 Notifications and Alerts

**What to Check**: JavaScript notifications are localized

- [ ] **Toast notifications** are in Portuguese
  - Perform various actions
  - Check: Success, error, warning toasts
  
- [ ] **Confirmation dialogs** are in Portuguese
  - Trigger delete actions
  - Check: "Tem certeza que deseja excluir?"
  
- [ ] **Alert messages** are in Portuguese
  - Check: System alerts, warnings
  - Verify: All alert types

**Notes**: _____________________________________________________

---

## 3. Functionality Verification

### 3.1 Forms

**What to Check**: Forms work correctly with FlowMktForm component

- [ ] **Login form** submits successfully
  - Test: Valid and invalid credentials
  - Verify: Redirects work, errors display
  
- [ ] **Registration form** submits successfully
  - Test: Create new user account
  - Verify: Validation works, success message displays
  
- [ ] **Profile update form** submits successfully
  - Test: Update user profile
  - Verify: Changes are saved
  
- [ ] **KYC form** submits successfully (if applicable)
  - Test: Submit KYC information
  - Verify: Form data is processed
  
- [ ] **Deposit form** submits successfully
  - Test: Initiate deposit
  - Verify: Gateway selection works
  
- [ ] **Withdrawal form** submits successfully
  - Test: Request withdrawal
  - Verify: Form validation and submission

**Notes**: _____________________________________________________

### 3.2 File Uploads

**What to Check**: File upload functionality is preserved

- [ ] **Profile image upload** works
  - Test: Upload profile picture
  - Verify: Image displays correctly
  
- [ ] **Document upload** works (KYC, attachments)
  - Test: Upload various file types
  - Verify: Files are accepted and stored
  
- [ ] **Flow Builder media upload** works
  - Test: Upload images, videos, documents in Flow Builder
  - Verify: Media displays in preview

**Notes**: _____________________________________________________

### 3.3 Flow Builder Functionality

**What to Check**: Flow Builder operates correctly

- [ ] **Create new flow** works
  - Test: Create a new flow
  - Verify: Flow is saved
  
- [ ] **Add nodes** works
  - Test: Drag and drop different node types
  - Verify: Nodes appear on canvas
  
- [ ] **Configure nodes** works
  - Test: Set up node parameters
  - Verify: Configuration is saved
  
- [ ] **Connect nodes** works
  - Test: Create connections between nodes
  - Verify: Connections are maintained
  
- [ ] **Save flow** works
  - Test: Save flow changes
  - Verify: Changes persist after reload
  
- [ ] **Delete flow** works
  - Test: Delete a flow
  - Verify: Confirmation dialog appears, flow is deleted

**Notes**: _____________________________________________________

### 3.4 Data Operations

**What to Check**: Database operations work correctly

- [ ] **Create operations** work
  - Test: Create new records (users, flows, contacts)
  - Verify: Records appear in database
  
- [ ] **Read operations** work
  - Test: View lists and details
  - Verify: Data displays correctly
  
- [ ] **Update operations** work
  - Test: Edit existing records
  - Verify: Changes are saved
  
- [ ] **Delete operations** work
  - Test: Delete records
  - Verify: Records are removed

**Notes**: _____________________________________________________

### 3.5 Authentication and Authorization

**What to Check**: Security features are preserved

- [ ] **User login** works
  - Test: Login with valid credentials
  - Verify: Session is created
  
- [ ] **User logout** works
  - Test: Logout
  - Verify: Session is destroyed, redirect to login
  
- [ ] **Admin login** works
  - Test: Admin login
  - Verify: Admin panel is accessible
  
- [ ] **Password reset** works
  - Test: Request password reset
  - Verify: Email is sent, reset link works
  
- [ ] **Access control** works
  - Test: Access restricted pages without permission
  - Verify: Redirected or denied access

**Notes**: _____________________________________________________

---

## 4. Visual and UX Verification

### 4.1 Color Scheme

**What to Check**: Brand colors are applied correctly

- [ ] **Primary color** matches FlowMkt brand
  - Check: Buttons, links, highlights
  - Verify: Consistent across all pages
  
- [ ] **Secondary color** matches FlowMkt brand
  - Check: Backgrounds, borders
  - Verify: Proper contrast and readability
  
- [ ] **Color consistency** across themes
  - Test: Light and dark modes (if available)
  - Verify: Colors work in both themes

**Notes**: _____________________________________________________

### 4.2 Layout and Design

**What to Check**: Layout is intact after changes

- [ ] **Responsive design** works
  - Test: Desktop, tablet, mobile views
  - Verify: Layout adapts properly
  
- [ ] **Navigation** is functional
  - Test: All menu items, breadcrumbs
  - Verify: Links work, active states display
  
- [ ] **Modals and popups** display correctly
  - Test: Open various modals
  - Verify: Content is visible, close buttons work

**Notes**: _____________________________________________________

---

## 5. Browser Compatibility

**What to Check**: Application works across browsers

- [ ] **Chrome/Edge** (Chromium-based)
  - Test: All critical features
  - Verify: No console errors
  
- [ ] **Firefox**
  - Test: All critical features
  - Verify: No console errors
  
- [ ] **Safari** (if on Mac)
  - Test: All critical features
  - Verify: No console errors

**Notes**: _____________________________________________________

---

## 6. Performance and Loading

**What to Check**: Application performance is acceptable

- [ ] **Page load times** are reasonable
  - Test: Load various pages
  - Verify: No significant delays
  
- [ ] **Assets load correctly**
  - Check: Images, CSS, JavaScript
  - Verify: No 404 errors in console
  
- [ ] **No JavaScript errors** in console
  - Open browser console
  - Navigate through application
  - Verify: No red errors

**Notes**: _____________________________________________________

---

## 7. Edge Cases and Error Handling

**What to Check**: Error scenarios are handled gracefully

- [ ] **404 page** displays in Portuguese
  - Navigate to: Non-existent URL
  - Verify: Error page is localized
  
- [ ] **500 error page** displays in Portuguese (if testable)
  - Verify: Error page is localized
  
- [ ] **Form validation errors** display in Portuguese
  - Submit invalid forms
  - Verify: Error messages are clear and localized
  
- [ ] **Network errors** are handled
  - Test: Disconnect network during action
  - Verify: Error message displays

**Notes**: _____________________________________________________

---

## 8. Final Checks

### 8.1 Documentation

- [ ] **Help text** is in Portuguese
  - Check: Tooltips, info icons, help pages
  
- [ ] **API documentation** is updated (if applicable)
  - Check: API docs reference FlowMkt
  
- [ ] **User guides** are updated (if applicable)
  - Check: Documentation references FlowMkt

**Notes**: _____________________________________________________

### 8.2 External Integrations

- [ ] **Email notifications** use FlowMkt branding
  - Test: Trigger email notification
  - Check: Email subject, body, footer
  
- [ ] **SMS notifications** are in Portuguese (if applicable)
  - Test: Trigger SMS notification
  - Check: Message content
  
- [ ] **Webhooks** function correctly
  - Test: Trigger webhook events
  - Verify: Payloads are sent

**Notes**: _____________________________________________________

---

## Verification Summary

### Statistics

- **Total Items**: 100+
- **Completed**: _____
- **Failed**: _____
- **Not Applicable**: _____

### Critical Issues Found

List any critical issues that must be fixed before deployment:

1. _____________________________________________________
2. _____________________________________________________
3. _____________________________________________________

### Minor Issues Found

List any minor issues that can be addressed later:

1. _____________________________________________________
2. _____________________________________________________
3. _____________________________________________________

### Overall Assessment

- [ ] ✅ **PASSED**: All critical items verified, ready for production
- [ ] ⚠️ **PASSED WITH WARNINGS**: Minor issues found, but acceptable for production
- [ ] ❌ **FAILED**: Critical issues found, must be fixed before deployment

### Sign-Off

**Verified By**: _____________________  
**Date**: _____________________  
**Signature**: _____________________

---

## Next Steps

After completing this checklist:

1. **If PASSED**: Proceed with production deployment
2. **If PASSED WITH WARNINGS**: Document minor issues for future fixes
3. **If FAILED**: Address critical issues and re-verify

---

**Document Version**: 1.0  
**Last Updated**: 2026-01-30  
**Related Documents**: 
- Design Document: `.kiro/specs/flowmlkt-rebranding-localization/design.md`
- Requirements: `.kiro/specs/flowmlkt-rebranding-localization/requirements.md`
- Tasks: `.kiro/specs/flowmlkt-rebranding-localization/tasks.md`
