<?php

use App\Http\Middleware\ApiCurrencyMiddleWare;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Localization;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\OrderState;
use Illuminate\Http\Request;
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
      
        $price_change_type = $productVariation->price_change_type;
        $price = $productVariation->price;

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

        $rating = $rating <= $maxRating ? $rating : $maxRating;
        $fullStarCount = (int)$rating;

        $html = str_repeat($fullStar, $fullStarCount);
        echo $html;
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
                return $symbol . $price;
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
            if(isset($all_variation_values[$value])) {
                $variationValue = $all_variation_values[$value];
                $val = array(
                    'id'   => $value,
                    'name' => $variationValue->collectLocalization('name'),
                    'code' => $variationValue->color_code
                );
                array_push($variationValues, $val);
            }
        }
        
        $variation = Variation::find($id);
        $data['id'] = $id;
        $data['name'] = $variation->collectLocalization('name');
        $data['display_type'] = $variation->display_type;
        $data['values'] = $variationValues;
    
        array_push($options, $data);
    }
    
    return $options;
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
    function variationDiscountedPrice($product, $variations, $addTax = true)
    {
        $price = $product->price;
    
        // Calcola il prezzo delle varianti
        foreach ($variations as $variation) {
            
            $price = calculateVariationPrice($price, $variation);
        }
    
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
    function getSubTotal($carts, $couponDiscount = true, $couponCode = '', $addTax = true)
    {
        $price = 0;
        $amount = 0;
        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $productVariations = $cart->product_variations;
                if (!$productVariations->isEmpty()) {
                    $product = $productVariations->first()->product;  // Assuming that all variations belong to the same product
                    $discountedVariationPriceWithTax = variationDiscountedPrice($product, $productVariations, $addTax);
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

        return $price - $amount;
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
   

function getTotalTax($carts)
{
    $IVA = getSetting('global_vat_rate') * 0.01;
    $total = getSubTotal($carts, false, '', false); // Ottieni il totale escludendo tasse e sconti.
    
    return $total * $IVA;
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
function isLight($color) {
    
    $hex = ltrim($color, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    return $brightness > 155;
}
}
