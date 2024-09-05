<?php

use App\Http\Middleware\ApiCurrencyMiddleWare;
use Illuminate\Support\Carbon;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Localization;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\OrderState;
use App\Models\LogisticZone;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

if (!function_exists('getTheme')) {
    # get system theme
    function getTheme()
    {
        if (session('theme') != null && session('theme') != '') {
            return session('theme');
        }
        return Config::get('app.theme');
    }
}

if (!function_exists('getView')) {
    # get view of theme
    function getView($path, $data = [])
    {
        return view('frontend.' . getTheme() . '.' . $path, $data);
    }
}

if (!function_exists('getViewRender')) {
    # get view of theme with render
    function getViewRender($path, $data = [])
    {

        return view('frontend.' . getTheme() . '.' . $path, $data)->render();
    }
}

if (!function_exists('cacheClear')) {
    # clear server cache
    function cacheClear()
    {
        try {
            Artisan::call('cache:forget spatie.permission.cache');
        } catch (\Throwable $th) {
            //throw $th;
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
    }
}

if (!function_exists('clearOrderSession')) {
    # clear session cache
    function clearOrderSession()
    {
        session()->forget('payment_method');
        session()->forget('payment_type');
        session()->forget('order_code');
    }
}

if (!function_exists('csrfToken')) {
    #  Get the CSRF token value.
    function csrfToken()
    {
        $session = app('session');

        if (isset($session)) {
            return $session->token();
        }
        throw new RuntimeException('Session store not set.');
    }
}

if (!function_exists('paginationNumber')) {
    # return number of data per page
    function paginationNumber($value = null)
    {
        return $value != null ? $value : env('DEFAULT_PAGINATION');
    }
}

if (!function_exists('areActiveRoutes')) {
    # return active class
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
        return '';
    }
}

if (!function_exists('validatePhone')) {
    # validatePhone
    function validatePhone($phone)
    {
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
        return $phone;
    }
}


if (!function_exists('staticAsset')) {
    # return path for static assets
    function staticAsset($path, $secure = null)
    {
        if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
            return app('url')->asset('' . $path, $secure) . '?v=' . env('APP_VERSION');
        }
        return app('url')->asset('public/' . $path, $secure) . '?v=' . env('APP_VERSION');
    }
}

if (!function_exists('staticAssetApi')) {
    # return path for static assets
    function staticAssetApi($path, $secure = null)
    {
        if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
            return app('url')->asset('' . $path, $secure);
        }
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('uploadedAsset')) {
    #  Generate an asset path for the uploaded files.
    function uploadedAsset($fileId)
    {
        $mediaFile = MediaManager::find($fileId);
        if (!is_null($mediaFile)) {
            if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
                return app('url')->asset('' . $mediaFile->media_file);
            }
            return app('url')->asset('public/' . $mediaFile->media_file);
        }
        return '';
    }
}

if (!function_exists('uploadedAssetes')) {
    #  Generate an asset path for the uploaded files.
    function uploadedAssetes($ids)
    {
        $ids = explode(",", $ids);

        $assets = [];
        $mediaFiles = MediaManager::whereIn('id', $ids)->get();

        if ($mediaFiles) {

            foreach ($mediaFiles as $file) {
                if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
                    $assets[] = app('url')->asset('' . $file->media_file);
                }
                $assets[] = app('url')->asset('public/' . $file->media_file);
            }
        }
        return $assets;
    }
}

if (!function_exists('productStock')) {
    #  get product stock
    function productStock($product)
    {

        $isVariantProduct = 0;
        $stock = 0;
        if ($product->variations()->count() > 1) {
            $isVariantProduct = 1;
        } else {
            $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
        }
        return $stock;
    }
}



if (!function_exists('localize')) {
    # add / return localization
    function localize($key, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        $t_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

        $localization_english = Cache::rememberForever('localizations-en', function () {
            return Localization::where('lang_key', 'en')->pluck('t_value', 't_key');
        });

        if (!isset($localization_english[$t_key])) {
            # add new localization
            newLocalization('en', $t_key, $key);
        }

        # return user session lang
        $localization_user = Cache::rememberForever("localizations-{$lang}", function () use ($lang) {
            return Localization::where('lang_key', $lang)->pluck('t_value', 't_key')->toArray();
        });

        if (isset($localization_user[$t_key])) {
            return trim($localization_user[$t_key]);
        }

        return isset($localization_english[$t_key]) ? trim($localization_english[$t_key]) : $key;
    }
}

