<x-admin-layout>
    @section('title', 'User Edit - ' . $user->name)
    <x-slot name="main">    
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <!-- User Information Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">User Role Permissions</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Manage roles and permissions for {{ $user->name }}
                        </p>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- User Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name
                                </label>
                                <input id="name" type="text" name="name" value="{{ $user->name }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input id="email" type="email" name="email" value="{{ $user->email }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        @can('user_edit')
                            <div class="flex justify-end gap-3 pt-4">
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Update Profile
                                </button>
                            </div>
                        @endcan
                    </form>

                    <!-- Password Regenerate Button -->
                    <div class="mt-6 flex flex-wrap justify-between gap-4">
                        <!-- Back Button -->
                        <a href="{{ route('admin.user') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                            ← Back to Users
                        </a>

                        <div class="flex flex-wrap items-center gap-4">
                            <!-- Block/Unblock Button -->
                            @can('block', $user)
                                <form
                                    action="{{ $user->status === 'active' ? route('users.block', $user) : route('users.unblock', $user) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $user->status === 'active' ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-150">
                                        {{ $user->status === 'active' ? 'Block User' : 'Unblock User' }}
                                    </button>
                                </form>
                            @else
                                <div class="flex justify-between items-center">
                                    <button disabled
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-400 cursor-not-allowed">
                                        {{ $user->status === 'active' ? 'Block User' : 'Unblock User' }}
                                    </button>
                                    <span class="text-xs text-gray-500 mt-1">
                                        @if (auth()->user()->id === $user->id)
                                            Cannot block your own account
                                        @elseif($user->hasRole('super_admin'))
                                            Super admin cannot be blocked
                                        @else
                                            No permission to block users
                                        @endif
                                    </span>
                                </div>
                            @endcan

                            <!-- Password Regenerate Button -->
                            <form action="{{ route('admin.users.passRegenerate', $user->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to regenerate this user\'s password?');"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                    Password Regenerate
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Roles Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">User Roles</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Manage role assignments for this user
                        </p>
                    </div>

                    <!-- Current Roles -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Current Roles</h3>
                        @if ($user->roles->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach ($user->roles as $role)
                                    <form method="POST"
                                        action="{{ route('admin.users.roles.remove', [$user->id, $role->id]) }}"
                                        onsubmit="return confirm('Are you sure you want to remove this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 transition-colors">
                                            {{ $role->name }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No roles assigned</p>
                        @endif
                    </div>

                    <!-- Assign New Role -->
                    <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="role"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Assign New Role
                                </label>
                                <select id="role" name="role"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @can('user_assign_role')
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        Assign Role
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Permissions Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">User Permissions</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Manage direct permission assignments for this user
                        </p>
                    </div>

                    <!-- Current Permissions -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Current Permissions</h3>
                        @if ($user->permissions->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach ($user->permissions as $permission)
                                    <form method="POST"
                                        action="{{ route('admin.users.permissions.revoke', [$user->id, $permission->id]) }}"
                                        onsubmit="return confirm('Are you sure you want to revoke this permission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 transition-colors">
                                            {{ $permission->name }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No direct permissions assigned</p>
                        @endif
                    </div>

                    <!-- Assign New Permission -->
                    <form method="POST" action="{{ route('admin.users.permissions', $user->id) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="permission"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Assign New Permission
                                </label>
                                <select id="permission" name="permission"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @can('user_assign_permission')
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        Assign Permission
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
