<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    use HasFactory;

    # order Group 
    public function orderGroup()
    {
        return $this->belongsTo(OrderGroup::class);
    }
}
