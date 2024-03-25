<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = ['condition_group_id', 'product_variation_id'];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
