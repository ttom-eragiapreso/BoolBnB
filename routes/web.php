<?php

use App\Http\Controllers\HousesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\GuestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Type_of_stay;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GuestController::class, 'index'])->name('home');

Route::get('/advanced-search', [GuestController::class, 'advancedSearch'])->name('advancedsearch');
Route::get('/details/{slug}', [GuestController::class, 'details'])->name('details');

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
