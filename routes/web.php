<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\GuestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// Guest Pages
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/advanced-search/{lat?}/{lng?}', [GuestController::class, 'advancedSearch'])->name('advancedsearch');
Route::get('/details/{slug}', [GuestController::class, 'details'])->name('details');

// Auth Pages
Route::middleware(['auth', 'verified'])
    ->name('dashboard.')
    ->prefix('dashboard')
    ->group(function (){
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('apartment/messages', [ApartmentController::class, 'messages'])->name('apartment.messages');
        Route::get('apartment/stats', [ApartmentController::class, 'stats'])->name('apartment.stats');
        Route::get('apartment/sponsorship', [ApartmentController::class, 'sponsorship'])->name('apartment.sponsorship');
        Route::resource('/apartment', ApartmentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
