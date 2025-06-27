<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::resource('stock', StockController::class);