<x-admin-layout>
    @section('title', 'Create Role')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header Section -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            Create New Role
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Define a new role and its permissions
                        </p>
                    </div>

                    <!-- Role Creation Form -->
                    <form action="{{ route('admin.role.create') }}" method="POST">
                        @csrf

                        <!-- Role Name Field -->
                        <div class="mb-6">
                            <label for="role-name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Role Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input id="role-name" type="text" name="name"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="e.g. admin, editor, viewer" required>

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.role') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
