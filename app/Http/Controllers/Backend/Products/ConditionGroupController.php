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
use App\Models\ActionVariationValue;
use Illuminate\Support\Facades\DB;

class ConditionGroupController extends Controller
{
    public function index(Request $request)
    {
        // Inizia la query di base per tutti i prodotti che hanno almeno una condizione
        $query = Product::whereHas('conditionGroups');

        // Controlla se è stato fornito un termine di ricerca
        if ($request->has('search') && !empty($request->search)) {
            $searchKey = $request->search;

            // Aggiungi la logica di ricerca alla query
            $query->where(function ($q) use ($searchKey) {
                $q->where('name', 'LIKE', "%{$searchKey}%") // Cerca per nome del prodotto
                    ->orWhereHas('conditionGroups', function ($q) use ($searchKey) {
                        $q->where('description', 'LIKE', "%{$searchKey}%"); // Cerca nella descrizione delle condizioni
                    });
            });
        }

        // Esegui la query
        $products = $query->with('conditionGroups')->orderBy('created_at', 'desc')->paginate(10);

        // Ritorna la vista con i risultati della ricerca
        return view('backend.pages.products.conditions.index', compact('products'));
    }

    public function create()
    {
        // Recupera solo i prodotti che non hanno condizioni associate
        $products = Product::doesntHave('conditionGroups')->get();


        // Restituisce la vista per creare una nuova condizione, correggendo il percorso della vista
        return view('backend.pages.products.conditions.create', compact('products'));
    }


    public function store(Request $request)
{
    $request->validate([
        'products' => 'required|exists:products,id',
        // Aggiungi qui altre regole di validazione secondo necessità
    ]);

    DB::beginTransaction();

    try {
        $conditionGroup = new ConditionGroup([
            'product_id' => $request->input('products'),
        ]);

        $conditionGroup->save();

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
        
        
        return view('backend.pages.products.conditions.edit', compact('conditionGroup'));
    }


    public function update(Request $request, $conditionGroupId)
{
    $request->validate([
        'products' => 'required|exists:products,id',
        // Includi qui le stesse regole di validazione o adattale se necessario per l'update
    ]);

    DB::beginTransaction();

    try {
        $conditionGroup = ConditionGroup::findOrFail($conditionGroupId);
        $conditionGroup->product_id = $request->input('products');
        $conditionGroup->save();

        // Rimuovi le condizioni (e azioni correlate) esistenti
        $conditionGroup->conditions()->delete(); // Assicurati che il model Condition definisca correttamente le relazioni per permettere ciò

        // Ricrea le condizioni e le azioni come nel metodo store
        foreach ($request->input('condition', []) as $conditionData) {
            if (!empty($conditionData['variantValue'])) {
                $condition = new Condition([
                    'condition_group_id' => $conditionGroup->id,
                    'variation_value_id' => $conditionData['variantValue'],
                    'motivational_message' => $conditionData['motivational_message'] ?? null, // Aggiungi il campo motivational_message
                ]);
                $condition->save();

                foreach ($conditionData['action'] ?? [] as $actionData) {
                    $applyToAll = in_array('All', $actionData['shutdownVariantValue']);

                    $action = new Action([
                        'condition_id' => $condition->id,
                        'action_type' => 'Spegni',
                        'variation_id' => $actionData['shutdownVariant'],
                        'motivational_message' => $actionData['motivational_message'],
                        'apply_to_all' => $applyToAll,
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
