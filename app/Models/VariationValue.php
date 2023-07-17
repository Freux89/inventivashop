<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class VariationValue extends Model
{
    use HasFactory;
    
    protected $with = ['variation_value_localizations'];
    
    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    } 

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $variation_value_localizations = $this->variation_value_localizations->where('lang_key', $lang_key)->first();
        return $variation_value_localizations != null && $variation_value_localizations->$entity ? $variation_value_localizations->$entity : $this->$entity;
    }

    public function variation_value_localizations()
    {
        return $this->hasMany(VariationValueLocalization::class);
    }
}