if (!function_exists('calculateVariationPrice')) {
    function calculateVariationPrice($product_price, $productVariation)
    {
        // Definisci le dimensioni statiche (altezza e larghezza in mm)
        $height_mm = 500;
        $width_mm = 700;
        
        // Verifica se il valore variante ha un materiale collegato
        if (hasMaterial($productVariation->variationValue)) {
            // Recupera il materiale associato
            $material = $productVariation->variationValue->material()->first();
            
            // Calcola il prezzo basato sul materiale
            $material_price = calculateMaterialPrice($material, $height_mm, $width_mm);
            
            // Applica il calcolo basato sul tipo di variazione della variante prodotto
            return $product_price + $material_price;
           
        }

        // Se non c'è un materiale collegato, calcola il prezzo basato sulla variante del prodotto
        $price_change_type = $productVariation->price_change_type;

        if ($productVariation->price != 0) {
            $price = $productVariation->price;
        } else {
            $default_price = $productVariation->variationValue->default_price;
            $price = $default_price ? $default_price : 0;
        }

        if ($price_change_type == 'replace') {
            return $price;
        } elseif ($price_change_type == 'amount') {
            return $product_price + $price;
        } elseif ($price_change_type == 'percentage') {
            return $product_price + ($product_price * ($price / 100));
        }

        return $product_price;
    }
}
if (!function_exists('calculateMaterialPrice')) {
    function calculateMaterialPrice($material, $height_mm, $width_mm)
    {
        // Converti le dimensioni da mm a metri
        $height_m = $height_mm / 1000;
        $width_m = $width_mm / 1000;

        // Inizializza la variabile del prezzo
        $price = 0;

        // Calcola il prezzo in base al tipo di calcolo selezionato
        if ($material->price_type == 'mq') {
            // Calcolo in metri quadrati
            $area_mq = $height_m * $width_m;

            // Trova il prezzo in base agli scaglioni di prezzo per mq
            $price = findDynamicPriceByTier($material, $area_mq);

            // Se non ci sono scaglioni applicabili, usa il prezzo di default al mq
            if (is_null($price)) {
                $price = $material->price * $area_mq;
            }
             // Calcola il prezzo di lavorazione
             $processing_price = calculateProcessingPrice($material, $area_mq);
        } elseif ($material->price_type == 'linear') {
            // Calcolo in metri lineari (assumendo che il calcolo sia basato sull'altezza)
            $linear_m = $height_m;

            // Trova il prezzo in base agli scaglioni di prezzo per metro lineare
            $price = findDynamicPriceByTier($material, $linear_m);

            // Se non ci sono scaglioni applicabili, usa il prezzo di default al metro lineare
            if (is_null($price)) {
                $price = $material->price * $linear_m;
            }
            $processing_price = calculateProcessingPrice($material, $linear_m);
        }

        $price += $processing_price;

        return $price;
    }
}

if (!function_exists('calculateProcessingPrice')) {
    function calculateProcessingPrice($material, $quantity)
    {
        // Controlla se esiste un prezzo di lavorazione e una quantità minima per il calcolo
        if (!$material->processing_price || !$material->min_quantity_processing) {
            return 0; // Nessun prezzo di lavorazione applicabile
        }

        // Calcola il coefficiente di riparto
        $coefficiente_riparto = $quantity / $material->min_quantity_processing;
        
        // Calcola il prezzo di lavorazione
        $prezzo_lavorazione = ($material->processing_price / $coefficiente_riparto) * $quantity;
       
        return $prezzo_lavorazione;
    }
}

if (!function_exists('findDynamicPriceByTier')) {
    function findDynamicPriceByTier($material, $quantity)
    {
        // Ottieni tutti gli scaglioni ordinati per quantità minima
        $tiers = $material->priceTiers->sortBy('min_quantity')->values();
        
        // Trova gli scaglioni inferiore e superiore che racchiudono la quantità
        $lower_tier = null;
        $upper_tier = null;

        foreach ($tiers as $index => $tier) {
            if ($quantity >= $tier->min_quantity) {
                $lower_tier = $tier;
                // Verifica se esiste un livello superiore
                if (isset($tiers[$index + 1])) {
                    $upper_tier = $tiers[$index + 1];
                }
            } else {
                break;
            }
        }

        // Se non esiste un livello superiore, utilizza il livello inferiore per calcolare il prezzo
        if (is_null($upper_tier)) {
            return $lower_tier ? $lower_tier->price * $quantity : null;
        }

        // Calcola il prezzo interpolato tra il livello inferiore e quello superiore
        $interpolated_price = interpolatePrice(
            $lower_tier->min_quantity,
            $lower_tier->price,
            $upper_tier->min_quantity,
            $upper_tier->price,
            $quantity
        );

        return $interpolated_price;
    }
}

if (!function_exists('interpolatePrice')) {
    function interpolatePrice($min_quantity_low, $price_low, $min_quantity_high, $price_high, $quantity)
    {
        if ($min_quantity_high == $min_quantity_low) {
            // Se sono uguali, utilizza semplicemente il prezzo più basso (dato che siamo nell'ultima fascia)
            return $price_low * $quantity;
        }
        // Calcola il prezzo interpolato
        $slope = ($price_high - $price_low) / ($min_quantity_high - $min_quantity_low);
        $price = $price_low + ($quantity - $min_quantity_low) * $slope;

        return $price * $quantity; // Restituisci il prezzo totale per la quantità specificata
    }
}


if (!function_exists('findPriceByTier')) {
    function findPriceByTier($material, $quantity)
    {
        // Trova il primo scaglione di prezzo che corrisponde alla quantità (mq o linear)
        $price_tier = $material->priceTiers
            ->where('min_quantity', '<=', $quantity)
            ->sortByDesc('min_quantity')
            ->first();

        // Restituisce il prezzo per l'unità di quantità (mq o linear) o null se nessuno scaglione è applicabile
        return $price_tier ? $price_tier->price : null;
    }
}
if (!function_exists('hasMaterial')) {
    function hasMaterial($variationValue)
    {
        // Usa il metodo material() e controlla se il risultato è non nullo
        return $variationValue->material() !== null;
    }
}
if (!function_exists('newLocalization')) {
    # new localization
    function newLocalization($lang, $t_key, $key)
    {
        $localization = new Localization;
        $localization->lang_key = $lang;
        $localization->t_key = $t_key;
        $localization->t_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
        $localization->save();

        # clear cache
        Cache::forget('localizations-' . $lang);

        return trim($key);
    }
}

if (!function_exists('writeToEnvFile')) {
    # write To Env File
    function
    writeToEnvFile($type, $val)
    {
        if (env('DEMO_MODE') != 'On') {
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"' . trim($val) . '"';
                if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                    file_put_contents($path, str_replace(
                        $type . '="' . env($type) . '"',
                        $type . '=' . $val,
                        file_get_contents($path)
                    ));
                } else {
                    file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
                }
            }
        }
    }
}

