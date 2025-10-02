<x-admin-layout>
    @section('title', $category->name)
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Category Details
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            Edit Category
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-3 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Back to Categories
                        </a>
                    </div>
                </div>

                <!-- Category Details -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column - Image -->
                        <div class="md:col-span-1">
                            @if ($category->image)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-64 object-cover">
                                </div>
                            @else
                                <div
                                    class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden h-64 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column - Details -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic
                                        Information</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $category->name }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $category->slug }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->description ?? 'No description' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Relationships -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Relationships
                                    </h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Parent
                                                Category</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->parent ? $category->parent->name : 'None (Top Level)' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                Subcategories</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->children_count }} subcategories
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Products
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->products_count }} products
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Status -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                        $category->is_active,
                                                    'bg-red-500/10 text-red-600 dark:text-red-400' => !$category->is_active,
                                                ])>
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->created_at->format('M d, Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last
                                                Updated</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $category->updated_at->format('M d, Y') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subcategories Section -->
                    @if ($category->children->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Subcategories</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($category->children as $subcategory)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-800 dark:text-gray-200">
                                            {{ $subcategory->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $subcategory->products_count }} products
                                        </p>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.categories.show', $subcategory->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>