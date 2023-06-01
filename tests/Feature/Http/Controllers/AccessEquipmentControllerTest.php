<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AccessEquipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccessEquipmentController
 */
class AccessEquipmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $accessEquipments = AccessEquipment::factory()->count(3)->create();

        $response = $this->get(route('access-equipment.index'));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.index');
        $response->assertViewHas('accessEquipments');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('access-equipment.create'));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessEquipmentController::class,
            'store',
            \App\Http\Requests\AccessEquipmentStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $system = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('access-equipment.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $accessEquipments = AccessEquipment::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('system', $system)
            ->get();
        $this->assertCount(1, $accessEquipments);
        $accessEquipment = $accessEquipments->first();

        $response->assertRedirect(route('accessEquipment.index'));
        $response->assertSessionHas('accessEquipment.id', $accessEquipment->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->get(route('access-equipment.show', $accessEquipment));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.show');
        $response->assertViewHas('accessEquipment');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->get(route('access-equipment.edit', $accessEquipment));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.edit');
        $response->assertViewHas('accessEquipment');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessEquipmentController::class,
            'update',
            \App\Http\Requests\AccessEquipmentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $system = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('access-equipment.update', $accessEquipment), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $accessEquipment->refresh();

        $response->assertRedirect(route('accessEquipment.index'));
        $response->assertSessionHas('accessEquipment.id', $accessEquipment->id);

        $this->assertEquals($name, $accessEquipment->name);
        $this->assertEquals($description, $accessEquipment->description);
        $this->assertEquals($notes, $accessEquipment->notes);
        $this->assertEquals($system, $accessEquipment->system);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->delete(route('access-equipment.destroy', $accessEquipment));

        $response->assertRedirect(route('accessEquipment.index'));

        $this->assertSoftDeleted($accessEquipment);
    }
}
