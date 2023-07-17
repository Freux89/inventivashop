<?php

namespace App\Http\Controllers\Backend\Promotions;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\BrandLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:campaigns'])->only('index');
        $this->middleware(['permission:add_campaigns'])->only(['create', 'store']);
        $this->middleware(['permission:edit_campaigns'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_campaigns'])->only(['updatePublishedStatus']);
        $this->middleware(['permission:delete_campaigns'])->only(['delete']);
    }

    # campaign list
    public function index(Request $request)
    {
        $searchKey = null;
        $campaigns = Campaign::latest();
        if ($request->search != null) {
            $campaigns = $campaigns->where('title', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $campaigns = $campaigns->paginate(paginationNumber());
        return view('backend.pages.campaigns.index', compact('campaigns', 'searchKey'));
    }

    # return view of create form
    public function create()
    {
        $products = Product::where('is_published', 1)->get();
        return view('backend.pages.campaigns.create', compact('products'));
    }


    # campaign store
    public function store(Request $request)
    {
        $campaign = new Campaign;
        $campaign->title = $request->title;
        $campaign->banner = $request->banner;

        if (Str::contains($request->date_range, 'to')) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y"), date("d-m-Y")];
        }

        $campaign->start_date = strtotime($date_var[0]);
        $campaign->end_date   = strtotime($date_var[1]);

        $campaign->slug = strtolower(Str::slug($request->title) . '-' . Str::random(5));

        if ($campaign->save()) {
            if ($request->product_ids) {

                foreach ($request->product_ids as $key => $product) {
                    $campaign_product = new CampaignProduct;
                    $campaign_product->campaign_id = $campaign->id;
                    $campaign_product->product_id = $product;
                    $campaign_product->save();

                    $root_product = Product::findOrFail($product);
                    $root_product->discount_value = $request['discount_' . $product];
                    $root_product->discount_type = $request['discount_type_' . $product];
                    $root_product->discount_start_date = strtotime($date_var[0]);
                    $root_product->discount_end_date   = strtotime($date_var[1]);
                    $root_product->save();
                }
            }

            flash(localize('Campaign has been saved successfully'))->success();
            return redirect()->route('admin.campaigns.index');
        } else {
            flash(localize('Something went wrong'))->error();
            return back();
        }
    }

    # edit campaign
    public function edit(Request $request, $id)
    {
        $products = Product::where('is_published', 1)->get();
        $campaign = Campaign::findOrFail($id);
        return view('backend.pages.campaigns.edit', compact('campaign', 'products'));
    }

    # update campaign
    public function update(Request $request)
    {
        $campaign = Campaign::findOrFail($request->id);

        if (Str::contains($request->date_range, 'to')) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y"), date("d-m-Y")];
        }

        $campaign->start_date = strtotime($date_var[0]);
        $campaign->end_date   = strtotime($date_var[1]);
        $campaign->title = $request->title;
        $campaign->banner = $request->banner;

        $campaign->campaignProducts()->delete();

        if ($campaign->save()) {
            if ($request->product_ids) {
                foreach ($request->product_ids as $key => $product) {
                    $campaign_product = new CampaignProduct;
                    $campaign_product->campaign_id = $campaign->id;
                    $campaign_product->product_id = $product;
                    $campaign_product->save();

                    $root_product = Product::findOrFail($product);
                    $root_product->discount_value = $request['discount_' . $product];
                    $root_product->discount_type = $request['discount_type_' . $product];
                    $root_product->discount_start_date = strtotime($date_var[0]);
                    $root_product->discount_end_date   = strtotime($date_var[1]);
                    $root_product->save();
                }
            }
            flash(localize('Campaign has been updated successfully'))->success();
            return redirect()->route('admin.campaigns.index');
        } else {
            flash(localize('Something went wrong'))->error();
            return back();
        }
    }

    # update published  
    public function updatePublishedStatus(Request $request)
    {
        $product = Campaign::findOrFail($request->id);
        $product->is_published = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    # discount
    public function productDiscount(Request $request)
    {
        $product_ids = $request->product_ids;
        return view('backend.pages.campaigns.campaign_discount', compact('product_ids'));
    }

    # discount update
    public function productDiscountEdit(Request $request)
    {
        $product_ids = $request->product_ids;
        $campaign_id = $request->campaign_id;
        return view('backend.pages.campaigns.campaign_discount_edit', compact('product_ids', 'campaign_id'));
    }

    # delete campaign
    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->campaignProducts()->delete();

        $campaign->delete();
        flash(localize('Campaign has been deleted successfully'))->success();
        return back();
    }
}