if (!function_exists('getFileType')) {
    #  Get file Type
    function getFileType($type)
    {
        $fileTypeArray = [
            // audio
            "mp3"       =>  "audio",
            "wma"       =>  "audio",
            "aac"       =>  "audio",
            "wav"       =>  "audio",

            // video
            "mp4"       =>  "video",
            "mpg"       =>  "video",
            "mpeg"      =>  "video",
            "webm"      =>  "video",
            "ogg"       =>  "video",
            "avi"       =>  "video",
            "mov"       =>  "video",
            "flv"       =>  "video",
            "swf"       =>  "video",
            "mkv"       =>  "video",
            "wmv"       =>  "video",

            // image
            "png"       =>  "image",
            "svg"       =>  "image",
            "gif"       =>  "image",
            "jpg"       =>  "image",
            "jpeg"      =>  "image",
            "webp"      =>  "image",

            // document
            "doc"       =>  "document",
            "txt"       =>  "document",
            "docx"      =>  "document",
            "pdf"       =>  "document",
            "csv"       =>  "document",
            "xml"       =>  "document",
            "ods"       =>  "document",
            "xlr"       =>  "document",
            "xls"       =>  "document",
            "xlsx"      =>  "document",

            // archive
            "zip"       =>  "archive",
            "rar"       =>  "archive",
            "7z"        =>  "archive"
        ];
        return isset($fileTypeArray[$type]) ? $fileTypeArray[$type] : null;
    }
}

if (!function_exists('fileDelete')) {
    # file delete
    function fileDelete($file)
    {
        if (File::exists('public/' . $file)) {
            File::delete('public/' . $file);
        }
    }
}

if (!function_exists('getSetting')) {
    # return system settings value
    function getSetting($key, $default = null)
    {
        try {
            $settings = Cache::remember('settings', 86400, function () {
                return SystemSetting::all();
            });

            $setting = $settings->where('entity', $key)->first();

            return $setting == null ? $default : $setting->value;
        } catch (\Throwable $th) {
            return $default;
        }
    }
}

if (!function_exists('renderStarRating')) {
    # render ratings
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i data-feather='star' width='16' height='16' class='text-primary'></i>";

        $rating = $rating <= $maxRating ? $rating : $maxRating;
        $fullStarCount = (int)$rating;

        $html = str_repeat($fullStar, $fullStarCount);
        echo $html;
    }
}

if (!function_exists('renderStarRatingFront')) {
    # render ratings frontend
    function renderStarRatingFront($rating, $maxRating = 5)
    {
        $fullStar = '<li><i class="fas fa-star"></i></li>';
        $emptyStar = '<li><i class="far fa-star"></i></li>'; // assuming you're using FontAwesome's regular star for empty ones

        $rating = $rating <= $maxRating ? $rating : $maxRating;
        $fullStarCount = (int)$rating;
        $emptyStarCount = $maxRating - $fullStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);

        echo $html; // or return $html; if you prefer to use return instead of echo
    }
}

if (!function_exists('formatPrice')) {

    //formats price - truncate price to 1M, 2K if activated by admin
    function formatPrice($price, $truncate = false, $forceTruncate = false, $addSymbol = true, $numberFormat = true)

    {
        // convert amount equal to local currency
        if (request()->hasHeader('Currency-Code')) {
            $price = floatval($price) / (floatval(env('DEFAULT_CURRENCY_RATE')) || 1);
            $price = floatval($price) * floatval(ApiCurrencyMiddleWare::currencyData()->rate);
        } else if (Session::has('currency_code') && Session::has('local_currency_rate')) {
            $price = floatval($price) / (floatval(env('DEFAULT_CURRENCY_RATE')) || 1);
            $price = floatval($price) * floatval(Session::get('local_currency_rate'));
        }

        if ($numberFormat) {
            // truncate price
            if ($truncate) {
                if (getSetting('truncate_price') == 1 || $forceTruncate == true) {
                    if ($price < 1000000) {
                        // less than a million
                        $price = number_format($price, getSetting('no_of_decimals'));
                    } else if ($price < 1000000000) {
                        // less than a billion
                        $price = number_format($price / 1000000, getSetting('no_of_decimals')) . 'M';
                    } else {
                        // at least a billion
                        $price = number_format($price / 1000000000, getSetting('no_of_decimals')) . 'B';
                    }
                }
            } else {
                // decimals
                if (getSetting('no_of_decimals') > 0) {
                    $price = number_format($price, getSetting('no_of_decimals'));
                } else {
                    $price = number_format($price, getSetting('no_of_decimals'), '.', ',');
                }
            }
        }

        if ($addSymbol) {
            // currency symbol
            if (request()->hasHeader('Currency-Code')) {
                $symbol             =   ApiCurrencyMiddleWare::currencyData()->symbol;
                $symbolAlignment    =    ApiCurrencyMiddleWare::currencyData()->alignment;
            } else {
                $symbol             = Session::has('currency_symbol')           ? Session::get('currency_symbol')           : env('DEFAULT_CURRENCY_SYMBOL');
                $symbolAlignment    = Session::has('currency_symbol_alignment') ? Session::get('currency_symbol_alignment') : env('DEFAULT_CURRENCY_SYMBOL_ALIGNMENT');
            }
            if ($symbolAlignment == 0) {
                return $symbol . ' ' . $price;
            } else if ($symbolAlignment == 1) {
                return $price . $symbol;
            } else if ($symbolAlignment == 2) {
                # space
                return $symbol . ' ' . $price;
            } else {
                # space
                return $price . ' ' .  $symbol;
            }
        }
        return $price;
    }
}

