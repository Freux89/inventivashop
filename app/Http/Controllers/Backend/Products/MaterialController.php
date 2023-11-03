<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Thickness;
use App\Models\Location;
use App\Models\Language;
use App\Models\MaterialLocalization;

class MaterialController extends Controller
{
    // crud materiali

    public function index(Request $request)
    {

        $searchKey = null;

        $materials = Material::latest();
        
        if ($request->search != null) {
            $materials = $materials->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $materials= $materials->get();
        
        return view('backend.pages.products.materials.index', compact('materials', 'searchKey'));
    }

    public function create()
    {
        $thicknesses = Thickness::all();
        return view('backend.pages.products.materials.create', compact('thicknesses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'price_type' => 'required|in:mq,linear,fixed',
        ]);

        $material = Material::create($request->all());

        // Controlla se ci sono spessori nell'input della richiesta e se la relazione esiste
        if ($request->has('thicknesses') && is_array($request->thicknesses) && method_exists($material, 'thicknesses')) {
            // Assicurati che ogni ID di spessore fornito esista nella tabella 'thicknesses'
            $validThicknessIds = Thickness::whereIn('id', $request->thicknesses)->pluck('id')->toArray();

            // Associare solo spessori validi al materiale
            $material->thicknesses()->attach($validThicknessIds);
        }



        return redirect()->route('admin.materials.index')->with('message', 'Materiale creato con successo');
    }

    public function edit(Request $request, $id)
    {
        $location = Location::where('is_default', 1)->first();
        $request->session()->put('stock_location_id',  $location->id);

        $lang_key = $request->lang_key;
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        $material = Material::findOrFail($id);
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.products.index');
        }
        
        return view('backend.pages.products.materials.edit', compact('material', 'lang_key'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'price_type' => 'required|in:mq,linear,fixed',
        ]);
        $material = Material::findOrFail($request->id);
      
        // Aggiornare l'oggetto Material esistente con i nuovi dati
        if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
        $material->update($request->only(['name', 'price', 'price_type','thumbnail_image']));
    
        // Controlla se ci sono spessori nell'input della richiesta e se la relazione esiste
        if ($request->has('thicknesses') && is_array($request->thicknesses) && method_exists($material, 'thicknesses')) {
            // Assicurati che ogni ID di spessore fornito esista nella tabella 'thicknesses'
            $validThicknessIds = Thickness::whereIn('id', $request->thicknesses)->pluck('id')->toArray();
    
            // Sincronizzare spessori validi al materiale
            $material->thicknesses()->sync($validThicknessIds);
        } else {
            // Se non ci sono spessori forniti, rimuovere tutte le associazioni esistenti
            $material->thicknesses()->detach();
        }
    }
    
        $MaterialLocalization = MaterialLocalization::firstOrNew(['lang_key' => $request->lang_key, 'material_id' => $material->id]);
        $MaterialLocalization->name = $request->name;
        $MaterialLocalization->description = $request->description;
        $MaterialLocalization->save();

        return redirect()->route('admin.materials.index')->with('message', 'Materiale modificato con successo');
    }

    public function delete(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials.index')->with('message', 'Materiale eliminato con successo');
    }

    public function updateStatus(Request $request)
    {
        $material = Material::findOrFail($request->id);
        $material->is_active = $request->is_active;
        if ($material->save()) {
            return 1;
        }
        return 0;
    }

}
