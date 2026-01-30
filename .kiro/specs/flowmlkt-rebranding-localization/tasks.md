 # Implementation Plan: FlowMkt Rebranding and Localization

## Overview

This implementation plan breaks down the rebranding and localization of the Laravel application into discrete, incremental steps. Each task builds on previous work and includes validation points to ensure functionality is maintained throughout the process. The plan follows a systematic approach: configuration → backend → views → frontend → assets → verification.

**Production Environment**: https://flow.clubemkt.digital (live application)

## Tasks

- [x] 1. Update configuration files for FlowMkt branding and Portuguese locale
  - Update core/.env to set APP_NAME=FlowMkt
  - Update core/.env to set APP_URL=https://flow.clubemkt.digital
  - Update core/config/app.php to set default locale to 'pt'
  - Update core/config/app.php to set fallback locale to 'pt'
  - Verify configuration loads correctly by checking config('app.name') and config('app.locale')
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_

- [ ]* 1.1 Write unit tests for configuration updates
  - Test that APP_NAME is 'FlowMkt'
  - Test that default locale is 'pt'
  - Test that fallback locale is 'pt'
  - _Requirements: 1.1, 1.4, 1.5_

- [x] 2. Rename OvoForm component to FlowMktForm
  - [x] 2.1 Rename core/app/View/Components/OvoForm.php to FlowMktForm.php
    - Update class name from OvoForm to FlowMktForm
    - Update render method to return 'components.flowmkt-form'
    - _Requirements: 2.7_
  
  - [x] 2.2 Rename core/resources/views/components/ovo-form.blade.php to flowmkt-form.blade.php
    - Keep file content unchanged, only rename the file
    - _Requirements: 2.7_
  
  - [x] 2.3 Update all Blade template references from x-ovo-form to x-flowmkt-form
    - Search in core/resources/views/ for all occurrences of "x-ovo-form"
    - Replace with "x-flowmkt-form"
    - Files to update: user/withdraw/preview.blade.php, user/payment/manual.blade.php, user/kyc/form.blade.php
    - _Requirements: 2.8_
  
  - [ ]* 2.4 Write unit tests for FlowMktForm component
    - Test that FlowMktForm class exists
    - Test that component renders with form data
    - Test that component view resolves correctly
    - _Requirements: 2.7_

- [x] 3. Checkpoint - Verify component renaming
  - Ensure all tests pass, ask the user if questions arise.

