<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;

class AdoptionController extends Controller
{
    public function adopt(Request $request)
    {
        return AdoptionRequest::create([
            'user_id' => auth()->id(),
            'pet_id' => $request->pet_id
        ]);
    }
}
