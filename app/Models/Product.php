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
        'condition',
        'image'
    ];

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class);
    }

    //
    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getMainImageAttribute()
    {
        $image = $this->images->first();

        return $image
            ? asset('storage/' . $image->image_path)
            : '/placeholder.png';
    }
}
