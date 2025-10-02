<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function user()
    {
        $users = User::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.role', compact('user', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('success-trash', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('success', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('success-delete', 'Role removed.');
        }

        return back()->with('success', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('success-trash', 'Permission exists.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('success', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('success-delete', 'Permission revoked.');
        }
        return back()->with('success', 'Permission does not exists.');
    }

    public function passRegenerate(User $user)
    {
        // Set the user's password to the specified hash
        $user->password = Hash::make('password');

        // Save the user model to persist the change
        $user->save();

        // Optionally, return a success response or redirect
        return to_route('admin.user')->with(['success' => 'User password reset successfully!']);
    }

    public function block(User $user)
    {
        try {
            $this->authorize('block', $user);

            $user->update(['status' => 'blocked']);
            return back()->with('success', 'User has been blocked successfully.');

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return back()->with('success-delete', $e->getMessage());
        }
    }

    public function unblock(User $user)
    {
        try {
            $this->authorize('unblock', $user);

            $user->update(['status' => 'active']);
            return back()->with('success', 'User has been unblocked successfully.');

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return back()->with('success-delete', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        // Check if the user has any of the 'super_admin', 'admin', or 'agent' roles
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return back()->with('success-trash', 'This user cannot be deleted as they have an important role.');
        }

        // Proceed to delete the user if they don't have those roles
        $user->delete();

        return to_route('admin.user')->with('success', 'User deleted successfully.');
    }

}