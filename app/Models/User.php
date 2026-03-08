<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_user');
    }


    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }

    public function isBuyer()
    {
        return $this->roles()->where('name', 'buyer')->exists();
    }
    

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            SellerProfile::class,
            'user_id',      // Foreign key on seller_profiles
            'seller_profile_id', // Foreign key on products
            'id',           // Local key on users
            'id'            // Local key on seller_profiles
        );
    }


    public function ordersPlaced()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function ordersReceived()
    {
        return $this->hasManyThrough(
            Order::class,
            SellerProfile::class,
            'user_id',
            'seller_profile_id',
            'id',
            'id'
        );
    }

    public function complianceFlags()
    {
        return $this->hasMany(ComplianceFlag::class);
    }

    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }


}
