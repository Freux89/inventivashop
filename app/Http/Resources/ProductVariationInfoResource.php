<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationInfoResource extends JsonResource
{
    
    
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {

        $ids = array_map(function ($item) {
            return $item['id'];
        }, $this->resource);

        $total_stock = array_reduce($this->resource, function($carry, $item) {
            return $carry + ($item['product_variation_stock'] ? (int) $item['product_variation_stock']->stock_qty : 0);
        }, 0);
    

        $indicativeDeliveryDays = indicativeDeliveryDays($this->resource[0]['product'], $this->resource);

        return [
            'ids'                       =>  $ids,
            'id'                        =>  (int) $this->resource[0]['id'],
            'price'                     =>  getViewRender('pages.partials.products.variation-pricing', [
                'product'               =>  $this->resource[0]['product'],
                'price'                 =>  (float) variationPrice($this->resource[0]['product'], $this->resource),
                'discounted_price'      =>  (float) variationDiscountedPrice($this->resource[0]['product'], $this->resource),
                'indicativeDeliveryDays' => $indicativeDeliveryDays
            ]),
            'stock'                     =>  $total_stock,
            'indicativeDeliveryDays' => $indicativeDeliveryDays
        ];
    }
    
}

