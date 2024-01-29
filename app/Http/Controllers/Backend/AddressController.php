<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
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

    public function create($id, $type)
    {
        $user_id = $id;
        $countries      = Country::isActive()->get();
        $states         = State::isActive()->get();
        if (!in_array($type, ['shipping', 'billing'])) {
            // Gestisci il caso in cui il tipo non sia valido
            abort(404); // O reindirizza con un messaggio di errore
        }

        return view('backend.pages.address.create', compact('user_id', 'countries', 'states', 'type'));
    }


    public function store(Request $request, $id)
    {

        // Verifica che l'ID utente esista
        $userId = User::findOrFail($id)->id;

        // Differenzia la validazione in base al tipo di indirizzo
        $rules = [
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            // Aggiungi qui altre regole di validazione comuni
        ];

        if ($request->filled('address_name')) {
            // Aggiungi regole specifiche per l'indirizzo di spedizione
            $rules['address_name'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['phone'] = 'required';
        } else {
            // Aggiungi regole specifiche per l'indirizzo di fatturazione
            $billingType = $request->input('billing_type', 'company'); // Predefinito a 'company'
            if ($billingType == 'company') {
                $rules = array_merge($rules, [
                    'company_name' => 'required',
                    'vat_id' => 'required',
                    // Custom validation for sdi_code and pec
                    'sdi_code' => [
                        'required_without:pec',
                        'nullable'
                    ],
                    'pec' => [
                        'required_without:sdi_code',
                        'nullable'
                    ],
                ]);
            } else {
                $rules = array_merge($rules, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'fiscal_code' => 'required',
                ]);
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Crea un nuovo indirizzo
        $address = new UserAddress;
        $address->is_default = 0;
        $address->user_id = $userId;
        $address->country_id = $request->country_id;
        $address->state_id = $request->state_id;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->postal_code = $request->postal_code;

        if ($request->filled('address_name')) {
            // Imposta i campi specifici per l'indirizzo di spedizione
            $address->address_name = $request->address_name;
            $address->first_name = $request->first_name;
            $address->last_name = $request->last_name;
            $address->phone = $request->phone;
            $address->document_type = 0;
        } else {
            // Imposta i campi specifici per l'indirizzo di fatturazione
            if ($billingType == 'company') {
                $address->company_name = $request->company_name;
                $address->vat_id = $request->vat_id;
                $address->sdi_code = $request->sdi_code;
                $address->pec = $request->pec;
                $address->document_type = 1;
            } else {
                $address->first_name = $request->first_name;
                $address->last_name = $request->last_name;
                $address->fiscal_code = $request->fiscal_code;
                $address->document_type = 2;
            }
        }

        // Gestisci l'indirizzo predefinito
        if ($request->is_default == '1') {
            UserAddress::where('user_id', $userId)->where('is_default', 1)->update(['is_default' => 0]);
        }
        $address->is_default = $request->has('is_default') ? $request->is_default : 0;

        $address->save();

        // Redireziona o restituisci una risposta in base al successo della creazione
        flash(localize('Indirizzo creato con successo'))->success();
        return redirect()->route('admin.customers.edit', ['id' => $id]);
    }



    # edit update and delete
    public function edit($id, $type)
    {
        $address = UserAddress::findOrFail($id);
        $countries      = Country::isActive()->get();
        $states         = State::isActive()->where('country_id', $address->country_id)->get();
        if (!in_array($type, ['shipping', 'billing'])) {
            // Gestisci il caso in cui il tipo non sia valido
            abort(404); // O reindirizza con un messaggio di errore
        }

        return view('backend.pages.address.edit', compact('address', 'countries', 'states', 'type'));
    }

    # update customer

    public function update(Request $request, $id)
    {
        // Recupera l'indirizzo corrente
        $address = UserAddress::findOrFail($id);
        $userId = $address->user_id;

        $rules = [
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            // Aggiungi qui altre regole di validazione comuni
        ];

        if ($request->filled('address_name')) {
            // Aggiungi regole specifiche per l'indirizzo di spedizione
            $rules['address_name'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['phone'] = 'required';
        } else {
            // Aggiungi regole specifiche per l'indirizzo di fatturazione
            $billingType = $request->input('billing_type', 'company'); // Predefinito a 'company'
            if ($billingType == 'company') {
                $rules = array_merge($rules, [
                    'company_name' => 'required',
                    'vat_id' => 'required',
                    'sdi_code' => [
                        'required_without:pec',
                        'nullable'
                    ],
                    'pec' => [
                        'required_without:sdi_code',
                        'nullable'
                    ],
                ]);
            } else {
                $rules = array_merge($rules, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'fiscal_code' => 'required',
                ]);
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Duplica l'indirizzo e applica soft delete all'originale
        $newAddress = $address->replicate();
        $address->delete(); // Soft delete dell'indirizzo originale

        // Aggiorna i campi del nuovo indirizzo (stessi campi del metodo store)
        $newAddress->fill($request->only(['country_id', 'state_id', 'city', 'address', 'postal_code']));

        if ($request->filled('address_name')) {
            // Imposta campi specifici per l'indirizzo di spedizione
            $newAddress->address_name = $request->address_name;
            $newAddress->first_name = $request->first_name;
            $newAddress->last_name = $request->last_name;
            $newAddress->phone = $request->phone;
            $newAddress->document_type = 0;
        } else {
            // Imposta campi specifici per l'indirizzo di fatturazione
            if ($request->billing_type == 'company') {
                $newAddress->company_name = $request->company_name;
                $newAddress->vat_id = $request->vat_id;
                $newAddress->sdi_code = $request->sdi_code;
                $newAddress->pec = $request->pec;
                $newAddress->document_type = 1;
            } else {
                $newAddress->first_name = $request->first_name;
                $newAddress->last_name = $request->last_name;
                $newAddress->fiscal_code = $request->fiscal_code;
                $newAddress->document_type = 2;
            }
        }

        // Gestione dell'indirizzo predefinito
        if ($request->is_default == '1') {
            UserAddress::where('user_id', $userId)->where('is_default', 1)->update(['is_default' => 0]);
            $newAddress->is_default = 1;
        } else {
            $newAddress->is_default = 0;
        }

        $newAddress->save();

        // Redireziona o restituisci una risposta in base al successo dell'aggiornamento
        flash(localize('Indirizzo aggiornato con successo'))->success();
        return redirect()->route('admin.customers.edit', ['id' => $userId]);
    }



    # delete customer

    public function delete($id)
    {
        $address = UserAddress::findOrFail($id);
        $address->delete();
        flash(localize('Indirizzo eliminato con successo'))->success();
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
