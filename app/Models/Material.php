<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'price_type',
        'thumbnail_image',
        'texture',
        'status',
        'is_default',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function materialDetails()
{
    return $this->belongsToMany(MaterialDetail::class, 'material_material_details');
}

    public function collectLocalization($entity = '', $lang_key = '')
    {
        
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $material_localizations = $this->material_localizations->where('lang_key', $lang_key)->first();
        return $material_localizations != null && $material_localizations->$entity ? $material_localizations->$entity : $this->$entity;
    }

    public function material_localizations()
    {
        return $this->hasMany(MaterialLocalization::class);
    } 

}
