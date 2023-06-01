<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueController
 */
class VenueControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $venues = Venue::factory()->count(3)->create();

        $response = $this->get(route('venue.index'));

        $response->assertOk();
        $response->assertViewIs('venue.index');
        $response->assertViewHas('venues');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('venue.create'));

        $response->assertOk();
        $response->assertViewIs('venue.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueController::class,
            'store',
            \App\Http\Requests\VenueStoreRequest::class
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
        $street_address = $this->faker->text;
        $city = $this->faker->city;
        $maximum_stage_width = $this->faker->randomNumber();
        $maximum_stage_depth = $this->faker->randomNumber();
        $maximum_stage_height = $this->faker->randomNumber();
        $maximum_seats = $this->faker->randomNumber();
        $maximum_wheelchair_seats = $this->faker->randomNumber();
        $number_of_dressing_rooms = $this->faker->randomNumber();
        $backstage_wheelchair_access = $this->faker->boolean;

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
            ->get();
        $this->assertCount(1, $venues);
        $venue = $venues->first();

        $response->assertRedirect(route('venue.index'));
        $response->assertSessionHas('venue.id', $venue->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->get(route('venue.show', $venue));

        $response->assertOk();
        $response->assertViewIs('venue.show');
        $response->assertViewHas('venue');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->get(route('venue.edit', $venue));

        $response->assertOk();
        $response->assertViewIs('venue.edit');
        $response->assertViewHas('venue');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VenueController::class,
            'update',
            \App\Http\Requests\VenueUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $venue = Venue::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $street_address = $this->faker->text;
        $city = $this->faker->city;
        $maximum_stage_width = $this->faker->randomNumber();
        $maximum_stage_depth = $this->faker->randomNumber();
        $maximum_stage_height = $this->faker->randomNumber();
        $maximum_seats = $this->faker->randomNumber();
        $maximum_wheelchair_seats = $this->faker->randomNumber();
        $number_of_dressing_rooms = $this->faker->randomNumber();
        $backstage_wheelchair_access = $this->faker->boolean;

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
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $venue = Venue::factory()->create();

        $response = $this->delete(route('venue.destroy', $venue));

        $response->assertRedirect(route('venue.index'));

        $this->assertModelMissing($venue);
    }
}
