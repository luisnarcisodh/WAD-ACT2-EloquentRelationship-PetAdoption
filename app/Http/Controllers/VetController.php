<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVetRequest;
use App\Http\Requests\UpdateVetRequest;
use App\Models\Pet;
use App\Models\Vet;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VetController extends Controller
{
    public function index(): View
    {
        $vets = Vet::with('pets')->latest()->paginate(15);
        return view('vets.index', compact('vets'));
    }

    public function create(): View
    {
        $pets = Pet::orderBy('name')->get();
        return view('vets.create', compact('pets'));
    }

    public function store(StoreVetRequest $request): RedirectResponse
    {
        $vet = Vet::create($request->validated());

        if ($request->filled('pet_ids')) {
            $vet->pets()->sync($request->pet_ids);
        }

        return redirect()->route('vets.index')
            ->with('success', 'Vet added successfully.');
    }

    public function show(Vet $vet): View
    {
        $vet->load('pets.vaccination');
        return view('vets.show', compact('vet'));
    }

    public function edit(Vet $vet): View
    {
        $pets = Pet::orderBy('name')->get();
        $vet->load('pets');
        return view('vets.edit', compact('vet', 'pets'));
    }

    public function update(UpdateVetRequest $request, Vet $vet): RedirectResponse
    {
        $vet->update($request->validated());

        if ($request->has('pet_ids')) {
            $vet->pets()->sync($request->pet_ids ?? []);
        }

        return redirect()->route('vets.index')
            ->with('success', 'Vet updated successfully.');
    }

    public function assignVet(Vet $vet, Pet $pet): RedirectResponse
    {
        $vet->pets()->syncWithoutDetaching([$pet->id]);
        return back()->with('success', 'Vet assigned successfully.');
    }

    public function destroy(Vet $vet): RedirectResponse
    {
        $vet->delete();
        return redirect()->route('vets.index')
            ->with('success', 'Vet removed successfully.');
    }
}
