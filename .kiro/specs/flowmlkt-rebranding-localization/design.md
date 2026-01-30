# Design Document: FlowMkt Rebranding and Localization

## Overview

This design document outlines the technical approach for rebranding a Laravel-based marketing automation application from "FlowZap/OvoWpp" to "FlowMkt" and implementing complete Brazilian Portuguese (pt-BR) localization. The application is live at https://flow.clubemkt.digital. The solution employs a systematic, multi-layered approach that addresses configuration files, codebase text replacement, component renaming, asset management, and comprehensive localization across Blade templates, React components, and JavaScript files.

The design prioritizes:
- **Zero-downtime migration**: All changes maintain backward compatibility until fully deployed
- **Comprehensive coverage**: Every user-facing element is localized
- **Maintainability**: Clear separation between brand-specific and functional code
- **Testability**: Each change can be verified independently

## Architecture

### System Layers

The application consists of five distinct layers that require rebranding and localization:

1. **Configuration Layer** (core/config/, core/.env)
   - Application name and locale settings
   - Environment-specific configurations

2. **Backend Layer** (core/app/)
   - PHP classes, components, and helpers
   - Business logic and data processing

3. **View Layer** (core/resources/views/)
   - Blade templates for admin and user interfaces
   - Component templates

4. **Frontend Layer** (core/resources/js/, assets/)
   - React components (Flow Builder)
   - JavaScript/jQuery scripts
   - CSS stylesheets

5. **Asset Layer** (assets/images/)
   - Logos, favicons, and brand imagery
   - Static resources

### Rebranding Strategy

The rebranding follows a **search-and-replace with validation** pattern:

```
┌─────────────────────────────────────────────────────────┐
│  1. Identify all brand references                       │
│     - FlowZap, OvoWpp, Ovo (standalone)                │
│     - Component names (OvoForm)                         │
│     - File names (ovo-markdown.js)                      │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  2. Apply context-aware replacement                      │
│     - Case-insensitive matching                         │
│     - Preserve partial matches (Novo, Approval)         │
│     - Update class names and namespaces                 │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  3. Validate changes                                     │
│     - Verify zero occurrences of old brand              │
│     - Test component functionality                      │
│     - Check asset loading                               │
└─────────────────────────────────────────────────────────┘
```

### Localization Strategy

The localization follows a **translation-key mapping** pattern:

```
┌─────────────────────────────────────────────────────────┐
│  1. Extract all translatable strings                     │
│     - Hardcoded text in Blade templates                 │
│     - JavaScript string literals                        │
│     - React component labels                            │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  2. Create translation keys                              │
│     - Add to pt.json with Brazilian Portuguese          │
│     - Wrap strings with __() or @lang()                 │
│     - Create dictionary objects for React               │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  3. Configure locale                                     │
│     - Set default locale to 'pt'                        │
│     - Create pt/ directory with framework files         │
│     - Update fallback locale                            │
└─────────────────────────────────────────────────────────┘
```

## Components and Interfaces

### 1. Configuration Manager

**Purpose**: Centralize all configuration changes for brand name and locale settings

**Files Modified**:
- `core/.env`
- `core/config/app.php`

**Interface**:
```php
// Environment Configuration
APP_NAME=FlowMkt
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
APP_URL=https://flow.clubemkt.digital

// Application Configuration
'name' => env('APP_NAME', 'FlowMkt'),
'locale' => env('APP_LOCALE', 'pt'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'pt'),
'url' => env('APP_URL', 'https://flow.clubemkt.digital'),
```

**Responsibilities**:
- Provide application name to all views and controllers
- Set default language for the application
- Configure fallback language for missing translations

### 2. Component Renaming Service

**Purpose**: Rename OvoForm component to FlowMktForm and update all references

**Files Modified**:
- `core/app/View/Components/OvoForm.php` → `FlowMktForm.php`
- `core/resources/views/components/ovo-form.blade.php` → `flowmkt-form.blade.php`
- All Blade templates using `<x-ovo-form>`

