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
        'shipped_at'
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
        // Must belong to buyer
        if (!$this->buyer_id || auth()->id() !== $this->buyer_id) {
            return false;
        }

        // Must be completed or delivered (depending on your flow)
        if (!in_array($this->status, ['delivered', 'completed'])) {
            return false;
        }

        // Must not already have a review
        if ($this->review()->exists()) {
            return false;
        }

        return true;
    }
}
