<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeShop($query)
    {
        return $query->where('shop_id', Auth::user()->shop_id);
    }

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }

    protected $with = ['product_localizations'];

    public function product_localizations()
    {
        return $this->hasMany(ProductLocalization::class);
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $product_localizations = $this->product_localizations->where('lang_key', $lang_key)->first();
        return $product_localizations != null && $product_localizations->$entity ? $product_localizations->$entity : $this->$entity;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function variation_combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function product_taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_taxes', 'product_id', 'tax_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
}
