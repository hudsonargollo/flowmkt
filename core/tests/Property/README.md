# Property-Based Tests for FlowMkt Rebranding and Localization

This directory contains property-based tests that validate the correctness of the FlowMkt rebranding and localization implementation.

## Overview

These tests implement the correctness properties defined in the design document for the `flowmlkt-rebranding-localization` feature. They verify that the system maintains functionality after rebranding from "FlowZap/OvoWpp" to "FlowMkt" and implementing Brazilian Portuguese localization.

## Test Files

### 1. FormFunctionalityPreservationTest.php
**Property 12: Form Functionality Preservation**

Tests that form submissions work correctly after component renaming (OvoForm → FlowMktForm).

**Validates Requirements:** 10.1, 10.2

**Test Cases:**
- FlowMktForm component instantiation with different identifiers
- Component rendering
- Handling missing forms gracefully
- Preserving form data structure
- Handling empty form data
- Multiple component instances coexisting

### 2. DataOperationPreservationTest.php
**Property 13: Data Operation Preservation**

Tests that database operations, file uploads, and route resolution work correctly after configuration and view changes.

**Validates Requirements:** 10.3, 10.4, 10.5

**Test Cases:**
- Database CREATE operations
- Database READ operations
- Database UPDATE operations
- Database DELETE operations
- Database transactions
- Route resolution
- File storage operations
- File upload simulation
- Model relationships
- Query builder operations

### 3. ExternalIntegrationPreservationTest.php
**Property 14: External Integration Preservation**

Tests that authentication, authorization, API endpoints, webhooks, and notifications function correctly after rebranding.

**Validates Requirements:** 10.6, 10.7, 10.8

**Test Cases:**
- Authentication system
- Password hashing
- User authentication with credentials
- Guest middleware
- Auth middleware
- Session management
- CSRF protection
- API routes accessibility
- Configuration values
- Environment variables
- User roles and permissions
- Notification system configuration
- Webhook endpoints
- API authentication

### 4. CompleteUserWorkflowTest.php
**Integration Tests**

Tests complete user workflows to ensure end-to-end functionality after rebranding and localization.

**Validates Requirements:** 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8

**Test Cases:**
- User registration and login workflow in Portuguese
- Form submission workflow with FlowMktForm
- File upload workflow
- Dashboard access workflow
- Multi-step form workflow
- User profile update workflow
- Session persistence across requests
- Error handling in form submission
- Localization in complete workflow

## Running the Tests

### Prerequisites

1. Ensure PHP 8.3+ is installed
2. Install Composer dependencies:
   ```bash
   cd core
   composer install
   ```

3. Configure the test environment:
   - Copy `.env.example` to `.env.testing`
   - Set `APP_ENV=testing`
   - Configure test database (SQLite recommended for testing)

### Run All Property Tests

```bash
cd core
./vendor/bin/phpunit --testsuite=Property
```

### Run Specific Test File

```bash
cd core
./vendor/bin/phpunit tests/Property/FormFunctionalityPreservationTest.php
```

### Run Specific Test Method

```bash
cd core
./vendor/bin/phpunit --filter test_flowmkt_form_component_instantiates_with_different_identifiers
```

### Run with Coverage

```bash
cd core
./vendor/bin/phpunit --testsuite=Property --coverage-html coverage
```

## Test Configuration

The tests use the following configuration from `phpunit.xml`:

- **Test Environment:** `APP_ENV=testing`
- **Cache:** Array driver (in-memory)
- **Session:** Array driver (in-memory)
- **Queue:** Sync (immediate execution)
- **Mail:** Array driver (no actual emails sent)

## Database Setup

Tests use Laravel's `RefreshDatabase` trait, which:
1. Runs migrations before each test
2. Rolls back all changes after each test
3. Ensures test isolation

For SQLite (recommended for testing):
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## Continuous Integration

These tests can be integrated into CI/CD pipelines:

```yaml
# Example GitHub Actions workflow
- name: Run Property Tests
  run: |
    cd core
    php artisan config:clear
    php artisan cache:clear
    ./vendor/bin/phpunit --testsuite=Property
```

## Test Results Interpretation

### Success
All tests pass, indicating that:
- Forms work correctly with FlowMktForm component
- Database operations are preserved
- External integrations function properly
- Complete user workflows operate as expected

### Failure
If tests fail, check:
1. Database configuration
2. Environment variables
3. Required dependencies
4. File permissions
5. Cache and configuration files

## Maintenance

When adding new functionality:
1. Add corresponding test cases to the appropriate test file
2. Follow the existing test structure and naming conventions
3. Ensure tests are isolated and don't depend on external state
4. Update this README with new test descriptions

## Notes

- These tests are **optional** as marked in the tasks.md file
- Tests validate that rebranding and localization don't break existing functionality
- All tests use Laravel's testing framework and PHPUnit
- Tests are designed to run in isolation without affecting production data
- The `RefreshDatabase` trait ensures a clean database state for each test

## Related Documentation

- [Design Document](../../../.kiro/specs/flowmlkt-rebranding-localization/design.md)
- [Requirements Document](../../../.kiro/specs/flowmlkt-rebranding-localization/requirements.md)
- [Tasks Document](../../../.kiro/specs/flowmlkt-rebranding-localization/tasks.md)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
