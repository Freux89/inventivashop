<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariationInfoResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\VariationValue;
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

        $currentUrl = url()->current();
    $canonicalUrl = route('products.show', ['slug' => $slug]);

    // Se l'URL corrente è l'URL canonical, sovrascrivi i breadcrumb
    if ($currentUrl === $canonicalUrl) {
        $breadcrumbs = collect();
    } else {
        // Altrimenti, usa i breadcrumb dalla sessione
        $breadcrumbs = session()->get('breadcrumb', collect());
    }
        // Se il breadcrumb è vuoto, crea un breadcrumb di default basato sulla categoria principale del prodotto
     

        $variations = generateVariationOptions($product->combinedOrderedVariations);
        
        $productVariations = $product->combinedOrderedVariations;
       
        $productVariationIds = [];
        $processedVariationIds = [];
        $variationsSel = [];

        foreach ($productVariations as $variation) {
            // Estrarre l'id della variante dalla chiave di variazione
            $variationKeyParts = explode(':', rtrim($variation->variation_key, '/'));
            $variationId = $variationKeyParts[0];

            // Se questa variante non è ancora stata processata, aggiungiamo il suo valore
            if (!in_array($variationId, $processedVariationIds)) {
                $productVariationIds[] = $variation->id;
                $processedVariationIds[] = $variationId;
                $variationsSel[] = $variation;

            }
        }

        $conditionEffects = prepareConditionsForVariations($product, $variationsSel);


        // Filtriamo nuovamente le variazioni del prodotto in base alle condizioni
        $filteredProductVariations = $productVariations->reject(function ($variation) use ($conditionEffects) {
            return in_array($variation->variation_value_id, $conditionEffects['valuesToDisable']);
        });

        // Estrarre solo i primi valori di ogni variante dalle variazioni filtrate
        $uniqueFilteredVariations = collect();
        $uniqueFilteredVariationValues = collect();
        $processedVariationIds = [];
        
        foreach ($filteredProductVariations as $variation) {
            $variationKeyParts = explode(':', rtrim($variation->variation_key, '/'));
            $variationId = $variationKeyParts[0];

            if (!in_array($variationId, $processedVariationIds)) {
                $uniqueFilteredVariations->push($variation);
                $uniqueFilteredVariationValues->push($variation->variation_value_id);
                $processedVariationIds[] = $variationId;
            }
        }

        $indicativeDeliveryDays = indicativeDeliveryDays($product, $uniqueFilteredVariations,1);

        // Calcolo dei prezzi
      
        $priceWithTax = variationPrice($product, $uniqueFilteredVariations);
        
        $discountedPriceWithTax = variationDiscountedPrice($product, $uniqueFilteredVariations);

        // Assumendo che $product_tax sia la percentuale di tassazione, ad esempio 0.22 per il 22%
        $product_tax =  $product->taxes[0]['tax_value'] / 100;  // Assicurati di ottenere questo valore correttamente nel tuo contesto

        $netPrice = $priceWithTax / (1 + $product_tax);
        $discountedNetPrice = $discountedPriceWithTax / (1 + $product_tax);
        $tax = $priceWithTax - $netPrice;
        $discountedTax = $discountedPriceWithTax - $discountedNetPrice;

        $basePrice = $priceWithTax;
        $discountedBasePrice = $discountedPriceWithTax;

        $selectedVariantValueIds = $uniqueFilteredVariationValues->toArray();
       
        $tiers = $product->quantityDiscount->tiers ?? collect();
        
        // Preparazione dei dati da passare alla vista
       
        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'product_page_widgets' => $product_page_widgets,
            'breadcrumbs' => $breadcrumbs,
            'variations' => $variations,
            'product_variationIds' => $productVariationIds,
            'variation_value_ids' => $selectedVariantValueIds,
            'conditionEffects' => $conditionEffects['valuesToDisable'],
            'motivationalMessages' => $conditionEffects['motivationalMessages'],
            'disableVariationValuesMap' => $conditionEffects['disableVariationValuesMap'],
            'indicativeDeliveryDays' => $indicativeDeliveryDays,
            'netPrice' => formatPrice($netPrice),
            'netPriceFloat' => $netPrice,
            'tax' => formatPrice($tax),
            'basePrice' => $basePrice,
            'discountedBasePrice' => $discountedBasePrice,
            'maxPrice' => $basePrice,
            'discountedMaxPrice' => $discountedBasePrice,
            'tiers' => $tiers
        ];

        return getView('pages.products.show', $data);
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
    $quantity = $request->quantity;
    $variation_ids = $request->variation_id;

    $product = Product::find($product_id);
    $productVariations = [];
    if (!empty($variation_ids)) {
    foreach ($variation_ids as $variationId) {
        $fieldName = 'variation_value_for_variation_' . $variationId;
        $variation_key = $variationId . ':' . $request[$fieldName] . '/';

        // Usa il metodo del modello Product per ottenere la variante
        $productVariation = $product->getVariationByKey($variation_key);

        if ($productVariation) {
            // Includi le informazioni della tabella VariationValue
            $variationValue = VariationValue::find(explode(':', rtrim($variation_key, '/'))[1]);
            $productVariation->variation_value_info = $variationValue;

            $productVariations[] = $productVariation;
        }
    }
}

    return new ProductVariationInfoResource($productVariations, $product_id, $quantity);
}

    public function category(Request $request, $categorySlug)
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


        $breadcrumb = collect([]);

        // Costruisci il breadcrumb con le categorie parent
        $currentCategory = $category;
        while ($currentCategory) {
            $breadcrumb->prepend($currentCategory); // Aggiungi la categoria corrente all'inizio del breadcrumb
            $currentCategory = $currentCategory->parentCategory; // Sposta il riferimento alla categoria parent per il prossimo ciclo
        }
        // Rimuovi l'ultimo elemento (la categoria corrente) dal breadcrumb

        // Salva il breadcrumb nella sessione
        session()->put('breadcrumb', $breadcrumb);



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
            'breadcrumbs' => $breadcrumb,
        ]);
    }

    public function categoryWithBreadcrumb(Request $request, $any, $categorySlug)
{
    // Divide la stringa "any" in singoli slug di categoria
    $breadcrumbSlugs = explode('/', $any);
    // Aggiunge l'ultimo slug che è il categorySlug alla lista dei breadcrumbs
    $breadcrumbSlugs[] = $categorySlug;

    // Ottiene l'oggetto categoria dalla categoria finale nell'URL
    $category = Category::where('slug', $categorySlug)->first();

    // Se la categoria non esiste, reindirizza alla home
    if (!$category) {
        return redirect()->route('home');
    }

    // Verifica che gli slug dei breadcrumb corrispondano ai genitori della categoria corrente
    $isValidBreadcrumb = $this->verifyBreadcrumb($category, $breadcrumbSlugs);

    // Se il breadcrumb non è valido, reindirizza all'URL canonical della categoria
    if (!$isValidBreadcrumb) {
        return redirect()->route('category.show', ['categorySlug' => $categorySlug]);
    }

    // Passa il controllo al metodo category
    return $this->category($request, $categorySlug);
}

