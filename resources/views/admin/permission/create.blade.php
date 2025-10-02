<x-admin-layout>
    @section('title', 'Create Permission')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header Section -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            Create New Permission
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Define a new system permission and its capabilities
                        </p>
                    </div>

                    <!-- Permission Creation Form -->
                    <form action="{{ route('admin.permission.create') }}" method="POST">
                        @csrf

                        <!-- Permission Name Field -->
                        <div class="mb-6">
                            <label for="permission-name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Permission Name
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input id="permission-name" type="text" name="name"
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="e.g. edit_posts, delete_users" required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Use lowercase with underscore (e.g. "edit_users", "delete_posts")
                            </p>
                        </div>

                        <!-- Submit & Cancel Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.permission') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Create Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
