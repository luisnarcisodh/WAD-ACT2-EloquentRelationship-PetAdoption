<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function store(Request $request)
    {
        return Pet::create($request->all());
    }
}