private function verifyBreadcrumb($category, $breadcrumbSlugs)
{
    // Inizializza un array per mantenere gli slug corretti
    $correctSlugs = [];
    // Inizia dalla categoria corrente e risale ai suoi genitori
    $currentCategory = $category;

    while ($currentCategory) {
        $correctSlugs[] = $currentCategory->slug;
        $currentCategory = $currentCategory->parentCategory; // Assicurati che questo metodo esista nel tuo modello
    }

    // Inverte l'array per confrontarlo con i breadcrumb forniti
    $correctSlugs = array_reverse($correctSlugs);

    // Confronta gli slug corretti con quelli forniti
    return $breadcrumbSlugs == $correctSlugs;
}

public function showWithBreadcrumb(Request $request, $any, $slug)
{
    // Divide la stringa "any" in singoli slug di categoria
    $breadcrumbSlugs = explode('/', $any);

    // Ottiene l'oggetto prodotto dallo slug
    $product = Product::where('slug', $slug)->first();

    // Se il prodotto non esiste, reindirizza alla home
    if (!$product) {
        return redirect()->route('home');
    }

    // Verifica che gli slug dei breadcrumb corrispondano ai genitori della categoria del prodotto
    $isValidBreadcrumb = $this->verifyProductBreadcrumb($product, $breadcrumbSlugs);

    // Se il breadcrumb non è valido, reindirizza all'URL canonical del prodotto
    if (!$isValidBreadcrumb) {
        return redirect()->route('products.show', ['slug' => $slug]);
    }

    // Passa il controllo al metodo show
    return $this->show($slug);
}

private function verifyProductBreadcrumb($product, $breadcrumbSlugs)
{
    // Ottiene le categorie associate al prodotto
    $categories = $product->categories; // Assicurati che questo metodo esista nel tuo modello Product

    foreach ($categories as $category) {
        // Verifica se uno degli alberi delle categorie del prodotto corrisponde ai breadcrumb forniti
        if ($this->verifyBreadcrumb($category, $breadcrumbSlugs)) {
            return true;
        }
    }

    return false;
}
}
