<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegionStoreRequest;
use App\Http\Requests\RegionUpdateRequest;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(Request $request): View
    {
        $regions = Region::all();

        return view('region.index', compact('regions'));
    }

    public function create(Request $request): View
    {
        return view('region.create');
    }

    public function store(RegionStoreRequest $request): RedirectResponse
    {
        $region = Region::create($request->validated());

        $request->session()->flash('region.id', $region->id);

        return redirect()->route('region.index');
    }

    public function show(Request $request, Region $region): View
    {
        return view('region.show', compact('region'));
    }

    public function edit(Request $request, Region $region): View
    {
        return view('region.edit', compact('region'));
    }

    public function update(RegionUpdateRequest $request, Region $region): RedirectResponse
    {
        $region->update($request->validated());

        $request->session()->flash('region.id', $region->id);

        return redirect()->route('region.index');
    }

    public function destroy(Request $request, Region $region): RedirectResponse
    {
        $region->delete();

        return redirect()->route('region.index');
    }
}
