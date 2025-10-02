<x-admin-layout>
    @section('title', 'Categories Management')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div
                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Categories Management</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Organize products into categories
                        </p>
                    </div>

                    <!-- Search and Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <!-- Search Form -->
                        <form action="{{ route('admin.categories.index') }}" class="w-full sm:w-64">
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" name="search" placeholder="Search categories..."
                                    class="block w-full rounded-md border-gray-300 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                <button type="submit"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.create') }}"
                                class="px-3 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Category
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                    onclick="sortTable(0)">
                                    <div class="flex items-center">
                                        ID
                                        <svg class="ml-1 w-3 h-3 text-gray-400 sort-icon" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Parent
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Products
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $category->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($category->image)
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-md object-cover"
                                                        src="{{ Storage::url($category->image) }}"
                                                        alt="{{ $category->name }}">
                                                </div>
                                            @endif
                                            <div class="{{ $category->image ? 'ml-4' : '' }}">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                    {{ $category->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $category->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $category->parent ? $category->parent->name : '—' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $category->products_count }} products
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'px-2 py-1 rounded-md text-xs font-medium',
                                            'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                $category->is_active,
                                            'bg-red-500/10 text-red-600 dark:text-red-400' => !$category->is_active,
                                        ])>
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.categories.show', $category) }}"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900/20"
                                                title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20"
                                                    onclick="return confirm('Are you sure you want to trash this category?')"
                                                    title="Trash">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No categories found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div
                        class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700 dark:text-gray-400">
                            Showing <span class="font-medium">{{ $categories->firstItem() }}</span> to <span
                                class="font-medium">{{ $categories->lastItem() }}</span> of <span
                                class="font-medium">{{ $categories->total() }}</span> results
                        </div>

                        <div class="flex gap-2">
                            <!-- Previous Button -->
                            @if ($categories->onFirstPage())
                                <button disabled
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">
                                    Previous
                                </button>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    Previous
                                </a>
                            @endif

                            <!-- Next Button -->
                            @if ($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    Next
                                </a>
                            @else
                                <button disabled
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">
                                    Next
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script>
            let sortDirection = 1; // 1 for ascending, -1 for descending
            let currentSortColumn = -1;

            function sortTable(columnIndex) {
                const tableBody = document.querySelector('tbody');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const sortIcons = document.querySelectorAll('.sort-icon');

                // Toggle sort direction if clicking the same column
                if (currentSortColumn === columnIndex) {
                    sortDirection *= -1;
                } else {
                    currentSortColumn = columnIndex;
                    sortDirection = 1;
                }

                rows.sort((a, b) => {
                    const aValue = a.cells[columnIndex].textContent.trim();
                    const bValue = b.cells[columnIndex].textContent.trim();

                    if (columnIndex === 0) { // For ID (numeric sorting)
                        return (parseInt(aValue) - parseInt(bValue)) * sortDirection;
                    } else { // For other columns (string sorting)
                        return aValue.localeCompare(bValue) * sortDirection;
                    }
                });

                // Clear the table body
                while (tableBody.firstChild) {
                    tableBody.removeChild(tableBody.firstChild);
                }

                // Re-add the sorted rows
                rows.forEach(row => tableBody.appendChild(row));

                // Update sort indicators
                sortIcons.forEach(icon => {
                    icon.classList.remove('text-blue-500', 'rotate-180');
                    icon.classList.add('text-gray-400');
                });

                const activeIcon = document.querySelector(`thead th:nth-child(${columnIndex + 1}) .sort-icon`);
                if (activeIcon) {
                    activeIcon.classList.remove('text-gray-400');
                    activeIcon.classList.add('text-blue-500');
                    if (sortDirection === -1) {
                        activeIcon.classList.add('rotate-180');
                    }
                }
            }
        </script>

        <style>
            .rotate-180 {
                transform: rotate(180deg);
                transition: transform 0.2s ease;
            }
        </style>
    </x-slot>
</x-admin-layout>
