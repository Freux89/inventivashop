<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductVariation;
use App\Models\Product;
class ProductVariationInfoResource extends JsonResource
{
    
    protected $productId;

    public function __construct($resource,$productId)
    {
        parent::__construct($resource);
        $this->productId = $productId;
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
    
        
        $conditionEffects = prepareConditionsForVariations($product,$productVariationIds);

        $filteredProductVariations = $productVariations->reject(function ($variation) use ($conditionEffects) {
            return in_array($variation->variant_value_id, $conditionEffects);
        });
        
        $indicativeDeliveryDays = indicativeDeliveryDays($product, $filteredProductVariations);
        $selectedVariantValueIds = array_diff($variantValueIds, $conditionEffects);
      
        return [
            'ids'                       =>  $ids,
            'price'                     =>  getViewRender('pages.partials.products.variation-pricing', [
                'product'               =>  $product,
                'price'                 =>  (float) variationPrice($product, $filteredProductVariations),
                'discounted_price'      =>  (float) variationDiscountedPrice($product, $filteredProductVariations),
                'indicativeDeliveryDays' => $indicativeDeliveryDays
            ]),
            'stock'                     =>  $total_stock,
            'indicativeDeliveryDays' => $indicativeDeliveryDays,
            'variations_html' => view('frontend.default.pages.partials.products.variations', [
                'product' => $product,
                'variation_value_ids' => $selectedVariantValueIds,
                'conditionEffects' => $conditionEffects
            ])->render(),
        ];
    }
    
}

