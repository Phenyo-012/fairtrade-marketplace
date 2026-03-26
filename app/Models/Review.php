<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    'order_id',
    'order_item_id',
    'buyer_id',
    'rating',
    'comment'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