- [x] 4. Replace brand names in codebase
  - [x] 4.1 Update helper functions with new brand name
    - Update core/app/Http/Helpers/helpers.php systemDetails() function
    - Change $system['name'] from 'ovowpp' to 'flowmkt'
    - _Requirements: 2.6_
  
  - [x] 4.2 Update admin system info view
    - Update core/resources/views/admin/system/info.blade.php
    - Replace "OvoPanel Version" with "FlowMkt Panel Version"
    - Update x-admin.svg.ovo component reference if needed
    - _Requirements: 2.5_
  
  - [x] 4.3 Update asset references from ovo-markdown.js to flowmkt-markdown.js
    - Search for "ovo-markdown.js" in core/resources/views/
    - Replace with "flowmkt-markdown.js"
    - Rename the actual JS file if it exists in assets/
    - _Requirements: 2.9_
  
  - [x] 4.4 Update documentation URLs
    - Search for "ovosolution.com/ovowpp" in core/resources/views/
    - Replace with FlowMkt documentation URL (https://flow.clubemkt.digital)
    - Update core/resources/views/admin/setting/pusher_configuration.blade.php
    - _Requirements: 2.10_
  
  - [ ]* 4.5 Write property test for brand name elimination
    - **Property 1: Brand Name Elimination**
    - **Validates: Requirements 2.1, 2.2, 2.3**
    - Test that zero occurrences of "FlowZap", "OvoWpp", or standalone "Ovo" exist in views, language files, and controllers
  
  - [ ]* 4.6 Write property test for partial word preservation
    - **Property 2: Partial Word Preservation**
    - **Validates: Requirements 2.4**
    - Test that words like "Novo", "Approval" are preserved after replacement

- [x] 5. Create Brazilian Portuguese translation files
  - [x] 5.1 Create complete pt.json translation file
    - Copy core/resources/lang/en.json structure
    - Translate all keys to professional Brazilian Portuguese
    - Include key translations: Dashboard→Painel, Login→Entrar, Logout→Sair, Submit→Enviar, Delete→Excluir, Edit→Editar, Search→Buscar, Withdraw→Saque
    - Use Brazilian conventions (você, R$)
    - _Requirements: 5.1, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 5.9, 5.10, 5.11_
  
  - [x] 5.2 Create Laravel framework translation files
    - Create core/resources/lang/pt/ directory
    - Create auth.php with authentication messages in Portuguese
    - Create pagination.php with pagination messages in Portuguese
    - Create validation.php with validation messages in Portuguese
    - Create passwords.php with password reset messages in Portuguese
    - _Requirements: 5.12, 5.13_
  
  - [ ]* 5.3 Write property test for translation key completeness
    - **Property 5: Translation Key Completeness**
    - **Validates: Requirements 5.1, 5.13, 6.2, 6.6, 11.2**
    - Test that all translation keys used in templates exist in pt.json with non-empty values
  
  - [ ]* 5.4 Write unit tests for specific translations
    - Test that key translations exist (Dashboard, Login, Logout, etc.)
    - Test that translations are not empty
    - _Requirements: 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 5.9, 5.10_

- [x] 6. Checkpoint - Verify translation files
  - Ensure all tests pass, ask the user if questions arise.

- [x] 7. Localize Blade templates
  - [x] 7.1 Localize admin templates
    - Wrap hardcoded text in core/resources/views/admin/ with {{ __('') }} or @lang('')
    - Add new translation keys to pt.json
    - Priority files: system/info.blade.php, dashboard.blade.php, user management views
    - _Requirements: 6.1, 6.2, 6.3_
  
  - [x] 7.2 Localize user templates
    - Wrap hardcoded text in core/resources/views/templates/basic/ with {{ __('') }} or @lang('')
    - Add new translation keys to pt.json
    - Priority files: layouts, dashboard, forms
    - _Requirements: 6.1, 6.2, 6.4_
  
  - [ ]* 7.3 Write property test for Blade template compilation
    - **Property 7: Blade Template Compilation**
    - **Validates: Requirements 6.5**
    - Test that all Blade templates compile without syntax errors
  
  - [ ]* 7.4 Write property test for translation key usage
    - **Property 6: Translation Fallback Behavior**
    - **Validates: Requirements 6.6, 11.3, 11.4**
    - Test that missing translation keys fall back gracefully without errors

- [x] 8. Localize React Flow Builder components
  - [x] 8.1 Create Portuguese translation dictionary in React
    - Create translations object in core/resources/js/flow_builder/app.jsx
    - Include translations for all node types, actions, and UI elements
    - Create translation helper function t(key)
    - _Requirements: 7.1_
  
  - [x] 8.2 Update Sidebar component with Portuguese labels
    - Update core/resources/js/flow_builder/nodes/Sidebar.jsx
    - Replace hardcoded node type labels with t() function calls
    - _Requirements: 7.3_
  
  - [x] 8.3 Update all node components with Portuguese text
    - Update button labels, placeholders, and validation messages in all node files
    - Files: SendTextMessageNode.jsx, SendImageNode.jsx, SendVideoNode.jsx, SendAudioNode.jsx, SendDocumentNode.jsx, SendButtonNode.jsx, SendListMessageNode.jsx, SendLocationNode.jsx, SendTemplateNode.jsx
    - _Requirements: 7.4, 7.5, 7.6_
  
  - [ ]* 8.4 Write property test for React component localization
    - **Property 8: React Component Localization**
    - **Validates: Requirements 7.2, 7.4, 7.5, 7.6**
    - Test that React components use translation dictionary instead of hardcoded strings
  
  - [ ]* 8.5 Write property test for React component functionality
    - **Property 9: React Component Functionality**
    - **Validates: Requirements 7.7**
    - Test that React components render and handle interactions correctly after localization

- [x] 9. Localize JavaScript and jQuery files
  - [x] 9.1 Localize global JavaScript notifications
    - Update assets/global/js/global.js
    - Replace English notification messages with Portuguese
    - Update notify() and toastr() calls
    - _Requirements: 8.3_
  
  - [x] 9.2 Localize admin JavaScript notifications
    - Update assets/admin/js/main.js
    - Replace English notification messages with Portuguese
    - Update notify() and toastr() calls
    - _Requirements: 8.4_
  
  - [ ]* 9.3 Write property test for JavaScript notification localization
    - **Property 10: JavaScript Notification Localization**
    - **Validates: Requirements 8.1, 8.2**
    - Test that all notify() and toastr() calls use Portuguese text
  
  - [ ]* 9.4 Write property test for JavaScript functionality preservation
    - **Property 11: JavaScript Functionality Preservation**
    - **Validates: Requirements 8.5**
    - Test that JavaScript functions execute without errors after localization

- [x] 10. Checkpoint - Verify localization completeness
  - Ensure all tests pass, ask the user if questions arise.

- [x] 11. Replace brand assets
  - [x] 11.1 Prepare FlowMkt logo files
    - Create logo.png (200x60px, PNG with transparency)
    - Create logo_dark.png (200x60px, PNG with transparency)
    - Create favicon.png (32x32px or 16x16px)
    - _Requirements: 3.1, 3.2_
  
  - [x] 11.2 Replace logo files in assets directory
    - Replace assets/images/logo_icon/logo.png
    - Replace assets/images/logo_icon/logo_dark.png
    - Replace assets/images/logo_icon/favicon.png
    - Set file permissions to 644
    - _Requirements: 3.1, 12.5_
  
  - [x] 11.3 Check and update admin login backgrounds
    - Check if assets/admin/images/login-bg.png exists
    - Check if assets/admin/images/login-dark.png exists
    - Update with FlowMkt branding if they exist
    - _Requirements: 3.4, 3.5_
  
  - [ ]* 11.4 Write unit tests for asset file existence
    - Test that logo.png exists and is readable
    - Test that logo_dark.png exists and is readable
    - Test that favicon.png exists and is readable
    - _Requirements: 3.1_

- [x] 12. Update SEO and meta information
  - [x] 12.1 Update SEO meta tags
    - Update core/resources/views/partials/seo.blade.php
    - Change meta titles to reference "FlowMkt"
    - Change meta descriptions to "FlowMkt - Sua plataforma de automação de marketing"
    - Update canonical URLs to https://flow.clubemkt.digital
    - _Requirements: 4.1, 4.2_
  
  - [x] 12.2 Update AppServiceProvider view shares
    - Check core/app/Providers/AppServiceProvider.php for hardcoded brand references
    - Update any global view shares with new brand name
    - _Requirements: 4.4_
  
  - [ ]* 12.3 Write unit tests for SEO updates
    - Test that SEO partial contains "FlowMkt"
    - Test that meta description is in Portuguese
    - _Requirements: 4.1, 4.2, 4.3_

- [x] 13. Update brand colors in CSS
  - [x] 13.1 Update color configuration
    - Update assets/templates/basic/css/color.php with FlowMkt brand colors
    - Update primary and secondary color variables
    - _Requirements: 9.1, 9.2_
  
  - [x] 13.2 Update CSS variables in layout
    - Update core/resources/views/templates/basic/layouts/app.blade.php
    - Update CSS variable definitions for brand colors
    - _Requirements: 9.3_
  
  - [x] 13.3 Check admin CSS for color references
    - Review assets/admin/css/main.css for hardcoded brand colors
    - Update any brand-specific color references
    - _Requirements: 9.4_

- [x] 14. Comprehensive functionality testing
  - [x]* 14.1 Write property test for form functionality preservation
    - **Property 12: Form Functionality Preservation**
    - **Validates: Requirements 10.1, 10.2**
    - Test that form submissions work correctly with FlowMktForm component
  
  - [x]* 14.2 Write property test for data operation preservation
    - **Property 13: Data Operation Preservation**
    - **Validates: Requirements 10.3, 10.4, 10.5**
    - Test that database operations, file uploads, and routing work correctly
  
  - [x]* 14.3 Write property test for external integration preservation
    - **Property 14: External Integration Preservation**
    - **Validates: Requirements 10.6, 10.7, 10.8**
    - Test that authentication, API endpoints, and webhooks function correctly
  
  - [x]* 14.4 Write integration tests for complete user workflows
    - Test user registration and login in Portuguese
    - Test form submission with FlowMktForm
    - Test flow builder creation and editing
    - Test file upload and asset display
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8_

- [x] 15. Final verification and documentation
  - [x] 15.1 Create translation verification script
    - Create script to identify untranslated strings
    - Check for missing translation keys
    - Generate report of translation completeness
    - _Requirements: 11.1_
  
  - [x] 15.2 Run comprehensive test suite
    - Run all unit tests
    - Run all property tests
    - Run all integration tests
    - Verify zero test failures
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8_
  
  - [x] 15.3 Clear application cache
    - Run php artisan config:clear
    - Run php artisan cache:clear
    - Run php artisan view:clear
    - Run php artisan route:clear
    - _Requirements: 10.1_
  
  - [x] 15.4 Manual verification checklist
    - Verify all pages display FlowMkt branding
    - Verify all text is in Brazilian Portuguese
    - Verify no English text visible to users
    - Verify forms submit successfully
    - Verify file uploads work correctly
    - Verify notifications display in Portuguese
    - Verify Flow Builder interface is fully localized
    - Verify SEO meta tags show FlowMkt branding
    - _Requirements: 3.3, 6.1, 10.1, 10.2, 10.3, 11.3_
  
  - [x] 15.5 Document asset replacement requirements
    - Create documentation for logo file specifications
    - Document required dimensions and formats
    - Create checklist of all asset files requiring updates
    - _Requirements: 12.1, 12.2, 12.3, 12.4_

- [x] 16. Final checkpoint - Complete verification
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- Property tests validate universal correctness properties across all inputs
- Unit tests validate specific examples and edge cases
- The implementation follows a systematic order: configuration → backend → views → frontend → assets → verification
- All changes maintain backward compatibility until fully deployed
- Cache clearing is essential after configuration and view changes
- Manual verification is required for visual elements and user experience
