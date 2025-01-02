<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];



    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }
}
