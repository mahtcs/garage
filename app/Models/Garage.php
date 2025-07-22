<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    protected $fillable = 
    [
        'user_id', 
        'capacity', 
        'street', 
        'number', 
        'complement', 
        'district', 
        'city', 
        'state', 
        'zip_code'];

    public function owner() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function spots() 
    { 
        return $this->hasMany(Spot::class); 
    }
}
