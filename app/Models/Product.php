<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'seller_profile_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'category',
        'condition',
        'image',
        'discount_percentage',
        'discount_ends_at',
        'free_shipping',
        'is_archived',
        'is_approved',
        'is_active',
        'shipping_size',
    ];

    protected $dates = ['deleted_at'];
    
    use SoftDeletes;

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_profile_id');
    }

    //
    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_profile_id');
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

        return \App\Support\ImageUrl::make($image->image_path ?? null, 'placeholder.png');
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(
            \App\Models\Review::class,
            \App\Models\OrderItem::class,
            'product_id',       // Foreign key on OrderItem
            'order_item_id',    // Foreign key on Review
            'id',               // Local key on Product
            'id'                // Local key on OrderItem
        );
    }

    public function getIsOnSaleAttribute()
    {
        return $this->discount_percentage > 0
            && $this->discount_ends_at
            && now()->lt($this->discount_ends_at);
    }

    public function getDiscountedPriceAttribute()
    {
        if (!$this->is_on_sale) {
            return $this->price;
        }

        return round(
            $this->price * (1 - ($this->discount_percentage / 100)),
            2
        );
    }
}
