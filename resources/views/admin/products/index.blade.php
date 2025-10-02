<x-admin-layout>
    @section('title', 'Products Management')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Header with breadcrumbs -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Products Management</h1>

                    <div>
                        {{-- <a href="{{ route('admin.products.trash') }}"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Trash
                        </a> --}}

                        <a href="{{ route('admin.products.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            {{-- <form id="bulk-action-form" method="POST" action="{{ route('admin.products.bulk-destroy') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="selected_products" id="selected-products-input">
                <div id="bulk-actions-container" class="hidden mb-4 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span id="selected-count" class="text-sm font-medium text-yellow-800">0 products selected</span>
                        </div>
                        <div>
                            <button type="button" id="cancel-bulk-action" class="mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="button" id="bulk-delete-btn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </form> --}}

            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Filters and Search -->
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search"
                                    class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" placeholder="Product name or SKU"
                                    value="{{ request('search') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
                                <div class="flex justify-between">
                                    <a href="{{ route('admin.products.index') }}"
                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                        Reset
                                    </a>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="select-all" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <label for="select-all" class="sr-only">Select all products</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                    onclick="sortTable(1)">
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
                                    Product
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                    onclick="sortTable(4)">
                                    <div class="flex items-center">
                                        Price
                                        <svg class="ml-1 w-3 h-3 text-gray-400 sort-icon" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" 
                                            class="product-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $product->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded-md object-cover"
                                                    src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                    {{ Str::limit($product->name, 30) }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    SKU: {{ $product->sku }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200"
                                            data-price="{{ $product->price - $product->discount }}">
                                            {{ number_format($product->price - $product->discount) }} TK
                                        </div>
                                        <div class="text-xs text-red-500 dark:text-red-400 line-through">
                                            {{ number_format($product->price) }} TK
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'inline-flex px-2 py-1 rounded-md text-xs font-medium',
                                            'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                $product->stock_quantity > 10,
                                            'bg-yellow-500/10 text-yellow-600 dark:text-yellow-400' =>
                                                $product->stock_quantity > 0 && $product->stock_quantity <= 10,
                                            'bg-red-500/10 text-red-600 dark:text-red-400' =>
                                                $product->stock_quantity == 0,
                                        ])>
                                            {{ $product->stock_quantity }} in stock
                                        </span>
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            <!-- Active Status Toggle -->
                                            <form action="{{ route('admin.products.toggle-status', $product) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex px-2 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors',
                                                        'bg-green-500/20 text-green-700 dark:text-green-300 hover:bg-green-500/30' =>
                                                            $product->is_active,
                                                        'bg-red-500/20 text-red-700 dark:text-red-300 hover:bg-red-500/30' => !$product->is_active,
                                                    ])>
                                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                        <svg class="w-3 h-3 ml-1 inline" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </form>

                                            <!-- Featured Status Toggle -->
                                            <form action="{{ route('admin.products.toggle-featured', $product) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex px-2 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors',
                                                        'bg-green-500/20 text-green-700 dark:text-green-300 hover:bg-green-500/30' =>
                                                            $product->is_featured,
                                                        'bg-red-500/20 text-red-700 dark:text-red-300 hover:bg-red-500/30' => !$product->is_featured,
                                                    ])>
                                                        {{ $product->is_featured ? 'Featured' : 'Not Featured' }}
                                                        <svg class="w-3 h-3 ml-1 inline" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.products.show', $product) }}"
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
                                            <a href="{{ route('admin.products.edit', $product) }}"
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
                                            <form action="{{ route('admin.products.destroy', $product) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20"
                                                    onclick="return confirm('Are you sure you want to trash this product?')"
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
                                    <td colspan="8"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div
                        class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700 dark:text-gray-400">
                            Showing <span class="font-medium">{{ $products->firstItem() }}</span> to <span
                                class="font-medium">{{ $products->lastItem() }}</span> of <span
                                class="font-medium">{{ $products->total() }}</span> results
                        </div>

                        <div class="flex gap-2">
                            <!-- Previous Button -->
                            @if ($products->onFirstPage())
                                <button disabled
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">
                                    Previous
                                </button>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    Previous
                                </a>
                            @endif

                            <!-- Next Button -->
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
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
            // Bulk selection functionality
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const productCheckboxes = document.querySelectorAll('.product-checkbox');
                const bulkActionsContainer = document.getElementById('bulk-actions-container');
                const selectedCountElement = document.getElementById('selected-count');
                const cancelBulkActionButton = document.getElementById('cancel-bulk-action');
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
                const bulkDeleteForm = document.getElementById('bulk-action-form');
                const selectedProductsInput = document.getElementById('selected-products-input');
                
                // Update the selected count and toggle bulk actions visibility
                function updateSelectedCount() {
                    const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
                    selectedCountElement.textContent = `${selectedCount} product${selectedCount !== 1 ? 's' : ''} selected`;
                    
                    if (selectedCount > 0) {
                        bulkActionsContainer.classList.remove('hidden');
                    } else {
                        bulkActionsContainer.classList.add('hidden');
                    }
                    
                    // Update select all checkbox state
                    selectAllCheckbox.checked = selectedCount === productCheckboxes.length && productCheckboxes.length > 0;
                    selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < productCheckboxes.length;
                }
                
                // Select all checkbox functionality
                selectAllCheckbox.addEventListener('change', function() {
                    productCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
                
                // Individual checkbox functionality
                productCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });
                
                // Cancel bulk action
                cancelBulkActionButton.addEventListener('click', function() {
                    productCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                    bulkActionsContainer.classList.add('hidden');
                });
                
                // Bulk delete button click
                bulkDeleteBtn.addEventListener('click', function() {
                    const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                        .map(checkbox => checkbox.value);
                    
                    if (selectedProducts.length === 0) {
                        alert('Please select at least one product to delete.');
                        return;
                    }
                    
                    if (!confirm(`Are you sure you want to delete ${selectedProducts.length} product${selectedProducts.length !== 1 ? 's' : ''}?`)) {
                        return;
                    }
                    
                    // Set the selected products in the hidden input
                    selectedProductsInput.value = JSON.stringify(selectedProducts);
                    
                    // Submit the form
                    bulkDeleteForm.submit();
                });
                
                // Initialize selected count
                updateSelectedCount();
            });
            
            // Table sorting functionality
            let sortDirection = 1; // 1 for ascending, -1 for descending
            let currentSortColumn = -1;

            function sortTable(columnIndex) {
                // Adjust column index for the checkbox column
                const actualColumnIndex = columnIndex + 1;
                
                const tableBody = document.querySelector('tbody');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const sortIcons = document.querySelectorAll('.sort-icon');

                // Toggle sort direction if clicking the same column
                if (currentSortColumn === actualColumnIndex) {
                    sortDirection *= -1;
                } else {
                    currentSortColumn = actualColumnIndex;
                    sortDirection = 1;
                }

                rows.sort((a, b) => {
                    let aValue, bValue;

                    if (actualColumnIndex === 1) { // For ID (numeric sorting)
                        aValue = parseInt(a.cells[actualColumnIndex].textContent.trim());
                        bValue = parseInt(b.cells[actualColumnIndex].textContent.trim());
                        return (aValue - bValue) * sortDirection;
                    } else if (actualColumnIndex === 4) { // For Price (numeric sorting)
                        // Use the data-price attribute which contains the numeric value without formatting
                        aValue = parseFloat(a.cells[actualColumnIndex].querySelector('[data-price]').dataset.price);
                        bValue = parseFloat(b.cells[actualColumnIndex].querySelector('[data-price]').dataset.price);
                        return (aValue - bValue) * sortDirection;
                    } else { // For other columns (string sorting)
                        aValue = a.cells[actualColumnIndex].textContent.trim();
                        bValue = b.cells[actualColumnIndex].textContent.trim();
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

                const activeIcon = document.querySelector(`thead th:nth-child(${actualColumnIndex + 1}) .sort-icon`);
                if (activeIcon) {
                    activeIcon.classList.remove('text-gray-400');
                    activeIcon.classList.add('text-blue-500');
                    if (sortDirection === -1) {
                        activeIcon.classList.add('rotate-180');
                    }
                }
                
                // Update checkbox states after sorting
                document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        document.dispatchEvent(new Event('DOMContentLoaded'));
                    });
                });
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