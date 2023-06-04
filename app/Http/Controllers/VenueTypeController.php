<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueTypeStoreRequest;
use App\Http\Requests\VenueTypeUpdateRequest;
use App\Models\VenueType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VenueTypeController extends Controller
{
    public function index(Request $request): View
    {
        $venueTypes = VenueType::all();

        return view('venueType.index', compact('venueTypes'));
    }

    public function create(Request $request): View
    {
        return view('venueType.create');
    }

    public function store(VenueTypeStoreRequest $request): RedirectResponse
    {
        $venueType = VenueType::create($request->validated());

        $request->session()->flash('venueType.id', $venueType->id);

        return redirect()->route('venue-type.index');
    }

    public function show(Request $request, VenueType $venueType): View
    {
        return view('venueType.show', compact('venueType'));
    }

    public function edit(Request $request, VenueType $venueType): View
    {
        return view('venueType.edit', compact('venueType'));
    }

    public function update(VenueTypeUpdateRequest $request, VenueType $venueType): RedirectResponse
    {
        $venueType->update($request->validated());

        $request->session()->flash('venueType.id', $venueType->id);

        return redirect()->route('venue-type.index');
    }

    public function destroy(Request $request, VenueType $venueType): RedirectResponse
    {
        $venueType->delete();

        return redirect()->route('venue-type.index');
    }
}
