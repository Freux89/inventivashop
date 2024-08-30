<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workflow;
use App\Models\Variation;
use App\Models\Product;
use App\Models\Category;
use App\Models\VariationValue;

class WorkflowController extends Controller
{
    public function index(Request $request)
    {
        // Inizia la query di base per tutte le lavorazioni
    $query = Workflow::query();

    // Controlla se è stato fornito un termine di ricerca
    if ($request->has('search') && !empty($request->search)) {
        $searchKey = $request->search;

        // Aggiungi la logica di ricerca alla query
        $query->where(function ($q) use ($searchKey) {
            $q->where('name', 'LIKE', "%{$searchKey}%") // Cerca per nome della lavorazione
                ->orWhereHas('products', function ($q) use ($searchKey) {
                    $q->where('name', 'LIKE', "%{$searchKey}%"); // Cerca nei nomi dei prodotti
                })
                ->orWhereHas('variationValues', function ($q) use ($searchKey) {
                    $q->where('name', 'LIKE', "%{$searchKey}%"); // Cerca nei valori delle varianti
                });
        });
    }

    // Esegui la query
    $workflows = $query->orderBy('created_at', 'desc')->paginate(10);

    // Ritorna la vista con i risultati della ricerca
    return view('backend.pages.workflows.index', compact('workflows'));
    }

    public function create()
    {
        $products = Product::all(); // Recupera tutti i prodotti
        $variations = Variation::all(); // Recupera tutti i valori delle varianti
        $categories = Category::all();
        return view('backend.pages.workflows.create', compact('products', 'variations', 'categories')); // Restituisce la vista per creare una nuova lavorazione
    }

    public function edit($id)
    {
        $categories = Category::all();
        $products = Product::all(); // Recupera tutti i prodotti
        $variations = Variation::all(); // Recupera tutti i valori delle varianti
        $workflow = Workflow::findOrFail($id); // Trova la lavorazione per ID o fallisce
        return view('backend.pages.workflows.edit', compact('workflow', 'products', 'variations', 'categories'));
    }




    public function store(Request $request)
    {
        // Validazione dei dati del form
        $request->validate([
            'name' => 'required|string|max:255|unique:workflows,name',
            'duration' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'increase_duration' => 'required|integer|min:0',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'variation_values' => 'nullable|array',
            'variation_values.*' => 'exists:variation_values,id',
        ]);

        // Creazione della lavorazione
        $workflow = new Workflow();
        $workflow->name = $request->name;
        $workflow->duration = $request->duration;
        $workflow->quantity = $request->quantity; // Salva il valore di 'quantity'
        $workflow->increase_duration = $request->increase_duration;
        $workflow->save();

 // Gestione delle associazioni delle categorie
 if ($request->has('categories')) {
    foreach ($request->categories as $categoryId) {
        // Rimuovi l'associazione della categoria da altre lavorazioni
        Workflow::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->each(function ($workflow) use ($categoryId) {
            $workflow->categories()->detach($categoryId);
        });
    }
    // Associa le categorie selezionate alla nuova lavorazione
    $workflow->categories()->attach($request->categories);
}

        // Associazione dei prodotti selezionati alla lavorazione
        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                // Qui rimuovi l'associazione del prodotto da altre lavorazioni
                Workflow::whereHas('products', function ($query) use ($productId) {
                    $query->where('products.id', $productId);
                })->each(function ($workflow) use ($productId) {
                    $workflow->products()->detach($productId);
                });
            }
            // Associazione dei prodotti selezionati alla nuova lavorazione
            $workflow->products()->attach($request->products);
        }

        // Rimozione delle associazioni dei valori delle varianti selezionati da altre lavorazioni
        if ($request->has('variation_values')) {
            foreach ($request->variation_values as $variationValueId) {
                // Qui rimuovi l'associazione del valore della variante da altre lavorazioni
                Workflow::whereHas('variationValues', function ($query) use ($variationValueId) {
                    $query->where('variation_values.id', $variationValueId);
                })->each(function ($workflow) use ($variationValueId) {
                    $workflow->variationValues()->detach($variationValueId);
                });
            }
            // Associazione dei valori delle varianti selezionati alla nuova lavorazione
            $workflow->variationValues()->attach($request->variation_values);
        }

        // Reindirizzamento con messaggio di successo
        return redirect()->route('admin.workflows.index')->with('success', 'Lavorazione aggiunta con successo.');
    }

    public function update(Request $request, $id)
    {
        // Trova la lavorazione da aggiornare
        $workflow = Workflow::findOrFail($id);

        // Validazione dei dati del form
        $request->validate([
            'name' => 'required|string|max:255|unique:workflows,name,' . $workflow->id,
            'duration' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'increase_duration' => 'required|integer|min:0',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'variation_values' => 'nullable|array',
            'variation_values.*' => 'exists:variation_values,id',
        ]);

        // Aggiornamento della lavorazione
        $workflow->name = $request->name;
        $workflow->duration = $request->duration;
        $workflow->quantity = $request->quantity; // Salva il valore di 'quantity'
        $workflow->increase_duration = $request->increase_duration;
        $workflow->save();
// Gestione delle categorie associate
if ($request->has('categories')) {
    foreach ($request->categories as $categoryId) {
        // Rimuovi l'associazione della categoria da altre lavorazioni
        Workflow::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->each(function ($workflow) use ($categoryId) {
            $workflow->categories()->detach($categoryId);
        });
    }
    // Associazione delle categorie selezionate alla nuova lavorazione
    $workflow->categories()->sync($request->categories);
} else {
    $workflow->categories()->detach(); // Rimuove tutte le associazioni se nessuna categoria è selezionata
}
        // Gestione dei prodotti associati
        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                // Qui rimuovi l'associazione del prodotto da altre lavorazioni
                Workflow::whereHas('products', function ($query) use ($productId) {
                    $query->where('products.id', $productId);
                })->each(function ($workflow) use ($productId) {
                    $workflow->products()->detach($productId);
                });
            }
            // Associazione dei prodotti selezionati alla nuova lavorazione
            
        }
$workflow->products()->sync($request->products);
        // Rimozione delle associazioni dei valori delle varianti selezionati da altre lavorazioni
        if ($request->has('variation_values')) {
            foreach ($request->variation_values as $variationValueId) {
                // Qui rimuovi l'associazione del valore della variante da altre lavorazioni
                Workflow::whereHas('variationValues', function ($query) use ($variationValueId) {
                    $query->where('variation_values.id', $variationValueId);
                })->each(function ($workflow) use ($variationValueId) {
                    $workflow->variationValues()->detach($variationValueId);
                });
            }
            // Associazione dei valori delle varianti selezionati alla nuova lavorazione
            
        }
$workflow->variationValues()->sync($request->variation_values);

        // Reindirizzamento con messaggio di successo
        return redirect()->route('admin.workflows.index')->with('success', 'Lavorazione aggiornata con successo.');
    }

    public function delete($id)
    {
        
        $workflow = Workflow::findOrFail($id);

        $workflow->categories()->detach();
        // Rimuove le associazioni con i prodotti
        $workflow->products()->detach();

        // Rimuove le associazioni con i valori delle varianti
        $workflow->variationValues()->detach();

        // Elimina la lavorazione
        $workflow->delete();

        // Reindirizza all'elenco delle lavorazioni con un messaggio di successo
        return redirect()->route('admin.workflows.index')
            ->with('success', 'Lavorazione eliminata con successo.');
    }
}
