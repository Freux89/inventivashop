<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\VariationValueLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariationValuesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:variation_values'])->only('index');
        $this->middleware(['permission:add_variation_values'])->only(['store']);
        $this->middleware(['permission:edit_variation_values'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_variation_values'])->only(['updateStatus']);
    }

    # variation value list
    public function index(Request $request, $id)
    {
        $searchKey = null;
        $variation = Variation::find($id);
        if (!$variation) {
            flash(localize('Variation not found'))->error();
            return redirect()->route('admin.variations.index');
        }
        $variationValues = VariationValue::where('variation_id', $variation->id);
        if ($request->search != null) {
            $variationValues = $variationValues->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $variationValues = $variationValues->get();
        
        return view('backend.pages.products.variationValues.index', compact('variation', 'variationValues', 'searchKey'));
    }

    # variation value store
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'variation_id' => 'required|integer',
            'color_code' => 'nullable|string',
            'image' => 'nullable|integer',  
        ]);

        $variationValue = new VariationValue;
        $variationValue->name = $data['name'];
        $variationValue->variation_id = $data['variation_id'];
        $variationValue->image = $data['image'];
        $highestPosition = VariationValue::max('position');
        $variationValue->position = $highestPosition + 1;
        // Commento perchè sembra un codice errato
        // if ($request->variation_id == 2) {
        //     $variationValue->color_code = $request->color_code;
        // }


        $variationValue->save();

        $variationValueLocalization = VariationValueLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'variation_value_id' => $variationValue->id]);

        $variationValueLocalization->name = $variationValue->name;

        $variationValueLocalization->save();

        flash(localize('Variation value has been inserted successfully'))->success();
        return redirect()->route('admin.variationValues.index', $request->variation_id);
    }

    # edit variation value
    public function edit(Request $request, $id)
    {
        $lang_key = $request->lang_key;
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.variationValues.index');
        }
        $variationValue = VariationValue::findOrFail($id);
        return view('backend.pages.products.variationValues.edit', compact('variationValue', 'lang_key'));
    }

    # update variation value
    public function update(Request $request)
    {

        $data = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'variation_id' => 'required|integer',
            'lang_key' => 'required|string',
            'color_code' => 'nullable|string',
            'image' => 'nullable|integer',  // Add this line
        ]);

        $variationValue = VariationValue::findOrFail($data['id']);

        if ($data['lang_key'] == env("DEFAULT_LANGUAGE")) {
            $variationValue->name = $data['name'];
            $variationValue->image = $data['image'];  // Add this line
        }
    
        $variationValue->variation_id = $data['variation_id'];
    
        // if ($data['variation_id'] == 2) {
        //     $variationValue->color_code = $data['color_code'];
        // }

        $variationValueLocalization = VariationValueLocalization::firstOrNew(['lang_key' => $request->lang_key, 'variation_value_id' => $variationValue->id]);
        $variationValueLocalization->name = $request->name;

        $variationValue->save();
        $variationValueLocalization->save();

        flash(localize('Variation value has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $variationValue = VariationValue::findOrFail($request->id);
        $variationValue->is_active = $request->is_active;
        if ($variationValue->save()) {
            return 1;
        }
        return 0;
    }

    # delete variation value
    public function delete($id)
    {
        $variationValue = VariationValue::findOrFail($id);
        $variationValue->delete();

        flash(localize('Variation value has been deleted successfully'))->success();
        return back();
    }


    public function updatePositions(Request $request)
    {
        
        try {
            foreach ($request->positions as $position => $id) {
                VariationValue::find($id)->update(['position' => $position]);
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
