<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function member()
    {
        return $this->hasOne(Member::class);
    }

     public function user()
    {
        return $this->hasOne(User::class);
    }
}