if (!function_exists('apiProductPrice')) {
    //formats price - truncate price to 1M, 2K if activated by admin
    function apiProductPrice($product)
    {
        $price = "00";
        if (productBasePrice($product) == discountedProductBasePrice($product)) {
            if (productBasePrice($product) == productMaxPrice($product)) {
                $price = formatPrice(productBasePrice($product));
            } else {
                $price = formatPrice(productBasePrice($product)) .
                    "-"
                    . formatPrice(productMaxPrice($product));
            }
        } else {
            if (discountedProductBasePrice($product) == discountedProductMaxPrice($product))
                $price = formatPrice(discountedProductBasePrice($product));
            else
                $price = formatPrice(discountedProductBasePrice($product)) .
                    "-"
                    . formatPrice(discountedProductMaxPrice($product));
        }
        return $price;
    }
}


if (!function_exists('priceToUsd')) {
    // price to usd
    function priceToUsd($price)
    {
        // convert amount equal to local currency
        if (Session::has('currency_code') && Session::has('local_currency_rate')) {
            $price = floatval($price) / floatval(Session::get('local_currency_rate'));
        }

        return $price;
    }
}


if (!function_exists('productBasePrice')) {
    // min/base price of a product
    function productBasePrice($product, $formatted = false)
    {
        $price = $product->price;
        $tax = 0;

        foreach ($product->taxes as $productTax) {
            if ($productTax->tax_type == 'percent') {
                $tax += ($price * $productTax->tax_value) / 100;
            } elseif ($productTax->tax_type == 'flat') {
                $tax += $productTax->tax_value;
            }
        }

        $price += $tax;
        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('productNetPrice')) {
    // min/base price of a product
    function productNetPrice($product, $formatted = false)
    {
        $price = $product->price;

        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountedProductBasePrice')) {
    // min/base price of a product with discount
    function discountedProductBasePrice($product, $formatted = false)
    {
        $price = $product->price;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }

        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('productMaxPrice')) {
    // max price of a product
    function productMaxPrice($product, $formatted = false)
    {
        $price = $product->max_price;
        $tax = 0;

        foreach ($product->taxes as $productTax) {
            if ($productTax->tax_type == 'percent') {
                $tax += ($price * $productTax->tax_value) / 100;
            } elseif ($productTax->tax_type == 'flat') {
                $tax += $productTax->tax_value;
            }
        }

        $price += $tax;
        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountedProductMaxPrice')) {
    // max price of a product with discount
    function discountedProductMaxPrice($product, $formatted = false)
    {
        $price = $product->max_price;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }

        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountPercentage')) {
    // return discount in %
    function discountPercentage($product)
    {
        $discountPercentage = $product->discount_value;

        if ($product->discount_type != "percent") {
            $price = productBasePrice($product);
            $discountAmount = discountedProductBasePrice($product);
            $discountValue = $price - $discountAmount;
            $discountPercentage = ($discountValue * 100) / ($price > 0 ? $price : 1);
        }

        return round($discountPercentage);
    }
}

if (!function_exists('sellCountPercentage')) {
    // return sales count %
    function sellCountPercentage($product)
    {
        $sold = $product->total_sale_count;
        $target = (int) $product->sell_target;
        $salePercentage = ($sold * 100) / ($target > 0 ? $target : 1);
        return round($salePercentage);
    }
}

if (!function_exists('generateVariationOptions')) {
    //  generate combinations based on variations
    function generateVariationOptions($options)
    {
        
        if (count($options) == 0) {
            return $options;
        }

        // Passo 1: Raccolta di tutti gli ID univoci dei valori di variante necessari
        $value_ids = [];
        foreach ($options as $option) {
            
            $value_ids[] = $option->variation_value_id;
        }
        $value_ids = array_unique($value_ids);  // Rimuove duplicati

        // Passo 2: Recupero di tutti i valori di variante associati a questi ID in una sola volta
        $all_variation_values = VariationValue::whereIn('id', $value_ids)
            ->orderBy('position', 'asc')
            ->get()
            ->keyBy('id');

        $variation_ids = array();

        foreach ($options as $option) {
            $value_ids = array();
            if (isset($variation_ids[$option->variation_id])) {
                $value_ids = $variation_ids[$option->variation_id];
            }
            if (!in_array($option->variation_value_id, $value_ids)) {
                array_push($value_ids, $option->variation_value_id);
            }
            $variation_ids[$option->variation_id] = $value_ids;
        }

        $options = array();

        foreach ($variation_ids as $id => $values) {

            $variationValues = array();
            usort($values, function ($a, $b) use ($all_variation_values) {
                if (!isset($all_variation_values[$a]) || !isset($all_variation_values[$b])) {
                    return 0; // o gestisci in un altro modo
                }
                return $all_variation_values[$a]->position <=> $all_variation_values[$b]->position;
            });

            foreach ($values as $value) {
                if (isset($all_variation_values[$value])) {
                    $variationValue = $all_variation_values[$value];
                    $val = array(
                        'id'   => $value,
                        'name' => $variationValue->collectLocalization('name'),
                        'code' => $variationValue->color_code,
                        'image' => $variationValue->image,
                        'info_description' => $variationValue->info_description,
                        'info_video_url' => $variationValue->info_video_url, 
                        'info_image_id' => $variationValue->info_image_id, 
                        'info_slider_image_ids' => $variationValue->info_slider_image_ids
                    );
                    array_push($variationValues, $val);
                }
            }
           
            $variation = Variation::find($id);
            
            $data['id'] = $id;
            $data['name'] = $variation->collectLocalization('name');
            $data['alias'] = $variation->collectLocalization('alias');
            $data['display_type'] = $variation->display_type;
            $data['values'] = $variationValues;

            array_push($options, $data);
        }

        return $options;
    }
}

if (!function_exists('prepareConditionsForVariations')) {
    function prepareConditionsForVariations($product, $initialVariations)
    {
        $valuesToDisable = [];
        $motivationalMessages = [];
        $checkedVariationValueIds = [];
        $disableVariationValuesMap = [];
       
       // Ottieni gli ID dei valori delle varianti dalla collezione di varianti iniziali (sia prodotto che template)
    $initialVariationValueIds = collect($initialVariations)->map(function ($variation) {
        return explode(':', explode('/', $variation->variation_key)[0])[1];
    })->toArray();

        // Inizia con gli ID dei valori variante ricevuti
        $variationValueIdsToCheck = $initialVariationValueIds;

        do {
            Log::info('Inizio iterazione', ['variationValueIdsToCheck' => $variationValueIdsToCheck]);

        // Usa le relazioni per ottenere le condizioni filtrate
        $filteredConditions = $product->conditionGroups()
            ->with(['conditions' => function ($query) use ($variationValueIdsToCheck) {
                $query->whereIn('variation_value_id', $variationValueIdsToCheck)
                    ->with('actions.variationValues');
            }])
            ->get()
            ->flatMap(function ($group) {
                return $group->conditions;
            });

        // Ripristina l'elenco degli ID dei valori variante da controllare nella prossima iterazione
        $newVariationValueIdsToCheck = [];

            foreach ($filteredConditions as $condition) {
                $variationValueId = $condition->variation_value_id;

                // Salta questa condizione se la variante corrispondente è stata disattivata
                if (in_array($variationValueId, $valuesToDisable)) {
                    Log::info('Condizione saltata perché la variante è disattivata', ['condition_id' => $condition->id, 'variationValueId' => $variationValueId]);
                    continue;
                }

                Log::info('Processando condizione', ['condition_id' => $condition->id]);

                foreach ($condition->actions as $action) {
                    if ($action->apply_to_all) {
                        // Se l'azione si applica a tutti i valori, aggiungi l'ID della variante all'array $valuesToDisable
                        $variantValuesToDisable = VariationValue::where('variation_id', $action->variation_id)->pluck('id')->toArray();
                        Log::info('Azione apply_to_all', ['variation_id' => $action->variation_id, 'variantValuesToDisable' => $variantValuesToDisable]);

                        foreach ($variantValuesToDisable as $valueId) {
                            if (!in_array($valueId, $valuesToDisable)) {
                                $valuesToDisable[] = $valueId;
                            }
                        }
                    } else {
                        foreach ($action->variationValues as $affectedVariationValue) {
                            $affectedValueId = $affectedVariationValue->id;
                            Log::info('Azione specifica', ['affectedVariationValue_id' => $affectedVariationValue->id, 'affectedValueId' => $affectedValueId]);

                            if (!in_array($affectedValueId, $valuesToDisable)) {
                                $valuesToDisable[] = $affectedValueId;
                                $newVariationValueIdsToCheck[] = $affectedVariationValue->id; // Aggiungi i nuovi ID dei valori variante da controllare
                            }

                            if (!empty($action->motivational_message)) {
                                $motivationalMessages[$affectedValueId] = $action->motivational_message;
                            } elseif (!empty($condition->motivational_message)) {
                                $motivationalMessages[$affectedValueId] = $condition->motivational_message;
                            }
                            else{
                                $motivationalMessages[$affectedValueId] = '';
                            }

                            // Salva il valore di disable_variation_values
                            $disableVariationValuesMap[$affectedValueId] = $action->disable_variation_values;
                        }
                    }
                }
            }

            // Filtra i valori variante disattivati per evitare di applicare le loro condizioni
            $newVariationValueIdsToCheck = array_filter($newVariationValueIdsToCheck, function ($id) use ($valuesToDisable) {
                return !in_array($id, $valuesToDisable);
            });

            Log::info('newVariationValueIdsToCheck dopo filtro', ['newVariationValueIdsToCheck' => $newVariationValueIdsToCheck]);

            // Rimuovi gli ID dei valori variante già controllati per evitare cicli infiniti
            $newVariationValueIdsToCheck = array_diff($newVariationValueIdsToCheck, $checkedVariationValueIds);
            Log::info('newVariationValueIdsToCheck dopo differenza', ['newVariationValueIdsToCheck' => $newVariationValueIdsToCheck]);

            $checkedVariationValueIds = array_merge($checkedVariationValueIds, $newVariationValueIdsToCheck);

            // Imposta i nuovi ID dei valori variante da controllare nella prossima iterazione
            $variationValueIdsToCheck = $newVariationValueIdsToCheck;
        } while (!empty($variationValueIdsToCheck));

        Log::info('Fine iterazione', ['valuesToDisable' => $valuesToDisable, 'checkedVariationValueIds' => $checkedVariationValueIds]);

        // Restituisci gli array dei valori da disabilitare e dei messaggi motivazionali
        return [
            'valuesToDisable' => array_unique($valuesToDisable),
            'motivationalMessages' => $motivationalMessages,
            'disableVariationValuesMap' => $disableVariationValuesMap, 
        ];
    }
}

if (!function_exists('getFinalVariations')) {

    function getFinalVariations($product, $resourceCollection = null)
{
    if (is_null($resourceCollection)) {
        $resourceCollection = collect();
    }

    // Ottieni gli ID delle varianti selezionate
    $selectedVariationIds = $resourceCollection->pluck('id')->toArray();

    // Usa combinedOrderedVariations per ottenere sia varianti prodotto che template
    $orderedVariations = $product->combinedOrderedVariations;

    // Raggruppa tutte le varianti per la loro variante ID
    $groupedVariations = $orderedVariations->groupBy(function ($item) {
        return explode(':', $item->variation_key)[0];
    });

    // Prepara l'array finale delle varianti selezionate
    $finalVariations = [];

    // Itera su ciascun gruppo di varianti
    foreach ($groupedVariations as $variationId => $variations) {
        // Trova la variante selezionata
        $selectedVariation = $variations->first(function ($variation) use ($selectedVariationIds) {
            return in_array($variation->id, $selectedVariationIds);
        });

        // Se c'è una variante selezionata, aggiungila al risultato finale
        if ($selectedVariation) {
            $finalVariations[] = $selectedVariation;
        } else {
            // Altrimenti, aggiungi il primo valore variante del gruppo
            $finalVariations[] = $variations->first();
        }
    }

    // Restituisci direttamente le varianti finali
    return collect($finalVariations);
}

}


if (!function_exists('variationPrice')) {
    // return price of a variation
    function variationPrice($product, $variations)
    {
        $price = $product->price;
        
        // Calcola il prezzo delle varianti
        foreach ($variations as $variation) {

            $price = calculateVariationPrice($price, $variation);
            
        }
        
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }
        return $price;
    }
}

if (!function_exists('variationDiscountedPrice')) {
    // return discounted price of a variation
    function variationDiscountedPrice($product, $variations, $addTax = true, $quantity = 1)
    {
        $price = $product->price;

        // Calcola il prezzo delle varianti
        foreach ($variations as $variation) {
            $price = calculateVariationPrice($price, $variation);
        }

        $discount_applicable = false;

        // Verifica se ci sono sconti per quantità
        $quantityDiscount = $product->quantityDiscounts()->first();
        if ($quantityDiscount) {
            $applicableTier = $quantityDiscount->tiers()->where('min_quantity', '<=', $quantity)->orderBy('min_quantity', 'desc')->first();
            if ($applicableTier) {
                $price -= ($price * $applicableTier->discount_percentage) / 100;
            }
        }

        // Verifica se ci sono altri sconti
        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= strtotime($product->discount_start_date) &&
            strtotime(date('d-m-Y H:i:s')) <= strtotime($product->discount_end_date)
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        // Aggiungi le tasse, se applicabile
        if ($addTax) {
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $price += ($price * $product_tax->tax_value) / 100;
                } elseif ($product_tax->tax_type == 'flat') {
                    $price += $product_tax->tax_value;
                }
            }
        }

        return $price;
    }
}



