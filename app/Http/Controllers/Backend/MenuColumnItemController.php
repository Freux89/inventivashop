<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuColumn;
use App\Models\MenuItem;
use App\Models\MenuColumnItem;
use App\Models\Product;
use App\Models\Category;

class MenuColumnItemController extends Controller
{
    /**
     * Mostra la pagina per creare una nuova colonna associata a un menu item.
     */
    public function create($menu_column_id)
    {
        // Recupera la colonna del menu associata
        $menuColumn = MenuColumn::findOrFail($menu_column_id);

        // Recupera tutti i prodotti e le categorie disponibili
        $products = Product::all();
        $categories = Category::all();

        // Ritorna la vista 'create' con i dati necessari
        return view('backend.pages.menus.items.columns.items.create', compact('menuColumn', 'products', 'categories'));
    }

    /**
     * Salva una nuova colonna nel database.
     */
    public function store(Request $request)
{
    // Validazione dei dati
    $request->validate([
        'menu_column_id' => 'required|exists:menu_columns,id',
        'title' => 'nullable|string|max:255',
        'font_size' => 'nullable|integer|min:1|max:100',
        'title_color' => 'nullable|string|max:7',
        'is_bold' => 'nullable|boolean',
        'margin_top' => 'nullable|integer|min:0|max:5',
        'margin_bottom' => 'nullable|integer|min:0|max:5',
        'link_type' => 'nullable|in:url,product,category',
        'url' => 'nullable|required_if:link_type,url|string',
        'product_id' => 'nullable|required_if:link_type,product|exists:products,id',
        'category_id' => 'nullable|required_if:link_type,category|exists:categories,id',
        'link_title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image_id' => 'nullable|integer',
    ]);

    // Creazione del nuovo item
    $menuColumnItem = new MenuColumnItem();
    $menuColumnItem->menu_column_id = $request->menu_column_id;
    $menuColumnItem->title = $request->title;
    $menuColumnItem->font_size = $request->font_size ?? 14;
    $menuColumnItem->title_color = $request->title_color;
    $menuColumnItem->is_bold = $request->is_bold ? true : false;
    $menuColumnItem->margin_top = $request->margin_top ?? 0;
    $menuColumnItem->margin_bottom = $request->margin_bottom ?? 0;
    $menuColumnItem->image_id = $request->image_id;
    $menuColumnItem->apply_link_to_image = $request->has('apply_link_to_image') ? true : false;
    $menuColumnItem->link_title = $request->link_title;
    $menuColumnItem->description = $this->cleanHtmlContent($request->description);

    // Gestione del tipo di collegamento
    if ($request->link_type === 'url') {
        $menuColumnItem->url = $request->url;
    } elseif ($request->link_type === 'product') {
        $menuColumnItem->product_id = $request->product_id;
    } elseif ($request->link_type === 'category') {
        $menuColumnItem->category_id = $request->category_id;
    }

    // Assegnazione posizione
    $lastPosition = MenuColumnItem::where('menu_column_id', $request->menu_column_id)->max('position');
    $menuColumnItem->position = $lastPosition + 1;

    $menuColumnItem->save();

    return redirect()->route('admin.menu-columns.edit', $request->menu_column_id)
        ->with('success', localize('Item aggiunto con successo!'));
}






    /**
     * Mostra la pagina per modificare una colonna esistente.
     */
    public function edit($id)
{
    // Recupera l'item di colonna da modificare
    $menuColumnItem = MenuColumnItem::findOrFail($id);

    // Recupera la colonna associata all'item
    $menuColumn = $menuColumnItem->menuColumn;

    // Recupera tutti i prodotti e le categorie disponibili
    $products = Product::all();
    $categories = Category::all();

    // Ritorna la vista 'edit' con i dati necessari
    return view('backend.pages.menus.items.columns.items.edit', compact('menuColumnItem', 'menuColumn', 'products', 'categories'));
}

    

