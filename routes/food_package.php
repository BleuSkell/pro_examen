<?php

use App\Http\Controllers\FoodPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/voedselpakketten', [FoodPackageController::class, 'index'])->name('foodPackages.index');
Route::get('/voedselpakketten/{id}', [FoodPackageController::class, 'show'])->name('foodPackages.show');