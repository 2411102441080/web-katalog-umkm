<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Menghubungkan produk ke tabel toko (Jika toko dihapus, produk ikut terhapus)
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            // Menghubungkan produk ke tabel kategori
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->string('name');
            $table->integer('price');
            $table->string('image')->nullable(); // Menyimpan nama file/path foto produk
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
