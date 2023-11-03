<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Thickness;

class MaterialController extends Controller
{
    // crud materiali

    public function index()
    {
        $materials = Material::all();
        return view('backend.pages.products.materials.index', compact('materials'));
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
            'thicknesses' => 'required|array',
            'thicknesses.*' => 'exists:thicknesses,id'
        ]);

        $material = Material::create($request->all());
        $material->thicknesses()->attach($request->thicknesses);

        return redirect()->route('admin.materials.index')->with('message', 'Materiale creato con successo');
    }

    public function edit(Material $material)
    {
        $thicknesses = Thickness::all();
        return view('backend.pages.products.materials.edit', compact('material', 'thicknesses'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'price_type' => 'required|in:mq,linear,fixed',
            'thicknesses' => 'required|array',
            'thicknesses.*' => 'exists:thicknesses,id'
        ]);

        $material->update($request->all());
        $material->thicknesses()->sync($request->thicknesses);

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
