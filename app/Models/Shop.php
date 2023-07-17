<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function scopeIsApproved($query)
    {
        return $query->where('is_approved', 1)->where('user_id','!=', 1); 
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