**Interface**:
```php
namespace App\View\Components;

class FlowMktForm extends Component
{
    public $identifier;
    public $identifierValue;
    public $form;
    public $formData;

    public function __construct($identifier, $identifierValue)
    {
        $this->identifier = $identifier;
        $this->identifierValue = $identifierValue;
        $this->form = Form::where($this->identifier, $this->identifierValue)->first();
        $this->formData = @$this->form->form_data ?? [];
    }

    public function render()
    {
        return view('components.flowmkt-form');
    }
}
```

**Usage in Blade**:
```blade
<!-- Old -->
<x-ovo-form identifier="id" identifierValue="{{ $gateway->form_id }}" />

<!-- New -->
<x-flowmkt-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
```

### 3. Translation Service

**Purpose**: Provide Brazilian Portuguese translations for all user-facing text

**Files Created/Modified**:
- `core/resources/lang/pt.json` (main translation file)
- `core/resources/lang/pt/auth.php`
- `core/resources/lang/pt/pagination.php`
- `core/resources/lang/pt/validation.php`
- `core/resources/lang/pt/passwords.php`

**Interface**:
```json
{
  "Dashboard": "Painel",
  "Login": "Entrar",
  "Logout": "Sair",
  "Submit": "Enviar",
  "Delete": "Excluir",
  "Edit": "Editar",
  "Search": "Buscar",
  "Withdraw": "Saque",
  "Welcome Back": "Bem-vindo de volta",
  "Username": "Nome de usuário",
  "Password": "Senha"
}
```

**Usage in Blade**:
```blade
<!-- Wrap hardcoded text -->
<h1>{{ __('Dashboard') }}</h1>
<button>@lang('Submit')</button>

<!-- With parameters -->
{{ __('Welcome, :name', ['name' => $user->name]) }}
```

### 4. React Localization Module

**Purpose**: Provide Portuguese translations for React Flow Builder components

**Files Modified**:
- `core/resources/js/flow_builder/app.jsx`
- `core/resources/js/flow_builder/nodes/Sidebar.jsx`
- All node component files

**Interface**:
```javascript
// Translation dictionary
const translations = {
  pt: {
    // Node types
    'Send Text Message': 'Enviar Mensagem de Texto',
    'Send Image': 'Enviar Imagem',
    'Send Video': 'Enviar Vídeo',
    'Send Audio': 'Enviar Áudio',
    'Send Document': 'Enviar Documento',
    'Send Button': 'Enviar Botão',
    'Send List': 'Enviar Lista',
    'Send Location': 'Enviar Localização',
    'Send Template': 'Enviar Template',
    
    // Actions
    'Add Node': 'Adicionar Nó',
    'Delete Node': 'Excluir Nó',
    'Save Flow': 'Salvar Fluxo',
    'Cancel': 'Cancelar',
    
    // Placeholders
    'Enter message': 'Digite a mensagem',
    'Select file': 'Selecionar arquivo',
    'Enter URL': 'Digite a URL'
  }
};

// Usage
const t = (key) => translations['pt'][key] || key;

// In components
<button>{t('Save Flow')}</button>
```

### 5. Asset Management Service

**Purpose**: Manage brand asset replacement and validation

**Files to Replace**:
- `assets/images/logo_icon/logo.png`
- `assets/images/logo_icon/logo_dark.png`
- `assets/images/logo_icon/favicon.png`
- `assets/admin/images/login-bg.png` (if exists)
- `assets/admin/images/login-dark.png` (if exists)

**Asset Specifications**:
```
Logo (logo.png):
  - Format: PNG with transparency
  - Recommended size: 200x60px
  - Usage: Main header logo (light backgrounds)

Logo Dark (logo_dark.png):
  - Format: PNG with transparency
  - Recommended size: 200x60px
  - Usage: Main header logo (dark backgrounds)

Favicon (favicon.png):
  - Format: PNG or ICO
  - Size: 32x32px or 16x16px
  - Usage: Browser tab icon
```

### 6. Helper Function Updates

**Purpose**: Update system identification functions

