<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    # get states based on country
    public function getStates(Request $request)
    {
        $states = State::isActive()->where('country_id', $request->country_id)->get();
        $html = '<option value="">' . localize("Seleziona provincia") . '</option>';

        foreach ($states as $state) {
            $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }

        echo json_encode($html);
    }

    # get cities based on state
    

    # store new address
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
    
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
    
        flash(localize('Address has been inserted successfully'))->success();
        return back();
    }

    # edit address
    public function edit(Request $request)
    {
        $address  = UserAddress::where('user_id', auth()->user()->id)->where('id', $request->addressId)->first();
        $addressType = empty($address->address_name) ? 'billing' : 'shipping';
        $documentType = $address->document_type;
        if ($address) {
            $countries      = Country::isActive()->get();
            $states         = State::isActive()->where('country_id', $address->country_id)->get();
            return [
                'content' => getViewRender('inc.addressEditForm', [
                    'address' => $address,
                    'countries' => $countries,
                    'states' => $states
                ]),
                'addressType' => $addressType,
                'documentType' => $documentType
            ];
        }
    }

    # update address
    public function update(Request $request)
{
    $userId = auth()->user()->id;
    $address = UserAddress::where('user_id', $userId)->where('id', $request->id)->first();

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
         // Rimuovi il flag di default da altri indirizzi di fatturazione (privati)
         UserAddress::where('user_id', auth()->user()->id)
         ->where('document_type', 2) // Indirizzi di fatturazione privati
         ->update(['is_default' => false]);
    }
    $newAddress->is_default = 1;

    $newAddress->save();
    flash(localize('Address has been updated successfully'))->success();
    return back();
}

    # delete address

    public function delete($id)
    {
        $address = UserAddress::where('user_id', auth()->user()->id)->where('id', $id)->first();
        if ($address) {
            $address->delete();
            flash(localize('Address has been deleted successfully'))->success();
            return back();
        }
    }
}