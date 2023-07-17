<?php

namespace App\Http\Controllers\Backend\Stocks;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductVariationStock;
use Illuminate\Http\Request;

class StocksController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:add_stock'])->only(['create', 'store']);
    }

    # add stock form
    public function create()
    {
        $products = Product::latest()->where('is_published', 1)->get();
        $locations = Location::latest()->where('is_published', 1)->get();
        return view('backend.pages.stocks.create', compact('products', 'locations'));
    }

    # get variation stock
    public function getVariationStocks(Request $request)
    {
        $product = Product::findOrFail((int) $request->product_id);
        $location_id = $request->location_id;
        return [
            'success'   => true,
            'variation_stocks'  => view('backend.pages.stocks.variation_stocks', compact('product', 'location_id'))->render()
        ];
    }

    # add stock
    public function store(Request $request)
    {
        if ($request->has('product_variation_id')) {
            $productVariationStock = ProductVariationStock::where('product_variation_id', $request->product_variation_id)
                ->where('location_id', $request->location_id)->first();
            if (is_null($productVariationStock)) {
                $productVariationStock = new ProductVariationStock;
                $productVariationStock->product_variation_id = $request->product_variation_id;
                $productVariationStock->location_id = $request->location_id;
            }
            $productVariationStock->stock_qty = $request->stock;
            $productVariationStock->save();
        } else {
            foreach ($request->variationsIds as $key => $productVariationId) {
                $productVariationStock = ProductVariationStock::where('product_variation_id', $productVariationId)
                    ->where('location_id', $request->location_id)->first();

                if (is_null($productVariationStock)) {
                    $productVariationStock = new ProductVariationStock;
                    $productVariationStock->product_variation_id = $productVariationId;
                    $productVariationStock->location_id = $request->location_id;
                }
                $productVariationStock->stock_qty = $request->variationStocks[$key];
                $productVariationStock->save();
            }
        }
        flash(localize('Stock updated successfully'))->success();
        return back();
    }
}
