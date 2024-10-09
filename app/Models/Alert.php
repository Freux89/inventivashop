<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'background_color',
        'text_color',
        'start_date',
        'end_date',
        'is_active',
        'display_location',
        'category_ids',
        'product_ids',
        'include_products',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'product_ids' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'include_products' => 'boolean',
    ];

    public function shouldDisplayOnPage($currentUri)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date && $this->start_date > now()) {
            return false;
        }

        if ($this->end_date && $this->end_date < now()) {
            return false;
        }

        switch ($this->display_location) {
            case 'all_pages':
                return true;
            case 'homepage':
                return $currentUri === '/';
            case 'all_categories':
                return $this->isCategoryPage($currentUri);
            case 'specific_categories':
                return $this->isInSpecificCategory($currentUri) || ($this->include_products && $this->isProductInCategory($currentUri));
            case 'all_products':
                return $this->isProductPage($currentUri);
            case 'specific_products':
                return $this->isSpecificProduct($currentUri);
            default:
                return false;
        }
    }

    private function isCategoryPage($currentUri)
    {
        return !str_contains($currentUri, 'products');
    }

    private function isProductPage($currentUri)
    {
        return preg_match('/^(.*\/)?products\//', $currentUri);
    }

    private function isInSpecificCategory($currentUri)
{
    $categorySlug = request()->route('categorySlug');
    $category = Category::where('slug', $categorySlug)->first();

    if ($category) {
        // Ottenere tutte le categorie specificate e le loro categorie figlie
        $categoryIds = explode(',', $this->category_ids);
        $allCategoryIds = [];

        foreach ($categoryIds as $categoryId) {
            $parentCategory = Category::find($categoryId);
            if ($parentCategory) {
                $allCategoryIds[] = $parentCategory->id;
                $allCategoryIds = array_merge($allCategoryIds, $this->getAllChildCategories($parentCategory));
            }
        }

        // Verifica se la categoria corrente è inclusa tra le categorie specificate o le loro figlie
        return in_array($category->id, $allCategoryIds);
    }

    return false;
}

    private function isSpecificProduct($currentUri)
    {
        $productSlug = request()->route('slug');
        $product = Product::where('slug', $productSlug)->first();

        if ($product) {
            $productIds = explode(',', $this->product_ids);
            if (in_array($product->id, $productIds)) {
                return true;
            }

            // Verifica se il prodotto appartiene a una delle categorie specifiche con il flag `include_products`
            if ($this->include_products) {
                $categoryIds = explode(',', $this->category_ids);
                $productCategoryIds = $product->categories->pluck('id')->toArray();
                return !empty(array_intersect($categoryIds, $productCategoryIds));
            }
        }

        return false;
    }

    private function isProductInCategory($currentUri)
{
    $productSlug = request()->route('slug');
    $product = Product::where('slug', $productSlug)->first();

    if ($product) {
        $categoryIds = explode(',', $this->category_ids);
        $productCategoryIds = $product->categories->pluck('id')->toArray();

        // Verifica se il prodotto appartiene alle categorie specificate direttamente
        if (!empty(array_intersect($categoryIds, $productCategoryIds))) {
            return true;
        }

        // Verifica se il prodotto appartiene a una delle categorie figlie delle categorie specificate
        foreach ($categoryIds as $categoryId) {
            $parentCategory = Category::find($categoryId);
            if ($parentCategory) {
                $allChildCategoryIds = $this->getAllChildCategories($parentCategory);
                if (!empty(array_intersect($allChildCategoryIds, $productCategoryIds))) {
                    return true;
                }
            }
        }
    }

    return false;
}

private function getAllChildCategories($category)
{
    $childCategories = $category->childrenCategories;
    $allChildCategoryIds = $childCategories->pluck('id')->toArray();

    foreach ($childCategories as $childCategory) {
        $allChildCategoryIds = array_merge($allChildCategoryIds, $this->getAllChildCategories($childCategory));
    }

    return $allChildCategoryIds;
}
}
