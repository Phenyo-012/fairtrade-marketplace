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
        'original_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)
            ->withTrashed()
            ->withDefault([
                'name' => 'Deleted Product',
                'price' => 0,
            ]);
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

    public function canBeReviewed(): bool
    {
        if (!$this->order) {
            return false;
        }

        $order = $this->order;

        if ((int) $order->buyer_id !== (int) auth()->id()) {
            return false;
        }

        if (!in_array($order->status, ['delivered', 'completed'], true)) {
            return false;
        }

        if (!$order->delivered_at) {
            return false;
        }

        if ($this->reviews()
            ->where('buyer_id', auth()->id())
            ->exists()) {
            return false;
        }

        return true;
    }
}