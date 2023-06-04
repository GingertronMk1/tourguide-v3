<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Area;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AreaController
 */
class AreaControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $areas = Area::factory()->count(3)->create();

        $response = $this->get(route('area.index'));

        $response->assertOk();
        $response->assertViewIs('area.index');
        $response->assertViewHas('areas');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('area.create'));

        $response->assertOk();
        $response->assertViewIs('area.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AreaController::class,
            'store',
            \App\Http\Requests\AreaStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
        $description = $this->faker->paragraph;
        $notes = $this->faker->paragraph;
        $response = $this->post(route('area.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
        ]);

        $areas = Area::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $areas);
        $area = $areas->first();

        $response->assertRedirect(route('area.index'));
        $response->assertSessionHas('area.id', $area->id);
    }

    public function testShowDisplaysView(): void
    {
        $area = Area::factory()->create();

        $response = $this->get(route('area.show', $area));

        $response->assertOk();
        $response->assertViewIs('area.show');
        $response->assertViewHas('area');
    }

    public function testEditDisplaysView(): void
    {
        $area = Area::factory()->create();

        $response = $this->get(route('area.edit', $area));

        $response->assertOk();
        $response->assertViewIs('area.edit');
        $response->assertViewHas('area');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AreaController::class,
            'update',
            \App\Http\Requests\AreaUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $area = Area::factory()->create();
        $name = $this->faker->name;
$description = $this->faker->paragraph;
$notes = $this->faker->paragraph;
$response = $this->put(route('area.update', $area), [
    'name' => $name,
    'description' => $description,
    'notes' => $notes,
]);

        $area->refresh();

        $response->assertRedirect(route('area.index'));
        $response->assertSessionHas('area.id', $area->id);

        $this->assertEquals($name, $area->name);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $area = Area::factory()->create();

        $response = $this->delete(route('area.destroy', $area));

        $response->assertRedirect(route('area.index'));

        $this->assertSoftDeleted($area);
    }
}
