<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuColumn;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\Category;

class MenuColumnController extends Controller
{
    /**
     * Mostra la pagina per creare una nuova colonna associata a un menu item.
     */
    public function create($menu_item_id)
    {
        // Recupera il menu item associato
        $menuItem = MenuItem::findOrFail($menu_item_id);

        // Recupera tutti i prodotti e le categorie disponibili
        $products = Product::all();
        $categories = Category::all();

        // Ritorna la vista 'create' con i dati necessari
        return view('backend.pages.menus.items.columns.create', compact('menuItem', 'products', 'categories'));
    }

    /**
     * Salva una nuova colonna nel database.
     */
    public function store(Request $request)
{
    // Validazione dei dati
    $request->validate([
        'menu_item_id' => 'required|exists:menu_items,id',
        'title' => 'required|string|max:255',
        'column_width' => 'required|integer|min:1|max:12',
        'padding_left' => 'nullable|integer|min:0|max:9',
        'padding_right' => 'nullable|integer|min:0|max:9'
    ]);

    // Creazione della nuova colonna
    $menuColumn = new MenuColumn();
    $menuColumn->menu_item_id = $request->menu_item_id;
    $menuColumn->title = $request->title;
    $menuColumn->column_width = $request->column_width;
    $menuColumn->padding_left = $request->padding_left;
    $menuColumn->padding_right = $request->padding_right;
    $menuColumn->border_left = $request->border_left ? true : false;
    $menuColumn->border_right = $request->border_right ? true : false;
    $menuColumn->save();

    return redirect()->route('admin.menu-items.edit', $request->menu_item_id)
        ->with('success', localize('Colonna aggiunta con successo!'));
}

    /**
     * Mostra la pagina per modificare una colonna esistente.
     */
    public function edit($id)
    {
        // Recupera la colonna da modificare
        $menuColumn = MenuColumn::findOrFail($id);

        // Recupera tutti i prodotti e le categorie disponibili
        $products = Product::all();
        $categories = Category::all();

        // Recupera tutti gli items associati alla colonna
        $menuColumnItems = $menuColumn->items; // Supponendo che esista una relazione items nel model MenuColumn

        // Ritorna la vista 'edit' con i dati necessari
        return view('backend.pages.menus.items.columns.edit', compact('menuColumn', 'products', 'categories', 'menuColumnItems'));
    }


    /**
     * Aggiorna una colonna esistente nel database.
     */
    public function update(Request $request, $id)
{
    // Validazione dei dati
    $request->validate([
        'menu_item_id' => 'required|exists:menu_items,id',
        'title' => 'required|string|max:255',
        'column_width' => 'required|integer|min:1|max:12',
        'padding_left' => 'nullable|integer|min:0|max:9',
        'padding_right' => 'nullable|integer|min:0|max:9',
    ]);

    // Trova la colonna esistente
    $menuColumn = MenuColumn::findOrFail($id);

    // Aggiorna i campi con i nuovi dati
    $menuColumn->menu_item_id = $request->menu_item_id;
    $menuColumn->title = $request->title;
    $menuColumn->column_width = $request->column_width;
    $menuColumn->padding_left = $request->padding_left;
    $menuColumn->padding_right = $request->padding_right;
    $menuColumn->border_left = $request->border_left ? true : false;
    $menuColumn->border_right = $request->border_right ? true : false;
    $menuColumn->save();

    return redirect()->route('admin.menu-items.edit', $menuColumn->menu_item_id)
        ->with('success', localize('Colonna aggiornata con successo!'));
}


    public function updatePositions(Request $request)
    {
        $positions = $request->input('positions');

        foreach ($positions as $index => $id) {
            MenuColumn::where('id', $id)->update(['position' => $index + 1]); // Aggiorna la posizione in base all'indice
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Elimina una colonna esistente dal database.
     */
    public function destroy($id)
    {
        $menuColumn = MenuColumn::findOrFail($id);
        $menuItemId = $menuColumn->menu_item_id; // Salva l'ID del menu item associato prima di eliminare
        $menuColumn->delete();

        return redirect()->route('admin.menu-items.edit', $menuItemId)->with('success', localize('Colonna eliminata con successo!'));
    }

    public function duplicate($id)
    {
        // Trova la colonna da duplicare
        $menuColumn = MenuColumn::findOrFail($id);

        // Crea una nuova colonna duplicata basata sull'originale
        $newMenuColumn = $menuColumn->replicate(); // Duplica tutti i campi dell'oggetto originale
        $newMenuColumn->title .= ' (Copia)'; // Aggiungi "(Copia)" al titolo per distinguere la colonna duplicata

        // Salva la nuova colonna duplicata
        $newMenuColumn->save();

        // Duplica anche gli items collegati alla colonna originale
        foreach ($menuColumn->items as $item) {
            $newItem = $item->replicate(); // Duplica ogni item della colonna
            $newItem->menu_column_id = $newMenuColumn->id; // Assegna l'item duplicato alla nuova colonna
            $newItem->save();
        }

        // Reindirizza alla pagina di modifica del menu item con un messaggio di successo
        return redirect()->route('admin.menu-items.edit', $menuColumn->menu_item_id)
            ->with('success', localize('Colonna duplicata con successo!'));
    }
}
