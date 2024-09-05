<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialDetail;
use App\Models\Location;
use App\Models\Language;
use App\Models\MaterialLocalization;
use App\Models\Variation;

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
        $variations = Variation::all();
        
        return view('backend.pages.products.materials.create', compact('variations'));
    }

    public function store(Request $request)
{
    // Valida i dati del form
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'purchase_price' => 'nullable|numeric|min:0',
        'processing_price' => 'nullable|numeric|min:0',
        'price_type' => 'required|in:mq,linear,fixed',
        'variation_values' => 'nullable|array',
        'variation_values.*' => 'exists:variation_values,id',
        'price_tiers' => 'nullable|array',
        'price_tiers.*.min_quantity' => 'required_with:price_tiers|numeric|min:0',
        'price_tiers.*.price' => 'required_with:price_tiers|numeric|min:0',
    ]);

    // Crea il materiale
    $material = Material::create([
        'name' => $validatedData['name'],
        'price' => $validatedData['price'],
        'purchase_price' => $validatedData['purchase_price'],
        'processing_price' => $validatedData['processing_price'],
        'price_type' => $validatedData['price_type'],
    ]);

    // Sincronizza i valori variante selezionati
    $material->variationValues()->sync($validatedData['variation_values'] ?? []);

    // Aggiungi scaglioni di prezzo
    if (!empty($validatedData['price_tiers'])) {
        foreach ($validatedData['price_tiers'] as $tier) {
            $material->priceTiers()->create($tier);
        }
    }

    return redirect()->route('admin.materials.index')->with('success', 'Materiale creato con successo.');
}


    public function edit(Request $request, $id)
    {
       
        $material = Material::findOrFail($id);
        $variations = Variation::all();
       
      
       
        return view('backend.pages.products.materials.edit', compact('material','variations'));
    }

    public function update(Request $request, Material $material)
{
    // Valida i dati del form
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'purchase_price' => 'nullable|numeric|min:0',
        'processing_price' => 'nullable|numeric|min:0',
        'price_type' => 'required|in:mq,linear,fixed',
        'variation_values' => 'nullable|array',
        'variation_values.*' => 'exists:variation_values,id',
        'price_tiers' => 'nullable|array',
        'price_tiers.*.min_quantity' => 'required_with:price_tiers|numeric|min:0',
        'price_tiers.*.price' => 'required_with:price_tiers|numeric|min:0',
    ]);

    // Aggiorna il materiale
    $material->update([
        'name' => $validatedData['name'],
        'price' => $validatedData['price'],
        'purchase_price' => $validatedData['purchase_price'],
        'processing_price' => $validatedData['processing_price'],
        'price_type' => $validatedData['price_type'],
    ]);
    
    // Sincronizza i valori variante selezionati
    $material->variationValues()->sync($validatedData['variation_values'] ?? []);

    // Gestione degli scaglioni di prezzo
    $material->priceTiers()->delete(); // Elimina gli scaglioni esistenti
    if (!empty($validatedData['price_tiers'])) {
        foreach ($validatedData['price_tiers'] as $tier) {
            $material->priceTiers()->create($tier);
        }
    }

    return back()->with('success', 'Materiale aggiornato con successo.');
}


    public function delete($id)
    {
        
        $material = Material::findOrFail($id);
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
