<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'category_id', 'name', 'price', 'description', 'image'];

    // Relasi balik: Produk ini milik sebuah toko
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relasi balik: Produk ini termasuk dalam sebuah kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}