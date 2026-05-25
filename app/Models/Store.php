<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['nama_toko', 'whatsapp', 'alamat'];

    // Relasi: Satu toko memiliki banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}