<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use Illuminate\Support\Facades\Route;

// Rute Publik (User Biasa)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Rute Privat Admin (Wajib Login)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    });

require __DIR__.'/auth.php';