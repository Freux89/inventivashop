<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticZoneCity extends Model
{
    use HasFactory;

    function logistic()
    {
        return $this->belongsTo(Logistic::class);
    }

    function logisticZone()
    {
        return $this->belongsTo(LogisticZone::class);
    }
}
