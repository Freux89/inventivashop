<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Unit extends Model
{
    use HasFactory;

    protected $with = ['unit_localizations'];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    } 
    
    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $unit_localizations = $this->unit_localizations->where('lang_key', $lang_key)->first();
        return $unit_localizations != null && $unit_localizations->$entity ? $unit_localizations->$entity : $this->$entity;
    }

    public function unit_localizations()
    {
        return $this->hasMany(UnitLocalization::class);
    } 
}
