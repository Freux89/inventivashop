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
        $resourceCollection = collect($this->resource);
       
        $ids = $resourceCollection->isEmpty() ? [] : $resourceCollection->pluck('id')->toArray();
        
        $product = Product::find($this->productId);

        $productVariations = ProductVariation::findMany($ids);
        $variantValueIds = $productVariations->pluck('variant_value_id')->toArray();
        $productVariationIds = $productVariations->pluck('id')->toArray();

        $total_stock = array_reduce($this->resource, function($carry, $item) {
            return $carry + ($item['product_variation_stock'] ? (int) $item['product_variation_stock']->stock_qty : 0);
        }, 0);

        $conditionEffects = prepareConditionsForVariations($product, $productVariationIds);
        $filteredProductVariations = $productVariations->reject(function ($variation) use ($conditionEffects) {
            return in_array($variation->variant_value_id, $conditionEffects);
        });
        $filteredIds = $filteredProductVariations->isEmpty() ? [] : $filteredProductVariations->pluck('id')->toArray();
        
        $indicativeDeliveryDays = indicativeDeliveryDays($product, $filteredProductVariations);
        $selectedVariantValueIds = array_diff($variantValueIds, $conditionEffects);

        // Prezzo con IVA
        $priceWithTax = variationPrice($product, $filteredProductVariations);
        $discountedPriceWithTax = variationDiscountedPrice($product, $filteredProductVariations);

        // Calcolare il prezzo netto (senza IVA) e l'IVA
        $netPrice = $priceWithTax / 1.22;
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
             // Assumendo che discountedMaxPrice = discountedBasePrice se non si usa in altro modo
        ])->render();
       
        return [
            'ids' => $ids,
            'filteredIds' => $filteredIds,
            'recap_body_html' => $recapBodyHtml,
            'variations_html' => view('frontend.default.pages.partials.products.variations', [
                'product' => $product,
                'variation_value_ids' => $selectedVariantValueIds,
                'conditionEffects' => $conditionEffects
            ])->render(),
        ];
    }
}
