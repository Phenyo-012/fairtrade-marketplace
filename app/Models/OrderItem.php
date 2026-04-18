<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'unit_price',
    'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
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