if (!function_exists('indicativeDeliveryDays')) {
    function indicativeDeliveryDays($product, $variations,$selectedQuantity)
    {
        // Ottieni il tempo medio di spedizione dalla zona di spedizione più veloce
        $fastestShipping = LogisticZone::min('average_delivery_days') ?? 0;

        
        $effectiveDuration = getEffectiveWorkDuration($product,$selectedQuantity);

        // Calcola la durata totale delle lavorazioni delle varianti selezionate
        $variantsWorkDuration = 0;

        foreach ($variations as $variationInfo) {
            // Estrai l'ID del valore della variante da 'variation_key'
            list($variationTypeId, $variationValueId) = explode(':', rtrim($variationInfo['variation_key'], '/'));

            // Cerca l'oggetto VariationValue usando l'ID estratto
            $variationValue = VariationValue::find($variationValueId);
            if ($variationValue) {
                // Recupera il workflow associato al valore della variante
                $variationWorkflow = $variationValue->workflows()->first();
                $workDuration = $variationWorkflow->duration ?? 0;

                // Calcola l'aumento della durata in base alla quantità della variante
                if ($variationWorkflow && $variationWorkflow->quantity > 0 && $variationWorkflow->increase_duration > 0) {
                    $increments = floor($selectedQuantity / $variationWorkflow->quantity); 
                    $workDuration += $increments * $variationWorkflow->increase_duration; 
                }

                $variantsWorkDuration += $workDuration;
            }
        }

        // La consegna indicativa è la somma dei giorni di lavorazione del prodotto, delle varianti e dei giorni di spedizione
        $indicativeDeliveryDays = $effectiveDuration + $variantsWorkDuration + $fastestShipping;

        return $indicativeDeliveryDays;
    }
}