    /**
     * Aggiorna una colonna esistente nel database.
     */
    public function update(Request $request, $id)
{
    // Validazione dei dati
    $request->validate([
        'menu_column_id' => 'required|exists:menu_columns,id',
        'title' => 'nullable|string|max:255',
        'font_size' => 'nullable|integer|min:1|max:100', // Grandezza del font opzionale
        'title_color' => 'nullable|string|max:7', // Colore del titolo in formato hex (es. #FFFFFF)
        'is_bold' => 'nullable|boolean', // Se il testo è in grassetto
        'margin_top' => 'nullable|integer|min:0|max:5', // Margine superiore, valori da 0 a 5
        'margin_bottom' => 'nullable|integer|min:0|max:5', // Margine inferiore, valori da 0 a 5
        'link_type' => 'nullable|in:url,product,category',
        'url' => 'nullable|required_if:link_type,url|string',
        'product_id' => 'nullable|required_if:link_type,product|exists:products,id',
        'category_id' => 'nullable|required_if:link_type,category|exists:categories,id',
        'link_title' => 'nullable|string|max:255', // Titolo del link opzionale
        'description' => 'nullable|string', // Descrizione opzionale che può contenere HTML
        'image_id' => 'nullable|integer', // File immagine opzionale
    ]);

    // Recupera l'item di colonna da aggiornare
    $menuColumnItem = MenuColumnItem::findOrFail($id);

    // Aggiorna i campi dell'item di colonna
    $menuColumnItem->menu_column_id = $request->menu_column_id;
    $menuColumnItem->title = $request->title;
    $menuColumnItem->font_size = $request->font_size ?? 14; // Assegna la grandezza del font con valore di default 14
    $menuColumnItem->title_color = $request->title_color; // Assegna il colore del titolo
    $menuColumnItem->is_bold = $request->is_bold ? true : false; // Assegna se il testo è in grassetto
    $menuColumnItem->margin_top = $request->margin_top ?? 0; // Assegna il margine superiore con valore di default 0
    $menuColumnItem->margin_bottom = $request->margin_bottom ?? 0; // Assegna il margine inferiore con valore di default 0
    $menuColumnItem->image_id = $request->image_id;
    $menuColumnItem->apply_link_to_image = $request->has('apply_link_to_image') ? true : false;

    $menuColumnItem->link_title = $request->link_title; // Assegna il titolo del link
    $cleanedDescription = $this->cleanHtmlContent($request->description);
    $menuColumnItem->description = $cleanedDescription; // Assegna la descrizione

    // Gestione del tipo di collegamento
    if ($request->link_type === 'url') {
        $menuColumnItem->url = $request->url;
        $menuColumnItem->product_id = null;
        $menuColumnItem->category_id = null;
    } elseif ($request->link_type === 'product') {
        $menuColumnItem->product_id = $request->product_id;
        $menuColumnItem->url = null;
        $menuColumnItem->category_id = null;
    } elseif ($request->link_type === 'category') {
        $menuColumnItem->category_id = $request->category_id;
        $menuColumnItem->url = null;
        $menuColumnItem->product_id = null;
    } else {
        $menuColumnItem->url = null;
        $menuColumnItem->product_id = null;
        $menuColumnItem->category_id = null;
    }

    $menuColumnItem->save();

    return redirect()->route('admin.menu-columns.edit', $menuColumnItem->menu_column_id)
        ->with('success', localize('Item aggiornato con successo!'));
}


public function updatePositions(Request $request)
{
    $positions = $request->input('positions');

    foreach ($positions as $index => $id) {
        MenuColumnItem::where('id', $id)->update(['position' => $index + 1]); // Aggiorna la posizione in base all'indice
    }

    return response()->json(['status' => 'success']);
}



    /**
     * Elimina una colonna esistente dal database.
     */
    public function destroy($id)
    {
        // Recupera l'item di colonna da eliminare
        $menuColumnItem = MenuColumnItem::findOrFail($id);
    
        // Salva l'ID della colonna associata prima di eliminare l'item
        $menuColumnId = $menuColumnItem->menu_column_id;
    
        // Elimina l'item di colonna
        $menuColumnItem->delete();
    
        // Reindirizza alla pagina di modifica della colonna con un messaggio di successo
        return redirect()->route('admin.menu-columns.edit', $menuColumnId)->with('success', localize('Item della colonna eliminato con successo!'));
    }
    


    public function cleanHtmlContent($content)
{
    // Rimuovi spazi bianchi, tag vuoti o non significativi
    $content = preg_replace('/<p>(&nbsp;|\s|<br>|<\/br>)*<\/p>/', '', $content); // Rimuove i tag <p> vuoti
    $content = preg_replace('/<br\s*\/?>/', '', $content); // Rimuove i tag <br>
    
    // Verifica se il contenuto è realmente vuoto
    $trimmedContent = strip_tags($content); // Rimuove tutti i tag per controllare solo il testo

    // Se il contenuto senza tag è vuoto, ritorna null; altrimenti, ritorna il contenuto originale
    return trim($trimmedContent) === '' ? null : $content;
}

public function duplicate($id)
{
    // Trova l'item di colonna da duplicare
    $menuColumnItem = MenuColumnItem::findOrFail($id);

    // Crea un nuovo oggetto duplicato basato sull'item originale
    $newMenuColumnItem = $menuColumnItem->replicate(); // Duplica tutti i campi dell'oggetto originale
    $newMenuColumnItem->title .= ' (Copia)'; // Aggiungi "(Copia)" al titolo per distinguere l'elemento duplicato

    // Salva il nuovo item duplicato
    $newMenuColumnItem->save();

    // Reindirizza alla pagina di modifica della colonna con un messaggio di successo
    return redirect()->route('admin.menu-columns.edit', $menuColumnItem->menu_column_id)
        ->with('success', localize('Item duplicato con successo!'));
}

}
