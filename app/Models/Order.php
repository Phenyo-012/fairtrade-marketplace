<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'buyer_id',
        'seller_profile_id',
        'product_id',
        'quantity',
        'total_amount',
        'status',
        'delivery_code',
        'seller_deadline',
        'payment_status'
    ];

    //
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function deliveryConfirmation()
    {
        return $this->hasOne(DeliveryConfirmation::class);
    }

    public function dispute()
    {
        return $this->hasOne(\App\Models\Dispute::class);
    }

    public function review()
    {
        return $this->hasOne(\App\Models\Review::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
