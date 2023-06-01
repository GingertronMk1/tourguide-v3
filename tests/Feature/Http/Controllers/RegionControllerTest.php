<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RegionController
 */
class RegionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $regions = Region::factory()->count(3)->create();

        $response = $this->get(route('region.index'));

        $response->assertOk();
        $response->assertViewIs('region.index');
        $response->assertViewHas('regions');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('region.create'));

        $response->assertOk();
        $response->assertViewIs('region.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'store',
            \App\Http\Requests\RegionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name;

        $response = $this->post(route('region.store'), [
            'name' => $name,
        ]);

        $regions = Region::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $regions);
        $region = $regions->first();

        $response->assertRedirect(route('region.index'));
        $response->assertSessionHas('region.id', $region->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('region.show', $region));

        $response->assertOk();
        $response->assertViewIs('region.show');
        $response->assertViewHas('region');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('region.edit', $region));

        $response->assertOk();
        $response->assertViewIs('region.edit');
        $response->assertViewHas('region');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'update',
            \App\Http\Requests\RegionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $region = Region::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('region.update', $region), [
            'name' => $name,
        ]);

        $region->refresh();

        $response->assertRedirect(route('region.index'));
        $response->assertSessionHas('region.id', $region->id);

        $this->assertEquals($name, $region->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $region = Region::factory()->create();

        $response = $this->delete(route('region.destroy', $region));

        $response->assertRedirect(route('region.index'));

        $this->assertSoftDeleted($region);
    }
}
