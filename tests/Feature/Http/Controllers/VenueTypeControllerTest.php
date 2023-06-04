<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\VenueType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueTypeController
 */
class VenueTypeControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $venueTypes = VenueType::factory()->count(3)->create();

        $response = $this->get(route('venue-type.index'));

        $response->assertOk();
        $response->assertViewIs('venueType.index');
        $response->assertViewHas('venueTypes');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('venue-type.create'));

        $response->assertOk();
        $response->assertViewIs('venueType.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueTypeController::class,
            'store',
            \App\Http\Requests\VenueTypeStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;

        $response = $this->post(route('venue-type.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
        ]);

        $venueTypes = VenueType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $venueTypes);
        $venueType = $venueTypes->first();

        $response->assertRedirect(route('venue-type.index'));
        $response->assertSessionHas('venueType.id', $venueType->id);
    }

    public function testShowDisplaysView(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->get(route('venue-type.show', $venueType));

        $response->assertOk();
        $response->assertViewIs('venueType.show');
        $response->assertViewHas('venueType');
    }

    public function testEditDisplaysView(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->get(route('venue-type.edit', $venueType));

        $response->assertOk();
        $response->assertViewIs('venueType.edit');
        $response->assertViewHas('venueType');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueTypeController::class,
            'update',
            \App\Http\Requests\VenueTypeUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $venueType = VenueType::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;

        $response = $this->put(route('venue-type.update', $venueType), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
        ]);

        $venueType->refresh();

        $response->assertRedirect(route('venue-type.index'));
        $response->assertSessionHas('venueType.id', $venueType->id);

        $this->assertEquals($name, $venueType->name);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->delete(route('venue-type.destroy', $venueType));

        $response->assertRedirect(route('venue-type.index'));

        $this->assertSoftDeleted($venueType);
    }
}
