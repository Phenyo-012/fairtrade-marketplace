<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'logo',
        'about',
        'verification_status',
        'verification_notes',
        'id_document',
        'selfie_document',
        'kyc_submitted',
        'onboarding_step',
        'pickup_address',
        'pickup_city',
        'pickup_postal_code',
        'pickup_province',
        'pickup_country',

    ];


    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_profile_id');
    }

    public function orders()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            Product::class,
            'seller_profile_id',
            'product_id',
            'id',
            'id'
        );
    }
}
