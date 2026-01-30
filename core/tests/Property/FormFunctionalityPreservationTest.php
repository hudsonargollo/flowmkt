<?php

namespace Tests\Property;

use Tests\TestCase;
use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\View\Components\FlowMktForm;

/**
 * @test
 * Feature: flowmlkt-rebranding-localization, Property 12: Form Functionality Preservation
 * 
 * Property: For any form submission after component renaming (FlowMktForm), 
 * the form should submit successfully and process data correctly
 * 
 * Validates: Requirements 10.1, 10.2
 */
class FormFunctionalityPreservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that FlowMktForm component can be instantiated with various identifiers
     */
    public function test_flowmkt_form_component_instantiates_with_different_identifiers(): void
    {
        // Create test forms with different identifiers
        $form1 = Form::create([
            'act' => 'test_action_1',
            'name' => 'Test Form 1',
            'form_data' => json_encode([
                ['name' => 'field1', 'type' => 'text', 'is_required' => 'required']
            ])
        ]);

        $form2 = Form::create([
            'act' => 'test_action_2',
            'name' => 'Test Form 2',
            'form_data' => json_encode([
                ['name' => 'field2', 'type' => 'email', 'is_required' => 'required']
            ])
        ]);

        // Test instantiation with 'id' identifier
        $component1 = new FlowMktForm('id', $form1->id);
        $this->assertNotNull($component1->form);
        $this->assertEquals($form1->id, $component1->form->id);
        $this->assertIsArray($component1->formData);

        // Test instantiation with 'act' identifier
        $component2 = new FlowMktForm('act', 'test_action_2');
        $this->assertNotNull($component2->form);
        $this->assertEquals('test_action_2', $component2->form->act);
        $this->assertIsArray($component2->formData);
    }

    /**
     * Test that FlowMktForm component renders correctly
     */
    public function test_flowmkt_form_component_renders_view(): void
    {
        $form = Form::create([
            'act' => 'test_render',
            'name' => 'Render Test Form',
            'form_data' => json_encode([
                ['name' => 'test_field', 'type' => 'text', 'is_required' => 'required']
            ])
        ]);

        $component = new FlowMktForm('id', $form->id);
        $view = $component->render();

        $this->assertNotNull($view);
        $this->assertEquals('components.flowmkt-form', $view->name());
    }

    /**
     * Test that FlowMktForm handles missing forms gracefully
     */
    public function test_flowmkt_form_handles_missing_form_gracefully(): void
    {
        // Test with non-existent ID
        $component = new FlowMktForm('id', 99999);
        
        $this->assertNull($component->form);
        $this->assertIsArray($component->formData);
        $this->assertEmpty($component->formData);
    }

    /**
     * Test that FlowMktForm preserves form data structure
     */
    public function test_flowmkt_form_preserves_form_data_structure(): void
    {
        $formData = [
            ['name' => 'username', 'type' => 'text', 'is_required' => 'required'],
            ['name' => 'email', 'type' => 'email', 'is_required' => 'required'],
            ['name' => 'phone', 'type' => 'tel', 'is_required' => 'optional']
        ];

        $form = Form::create([
            'act' => 'test_structure',
            'name' => 'Structure Test Form',
            'form_data' => json_encode($formData)
        ]);

        $component = new FlowMktForm('id', $form->id);
        
        $this->assertCount(3, $component->formData);
        $this->assertEquals('username', $component->formData[0]->name);
        $this->assertEquals('email', $component->formData[1]->name);
        $this->assertEquals('phone', $component->formData[2]->name);
    }

    /**
     * Test that form component works with empty form_data
     */
    public function test_flowmkt_form_handles_empty_form_data(): void
    {
        $form = Form::create([
            'act' => 'test_empty',
            'name' => 'Empty Form',
            'form_data' => null
        ]);

        $component = new FlowMktForm('id', $form->id);
        
        $this->assertNotNull($component->form);
        $this->assertIsArray($component->formData);
        $this->assertEmpty($component->formData);
    }

    /**
     * Test that multiple FlowMktForm instances can coexist
     */
    public function test_multiple_flowmkt_form_instances_coexist(): void
    {
        $form1 = Form::create([
            'act' => 'form_1',
            'name' => 'Form 1',
            'form_data' => json_encode([['name' => 'field1', 'type' => 'text']])
        ]);

        $form2 = Form::create([
            'act' => 'form_2',
            'name' => 'Form 2',
            'form_data' => json_encode([['name' => 'field2', 'type' => 'email']])
        ]);

        $component1 = new FlowMktForm('id', $form1->id);
        $component2 = new FlowMktForm('id', $form2->id);

        $this->assertNotEquals($component1->form->id, $component2->form->id);
        $this->assertEquals('Form 1', $component1->form->name);
        $this->assertEquals('Form 2', $component2->form->name);
    }
}
