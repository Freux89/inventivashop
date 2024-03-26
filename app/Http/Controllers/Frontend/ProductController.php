<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariationInfoResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\Tag;
use App\Models\Category;
use App\Models\LogisticZone;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    # product listing
    public function index(Request $request)
    {
        
        $searchKey = null;
        $per_page = 9;
        $sort_by = $request->sort_by ? $request->sort_by : "new";
        $maxRange = Product::max('max_price');
        $min_value = 0;
        $max_value = formatPrice($maxRange, false, false, false, false);
        
        $category = null;
        $tag = null;

        $products = Product::isPublished();

        # conditional - search by
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        # pagination
        if ($request->per_page != null) {
            $per_page = $request->per_page;
        }

        # sort by
        if ($sort_by == 'new') {
            $products = $products->latest();
        } else {
            $products = $products->orderBy('total_sale_count', 'DESC');
        }

        # by price
        if ($request->min_price != null) {
            $min_value = $request->min_price;
        }
        if ($request->max_price != null) {
            $max_value = $request->max_price;
        }

        if ($request->min_price || $request->max_price) {
            $products = $products->where('min_price', '>=', priceToUsd($min_value))->where('min_price', '<=', priceToUsd($max_value));
        }

        # by category
        if ($request->category_id && $request->category_id != null) {
            $category = Category::find($request->category_id);
            $product_category_product_ids = ProductCategory::where('category_id', $request->category_id)->pluck('product_id');
            $products = $products->whereIn('id', $product_category_product_ids);
        }

        # by tag
        if ($request->tag_id && $request->tag_id != null) {
            $tag = Tag::find($request->tag_id);
            
            $product_tag_product_ids = ProductTag::where('tag_id', $request->tag_id)->pluck('product_id');
            $products = $products->whereIn('id', $product_tag_product_ids);
        }
        # conditional

        $products = $products->paginate(paginationNumber($per_page));

        $tags = Tag::all();
        $breadcrumbs = collect([]);
        return getView('pages.products.index', [
            'category'    => $category,
            'tag'          => $tag,
            'products'      => $products,
            'searchKey'     => $searchKey,
            'per_page'      => $per_page,
            'sort_by'       => $sort_by,
            'max_range'     => formatPrice($maxRange, false, false, false, false),
            'min_value'     => $min_value,
            'max_value'     => $max_value,
            'tags'          => $tags,
            'breadcrumbs'   => $breadcrumbs,
        ]);
    }

    # product show
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (auth()->check() && auth()->user()->user_type == "admin") {
            // do nothing
        } else {
            if ($product->is_published == 0) {
                flash(localize('This product is not available'))->info();
                return redirect()->route('home');
            }
        }

        $productCategories              = $product->categories()->pluck('category_id');
        $productIdsWithTheseCategories  = ProductCategory::whereIn('category_id', $productCategories)->where('product_id', '!=', $product->id)->pluck('product_id');

        $relatedProducts                = Product::whereIn('id', $productIdsWithTheseCategories)->get();

        $product_page_widgets = [];
        if (getSetting('product_page_widgets') != null) {
            $product_page_widgets = json_decode(getSetting('product_page_widgets'));
        }
    
        $breadcrumbs = collect([]);
        foreach ($product->categories as $category) {
            $breadcrumbs->push($category); // Aggiungi la categoria corrente ai breadcrumbs
            while ($parent = $category->parentCategory) {
                $breadcrumbs->prepend($parent); // Aggiungi la categoria genitore ai breadcrumbs
                $category = $parent; // Sposta il riferimento alla categoria genitore per il prossimo ciclo
            }
        }

        $breadcrumbs = $breadcrumbs->unique('id')->values();

        // Recupera la zona di spedizione con il minor tempo medio di consegna
        $fastestZone = LogisticZone::orderBy('average_delivery_days', 'asc')->first();

        // Controlla se il prodotto ha delle lavorazioni associate e calcola la loro durata totale
        
        $workflowsDuration = $product->workflows->first() ? $product->workflows->first()->duration : 0;

        // Se non ci sono zone di spedizione configurate correttamente, imposta un valore di default
        $fastestDeliveryDays = $fastestZone ? $fastestZone->average_delivery_days : 0;

        // Calcola la consegna indicativa sommando i giorni di lavorazione ai giorni di spedizione più veloci
        $indicativeDeliveryDays = $workflowsDuration + $fastestDeliveryDays;

        

        return getView('pages.products.show', ['product' => $product, 'relatedProducts' => $relatedProducts, 'product_page_widgets' => $product_page_widgets, 'breadcrumbs' => $breadcrumbs, 'indicativeDeliveryDays' => $indicativeDeliveryDays]);
    }

    # product info
    public function showInfo(Request $request)
    {
        $product = Product::find($request->id);
        
        return getView('pages.partials.products.product-view-box', ['product' => $product]);
    }

    # product variation info
    public function getVariationInfo(Request $request)
{
    $product_id = $request->product_id;
    
    $variation_ids = $request->variation_id;

    $product_price = Product::find($product_id)->price;
    $total_price = $product_price;
    $productVariations = [];

    foreach ($variation_ids as $key => $variationId) {
        $fieldName = 'variation_value_for_variation_' . $variationId;
        $variation_key = $variationId . ':' . $request[$fieldName] . '/';
        $productVariation = ProductVariation::where('variation_key', $variation_key)->where('product_id', $product_id)->first();

        if ($productVariation) {
            $productVariations[] = $productVariation;
        }
    }
    
    
    return new ProductVariationInfoResource($productVariations,$product_id);
}

