<?php

namespace App\Http\Controllers\Backend\Promotions;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Str;

class CouponsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:coupons'])->only('index');
        $this->middleware(['permission:add_coupons'])->only(['create', 'store']);
        $this->middleware(['permission:edit_coupons'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_coupons'])->only(['delete']);
    }

    # Coupon list
    public function index(Request $request)
    {
        $searchKey = null;
        $coupons = Coupon::shop()->latest();
        if ($request->search != null) {
            $coupons = $coupons->where('code', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $coupons = $coupons->paginate(paginationNumber());
        return view('backend.pages.coupons.index', compact('coupons', 'searchKey'));
    }

    # return view of create form
    public function create()
    {
        $products = Product::where('is_published', 1)->shop()->get();
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
        return view('backend.pages.coupons.create', compact('categories', 'products'));
    }


    # Coupon store
    public function store(Request $request)
    {
        if (Str::contains($request->date_range, 'to')) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y"), date("d-m-Y")];
        }
        if (Coupon::where('code', $request->code)->where('shop_id', Auth::user()->shop_id)->count() > 0) {
            flash(localize('Coupon already exist for this coupon code'))->error();
            return back();
        }

        $coupon = new Coupon;
        $coupon->code = $request->code;
        $coupon->shop_id = auth()->user()->shop_id;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->banner = $request->banner;

        if ($request->is_free_shipping == "on") {
            $coupon->is_free_shipping = 1;
        } else {
            $coupon->is_free_shipping = 0;
        }


        $coupon->start_date = strtotime($date_var[0]);
        $coupon->end_date = strtotime($date_var[1]);

        $coupon->min_spend = $request->min_spend;
        $coupon->max_discount_amount = $request->max_discount_amount;

        $coupon->total_usage_limit = $request->total_usage_limit;
        $coupon->customer_usage_limit = $request->customer_usage_limit;

        if ($request->product_ids) {
            $coupon->product_ids = json_encode($request->product_ids);
        }
        if ($request->category_ids) {
            $coupon->category_ids = json_encode($request->category_ids);
        }

        $coupon->save();

        flash(localize('Coupon has been saved successfully'))->success();
        return redirect()->route('admin.coupons.index');
    }

    # edit Coupon
    public function edit(Request $request, $id)
    {
        $products = Product::where('is_published', 1)->get();
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
        $coupon = Coupon::findOrFail($id);
        return view('backend.pages.coupons.edit', compact('coupon', 'products', 'categories'));
    }

    # update Coupon
    public function update(Request $request)
    {
        if (Str::contains($request->date_range, 'to')) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y"), date("d-m-Y")];
        }

        if (Coupon::where('id', '!=', $request->id)->where('code', $request->code)->where('shop_id', Auth::user()->shop_id)->count() > 0) {
            flash(localize('Coupon already exist for this coupon code'))->error();
            return back();
        }

        $coupon = Coupon::findOrFail($request->id);
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->banner = $request->banner;

        if ($request->is_free_shipping == "on") {
            $coupon->is_free_shipping = 1;
        } else {
            $coupon->is_free_shipping = 0;
        }

        $coupon->start_date = strtotime($date_var[0]);
        $coupon->end_date = strtotime($date_var[1]);

        $coupon->min_spend = $request->min_spend;
        $coupon->max_discount_amount = $request->max_discount_amount;

        $coupon->total_usage_limit = $request->total_usage_limit;
        $coupon->customer_usage_limit = $request->customer_usage_limit;

        if ($request->product_ids) {
            $coupon->product_ids = json_encode($request->product_ids);
        }
        if ($request->category_ids) {
            $coupon->category_ids = json_encode($request->category_ids);
        }

        $coupon->save();

        flash(localize('Coupon has been updated successfully'))->success();
        return back();
    }


    # delete Coupon
    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        flash(localize('Coupon has been deleted successfully'))->success();
        return back();
    }
}
