<?php

namespace App\Http\Controllers\Backend\Templates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Variation;
use App\Models\ProductVariation;

class TemplateVariationsController extends Controller
{
    public function index(Request $request)
    {
        // Recupera il valore di ricerca dalla richiesta
        $search = $request->input('search');
    
        // Crea una query di base per i templates con template_type 'variation'
        $query = Template::where('template_type', 'variation');
    
        // Se il campo di ricerca non è vuoto, aggiungi un filtro per il nome
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        // Esegui la query e paginazione
        $templates = $query->paginate(10);

        return view('backend.pages.templates.variations.index', compact('templates'));
    }

    // Mostra il form per creare un nuovo template variante
    public function create()
    {
        $variations = Variation::all();
        return view('backend.pages.templates.variations.create', compact('variations'));
    }

    // Salva un nuovo template variante
    public function store(Request $request)
    {
        // Creazione del Template
        $template = new Template;
        $template->name = $request->name;
        $template->template_type = 'variation';
        $template->save();

        // Salvataggio delle Varianti Associate
        if ($request->has('variations') && is_array($request->variations) && count($request->variations) > 0) {

            foreach ($request->variations as $variation) {
                $template_variation = new ProductVariation;
                $template_variation->template_id = $template->id;
                $template_variation->variation_key = $variation['variation_key'];
                $template_variation->price = priceToUsd($variation['price']);
                $template_variation->price_change_type = $variation['price_change_type'];
                $template_variation->save();
            }
        }
    
        return redirect()->route('admin.templates.variations.index')->with('success', 'Template varianti creato con successo.');
    }



    public function edit(Template $template)
    {
        // Ottieni tutte le varianti disponibili
        $variations = Variation::all();

        // Passa il template e le sue varianti alla vista
        return view('backend.pages.templates.variations.edit', compact('template', 'variations'));
    }

    // Aggiorna il template variante esistente
    public function update(Request $request, Template $template)
{
    // Aggiornamento del nome del template e del tipo
    $template->name = $request->name;
    $template->template_type = 'variation';
    $template->save();

    // Recupera gli ID delle varianti esistenti per confronto
    $existingVariations = $template->variations->keyBy('variation_key');

    // Itera sulle varianti inviate dal form
    foreach ($request->variations as $variation) {
        if (isset($existingVariations[$variation['variation_key']])) {
            // Se la variante esiste già, aggiornala
            $template_variation = $existingVariations[$variation['variation_key']];
            $template_variation->price = priceToUsd($variation['price']);
            $template_variation->price_change_type = $variation['price_change_type'];
            $template_variation->save();

            // Rimuovi la variante dall'elenco delle esistenti, poiché è stata aggiornata
            $existingVariations->forget($variation['variation_key']);
        } else {
            // Se la variante non esiste, creane una nuova
            $template_variation = new ProductVariation; // Cambiato in ProductVariation
            $template_variation->template_id = $template->id;
            $template_variation->variation_key = $variation['variation_key'];
            $template_variation->price = priceToUsd($variation['price']);
            $template_variation->price_change_type = $variation['price_change_type'];
            $template_variation->save();
        }
    }

    // Rimuovi le varianti che non sono più presenti nel form
    foreach ($existingVariations as $variation) {
        $variation->delete();
    }
    $variations = Variation::all();

    // Passa il template e le sue varianti alla vista
    return view('backend.pages.templates.variations.edit', compact('template', 'variations'));
}

    

    // Elimina un template variante
    public function delete($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        return redirect()->route('admin.templates.variations.index')->with('success', 'Template Variations deleted successfully.');
    }
}
