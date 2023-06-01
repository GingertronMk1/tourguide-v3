<?php

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
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $venueTypes = VenueType::factory()->count(3)->create();

        $response = $this->get(route('venue-type.index'));

        $response->assertOk();
        $response->assertViewIs('venueType.index');
        $response->assertViewHas('venueTypes');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('venue-type.create'));

        $response->assertOk();
        $response->assertViewIs('venueType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueTypeController::class,
            'store',
            \App\Http\Requests\VenueTypeStoreRequest::class
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

        $response = $this->post(route('venue-type.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $venueTypes = VenueType::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('system', $system)
            ->get();
        $this->assertCount(1, $venueTypes);
        $venueType = $venueTypes->first();

        $response->assertRedirect(route('venueType.index'));
        $response->assertSessionHas('venueType.id', $venueType->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->get(route('venue-type.show', $venueType));

        $response->assertOk();
        $response->assertViewIs('venueType.show');
        $response->assertViewHas('venueType');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->get(route('venue-type.edit', $venueType));

        $response->assertOk();
        $response->assertViewIs('venueType.edit');
        $response->assertViewHas('venueType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueTypeController::class,
            'update',
            \App\Http\Requests\VenueTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $venueType = VenueType::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $system = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('venue-type.update', $venueType), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $venueType->refresh();

        $response->assertRedirect(route('venueType.index'));
        $response->assertSessionHas('venueType.id', $venueType->id);

        $this->assertEquals($name, $venueType->name);
        $this->assertEquals($description, $venueType->description);
        $this->assertEquals($notes, $venueType->notes);
        $this->assertEquals($system, $venueType->system);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $venueType = VenueType::factory()->create();

        $response = $this->delete(route('venue-type.destroy', $venueType));

        $response->assertRedirect(route('venueType.index'));

        $this->assertSoftDeleted($venueType);
    }
}
