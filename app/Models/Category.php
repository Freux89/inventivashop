<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Category extends Model
{
    use HasFactory; 

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }  
 
    protected $with = ['category_localizations', 'parentCategory'];  

    public function category_localizations()
    {
        return $this->hasMany(CategoryLocalization::class);
    }  
        
    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $category_localizations = $this->category_localizations->where('lang_key', $lang_key)->first();
        return $category_localizations != null && $category_localizations->$entity ? $category_localizations->$entity : $this->$entity;
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function product_categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brands', 'category_id', 'brand_id');
    } 
}
