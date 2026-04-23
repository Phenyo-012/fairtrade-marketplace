<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'reported_by',
        'reason',
    ];

    /**
     * The message that was reported
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * The user who reported the message
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}