<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Torna true per abilitare l'uso di questa request
        // Puoi inserire logica di autorizzazione qui, per esempio:
        // return auth()->user()->can('create', Menu::class);
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'is_primary' => 'sometimes|boolean',
        ];
    }
}
