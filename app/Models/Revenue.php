<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{

    protected $fillable = [
        'id_user',
        'amount',
        'year',
        'month',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
