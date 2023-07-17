<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Location;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\Product;
use App\Models\ProductLocalization;
use App\Models\ProductVariation;
use App\Models\ProductVariationStock;
use App\Models\ProductVariationCombination;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:products'])->only('index');
        $this->middleware(['permission:add_products'])->only(['create', 'store']);
        $this->middleware(['permission:edit_products'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_products'])->only(['updatePublishedStatus']);
    }

    # product list
    public function index(Request $request)
    {
        $searchKey = null;
        $brand_id = null;
        $is_published = null;

        $products = Product::shop()->latest();
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->brand_id != null) {
            $products = $products->where('brand_id', $request->brand_id);
            $brand_id    = $request->brand_id;
        }

        if ($request->is_published != null) {
            $products = $products->where('is_published', $request->is_published);
            $is_published    = $request->is_published;
        }

        $brands = Brand::latest()->get();
        $products = $products->paginate(paginationNumber());
        return view('backend.pages.products.products.index', compact('products', 'brands', 'searchKey', 'brand_id', 'is_published'));
    }

    # return view of create form
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
        $brands = Brand::isActive()->get();
        $units = Unit::isActive()->get();
        $variations = Variation::isActive()->whereNotIn('id', [1, 2])->get();
        $taxes = Tax::isActive()->get();
        $tags = Tag::all();
        return view('backend.pages.products.products.create', compact('categories', 'brands', 'units', 'variations', 'taxes', 'tags'));
    }

    # get variation values to add new product
    public function getVariationValues(Request $request)
    {
        $variation_id = $request->variation_id;
        $variation_values = VariationValue::isActive()->where('variation_id', $variation_id)->get();

        return view('backend.pages.products.products.new_variation_values', compact('variation_values', 'variation_id'));
    }

    # new chosen variation
    public function getNewVariation(Request $request)
    {
        $variations = Variation::query();
        if ($request->has('chosen_variations')) {
            $variations = $variations->whereNotIn('id', $request->chosen_variations)->get();
        } else {
            $variations = $variations->get();
        }
        if (count($variations) > 0) {
            return array(
                'count' => count($variations),
                'view' => view('backend.pages.products.products.new_variation', compact('variations'))->render(),
            );
        } else {
            return false;
        }
    }

    # generate variation combinations
    public function generateVariationCombinations(Request $request)
    {
        $variations_and_values = array();

        if ($request->has('chosen_variations')) {
            $chosen_variations = $request->chosen_variations;
            sort($chosen_variations, SORT_NUMERIC);

            foreach ($chosen_variations as $key => $option) {

                $option_name = 'option_' . $option . '_choices'; # $option = variation_id
                $value_ids = array();

                if ($request->has($option_name)) {

                    $variation_option_values = $request[$option_name];
                    sort($variation_option_values, SORT_NUMERIC);

                    foreach ($variation_option_values as $item) {
                        array_push($value_ids, $item);
                    }
                    $variations_and_values[$option] =  $value_ids;
                }
            }
        }

        $combinations = array(array());
        foreach ($variations_and_values as $variation => $variation_values) {
            $tempArray = array();
            foreach ($combinations as $combination_item) {
                foreach ($variation_values as $variation_value) {
                    $tempArray[] = $combination_item + array($variation => $variation_value);
                }
            }
            $combinations = $tempArray;
        }
        return view('backend.pages.products.products.new_variation_combinations', compact('combinations'))->render();
    }

    # add new data
    public function store(Request $request)
    {
        if ($request->has('is_variant') && !$request->has('variations')) {
            flash(localize('Invalid product variations, please check again'))->error();
            return redirect()->back();
        }

        $product                    = new Product;
        $product->shop_id           = auth()->user()->shop_id;
        $product->name              = $request->name;
        $product->slug              = Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));
        $product->brand_id          = $request->brand_id;
        $product->unit_id           = $request->unit_id;
        $product->sell_target       = $request->sell_target;

        $product->thumbnail_image   = $request->image;
        $product->gallery_images    = $request->images;
        $product->size_guide        = $request->size_guide;

        $product->description       = $request->description;
        $product->short_description = $request->short_description;

        # min-max price
        if ($request->has('is_variant') && $request->has('variations')) {
            $product->min_price =  priceToUsd(min(array_column($request->variations, 'price')));
            $product->max_price =  priceToUsd(max(array_column($request->variations, 'price')));
        } else {
            $product->min_price =  priceToUsd($request->price);
            $product->max_price =  priceToUsd($request->price);
        }

        # discount
        $product->discount_value    = $request->discount_value ?? 0;
        $product->discount_type     = $request->discount_type;


        if ($request->date_range != null) {
            if (Str::contains($request->date_range, 'to')) {
                $date_var = explode(" to ", $request->date_range);
            } else {
                $date_var = [date("d-m-Y"), date("d-m-Y")];
            }
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime($date_var[1]);
        }

        # stock qty based on all variations / no variation 
        $product->stock_qty   = ($request->has('is_variant') && $request->has('variations')) ? max(array_column($request->variations, 'stock')) : $request->stock;

        $product->is_published         = $request->is_published;
        $product->has_variation        = ($request->has('is_variant') && $request->has('variations')) ? 1 : 0;

        # shipping info
        $product->standard_delivery_hours    = $request->standard_delivery_hours;
        $product->express_delivery_hours     = $request->express_delivery_hours;
        $product->min_purchase_qty     = $request->min_purchase_qty;
        $product->max_purchase_qty     = $request->max_purchase_qty;


        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_img = $request->meta_image;

        $product->save();
        # Product Localization
        $ProductLocalization = ProductLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $ProductLocalization->name = $request->name;
        $ProductLocalization->description = $request->description;
        $ProductLocalization->save();

        # tags
        $product->tags()->sync($request->tag_ids);

        # category
        $product->categories()->sync($request->category_ids);

        # taxes
        $tax_data = array();
        $tax_ids = array();
        if ($request->has('taxes')) {
            foreach ($request->taxes as $key => $tax) {
                array_push($tax_data, [
                    'tax_value' => $tax,
                    'tax_type' => $request->tax_types[$key]
                ]);
            }
            $tax_ids = $request->tax_ids;
        }
        $taxes = array_combine($tax_ids, $tax_data);
        $product->product_taxes()->sync($taxes);

        $location = Location::where('is_default', 1)->first();

        if ($request->has('is_variant') && $request->has('variations')) {
            foreach ($request->variations as $variation) {
                $product_variation              = new ProductVariation;
                $product_variation->product_id  = $product->id;
                $product_variation->variation_key        = $variation['variation_key'];
                $product_variation->price       = priceToUsd($variation['price']);
                $product_variation->sku         = $variation['sku'];
                $product_variation->code         = $variation['code'];
                $product_variation->save();

                $product_variation_stock                              = new ProductVariationStock;
                $product_variation_stock->product_variation_id        = $product_variation->id;
                $product_variation_stock->location_id                 = $location->id;
                $product_variation_stock->stock_qty                   = $variation['stock'];
                $product_variation_stock->save();

                foreach (array_filter(explode("/", $variation['variation_key'])) as $combination) {
                    $product_variation_combination                         = new ProductVariationCombination;
                    $product_variation_combination->product_id             = $product->id;
                    $product_variation_combination->product_variation_id   = $product_variation->id;
                    $product_variation_combination->variation_id           = explode(":", $combination)[0];
                    $product_variation_combination->variation_value_id     = explode(":", $combination)[1];
                    $product_variation_combination->save();
                }
            }
        } else {
            $variation              = new ProductVariation;
            $variation->product_id  = $product->id;
            $variation->sku         = $request->sku;
            $variation->code         = $request->code;
            $variation->price       = priceToUsd($request->price);
            $variation->save();
            $product_variation_stock                          = new ProductVariationStock;
            $product_variation_stock->product_variation_id    = $variation->id;
            $product_variation_stock->location_id             = $location->id;
            $product_variation_stock->stock_qty               = $request->stock;
            $product_variation_stock->save();
        }

        flash(localize('Product has been inserted successfully'))->success();
        return redirect()->route('admin.products.index');
    }

    # return view of edit form
    public function edit(Request $request, $id)
    {
        $location = Location::where('is_default', 1)->first();
        $request->session()->put('stock_location_id',  $location->id);

        $lang_key = $request->lang_key;
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.products.index');
        }
        $product = Product::findOrFail($id);
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
        $brands = Brand::isActive()->get();
        $units = Unit::isActive()->get();
        $variations = Variation::isActive()->whereNotIn('id', [1, 2])->get();
        $taxes = Tax::isActive()->get();
        $tags = Tag::all();
        return view('backend.pages.products.products.edit', compact('product', 'categories', 'brands', 'units', 'variations', 'taxes', 'lang_key', 'tags'));
    }

    # update product
    public function update(Request $request)
    {
        if ($request->has('is_variant') && !$request->has('variations')) {
            flash(localize('Invalid product variations, please check again'))->error();
            return redirect()->back();
        }

        $product                    = Product::where('id', $request->id)->first();
        $oldProduct                 = clone $product;

        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
            $product->name              = $request->name;
            $product->slug              = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));
            $product->description       = $request->description;
            $product->sell_target       = $request->sell_target;
            $product->brand_id          = $request->brand_id;
            $product->unit_id           = $request->unit_id;
            $product->short_description = $request->short_description;

            $product->thumbnail_image   = $request->image;
            $product->gallery_images   = $request->images;
            $product->size_guide        = $request->size_guide;

            # min-max price
            if ($request->has('is_variant') && $request->has('variations')) {
                $product->min_price =  priceToUsd(min(array_column($request->variations, 'price')));
                $product->max_price =  priceToUsd(max(array_column($request->variations, 'price')));
            } else {
                $product->min_price =  priceToUsd($request->price);
                $product->max_price =  priceToUsd($request->price);
            }

            # discount
            $product->discount_value    = $request->discount_value;
            $product->discount_type     = $request->discount_type;
            if ($request->date_range != null) {

                if (Str::contains($request->date_range, 'to')) {
                    $date_var = explode(" to ", $request->date_range);
                } else {
                    $date_var = [date("d-m-Y"), date("d-m-Y")];
                }

                $product->discount_start_date = strtotime($date_var[0]);
                $product->discount_end_date   = strtotime($date_var[1]);
            }

            # stock qty based on all variations / no variation 
            $product->stock_qty   = ($request->has('is_variant') && $request->has('variations')) ? max(array_column($request->variations, 'stock')) : $request->stock;

            $product->is_published         = $request->is_published;
            $product->has_variation        = ($request->has('is_variant') && $request->has('variations')) ? 1 : 0;

            # shipping info
            $product->standard_delivery_hours    = $request->standard_delivery_hours;
            $product->express_delivery_hours     = $request->express_delivery_hours;
            $product->min_purchase_qty     = $request->min_purchase_qty;
            $product->max_purchase_qty     = $request->max_purchase_qty;


            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_img = $request->meta_image;


            $product->save();

            # tags
            $product->tags()->sync($request->tag_ids);

            # category
            $product->categories()->sync($request->category_ids);

            # taxes
            $tax_data = array();
            $tax_ids = array();
            if ($request->has('taxes')) {
                foreach ($request->taxes as $key => $tax) {
                    array_push($tax_data, [
                        'tax_value' => $tax,
                        'tax_type' => $request->tax_types[$key]
                    ]);
                }
                $tax_ids = $request->tax_ids;
            }
            $taxes = array_combine($tax_ids, $tax_data);
            $product->product_taxes()->sync($taxes);


            $location = Location::where('is_default', 1)->first();

            if ($request->has('is_variant') && $request->has('variations')) {

                $new_requested_variations = collect($request->variations);
                $new_requested_variations_key = $new_requested_variations->pluck('variation_key')->toArray();
                $old_variations_keys = $product->variations->pluck('variation_key')->toArray();
                $old_matched_variations = $new_requested_variations->whereIn('variation_key', $old_variations_keys);
                $new_variations = $new_requested_variations->whereNotIn('variation_key', $old_variations_keys);

                # delete old variations that isn't requested
                $product->variations->whereNotIn('variation_key', $new_requested_variations_key)->each(function ($variation) use ($location) {
                    foreach ($variation->combinations as $comb) {
                        $comb->delete();
                    }
                    $variation->product_variation_stock_without_location()->where('location_id', $location->id)->delete();
                    $variation->delete();
                });

                # update old matched variations
                foreach ($old_matched_variations as $variation) {
                    $p_variation              = ProductVariation::where('product_id', $product->id)->where('variation_key', $variation['variation_key'])->first();
                    $p_variation->price       = priceToUsd($variation['price']);
                    $p_variation->sku         = $variation['sku'];
                    $p_variation->code         = $variation['code'];
                    $p_variation->save();

                    # update stock of this variation
                    $productVariationStock = $p_variation->product_variation_stock_without_location()->where('location_id', $location->id)->first();
                    if (is_null($productVariationStock)) {
                        $productVariationStock = new ProductVariationStock;
                        $productVariationStock->product_variation_id    = $p_variation->id;
                    }
                    $productVariationStock->stock_qty = $variation['stock'];
                    $productVariationStock->location_id = $location->id;
                    $productVariationStock->save();
                }

                # store new requested variations
                foreach ($new_variations as $variation) {
                    $product_variation                      = new ProductVariation;
                    $product_variation->product_id          = $product->id;
                    $product_variation->variation_key       = $variation['variation_key'];
                    $product_variation->price               = priceToUsd($variation['price']);
                    $product_variation->sku                 = $variation['sku'];
                    $product_variation->code                 = $variation['code'];
                    $product_variation->save();

                    $product_variation_stock                              = new ProductVariationStock;
                    $product_variation_stock->product_variation_id        = $product_variation->id;
                    $product_variation_stock->stock_qty                   = $variation['stock'];
                    $product_variation_stock->save();

                    foreach (array_filter(explode("/", $variation['variation_key'])) as $combination) {
                        $product_variation_combination                         = new ProductVariationCombination;
                        $product_variation_combination->product_id             = $product->id;
                        $product_variation_combination->product_variation_id   = $product_variation->id;
                        $product_variation_combination->variation_id           = explode(":", $combination)[0];
                        $product_variation_combination->variation_value_id     = explode(":", $combination)[1];
                        $product_variation_combination->save();
                    }
                }
            } else {
                # check if old product is variant then delete all old variation & combinations
                if ($oldProduct->is_variant) {
                    foreach ($product->variations as $variation) {
                        foreach ($variation->combinations as $comb) {
                            $comb->delete();
                        }
                        $variation->delete();
                    }
                }

                $variation                       = $product->variations->first();
                $variation->product_id           = $product->id;
                $variation->variation_key        = null;
                $variation->sku                  = $request->sku;
                $variation->code                  = $request->code;
                $variation->price                = priceToUsd($request->price);
                $variation->save();


                if ($variation->product_variation_stock) {
                    $productVariationStock = $variation->product_variation_stock_without_location()->where('location_id', $location->id)->first();

                    if (is_null($productVariationStock)) {
                        $productVariationStock = new ProductVariationStock;
                    }

                    $productVariationStock->product_variation_id    = $variation->id;
                    $productVariationStock->stock_qty               = $request->stock;
                    $productVariationStock->location_id = $location->id;
                    $productVariationStock->save();
                } else {
                    $product_variation_stock                          = new ProductVariationStock;
                    $product_variation_stock->product_variation_id    = $variation->id;
                    $product_variation_stock->stock_qty               = $request->stock;
                    $product_variation_stock->save();
                }
            }
        }
        # Product Localization
        $ProductLocalization = ProductLocalization::firstOrNew(['lang_key' => $request->lang_key, 'product_id' => $product->id]);
        $ProductLocalization->name = $request->name;
        $ProductLocalization->description = $request->description;
        $ProductLocalization->short_description = $request->short_description;
        $ProductLocalization->save();

        flash(localize('Product has been updated successfully'))->success();
        return back();
    }

    # update status
    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    # update published
    public function updatePublishedStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_published = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    # delete product
    public function delete($id)
    {
        #
    }
}
