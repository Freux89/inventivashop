<?php

namespace App\Http\Controllers\Backend\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:roles_and_permissions'])->only('index');
        $this->middleware(['permission:add_roles_and_permissions'])->only(['create', 'store']);
        $this->middleware(['permission:edit_roles_and_permissions'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_roles_and_permissions'])->only(['delete']);
    }

    # role list
    public function index(Request $request)
    {
        $searchKey = null;
        $roles = Role::oldest();
        if ($request->search != null) {
            $roles = $roles->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $roles = $roles->paginate(paginationNumber());
        return view('backend.pages.roles.index', compact('roles', 'searchKey'));
    }

    # return view of create form
    public function create()
    {
        $permission_groups = Permission::all()->groupBy('group_name');
        return view('backend.pages.roles.create', compact('permission_groups'));
    }

    # role store
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        flash(localize('New Role has been added successfully'))->success();
        return redirect()->route('admin.roles.index');
    }

    # edit role
    public function edit(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permission_groups = Permission::all()->groupBy('group_name');
        return view('backend.pages.roles.edit', compact('role', 'permission_groups'));
    }

    # update role
    public function update(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        $role->save();
        flash(localize('Role has been updated successfully'))->success();
        return back();
    }

    # delete role
    public function delete($id)
    {
        Role::destroy($id);
        flash(localize('Role has been deleted successfully'))->success();
        return redirect()->route('admin.roles.index');
    }
}
