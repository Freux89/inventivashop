<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticZone extends Model
{
    use HasFactory;

    public function logistic()
    {
        return $this->belongsTo(Logistic::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'logistic_zone_countries', 'logistic_zone_id', 'country_id');
    }
}
