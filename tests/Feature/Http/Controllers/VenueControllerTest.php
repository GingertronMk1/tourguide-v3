<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Region;
use App\Models\Venue;
use App\Models\VenueType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueController
 */
class VenueControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $venues = Venue::factory()->count(3)->create();

        $response = $this->get(route('venue.index'));

        $response->assertOk();
        $response->assertViewIs('venue.index');
        $response->assertViewHas('venues');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('venue.create'));

        $response->assertOk();
        $response->assertViewIs('venue.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueController::class,
            'store',
            \App\Http\Requests\VenueStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;
        $street_address = $this->faker->text;
        $city = $this->faker->city;
        $maximum_stage_width = $this->faker->numberBetween(1);
        $maximum_stage_depth = $this->faker->numberBetween(1);
        $maximum_stage_height = $this->faker->numberBetween(1);
        $maximum_seats = $this->faker->numberBetween(1);
        $maximum_wheelchair_seats = $this->faker->numberBetween(1);
        $number_of_dressing_rooms = $this->faker->numberBetween(1);
        $backstage_wheelchair_access = $this->faker->boolean;
        $region = Region::factory()->create();
        $venue_type = VenueType::factory()->create();

        $response = $this->post(route('venue.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'street_address' => $street_address,
            'city' => $city,
            'maximum_stage_width' => $maximum_stage_width,
            'maximum_stage_depth' => $maximum_stage_depth,
            'maximum_stage_height' => $maximum_stage_height,
            'maximum_seats' => $maximum_seats,
            'maximum_wheelchair_seats' => $maximum_wheelchair_seats,
            'number_of_dressing_rooms' => $number_of_dressing_rooms,
            'backstage_wheelchair_access' => $backstage_wheelchair_access,
            'region_id' => $region->id,
            'venue_type_id' => $venue_type->id,
        ]);

        $venues = Venue::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('street_address', $street_address)
            ->where('city', $city)
            ->where('maximum_stage_width', $maximum_stage_width)
            ->where('maximum_stage_depth', $maximum_stage_depth)
            ->where('maximum_stage_height', $maximum_stage_height)
            ->where('maximum_seats', $maximum_seats)
            ->where('maximum_wheelchair_seats', $maximum_wheelchair_seats)
            ->where('number_of_dressing_rooms', $number_of_dressing_rooms)
            ->where('backstage_wheelchair_access', $backstage_wheelchair_access)
            ->where('region_id', $region->id)
            ->where('venue_type_id', $venue_type->id)
            ->get();
        $this->assertCount(1, $venues);
        $venue = $venues->first();

        $response->assertRedirect(route('venue.index'));
        $response->assertSessionHas('venue.id', $venue->id);
    }

    public function testShowDisplaysView(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->get(route('venue.show', $venue));

        $response->assertOk();
        $response->assertViewIs('venue.show');
        $response->assertViewHas('venue');
    }

    public function testEditDisplaysView(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->get(route('venue.edit', $venue));

        $response->assertOk();
        $response->assertViewIs('venue.edit');
        $response->assertViewHas('venue');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueController::class,
            'update',
            \App\Http\Requests\VenueUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $venue = Venue::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;
        $street_address = $this->faker->text;
        $city = $this->faker->city;
        $maximum_stage_width = $this->faker->numberBetween(0, PHP_INT_MAX);
        $maximum_stage_depth = $this->faker->numberBetween(0, PHP_INT_MAX);
        $maximum_stage_height = $this->faker->numberBetween(0, PHP_INT_MAX);
        $maximum_seats = $this->faker->numberBetween(0, PHP_INT_MAX);
        $maximum_wheelchair_seats = $this->faker->numberBetween(0, PHP_INT_MAX);
        $number_of_dressing_rooms = $this->faker->numberBetween(0, PHP_INT_MAX);
        $backstage_wheelchair_access = $this->faker->boolean;
        $region = Region::factory()->create();
        $venue_type = VenueType::factory()->create();

        $response = $this->put(route('venue.update', $venue), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'street_address' => $street_address,
            'city' => $city,
            'maximum_stage_width' => $maximum_stage_width,
            'maximum_stage_depth' => $maximum_stage_depth,
            'maximum_stage_height' => $maximum_stage_height,
            'maximum_seats' => $maximum_seats,
            'maximum_wheelchair_seats' => $maximum_wheelchair_seats,
            'number_of_dressing_rooms' => $number_of_dressing_rooms,
            'backstage_wheelchair_access' => $backstage_wheelchair_access,
            'region_id' => $region->id,
            'venue_type_id' => $venue_type->id,
        ]);

        $venue->refresh();

        $response->assertRedirect(route('venue.index'));
        $response->assertSessionHas('venue.id', $venue->id);

        $this->assertEquals($name, $venue->name);
        $this->assertEquals($description, $venue->description);
        $this->assertEquals($notes, $venue->notes);
        $this->assertEquals($street_address, $venue->street_address);
        $this->assertEquals($city, $venue->city);
        $this->assertEquals($maximum_stage_width, $venue->maximum_stage_width);
        $this->assertEquals($maximum_stage_depth, $venue->maximum_stage_depth);
        $this->assertEquals($maximum_stage_height, $venue->maximum_stage_height);
        $this->assertEquals($maximum_seats, $venue->maximum_seats);
        $this->assertEquals($maximum_wheelchair_seats, $venue->maximum_wheelchair_seats);
        $this->assertEquals($number_of_dressing_rooms, $venue->number_of_dressing_rooms);
        $this->assertEquals($backstage_wheelchair_access, $venue->backstage_wheelchair_access);
        $this->assertEquals($region->id, $venue->region_id);
        $this->assertEquals($venue_type->id, $venue->venue_type_id);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->delete(route('venue.destroy', $venue));

        $response->assertRedirect(route('venue.index'));

        $this->assertModelMissing($venue);
    }
}
