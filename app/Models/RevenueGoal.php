<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueGoal extends Model
{
    protected $fillable = [
        'id_user',
        'year',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
