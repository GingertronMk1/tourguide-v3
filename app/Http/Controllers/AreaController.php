<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaStoreRequest;
use App\Http\Requests\AreaUpdateRequest;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(Request $request): View
    {
        $areas = Area::all();

        return view('area.index', compact('areas'));
    }

    public function create(Request $request): View
    {
        return view('area.create');
    }

    public function store(AreaStoreRequest $request): RedirectResponse
    {
        $area = Area::create($request->validated());

        $request->session()->flash('area.id', $area->id);

        return redirect()->route('area.index');
    }

    public function show(Request $request, Area $area): View
    {
        return view('area.show', compact('area'));
    }

    public function edit(Request $request, Area $area): View
    {
        return view('area.edit', compact('area'));
    }

    public function update(AreaUpdateRequest $request, Area $area): RedirectResponse
    {
        $area->update($request->validated());

        $request->session()->flash('area.id', $area->id);

        return redirect()->route('area.index');
    }

    public function destroy(Request $request, Area $area): RedirectResponse
    {
        $area->delete();

        return redirect()->route('area.index');
    }
}
