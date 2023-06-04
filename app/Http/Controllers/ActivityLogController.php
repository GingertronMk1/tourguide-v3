<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $activityLogs = ActivityLog::all();

        return view('activityLog.index', compact('activityLogs'));
    }

    public function show(Request $request, ActivityLog $activityLog): View
    {
        return view('activityLog.show', compact('activityLog'));
    }
}
