<?php

namespace App\Models;

use App\Scopes\OrderByPositionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VariationValue;
use App; 

class Variation extends Model
{
    use HasFactory;

    protected $with = ['variation_localizations'];

    protected $fillable = [
        'position',
        'material_feature'
        // altri campi...
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByPositionScope);
    }


    public function variationValues()
    {
        return $this->hasMany(VariationValue::class)->orderBy('position');
    }


    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    } 
    
    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $variation_localizations = $this->variation_localizations->where('lang_key', $lang_key)->first();
        return $variation_localizations != null && $variation_localizations->$entity ? $variation_localizations->$entity : $this->$entity;
    }

    public function variation_localizations()
    {
        return $this->hasMany(VariationLocalization::class);
    } 

    public static function activeMaterialFeatures()
    {
        return self::where('material_feature', 1)
        ->where('is_active', 1)
        ->orderBy('position')
        ->with(['variationValues' => function($query) {
            $query->orderBy('position');
        }])
        ->get();
    }

    protected static function booted()
    {
        static::deleted(function ($variant) {
            // Recupera tutti i ProductVariation
            $productVariations = ProductVariation::all();

            foreach ($productVariations as $productVariation) {
                // Utilizza l'accessor per ottenere l'ID della variante
                if ($productVariation->variant_id === $variant->id) {
                    // Cancella il ProductVariation associato alla variante eliminata
                    $productVariation->delete(); // o ->forceDelete() se desideri una cancellazione forzata
                }
            }
            ProductVariationCombination::where('variation_id', $variant->id)->delete();
        });
    }
}
