<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('activity-log', App\Http\Controllers\ActivityLogController::class)->only('index', 'show');

Route::resource('deal-type', App\Http\Controllers\DealTypeController::class);

Route::resource('access-equipment', App\Http\Controllers\AccessEquipmentController::class);

Route::resource('venue-type', App\Http\Controllers\VenueTypeController::class);

Route::resource('area', App\Http\Controllers\AreaController::class);

Route::resource('region', App\Http\Controllers\RegionController::class);

Route::resource('venue', App\Http\Controllers\VenueController::class);
