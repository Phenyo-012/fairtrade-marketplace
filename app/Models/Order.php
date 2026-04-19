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
        'delivered_at',
        'seller_deadline',
        'payment_status',
        'is_late',
        'shipped_at',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
    ];

    protected $casts = [
        'seller_deadline' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'is_late' => 'boolean',
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

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function getIsLateAttribute()
    {
        // Once shipped → freeze the value stored in DB
        if ($this->status === 'shipped') {
            return (bool) $this->attributes['is_late'];
        }

        // Do NOT evaluate lateness anymore after shipped
        if (in_array($this->status, ['completed', 'cancelled', 'disputed'])) {
            return (bool) $this->attributes['is_late'];
        }

        // Before shipping → calculate dynamically
        return $this->seller_deadline
            && now()->gt($this->seller_deadline);
    }

    public function getIsAutoCompletedAttribute()
    {
        // Must be delivered
        if ($this->status !== 'delivered') {
            return false;
        }

        // Must have delivery timestamp
        if (!$this->delivered_at) {
            return false;
        }

        // If disputed → DO NOT auto complete
        if ($this->status === 'disputed') {
            return false;
        }

        // 24 hour rule
        return now()->gt($this->delivered_at->addHours(24));
    }

    public function canBeReviewed()
    {
        // Must belong to a valid order
        if (!$this->order) {
            return false;
        }

        $order = $this->order;

        // Order must be delivered or completed
        if (!in_array($order->status, ['delivered', 'completed'])) {
            return false;
        }

        // Must have delivery timestamp
        if (!$order->delivered_at) {
            return false;
        }

        // Must be owned by current user
        if ($order->buyer_id !== auth()->id()) {
            return false;
        }

        // Prevent duplicate review per item per user
        if ($this->reviews()
            ->where('buyer_id', auth()->id())
            ->exists()) {
            return false;
        }

        return true;
    }

    public function canBeCompletedByAdmin()
    {
        if ($this->status !== 'delivered') {
            return false;
        }

        if (!$this->delivered_at) {
            return false;
        }

        return now()->gt($this->delivered_at->addHours(24));
    }
}
