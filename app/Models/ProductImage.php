<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getLogoUrlAttribute()
    {
        return \App\Support\ImageUrl::make($this->logo, 'default-store.png');
    }
}