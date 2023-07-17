<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Hash;

class StaffsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:staffs'])->only('index');
        $this->middleware(['permission:add_staffs'])->only(['create', 'store']);
        $this->middleware(['permission:edit_staffs'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_staffs'])->only(['delete']);
    }

    # staff list
    public function index(Request $request)
    {
        $searchKey = null;
        $staffs = User::where('user_type', 'staff')->latest();
        if ($request->search != null) {
            $staffs = $staffs->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $staffs = $staffs->paginate(paginationNumber());
        return view('backend.pages.staffs.index', compact('staffs', 'searchKey'));
    }

    # return create form
    public function create()
    {
        $roles = Role::oldest()->get();
        return view('backend.pages.staffs.create', compact('roles'));
    }

    # save new staff
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first() == null) {
            $user             = new User;
            $user->name       = $request->name;
            $user->email      = $request->email;
            $user->shop_id    = auth()->user()->shop_id;
            $user->phone      = validatePhone($request->phone);
            $user->user_type  = "staff";
            $user->password   = Hash::make($request->password);
            $user->role_id    = $request->role_id;
            $user->save();
            $user->assignRole(Role::findOrFail($request->role_id)->name);

            flash(localize('Staff has been inserted successfully'))->success();
            return redirect()->route('admin.staffs.index');
        }
        flash(localize('Email already used'))->error();
        return back();
    }

    # edit staff
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::latest()->get();
        return view('backend.pages.staffs.edit', compact('user', 'roles'));
    }

    # update staff 
    public function update(Request $request)
    {
        $user             = User::findOrFail($request->id);
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->phone      = validatePhone($request->phone);
        $user->role_id    = $request->role_id;

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->assignRole(Role::findOrFail($request->role_id)->name);

        flash(localize('Staff has been updated successfully'))->success();
        return redirect()->route('admin.staffs.index');
    }

    # delete staff  
    public function delete($id)
    {
        User::destroy($id);
        flash(localize('Staff has been deleted successfully'))->success();
        return redirect()->route('admin.staffs.index');
    }
}
