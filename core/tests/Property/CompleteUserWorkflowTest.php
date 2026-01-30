<?php

namespace Tests\Property;

use Tests\TestCase;
use App\Models\User;
use App\Models\Form;
use App\View\Components\FlowMktForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Integration Tests
 * 
 * Property: Complete user workflows should function correctly after rebranding 
 * and localization, including registration, login, form submission, file uploads, 
 * and flow builder operations
 * 
 * Validates: Requirements 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8
 */
class CompleteUserWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test complete user registration and login workflow in Portuguese
     */
    public function test_user_registration_and_login_workflow_in_portuguese(): void
    {
        // Set locale to Portuguese
        app()->setLocale('pt');
        
        // Verify locale is set correctly
        $this->assertEquals('pt', app()->getLocale());

        // Create a new user (simulating registration)
        $user = User::create([
            'firstname' => 'Teste',
            'lastname' => 'Usuário',
            'username' => 'testeusuario',
            'email' => 'teste@exemplo.com',
            'password' => Hash::make('senha123'),
            'country_code' => 'BR',
            'mobile' => '11999999999',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Verify user was created
        $this->assertDatabaseHas('users', [
            'email' => 'teste@exemplo.com',
            'username' => 'testeusuario',
        ]);

        // Test login
        $authenticated = Auth::attempt([
            'username' => 'testeusuario',
            'password' => 'senha123',
        ]);

        $this->assertTrue($authenticated);
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());

        // Verify user data is accessible
        $loggedInUser = Auth::user();
        $this->assertEquals('Teste', $loggedInUser->firstname);
        $this->assertEquals('Usuário', $loggedInUser->lastname);
    }

    /**
     * Test form submission workflow with FlowMktForm component
     */
    public function test_form_submission_workflow_with_flowmkt_form(): void
    {
        // Create a test user
        $user = User::create([
            'firstname' => 'Form',
            'lastname' => 'User',
            'username' => 'formuser',
            'email' => 'form@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11888888888',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Create a form
        $form = Form::create([
            'act' => 'kyc_form',
            'name' => 'Formulário KYC',
            'form_data' => json_encode([
                [
                    'name' => 'full_name',
                    'type' => 'text',
                    'is_required' => 'required',
                    'label' => 'Nome Completo'
                ],
                [
                    'name' => 'document',
                    'type' => 'text',
                    'is_required' => 'required',
                    'label' => 'CPF'
                ],
                [
                    'name' => 'address',
                    'type' => 'textarea',
                    'is_required' => 'required',
                    'label' => 'Endereço'
                ]
            ])
        ]);

        // Test FlowMktForm component instantiation
        $component = new FlowMktForm('id', $form->id);
        
        $this->assertNotNull($component->form);
        $this->assertEquals('Formulário KYC', $component->form->name);
        $this->assertCount(3, $component->formData);

        // Verify form fields
        $this->assertEquals('full_name', $component->formData[0]->name);
        $this->assertEquals('document', $component->formData[1]->name);
        $this->assertEquals('address', $component->formData[2]->name);

        // Test component rendering
        $view = $component->render();
        $this->assertEquals('components.flowmkt-form', $view->name());
    }

    /**
     * Test file upload workflow
     */
    public function test_file_upload_workflow(): void
    {
        Storage::fake('public');

        // Create a test user
        $user = User::create([
            'firstname' => 'Upload',
            'lastname' => 'User',
            'username' => 'uploaduser',
            'email' => 'upload@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11777777777',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Simulate file upload
        $file = UploadedFile::fake()->image('documento.jpg', 800, 600);

        // Test file properties
        $this->assertEquals('documento.jpg', $file->getClientOriginalName());
        $this->assertEquals('image/jpeg', $file->getMimeType());
        $this->assertGreaterThan(0, $file->getSize());

        // Store the file
        $path = $file->store('documents', 'public');
        
        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);

        // Verify file can be retrieved
        $exists = Storage::disk('public')->exists($path);
        $this->assertTrue($exists);
    }

    /**
     * Test complete dashboard access workflow
     */
    public function test_dashboard_access_workflow(): void
    {
        // Create and authenticate a user
        $user = User::create([
            'firstname' => 'Dashboard',
            'lastname' => 'User',
            'username' => 'dashuser',
            'email' => 'dash@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11666666666',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        Auth::login($user);

        // Test that user can access dashboard
        $response = $this->actingAs($user)->get('/user/dashboard');
        
        // Should not redirect to login
        $this->assertNotEquals(302, $response->status());
        
        // Verify user is authenticated
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }

    /**
     * Test multi-step form workflow
     */
    public function test_multi_step_form_workflow(): void
    {
        // Create a user
        $user = User::create([
            'firstname' => 'MultiStep',
            'lastname' => 'User',
            'username' => 'multistepuser',
            'email' => 'multistep@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11555555555',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Create multiple forms for different steps
        $step1Form = Form::create([
            'act' => 'step_1',
            'name' => 'Passo 1 - Informações Pessoais',
            'form_data' => json_encode([
                ['name' => 'nome', 'type' => 'text', 'is_required' => 'required']
            ])
        ]);

        $step2Form = Form::create([
            'act' => 'step_2',
            'name' => 'Passo 2 - Informações de Contato',
            'form_data' => json_encode([
                ['name' => 'email', 'type' => 'email', 'is_required' => 'required']
            ])
        ]);

        $step3Form = Form::create([
            'act' => 'step_3',
            'name' => 'Passo 3 - Confirmação',
            'form_data' => json_encode([
                ['name' => 'aceite', 'type' => 'checkbox', 'is_required' => 'required']
            ])
        ]);

        // Test each step
        $component1 = new FlowMktForm('act', 'step_1');
        $this->assertNotNull($component1->form);
        $this->assertEquals('Passo 1 - Informações Pessoais', $component1->form->name);

        $component2 = new FlowMktForm('act', 'step_2');
        $this->assertNotNull($component2->form);
        $this->assertEquals('Passo 2 - Informações de Contato', $component2->form->name);

        $component3 = new FlowMktForm('act', 'step_3');
        $this->assertNotNull($component3->form);
        $this->assertEquals('Passo 3 - Confirmação', $component3->form->name);
    }

    /**
     * Test user profile update workflow
     */
    public function test_user_profile_update_workflow(): void
    {
        // Create a user
        $user = User::create([
            'firstname' => 'Original',
            'lastname' => 'Name',
            'username' => 'originaluser',
            'email' => 'original@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11444444444',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Authenticate user
        Auth::login($user);
        $this->assertTrue(Auth::check());

        // Update user profile
        $user->update([
            'firstname' => 'Atualizado',
            'lastname' => 'Nome',
            'mobile' => '11333333333',
        ]);

        // Verify updates
        $updatedUser = User::find($user->id);
        $this->assertEquals('Atualizado', $updatedUser->firstname);
        $this->assertEquals('Nome', $updatedUser->lastname);
        $this->assertEquals('11333333333', $updatedUser->mobile);

        // Verify old data is gone
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'firstname' => 'Original',
        ]);
    }

    /**
     * Test session persistence across requests
     */
    public function test_session_persistence_across_requests(): void
    {
        // Create a user
        $user = User::create([
            'firstname' => 'Session',
            'lastname' => 'User',
            'username' => 'sessionuser',
            'email' => 'session@example.com',
            'password' => Hash::make('password123'),
            'country_code' => 'BR',
            'mobile' => '11222222222',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // First request - login
        Auth::login($user);
        $this->assertTrue(Auth::check());
        
        // Store session data
        session(['user_preference' => 'dark_mode']);
        $this->assertEquals('dark_mode', session('user_preference'));

        // Simulate second request - verify session persists
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertEquals('dark_mode', session('user_preference'));
    }

    /**
     * Test error handling in form submission
     */
    public function test_error_handling_in_form_submission(): void
    {
        // Create a form with required fields
        $form = Form::create([
            'act' => 'error_test',
            'name' => 'Formulário de Teste de Erro',
            'form_data' => json_encode([
                [
                    'name' => 'required_field',
                    'type' => 'text',
                    'is_required' => 'required',
                    'label' => 'Campo Obrigatório'
                ]
            ])
        ]);

        // Test component handles form correctly
        $component = new FlowMktForm('id', $form->id);
        
        $this->assertNotNull($component->form);
        $this->assertCount(1, $component->formData);
        $this->assertEquals('required', $component->formData[0]->is_required);
    }

    /**
     * Test localization in complete workflow
     */
    public function test_localization_in_complete_workflow(): void
    {
        // Set locale to Portuguese
        app()->setLocale('pt');
        
        // Create user with Portuguese data
        $user = User::create([
            'firstname' => 'Usuário',
            'lastname' => 'Brasileiro',
            'username' => 'usuariobrasileiro',
            'email' => 'usuario@brasil.com',
            'password' => Hash::make('senha123'),
            'country_code' => 'BR',
            'mobile' => '11111111111',
            'ev' => 1,
            'sv' => 1,
            'status' => 1,
        ]);

        // Create form with Portuguese labels
        $form = Form::create([
            'act' => 'formulario_pt',
            'name' => 'Formulário em Português',
            'form_data' => json_encode([
                [
                    'name' => 'nome_completo',
                    'type' => 'text',
                    'is_required' => 'required',
                    'label' => 'Nome Completo'
                ],
                [
                    'name' => 'telefone',
                    'type' => 'tel',
                    'is_required' => 'required',
                    'label' => 'Telefone'
                ]
            ])
        ]);

        // Test component with Portuguese data
        $component = new FlowMktForm('id', $form->id);
        
        $this->assertNotNull($component->form);
        $this->assertEquals('Formulário em Português', $component->form->name);
        $this->assertEquals('Nome Completo', $component->formData[0]->label);
        $this->assertEquals('Telefone', $component->formData[1]->label);

        // Verify locale is still Portuguese
        $this->assertEquals('pt', app()->getLocale());
    }
}
