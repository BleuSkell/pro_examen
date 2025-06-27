<?php

use App\Http\Controllers\FoodPackageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/voedselpakketten', [FoodPackageController::class, 'index'])->name('foodPackages.index');
    Route::get('/voedselpakketten/aanmaken', [FoodPackageController::class, 'create'])->name('foodPackages.create');
    Route::post('/voedselpakketten', [FoodPackageController::class, 'store'])->name('foodPackages.store');
    Route::get('/voedselpakketten/{id}/bewerken', [FoodPackageController::class, 'edit'])->name('foodPackages.edit');
    Route::put('/voedselpakketten/{id}', [FoodPackageController::class, 'update'])->name('foodPackages.update');
    Route::delete('/voedselpakketten/{id}', [FoodPackageController::class, 'destroy'])->name('foodPackages.destroy');
    Route::get('/voedselpakketten/{id}', [FoodPackageController::class, 'show'])->name('foodPackages.show');
});