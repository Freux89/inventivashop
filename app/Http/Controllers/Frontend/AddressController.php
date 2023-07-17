<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    # get states based on country
    public function getStates(Request $request)
    {
        $states = State::isActive()->where('country_id', $request->country_id)->get();
        $html = '<option value="">' . localize("Select State") . '</option>';

        foreach ($states as $state) {
            $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }

        echo json_encode($html);
    }

    # get cities based on state
    public function getCities(Request $request)
    {
        $cities = City::isActive()->where('state_id', $request->state_id)->get();
        $html = '<option value="">' . localize("Select City") . '</option>';

        foreach ($cities as $city) {
            $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
        echo json_encode($html);
    }

    # store new address
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $address                = new UserAddress;
        $address->user_id       = $userId;
        $address->country_id    = $request->country_id;
        $address->state_id      = $request->state_id;
        $address->city_id       = $request->city_id;

        if ($request->is_default == 1) {
            $prevDefault = UserAddress::where('user_id', $userId)->where('is_default', 1)->first();
            if (!is_null($prevDefault)) {
                $prevDefault->is_default = 0;
                $prevDefault->save();
            }
        }
        $address->is_default    = $request->is_default;
        $address->address       = $request->address;
        $address->save();
        flash(localize('Address has been inserted successfully'))->success();
        return back();
    }

    # edit address
    public function edit(Request $request)
    {
        $address  = UserAddress::where('user_id', auth()->user()->id)->where('id', $request->addressId)->first();
        if ($address) {
            $countries      = Country::isActive()->get();
            $states         = State::isActive()->where('country_id', $address->country_id)->get();
            $cities         = City::isActive()->where('state_id', $address->state_id)->get();
            return getViewRender('inc.addressEditForm', [
                'address' => $address,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities
            ]);
        }
    }

    # update address
    public function update(Request $request)
    {
        $userId   = auth()->user()->id;
        $address  = UserAddress::where('user_id', $userId)->where('id', $request->id)->first();

        $address->country_id    = $request->country_id;
        $address->state_id      = $request->state_id;
        $address->city_id       = $request->city_id;
        if ($request->is_default == 1) {
            $prevDefault = UserAddress::where('user_id', $userId)->where('is_default', 1)->first();
            if (!is_null($prevDefault)) {
                $prevDefault->is_default = 0;
                $prevDefault->save();
            }
        }
        $address->is_default    = $request->is_default;
        $address->address       = $request->address;
        $address->save();
        flash(localize('Address has been inserted successfully'))->success();
        return back();
    }

    # delete address
    public function delete($id)
    {
        $user = auth()->user();
        UserAddress::where('user_id', $user->id)->where('id', $id)->delete();

        flash(localize('Address has been deleted successfully'))->success();
        return back();
    }
}
