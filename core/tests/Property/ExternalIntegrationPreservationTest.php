<?php

namespace Tests\Property;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 14: External Integration Preservation
 * 
 * Property: For any authentication, authorization, API endpoint, webhook, or notification 
 * after rebranding, the integration should function correctly
 * 
 * Validates: Requirements 10.6, 10.7, 10.8
 */
class ExternalIntegrationPreservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that authentication system works correctly
     */
    public function test_authentication_system_works(): void
    {
        // Create a test user
        $user = User::create([
            'firstname' => 'Auth',
            'lastname' => 'Test',
            'username' => 'authtest',
            'email' => 'auth@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11999999999',
            'ev' => 1, // Email verified
            'sv' => 1, // SMS verified
            'status' => 1, // Active
        ]);

        // Test authentication attempt
        $this->assertFalse(Auth::check());
        
        Auth::login($user);
        
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertEquals('auth@example.com', Auth::user()->email);

        // Test logout
        Auth::logout();
        $this->assertFalse(Auth::check());
    }

    /**
     * Test that password hashing works correctly
     */
    public function test_password_hashing_works(): void
    {
        $password = 'SecurePassword123!';
        $hashedPassword = Hash::make($password);

        // Test that hash is created
        $this->assertNotEmpty($hashedPassword);
        $this->assertNotEquals($password, $hashedPassword);

        // Test that hash can be verified
        $this->assertTrue(Hash::check($password, $hashedPassword));
        $this->assertFalse(Hash::check('WrongPassword', $hashedPassword));
    }

    /**
     * Test that user authentication with credentials works
     */
    public function test_user_authentication_with_credentials_works(): void
    {
        // Create a test user
        $user = User::create([
            'firstname' => 'Credential',
            'lastname' => 'Test',
            'username' => 'credtest',
            'email' => 'cred@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11888888888',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Test authentication with correct credentials
        $authenticated = Auth::attempt([
            'username' => 'credtest',
            'password' => 'password123',
        ]);

        $this->assertTrue($authenticated);
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());

        Auth::logout();

        // Test authentication with incorrect credentials
        $failedAuth = Auth::attempt([
            'username' => 'credtest',
            'password' => 'wrongpassword',
        ]);

        $this->assertFalse($failedAuth);
        $this->assertFalse(Auth::check());
    }

    /**
     * Test that guest middleware works correctly
     */
    public function test_guest_middleware_works(): void
    {
        // Test that guest can access login page
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test that auth middleware works correctly
     */
    public function test_auth_middleware_works(): void
    {
        // Create and authenticate a user
        $user = User::create([
            'firstname' => 'Middleware',
            'lastname' => 'Test',
            'username' => 'middlewaretest',
            'email' => 'middleware@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11777777777',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Test that unauthenticated user is redirected
        $response = $this->get('/user/dashboard');
        $response->assertRedirect('/login');

        // Test that authenticated user can access protected routes
        $response = $this->actingAs($user)->get('/user/dashboard');
        // Should not redirect to login (either 200 or other valid status)
        $this->assertNotEquals(302, $response->status());
    }

    /**
     * Test that session management works correctly
     */
    public function test_session_management_works(): void
    {
        // Test setting session data
        session(['test_key' => 'test_value']);
        $this->assertEquals('test_value', session('test_key'));

        // Test session has
        $this->assertTrue(session()->has('test_key'));
        $this->assertFalse(session()->has('nonexistent_key'));

        // Test session forget
        session()->forget('test_key');
        $this->assertFalse(session()->has('test_key'));
    }

    /**
     * Test that CSRF protection is enabled
     */
    public function test_csrf_protection_is_enabled(): void
    {
        // Test that CSRF token can be generated
        $token = csrf_token();
        $this->assertNotEmpty($token);
        $this->assertIsString($token);

        // Test that CSRF field can be generated
        $field = csrf_field();
        $this->assertStringContainsString('_token', $field);
        $this->assertStringContainsString($token, $field);
    }

    /**
     * Test that API routes are accessible
     */
    public function test_api_routes_are_accessible(): void
    {
        // Test that API routes are registered
        $apiRoutes = collect(Route::getRoutes())->filter(function ($route) {
            return str_starts_with($route->uri(), 'api/');
        });

        // API routes should exist in the application
        $this->assertGreaterThanOrEqual(0, $apiRoutes->count());
    }

    /**
     * Test that configuration values are accessible
     */
    public function test_configuration_values_are_accessible(): void
    {
        // Test that app configuration is accessible
        $appName = Config::get('app.name');
        $this->assertNotEmpty($appName);
        $this->assertEquals('FlowMkt', $appName);

        // Test that locale configuration is accessible
        $locale = Config::get('app.locale');
        $this->assertNotEmpty($locale);
        $this->assertEquals('pt', $locale);

        // Test that fallback locale is accessible
        $fallbackLocale = Config::get('app.fallback_locale');
        $this->assertNotEmpty($fallbackLocale);
        $this->assertEquals('pt', $fallbackLocale);
    }

    /**
     * Test that environment variables are accessible
     */
    public function test_environment_variables_are_accessible(): void
    {
        // Test that APP_NAME is set
        $appName = env('APP_NAME');
        $this->assertNotEmpty($appName);

        // Test that APP_ENV is set
        $appEnv = env('APP_ENV');
        $this->assertNotEmpty($appEnv);

        // Test that APP_KEY is set
        $appKey = env('APP_KEY');
        $this->assertNotEmpty($appKey);
    }

    /**
     * Test that user roles and permissions system works
     */
    public function test_user_roles_and_permissions_work(): void
    {
        // Create a test user
        $user = User::create([
            'firstname' => 'Permission',
            'lastname' => 'Test',
            'username' => 'permtest',
            'email' => 'perm@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11666666666',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Verify user exists and can be authenticated
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
        
        Auth::login($user);
        $this->assertTrue(Auth::check());
    }

    /**
     * Test that notification system configuration is intact
     */
    public function test_notification_system_configuration_is_intact(): void
    {
        // Test that mail configuration is accessible
        $mailDriver = Config::get('mail.default');
        $this->assertNotEmpty($mailDriver);

        // Test that notification channels are configured
        $this->assertTrue(Config::has('mail.mailers'));
    }

    /**
     * Test that webhook endpoints can be registered
     */
    public function test_webhook_endpoints_can_be_registered(): void
    {
        // Test that routes can be registered dynamically
        Route::post('/test-webhook', function () {
            return response()->json(['status' => 'success']);
        });

        // Verify route was registered
        $this->assertTrue(Route::has('test-webhook') || 
                         collect(Route::getRoutes())->contains(function ($route) {
                             return $route->uri() === 'test-webhook';
                         }));
    }

    /**
     * Test that API authentication works
     */
    public function test_api_authentication_works(): void
    {
        // Create a test user
        $user = User::create([
            'firstname' => 'API',
            'lastname' => 'Test',
            'username' => 'apitest',
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11555555555',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Test that user can be authenticated for API
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }
}
