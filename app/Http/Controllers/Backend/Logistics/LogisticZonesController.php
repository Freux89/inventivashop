<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Logistic;
use App\Models\LogisticZone;
use App\Models\LogisticZoneCity;
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
    public function getLogisticCities(Request $request)
    {
        $logistic = Logistic::find($request->logistic_id);
        $html = '<option value="">' . localize("Select City") . '</option>';

        if (!is_null($logistic)) {
            $logisticCities = $logistic->cities()->pluck('city_id');
            $cities =    City::isActive()->whereNotIn('id', $logisticCities)->latest()->get();

            foreach ($cities as $city) {
                $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
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

        foreach ($request->city_ids as $city_id) {
            LogisticZoneCity::where('logistic_id', $logisticZone->logistic_id)
                ->where('city_id', $city_id)
                ->delete();
            $logisticZoneCity                   = new LogisticZoneCity;
            $logisticZoneCity->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneCity->logistic_zone_id = $logisticZone->id;
            $logisticZoneCity->city_id          = $city_id;
            $logisticZoneCity->save();
        }

        flash(localize('Zone has been inserted successfully'))->success();
        return redirect()->route('admin.logisticZones.index');
    }

    # edit zone
    public function edit(Request $request, $id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        $cities       = City::isActive()->latest()->get();
        return view('backend.pages.fulfillments.logisticZones.edit', compact('logisticZone', 'cities'));
    }

    # update zone
    public function update(Request $request)
    {
        $logisticZone = LogisticZone::findOrFail($request->id);
        $logisticZone->name = $request->name;

        $logisticZone->standard_delivery_charge = $request->standard_delivery_charge;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_charge = $request->express_delivery_charge;
        }

        $logisticZone->standard_delivery_time = $request->standard_delivery_time;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_time = $request->express_delivery_time;
        }

        $logisticZone->save();


        foreach ($request->city_ids as $city_id) {
            LogisticZoneCity::where('logistic_id', $logisticZone->logistic_id)
                ->where('city_id', $city_id)
                ->delete();
            $logisticZoneCity                   = new LogisticZoneCity;
            $logisticZoneCity->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneCity->logistic_zone_id = $logisticZone->id;
            $logisticZoneCity->city_id          = $city_id;
            $logisticZoneCity->save();
        }

        flash(localize('Zone has been updated successfully'))->success();
        return back();
    }

    # delete zone
    public function delete($id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        LogisticZoneCity::where('logistic_zone_id', $logisticZone->id)->delete();
        $logisticZone->delete();
        flash(localize('Zone has been deleted successfully'))->success();
        return back();
    }
}
