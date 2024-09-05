<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrderByPositionScope;
use App;

class VariationValue extends Model
{
    use HasFactory;

    protected $with = ['variation_value_localizations'];
    protected $fillable = [
        'position',
        // altri campi...
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByPositionScope);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $variation_value_localizations = $this->variation_value_localizations->where('lang_key', $lang_key)->first();
        return $variation_value_localizations != null && $variation_value_localizations->$entity ? $variation_value_localizations->$entity : $this->$entity;
    }

    public function variation_value_localizations()
    {
        return $this->hasMany(VariationValueLocalization::class);
    }

    public function workflows()
    {
        return $this->belongsToMany(Workflow::class, 'variation_value_workflows');
    }

    protected static function booted()
    {
        static::deleted(function ($variationValue) {
            
                // Gestisci il soft delete
                $productVariations = ProductVariation::all();

                foreach ($productVariations as $productVariation) {
                    
                    // Utilizza l'accessor per ottenere l'ID del valore variante in snake case
                    if ($productVariation->variant_value_id === $variationValue->id) {
                        
                        $productVariation->delete(); // o ->forceDelete() se vuoi una cancellazione forzata
                    }
                }
                ProductVariationCombination::where('variation_value_id', $variationValue->id)->delete();
          
        });
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function material()
    {
        // Definisce la relazione molti-a-molti con Material utilizzando la tabella pivot material_variation_value
        // Ritorna il primo materiale trovato
        return $this->belongsToMany(Material::class, 'material_variation_value', 'variation_value_id', 'material_id')
                    ->first(); // Restituisce il primo materiale (o null se non esiste)
    }
}
