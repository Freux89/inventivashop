<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = $request->input('search');
        $alerts = Alert::when($searchKey, function($query, $searchKey) {
            return $query->where('title', 'like', "%$searchKey%");
        })->get();
    
        $categories = Category::all();
        $products = Product::all();
    
        return view('backend.pages.alerts.index', compact('alerts', 'categories', 'products', 'searchKey'));
    }

    public function create()
{
    $categories = Category::all();
    $products = Product::all();
    return view('backend.pages.alerts.create', compact('categories', 'products'));
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'text' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'display_location' => 'required|string',
    ]);

    $alert = new Alert();
    $alert->title = $request->title;
    $alert->text = $request->text;
    $alert->background_color = $request->background_color;
    $alert->text_color = $request->text_color;
    $alert->start_date = $request->start_date;
    $alert->end_date = $request->end_date;
    $alert->display_location = $request->display_location;

    // Se sono state selezionate categorie specifiche
    if ($request->display_location === 'specific_categories') {
        $alert->category_ids = implode(',', $request->categories);
        $alert->include_products = $request->has('include_products') ? true : false;
    } else {
        $alert->category_ids = null;
        $alert->include_products = false;
    }

    // Se sono stati selezionati prodotti specifici
    if ($request->display_location === 'specific_products') {
        $alert->product_ids = implode(',', $request->products);
    } else {
        $alert->product_ids = null;
    }

    $alert->is_active = true; // Può essere aggiornato anche separatamente se necessario
    $alert->save();

    return redirect()->route('admin.alerts.index')->with('success', 'Avviso creato con successo.');
}


    public function show(Alert $alert)
    {
        return view('alerts.show', compact('alert'));
    }

   // Metodo edit
public function edit($id)
{
    $alert = Alert::findOrFail($id);
    $categories = Category::all();
    $products = Product::all();

    return view('backend.pages.alerts.edit', compact('alert', 'categories', 'products'));
}

// Metodo update
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string',
        'text' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'display_location' => 'required|string',
    ]);

    $alert = Alert::findOrFail($id);
    $alert->title = $request->title;
    $alert->text = $request->text;
    $alert->background_color = $request->background_color;
    $alert->text_color = $request->text_color;
    $alert->start_date = $request->start_date;
    $alert->end_date = $request->end_date;
    $alert->display_location = $request->display_location;

    // Se sono state selezionate categorie specifiche
    if ($request->display_location === 'specific_categories') {
        $alert->category_ids = implode(',', $request->categories);

        $alert->include_products = $request->has('include_products') ? true : false;
    } else {
        $alert->category_ids = null;
        $alert->include_products = false;
    }

    // Se sono stati selezionati prodotti specifici
    if ($request->display_location === 'specific_products') {
        $alert->product_ids = implode(',', $request->products);

    } else {
        $alert->product_ids = null;
    }

    $alert->save();

    return redirect()->route('admin.alerts.index')->with('success', 'Avviso aggiornato con successo.');
}


    public function updateStatus(Request $request)
    {
        $alert = Alert::findOrFail($request->id);
        $alert->is_active = $request->is_active;
        if ($alert->save()) {
            return 1;
        }
        return 0;
    }

    public function delete($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();

        return redirect()->route('admin.alerts.index')->with('success', 'Avviso eliminato con successo.');
    }
}
