<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceFlag extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
