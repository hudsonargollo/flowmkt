# Test Execution Guide

## Overview

This guide provides instructions for running the comprehensive test suite for the FlowMkt rebranding and localization project. The test suite validates that all functionality is preserved after rebranding and localization changes.

## Prerequisites

Before running tests, ensure:

1. **Composer dependencies are installed**:
   ```bash
   cd core
   composer install
   ```

2. **Environment is configured**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database is set up** (if running integration tests):
   ```bash
   php artisan migrate --env=testing
   ```

## Test Suites

### 1. Unit Tests

**Location**: `core/tests/Unit/`

**Purpose**: Test specific functionality and configuration values

**Tests Include**:
- Configuration verification (APP_NAME, locale settings)
- Component class existence (FlowMktForm)
- Translation key existence
- Asset file presence
- Helper function outputs

**Run Command**:
```bash
./vendor/bin/phpunit --testsuite Unit
```

**Expected Outcome**: All unit tests should pass, confirming:
- ✅ APP_NAME is set to "FlowMkt"
- ✅ Default locale is "pt"
- ✅ Fallback locale is "pt"
- ✅ FlowMktForm component exists
- ✅ Key translations exist in pt.json
- ✅ Logo files exist and are readable

### 2. Property-Based Tests

**Location**: `core/tests/Property/`

**Purpose**: Verify universal correctness properties across all inputs

**Tests Include**:
- **FormFunctionalityPreservationTest**: Forms work correctly with FlowMktForm
- **DataOperationPreservationTest**: Database operations, file uploads, routing work
- **ExternalIntegrationPreservationTest**: Authentication, APIs, webhooks function
- **CompleteUserWorkflowTest**: End-to-end user workflows in Portuguese

**Run Command**:
```bash
./vendor/bin/phpunit --testsuite Property
```

**Expected Outcome**: All property tests should pass, confirming:
- ✅ Form submissions work correctly
- ✅ Database operations are preserved
- ✅ File uploads function properly
- ✅ Routing works correctly
- ✅ Authentication is functional
- ✅ API endpoints respond correctly
- ✅ Complete user workflows succeed

### 3. Integration Tests

**Location**: `core/tests/Feature/`

**Purpose**: Test complete workflows and feature interactions

**Tests Include**:
- User registration and login in Portuguese
- Form submission with FlowMktForm component
- Flow builder creation and editing
- File upload and asset display
- Notification display in Portuguese

**Run Command**:
```bash
./vendor/bin/phpunit --testsuite Feature
```

**Expected Outcome**: All integration tests should pass, confirming:
- ✅ Users can register and login
- ✅ Dashboard displays in Portuguese
- ✅ Forms submit successfully
- ✅ Flow builder works correctly
- ✅ Assets load properly

## Running All Tests

### Using the Test Runner Script

The easiest way to run all tests is using the provided script:

```bash
./core/scripts/run_comprehensive_tests.sh
```

This script will:
1. Check prerequisites
2. Run unit tests
3. Run property-based tests
4. Run integration tests
5. Run complete test suite
6. Display a summary report

### Using PHPUnit Directly

To run all tests at once:

```bash
cd core
./vendor/bin/phpunit
```

To run with coverage report:

```bash
./vendor/bin/phpunit --coverage-html coverage
```

To run specific test files:

```bash
./vendor/bin/phpunit tests/Property/FormFunctionalityPreservationTest.php
```

## Test Configuration

### PHPUnit Configuration

Tests are configured in `core/phpunit.xml`:

```xml
<testsuites>
    <testsuite name="Unit">
        <directory>tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory>tests/Feature</directory>
    </testsuite>
    <testsuite name="Property">
        <directory>tests/Property</directory>
    </testsuite>
</testsuites>
```

### Test Environment

Tests use a separate `.env.testing` file (if present) or fall back to `.env`.

Key environment variables for testing:
- `APP_ENV=testing`
- `DB_CONNECTION=sqlite` (recommended for tests)
- `DB_DATABASE=:memory:` (in-memory database for speed)

## Interpreting Test Results

### Success Output

```
✅ Unit tests passed
✅ Property tests passed
✅ Integration tests passed

╔════════════════════════════════════════════════════════════════╗
║  ✅ SUCCESS: All test suites passed!                           ║
╚════════════════════════════════════════════════════════════════╝
```

### Failure Output

If tests fail, you'll see:

```
❌ Unit tests failed

FAILURES!
Tests: 10, Assertions: 45, Failures: 2.

Failed asserting that 'OvoForm' matches expected 'FlowMktForm'.
```

**Action**: Review the failure details and fix the underlying issue.

## Common Issues and Solutions

### Issue: "Class 'Tests\TestCase' not found"

**Solution**: Run `composer dump-autoload`

### Issue: "Database connection failed"

**Solution**: 
1. Check database configuration in `.env`
2. Run migrations: `php artisan migrate --env=testing`
3. Or use in-memory SQLite: Set `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`

### Issue: "Translation key not found"

**Solution**: 
1. Run translation verification: `php core/scripts/verify_translations.php`
2. Add missing keys to `core/resources/lang/pt.json`

### Issue: "Component not found"

**Solution**:
1. Verify component file exists: `core/app/View/Components/FlowMktForm.php`
2. Check component is registered in service provider
3. Clear cache: `php artisan view:clear`

## Test Coverage

To generate a test coverage report:

```bash
./vendor/bin/phpunit --coverage-html coverage --coverage-filter app/
```

Open `coverage/index.html` in a browser to view the report.

**Target Coverage**: Aim for >80% code coverage on critical paths:
- Configuration files
- Component classes
- Helper functions
- Controllers

## Continuous Integration

For CI/CD pipelines, use:

```bash
./vendor/bin/phpunit --log-junit junit.xml --coverage-clover coverage.xml
```

This generates machine-readable reports for CI systems.

## Requirements Validation

Each test validates specific requirements from the design document:

| Test Suite | Requirements Validated |
|------------|------------------------|
| Unit Tests | 1.1-1.5, 2.7, 3.1, 5.3-5.10 |
| Property Tests | 10.1-10.8 |
| Integration Tests | 6.1, 7.7, 8.5, 10.1-10.8 |

See `core/tests/Property/README.md` for detailed property-to-requirement mappings.

## Next Steps After Testing

1. **If all tests pass**:
   - Proceed to task 15.3 (Clear application cache)
   - Continue with manual verification (task 15.4)

2. **If tests fail**:
   - Review failure details
   - Fix underlying issues
   - Re-run tests
   - Do not proceed until all tests pass

## Support

For issues with tests:
1. Check this guide for common solutions
2. Review test output for specific error messages
3. Consult the design document for requirements
4. Check the translation verification report for missing keys

---

**Last Updated**: 2026-01-30
**Version**: 1.0
