<?php

namespace App\Http\Controllers\Backend\Products;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialDetail;

class MaterialDetailController extends Controller
{
    public function index()
    {
        $materialDetails = MaterialDetail::all();
        return view('backend.pages.products.material_details.index', compact('materialDetails'));
    }

    public function create()
    {
        return view('backend.pages.products.material_details.create');
    }

    public function store(Request $request)
    {
        // Validazione dei dati di input

        $materialDetail = MaterialDetail::create($request->all());

        // Altre operazioni se necessario

        return redirect()->route('admin.materialDetails.index')->with('message', 'Dettaglio materiale creato con successo');
    }

    public function edit(MaterialDetail $materialDetail)
    {
        return view('backend.pages.products.material_details.edit', compact('materialDetail'));
    }

    public function update(Request $request, MaterialDetail $materialDetail)
    {
        // Validazione dei dati di input

        $materialDetail->update($request->all());

        // Altre operazioni se necessario

        return redirect()->route('admin.materialDetails.index')->with('message', 'Dettaglio materiale modificato con successo');
    }

    public function updateStatus(Request $request)
    {
        // Aggiornamento dello stato del dettaglio materiale

        return response()->json(['status' => 'success']);
    }

    public function delete(MaterialDetail $materialDetail)
    {
        // Eliminazione del dettaglio materiale

        $materialDetail->delete();

        return redirect()->route('admin.materialDetails.index')->with('message', 'Dettaglio materiale eliminato con successo');
    }
}

