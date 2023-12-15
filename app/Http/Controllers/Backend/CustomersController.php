<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:ban_customers'])->only(['updateBanStatus']);
    }

    # customer list
    public function index(Request $request)
    {
        $searchKey = null;
        $is_banned = null;

        $customers = User::where('user_type', 'customer')->latest();
        if ($request->search != null) {
            $customers = $customers->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_banned != null) {
            $customers = $customers->where('is_banned', $request->is_banned);
            $is_banned    = $request->is_banned;
        }

        $customers = $customers->paginate(paginationNumber());
        return view('backend.pages.customers.index', compact('customers', 'searchKey', 'is_banned'));
    }


    # edit update and delete
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.pages.customers.edit', compact('user'));
    }

    # update customer

    public function update(Request $request, $id)
{
    // Validazione dei dati in input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'phone' => 'nullable|string|max:255',
        'password' => 'sometimes|nullable|string|min:8',
    ]);

    // Trova l'utente tramite ID
    $user = User::findOrFail($id);

    // Aggiorna i dati dell'utente
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // Aggiorna la password solo se fornita
    if ($request->filled('password')) {
        
        $user->password = Hash::make($request->password);
    }

    $user->save();
    
    // Qui puoi aggiungere la logica per gestire gli indirizzi se necessario
    // ...

    // Redirect con messaggio di successo
    flash(localize('Utente aggiornato con successo'))->success();
    return redirect()->route('admin.customers.index');
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
}
