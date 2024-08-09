<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionVariationValue extends Model
{
    use HasFactory;

    protected $fillable = ['action_id', 'variation_value_id'];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function variationValue()
    {
        return $this->belongsTo(VariationValue::class);
    }
}
