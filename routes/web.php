<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\VetController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/pets', [PetController::class, 'store']);
Route::post('/adopt', [AdoptionController::class, 'adopt']);
Route::post('/pets/{id}/vet', [VetController::class, 'assignVet']);