if (!function_exists('getEffectiveWorkDuration')) {
    function getEffectiveWorkDuration($product, $selectedQuantity)
{
    // Recupera il primo workflow associato al prodotto
    $productWorkflow = $product->workflows()->first();
    $productWorkDuration = $productWorkflow->duration ?? 0;

    // Se il prodotto ha una durata di lavorazione specificata, calcola l'aumento basato su quantity e increase_duration
    if ($productWorkDuration > 0) {
        // Calcola l'incremento della durata se il prodotto ha un workflow associato con quantity e increase_duration
        if ($productWorkflow->quantity > 0 && $productWorkflow->increase_duration > 0) {
            // Calcola quanti incrementi si applicano in base alla quantità selezionata
            $increments = floor($selectedQuantity / $productWorkflow->quantity); 
            // Aumenta la durata in base agli incrementi calcolati
            $productWorkDuration += $increments * $productWorkflow->increase_duration; 
        }
        return $productWorkDuration;
    }

    // Se il prodotto non ha una lavorazione, controlla le categorie per la lavorazione
    $categoryDurations = $product->categories->map(function($category) use ($selectedQuantity) {
        $categoryWorkflow = $category->workflows()->first();
        $categoryDuration = $categoryWorkflow->duration ?? 0;

        // Calcola l'incremento della durata se la categoria ha un workflow associato con quantity e increase_duration
        if ($categoryWorkflow && $categoryWorkflow->quantity > 0 && $categoryWorkflow->increase_duration > 0) {
            // Calcola quanti incrementi si applicano in base alla quantità selezionata
            $increments = floor($selectedQuantity / $categoryWorkflow->quantity); 
            // Aumenta la durata in base agli incrementi calcolati
            $categoryDuration += $increments * $categoryWorkflow->increase_duration; 
        }

        return $categoryDuration;
    });

    // Trova la durata massima tra tutte le categorie
    $maxCategoryDuration = $categoryDurations->max() ?? 0;

    return $maxCategoryDuration;
}

}


