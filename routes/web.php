<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;

// Rute Publik (Halaman Depan Katalog)
Route::get('/', [HomeController::class, 'index'])->name('home');
// Rute untuk halaman detail UMKM/Toko (Menggunakan nama_toko/slug aman)
Route::get('/store/{slug}', [HomeController::class, 'storeDetail'])->name('store.detail');

// Grup Rute Autentikasi (Wajib Login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Jalur Bersama (Bisa diakses Admin Utama & UMKM)
    |--------------------------------------------------------------------------
    */
    // Rute Manajemen Produk (Pembatasan CRUD & Read-Only diatur di AdminProductController)
    Route::resource('products', AdminProductController::class);
    
    // Rute Utama Toko: 
    // - Admin akan diarahkan ke halaman Kelola Pengguna Global
    // - UMKM otomatis diarahkan ke halaman edit profil Toko Mandiri milik mereka sendiri
    Route::get('stores', [AdminStoreController::class, 'index'])->name('stores.index');
    
    // Jalur Update Informasi Toko (Digunakan oleh UMKM maupun Admin saat modifikasi data)
    Route::put('stores/{store}', [AdminStoreController::class, 'update'])->name('stores.update');


    /*
    |--------------------------------------------------------------------------
    | Area Khusus Admin Utama (Diproteksi Middleware 'admin' / IsAdmin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        // Memvalidasi status kelayakan toko (Setujui / Tolak)
        Route::patch('stores/{store}/status', [AdminStoreController::class, 'updateStatus'])->name('stores.updateStatus');
        
        // Menghapus toko tidak aktif atau user terkait (Cascading Delete)
        Route::delete('stores/{store}', [AdminStoreController::class, 'destroy'])->name('stores.destroy');
    });
    
});

// Memuat rute bawaan Laravel Breeze (Login, Register, dll)
require __DIR__.'/auth.php';