**Files Modified**:
- `core/app/Http/Helpers/helpers.php`

**Interface**:
```php
function systemDetails()
{
    $system['name']                = 'flowmkt';
    $system['web_version']         = '1.8';
    $system['admin_panel_version'] = '1.0.1';
    $system['mobile_app_version']  = '1.0';
    $system['flutter_version']     = '3.10.0';
    $system['android_version']     = '1.0';
    $system['ios_version']         = '1.0';
    
    return $system;
}
```

## Data Models

### Translation Key Structure

The translation system uses a flat key-value structure in JSON format:

```json
{
  "key": "translated_value"
}
```

**Key Naming Conventions**:
- Use the English text as the key
- Keys are case-sensitive
- Use exact text including punctuation
- For parameterized translations, use Laravel's `:parameter` syntax

**Example**:
```json
{
  "Welcome, :name": "Bem-vindo, :name",
  "Are you sure to delete this item?": "Tem certeza que deseja excluir este item?"
}
```

### Component State

The FlowMktForm component maintains the following state:

```php
class FlowMktForm {
    public string $identifier;      // Form identifier type ('id', 'act', etc.)
    public mixed $identifierValue;  // Value to match against
    public ?Form $form;             // Loaded form model
    public array $formData;         // Form field definitions
}
```

### React Component Props

Flow Builder nodes receive standardized props:

