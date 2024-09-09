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

    public function toArray($request)
    {

        $product = Product::find($this->productId);
        $tiers = $product->quantityDiscount->tiers ?? collect();
        $resourceCollection = collect($this->resource);

        

        // Ottieni solo gli ID delle varianti prodotto
        $variations_all = getFinalVariations( $product, $resourceCollection);



        $product_tax = $product->taxes[0]['tax_value'] / 100;
        
      
        

        $total_stock = array_reduce($this->resource, function ($carry, $item) {
            return $carry + ($item['product_variation_stock'] ? (int) $item['product_variation_stock']->stock_qty : 0);
        }, 0);

        $conditionEffects = prepareConditionsForVariations($product, $variations_all );



        // Supponiamo che $allProductVariations contenga tutte le varianti prodotto disponibili
        $allProductVariations = $product->combinedOrderedVariations;

        // Filtra le varianti prodotto selezionate in base alle condizioni e sostituisci quelle disattivate con la prima variante attiva disponibile
        $filteredProductVariations = $variations_all->map(function ($variation) use ($conditionEffects, $allProductVariations) {
            if (in_array($variation->variation_value_id, $conditionEffects['valuesToDisable'])) {
                // Trova la prima variante prodotto attiva della stessa variante
                $variantId = explode(':', $variation->variation_key)[0];
                $activeVariation = $allProductVariations->filter(function ($v) use ($variantId, $conditionEffects) {
                    $vVariantId = explode(':', $v->variation_key)[0];
                    $vValueId = explode(':', explode('/', $v->variation_key)[0])[1];
                    return $vVariantId == $variantId && !in_array($vValueId, $conditionEffects['valuesToDisable']);
                })->first();

                return $activeVariation ?: null; // Ritorna null se tutte le varianti prodotto sono disattivate
            }

            return $variation;
        })->filter(); // Rimuovi le varianti prodotto null

        // Aggiorno nuovamente le condizioni con le nuove varianti prodotto aggiornate.
        $conditionEffects = prepareConditionsForVariations($product, $filteredProductVariations );
        // Converti la collezione filtrata in una lista di varianti prodotto
        $filteredProductVariations = $filteredProductVariations->values();




        $filteredIds = $filteredProductVariations->isEmpty() ? [] : $filteredProductVariations->pluck('id')->toArray();

        $indicativeDeliveryDays = indicativeDeliveryDays($product, $filteredProductVariations,$this->quantity);
        
        $selectedVariantValueIds = $filteredProductVariations->pluck('variation_value_id')->toArray();;
        

        // Prezzo con IVA

        $priceWithTax = variationPrice($product, $filteredProductVariations);
        $discountedPriceWithTax = variationDiscountedPrice($product, $filteredProductVariations,true,$this->quantity);

        // Calcolare il prezzo netto (senza IVA) e l'IVA
        $netPrice = $priceWithTax / (1 + $product_tax);
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


        $quantityDiscounts = view('frontend.default.pages.partials.products.quantityDiscounts', [
            'tiers' => $tiers,
            'netPriceFloat' => $netPrice
        ])->render();


        $recapBodyMobileHtml = view('frontend.default.pages.partials.products.recap-body-mobile', [
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
            'filteredIds' => $filteredIds,
            'recap_body_html' => $recapBodyHtml,
            'indicativeDeliveryDays' => $indicativeDeliveryDays,
            'recap_body_mobile_html' => $recapBodyMobileHtml,
            'quantity_discounts' => $quantityDiscounts,
            'summary_box_variants_html' => $summaryBoxVariantsHtml, // Aggiungi questo per il riepilogo delle varianti
            'variations_html' => view('frontend.default.pages.partials.products.variations', [
                'product' => $product,
                'variation_value_ids' => $selectedVariantValueIds,
                'conditionEffects' => $conditionEffects['valuesToDisable'],
                'motivationalMessages' => $conditionEffects['motivationalMessages'],
                'disableVariationValuesMap' => $conditionEffects['disableVariationValuesMap'],
            ])->render(),
        ];
    }
}
