<x-admin-layout>
    @section('title', 'Edit Permission - ' . $permission->name)
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <!-- Edit Permission Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Edit Permission</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Update permission details and role assignments
                        </p>
                    </div>

                    <form action="{{ route('admin.permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Permission Name Field -->
                        <div class="mb-6">
                            <label for="permission-name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Permission Name
                            </label>
                            <input id="permission-name" type="text" name="name" value="{{ $permission->name }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="e.g. edit-posts, delete-users">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        @can('edit')
                            <div class="flex justify-between">
                                <button type="button"
                                    class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                    onclick="window.location.href='{{ route('admin.permission') }}'">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Save Changes
                                </button>
                            </div>
                        @endcan
                    </form>
                </div>
            </div>

            <!-- Role Assignments Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Role Assignments</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Manage which roles have this permission
                        </p>
                    </div>

                    <!-- Current Role Assignments -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Currently Assigned Roles
                        </h3>
                        @if ($permission->roles->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach ($permission->roles as $role)
                                    <form method="POST"
                                        action="{{ route('admin.permissions.roles.revoke', [$permission->id, $role->id]) }}"
                                        onsubmit="return confirm('Are you sure you want to revoke this role assignment?');">
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">No roles currently assigned</p>
                        @endif
                    </div>

                    <!-- Assign New Role -->
                    <form method="POST" action="{{ route('admin.permissions.role', $permission->id) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="role"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Assign to Role
                                </label>
                                <select id="role" name="role"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Assign Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