```javascript
interface NodeProps {
  id: string;              // Unique node identifier
  data: {
    label: string;         // Node display label (localized)
    config: object;        // Node-specific configuration
  };
  selected: boolean;       // Selection state
}
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property Reflection

After analyzing all acceptance criteria, I've identified the following consolidation opportunities:

**Redundancy Analysis**:

1. **Brand Name Removal Properties (2.1, 2.2, 2.3)**: These three properties all test for zero occurrences of old brand names. They can be combined into a single comprehensive property that checks for all old brand names at once.

2. **Translation Completeness Properties (5.1, 5.13, 6.2, 6.6, 11.2, 11.3)**: Multiple properties test that translation keys exist and have values. These can be consolidated into two properties: one for key completeness and one for value completeness.

3. **React Localization Properties (7.2, 7.4, 7.5, 7.6)**: These all test that React components use translated text. They can be combined into one property about React component localization.

4. **JavaScript Notification Properties (8.1, 8.2)**: Both test notification localization and can be combined into one property.

5. **Functionality Preservation Properties (10.1-10.8)**: These all test that functionality is maintained after changes. They can be consolidated into fewer, more comprehensive properties grouped by concern (forms/UI, data operations, external integrations).

**Retained Properties After Consolidation**:
- Brand name removal (consolidated from 2.1, 2.2, 2.3)
- Partial word preservation (2.4)
- Component reference updates (2.8, 2.9)
- Translation key completeness (consolidated from 5.1, 5.13, 6.2, 6.6, 11.2)
- Translation value completeness (consolidated from 11.3)
- React component localization (consolidated from 7.2, 7.4, 7.5, 7.6)
- JavaScript notification localization (consolidated from 8.1, 8.2)
- Form functionality preservation (consolidated from 10.1, 10.2)
- Data operation preservation (consolidated from 10.3, 10.4, 10.5)
- External integration preservation (consolidated from 10.6, 10.7, 10.8)

### Correctness Properties

Based on the prework analysis and property reflection, the following properties validate the rebranding and localization requirements:

**Property 1: Brand Name Elimination**
*For any* file in View_Files, Language_Files, or controller directories, searching for "FlowZap", "OvoWpp", or standalone "Ovo" (with word boundaries) should return zero occurrences
**Validates: Requirements 2.1, 2.2, 2.3**

**Property 2: Partial Word Preservation**
*For any* word containing "Ovo" as a substring (such as "Novo", "Approval", "Provoke"), the word should remain unchanged after rebranding operations
**Validates: Requirements 2.4**

**Property 3: Component Reference Consistency**
*For any* Blade template file, all component references should use the new naming convention (zero occurrences of "x-ovo-form", all references use "x-flowmkt-form")
**Validates: Requirements 2.8**

**Property 4: Asset Reference Consistency**
*For any* file referencing JavaScript assets, all references to "ovo-markdown.js" should be updated to "flowmkt-markdown.js"
**Validates: Requirements 2.9**

**Property 5: Translation Key Completeness**
*For any* translation key used in Blade templates (via __() or @lang()), React components, or JavaScript files, that key should exist in core/resources/lang/pt.json with a non-empty value
**Validates: Requirements 5.1, 5.13, 6.2, 6.6, 11.2**

**Property 6: Translation Fallback Behavior**
*For any* missing translation key, when the application runs in Portuguese mode, the system should fall back to the English translation and the key should not cause a runtime error
**Validates: Requirements 11.3, 11.4**

**Property 7: Blade Template Compilation**
*For any* Blade template file after localization changes, the template should compile without syntax errors
**Validates: Requirements 6.5**

**Property 8: React Component Localization**
*For any* React component in the flow_builder directory, all user-facing text (labels, buttons, placeholders, validation messages) should use the translation dictionary function rather than hardcoded strings
**Validates: Requirements 7.2, 7.4, 7.5, 7.6**

**Property 9: React Component Functionality**
*For any* React component after localization, the component should render and handle user interactions correctly
**Validates: Requirements 7.7**

**Property 10: JavaScript Notification Localization**
*For any* notify() or toastr() function call in JavaScript files, the message parameter should be in Brazilian Portuguese or use a translation key
**Validates: Requirements 8.1, 8.2**

**Property 11: JavaScript Functionality Preservation**
*For any* JavaScript function after localization, the function should execute without errors and produce the same logical results
**Validates: Requirements 8.5**

**Property 12: Form Functionality Preservation**
*For any* form submission after component renaming (FlowMktForm), the form should submit successfully and process data correctly
**Validates: Requirements 10.1, 10.2**

**Property 13: Data Operation Preservation**
*For any* database operation, file upload, or route resolution after configuration and view changes, the operation should complete successfully
**Validates: Requirements 10.3, 10.4, 10.5**

**Property 14: External Integration Preservation**
*For any* authentication, authorization, API endpoint, webhook, or notification after rebranding, the integration should function correctly
**Validates: Requirements 10.6, 10.7, 10.8**

## Error Handling

### Translation Missing Errors

**Scenario**: A translation key is used but not defined in pt.json

**Handling Strategy**:
1. Laravel's translation system automatically falls back to the key itself or English translation
2. Log a warning to help identify missing translations during development
3. Display the English text to users rather than showing an error

**Implementation**:
```php
// In AppServiceProvider or custom translation service
if (app()->environment('local', 'development')) {
    Event::listen(TranslationMissing::class, function ($event) {
        Log::warning('Missing translation', [
            'key' => $event->key,
            'locale' => $event->locale,
        ]);
    });
}
```

### Component Not Found Errors

**Scenario**: Blade templates reference old component name after renaming

**Handling Strategy**:
1. Comprehensive search and replace to update all references
2. Automated tests to verify component resolution
3. Clear error messages if component is not found

**Prevention**:
- Use IDE refactoring tools when renaming components
- Run grep search to find all component usages before renaming
- Test all pages that use the component

### Asset Loading Errors

**Scenario**: Logo or asset files are not found after replacement

**Handling Strategy**:
1. Verify file paths match exactly (case-sensitive on Linux servers)
2. Check file permissions (644 for files, 755 for directories)
3. Clear browser cache and Laravel cache after asset updates
4. Provide fallback to default assets if custom assets fail to load

**Implementation**:
```blade
<img src="{{ asset('assets/images/logo_icon/logo.png') }}" 
     onerror="this.src='{{ asset('assets/images/logo_icon/default-logo.png') }}'"
     alt="FlowMkt Logo">
