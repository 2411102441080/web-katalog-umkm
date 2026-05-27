<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;

// Rute Publik (Halaman Depan Katalog)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Grup Rute Autentikasi Admin (Breeze + IsAdmin Middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Manajemen Produk
    Route::resource('products', AdminProductController::class);
    
    // Rute Manajemen Toko UMKM
    Route::resource('stores', AdminStoreController::class);
    
});

// Memuat rute bawaan Laravel Breeze (Login, Register, dll)
require __DIR__.'/auth.php';