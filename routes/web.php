<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ALL AUTHENTICATED USERS (Admins & Regular Users)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

    Route::get('/adoptions', [AdoptionRequestController::class, 'index'])->name('adoptions.index');
    Route::get('/adoptions/create', [AdoptionRequestController::class, 'create'])->name('adoptions.create');
    Route::post('/adoptions', [AdoptionRequestController::class, 'store'])->name('adoptions.store');

    // ONLY ADMINS BEYOND THIS POINT
    Route::middleware(['admin'])->group(function () {
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
        Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
        Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

        Route::resource('vets', VetController::class)->except(['create', 'show', 'edit']);

        Route::put('/adoptions/{adoption}', [AdoptionRequestController::class, 'update'])->name('adoptions.update');
        Route::delete('/adoptions/{adoption}', [AdoptionRequestController::class, 'destroy'])->name('adoptions.destroy');
    });
});
