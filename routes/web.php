<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\GuestController;
use App\Models\Apartment;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// Guest Pages
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/advanced-search/{lat?}/{lng?}', [GuestController::class, 'advancedSearch'])->name('advancedsearch');
Route::get('/details/{slug}', [GuestController::class, 'details'])->name('details');
Route::post('/store-messages', [GuestController::class, 'storeMessages'])->name('store-messages');

// Auth Pages
Route::middleware(['auth', 'verified'])
    ->name('dashboard.')
    ->prefix('dashboard')
    ->group(function (){
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('transactions-history', [DashboardController::class, 'transactions'])->name('transactions');
        Route::get('apartment/messages/{apartment_id?}', [ApartmentController::class, 'messages'])->name('apartment.messages');
        Route::get('apartment/stats', [ApartmentController::class, 'stats'])->name('apartment.stats');
        Route::get('apartment/sponsorship/{apartment_id?}', [ApartmentController::class, 'sponsorship'])->name('apartment.sponsorship');
        Route::post('apartment/sponsorship/transaction', [ApartmentController::class, 'transaction'])->name('transaction');
        Route::resource('/apartment', ApartmentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