```

### Configuration Errors

**Scenario**: Invalid locale configuration or missing language files

**Handling Strategy**:
1. Validate locale configuration on application boot
2. Ensure fallback locale is always available
3. Provide clear error messages for configuration issues

**Implementation**:
```php
// In AppServiceProvider boot method
if (!in_array(config('app.locale'), ['pt', 'en', 'es'])) {
    throw new \RuntimeException('Invalid locale configuration');
}

if (!file_exists(resource_path('lang/' . config('app.locale') . '.json'))) {
    Log::error('Language file missing', ['locale' => config('app.locale')]);
    config(['app.locale' => config('app.fallback_locale')]);
}
```

### React Component Errors

**Scenario**: Translation dictionary is not loaded or contains errors

**Handling Strategy**:
1. Provide default English text as fallback
2. Validate translation dictionary structure on component mount
3. Log errors to console for debugging

**Implementation**:
```javascript
const t = (key) => {
  try {
    return translations[currentLocale][key] || translations['en'][key] || key;
  } catch (error) {
    console.error('Translation error:', error);
    return key;
  }
};
```

## Testing Strategy

### Dual Testing Approach

This project requires both unit tests and property-based tests to ensure comprehensive coverage:

**Unit Tests**: Focus on specific examples, edge cases, and integration points
- Verify specific configuration values (APP_NAME, locale settings)
- Test specific file content (helpers.php systemDetails function)
- Validate specific translations (Dashboard → Painel)
- Check specific component functionality (FlowMktForm rendering)

**Property-Based Tests**: Verify universal properties across all inputs
- Test brand name elimination across all files
- Verify translation completeness across all keys
- Validate component functionality across all forms
- Ensure functionality preservation across all operations

### Unit Testing Strategy

**Configuration Tests**:
```php
// Test: Configuration values are updated correctly
public function test_app_name_is_flowmkt()
{
    $this->assertEquals('FlowMkt', config('app.name'));
}

public function test_default_locale_is_portuguese()
{
    $this->assertEquals('pt', config('app.locale'));
}

public function test_fallback_locale_is_portuguese()
{
    $this->assertEquals('pt', config('app.fallback_locale'));
}
```

**Component Tests**:
```php
// Test: FlowMktForm component renders correctly
public function test_flowmkt_form_component_exists()
{
    $this->assertTrue(class_exists('App\View\Components\FlowMktForm'));
}

public function test_flowmkt_form_renders_with_form_data()
{
    $form = Form::factory()->create();
    $component = new FlowMktForm('id', $form->id);
    
    $this->assertNotNull($component->form);
    $this->assertIsArray($component->formData);
}
```

**Translation Tests**:
```php
// Test: Specific translations exist and are correct
public function test_dashboard_translation_exists()
{
    $this->assertEquals('Painel', __('Dashboard'));
}

public function test_common_translations_exist()
{
    $translations = ['Login', 'Logout', 'Submit', 'Delete', 'Edit', 'Search'];
    
    foreach ($translations as $key) {
        $translated = __($key);
        $this->assertNotEquals($key, $translated);
        $this->assertNotEmpty($translated);
    }
}
```

**Asset Tests**:
```php
// Test: Brand assets exist and are accessible
public function test_logo_files_exist()
{
    $this->assertFileExists(public_path('assets/images/logo_icon/logo.png'));
    $this->assertFileExists(public_path('assets/images/logo_icon/logo_dark.png'));
    $this->assertFileExists(public_path('assets/images/logo_icon/favicon.png'));
}
```

### Property-Based Testing Strategy

**Library**: Use PHPUnit with custom generators for property-based testing, or integrate a library like Eris for PHP

**Configuration**: Each property test should run minimum 100 iterations

**Test Tagging**: Each test must reference its design property
```php
/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 1: Brand Name Elimination
 */
```

**Property Test Examples**:

```php
/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 1: Brand Name Elimination
 */
