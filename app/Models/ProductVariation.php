<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variation;
use App\Models\VariationValue;

class ProductVariation extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    protected static function booted()
    {
        static::deleted(function ($productVariation) {
            if ($productVariation->isForceDeleting()) {
                // Gestisci la cancellazione forzata se necessario
            } else {
                // Qui gestisci il soft delete
                ActionProductVariation::where('product_variation_id', $productVariation->id)
                    ->delete(); // O softDelete(), a seconda della tua logica
                Condition::where('product_variation_id', $productVariation->id)
                    ->delete();
            }
        });
    }

    public function getVariantIdAttribute()
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
    public function getVariantValueIdAttribute()
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
}
