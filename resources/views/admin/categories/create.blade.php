<x-admin-layout>
    @section('title', $category->exists ? 'Edit Category' : 'Create Category')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $category->exists ? 'Edit Category' : 'Create New Category' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $category->exists ? 'Update category information' : 'Add a new product category' }}
                    </p>
                </div>

                <!-- Form -->
                <form
                    action="{{ $category->exists ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                    method="POST" enctype="multipart/form-data" class="px-6 py-4">
                    @csrf
                    @if ($category->exists)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic Information
                                </h3>

                                <div class="space-y-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category
                                            Name *</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $category->name) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Parent Category -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Parent Category
                                </h3>

                                <div>
                                    <label for="parent_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parent
                                        Category</label>
                                    <select id="parent_id" name="parent_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        <option value="">No Parent (Top Level)</option>
                                        @foreach ($parentCategories as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Image -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Category Image
                                    (Max size: 400 KB)
                                </h3>

                                <div class="space-y-4">
                                    <!-- Image Upload -->
                                    <div>
                                        <label for="image"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category
                                            Image (Recommended ratio 1:1)</label>
                                        <input type="file" id="image" name="image" accept="image/*"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('image')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @if ($category->image)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($category->image) }}" alt="Current image"
                                                    class="h-20 w-20 object-cover rounded-md">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>

                                <div class="flex items-center">
                                    <input type="checkbox" id="is_active" name="is_active" value="1"
                                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_active"
                                        class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Active Category
                                    </label>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $category->exists ? 'Update Category' : 'Create Category' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
