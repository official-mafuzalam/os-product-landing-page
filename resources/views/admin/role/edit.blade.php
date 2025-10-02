<x-admin-layout>
    @section('title', 'Edit Role - ' . $role->name)
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <!-- Edit Role Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Edit Role</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Update role information and permissions
                        </p>
                    </div>

                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name Field -->
                        <div class="mb-6">
                            <label for="role-name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Role Name
                            </label>
                            <input id="role-name" type="text" name="name" value="{{ $role->name }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="e.g. admin">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between">
                            <button type="button"
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                onclick="window.location.href='{{ route('admin.role') }}'">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Permissions Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Role Permissions</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Manage permissions assigned to this role
                        </p>
                    </div>

                    <!-- Current Permissions -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Current Permissions</h3>
                        @if ($role->permissions->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach ($role->permissions as $permission)
                                    <form method="POST"
                                        action="{{ route('admin.role.permissions.revoke', [$role->id, $permission->id]) }}"
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">No permissions assigned</p>
                        @endif
                    </div>

                    <!-- Assign New Permission -->
                    <form method="POST" action="{{ route('admin.role.permissions', $role->id) }}">
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

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Assign Permission
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
