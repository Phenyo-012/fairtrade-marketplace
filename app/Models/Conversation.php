<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class)
            ->orderBy('created_at', 'asc');
    }
    
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get the OTHER participant
     */
    public function otherUser()
    {
        return $this->user_one_id === auth()->id()
            ? $this->userTwo
            : $this->userOne;
    }

    /**
     * Last message
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function unreadMessagesFor($userId)
    {
        return $this->hasMany(Message::class)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at');
    }
}
