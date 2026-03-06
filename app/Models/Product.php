<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

     protected $fillable = [
        'seller_profile_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'category',
        'condition'
    ];

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
