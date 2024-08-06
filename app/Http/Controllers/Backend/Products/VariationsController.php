<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Variation;
use App\Models\VariationLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductVariation;
use App\Models\ProductVariationCombination;
use App\Models\ProductVariationStock;

class VariationsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:variations'])->only('index');
        $this->middleware(['permission:add_variations'])->only(['store']);
        $this->middleware(['permission:edit_variations'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_variations'])->only(['updateStatus']);
    }

    # variation list
    public function index(Request $request)
    {
        $searchKey = null;
        $is_published = null;

        $variations = Variation::all();        if ($request->search != null) {
            $variations = $variations->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_published != null) {
            $variations = $variations->where('is_active', $request->is_published);
            $is_published    = $request->is_published;
        }


        //  $variations = Variation::paginate(paginationNumber());
        return view('backend.pages.products.variations.index', compact('variations', 'searchKey', 'is_published'));
    }

    # variation store
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'alias' => 'nullable|string', // Aggiungi la validazione per alias
        'display_type' => 'required|string',
    ]);

    $variation = new Variation;
    $variation->name = $request->name;
    $variation->alias = $request->alias; // Aggiungi alias alla nuova variante
    $variation->display_type = $data['display_type']; 
    $highestPosition = Variation::max('position');
    $variation->position = $highestPosition + 1;

    $variation->save();

    $variationLocalization = VariationLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'variation_id' => $variation->id]);
    $variationLocalization->name = $variation->name;
    $variationLocalization->alias = $request->alias; // Aggiungi alias alla localizzazione della variante

    $variationLocalization->save();

    flash(localize('Variation has been inserted successfully'))->success();
    return redirect()->route('admin.variations.index');
}


    # edit variation
    public function edit(Request $request, $id)
    {
        $lang_key = $request->lang_key;
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.variations.index');
        }
        $variation = Variation::findOrFail($id);
        return view('backend.pages.products.variations.edit', compact('variation', 'lang_key'));
    }

    # update variation
    public function update(Request $request)
{
    $data = $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string',
        'alias' => 'nullable|string', // Aggiungi la validazione per alias
        'lang_key' => 'required|string',
        'display_type' => 'required|string',  
        'material_feature' => 'sometimes|boolean'
    ]);

    $variation = Variation::findOrFail($request->id);

    if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
        $variation->name = $request->name;
        $variation->alias = $request->alias; // Aggiungi alias alla variante principale
    }

    $variationLocalization = VariationLocalization::firstOrNew(['lang_key' => $request->lang_key, 'variation_id' => $variation->id]);
    $variationLocalization->name = $request->name;
    $variationLocalization->alias = $request->alias; // Aggiungi alias alla localizzazione della variante

    $variation->display_type = $data['display_type']; 
    $variation->material_feature = $request->has('material_feature') ? 1 : 0;
    $variation->save();
    $variationLocalization->save();

    flash(localize('Variation has been updated successfully'))->success();
    return back();
}

    # update status 
    public function updateStatus(Request $request)
    {
        $variation = Variation::findOrFail($request->id);
        $variation->is_active = $request->is_active;
        if ($variation->save()) {
            return 1;
        }
        return 0;
    }

    # delete variation
    // public function delete($id)
    // {
    //     $variation = Variation::findOrFail($id);
    //     $variation->delete();
    //     flash(localize('Variation has been deleted successfully'))->success();
    //     return back();
    // }
    public function delete($id)
{
    $variation = Variation::findOrFail($id);

    // Trova e elimina le variazioni correlate in product_variations
    $relatedProductVariations = ProductVariation::where('variation_key', 'like', $id . ':%')->orWhere('variation_key', 'like', '%:' . $id)->get();
    foreach ($relatedProductVariations as $relatedProductVariation) {
        $relatedProductVariation->delete();
    }

    // Trova e elimina le combinazioni e gli stock correlati in product_variation_combinations e product_variation_stocks
    $relatedProductVariationIds = $relatedProductVariations->pluck('id');
    ProductVariationCombination::whereIn('product_variation_id', $relatedProductVariationIds)->delete();
    ProductVariationStock::whereIn('product_variation_id', $relatedProductVariationIds)->delete();

    // Elimina la variazione
    $variation->delete();

    flash(localize('Variation has been deleted successfully'))->success();
    return back();
}

    public function updatePositions(Request $request)
    {
        
        try {
            foreach ($request->positions as $position => $id) {
                Variation::find($id)->update(['position' => $position]);
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

}
