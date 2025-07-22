<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = 
    [
        'spot_id', 
        'car_id', 
        'client_id', 
        'owner_id', 
        'start_date', 
        'end_date', 
        'status'
    ];

    public function spot() 
    { 
        return $this->belongsTo(Spot::class); 
    }

    public function car() 
    { 
        return $this->belongsTo(Car::class); 
    }

    public function client() 
    { 
        return $this->belongsTo(User::class, 'client_id'); 
    }

    public function owner() 
    { 
        return $this->belongsTo(User::class, 'owner_id'); 
    }
    
}
