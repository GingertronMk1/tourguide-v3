<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessEquipmentStoreRequest;
use App\Http\Requests\AccessEquipmentUpdateRequest;
use App\Models\AccessEquipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccessEquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $accessEquipments = AccessEquipment::all();

        return view('accessEquipment.index', compact('accessEquipments'));
    }

    public function create(Request $request): View
    {
        return view('accessEquipment.create');
    }

    public function store(AccessEquipmentStoreRequest $request): RedirectResponse
    {
        $accessEquipment = AccessEquipment::create($request->validated());

        $request->session()->flash('accessEquipment.id', $accessEquipment->id);

        return redirect()->route('accessEquipment.index');
    }

    public function show(Request $request, AccessEquipment $accessEquipment): View
    {
        return view('accessEquipment.show', compact('accessEquipment'));
    }

    public function edit(Request $request, AccessEquipment $accessEquipment): View
    {
        return view('accessEquipment.edit', compact('accessEquipment'));
    }

    public function update(AccessEquipmentUpdateRequest $request, AccessEquipment $accessEquipment): RedirectResponse
    {
        $accessEquipment->update($request->validated());

        $request->session()->flash('accessEquipment.id', $accessEquipment->id);

        return redirect()->route('accessEquipment.index');
    }

    public function destroy(Request $request, AccessEquipment $accessEquipment): RedirectResponse
    {
        $accessEquipment->delete();

        return redirect()->route('accessEquipment.index');
    }
}
