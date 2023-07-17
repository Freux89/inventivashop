<?php

namespace App\Http\Controllers\Backend\Rewards;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:reward_configurations'])->only('configurations');
        $this->middleware(['permission:set_reward_points'])->only(['setPoints', 'storePoints', 'storeEachProductPoints']);
    }

    # rewards configuration
    public function configurations()
    {
        return view('backend.pages.rewards.configurations');
    }

    # set reward points
    public function setPoints(Request $request)
    {
        $searchKey = null;
        $products = Product::shop()->latest();

        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $products = $products->paginate(paginationNumber());
        return view('backend.pages.rewards.setPoints', compact('products', 'searchKey'));
    }

    # set reward points
    public function storePoints(Request $request)
    {
        $products = Product::query();

        if ($request->points_for == "all") {
            $products = $products->update(['reward_points' => $request->points]);
            flash(localize('Points have been set for all products'))->success();
        } else {
            $products = $products->where('min_price', '>=', $request->min_price)
                ->where('min_price', '<=', $request->max_price)->update(['reward_points' => $request->points]);
            flash(localize('Points have been set for products within the price range'))->success();
        }
        return back();
    }

    # set each product reward points
    public function storeEachProductPoints(Request $request)
    {
        $product = Product::find((int) $request->product_id);
        if (!is_null($product)) {
            $product->reward_points = $request->points;
            $product->save();
        }
        return true;
    }
}
