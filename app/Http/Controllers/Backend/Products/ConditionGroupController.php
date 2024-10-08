<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\ConditionGroup;
use App\Models\Condition;
use App\Models\Action;
use App\Models\Template;
use App\Models\ActionVariationValue;
use Illuminate\Support\Facades\DB;

class ConditionGroupController extends Controller
{
    public function index(Request $request)
{
    // Inizia la query di base per tutti i gruppi di condizioni
    $query = ConditionGroup::query();

    // Controlla se è stato fornito un termine di ricerca
    if ($request->has('search') && !empty($request->search)) {
        $searchKey = $request->search;

        // Aggiungi la logica di ricerca alla query
        $query->where('name', 'LIKE', "%{$searchKey}%"); // Cerca per nome del gruppo di condizioni
    }

    // Esegui la query
    $conditionGroups = $query->orderBy('created_at', 'desc')->paginate(20);

    // Ritorna la vista con i risultati della ricerca
    return view('backend.pages.products.conditions.index', compact('conditionGroups'));
}

    public function create()
    {
        // Recupera solo i prodotti che non hanno condizioni associate
        $products = Product::doesntHave('directConditionGroups')->get();


        // Restituisce la vista per creare una nuova condizione, correggendo il percorso della vista
        return view('backend.pages.products.conditions.create', compact('products'));
    }


