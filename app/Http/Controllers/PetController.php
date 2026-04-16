<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use App\Models\Vet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::with(['vaccination', 'vets', 'adoptionRequests'])
            ->latest()
            ->paginate(12);

        return view('pets.index', compact('pets'));
    }

    public function create(): View
    {
        $vets = Vet::orderBy('name')->get();
        return view('pets.create', compact('vets'));
    }

    public function store(StorePetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet = Pet::create($data);

        if ($request->filled('vet_ids')) {
            $pet->vets()->sync($request->vet_ids);
        }

        return redirect()->route('pets.index')
            ->with('success', 'Pet created successfully.');
    }

    public function show(Pet $pet): View
    {
        $pet->load(['vaccination', 'vets', 'adoptionRequests.user']);
        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet): View
    {
        $vets = Vet::orderBy('name')->get();
        $pet->load('vets');
        return view('pets.edit', compact('pet', 'vets'));
    }

    public function update(UpdatePetRequest $request, Pet $pet): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($pet->image) {
                Storage::disk('public')->delete($pet->image);
            }
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($data);

        if ($request->has('vet_ids')) {
            $pet->vets()->sync($request->vet_ids ?? []);
        }

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully.');
    }

    public function destroy(Pet $pet): RedirectResponse
    {
        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet deleted successfully.');
    }
}
