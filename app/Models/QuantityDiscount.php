<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class QuantityDiscount extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'status'];

    public function tiers()
    {
        return $this->hasMany(QuantityDiscountTier::class)->orderBy('min_quantity', 'desc');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_quantity_discounts');
    }
}
