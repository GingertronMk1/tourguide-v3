<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Area;
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
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $regions = Region::factory()->count(3)->create();

        $response = $this->get(route('region.index'));

        $response->assertOk();
        $response->assertViewIs('region.index');
        $response->assertViewHas('regions');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('region.create'));

        $response->assertOk();
        $response->assertViewIs('region.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'store',
            \App\Http\Requests\RegionStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;
        $area = Area::factory()->create();

        $response = $this->post(route('region.store'), [
            'name' => $name,
            'area_id' => $area->id,
            'description' => $description,
            'notes' => $notes,
        ]);

        $regions = Region::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('area_id', $area->id)
            ->get();
        $this->assertCount(1, $regions);
        $region = $regions->first();

        $response->assertRedirect(route('region.index'));
        $response->assertSessionHas('region.id', $region->id);
    }

    public function testShowDisplaysView(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('region.show', $region));

        $response->assertOk();
        $response->assertViewIs('region.show');
        $response->assertViewHas('region');
    }

    public function testEditDisplaysView(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('region.edit', $region));

        $response->assertOk();
        $response->assertViewIs('region.edit');
        $response->assertViewHas('region');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'update',
            \App\Http\Requests\RegionUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $region = Region::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;
        $area = Area::factory()->create();

        $response = $this->put(route('region.update', $region), [
            'name' => $name,
            'area_id' => $area->id,
            'description' => $description,
            'notes' => $notes,
        ]);

        $region->refresh();

        $response->assertRedirect(route('region.index'));
        $response->assertSessionHas('region.id', $region->id);

        $this->assertEquals($name, $region->name);
        $this->assertEquals($area->id, $region->area_id);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $region = Region::factory()->create();

        $response = $this->delete(route('region.destroy', $region));

        $response->assertRedirect(route('region.index'));

        $this->assertSoftDeleted($region);
    }
}
