<?php

namespace App\Http\Controllers\Backend\Stocks;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Location;
use Illuminate\Http\Request;
use Auth;

class LocationsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:show_locations'])->only('index');
        $this->middleware(['permission:add_location'])->only(['create', 'store']);
        $this->middleware(['permission:edit_location'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_locations'])->only(['updatePublishedStatus', 'updateDefaultStatus']);
    }

    # location index
    public function index(Request $request)
    {
        $searchKey = null;
        $is_published = null;

        $locations = Location::latest();
        if ($request->search != null) {
            $locations = $locations->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_published != null) {
            $locations = $locations->where('is_published', $request->is_published);
            $is_published    = $request->is_published;
        }

        $locations = $locations->paginate(paginationNumber());
        return view('backend.pages.stocks.locations.index', compact('locations', 'searchKey', 'is_published'));
    }

    # change the currency
    public function changeLocation(Request $request)
    {
        $request->session()->put('stock_location_id', $request->location_id);
        return true;
    }

    # add location
    public function create()
    {
        return view('backend.pages.stocks.locations.create');
    }

    # add location
    public function store(Request $request)
    {
        $location = new Location;
        $location->name = $request->name;
        $location->address = $request->address;
        $location->banner = $request->image;
        if (Location::count() == 0) {
            $location->is_default = 1;
        }
        $location->save();
        flash(localize('Location has been added successfully'))->success();
        return redirect()->route('admin.locations.index');
    }


    # edit location
    public function edit($id)
    {
        $location = Location::find((int)$id);
        return view('backend.pages.stocks.locations.edit', compact('location'));
    }

    # update location
    public function update(Request $request)
    {
        $location = Location::where('id', $request->id)->first();
        $location->name = $request->name;
        $location->address = $request->address;
        $location->banner = $request->image;
        $location->save();
        flash(localize('Location has been updated successfully'))->success();
        return redirect()->route('admin.locations.index');
    }

    # update published
    public function updatePublishedStatus(Request $request)
    {
        $location = Location::findOrFail($request->id);
        if ($location->is_default == 1) {
            return 3;
        }
        $location->is_published = $request->status;
        if ($location->save()) {
            return 1;
        }
        return 0;
    }

    # update default
    public function updateDefaultStatus(Request $request)
    {
        $location = Location::findOrFail($request->id);
        $default = Location::where('is_default', 1)->first();
        if (!is_null($default)) {
            $default->is_default = 0;
            $default->save();
        }
        $location->is_default = $request->status;
        if ($location->save()) {
            return 1;
        }
        return 0;
    }
}
