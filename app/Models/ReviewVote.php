<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewVote extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
        'is_helpful'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}