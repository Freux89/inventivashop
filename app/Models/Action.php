<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['condition_id', 'variation_id', 'action_type', 'variation_value_id', 'apply_to_all', 'motivational_message'];

    public function variationValues()
    {
        return $this->belongsToMany(VariationValue::class, 'action_variation_values', 'action_id', 'variation_value_id');
    }
}

