<?php

declare(strict_types=1);

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
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function testIndexDisplaysView(): void
    {
        $dealTypes = DealType::factory()->count(3)->create();

        $response = $this->get(route('deal-type.index'));

        $response->assertOk();
        $response->assertViewIs('dealType.index');
        $response->assertViewHas('dealTypes');
    }

    public function testCreateDisplaysView(): void
    {
        $response = $this->get(route('deal-type.create'));

        $response->assertOk();
        $response->assertViewIs('dealType.create');
    }

    public function testStoreUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DealTypeController::class,
            'store',
            \App\Http\Requests\DealTypeStoreRequest::class
        );
    }

    public function testStoreSavesAndRedirects(): void
    {
        $name = $this->faker->name;
$description = $this->faker->paragraph;
$notes = $this->faker->paragraph;
$response = $this->post(route('deal-type.store'), [
    'name' => $name,
    'description' => $description,
    'notes' => $notes,
]);

        $dealTypes = DealType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $dealTypes);
        $dealType = $dealTypes->first();

        $response->assertRedirect(route('deal-type.index'));
        $response->assertSessionHas('dealType.id', $dealType->id);
    }

    public function testShowDisplaysView(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->get(route('deal-type.show', $dealType));

        $response->assertOk();
        $response->assertViewIs('dealType.show');
        $response->assertViewHas('dealType');
    }

    public function testEditDisplaysView(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->get(route('deal-type.edit', $dealType));

        $response->assertOk();
        $response->assertViewIs('dealType.edit');
        $response->assertViewHas('dealType');
    }

    public function testUpdateUsesFormRequestValidation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DealTypeController::class,
            'update',
            \App\Http\Requests\DealTypeUpdateRequest::class
        );
    }

    public function testUpdateRedirects(): void
    {
        $dealType = DealType::factory()->create();
        $name = $this->faker->name;
$description = $this->faker->paragraph;
$notes = $this->faker->paragraph;
$response = $this->put(route('deal-type.update', $dealType), [
    'name' => $name,
    'description' => $description,
    'notes' => $notes,
]);

        $dealType->refresh();

        $response->assertRedirect(route('deal-type.index'));
        $response->assertSessionHas('dealType.id', $dealType->id);

        $this->assertEquals($name, $dealType->name);
    }

    public function testDestroyDeletesAndRedirects(): void
    {
        $dealType = DealType::factory()->create();

        $response = $this->delete(route('deal-type.destroy', $dealType));

        $response->assertRedirect(route('deal-type.index'));

        $this->assertSoftDeleted($dealType);
    }
}
