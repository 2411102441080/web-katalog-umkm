<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;

// Rute Publik (Halaman Depan Katalog)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/store/{slug}', [HomeController::class, 'storeDetail'])->name('store.detail');

/*
|--------------------------------------------------------------------------
| Grup Dashboard (Wajib Login DAN Harus Ber-role Admin atau UMKM)
|--------------------------------------------------------------------------
| User biasa (guest) akan langsung tertolak di sini karena ada 'dashboard_user'
*/
Route::middleware(['auth', 'umkm'])->prefix('admin')->name('admin.')->group(function () {
    
    // Jalur Bersama (Bisa diakses Admin Utama & UMKM)
    Route::resource('products', AdminProductController::class);
    Route::get('stores', [AdminStoreController::class, 'index'])->name('stores.index');
    Route::put('stores/{store}', [AdminStoreController::class, 'update'])->name('stores.update');

    /*
    |--------------------------------------------------------------------------
    | Area Khusus Admin Utama (Diproteksi Middleware 'super_admin')
    |--------------------------------------------------------------------------
    | User UMKM akan tertolak di sini, hanya akun dengan role 'admin' yang bisa masuk
    */
    Route::middleware(['admin'])->group(function () {
        // Memvalidasi status kelayakan toko (Setujui / Tolak)
        Route::patch('stores/{store}/status', [AdminStoreController::class, 'updateStatus'])->name('stores.updateStatus');
        
        // Menghapus toko tidak aktif atau user terkait
        Route::delete('stores/{store}', [AdminStoreController::class, 'destroy'])->name('stores.destroy');
    });
    
});

// Memuat rute bawaan Laravel Breeze (Login, Register, dll)
require __DIR__.'/auth.php';