<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;

// Rute Publik (Halaman Depan Katalog)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Grup Rute Autentikasi (Wajib Login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Jalur Bersama (Bisa diakses Admin Utama & UMKM)
    |--------------------------------------------------------------------------
    */
    // Rute Manajemen Produk (Pembatasan kueri data diatur di dalam Controller)
    Route::resource('products', AdminProductController::class);
    
    // Jalur Update Informasi Toko Mandiri untuk UMKM (Memanfaatkan verb PUT dari Resource)
    Route::put('stores/{store}', [AdminStoreController::class, 'update'])->name('stores.update');


    /*
    |--------------------------------------------------------------------------
    | Area Khusus Admin Utama (Diproteksi Middleware 'admin')
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        // Melihat semua daftar toko yang mendaftar
        Route::get('stores', [AdminStoreController::class, 'index'])->name('stores.index');
        
        // Memvalidasi status kelayakan toko (Setujui / Tolak)
        Route::patch('stores/{store}/status', [AdminStoreController::class, 'updateStatus'])->name('stores.updateStatus');
        
        // Menghapus toko tidak aktif atau barang ilegal (Cascading Delete)
        Route::delete('stores/{store}', [AdminStoreController::class, 'destroy'])->name('stores.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Area Khusus Pelaku UMKM (Diproteksi Middleware 'umkm')
    |--------------------------------------------------------------------------
    */
    Route::middleware(['umkm'])->group(function () {
        // Halaman Profil Toko milik sendiri (Membuka file my_store.blade.php)
        Route::get('my-store', [AdminStoreController::class, 'index'])->name('stores.my_store');
    });
    
});

// Memuat rute bawaan Laravel Breeze (Login, Register, dll)
require __DIR__.'/auth.php';