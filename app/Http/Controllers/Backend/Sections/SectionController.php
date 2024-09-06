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
            $q->where('name', 'LIKE', "%{$searchKey}%") ;
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
        $section = Section::findOrFail($id);
        return view('backend.pages.sections.edit', compact('section'));
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
}