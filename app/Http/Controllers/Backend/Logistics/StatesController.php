<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:shipping_states'])->only('index');
        $this->middleware(['permission:add_shipping_states'])->only('create');
        $this->middleware(['permission:edit_shipping_states'])->only('edit');
    }

    # state list
    public function index(Request $request)
    {
        $searchKey = null;
        $searchCountry = null;
        $states = State::query();

        if ($request->search != null) {
            $states = $states->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->searchCountry) {
            $states->where('country_id', $request->searchCountry);
            $searchCountry = $request->searchCountry;
        }

        $states = $states->orderBy('is_active', 'desc')->paginate(paginationNumber());
        return view('backend.pages.fulfillments.states.index', compact('states', 'searchKey', 'searchCountry'));
    }

    # return view of create form
    public function create()
    {
        $countries = Country::where('is_active', 1)->get();
        return view('backend.pages.fulfillments.states.create', compact('countries'));
    }

    # store new state
    public function store(Request $request)
    {
        $state = new State;
        $state->name        = $request->name;
        $state->country_id  = $request->country_id;
        $state->is_active  = 1;
        $state->save();
        flash(localize('State has been inserted successfully'))->success();
        return redirect()->route('admin.states.index');
    }

    # return view of create form
    public function edit($id)
    {
        $countries = Country::where('is_active', 1)->get();
        $state = State::findOrFail($id);
        return view('backend.pages.fulfillments.states.edit', compact('countries', 'state'));
    }

    # update State  
    public function update(Request $request)
    {
        $state = State::findOrFail((int) $request->id);
        $state->name        = $request->name;
        $state->country_id  = $request->country_id;
        $state->save();
        flash(localize('State has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $state = State::findOrFail($request->id);
        $state->is_active = $request->is_active;
        $state->save();

        foreach ($state->cities as $city) {
            $city->is_active = $state->is_active;
            $city->save();
        }

        flash(localize('Status updated successfully'))->success();
        return 1;
    }
}
