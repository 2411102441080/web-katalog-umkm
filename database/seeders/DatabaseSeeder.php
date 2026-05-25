<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun untuk Login Dashboard Admin
        User::create([
            'name' => 'Admin Alwi',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Data Kategori Contoh
        $kuliner = Category::create(['nama_kategori' => 'Kuliner']);
        $fashion = Category::create(['nama_kategori' => 'Fashion']);
        $kerajinan = Category::create(['nama_kategori' => 'Kerajinan']);

        // 3. Data Toko Contoh (Gunakan kode negara 62 untuk WhatsApp)
        Store::create([
            'nama_toko' => 'Toko Berkah Jaya',
            'whatsapp' => '628123456789', 
            'alamat' => 'Jl. Juanda No. 10, Samarinda'
        ]);

        Store::create([
            'nama_toko' => 'Batik Kaltim Indah',
            'whatsapp' => '628987654321',
            'alamat' => 'Jl. Antasari No. 45, Samarinda'
        ]);
    }
}