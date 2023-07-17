<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use App\Models\Unit;
use App\Models\UnitLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:units'])->only('index');
        $this->middleware(['permission:add_units'])->only(['store']);
        $this->middleware(['permission:edit_units'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_units'])->only(['updateStatus']);
        $this->middleware(['permission:delete_units'])->only(['delete']);
    }

    # unit list
    public function index(Request $request)
    {
        $searchKey = null;
        $is_published = null;

        $units = Unit::oldest();
        if ($request->search != null) {
            $units = $units->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_published != null) {
            $units = $units->where('is_active', $request->is_published);
            $is_published    = $request->is_published;
        }


        $units = $units->paginate(paginationNumber());
        return view('backend.pages.products.units.index', compact('units', 'searchKey', 'is_published'));
    }

    # unit store
    public function store(Request $request)
    {
        $unit = new Unit;
        $unit->name = $request->name;

        if ($request->slug != null) {
            $unit->slug = str_replace(' ', '-', $request->slug);
        } else {
            $unit->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $unit->save();

        $unitLocalization = UnitLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'unit_id' => $unit->id]);
        $unitLocalization->name = $unit->name;

        $unitLocalization->save();

        flash(localize('Unit has been inserted successfully'))->success();
        return redirect()->route('admin.units.index');
    }

    # edit unit
    public function edit(Request $request, $id)
    {
        $lang_key = $request->lang_key;
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.units.index');
        }
        $unit = Unit::findOrFail($id);
        return view('backend.pages.products.units.edit', compact('unit', 'lang_key'));
    }

    # update unit
    public function update(Request $request)
    {
        $unit = Unit::findOrFail($request->id);

        if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
            $unit->name = $request->name;
            $unit->slug = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));
        }

        $unitLocalization = UnitLocalization::firstOrNew(['lang_key' => $request->lang_key, 'unit_id' => $unit->id]);
        $unitLocalization->name = $request->name;

        $unit->save();
        $unitLocalization->save();

        flash(localize('Unit has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $unit->is_active = $request->is_active;
        if ($unit->save()) {
            return 1;
        }
        return 0;
    }

    # delete unit
    public function delete($id)
    {
        $unit = Unit::findOrFail($id);
        try {
            Product::where('unit_id', $id)->update([
                'unit_id' => NULL
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $unit->delete();
        flash(localize('Unit has been deleted successfully'))->success();
        return back();
    }
}
