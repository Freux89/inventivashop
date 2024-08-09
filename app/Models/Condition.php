<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['condition_group_id', 'variation_value_id', 'motivational_message'];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function variationValue()
    {
        return $this->belongsTo(VariationValue::class, 'variation_value_id');
    }
}