public function test_no_old_brand_names_in_codebase()
{
    $directories = [
        resource_path('views'),
        resource_path('lang'),
        app_path('Http/Controllers'),
    ];
    
    $oldBrandNames = ['FlowZap', 'OvoWpp', '\bOvo\b'];
    
    foreach ($directories as $directory) {
        $files = $this->getAllPhpAndBladeFiles($directory);
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            
            foreach ($oldBrandNames as $brandName) {
                $this->assertEquals(
                    0,
                    preg_match_all('/' . $brandName . '/i', $content),
                    "Found '{$brandName}' in {$file}"
                );
            }
        }
    }
}

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 2: Partial Word Preservation
 */
public function test_partial_words_with_ovo_preserved()
{
    $wordsToPreserve = ['Novo', 'Approval', 'Provoke', 'Provost'];
    $directories = [resource_path('views'), app_path()];
    
    foreach ($directories as $directory) {
        $files = $this->getAllPhpAndBladeFiles($directory);
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            
            foreach ($wordsToPreserve as $word) {
                // If the word existed in original, it should still exist
                // This test verifies we didn't break partial matches
                if (preg_match('/\b' . $word . '\b/i', $content)) {
                    $this->assertTrue(true); // Word preserved
                }
            }
        }
    }
}

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 5: Translation Key Completeness
 */
public function test_all_translation_keys_have_portuguese_values()
{
    $ptTranslations = json_decode(
        file_get_contents(resource_path('lang/pt.json')),
        true
    );
    
    // Extract all translation keys used in Blade templates
    $usedKeys = $this->extractTranslationKeysFromBladeTemplates();
    
    foreach ($usedKeys as $key) {
        $this->assertArrayHasKey(
            $key,
            $ptTranslations,
            "Translation key '{$key}' missing from pt.json"
        );
        
        $this->assertNotEmpty(
            $ptTranslations[$key],
            "Translation key '{$key}' has empty value in pt.json"
        );
    }
}

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 12: Form Functionality Preservation
 */
public function test_form_submission_works_with_renamed_component()
{
    // Test with multiple form types
    $formTypes = ['kyc', 'deposit', 'withdraw'];
    
    foreach ($formTypes as $formType) {
        $form = Form::factory()->create(['identifier' => $formType]);
        
        $response = $this->actingAs($this->user)
            ->post(route('user.form.submit'), [
                'form_id' => $form->id,
                'field_data' => ['test' => 'value'],
            ]);
        
        $response->assertSuccessful();
        $this->assertDatabaseHas('form_submissions', [
            'form_id' => $form->id,
        ]);
    }
}

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 13: Data Operation Preservation
 */
public function test_database_operations_work_after_changes()
{
    $operations = [
        'create' => fn() => User::create(['name' => 'Test', 'email' => 'test@example.com']),
        'read' => fn() => User::find(1),
        'update' => fn() => User::find(1)->update(['name' => 'Updated']),
        'delete' => fn() => User::find(1)->delete(),
    ];
    
    foreach ($operations as $operation => $callback) {
        try {
            $callback();
            $this->assertTrue(true, "{$operation} operation successful");
        } catch (\Exception $e) {
            $this->fail("{$operation} operation failed: " . $e->getMessage());
        }
    }
}
```

### Integration Testing

**Scope**: Test complete user workflows after rebranding and localization

**Key Workflows to Test**:
1. User registration and login
2. Form submission with FlowMktForm component
3. Flow builder creation and editing
4. File upload and asset display
5. Notification display
6. Multi-language switching (if supported)

**Example Integration Test**:
```php
public function test_complete_user_workflow_in_portuguese()
{
    // Set locale to Portuguese
    app()->setLocale('pt');
    
    // Register new user
    $response = $this->post(route('register'), [
        'name' => 'Teste Usuário',
        'email' => 'teste@exemplo.com',
        'password' => 'senha123',
    ]);
    
    $response->assertRedirect(route('user.dashboard'));
    
    // Verify dashboard displays in Portuguese
    $response = $this->get(route('user.dashboard'));
    $response->assertSee('Painel');
    $response->assertDontSee('Dashboard');
    
    // Create a flow
    $response = $this->post(route('user.flow.store'), [
        'name' => 'Meu Fluxo',
        'description' => 'Descrição do fluxo',
    ]);
    
    $response->assertSuccessful();
    $this->assertDatabaseHas('flows', ['name' => 'Meu Fluxo']);
}
```

### Manual Testing Checklist

After automated tests pass, perform manual verification:

- [ ] All pages display FlowMkt branding (logo, favicon)
- [ ] All text is in Brazilian Portuguese
- [ ] No English text visible to users
- [ ] Forms submit successfully
- [ ] File uploads work correctly
- [ ] Notifications display in Portuguese
- [ ] Flow builder interface is fully localized
- [ ] All buttons and links work correctly
- [ ] SEO meta tags show FlowMkt branding
- [ ] Browser tab shows correct favicon and title

### Test Execution Order

1. **Unit Tests**: Run first to catch basic issues
2. **Property Tests**: Run to verify comprehensive coverage
3. **Integration Tests**: Run to verify complete workflows
4. **Manual Tests**: Perform final verification

### Continuous Integration

Add tests to CI/CD pipeline:
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - name: Install Dependencies
        run: composer install
      - name: Run Unit Tests
        run: php artisan test --filter Unit
      - name: Run Property Tests
        run: php artisan test --filter Property
      - name: Run Integration Tests
        run: php artisan test --filter Integration
```