public function category(Request $request,$categorySlug)
{
    
    $category = Category::where('slug', $categorySlug)->first();

    
    if (!$category) {
        // Gestire il caso in cui la categoria non esiste
        return redirect()->route('home');
    }
    $maxRange = Product::max('max_price');
    $max_value = formatPrice($maxRange, false, false, false, false);
    // Filtrare i prodotti per la categoria specificata
     // Inizia la query di base per i prodotti
     $query = Product::isPublished()->whereHas('categories', function ($query) use ($category) {
        $query->where('category_id', $category->id);
    });

    // Verifica se è stata inviata una richiesta di ricerca
    if ($request->has('search') && $request->search != '') {
        $searchKey = $request->search;
        // Filtra i prodotti basati sul parametro di ricerca
        $query = $query->where('name', 'like', '%' . $searchKey . '%');
    } else {
        $searchKey = null;
    }

    // Filtraggio per prezzo
    if ($request->has('min_price')) {
        $minPrice = $request->min_price;
        $query = $query->where('price', '>=', $minPrice);
    }

    if ($request->has('max_price')) {
        $maxPrice = $request->max_price;
        $query = $query->where('price', '<=', $maxPrice);
    }

    // Esegue la query con la paginazione
    $products = $query->paginate(paginationNumber(9));


    $breadcrumbs = collect([]);
    $currentCategory = $category;

    // Risali la gerarchia delle categorie fino a quando non ci sono più categorie genitore
    while ($parent = $currentCategory->parentCategory) {
        $breadcrumbs->prepend($parent);
        $currentCategory = $parent; // Sposta il riferimento alla categoria genitore per il prossimo ciclo
    }

    $breadcrumbs = $breadcrumbs->unique('id')->values();

    return getView('pages.products.index', [
        'category'    => $category,
        'products'    => $products,
        // Imposta le altre variabili a null o ai loro valori di default
        'tag'         => null,
        'searchKey'   => $searchKey,
        'per_page'    => 9,
        'sort_by'     => 'new',
        'max_range'   => $maxRange,
        'min_value'   => $request->input('min_price', 0),
        'max_value'   => $request->input('max_price', $max_value),
        'tags'        => Tag::all(),
        'breadcrumbs' => $breadcrumbs,
    ]);
}

}
