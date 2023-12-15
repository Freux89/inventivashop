<?php

namespace App\Http\Controllers\Backend\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderState;
use App\Models\StateLocalization;

class OrderStatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all states
        $states = OrderState::paginate(20);

        return view('backend.pages.states.index', compact('states'));

       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('backend.pages.states.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
            'send_email' => 'required|in:0,1', 
            'color' => 'required|string|regex:/^#([a-fA-F0-9]{6})$/', 
            'email_content' => 'nullable|string',
            'type' => 'required|in:1,2', 
            'cancelled' => 'required|in:0,1',
            'invoice' => 'required|in:0,1',
            'visible_to_customer' => 'required|in:0,1',
            'default_on_completion' => 'required|in:0,1',
        ]);
    
        // Creazione di un nuovo stato d'ordine
        $orderState = new OrderState();
        $orderState->name = $validatedData['name'];
        $orderState->send_email = $validatedData['send_email'];
        $orderState->color = $validatedData['color'];
        $orderState->type = $validatedData['type'];
        $orderState->cancelled = $validatedData['cancelled'];
        $orderState->invoice = $validatedData['invoice'];
        $orderState->visible_to_customer = $validatedData['visible_to_customer'];
        if ($validatedData['default_on_completion'] == 1) {
            OrderState::query()->update(['default_on_completion' => 0]);
        }
        $orderState->default_on_completion = $validatedData['default_on_completion'];
        
        // Salva il contenuto email solo se send_email è 1
        if ($validatedData['send_email'] == 1) {
            $orderState->email_content = $validatedData['email_content'];
        }
    
        // Salva il nuovo stato d'ordine nel database
        $orderState->save();
   
        $StateLocalization = StateLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'order_state_id' => $orderState->id]);
        $StateLocalization->name = $request->name;
        if ($validatedData['send_email'] == 1) {
            $StateLocalization->email_content = $validatedData['email_content'];
        }
        $StateLocalization->save();
        flash(localize('Stato d\'ordine creato con successo'))->success();
        // Redirect a una pagina con messaggio di successo
        return redirect()->route('admin.orderStates.index');
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    
            // get state by id
            $orderState = OrderState::findOrFail($id);
    
            return view('backend.pages.states.edit', compact('orderState'));
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
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', 
        'send_email' => 'required|in:0,1', 
        'color' => 'required|string|regex:/^#([a-fA-F0-9]{6})$/', 
        'email_content' => 'nullable|string',
        'type' => 'required|in:1,2', 
        'cancelled' => 'required|in:0,1',
        'invoice' => 'required|in:0,1',
        'visible_to_customer' => 'required|in:0,1',
        'default_on_completion' => 'required|in:0,1',
    ]);

    // Trova l'ordine esistente o fallisci se non trovato
    $orderState = OrderState::findOrFail($id);
    $orderState->name = $validatedData['name'];
    $orderState->send_email = $validatedData['send_email'];
    $orderState->color = $validatedData['color'];
    $orderState->type = $validatedData['type'];
    $orderState->cancelled = $validatedData['cancelled'];
    $orderState->invoice = $validatedData['invoice'];
    $orderState->visible_to_customer = $validatedData['visible_to_customer'];
    if ($validatedData['default_on_completion'] == 1) {
        OrderState::query()->update(['default_on_completion' => 0]);
    }
    $orderState->default_on_completion = $validatedData['default_on_completion'];
    
    // Aggiorna il contenuto email solo se send_email è 1
    $orderState->email_content = $validatedData['send_email'] == 1 ? $validatedData['email_content'] : null;
    
    // Salva le modifiche
    $orderState->save();

    // Aggiorna o crea un nuovo StateLocalization
    $StateLocalization = StateLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'order_state_id' => $orderState->id]);
    $StateLocalization->name = $request->name;
    $StateLocalization->email_content = $validatedData['send_email'] == 1 ? $validatedData['email_content'] : null;
    $StateLocalization->save();

    // Redirect a una pagina con messaggio di successo
    flash(localize('Stato d\'ordine aggiornato con successo'))->success();
    return redirect()->route('admin.orderStates.index');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function delete($id)
    {
        $state = OrderState::findOrFail($id);
        $state->delete();
        flash(localize('Stato ordine eliminato con successo'))->success();
        return back();
    }

    public function updatePublishedStatus(Request $request)
    {
        $state = OrderState::findOrFail($request->id);
        $state->status = $request->status;
        if ($state->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePositions(Request $request)
    {
        
        try {
            foreach ($request->positions as $position => $id) {
                OrderState::find($id)->update(['position' => $position]);
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
