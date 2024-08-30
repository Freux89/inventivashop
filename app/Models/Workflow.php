<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_workflows');
    }

    // Relazione con VariationValue
    public function variationValues()
    {
        return $this->belongsToMany(VariationValue::class, 'variation_value_workflows');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_workflow');
    }
}
