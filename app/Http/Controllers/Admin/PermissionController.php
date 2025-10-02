<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //

    public function permission()
    {
        $permission = Permission::paginate(10);

        return view('admin.permission.index', compact('permission'));
    }


    public function permissionCreatePage()
    {

        return view('admin.permission.create');
    }

    public function permissionCreate(Request $request)
    {
        $validated = $request->validate(['name' => ['required']]);

        Permission::create($validated);

        return to_route('admin.permission');
    }

    public function permissionEditPage($id)
    {
        $roles = Role::all();

        $permission = Permission::findOrFail($id);

        return view('admin.permission.edit', compact('permission', 'roles'));

        // echo "<pre>";
        // print_r($request->toArray());
    }

    public function permissionUpdate(Request $request, $id)
    {
        $validated = $request->validate(['name' => ['required']]);
        // Find the permission by its ID
        $permission = Permission::findOrFail($id);

        $permission->update($validated);

        // Redirect to a success page or return a response as needed
        return redirect()->route('admin.permission')->with('success', 'Permission updated successfully!');
    }

    public function givePermission(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }


    public function checkPer()
    {
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name');
        // return view('your.view', compact('userPermissions'));

        echo "<pre>";
        print_r($userPermissions->toArray());

    }









}