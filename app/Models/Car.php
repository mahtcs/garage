<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = 
    [
        'user_id', 
        'brand', 
        'model', 
        'year', 
        'body_type', 
        'plate'];
    
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function rental() 
    { 
        return $this->hasOne(Rental::class)->whereIn('status', ['pending', 'active']);
    }
}
