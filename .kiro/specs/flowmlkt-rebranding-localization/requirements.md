# Requirements Document

## Introduction

This document outlines the requirements for rebranding and localizing a Laravel-based marketing automation application from "FlowZap/OvoWpp" to "FlowMkt" with complete Brazilian Portuguese (pt-BR) localization. The system is built with Laravel (PHP), Blade templates, React (Flow Builder), jQuery, and Bootstrap 5. The rebranding must eliminate all references to the old brand names while maintaining full application functionality, and the localization must provide a native Brazilian Portuguese user experience across all interfaces.

**Production Environment**: https://flow.clubemkt.digital (live application)

## Glossary

- **System**: The Laravel-based marketing automation application
- **Rebranding**: The process of replacing all references to "FlowZap", "OvoWpp", and "Ovo" with "FlowMkt"
- **Localization**: The process of translating and adapting the application interface to Brazilian Portuguese (pt-BR)
- **Translation_Key**: A key-value pair in Laravel's JSON translation files
- **Blade_Template**: Laravel's templating engine files with .blade.php extension
- **React_Component**: JavaScript/JSX files in the flow_builder directory
- **Language_File**: JSON or PHP files in core/resources/lang/ directory
- **Brand_Asset**: Logo, favicon, or other visual identity files
- **Configuration_File**: PHP files in core/config/ directory
- **View_File**: Blade template files in core/resources/views/ directory

## Requirements

### Requirement 1: Configuration Rebranding

**User Story:** As a system administrator, I want the application name updated in all configuration files, so that the system correctly identifies itself as "FlowMkt"

#### Acceptance Criteria

1. WHEN the application loads, THE System SHALL use "FlowMkt" as the APP_NAME value from the environment configuration
2. THE System SHALL update the APP_NAME in core/.env from "FLOW" to "FlowMkt"
3. THE System SHALL maintain the existing app.php configuration structure while reflecting the new brand name
4. THE System SHALL update the default locale to "pt" (Brazilian Portuguese) in core/config/app.php
5. THE System SHALL update the fallback locale to "pt" in core/config/app.php

### Requirement 2: Global Text Rebranding

**User Story:** As a developer, I want all code references to old brand names removed, so that the codebase is consistent with the new brand identity

#### Acceptance Criteria

1. WHEN searching the codebase, THE System SHALL contain zero occurrences of "FlowZap" in View_Files, Language_Files, and controller files
2. WHEN searching the codebase, THE System SHALL contain zero occurrences of "OvoWpp" in View_Files, Language_Files, and controller files
3. WHEN searching the codebase, THE System SHALL contain zero occurrences of standalone "Ovo" in View_Files, Language_Files, and controller files
4. IF a word contains "Ovo" as part of a larger word (e.g., "Novo", "Approval"), THEN THE System SHALL preserve that word unchanged
5. THE System SHALL replace "OvoPanel Version" with "FlowMkt Panel Version" in core/resources/views/admin/system/info.blade.php
6. THE System SHALL replace "ovowpp" with "flowmkt" in core/app/Http/Helpers/helpers.php systemDetails function
7. THE System SHALL rename the OvoForm component class to FlowMktForm in core/app/View/Components/OvoForm.php
8. THE System SHALL update all references to "x-ovo-form" to "x-flowmkt-form" in Blade_Templates
9. THE System SHALL update all references to "ovo-markdown.js" to "flowmkt-markdown.js" in View_Files and asset paths
10. THE System SHALL update the OvoSolution documentation URL to reference FlowMkt documentation at https://flow.clubemkt.digital

### Requirement 3: Brand Asset Replacement

**User Story:** As a user, I want to see FlowMkt branding in logos and favicons, so that the visual identity matches the new brand

#### Acceptance Criteria

1. THE System SHALL provide placeholder files for logo.png, logo_dark.png, and favicon.png in assets/images/logo_icon/
2. THE System SHALL maintain the same file dimensions and formats as the original brand assets
3. WHEN the logo files are replaced, THE System SHALL display the new FlowMkt branding across all pages
4. THE System SHALL check for additional logo files in assets/admin/images/ directory
5. IF login background images exist, THEN THE System SHALL update login-bg.png and login-dark.png with FlowMkt branding

### Requirement 4: SEO and Meta Information Update

**User Story:** As a marketing manager, I want SEO metadata updated to reflect FlowMkt branding, so that search engines index the correct brand information

#### Acceptance Criteria

1. THE System SHALL update meta titles in core/resources/views/partials/seo.blade.php to reference "FlowMkt"
2. THE System SHALL update meta descriptions to "FlowMkt - Sua plataforma de automação de marketing"
3. THE System SHALL update canonical URLs to reference https://flow.clubemkt.digital
4. THE System SHALL maintain proper SEO structure while updating brand-specific content
5. THE System SHALL update any hardcoded brand references in core/app/Providers/AppServiceProvider.php global view shares

### Requirement 5: Brazilian Portuguese Language File Creation

**User Story:** As a Brazilian user, I want the entire interface in professional Brazilian Portuguese, so that I can use the application in my native language

#### Acceptance Criteria

