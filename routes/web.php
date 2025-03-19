<?php

use App\Infrastructure\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});

Route::prefix('orders')->group(function () {
    Route::get('/', [\App\Infrastructure\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [\App\Infrastructure\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/', [\App\Infrastructure\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}', [\App\Infrastructure\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/{id}/edit', [\App\Infrastructure\Http\Controllers\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/{id}', [\App\Infrastructure\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{id}', [\App\Infrastructure\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');
});
