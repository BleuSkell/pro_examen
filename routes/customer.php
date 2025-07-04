<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
  Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
  Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
  Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
  Route::delete('/customers/delete-all', [CustomerController::class, 'destroyAll'])->name('customers.destroyAll');
  Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
  Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
  Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
  Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});