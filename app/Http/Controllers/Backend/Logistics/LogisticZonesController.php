<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Logistic;
use App\Models\LogisticZone;
use App\Models\logisticZoneCountry;
use Illuminate\Http\Request;

class LogisticZonesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:shipping_zones'])->only('index');
        $this->middleware(['permission:add_shipping_zones'])->only(['create', 'store']);
        $this->middleware(['permission:edit_shipping_zones'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_shipping_zones'])->only(['delete']);
    }

    # zone list
    public function index(Request $request)
    {
        $searchKey = null;
        $searchLogistic = null;
        $logisticZones = LogisticZone::latest();
        if ($request->search != null) {
            $logisticZones = $logisticZones->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->searchLogistic) {
            $logisticZones->where('logistic_id', $request->searchLogistic);
            $searchLogistic = $request->searchLogistic;
        }
        $logisticZones = $logisticZones->paginate(paginationNumber());
        return view('backend.pages.fulfillments.logisticZones.index', compact('logisticZones', 'searchKey', 'searchLogistic'));
    }

    # create zone
    public function create()
    {
        $logistics = Logistic::where('is_published', 1)->latest()->get();
        return view('backend.pages.fulfillments.logisticZones.create', compact('logistics'));
    }


    # create zone
    public function getLogisticCountries(Request $request)
    {
        $logistic = Logistic::find($request->logistic_id);
        $html = '<option value="">' . localize("Select Country") . '</option>';

        if (!is_null($logistic)) {
            $logisticCountries= $logistic->countries()->pluck('country_id');
            
            $countries =    Country::isActive()->whereNotIn('id', $logisticCountries)->latest()->get();

            foreach ($countries as $country) {
                $html .= '<option value="' . $country->id . '">' . $country->name . '</option>';
            }
        }

        echo json_encode($html);
    }

    # zone store
    public function store(Request $request)
    {
        $logisticZone = new LogisticZone;
        $logisticZone->name = $request->name;
        $logisticZone->logistic_id = $request->logistic_id;
        $logisticZone->standard_delivery_charge = $request->standard_delivery_charge;
        $logisticZone->standard_delivery_time = $request->standard_delivery_time;
        $logisticZone->save();

        foreach ($request->country_ids as $country_id) {
            LogisticZoneCountry::where('logistic_id', $logisticZone->logistic_id)
                ->where('country_id', $country_id)
                ->delete();
            $logisticZoneCountry                 = new LogisticZoneCountry;
            $logisticZoneCountry->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneCountry->logistic_zone_id = $logisticZone->id;
            $logisticZoneCountry->country_id          = $country_id;
            $logisticZoneCountry->save();
        }

        flash(localize('Zone has been inserted successfully'))->success();
        return redirect()->route('admin.logisticZones.index');
    }

    # edit zone
    public function edit(Request $request, $id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        
        $countries      = Country::isActive()->latest()->get();
        
        return view('backend.pages.fulfillments.logisticZones.edit', compact('logisticZone', 'countries'));
    }

    # update zone
    public function update(Request $request)
    {
        $logisticZone = LogisticZone::findOrFail($request->id);
        $logisticZone->name = $request->name;

        $logisticZone->standard_delivery_charge = $request->standard_delivery_charge;
        $logisticZone->packing_cost = $request->packing_cost;
        $logisticZone->insured_shipping_cost = $request->insured_shipping_cost;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_charge = $request->express_delivery_charge;
        }

        $logisticZone->standard_delivery_time = $request->standard_delivery_time;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_time = $request->express_delivery_time;
        }

        $logisticZone->save();

        LogisticZoneCountry::where('logistic_zone_id', $logisticZone->id)->delete();

        foreach ($request->country_ids as $country_id) {
           
            $logisticZoneCountry                  = new logisticZoneCountry;
            $logisticZoneCountry->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneCountry->logistic_zone_id = $logisticZone->id;
            $logisticZoneCountry->country_id          = $country_id;
            $logisticZoneCountry->save();
        }

        flash(localize('Zone has been updated successfully'))->success();
        return back();
    }

    # delete zone
    public function delete($id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        LogisticZoneCountry::where('logistic_zone_id', $logisticZone->id)->delete();
        $logisticZone->delete();
        flash(localize('Zone has been deleted successfully'))->success();
        return back();
    }
}
