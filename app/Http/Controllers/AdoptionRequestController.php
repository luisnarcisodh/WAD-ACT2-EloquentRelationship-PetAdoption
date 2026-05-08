<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdoptionRequestController extends Controller
{
    use AuthorizesRequests;

    // READ
    public function index()
    {
        $query = AdoptionRequest::with(['user', 'pet']);

        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $adoptions = $query->latest()->paginate(10);
        return view('adoptions.index', compact('adoptions'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'notes'  => 'nullable|string|max:500'
        ]);

        $exists = AdoptionRequest::where('user_id', Auth::id())
            ->where('pet_id', $request->pet_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have an active request for this pet.');
        }

        AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id'  => $request->pet_id,
            'notes'   => $request->notes,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Your adoption request has been submitted successfully.');
    }

    // UPDATE
    public function update(Request $request, AdoptionRequest $adoption)
    {
        $this->authorize('update', $adoption); // Policy Check (Admin Only)

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $adoption->update([
            'status' => $validated['status'],
            'reviewed_at' => now()
        ]);

        if ($validated['status'] === 'approved') {
            $adoption->pet->update(['status' => 'adopted']);
        } elseif ($validated['status'] === 'rejected' && $adoption->getOriginal('status') === 'approved') {
            $adoption->pet->update(['status' => 'available']);
        }

        return back()->with('success', 'Adoption status updated successfully.');
    }

    // DELETE
    public function destroy(AdoptionRequest $adoption)
    {
        $this->authorize('delete', $adoption); // Policy Check (Owner or Admin Only)

        $adoption->delete();
        return back()->with('success', 'Adoption request removed.');
    }
}
