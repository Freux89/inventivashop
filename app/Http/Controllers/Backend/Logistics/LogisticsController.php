<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Logistic;
use App\Models\LogisticZone;
use App\Models\LogisticZoneCity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogisticsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:logistics'])->only('index');
        $this->middleware(['permission:add_logistics'])->only(['store']);
        $this->middleware(['permission:edit_logistics'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_logistics'])->only(['updateStatus']);
        $this->middleware(['permission:delete_logistics'])->only(['delete']);
    }

    # Logistic list
    public function index(Request $request)
    {
        $searchKey = null;
        $logistics = Logistic::oldest();
        if ($request->search != null) {
            $logistics = $logistics->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $logistics = $logistics->paginate(paginationNumber());
        return view('backend.pages.fulfillments.logistics.index', compact('logistics', 'searchKey'));
    }

    # Logistic store
    public function store(Request $request)
    {
        $logistic = new Logistic;
        $logistic->name = $request->name;
        $logistic->thumbnail_image = $request->image;

        if ($request->slug != null) {
            $logistic->slug = Str::slug($request->slug);
        } else {
            $logistic->slug = Str::slug($request->name) . '-' . Str::random(5);
        }

        $logistic->save();
        flash(localize('Logistic has been inserted successfully'))->success();
        return redirect()->route('admin.logistics.index');
    }

    # edit Logistic
    public function edit(Request $request, $id)
    {
        $logistic = Logistic::findOrFail($id);
        return view('backend.pages.fulfillments.logistics.edit', compact('logistic'));
    }

    # update Logistic
    public function update(Request $request)
    {
        $logistic = Logistic::findOrFail($request->id);
        $logistic->name = $request->name;
        $logistic->thumbnail_image = $request->image;

        if ($request->slug != null) {
            $logistic->slug = Str::slug($request->name);
        } else {
            $logistic->slug = Str::slug($request->name) . '-' . Str::random(5);
        }

        $logistic->save();
        flash(localize('Logistic has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $blog = Logistic::findOrFail($request->id);
        $blog->is_published = $request->is_published;
        if ($blog->save()) {
            return 1;
        }
        return 0;
    }

    # delete Logistic
    public function delete($id)
    {
        $logistic = Logistic::findOrFail($id);
        LogisticZone::where('logistic_id', $logistic->id)->delete();
        LogisticZoneCity::where('logistic_id', $logistic->id)->delete();
        $logistic->delete();
        flash(localize('Logistic has been deleted successfully'))->success();
        return back();
    }
}
