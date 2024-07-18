<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductVariation;
use App\Models\Product;

class ProductVariationInfoResource extends JsonResource
{
    protected $productId;
    protected $quantity;

    public function __construct($resource, $productId, $quantity)
    {
        parent::__construct($resource);
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function toArray($request) {

        $product = Product::find($this->productId);

        $resourceCollection = collect($this->resource);
        
        $ids = $resourceCollection->isEmpty() ? [] : $resourceCollection->pluck('id')->toArray(); // sono gli id product variations selezionati
        
        
        // prendo gli id presenti su ids mentre per le altre varianti prodotto prendo il primo valore presente.
        $orderedVariations = $product->ordered_variations;

// Dividi le varianti prodotto per la loro variante ID
$groupedVariations = $orderedVariations->groupBy(function($item) {
    // Estrai l'ID della variante dalla variation_key
    return explode(':', $item->variation_key)[0];
});

// Prepara l'array finale delle varianti prodotto
$finalVariations = [];

// Itera su ciascun gruppo di varianti
foreach ($groupedVariations as $variationId => $variations) {
    // Trova la variante prodotto selezionata nel gruppo, se esiste
    $selectedVariation = $variations->first(function($variation) use ($ids) {
        return in_array($variation->id, $ids);
    });

    // Se c'è una variante selezionata, aggiungila al risultato finale
    if ($selectedVariation) {
        $finalVariations[] = $selectedVariation;
    } else {
        // Altrimenti, aggiungi il primo valore variante del gruppo
        $finalVariations[] = $variations->first();
    }
}

// Converti il risultato in una collezione (se necessario)
$finalVariations = collect($finalVariations);

// Ottieni solo gli ID delle varianti prodotto
$ids_all = $finalVariations->pluck('id')->toArray();


        
        $product_tax = $product->taxes[0]['tax_value']/100;
        $productVariations = ProductVariation::findMany($ids_all);
        $variantValueIds = $productVariations->pluck('variant_value_id')->toArray();
    
        $total_stock = array_reduce($this->resource, function($carry, $item) {
            return $carry + ($item['product_variation_stock'] ? (int) $item['product_variation_stock']->stock_qty : 0);
        }, 0);
    
        $conditionEffects = prepareConditionsForVariations($product, $ids_all);

        

        $filteredProductVariations = $productVariations->reject(function ($variation) use ($conditionEffects) {
            return in_array($variation->variant_value_id, $conditionEffects['valuesToDisable']);
        });

        

        $filteredIds = $filteredProductVariations->isEmpty() ? [] : $filteredProductVariations->pluck('id')->toArray();
        
        $indicativeDeliveryDays = indicativeDeliveryDays($product, $filteredProductVariations);
        $selectedVariantValueIds = array_diff($variantValueIds, $conditionEffects['valuesToDisable']);

        
        // Prezzo con IVA
        
        $priceWithTax = variationPrice($product, $filteredProductVariations);
        $discountedPriceWithTax = variationDiscountedPrice($product, $filteredProductVariations);
    
        // Calcolare il prezzo netto (senza IVA) e l'IVA
        $netPrice = $priceWithTax / (1+$product_tax);
        $tax = $priceWithTax - $netPrice;
    
        // Calcola il prezzo base e scontato
        $basePrice = $priceWithTax * $this->quantity;
        $discountedBasePrice = $discountedPriceWithTax * $this->quantity;
    
        $unit = $product->unit ? $product->unit->collectLocalization('name') : '';
    
        $recapBodyHtml = view('frontend.default.pages.partials.products.recap-body', [
            'stock' => $total_stock,
            'indicativeDeliveryDays' => $indicativeDeliveryDays,
            'netPrice' => formatPrice($netPrice * $this->quantity),
            'unit' => $unit,
            'tax' => formatPrice($tax * $this->quantity),
            'basePrice' => $basePrice,
            'discountedBasePrice' => $discountedBasePrice,
            'maxPrice' => $basePrice, // Assumendo che maxPrice = basePrice se non si usa in altro modo
            'discountedMaxPrice' => $discountedBasePrice,
            'quantity' => $this->quantity, // Aggiungi la quantità
        ])->render();
        // Creazione del riepilogo delle varianti
       
        $summaryBoxVariantsHtml = view('frontend.default.pages.partials.products.summary-box-variants-content', [
            'productVariations' => $filteredProductVariations,
        ])->render();
        
        return [
            'ids' => $ids,
            'filteredIds' => $filteredIds,
            'recap_body_html' => $recapBodyHtml,
            'summary_box_variants_html' => $summaryBoxVariantsHtml, // Aggiungi questo per il riepilogo delle varianti
            'variations_html' => view('frontend.default.pages.partials.products.variations', [
                'product' => $product,
                'variation_value_ids' => $selectedVariantValueIds,
                'conditionEffects' => $conditionEffects['valuesToDisable'],
                'motivationalMessages' => $conditionEffects['motivationalMessages'],
            ])->render(),
        ];
    }
}

