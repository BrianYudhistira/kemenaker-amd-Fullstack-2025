<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\CheckupsController;

Route::get('/', function () {
    return redirect('/overview');
});

Route::get('/overview', [OverviewController::class, 'index'])->name('overview.index');

Route::get('/checkups', [CheckupsController::class, 'index'])->name('checkups.index');
Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');
Route::get('/pets', [PetsController::class, 'index'])->name('pets.index');

Route::post('/owner/add', [OwnerController::class, 'store'])->name('owners.store');
Route::put('/owner/edit/{id}', [OwnerController::class, 'update'])->name('owners.update');
Route::delete('/owner/delete/{id}', [OwnerController::class, 'destroy'])->name('owners.destroy');

Route::post('/pets/add', [PetsController::class, 'store'])->name('pets.store');
Route::put('/pets/edit/{id}', [PetsController::class, 'update'])->name('pets.update');
Route::delete('/pets/delete/{id}', [PetsController::class, 'destroy'])->name('pets.destroy');

Route::post('/checkups/add', [CheckupsController::class, 'store'])->name('checkups.store');
Route::put('/checkups/edit/{id}', [CheckupsController::class, 'update'])->name('checkups.update');
Route::delete('/checkups/delete/{id}', [CheckupsController::class, 'destroy'])->name('checkups.destroy');