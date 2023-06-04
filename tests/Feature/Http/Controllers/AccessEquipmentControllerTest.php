<?php

declare(strict_types=1);

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
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $accessEquipments = AccessEquipment::factory()->count(3)->create();

        $response = $this->get(route('access-equipment.index'));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.index');
        $response->assertViewHas('accessEquipments');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('access-equipment.create'));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessEquipmentController::class,
            'store',
            \App\Http\Requests\AccessEquipmentStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;

        $response = $this->post(route('access-equipment.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
        ]);

        $accessEquipments = AccessEquipment::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $accessEquipments);
        $accessEquipment = $accessEquipments->first();

        $response->assertRedirect(route('access-equipment.index'));
        $response->assertSessionHas('accessEquipment.id', $accessEquipment->id);
    }

    public function testShowDisplaysView(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->get(route('access-equipment.show', $accessEquipment));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.show');
        $response->assertViewHas('accessEquipment');
    }

    public function testEditDisplaysView(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->get(route('access-equipment.edit', $accessEquipment));

        $response->assertOk();
        $response->assertViewIs('accessEquipment.edit');
        $response->assertViewHas('accessEquipment');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessEquipmentController::class,
            'update',
            \App\Http\Requests\AccessEquipmentUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;

        $response = $this->put(route('access-equipment.update', $accessEquipment), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
        ]);

        $accessEquipment->refresh();

        $response->assertRedirect(route('access-equipment.index'));
        $response->assertSessionHas('accessEquipment.id', $accessEquipment->id);

        $this->assertEquals($name, $accessEquipment->name);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $accessEquipment = AccessEquipment::factory()->create();

        $response = $this->delete(route('access-equipment.destroy', $accessEquipment));

        $response->assertRedirect(route('access-equipment.index'));

        $this->assertSoftDeleted($accessEquipment);
    }
}
