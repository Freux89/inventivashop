<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function product_variations()
    {
        return $this->belongsToMany(ProductVariation::class, 'order_item_product_variation');
   
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundRequest()
    {
        return $this->hasOne(Refund::class);
    }
}
