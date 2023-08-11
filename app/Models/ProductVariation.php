<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variation;
use App\Models\VariationValue;

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

    /**
     * Ottieni il nome della variazione.
     */
    public function getVariationNameAttribute()
    {
        $keys = explode(':', rtrim($this->variation_key, '/'));
        if (count($keys) == 2) {
            $variationId = $keys[0];
            return Variation::find($variationId)->name ?? 'Variation not found';
        }
        return null;
    }

    /**
     * Ottieni il nome del valore della variazione.
     */
    public function getVariationValueNameAttribute()
    {
        $keys = explode(':', rtrim($this->variation_key, '/'));
        if (count($keys) == 2) {
            $valueId = $keys[1];
            return VariationValue::find($valueId)->name ?? 'Value not found';
        }
        return null;
    }
}
