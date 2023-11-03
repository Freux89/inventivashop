<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thickness extends Model
{
    use HasFactory;

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_thickness');
    }
}