1. THE System SHALL create a complete pt.json file in core/resources/lang/ with all translation keys from en.json
2. WHEN a translation key is requested, THE System SHALL return professional Brazilian Portuguese text
3. THE System SHALL translate "Dashboard" to "Painel" in the pt.json file
4. THE System SHALL translate "Withdraw" to "Saque" in the pt.json file
5. THE System SHALL translate "Login" to "Entrar" in the pt.json file
6. THE System SHALL translate "Logout" to "Sair" in the pt.json file
7. THE System SHALL translate "Submit" to "Enviar" in the pt.json file
8. THE System SHALL translate "Delete" to "Excluir" in the pt.json file
9. THE System SHALL translate "Edit" to "Editar" in the pt.json file
10. THE System SHALL translate "Search" to "Buscar" in the pt.json file
11. THE System SHALL use Brazilian Portuguese conventions (e.g., "você" instead of "tu", "R$" for currency)
12. THE System SHALL create core/resources/lang/pt/ directory with auth.php, pagination.php, validation.php, and passwords.php files
13. THE System SHALL translate all Laravel framework messages to Brazilian Portuguese in the pt/ directory files

### Requirement 6: Blade Template Localization

**User Story:** As a developer, I want all hardcoded text in Blade templates wrapped with translation functions, so that the interface displays in the user's selected language

#### Acceptance Criteria

1. WHEN a Blade_Template contains hardcoded English text, THE System SHALL wrap it with {{ __('') }} or @lang('') directives
2. THE System SHALL add all new translation keys to core/resources/lang/pt.json
3. THE System SHALL prioritize templates in core/resources/views/admin/ for localization
4. THE System SHALL prioritize templates in core/resources/views/templates/basic/ for localization
5. THE System SHALL maintain proper Blade syntax and functionality after localization
6. IF a string is already wrapped with translation functions, THEN THE System SHALL ensure the corresponding key exists in pt.json

### Requirement 7: React Component Localization

**User Story:** As a user of the Flow Builder, I want all interface elements in Brazilian Portuguese, so that I can create flows in my native language

#### Acceptance Criteria

1. THE System SHALL create a Portuguese language dictionary object in core/resources/js/flow_builder/app.jsx
2. WHEN a React_Component renders text, THE System SHALL use the Portuguese dictionary for labels
3. THE System SHALL localize all node type labels in the Sidebar component
4. THE System SHALL localize all button labels in React_Components
5. THE System SHALL localize all placeholder text in React_Components
6. THE System SHALL localize all validation messages in React_Components
7. THE System SHALL maintain React component functionality after localization

### Requirement 8: JavaScript and jQuery Localization

**User Story:** As a user, I want notification messages and alerts in Brazilian Portuguese, so that system feedback is clear and understandable

#### Acceptance Criteria

1. WHEN the System displays a notification via notify() function, THE System SHALL show Brazilian Portuguese text
2. WHEN the System displays a toastr message, THE System SHALL show Brazilian Portuguese text
3. THE System SHALL localize notification messages in assets/global/js/global.js
4. THE System SHALL localize notification messages in assets/admin/js/main.js
5. THE System SHALL maintain JavaScript functionality after localization

### Requirement 9: Visual Identity CSS Updates

**User Story:** As a designer, I want the color scheme updated to match FlowMkt brand guidelines, so that the visual identity is consistent

#### Acceptance Criteria

1. THE System SHALL update primary brand colors in assets/templates/basic/css/color.php
2. THE System SHALL update secondary brand colors in assets/templates/basic/css/color.php
3. THE System SHALL update CSS variables in core/resources/views/templates/basic/layouts/app.blade.php
4. THE System SHALL check for brand color references in assets/admin/css/main.css
5. THE System SHALL maintain CSS functionality and layout after color updates

### Requirement 10: Functionality Preservation

**User Story:** As a quality assurance tester, I want all application features to work correctly after rebranding and localization, so that users experience no disruption

#### Acceptance Criteria

1. WHEN a user performs any action, THE System SHALL execute the action successfully regardless of language changes
2. THE System SHALL maintain all form submissions functionality after component renaming
3. THE System SHALL maintain all file upload functionality after asset replacement
4. THE System SHALL maintain all database operations after configuration changes
5. THE System SHALL maintain all routing functionality after view file updates
6. THE System SHALL maintain all authentication and authorization functionality
7. THE System SHALL maintain all API endpoints functionality
8. THE System SHALL maintain all webhook and notification functionality

### Requirement 11: Translation Completeness Verification

**User Story:** As a project manager, I want to verify that no English text remains visible to users, so that the localization is complete

#### Acceptance Criteria

1. THE System SHALL provide a method to identify untranslated strings in the interface
2. WHEN all translation keys are checked, THE System SHALL have corresponding Portuguese translations in pt.json
3. THE System SHALL have zero missing translation keys when the application runs in Portuguese mode
4. IF a translation key is missing, THEN THE System SHALL fall back to the English translation and log a warning

### Requirement 12: Asset File Management

**User Story:** As a system administrator, I want clear documentation of which asset files need replacement, so that the rebranding process is efficient

#### Acceptance Criteria

1. THE System SHALL document all logo file paths that require replacement
2. THE System SHALL document the required dimensions for each logo file
3. THE System SHALL document the supported file formats for brand assets
4. THE System SHALL provide a checklist of all asset files requiring updates
5. THE System SHALL maintain proper file permissions after asset replacement
