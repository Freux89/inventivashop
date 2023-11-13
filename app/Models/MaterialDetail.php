<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetail extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_material_details', 'material_detail_id', 'material_id');
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key == '' ? App::getLocale() : $lang_key;
        $material_detail_localizations = $this->material_detail_localizations->where('lang_key', $lang_key)->first();
        return $material_detail_localizations != null && $material_detail_localizations->$entity ? $material_detail_localizations->$entity : $this->$entity;
    }

    public function material_detail_localizations()
    {
        return $this->hasMany(MaterialDetailLocalization::class);
    }
}
