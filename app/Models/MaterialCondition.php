<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCondition extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'variation_value_id', 'condition_group', 'condition_operator'];

    // Relazione con Material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Relazione con VariationValue
    public function variationValue()
    {
        return $this->belongsTo(VariationValue::class);
    }
}