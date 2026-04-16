<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Requests\UpdateAdoptionRequest;
use App\Models\AdoptionRequest;
use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdoptionController extends Controller
{
    public function index(): View
    {
        $query = AdoptionRequest::with(['user', 'pet']);

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $adoptions = $query->latest()->paginate(15);

        return view('adoptions.index', compact('adoptions'));
    }

    public function create(): View
    {
        $pets = Pet::where('status', 'available')->orderBy('name')->get();
        return view('adoptions.create', compact('pets'));
    }

    public function adopt(StoreAdoptionRequest $request): RedirectResponse
    {
        $alreadyRequested = AdoptionRequest::where('user_id', auth()->id())
            ->where('pet_id', $request->pet_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($alreadyRequested) {
            return back()->with('error', 'You already have an active request for this pet.');
        }

        AdoptionRequest::create([
            'user_id' => auth()->id(),
            'pet_id'  => $request->pet_id,
            'notes'   => $request->notes,
            'status'  => 'pending',
        ]);

        return redirect()->route('adoptions.index')
            ->with('success', 'Adoption request submitted successfully.');
    }

    public function show(AdoptionRequest $adoption): View
    {
        if (!auth()->user()->isAdmin() && $adoption->user_id !== auth()->id()) {
            abort(403);
        }

        $adoption->load(['user', 'pet.vaccination', 'pet.vets']);
        return view('adoptions.show', compact('adoption'));
    }

    public function edit(AdoptionRequest $adoption): View
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $adoption->load(['user', 'pet']);
        return view('adoptions.edit', compact('adoption'));
    }

    public function update(UpdateAdoptionRequest $request, AdoptionRequest $adoption): RedirectResponse
    {
        $adoption->update([
            'status'      => $request->status,
            'notes'       => $request->notes,
            'reviewed_at' => now(),
        ]);

        if ($request->status === 'approved') {
            $adoption->pet->update(['status' => 'adopted']);
        } elseif ($request->status === 'rejected') {
            $adoption->pet->update(['status' => 'available']);
        }

        return redirect()->route('adoptions.index')
            ->with('success', 'Adoption request updated.');
    }

    public function destroy(AdoptionRequest $adoption): RedirectResponse
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $adoption->delete();
        return redirect()->route('adoptions.index')
            ->with('success', 'Request deleted.');
    }
}
