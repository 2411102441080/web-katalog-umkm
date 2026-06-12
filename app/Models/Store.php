<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
protected $fillable = ['user_id', 'nama_toko', 'whatsapp', 'alamat', 'status'];

public function user()
{
    return $this->belongsTo(User::class);
}

    // Relasi: Satu toko memiliki banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}