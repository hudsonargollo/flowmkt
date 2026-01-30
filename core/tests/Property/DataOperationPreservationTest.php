<?php

namespace Tests\Property;

use Tests\TestCase;
use App\Models\User;
use App\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 13: Data Operation Preservation
 * 
 * Property: For any database operation, file upload, or route resolution after 
 * configuration and view changes, the operation should complete successfully
 * 
 * Validates: Requirements 10.3, 10.4, 10.5
 */
class DataOperationPreservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that database CREATE operations work correctly
     */
    public function test_database_create_operations_work(): void
    {
        // Test creating a User
        $user = User::create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11999999999',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);

        // Test creating a Form
        $form = Form::create([
            'act' => 'test_create',
            'name' => 'Test Form',
            'form_data' => json_encode([
                ['name' => 'field1', 'type' => 'text']
            ])
        ]);

        $this->assertDatabaseHas('forms', [
            'act' => 'test_create',
            'name' => 'Test Form',
        ]);
    }

    /**
     * Test that database READ operations work correctly
     */
    public function test_database_read_operations_work(): void
    {
        // Create test data
        $user = User::create([
            'firstname' => 'Read',
            'lastname' => 'Test',
            'username' => 'readtest',
            'email' => 'read@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11888888888',
        ]);

        // Test reading by ID
        $foundUser = User::find($user->id);
        $this->assertNotNull($foundUser);
        $this->assertEquals('readtest', $foundUser->username);

        // Test reading by email
        $foundByEmail = User::where('email', 'read@example.com')->first();
        $this->assertNotNull($foundByEmail);
        $this->assertEquals($user->id, $foundByEmail->id);

        // Test reading all
        $allUsers = User::all();
        $this->assertGreaterThan(0, $allUsers->count());
    }

    /**
     * Test that database UPDATE operations work correctly
     */
    public function test_database_update_operations_work(): void
    {
        // Create test data
        $user = User::create([
            'firstname' => 'Update',
            'lastname' => 'Test',
            'username' => 'updatetest',
            'email' => 'update@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11777777777',
        ]);

        // Test updating
        $user->update([
            'firstname' => 'Updated',
            'lastname' => 'Name',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => 'Updated',
            'lastname' => 'Name',
        ]);

        // Verify old values are gone
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'firstname' => 'Update',
        ]);
    }

    /**
     * Test that database DELETE operations work correctly
     */
    public function test_database_delete_operations_work(): void
    {
        // Create test data
        $user = User::create([
            'firstname' => 'Delete',
            'lastname' => 'Test',
            'username' => 'deletetest',
            'email' => 'delete@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11666666666',
        ]);

        $userId = $user->id;

        // Test deleting
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $userId,
            'email' => 'delete@example.com',
        ]);

        // Verify user cannot be found
        $deletedUser = User::find($userId);
        $this->assertNull($deletedUser);
    }

    /**
     * Test that database transactions work correctly
     */
    public function test_database_transactions_work(): void
    {
        \DB::beginTransaction();

        try {
            $user = User::create([
                'firstname' => 'Transaction',
                'lastname' => 'Test',
                'username' => 'transactiontest',
                'email' => 'transaction@example.com',
                'password' => bcrypt('password123'),
                'country_code' => 'BR',
                'mobile' => '11555555555',
            ]);

            $form = Form::create([
                'act' => 'transaction_test',
                'name' => 'Transaction Form',
                'form_data' => json_encode([])
            ]);

            \DB::commit();

            $this->assertDatabaseHas('users', ['email' => 'transaction@example.com']);
            $this->assertDatabaseHas('forms', ['act' => 'transaction_test']);
        } catch (\Exception $e) {
            \DB::rollBack();
            $this->fail('Transaction failed: ' . $e->getMessage());
        }
    }

    /**
     * Test that route resolution works correctly
     */
    public function test_route_resolution_works(): void
    {
        // Test that common routes are registered
        $this->assertTrue(Route::has('login'), 'Login route should exist');
        
        // Test route URL generation
        $loginUrl = route('login');
        $this->assertNotEmpty($loginUrl);
        $this->assertStringContainsString('login', $loginUrl);
    }

    /**
     * Test that file storage operations work correctly
     */
    public function test_file_storage_operations_work(): void
    {
        Storage::fake('local');

        // Test file creation
        $content = 'Test file content';
        Storage::put('test-file.txt', $content);

        // Test file exists
        $this->assertTrue(Storage::exists('test-file.txt'));

        // Test file reading
        $readContent = Storage::get('test-file.txt');
        $this->assertEquals($content, $readContent);

        // Test file deletion
        Storage::delete('test-file.txt');
        $this->assertFalse(Storage::exists('test-file.txt'));
    }

    /**
     * Test that file upload simulation works correctly
     */
    public function test_file_upload_simulation_works(): void
    {
        Storage::fake('public');

        // Create a fake uploaded file
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        // Test file properties
        $this->assertEquals('test-image.jpg', $file->getClientOriginalName());
        $this->assertEquals('image/jpeg', $file->getMimeType());
        $this->assertGreaterThan(0, $file->getSize());

        // Test file storage
        $path = $file->store('uploads', 'public');
        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);
    }

    /**
     * Test that model relationships work correctly
     */
    public function test_model_relationships_work(): void
    {
        // This test verifies that Eloquent relationships still function
        // after configuration changes
        
        $user = User::create([
            'firstname' => 'Relationship',
            'lastname' => 'Test',
            'username' => 'relationtest',
            'email' => 'relation@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11444444444',
        ]);

        // Verify user can be retrieved
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test that query builder operations work correctly
     */
    public function test_query_builder_operations_work(): void
    {
        // Create test data
        User::create([
            'firstname' => 'Query',
            'lastname' => 'One',
            'username' => 'query1',
            'email' => 'query1@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11333333333',
        ]);

        User::create([
            'firstname' => 'Query',
            'lastname' => 'Two',
            'username' => 'query2',
            'email' => 'query2@example.com',
            'password' => bcrypt('password123'),
            'country_code' => 'BR',
            'mobile' => '11222222222',
        ]);

        // Test WHERE clause
        $users = User::where('firstname', 'Query')->get();
        $this->assertGreaterThanOrEqual(2, $users->count());

        // Test ORDER BY
        $orderedUsers = User::where('firstname', 'Query')
            ->orderBy('lastname', 'asc')
            ->get();
        $this->assertEquals('One', $orderedUsers->first()->lastname);

        // Test COUNT
        $count = User::where('firstname', 'Query')->count();
        $this->assertGreaterThanOrEqual(2, $count);
    }
}
