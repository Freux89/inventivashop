<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        =>  (int) $this->id,
            'price'                     =>  getViewRender('pages.partials.products.variation-pricing', [
                'product'               =>  $this->product,
                'price'                 =>  (float) variationPrice($this->product, $this),
                'discounted_price'      =>  (float) variationDiscountedPrice($this->product, $this)
            ]),
            'stock'                     =>  $this->product_variation_stock ? (int) $this->product_variation_stock->stock_qty : 0,
        ];
    }
}
