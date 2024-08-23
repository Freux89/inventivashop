<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Template extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'template_type'];

    // Relazione per ottenere le varianti collegate al template
    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'template_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_template_assignments');
    }

    // Metodo per ottenere le varianti ordinate
    public function getOrderedVariationsAttribute()
    {
        return $this->variations()
            ->join('variations', DB::raw('SUBSTRING_INDEX(product_variations.variation_key, ":", 1)'), '=', 'variations.id')
            ->join('variation_values', DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(product_variations.variation_key, "/", 1), ":", -1)'), '=', 'variation_values.id')
            ->orderBy('variations.position', 'asc')
            ->orderBy('variation_values.position', 'asc')
            ->select('product_variations.*', 'variations.position as variation_position', 'variation_values.position as value_position')
            ->get();
    }

    // Metodo per ottenere le combinazioni delle varianti ordinate
    public function getOrderedVariationCombinationsAttribute()
    {
        return $this->variations->map(function ($templateVariation) {
            $combinations = array_filter(explode("/", $templateVariation->variation_key));
            return collect($combinations)->map(function ($combination) use ($templateVariation) {
                list($variation_id, $variation_value_id) = explode(":", $combination);
                return (object) [
                    'id' => $templateVariation->id,
                    'template_id' => $templateVariation->template_id,
                    'variation_id' => (int) $variation_id,
                    'variation_value_id' => (int) $variation_value_id,
                    'variation_key' => $templateVariation->variation_key,
                    'price' => $templateVariation->price,
                    'price_change_type' => $templateVariation->price_change_type,
                ];
            });
        })->collapse()->sortBy([
            ['variation_id', 'asc'],
            ['variation_value_id', 'asc']
        ]);
    }
}
