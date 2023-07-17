<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationStock extends Model
{
    use HasFactory;
 
    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
