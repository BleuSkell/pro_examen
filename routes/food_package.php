<?php

use App\Http\Controllers\FoodPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/voedselpakketten', [FoodPackageController::class, 'index'])->name('foodPackages.index');