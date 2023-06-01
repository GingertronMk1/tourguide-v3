<?php

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
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $areas = Area::factory()->count(3)->create();

        $response = $this->get(route('area.index'));

        $response->assertOk();
        $response->assertViewIs('area.index');
        $response->assertViewHas('areas');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('area.create'));

        $response->assertOk();
        $response->assertViewIs('area.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AreaController::class,
            'store',
            \App\Http\Requests\AreaStoreRequest::class
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

        $response = $this->post(route('area.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $areas = Area::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('system', $system)
            ->get();
        $this->assertCount(1, $areas);
        $area = $areas->first();

        $response->assertRedirect(route('area.index'));
        $response->assertSessionHas('area.id', $area->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $area = Area::factory()->create();

        $response = $this->get(route('area.show', $area));

        $response->assertOk();
        $response->assertViewIs('area.show');
        $response->assertViewHas('area');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $area = Area::factory()->create();

        $response = $this->get(route('area.edit', $area));

        $response->assertOk();
        $response->assertViewIs('area.edit');
        $response->assertViewHas('area');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AreaController::class,
            'update',
            \App\Http\Requests\AreaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $area = Area::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $system = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('area.update', $area), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $area->refresh();

        $response->assertRedirect(route('area.index'));
        $response->assertSessionHas('area.id', $area->id);

        $this->assertEquals($name, $area->name);
        $this->assertEquals($description, $area->description);
        $this->assertEquals($notes, $area->notes);
        $this->assertEquals($system, $area->system);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $area = Area::factory()->create();

        $response = $this->delete(route('area.destroy', $area));

        $response->assertRedirect(route('area.index'));

        $this->assertSoftDeleted($area);
    }
}
