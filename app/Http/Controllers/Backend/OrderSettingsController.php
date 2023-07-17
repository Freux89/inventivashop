<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ScheduledDeliveryTimeList;
use Illuminate\Http\Request;

class OrderSettingsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:order_settings'])->only(['index', 'store', 'edit', 'update', 'delete']);
    }

    # order settings view
    public function index()
    {
        $slots = ScheduledDeliveryTimeList::orderBy('sorting_order', 'ASC')->get();
        return view('backend.pages.systemSettings.orderSettings', compact('slots'));
    }

    # store time slot
    public function store(Request $request)
    {
        $timeSlot = new ScheduledDeliveryTimeList;
        $timeSlot->timeline         = $request->timeline;
        $timeSlot->sorting_order    = $request->sorting_order;
        $timeSlot->save();
        flash(localize('Slot has been saved successfully'))->success();
        return back();
    }

    # edit form
    public function edit($id)
    {
        $slot = ScheduledDeliveryTimeList::find($id);
        return view('backend.pages.systemSettings.orderSettingsTimeslotEdit', compact('slot'));
    }

    # update timeslot
    public function update(Request $request)
    {
        $timeSlot = ScheduledDeliveryTimeList::where('id', $request->id)->first();
        $timeSlot->timeline         = $request->timeline;
        $timeSlot->sorting_order    = $request->sorting_order;
        $timeSlot->save();

        flash(localize('Slot has been updated successfully'))->success();
        return redirect()->route('admin.orderSettings');
    }

    # delete timeslot
    public function delete($id)
    {
        ScheduledDeliveryTimeList::where('id', $id)->delete();
        flash(localize('Slot has been deleted successfully'))->success();
        return back();
    }
}
