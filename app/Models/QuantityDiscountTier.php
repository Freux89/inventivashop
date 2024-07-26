<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityDiscountTier extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['quantity_discount_id', 'min_quantity', 'discount_percentage'];

    public function discount()
    {
        return $this->belongsTo(QuantityDiscount::class);
    }
}
