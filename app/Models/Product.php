<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
