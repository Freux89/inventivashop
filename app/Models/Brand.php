<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Brand extends Model
{
    use HasFactory;

    protected $with = ['brand_localizations'];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    } 
 
    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $brand_localizations = $this->brand_localizations->where('lang_key', $lang_key)->first();
        return $brand_localizations != null && $brand_localizations->$entity ? $brand_localizations->$entity : $this->$entity;
    }

    public function brand_localizations()
    {
        return $this->hasMany(BrandLocalization::class);
    } 
}
