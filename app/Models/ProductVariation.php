<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Variation;
use App\Models\VariationValue;

class ProductVariation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted()
    {
        static::saving(function ($productVariation) {
            if (!is_null($productVariation->variation_key)) {
                // Estrai variation_id e variation_value_id dalla variation_key
                $parts = explode(':', rtrim($productVariation->variation_key, '/'));
                
                // Assicurati che ci siano sia variation_id che variation_value_id
                if (count($parts) == 2) {
                    $productVariation->variation_id = $parts[0]; // Primo numero è il variation_id
                    $productVariation->variation_value_id = $parts[1]; // Secondo numero è il variation_value_id
                }
            }
        });


        if (app()->has('isFrontend') && app('isFrontend') === true) {

            // Applica il global scope per filtrare solo le varianti attive e i valori varianti attivi
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->whereHas('variation', function ($query) {
                    $query->where('is_active', 1);
                })
                ->whereHas('variationValue', function ($query) {
                    $query->where('is_active', 1);
                });
            });
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
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

   

    public function getVariationIdAttribute()
    {
        // Verifica se variation_key è null o non contiene ':'.
        if ($this->variation_key === null || !strpos($this->variation_key, ':')) {
            return null; // Restituisce null o un altro valore appropriato.
        }

        // Procede con l'elaborazione se variation_key non è null e contiene ':'.
        $parts = explode(':', rtrim($this->variation_key, '/'));

        // Assicurati che l'array $parts abbia almeno un elemento prima di tentare di accedere all'indice [0].
        if (count($parts) >= 1) {
            return (int) $parts[0];
        }

        // Restituisce null (o un altro valore predefinito) se il formato non è corretto.
        return null;
    }

    /**
     * Restituisce l'ID del valore variante da variation_key.
     *
     * @return int
     */
    public function getVariationValueIdAttribute()
    {
        // Prima verifica se variation_key è null.
        if ($this->variation_key === null) {
            return null; // o un altro valore che consideri appropriato per indicare l'assenza di dati.
        }

        // Successivamente, procedi con l'elaborazione se variation_key non è null.
        $parts = explode(':', rtrim($this->variation_key, '/'));

        // Verifica che l'array $parts abbia almeno due elementi prima di tentare di accedere all'indice [1].
        if (count($parts) >= 2) {
            return (int) $parts[1];
        }

        // Restituisce null (o un altro valore predefinito) se il formato non è corretto.
        return null;
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

    public function variationValue()
    {
        return $this->belongsTo(VariationValue::class, 'variation_value_id', 'id');
    }

    
}
