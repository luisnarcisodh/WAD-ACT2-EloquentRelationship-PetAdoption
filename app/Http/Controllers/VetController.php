<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Vet;

class VetController extends Controller
{
    public function assignVet(Request $request, $petId)
    {
        $pet = Pet::find($petId);
        $pet->vets()->attach($request->vet_id);
    }
}
