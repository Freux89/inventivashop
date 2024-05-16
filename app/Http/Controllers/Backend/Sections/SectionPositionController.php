<?php

namespace App\Http\Controllers\Backend\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionPosition;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class SectionPositionController extends Controller
{
    public function index(Request $request)
    {
        
        // Configurazione predefinita dei positionable_types e dei loro hook_names
    $defaultPositions = [
        'Home' => ['hook_home'],
        'Category' => ['hook_before_content', 'hook_after_content'],
        'Product' => ['hook_before_content', 'hook_after_content'],
        'Page' => ['hook_before_content', 'hook_after_content']
    ];

    // Inizializza un array per raccogliere le posizioni
    $positions = [];

    // Assicurati che ogni tipo e hook abbia una collezione vuota
    foreach ($defaultPositions as $type => $hooks) {
        foreach ($hooks as $hook) {
            $positions[$type][$hook] = collect(); // Inizializza con una collezione vuota
        }
    }

    // Carica le posizioni esistenti e sovrascrive le collezioni vuote dove ci sono dati
    $existingPositions = SectionPosition::orderBy('positionable_type')
                                        ->orderBy('hook_name')
                                        ->orderBy('order', 'asc')
                                        ->get()
                                        ->groupBy(['positionable_type', 'hook_name']);
    
    // Unisci le posizioni esistenti con le configurazioni predefinite
    foreach ($existingPositions as $type => $hooks) {
        foreach ($hooks as $hook => $data) {
            $positions[$type][$hook] = $data;
        }
    }

        return view('backend.pages.sections.positions.index', compact('positions'));
    }

    public function create()
    {
        $sections = Section::all(); // Assumendo che tu abbia un model Section
        return view('backend.pages.sections.positions.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'position_type' => 'required|in:Home,Category,Product,Page',
            'hook' => 'required|string',
            'entities' => 'nullable|array'
        ]);

        try {
            // Inizia una transazione
            DB::beginTransaction();

            // Calcola l'ordine successivo per la nuova posizione
            $lastOrder = SectionPosition::where('positionable_type', $validatedData['position_type'])
            ->where('hook_name', $validatedData['hook'])
            ->max('order');

            $sectionPosition = new SectionPosition();
            $sectionPosition->section_id = $validatedData['section_id'];
            $sectionPosition->positionable_type = $validatedData['position_type'];
            $sectionPosition->hook_name = $validatedData['hook'];
            $sectionPosition->order = $lastOrder + 1;
            $sectionPosition->save();

            // Gestione delle entità associate
            if (!empty($validatedData['entities']) && !in_array('all', $validatedData['entities'])) {
                foreach ($validatedData['entities'] as $entityId) {
                    $sectionPosition->positionables()->create([
                        'positionable_id' => $entityId
                    ]);
                }
            }

            // Esegui la transazione
            DB::commit();

            return redirect()->route('admin.section_positions.index')->with('success', 'Sezione associata con successo!');
        } catch (\Exception $e) {
            // Annulla la transazione in caso di errore
            DB::rollback();
            return redirect()->route('admin.section_positions.index')->with('error', 'Errore durante l\'associazione della sezione: ' . $e->getMessage());
        }
    }


public function edit($id)
{
    
    $sectionPosition = SectionPosition::find($id);
    $sections = Section::all();
    $selectedIds = $sectionPosition->positionables->pluck('positionable_id')->toArray();
    $entityOptionsHtml = '';

    // Supponendo che gli hook variano a seconda della position_type
    if($sectionPosition->positionable_type != 'Home'){
        $entityOptionsHtml = $this->getEntities($sectionPosition->positionable_type, $selectedIds)->render();
    }
        
    
    
    // Passa i dati alla vista
    return view('backend.pages.sections.positions.edit', [
        'sectionPosition' => $sectionPosition,
        'sections' => $sections,
        'entityOptionsHtml' => $entityOptionsHtml  // Supponendo che hai una relazione 'entities'
    ]);
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'section_id' => 'required|exists:sections,id',
        'position_type' => 'required|in:Home,Category,Product,Page',
        'hook' => 'required|string',
        'entities' => 'nullable|array'
    ]);

    try {
        // Inizia una transazione
        DB::beginTransaction();

        // Trova la posizione esistente
        $sectionPosition = SectionPosition::findOrFail($id);

        // Aggiorna i dettagli della posizione
        $sectionPosition->section_id = $validatedData['section_id'];
        $sectionPosition->positionable_type = $validatedData['position_type'];
        $sectionPosition->hook_name = $validatedData['hook'];
        $sectionPosition->save();

        // Aggiorna le entità associate
        $sectionPosition->positionables()->delete(); // Rimuovi le associazioni esistenti
        if (!empty($validatedData['entities'])) {
            foreach ($validatedData['entities'] as $entityId) {
                $sectionPosition->positionables()->create([
                    'positionable_id' => $entityId
                ]);
            }
        }

        // Esegui la transazione
        DB::commit();

        return redirect()->route('admin.section_positions.index')->with('success', 'Posizione della sezione aggiornata con successo!');
    } catch (\Exception $e) {
        // Annulla la transazione in caso di errore
        DB::rollback();
        return redirect()->route('admin.section_positions.index')->with('error', 'Errore durante l\'aggiornamento della posizione della sezione: ' . $e->getMessage());
    }
}

    public function delete($id)
    {
        $position = SectionPosition::findOrFail($id);

      

        // Elimina la posizione
        $position->delete();

       
        return redirect()->route('admin.section_positions.index')
            ->with('success', 'Posizione eliminata con successo.');
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

    public function updatePositions(Request $request)
    {
       
        try {
            foreach ($request->positions as $position => $id) {
                SectionPosition::find($id)->update(['order' => $position]);
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getEntities($type, $selectedIds = [])
    {
        
        switch ($type) {
            case 'Category':
                $entities = Category::all();
                break;
            case 'Product':
                $entities = Product::all();
                break;
            case 'Page':
                $entities = Page::all();
                break;
            default:
                return response()->json(['error' => 'Tipo non valido'], 400);
        }
       
        return view('backend.pages.partials.entity_options', [
            'entities' => $entities,
            'selectedIds' => $selectedIds // Assicurati che sia sempre un array
        ]);
    }

}