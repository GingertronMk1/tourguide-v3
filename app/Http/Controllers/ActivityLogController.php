<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityLogStoreRequest;
use App\Http\Requests\ActivityLogUpdateRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $activityLogs = ActivityLog::all();

        return view('activityLog.index', compact('activityLogs'));
    }

    public function create(Request $request): View
    {
        return view('activityLog.create');
    }

    public function store(ActivityLogStoreRequest $request): RedirectResponse
    {
        $activityLog = ActivityLog::create($request->validated());

        $request->session()->flash('activityLog.id', $activityLog->id);

        return redirect()->route('activityLog.index');
    }

    public function show(Request $request, ActivityLog $activityLog): View
    {
        return view('activityLog.show', compact('activityLog'));
    }

    public function edit(Request $request, ActivityLog $activityLog): View
    {
        return view('activityLog.edit', compact('activityLog'));
    }

    public function update(ActivityLogUpdateRequest $request, ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->update($request->validated());

        $request->session()->flash('activityLog.id', $activityLog->id);

        return redirect()->route('activityLog.index');
    }

    public function destroy(Request $request, ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()->route('activityLog.index');
    }
}
