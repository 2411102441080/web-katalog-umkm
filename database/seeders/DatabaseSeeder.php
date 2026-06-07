<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. BUAT DATA KATEGORI
        $kriya = Category::create(['nama_kategori' => 'Kerajinan Tangan']);
        $kuliner = Category::create(['nama_kategori' => 'Makanan & Minuman']);
        $fashion = Category::create(['nama_kategori' => 'Pakaian & Aksesoris']);

        // 3. BUAT DATA TOKO UMKM (Format WA otomatis murni angka kode negara)
        $toko1 = Store::create([
            'nama_toko' => 'Kriya Nusantara Craft',
            'whatsapp' => '6281234567890',
            'alamat' => 'Jl. Merdeka No. 12, Kelurahan Pelita, Samarinda'
        ]);

        $toko2 = Store::create([
            'nama_toko' => 'Dapur Rasa Lokal',
            'whatsapp' => '6289876543210',
            'alamat' => 'Gang Baiturrahman No. 45, Samarinda Seberang'
        ]);

        $toko3 = Store::create([
            'nama_toko' => 'Tenun Benang Mahakam',
            'whatsapp' => '6285211223344',
            'alamat' => 'Kawasan Kampung Tenun, Samarinda'
        ]);

        // 4. BUAT DATA PRODUK YANG BANYAK
        // Kategori: Kerajinan Tangan
        Product::create([
            'store_id' => $toko1->id,
            'category_id' => $kriya->id,
            'name' => 'Tas Rotan Etnik Kalimantan',
            'price' => 175000,
            'description' => 'Tas rotan handmade anyaman khas motif Dayak yang kuat, modis, dan cocok untuk acara santai maupun formal.',
            'image' => 'products/tas_rotan.jpg', // Pastikan file ada di storage atau diisi mockup nanti
        ]);

        Product::create([
            'store_id' => $toko1->id,
            'category_id' => $kriya->id,
            'name' => 'Lampu Tidur Bambu Ukir',
            'price' => 120000,
            'description' => 'Lampu hias meja dari bambu pilihan dengan ukiran estetik yang memancarkan cahaya hangat menenangkan.',
            'image' => 'products/lampu_bambu.jpg',
        ]);

        Product::create([
            'store_id' => $toko1->id,
            'category_id' => $kriya->id,
            'name' => 'Gantungan Kunci Kayu Custom',
            'price' => 15000,
            'description' => 'Suvenir gantungan kunci dari sisa limbah kayu jati berkualitas tinggi yang dihaluskan dan diukir presisi.',
            'image' => 'products/gantungan_kayu.jpg',
        ]);

        // Kategori: Makanan & Minuman
        Product::create([
            'store_id' => $toko2->id,
            'category_id' => $kuliner->id,
            'name' => 'Keripik Singkong Balado Premium',
            'price' => 18000,
            'description' => 'Keripik singkong renyah dengan taburan bumbu balado basah racikan asli tanpa pengawet buatan. Isi bersih 250 gram.',
            'image' => 'products/keripik_singkong.jpg',
        ]);

        Product::create([
            'store_id' => $toko2->id,
            'category_id' => $kuliner->id,
            'name' => 'Sambal Bawang Pedas Nagih',
            'price' => 25000,
            'description' => 'Sambal bawang siap saji dalam kemasan botol kaca. Dibuat dari cabai segar pilihan dan minyak kelapa murni.',
            'image' => 'products/sambal_bawang.jpg',
        ]);

        Product::create([
            'store_id' => $toko2->id,
            'category_id' => $kuliner->id,
            'name' => 'Kopi Bubuk Robusta Alami',
            'price' => 45000,
            'description' => 'Kopi robusta murni hasil sangrai tradisional tingkat medium, menghasilkan aroma kuat dan rasa yang pekat.',
            'image' => 'products/kopi_robusta.jpg',
        ]);

        Product::create([
            'store_id' => $toko2->id,
            'category_id' => $kuliner->id,
            'name' => 'Madu Hutan Asli Sektor Kedang',
            'price' => 95000,
            'description' => 'Madu murni hasil panen langsung dari sarang lebah liar hutan Kalimantan Timur tanpa proses pemanasan.',
            'image' => 'products/madu_hutan.jpg',
        ]);

        // Kategori: Pakaian & Aksesoris
        Product::create([
            'store_id' => $toko3->id,
            'category_id' => $fashion->id,
            'name' => 'Kain Sarung Tenun Samarinda Original',
            'price' => 350000,
            'description' => 'Kain tenun tradisional asli buatan tangan pengrajin lokal dengan motif legendaris yang rapi dan elegan.',
            'image' => 'products/sarung_tenun.jpg',
        ]);

        Product::create([
            'store_id' => $toko3->id,
            'category_id' => $fashion->id,
            'name' => 'Kemeja Batik Motif Kontemporer',
            'price' => 185000,
            'description' => 'Kemeja pria lengan pendek bahan katun primissima yang adem dengan corak paduan modern-tradisional.',
            'image' => 'products/kemeja_batik.jpg',
        ]);

        Product::create([
            'store_id' => $toko3->id,
            'category_id' => $fashion->id,
            'name' => 'Hijab Segi Empat Voal Premium',
            'price' => 55000,
            'description' => 'Kerudung voal lembut, tegak di dahi, tidak terawang, dan sangat mudah dibentuk untuk aktivitas harian.',
            'image' => 'products/hijab_voal.jpg',
        ]);
    }
}