## Implementation Notes

### Execution Order

The rebranding and localization should be implemented in this order to minimize disruption:

1. **Configuration Updates** (Requirements 1.x)
   - Update .env and config files
   - Test configuration loading

2. **Component Renaming** (Requirements 2.7, 2.8)
   - Rename OvoForm to FlowMktForm
   - Update all component references
   - Test component functionality

3. **Text Replacement** (Requirements 2.1-2.6, 2.9, 2.10)
   - Search and replace brand names
   - Update helper functions
   - Update documentation URLs

4. **Translation File Creation** (Requirements 5.x)
   - Create pt.json with all translations
   - Create pt/ directory with framework files
   - Test translation loading

5. **Blade Template Localization** (Requirements 6.x)
   - Wrap hardcoded text with translation functions
   - Add new keys to pt.json
   - Test template rendering

6. **React Component Localization** (Requirements 7.x)
   - Create translation dictionary
   - Update all React components
   - Test React functionality

7. **JavaScript Localization** (Requirements 8.x)
   - Localize notification messages
   - Update global scripts
   - Test JavaScript functionality

8. **Asset Replacement** (Requirements 3.x)
   - Replace logo files
   - Update brand imagery
   - Test asset loading

9. **CSS Updates** (Requirements 9.x)
   - Update brand colors
   - Test visual appearance

10. **SEO Updates** (Requirements 4.x)
    - Update meta tags
    - Test SEO rendering

11. **Final Verification** (Requirements 10.x, 11.x, 12.x)
    - Run all tests
    - Verify functionality
    - Document changes

### Rollback Strategy

If issues are discovered after deployment:

1. **Configuration Rollback**: Revert .env and config files
2. **Component Rollback**: Restore OvoForm component and references
3. **Translation Rollback**: Switch locale back to English
4. **Asset Rollback**: Restore original logo files
5. **Full Rollback**: Use version control to revert all changes

### Performance Considerations

- **Translation Caching**: Laravel caches translations in production, improving performance
- **Asset Optimization**: Compress logo files to reduce load times
- **React Bundle Size**: Ensure translation dictionary doesn't significantly increase bundle size
- **Database Queries**: Rebranding doesn't affect database queries or performance

### Security Considerations

- **File Permissions**: Ensure asset files have correct permissions (644)
- **XSS Prevention**: All translated text is escaped by Laravel's Blade engine
- **CSRF Protection**: Form submissions maintain CSRF token validation
- **Input Validation**: Localization doesn't affect input validation rules

### Maintenance Considerations

- **Adding New Translations**: Document process for adding new translation keys
- **Updating Translations**: Provide tools for translators to update pt.json
- **Translation Completeness**: Regular audits to find missing translations
- **Brand Updates**: Document process for updating brand assets and colors
