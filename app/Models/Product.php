<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Product extends Model
{
    use HasFactory;
    

    protected $guarded = [];

    public function scopeShop($query)
    {
        return $query->where('shop_id', Auth::user()->shop_id);
    }

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }

    protected $with = ['product_localizations'];

    public function product_localizations()
    {
        return $this->hasMany(ProductLocalization::class);
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $product_localizations = $this->product_localizations->where('lang_key', $lang_key)->first();
        return $product_localizations != null && $product_localizations->$entity ? $product_localizations->$entity : $this->$entity;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variations()
{
    return $this->hasMany(ProductVariation::class);
}
    public function productOnlyVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function combinedVariations()
{
    // Recupera le varianti prodotto
    $productVariations = $this->variations;

    // Recupera le varianti template, ma escludi quelle già presenti nelle varianti prodotto
    $templateVariations = ProductVariation::whereNotNull('template_id')
        ->whereIn('template_id', $this->templates->pluck('id'))
        ->get()
        ->filter(function ($templateVariation) use ($productVariations) {
            return !$productVariations->contains('variation_key', $templateVariation->variation_key);
        });

    // Unisci le varianti prodotto e template
    $allVariations = $productVariations->merge($templateVariations);

    // Filtra le varianti in base allo stato attivo di varianti e valori varianti
    $filteredVariations = $allVariations->filter(function ($variation) {
        return $variation->variation && $variation->variation->is_active && 
               $variation->variationValue && $variation->variationValue->is_active;
    });

    // Esegui il dump delle varianti filtrate
    

    return $filteredVariations;
}

    



    public function getOrderedVariationsAttribute()
    {
         return $this->variations()
        ->join('variations', DB::raw('SUBSTRING_INDEX(product_variations.variation_key, ":", 1)'), '=', 'variations.id')
        ->join('variation_values', DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(product_variations.variation_key, "/", 1), ":", -1)'), '=', 'variation_values.id')
        ->orderBy('variations.position', 'asc')
        ->orderBy('variation_values.position', 'asc')
        ->select('product_variations.*', 'variations.position as variation_position', 'variation_values.position as value_position') // Seleziona i campi necessari
        ->get();
    }

    public function getCombinedOrderedVariationsAttribute()
{
    // Recupera le varianti prodotto e template
    $combinedVariations = $this->combinedVariations();

    // Filtra le varianti con variation_key nullo
    $filteredVariations = $combinedVariations->filter(function ($variation) {
        return $variation->variation_key !== null;
    });

    // Ottieni le informazioni sulle posizioni delle varianti
    $orderedVariations = $filteredVariations->map(function ($variation) {
        $variation->variation_position = DB::table('variations')
            ->where('id', explode(':', $variation->variation_key)[0])
            ->value('position');

        $variation->value_position = DB::table('variation_values')
            ->where('id', explode(':', rtrim($variation->variation_key, '/'))[1])
            ->value('position');

        return $variation;
    });

    // Ordina le varianti in base alla posizione
    return $orderedVariations->sortBy([
        fn($a, $b) => $a->variation_position <=> $b->variation_position,
        fn($a, $b) => $a->value_position <=> $b->value_position
    ])->values();
}

    
// Metodo per ottenere una variante specifica in base al variation_key
public function getVariationByKey($variation_key)
{
    // Recupera le varianti prodotto e template combinate
    $combinedVariations = $this->combinedVariations();

    // Filtra per variation_key e restituisci la variante corrispondente
    return $combinedVariations->firstWhere('variation_key', $variation_key);
}

    public function variation_combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }



    public function getOrderedVariationCombinationsAttribute()
    {
        return $this->variation_combinations()
            ->join('variations', 'product_variation_combinations.variation_id', '=', 'variations.id')
            ->orderBy('variations.position', 'asc')
            ->select('product_variation_combinations.*')
            ->get();
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function product_taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_taxes', 'product_id', 'tax_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
    public function workflows()
    {
        return $this->belongsToMany(Workflow::class, 'product_workflows');
    }
    public function directConditionGroups()
    {
        return $this->hasMany(ConditionGroup::class);
    }
    public function conditionGroups()
    {
        // Controlla se esistono condizioni collegate direttamente al prodotto
        $productConditionGroups = $this->hasMany(ConditionGroup::class);

        if ($productConditionGroups->exists()) {
            // Se esistono condizioni collegate al prodotto, restituiscile
            return $productConditionGroups;
        } else {
            // Altrimenti, recupera le condizioni collegate tramite i template varianti
            return ConditionGroup::whereIn('id', function ($query) {
                $query->select('condition_group_id')
                ->from('templates')
                ->join('product_template_assignments', 'templates.id', '=', 'product_template_assignments.template_id')
                ->where('product_template_assignments.product_id', $this->id)
                    ->where('templates.template_type', 'variation')
                    ->whereNotNull('condition_group_id');
            });
        }
    }

    public function quantityDiscounts()
    {
        return $this->belongsToMany(QuantityDiscount::class, 'product_quantity_discounts');
    }
    public function getQuantityDiscountAttribute()
    {
        return $this->quantityDiscounts()->first();
    }

    public function templates()
{
    return $this->belongsToMany(Template::class, 'product_template_assignments');
}
public function templateVariations()
{
    return $this->belongsToMany(Template::class, 'product_template_assignments')
                ->where('template_type', 'variation');
}
}
