<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn() => redirect()->route('login'));

// REQUIREMENT 2: AUTHENTICATION
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// REQUIREMENT 3: MIDDLEWARE (Auth)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');

    Route::apiResource('adoptions', AdoptionRequestController::class)->only(['index', 'store', 'destroy']);

    // REQUIREMENT 3: MIDDLEWARE (Admin Restrictions)
    Route::middleware(['admin'])->group(function () {
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
        Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
        Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

        Route::resource('vets', VetController::class)->except(['create', 'show', 'edit']);
        Route::post('/vets/{vet}/assign/{pet}', [VetController::class, 'assignVet'])->name('vets.assign');

        Route::put('/adoptions/{adoption}', [AdoptionRequestController::class, 'update'])->name('adoptions.update');
    });
});
