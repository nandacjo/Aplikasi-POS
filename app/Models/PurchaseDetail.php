<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PurchaseDetail extends Model
{
    use HasFactory;

    // protected $table = 'pembelian_detail';
    // protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
