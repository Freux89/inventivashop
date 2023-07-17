<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }

    public function product_variation_stock()
    {
        return $this->hasOne(ProductVariationStock::class)->where('location_id', session('stock_location_id'));
    }

    public function product_variation_stock_without_location()
    {
        return $this->hasOne(ProductVariationStock::class);
    }
}
