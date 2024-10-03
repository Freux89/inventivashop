<?php

namespace App\Http\Controllers\Backend\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;



class SectionController extends Controller
{
    public function index(Request $request)
    {

        $query = Section::query();

        // Controlla se è stato fornito un termine di ricerca
        if ($request->has('search') && !empty($request->search)) {
            $searchKey = $request->search;

            $query->where(function ($q) use ($searchKey) {
                $q->where('name', 'LIKE', "%{$searchKey}%");
            });
        }

        // Esegui la query
        $sections = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.pages.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('backend.pages.sections.create');
    }

    public function store(Request $request)
    {
        // Validazione dei dati
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            // Qui aggiungi altre validazioni per i campi che introduci
        ]);

        // Preparazione del payload JSON
        $settings = [];

        // Creazione della sezione
        $section = new Section;
        $section->name = $request->name;
        $section->type = $request->type;
        $section->settings = json_encode($settings); // Conversione dell'array in JSON
        $section->save();
        return redirect()->route('admin.sections.index')->with('success', 'Section creato con successo!');
    }

    public function edit($id)
    {
        // Recupera la sezione
        $section = Section::findOrFail($id);

        // Verifica se settings è già un array o una stringa JSON
        $settings = is_array($section->settings) ? $section->settings : json_decode($section->settings, true);

        // Estrai le categorie dalla sezione
        $categories = [];
        if ($section->type == 'filtergrid') {
            $sectionCategories = $settings['categories'] ?? '';
            $categories = explode(',', $sectionCategories);
        }



        return view('backend.pages.sections.edit', compact('section', 'categories'));
    }


    public function update(Request $request, $id)
    {

        // Valida e aggiorna il nome della sezione
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $section = Section::findOrFail($id);

        $section->name = $validatedData['name'];

        // Prendi tutti i dati di settings dal form
        $settings = $request->input('settings', []);

        // Estrai le vecchie e nuove categorie
        $oldCategories = isset($section->settings['categories']) ? explode(',', $section->settings['categories']) : [];
        $newCategories = isset($settings['categories']) ? explode(',', $settings['categories']) : [];

        // Trova le categorie rimosse
        $removedCategories = array_diff($oldCategories, $newCategories);

        // Rimuovi le categorie obsolete dagli items
        $this->removeObsoleteCategories($section, $removedCategories);

        // Salva i settings come JSON
        $section->settings = json_encode($settings);

        // Salva la sezione
        $section->save();

        return redirect()->route('admin.sections.edit', $id);
    }

    public function delete($id)
    {
        $section = Section::findOrFail($id);



        // Elimina la lavorazione
        $section->delete();

        // Reindirizza all'elenco delle lavorazioni con un messaggio di successo
        return redirect()->route('admin.sections.index')
            ->with('success', 'Sezione eliminata con successo.');
    }

    public function updateStatus(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $section->is_active = $request->is_active;
        if ($section->save()) {
            return 1;
        }
        return 0;
    }


    public function duplicate($id)
    {
        // Trova la sezione da duplicare
        $section = Section::findOrFail($id);

        // Duplica la sezione
        $newSection = $section->replicate();
        $newSection->name = $section->name . ' (Copy)'; // Aggiungi "(Copy)" per differenziare la nuova sezione
        $newSection->save();

        // Duplica gli item collegati alla sezione
        foreach ($section->items as $item) {
            $newItem = $item->replicate();
            $newItem->section_id = $newSection->id; // Associa il nuovo item alla nuova sezione
            $newItem->save();
        }

        return redirect()->route('admin.sections.index')->with('success', 'Sezione duplicata con successo.');
    }



    protected function removeObsoleteCategories($section, $removedCategories)
    {
        // Se ci sono categorie rimosse, aggiorna gli items
        if (!empty($removedCategories)) {
            // Recupera tutti gli items della sezione
            $items = $section->items()->get();

            foreach ($items as $item) {
                // Decodifica il campo settings dell'item
                $itemSettings = is_array($item->settings) ? $item->settings : json_decode($item->settings, true);

                // Rimuovi le categorie rimosse dall'array 'categories_item'
                if (isset($itemSettings['categories_item'])) {
                    $itemSettings['categories_item'] = array_diff($itemSettings['categories_item'], $removedCategories);

                    // Salva nuovamente le categorie aggiornate nell'item
                    $item->settings = json_encode($itemSettings);
                    $item->save();
                }
            }
        }
    }
}
