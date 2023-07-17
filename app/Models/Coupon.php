<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Coupon extends Model
{
    use HasFactory;

    public function scopeShop($query)
    {
        return $query->where('shop_id', Auth::user()->shop_id);
    }
}
