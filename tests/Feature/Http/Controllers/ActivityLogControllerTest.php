<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ActivityLogController
 */
class ActivityLogControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $activityLogs = ActivityLog::factory()->count(3)->create();

        $response = $this->get(route('activity-log.index'));

        $response->assertOk();
        $response->assertViewIs('activityLog.index');
        $response->assertViewHas('activityLogs');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('activity-log.create'));

        $response->assertOk();
        $response->assertViewIs('activityLog.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityLogController::class,
            'store',
            \App\Http\Requests\ActivityLogStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $event_type = $this->faker->word;
        $old_data = [];
        $new_data = [];

        $response = $this->post(route('activity-log.store'), [
            'event_type' => $event_type,
            'old_data' => $old_data,
            'new_data' => $new_data,
        ]);

        $activityLogs = ActivityLog::query()
            ->where('event_type', $event_type)
            ->where('old_data', $old_data)
            ->where('new_data', $new_data)
            ->get();
        $this->assertCount(1, $activityLogs);
        $activityLog = $activityLogs->first();

        $response->assertRedirect(route('activityLog.index'));
        $response->assertSessionHas('activityLog.id', $activityLog->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $activityLog = ActivityLog::factory()->create();

        $response = $this->get(route('activity-log.show', $activityLog));

        $response->assertOk();
        $response->assertViewIs('activityLog.show');
        $response->assertViewHas('activityLog');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $activityLog = ActivityLog::factory()->create();

        $response = $this->get(route('activity-log.edit', $activityLog));

        $response->assertOk();
        $response->assertViewIs('activityLog.edit');
        $response->assertViewHas('activityLog');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityLogController::class,
            'update',
            \App\Http\Requests\ActivityLogUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $activityLog = ActivityLog::factory()->create();
        $event_type = $this->faker->word;
        $old_data = [];
        $new_data = [];

        $response = $this->put(route('activity-log.update', $activityLog), [
            'event_type' => $event_type,
            'old_data' => $old_data,
            'new_data' => $new_data,
        ]);

        $activityLog->refresh();

        $response->assertRedirect(route('activityLog.index'));
        $response->assertSessionHas('activityLog.id', $activityLog->id);

        $this->assertEquals($event_type, $activityLog->event_type);
        $this->assertEquals($old_data, $activityLog->old_data);
        $this->assertEquals($new_data, $activityLog->new_data);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $activityLog = ActivityLog::factory()->create();

        $response = $this->delete(route('activity-log.destroy', $activityLog));

        $response->assertRedirect(route('activityLog.index'));

        $this->assertModelMissing($activityLog);
    }
}
