<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\DealType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DealTypeController
 */
class DealTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $dealTypes = DealType::factory()->count(3)->create();

        $response = $this->get(route('deal-type.index'));

        $response->assertOk();
        $response->assertViewIs('dealType.index');
        $response->assertViewHas('dealTypes');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('deal-type.create'));

        $response->assertOk();
        $response->assertViewIs('dealType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DealTypeController::class,
            'store',
            \App\Http\Requests\DealTypeStoreRequest::class
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

        $response = $this->post(route('deal-type.store'), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $dealTypes = DealType::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('notes', $notes)
            ->where('system', $system)
            ->get();
        $this->assertCount(1, $dealTypes);
        $dealType = $dealTypes->first();

        $response->assertRedirect(route('dealType.index'));
        $response->assertSessionHas('dealType.id', $dealType->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->get(route('deal-type.show', $dealType));

        $response->assertOk();
        $response->assertViewIs('dealType.show');
        $response->assertViewHas('dealType');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->get(route('deal-type.edit', $dealType));

        $response->assertOk();
        $response->assertViewIs('dealType.edit');
        $response->assertViewHas('dealType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DealTypeController::class,
            'update',
            \App\Http\Requests\DealTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $dealType = DealType::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $notes = $this->faker->text;
        $system = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('deal-type.update', $dealType), [
            'name' => $name,
            'description' => $description,
            'notes' => $notes,
            'system' => $system,
        ]);

        $dealType->refresh();

        $response->assertRedirect(route('dealType.index'));
        $response->assertSessionHas('dealType.id', $dealType->id);

        $this->assertEquals($name, $dealType->name);
        $this->assertEquals($description, $dealType->description);
        $this->assertEquals($notes, $dealType->notes);
        $this->assertEquals($system, $dealType->system);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->delete(route('deal-type.destroy', $dealType));

        $response->assertRedirect(route('dealType.index'));

        $this->assertSoftDeleted($dealType);
    }
}
