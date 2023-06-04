<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DealTypeStoreRequest;
use App\Http\Requests\DealTypeUpdateRequest;
use App\Models\DealType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealTypeController extends Controller
{
    public function index(Request $request): View
    {
        $dealTypes = DealType::all();

        return view('dealType.index', compact('dealTypes'));
    }

    public function create(Request $request): View
    {
        return view('dealType.create');
    }

    public function store(DealTypeStoreRequest $request): RedirectResponse
    {
        $dealType = DealType::create($request->validated());

        $request->session()->flash('dealType.id', $dealType->id);

        return redirect()->route('deal-type.index');
    }

    public function show(Request $request, DealType $dealType): View
    {
        return view('dealType.show', compact('dealType'));
    }

    public function edit(Request $request, DealType $dealType): View
    {
        return view('dealType.edit', compact('dealType'));
    }

    public function update(DealTypeUpdateRequest $request, DealType $dealType): RedirectResponse
    {
        $dealType->update($request->validated());

        $request->session()->flash('dealType.id', $dealType->id);

        return redirect()->route('deal-type.index');
    }

    public function destroy(Request $request, DealType $dealType): RedirectResponse
    {
        $dealType->delete();

        return redirect()->route('deal-type.index');
    }
}
