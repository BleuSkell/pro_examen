<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/leveranciers', [SupplierController::class, 'index'])->name('suppliers.index');