<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialPriceTier extends Model
{
    protected $fillable = ['material_id', 'min_quantity', 'price'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
