<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ActivityLogController
 */
class ActivityLogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexDisplaysView(): void
    {
        $activityLogs = ActivityLog::factory()->count(3)->create();

        $response = $this->get(route('activity-log.index'));

        $response->assertOk();
        $response->assertViewIs('activityLog.index');
        $response->assertViewHas('activityLogs');
    }

    public function testShowDisplaysView(): void
    {
        $activityLog = ActivityLog::factory()->create();

        $response = $this->get(route('activity-log.show', $activityLog));

        $response->assertOk();
        $response->assertViewIs('activityLog.show');
        $response->assertViewHas('activityLog');
    }
}
