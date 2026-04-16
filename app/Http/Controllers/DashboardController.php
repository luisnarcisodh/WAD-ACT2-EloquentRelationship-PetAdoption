<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\Pet;
use App\Models\User;
use App\Models\Vet;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pets'      => Pet::count(),
            'available_pets'  => Pet::where('status', 'available')->count(),
            'total_vets'      => Vet::count(),
            'pending_adoptions' => AdoptionRequest::where('status', 'pending')->count(),
            'total_users'     => User::count(),
            'approved_adoptions' => AdoptionRequest::where('status', 'approved')->count(),
        ];

        $recentPets = Pet::with('vaccination')->latest()->take(6)->get();
        $recentAdoptions = AdoptionRequest::with(['user', 'pet'])->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentPets', 'recentAdoptions'));
    }
}
