<?php

namespace App\Http\Controllers\Backend\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionItem;
use App\Models\Section;
class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sectionId, $type)
    {
        $section = Section::findOrFail($sectionId);
        return view('backend.pages.sections.items.create', compact('section', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sectionId)
{
    // Creazione di una nuova colonna
    $SectionItem = new SectionItem();
    $SectionItem->section_id = $sectionId;  // Imposta l'ID della sezione
    $SectionItem->type = $request->input('type');
    // Salvataggio di tutti i dati della request in settings come JSON
    $SectionItem->settings = json_encode($request->except('_token','type')); // Escludi il token CSRF se presente

    // Salvataggio della colonna
    $SectionItem->save();

    // Reindirizzamento a una vista appropriata, ad esempio, torna alla lista delle colonne con un messaggio di successo
    return redirect()->route('admin.sections.edit', $sectionId)
                     ->with('success', 'Elemento aggiunto con successo!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $item = SectionItem::findOrFail($id);
        
        return view('backend.pages.sections.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Trova la colonna esistente
    $item = SectionItem::findOrFail($id);

    
    $item->settings = json_encode($request->except('_token', '_method', 'type')); // Escludi il token CSRF e il metodo HTTP

    // Salvataggio delle modifiche
    $item->save();

    return redirect()->route('admin.sections.edit', $item->section_id)
                     ->with('success', 'Elemento aggiornato con successo!');
}

public function duplicate($id)
    {
        // Trova l'oggetto SectionItem originale usando l'ID
        $original = SectionItem::find($id);

        if (!$original) {
            // Se non trovi la colonna, reindirizza con un errore
            return redirect()->route('admin.sections.edit', $original->section_id)
            ->with('error', 'Elemento non duplicata!');
        }

        // Esegui la duplicazione
        $duplicate = $original->replicate();

        // Qui puoi rimuovere qualsiasi attributo che non deve essere duplicato, es:
        // $duplicate->resetSomeProperty();

        // Salva la nuova colonna
        $duplicate->save();

        // Reindirizza alla lista delle colonne con un messaggio di successo
        return redirect()->route('admin.sections.edit', $original->section_id)
        ->with('success', 'Colonna duplicata  con successo!');
    }

    public function updateStatus(Request $request)
    {
        $item = SectionItem::findOrFail($request->id);
        $item->is_active = $request->is_active;
        if ($item->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePositions(Request $request)
    {
        
        try {
            foreach ($request->positions as $position => $id) {
                SectionItem::find($id)->update(['position' => $position]);
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $item = SectionItem::findOrFail($id);

        $sectionId = $item->section_id;

        // Elimina la lavorazione
        $item->delete();

        // Reindirizza all'elenco delle lavorazioni con un messaggio di successo
        return redirect()->route('admin.sections.edit', $sectionId)
                     ->with('success', 'Elemento eliminato con successo!');
    }
}
