<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
    'order_id',
    'product_id',
    'product_name',
    'quantity',
    'unit_price',
    'subtotal',
    'original_price'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class)
            ->withTrashed()
            ->withDefault(function () {
                return new \App\Models\Product([
                    'product_name' => 'Deleted Product',
                    'unit_price' => 0
                ]);
            });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getIsDiscountedAttribute()
    {
        return $this->original_price && $this->original_price > $this->unit_price;
    }
}