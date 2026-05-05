<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dispute extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'order_id',
        'opened_by',
        'reason',
        'status',
        'resolution_notes',
        'resolved_by',
        'seller_response',
        'seller_responded_at'
    ];

    protected $casts = [
        'seller_responded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

}
