<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterData\DivisionController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\UnitController;
use App\Http\Controllers\MasterData\SupplierController;
use App\Http\Controllers\MasterData\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Master Data
    Route::prefix('master')->group(function () {
        Route::resource('divisions', DivisionController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('items', ItemController::class);
    });
});

require __DIR__.'/auth.php';