if (!function_exists('variationTaxAmount')) {
    // return tax of a variation
    function variationTaxAmount($product, $variation)
    {
        $price = $variation->price;
        $tax   = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $tax += $product_tax->tax_value;
            }
        }

        return $tax;
    }
}

if (!function_exists('getSubTotal')) {
    // return sub total price
    function getSubTotal($carts, $couponDiscount = true, $couponCode = '', $addTax = true, $shippingCost = 0, $insuranceCost = 0)
    {
        $price = 0;
        $amount = 0;
        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $productVariations = $cart->product_variations;
                if (!$productVariations->isEmpty()) {
                    $product = $cart->product;  // Assuming that all variations belong to the same product
                    $discountedVariationPriceWithTax = variationDiscountedPrice($product, $productVariations, $addTax, $cart->qty);
                    $price += (float) $discountedVariationPriceWithTax * $cart->qty;
                } else {
                    // Handle the case where the product or product variation does not exist
                    // You could perhaps skip the calculation for this cart item, or show a message, etc.
                }
            }

            # calculate coupon discount
            if ($couponDiscount) {
                $amount = getCouponDiscount($price, $couponCode);
            }
        }

        $price = $price - $amount + $shippingCost + $insuranceCost;

        return $price;
    }
}

if (!function_exists('setCoupon')) {
    // set coupon code in cookie
    function setCoupon($coupon)
    {
        $theTime = time() + 86400 * 7;
        setcookie('coupon_code', $coupon->code, $theTime, '/'); // 86400 = 1 day
    }
}

if (!function_exists('removeCoupon')) {
    // remove coupon code from  cookie
    function removeCoupon()
    {
        if (isset($_COOKIE["coupon_code"])) {
            setcookie("coupon_code", "", time() - 3600);
            unset($_COOKIE["coupon_code"]);
        }
    }
}

if (!function_exists('getCoupon')) {
    // get coupon code from  cookie
    function getCoupon()
    {

        if (request()->hasHeader("Coupon-Code")) {
            return request()->header("Coupon-Code");
        }
        if (isset($_COOKIE["coupon_code"])) {
            return $_COOKIE["coupon_code"];
        }
        return '';
    }
}

if (!function_exists('getCouponDiscount')) {
    // return Coupon Discount amount
    function getCouponDiscount($subTotal, $code = '')
    {
        $amount = 0;
        $coupon = Coupon::where('code', $code)->first();
        if ($coupon) {
            $date = strtotime(date('d-m-Y H:i:s'));
            # check if coupon is not expired
            if ($coupon->start_date <= $date && $coupon->end_date >= $date) {
                if ($coupon->discount_type == 'flat') {
                    $amount = (float) $coupon->discount_value;
                } else {
                    $amount = ((float) $coupon->discount_value * $subTotal) / 100;
                    if ($amount > (float) $coupon->max_discount_amount) {
                        $amount = (float) $coupon->max_discount_amount;
                    }
                }
            } else {
                removeCoupon();
            }
        } else {
            removeCoupon();
        }

        return $amount;
    }
}

if (!function_exists('getCouponDetailsByCode')) {
    // return Coupon Discount amount
    function getCouponDetailsByCode($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();
        if ($coupon) {
            return $coupon;
        }
        return null;
    }
}

