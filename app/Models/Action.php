<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['condition_id', 'product_variation_id','action_type','variant_id','apply_to_all','motivational_message'];

    public function productVariations()
    {
        return $this->belongsToMany(ProductVariation::class, 'action_product_variations', 'action_id', 'product_variation_id');
    }
}
