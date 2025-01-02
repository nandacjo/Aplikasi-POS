<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    // Relasi ke produk
    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id');
    }
}
