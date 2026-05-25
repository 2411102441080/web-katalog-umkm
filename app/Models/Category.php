<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Mengizinkan pengisian data massal untuk kolom nama_kategori
    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori memiliki banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}