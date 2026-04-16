<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionRequestController extends Controller
{
    public function index()
    {
        // Changed ->get() to ->paginate(10) so the view's pagination links will work
        if (Auth::user()->isAdmin()) {
            $adoptions = AdoptionRequest::with(['user', 'pet'])->latest()->paginate(10);
        } else {
            $adoptions = Auth::user()->adoptionRequests()->with('pet')->latest()->paginate(10);
        }

        return view('adoptions.index', compact('adoptions'));
    }

    public function create()
    {
        // Redirect back to the pets catalog since adoptions are handled via modals/buttons there
        return redirect()->route('pets.index')->with('success', 'Please select a pet from the catalog to adopt.');
    }

    public function store(Request $request)
    {
        $request->validate(['pet_id' => 'required|exists:pets,id']);

        // Prevent user from requesting the same pet if they already have a pending request
        $exists = AdoptionRequest::where('user_id', Auth::id())
            ->where('pet_id', $request->pet_id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'You already have a pending request for this pet.']);
        }

        AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id' => $request->pet_id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your adoption request has been submitted.');
    }

    public function update(Request $request, AdoptionRequest $adoption)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $adoption->update($validated);
        return back()->with('success', 'Adoption status has been updated.');
    }

    public function destroy(AdoptionRequest $adoption)
    {
        // Allow admins or the owner of the request to delete it
        if (Auth::user()->isAdmin() || Auth::id() === $adoption->user_id) {
            $adoption->delete();
            return back()->with('success', 'Adoption request removed successfully.');
        }

        abort(403, 'Unauthorized action.');
    }
}
