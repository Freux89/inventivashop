<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