if (!function_exists('validateCouponForProductsAndCategories')) {
    # check coupon for products & categories
    function validateCouponForProductsAndCategories($cartItems, $coupon)
    {
        if ($coupon->product_ids) {
            $product_ids = json_decode($coupon->product_ids);
            foreach ($cartItems as $key => $cartItem) {
                if (in_array($cartItem->product_variations->first()->product_id, $product_ids)) {
                    return true;
                }
            }
        }

        if ($coupon->category_ids) {
            $category_ids = json_decode($coupon->category_ids);
            foreach ($cartItems as $key => $cartItem) {
                $product_categories = $cartItem->product_variations->first()->product->product_categories;
                foreach ($product_categories as $key => $product_category) {
                    if (in_array($product_category->category_id, $category_ids)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('checkCouponValidityForCheckout')) {
    // check coupon validity For Checkout
    function checkCouponValidityForCheckout($carts)
    {
        if (getCoupon() != '') {
            $date = strtotime(date('d-m-Y H:i:s'));
            $coupon = Coupon::where('code', getCoupon())->first();
            if ($coupon) {
                # total coupon usage
                $totalCouponUsage = CouponUsage::where('coupon_code', $coupon->code)->sum('usage_count');
                if ($totalCouponUsage == $coupon->total_usage_limit) {
                    # coupon usage limit reached
                    removeCoupon();
                    return [
                        'status'    => false,
                        'message'   => localize('Total usage limit has been reached for the coupon')
                    ];
                }

                # coupon usage by user
                $couponUsageByUser = CouponUsage::where('user_id', auth()->user()->id)->where('coupon_code', $coupon->code)->first();
                if (!is_null($couponUsageByUser)) {
                    if ($couponUsageByUser->usage_count ==  $coupon->customer_usage_limit) {
                        removeCoupon();
                        return [
                            'status'    => false,
                            'message'   => localize('You have used this coupon for maximum time')
                        ];
                    }
                }

                # check if coupon is expired
                if ($coupon->start_date <= $date && $coupon->end_date >= $date) {
                    $subTotal = (float) getSubTotal($carts, false);
                    if ($subTotal >= (float) $coupon->min_spend) {
                        # check if coupon is for categories or products
                        if ($coupon->product_ids || $coupon->category_ids) {
                            if (!validateCouponForProductsAndCategories($carts, $coupon)) {
                                # coupon not valid for your cart items
                                removeCoupon();
                                return [
                                    'status'    => false,
                                    'message'   => localize('Coupon is not valid for the products')
                                ];
                            }

                            return [
                                'status'    => true,
                                'message'   => ''
                            ];
                        }

                        return [
                            'status'    => true,
                            'message'   => ''
                        ];
                    } else {
                        # min amount not reached
                        removeCoupon();
                        return [
                            'status'    => false,
                            'message'   => localize('Minimum order amount is not reached to use this coupon')
                        ];
                    }
                } else {
                    # expired
                    removeCoupon();
                    return [
                        'status'    => false,
                        'message'   => localize('Coupon has been expired')
                    ];
                }
            } else {
                # coupon not found
                removeCoupon();
                return [
                    'status'    => false,
                    'message'   => localize('Coupon is not valid')
                ];
            }
        }

        // coupon not set - so return true
        return [
            'status'    => true,
            'message'   => ''
        ];
    }
}

if (!function_exists('getTotalTax')) {
    // get Total Tax from


    function getTotalTax($carts, $shippingCost = 0, $insuranceCost = 0)
    {
        $IVA = getSetting('global_vat_rate') * 0.01;
        $total = getSubTotal($carts, false, '', false, $shippingCost, $insuranceCost); // Ottieni il totale escludendo tasse e sconti.


        return $total * $IVA;
    }
}

if (!function_exists('calculateOverallDeliveryTime')) {
    function calculateOverallDeliveryTime($carts, $logistic_zone)
    {
        $longestDeliveryTime = 0;

        // Recupera il tempo medio di spedizione più veloce
        $fastestShipping = LogisticZone::min('average_delivery_days') ?? 0;

        // Cerca il valore più alto di indicative_delivery_days tra i prodotti presenti nel carrello
        foreach ($carts as $cart) {
            // Sottrai il fastestShipping se è stato aggiunto a indicative_delivery_days in precedenza
            $deliveryDays = max($cart->indicative_delivery_days - $fastestShipping, 0);
            if ($deliveryDays > $longestDeliveryTime) {
                $longestDeliveryTime = $deliveryDays;
            }
        }

        // Recupera i tempi di spedizione della spedizione selezionata
        $selectedShippingTime = LogisticZone::where('id', $logistic_zone->id)->value('average_delivery_days') ?? 0;

        // Aggiungi i tempi di spedizione selezionati al tempo di consegna più lungo
        $overallDeliveryTime = $longestDeliveryTime + $selectedShippingTime;

        return $overallDeliveryTime;
    }
}

if (!function_exists('calculateEstimatedDeliveryDate')) {
    function calculateEstimatedDeliveryDate($created_at, $indicative_delivery_days)
    {

        if ($indicative_delivery_days == 0) {
            return 'Data non calcolata';
        }

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);

        // Aggiungi un giorno se l'ordine è stato creato dopo le 12:00
        if ($date->hour >= 12) {
            $date->addDay();
        }

        $daysAdded = 0;
        while ($daysAdded < $indicative_delivery_days) {
            $date->addDay();

            // Se il giorno successivo non è né sabato (6) né domenica (0), incrementa il conteggio
            if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $daysAdded++;
            }
        }

        return $date->format('d M, Y');
    }
}

if (!function_exists('getScheduledDeliveryType')) {
    // delivery type Status
    function getScheduledDeliveryType()
    {
        return "scheduled";
    }
}

if (!function_exists('paidPaymentStatus')) {
    // paid Payment Status
    function paidPaymentStatus()
    {
        return "paid";
    }
}
if (!function_exists('unpaidPaymentStatus')) {
    // unpaid Payment Status
    function unpaidPaymentStatus()
    {
        return "unpaid";
    }
}

if (!function_exists('orderPlacedStatus')) {
    // orderPlacedStatus
    function orderPlacedStatus()
    {
        return "order_placed";
    }
}
if (!function_exists('orderPendingStatus')) {
    // orderPendingStatus
    function orderPendingStatus()
    {
        return "pending";
    }
}
if (!function_exists('orderProcessingStatus')) {
    // orderProcessingStatus
    function orderProcessingStatus()
    {
        return "processing";
    }
}

// todo:: orderIsPickedUpStatus Order status
if (!function_exists('orderPickedUpStatus')) {
    // orderIsPickedUpStatus
    function orderPickedUpStatus()
    {
        return "picked_up";
    }
}

// todo:: OutForDelivery Order status
if (!function_exists('orderOutForDeliveryStatus')) {
    // orderProcessingStatus
    function orderOutForDeliveryStatus()
    {
        return "out_for_delivery";
    }
}

if (!function_exists('orderDeliveredStatus')) {
    // order Delivered Status
    function orderDeliveredStatus()
    {
        return "delivered";
    }
}

if (!function_exists('orderCancelledStatus')) {
    // order cancelled Status
    function orderCancelledStatus()
    {
        $cancelledStates = OrderState::where('cancelled', 1)->pluck('id')->toArray();

        return $cancelledStates;
    }
}
if (!function_exists('isColorLight')) {
    function isLight($color)
    {

        $hex = ltrim($color, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
        return $brightness > 155;
    }
}