    public function store(Request $request)
    {
        // Valida la richiesta
        $request->validate([
            'group_type' => 'required|in:product,template',
            'name' => 'required|string|max:255', // Valida il campo 'name'
        ]);
    
        DB::beginTransaction();
    
        try {
            // Inizializza il product_id come null
            $product_id = null;
    
            // Se il tipo di gruppo è "product", verifica che il prodotto sia selezionato
            if ($request->input('group_type') === 'product') {
                $request->validate([
                    'products' => 'required|exists:products,id',
                ]);
                $product_id = $request->input('products');
            }
    
            // Crea un nuovo ConditionGroup
            $conditionGroup = new ConditionGroup([
                'product_id' => $product_id,
                'name' => $request->input('name'), // Nome della condizione gruppo
            ]);
    
            $conditionGroup->save();
    
            // Se è stato scelto il tipo template, assegna il condition_group_id al template selezionato
            if ($request->input('group_type') === 'template') {
                // Assumendo che il template sia selezionato tramite un dropdown o qualcosa di simile
                $template_id = $request->input('template_id');
                if ($template_id) {
                    $template = Template::find($template_id);
                    $template->condition_group_id = $conditionGroup->id;
                    $template->save();
                }
            }
    
            // Salva le condizioni collegate al gruppo di condizioni
            foreach ($request->input('condition', []) as $conditionData) {
                if (!empty($conditionData['variantValue'])) { // Controlla che la condizione abbia un valore variante
                    $condition = new Condition([
                        'condition_group_id' => $conditionGroup->id,
                        'variation_value_id' => $conditionData['variantValue'], // Usa il campo variation_value_id
                        'motivational_message' => $conditionData['motivational_message'] ?? null, // Aggiungi il campo motivational_message
                    ]);
                    $condition->save();
    
                    foreach ($conditionData['action'] ?? [] as $actionData) {
                        $applyToAll = in_array('All', $actionData['shutdownVariantValue']);
    
                        $action = new Action([
                            'condition_id' => $condition->id,
                            'action_type' => 'Spegni',
                            'variation_id' => $actionData['shutdownVariant'], // Usa il campo variation_id
                            'motivational_message' => $actionData['motivational_message'],
                            'apply_to_all' => $applyToAll,
                        ]);
                        $action->save();
    
                        if (!$applyToAll) {
                            foreach ($actionData['shutdownVariantValue'] as $variantValueId) {
                                $actionVariationValue = new ActionVariationValue([
                                    'action_id' => $action->id,
                                    'variation_value_id' => $variantValueId, // Usa il campo variation_value_id
                                ]);
                                $actionVariationValue->save();
                            }
                        }
                    }
                }
            }
    
            DB::commit();
            flash(localize('Condizioni aggiunte con successo.'))->success();
    
            return redirect()->route('admin.conditions.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash(localize('Errore durante il salvataggio: ' . $e->getMessage()))->error();
    
            return redirect()->route('admin.conditions.index');
        }
    }
    



    public function edit($id)
    {
        
        $conditionGroup = ConditionGroup::findOrFail($id);
        $products = Product::whereDoesntHave('conditionGroups')
                ->orWhere('id', $conditionGroup->product_id) // Include il prodotto attualmente collegato alla condizione gruppo
                ->get();
        
        return view('backend.pages.products.conditions.edit', compact('conditionGroup','products'));
    }


    public function update(Request $request, $conditionGroupId)
    {
        // Valida la richiesta
        $request->validate([
            'group_type' => 'required|in:product,template',
            'name' => 'required|string|max:255',
            // Aggiungi qui altre regole di validazione o adattale se necessario per l'update
        ]);
    
        DB::beginTransaction();
    
        try {
            $conditionGroup = ConditionGroup::findOrFail($conditionGroupId);
    
            // Inizializza il product_id come null
            $product_id = null;
    
            // Se il tipo di gruppo è "product", verifica che il prodotto sia selezionato
            if ($request->input('group_type') === 'product') {
                $request->validate([
                    'products' => 'required|exists:products,id',
                ]);
    
                $product_id = $request->input('products');

                // Controlla se la condizione è attualmente associata a un template
             // Dissocia la condizione da tutti i template che la utilizzano
             $associatedTemplates = Template::where('condition_group_id', $conditionGroupId)->get();
             foreach ($associatedTemplates as $template) {
                 $template->condition_group_id = null;
                 $template->save();
             }
            }
    
            // Aggiorna il ConditionGroup, impostando il product_id o lasciandolo null
            $conditionGroup->product_id = $product_id;
            $conditionGroup->name = $request->input('name'); // Aggiorna il nome della condizione gruppo
            $conditionGroup->save();
    
            // Rimuovi le condizioni (e azioni correlate) esistenti
            $conditionGroup->conditions()->delete(); // Assicurati che il model Condition definisca correttamente le relazioni per permettere ciò
    
            // Ricrea le condizioni e le azioni come nel metodo store
            foreach ($request->input('condition', []) as $conditionData) {
                if (!empty($conditionData['variantValue'])) {
                    $condition = new Condition([
                        'condition_group_id' => $conditionGroup->id,
                        'variation_value_id' => $conditionData['variantValue'],
                        'motivational_message' => $conditionData['motivational_message'] ?? null,
                    ]);
                    $condition->save();
    
                    foreach ($conditionData['action'] ?? [] as $actionData) {
                        $applyToAll = in_array('All', $actionData['shutdownVariantValue']);
                        $disableVariationValues = isset($actionData['disableVariationValues']) && $actionData['disableVariationValues'] == 1;

                        $action = new Action([
                            'condition_id' => $condition->id,
                            'action_type' => 'Spegni',
                            'variation_id' => $actionData['shutdownVariant'],
                            'motivational_message' => $actionData['motivational_message'],
                            'apply_to_all' => $applyToAll,
                            'disable_variation_values' => $disableVariationValues,
                        ]);
                        $action->save();
    
                        if (!$applyToAll) {
                            foreach ($actionData['shutdownVariantValue'] as $variantValueId) {
                                $actionVariationValue = new ActionVariationValue([
                                    'action_id' => $action->id,
                                    'variation_value_id' => $variantValueId,
                                ]);
                                $actionVariationValue->save();
                            }
                        }
                    }
                }
            }
    
            DB::commit();
    
            flash(localize('Condizioni aggiornate con successo.'))->success();
    
            return redirect()->route('admin.conditions.index');
        } catch (\Exception $e) {
            DB::rollBack();
    
            flash(localize('Errore durante l\'aggiornamento: ' . $e->getMessage()))->error();
            return redirect()->route('admin.conditions.index');
        }
    }
    


    public function getVariations(Request $request)
{
    $excludeVariantId = $request->query('excludeVariantId'); // Nuovo parametro per escludere una variante
    $context = $request->input('context', 'condition');
    $viewName = $context === 'action' ? 'backend.pages.partials.conditions.actionVariantSelect' : 'backend.pages.partials.conditions.conditionVariantSelect';
    $conditionIndex = $request->query('conditionIndex', 0);
    $actionIndex = $request->query('actionIndex', 0);

    // Recupera tutte le varianti disponibili, escludendo quella specificata
    $variations = $this->getAllVariationsArray($excludeVariantId);

    // Usa la vista Blade per generare l'HTML
    $html = view($viewName, [
        'variations' => $variations,
        'conditionIndex' => $conditionIndex,
        'actionIndex' => $actionIndex,
        'selectedVariantId' => null
    ])->render();

    // Restituisci l'HTML generato come risposta
    return response()->json(['html' => $html]);
}

    public function getVariationsArray($productId, $excludeVariantId = null)
    {
        $product = Product::findOrFail($productId);

        $variations = $product->variations()->get()->map(function ($variation) use ($excludeVariantId) {
            $keys = explode(':', rtrim($variation->variation_key, '/'));
            $variationId = $keys[0];
            return [
                'id' => $variationId,
                'variation_name' => $variation->variation_name
            ];
        })->when($excludeVariantId, function ($query) use ($excludeVariantId) {
            return $query->whereNotIn('id', [$excludeVariantId]);
        })->unique('variation_name')->values();

        return $variations;
    }

    public function getVariantValues(Request $request)
{
    $variantId = $request->input('variantId');
    $context = $request->input('context', 'condition');
    $conditionIndex = $request->input('conditionIndex');
    $actionIndex = $request->query('actionIndex', 0);
    $viewName = $context === 'action' ? 'backend.pages.partials.conditions.actionVariantValueSelect' : 'backend.pages.partials.conditions.conditionVariantValueSelect';

    // Recupera tutti i valori delle varianti che corrispondono all'ID della variante specificata
    $variantValues = $this->getVariantValuesArray($variantId);

    $html = view($viewName, [
        'values' => $variantValues,
        'conditionIndex' => $conditionIndex,
        'actionIndex' => $actionIndex,
        'selectedValueId' => null
    ])->render();

    // Restituisci l'HTML generato come risposta
    return response()->json(['html' => $html]);
}



public function getVariantValuesArray($variantId)
{
    // Recupera tutte le variazioni che corrispondono all'ID della variante specificata
    $variantValues = VariationValue::where('variation_id', $variantId)->get()->map(function ($variationValue) {
        return [
            'variation_value_id' => $variationValue->id,
            'value_name' => $variationValue->name,
        ];
    });

    return $variantValues;
}
    public function delete($id)
    {
        $ConditionGroup = ConditionGroup::findOrFail($id);
        $ConditionGroup->delete();
        flash(localize('Condizioni Prodotto cancellate con successo'))->success();
        return back();
    }


    public function getAllVariationsArray($excludeVariantId = null)
    {
        // Recupera tutte le varianti
        $variations = Variation::all();
    
        // Trasforma le varianti in un array utilizzabile nel Blade
        $variationsArray = $variations->map(function ($variation) {
            return [
                'id' => $variation->id,
                'variation_name' => $variation->name,
            ];
        });
    
        // Escludi la variante se necessario
        if ($excludeVariantId) {
            $variationsArray = $variationsArray->reject(function ($variation) use ($excludeVariantId) {
                return $variation['id'] == $excludeVariantId;
            })->values();
        }
    
        return $variationsArray;
    }
}
