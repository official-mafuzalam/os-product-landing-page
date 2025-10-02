<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    //

    public function role()
    {
        $roles = Role::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    public function roleCreatePage()
    {

        return view('admin.role.create');

    }

    public function create(Request $request)
    {

        $validated = $request->validate(['name' => ['required', 'min:3']]);

        Role::create($validated);

        return to_route('admin.role');

        // echo "<pre>";
        // print_r($request->toArray());
    }

    public function roleEditPage($id)
    {

        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function roleUpdate(Request $request, $id)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        // Find the role by its ID
        $role = Role::findOrFail($id);

        $role->update($validated);

        // Redirect to a success page or return a response as needed
        return redirect()->route('admin.role')->with('success', 'Role updated successfully!');
    }

    public function givePermission(Request $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('success-trash', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);
        return back()->with('success', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('success-delete', 'Permission revoked.');
        }

        return back()->with('success-trash', 'Permission does not exist.');
    }











}