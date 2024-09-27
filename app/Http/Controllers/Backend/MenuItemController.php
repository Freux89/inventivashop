<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;

class MenuItemController extends Controller
{
    public function index(Menu $menu)
    {
        return view('backend.pages.menus.items.index', compact('menu'));
    }

    public function create($menu_id)
    {
        // Recupera il menu specificato
        $menu = Menu::findOrFail($menu_id);

        // Recupera tutti i prodotti e le categorie disponibili
        $products = Product::all();
        $categories = Category::all();

        // Ritorna la vista 'create' con i dati necessari
        return view('backend.pages.menus.items.create', compact('menu_id', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        // Validazione dei dati
        $request->validate([
            'title' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id',
            'link_type' => 'nullable|in:url,product,category', // Il tipo di collegamento è opzionale
            'link_url' => 'nullable|required_if:link_type,url|string',
            'link_product_id' => 'nullable|required_if:link_type,product|exists:products,id',
            'link_category_id' => 'nullable|required_if:link_type,category|exists:categories,id',
            'menu_type' => 'nullable|in:dropdown,columns', // Il tipo di menu è opzionale
        ]);
    
        // Creazione del nuovo menu item
        $menuItem = new MenuItem();
        $menuItem->menu_id = $request->menu_id;
        $menuItem->title = $request->title;
    
        // Gestione del tipo di collegamento
        if ($request->link_type === 'url') {
            $menuItem->url = $request->link_url;
        } elseif ($request->link_type === 'product') {
            $menuItem->product_id = $request->link_product_id;
        } elseif ($request->link_type === 'category') {
            $menuItem->category_id = $request->link_category_id;
        }
    
        // Assegnazione posizione
        $lastPosition = MenuItem::where('menu_id', $request->menu_id)->max('position');
        $menuItem->position = $lastPosition + 1;
    
        $menuItem->save();
    
        return redirect()->route('admin.menus.edit', $request->menu_id)->with('success', localize('Item del menu aggiunto con successo!'));
    }
    



public function edit($id)
{
    // Recupera il menu item da modificare
    $menuItem = MenuItem::findOrFail($id);

    // Recupera tutti i prodotti e le categorie disponibili
    $products = Product::all();
    $categories = Category::all();

    // Recupera tutte le colonne associate al menu item
    $menuColumns = $menuItem->columns()->get();

    // Ritorna la vista 'edit' con i dati necessari
    return view('backend.pages.menus.items.edit', compact('menuItem', 'products', 'categories', 'menuColumns'));
}

public function update(Request $request, $id)
{
    // Validazione dei dati
    $request->validate([
        'title' => 'required|string|max:255',
        'menu_id' => 'required|exists:menus,id',
        'link_type' => 'nullable|in:url,product,category', // Il tipo di collegamento è opzionale
        'link_url' => 'nullable|required_if:link_type,url|string',
        'link_product_id' => 'nullable|required_if:link_type,product|exists:products,id',
        'link_category_id' => 'nullable|required_if:link_type,category|exists:categories,id',
        'menu_type' => 'nullable|in:dropdown,columns', // Il tipo di menu è opzionale
    ]);

    // Recupera l'item esistente
    $menuItem = MenuItem::findOrFail($id);
    $menuItem->menu_id = $request->menu_id;
    $menuItem->title = $request->title;

    // Gestione del tipo di collegamento
    $menuItem->url = null;
    $menuItem->product_id = null;
    $menuItem->category_id = null;
    
    if ($request->link_type === 'url') {
        $menuItem->url = $request->link_url;
    } elseif ($request->link_type === 'product') {
        $menuItem->product_id = $request->link_product_id;
    } elseif ($request->link_type === 'category') {
        $menuItem->category_id = $request->link_category_id;
    }

   

    $menuItem->save();

    return redirect()->route('admin.menus.edit', $request->menu_id)->with('success', localize('Item del menu aggiornato con successo!'));
}

public function updatePositions(Request $request)
{
    $positions = $request->input('positions');

    foreach ($positions as $index => $id) {
        MenuItem::where('id', $id)->update(['position' => $index + 1]); // Aggiorna la posizione in base all'indice
    }

    return response()->json(['status' => 'success']);
}

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();
        return back();
    }

    public function duplicate($id)
{
    // Trova l'item del menu da duplicare
    $menuItem = MenuItem::findOrFail($id);

    // Crea un nuovo item duplicato basato sull'originale
    $newMenuItem = $menuItem->replicate(); // Duplica tutti i campi dell'oggetto originale
    $newMenuItem->title .= ' (Copia)'; // Aggiungi "(Copia)" al titolo per distinguere l'item duplicato

    // Salva il nuovo item duplicato
    $newMenuItem->save();

    // Duplica anche le colonne collegate all'item originale
    foreach ($menuItem->columns as $column) {
        $newColumn = $column->replicate(); // Duplica ogni colonna
        $newColumn->menu_item_id = $newMenuItem->id; // Assegna la colonna duplicata al nuovo item
        $newColumn->save();

        // Duplica gli item della colonna
        foreach ($column->items as $columnItem) {
            $newColumnItem = $columnItem->replicate(); // Duplica ogni item della colonna
            $newColumnItem->menu_column_id = $newColumn->id; // Assegna l'item duplicato alla nuova colonna
            $newColumnItem->save();
        }
    }

    // Reindirizza alla pagina di modifica del menu con un messaggio di successo
    return redirect()->route('admin.menus.edit', $menuItem->menu_id)
        ->with('success', localize('Item duplicato con successo!'));
}

}