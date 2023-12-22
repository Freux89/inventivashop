<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Hash;

class AddressController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:ban_customers'])->only(['updateBanStatus']);
    }

    # customer list



    # edit update and delete
    public function edit($id)
    {
        $address = UserAddress::findOrFail($id);
        $countries      = Country::isActive()->get();
        $states         = State::isActive()->where('country_id', $address->country_id)->get();
        return view('backend.pages.address.edit', compact('address', 'countries', 'states'));
    }

    # update customer

    public function update(Request $request, $id)
{
    // Recupera l'indirizzo corrente
    $address = UserAddress::findOrFail($id);
    $userId = $address->user_id;
    // Definisce le regole di base per la validazione
    $rules = [
        'address_name' => 'required',
        'first_name'   => 'required',
        'last_name'    => 'required',
        'phone'        => 'sometimes|nullable',
        'country_id'   => 'required',
        'state_id'     => 'required',
        'city'         => 'required',
        'address'      => 'required',
        'postal_code'  => 'required',
        'document_type'=> 'required|in:0,1,2',
    ];

    // Aggiunge regole condizionali in base al tipo di documento selezionato
    switch ($request->document_type) {
        case '1': // Ricevuta
            $rules['fiscal_code'] = 'required'; // Solo Codice fiscale è obbligatorio
            break;
        case '2': // Fattura
            // Tutti i campi sono obbligatori per la Fattura
            $rules = array_merge($rules, [
                'company_name'   => 'required',
                'vat_id'         => 'required',
                'fiscal_code'    => 'required',
                'pec'            => 'required',
                'exchange_code'  => 'required',
            ]);
            break;
    }

    // Esegue la validazione
    $validatedData = $request->validate($rules);

    // Aggiorna l'indirizzo con i dati validati
    $address->update($validatedData);

    // Redireziona o restituisci una risposta in base al successo dell'aggiornamento
    flash(localize('Indirizzo aggiornato con successo'))->success();
    return redirect()->route('admin.customers.edit', ['id' => $userId]);

}



    # delete customer

    public function delete($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();
        flash(localize('Cliente eliminato con successo'))->success();
        return back();
    }


    # update status 
    public function updateBanStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_banned = $request->status;
        if ($user->save()) {
            return 1;
        }
        return 0;
    }

    public function getStates(Request $request)
    {
        $countryId = $request->input('country_id');
        $states = State::isActive()->where('country_id', $countryId)->get();
        return response()->json($states);
    }
}
