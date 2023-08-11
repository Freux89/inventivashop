<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'guest_user_id',
        'location_id',
        // ... qualsiasi altro campo che vuoi rendere fillable
    ];
    
    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function product_variations()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_product_variation');

    }
}
