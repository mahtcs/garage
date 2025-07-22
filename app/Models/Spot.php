<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = 
    [
        'garage_id', 
        'identification', 
        'supported_body_types'
    ];

    public function garage() 
    { 
        return $this->belongsTo(Garage::class); 
    }

    public function activeRental() 
    { 
        return $this->hasOne(Rental::class)->where('status', 'active'); 
    }
}
