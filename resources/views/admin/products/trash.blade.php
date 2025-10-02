<x-admin-layout>
    @section('title', 'Products Management')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Header with breadcrumbs -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Trashed Products Management</h1>

                    <div>
                        <a href="{{ route('admin.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <form id="bulk-action-form" method="POST" action="{{ route('admin.products.bulk-force-delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="selected_products" id="selected-products-input">
                <div id="bulk-actions-container" class="hidden mb-4 bg-red-50 p-4 rounded-lg border border-red-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span id="selected-count" class="text-sm font-medium text-red-800">0 products
                                selected</span>
                        </div>
                        <div>
                            <button type="button" id="cancel-bulk-action"
                                class="mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                Cancel
                            </button>
                            {{-- <button type="button" id="bulk-restore-btn"
                                class="mr-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Restore Selected
                            </button> --}}
                            <button type="button" id="bulk-delete-btn"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete Selected Permanently
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Filters and Search -->
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <form method="GET" action="{{ route('admin.products.trash') }}">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label for="search"
                                    class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" placeholder="Product name or SKU"
                                    value="{{ request('search') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <select name="brand" id="brand"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Brands</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                    <a href="{{ route('admin.products.trash') }}"
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
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="select-all"
                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
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
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Category/Brand
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
                                    Deleted At
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
                                        <input type="checkbox" name="selected_products[]"
                                            value="{{ $product->id }}"
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
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ $product->category->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $product->brand->name }}
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

                                    <!-- Deleted At Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-200">
                                            {{ $product->deleted_at ? $product->deleted_at->format('Y-m-d H:i A') : 'N/A' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Restore -->
                                            <form action="{{ route('admin.products.restore', $product->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 transition-colors p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20"
                                                    onclick="return confirm('Restore this product?')" title="Restore">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M3 10h4l3 10 4-18 3 8h4" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Permanently Delete -->
                                            <form action="{{ route('admin.products.force-delete', $product->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20"
                                                    onclick="return confirm('This will permanently delete the product. Are you sure?')"
                                                    title="Delete Permanently">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                const bulkRestoreBtn = document.getElementById('bulk-restore-btn');
                const bulkDeleteForm = document.getElementById('bulk-action-form');
                const selectedProductsInput = document.getElementById('selected-products-input');

                // Update the selected count and toggle bulk actions visibility
                function updateSelectedCount() {
                    const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
                    selectedCountElement.textContent =
                        `${selectedCount} product${selectedCount !== 1 ? 's' : ''} selected`;

                    if (selectedCount > 0) {
                        bulkActionsContainer.classList.remove('hidden');
                    } else {
                        bulkActionsContainer.classList.add('hidden');
                    }

                    // Update select all checkbox state
                    selectAllCheckbox.checked = selectedCount === productCheckboxes.length && productCheckboxes.length >
                        0;
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

                    if (!confirm(
                            `Are you sure you want to PERMANENTLY delete ${selectedProducts.length} product${selectedProducts.length !== 1 ? 's' : ''}? This action cannot be undone.`
                            )) {
                        return;
                    }

                    // Set the selected products in the hidden input
                    selectedProductsInput.value = JSON.stringify(selectedProducts);

                    // Set form action for permanent deletion
                    bulkDeleteForm.action = "{{ route('admin.products.bulk-force-delete') }}";

                    // Submit the form
                    bulkDeleteForm.submit();
                });

                // Bulk restore button click
                bulkRestoreBtn.addEventListener('click', function() {
                    const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                        .map(checkbox => checkbox.value);

                    if (selectedProducts.length === 0) {
                        alert('Please select at least one product to restore.');
                        return;
                    }

                    if (!confirm(
                            `Are you sure you want to restore ${selectedProducts.length} product${selectedProducts.length !== 1 ? 's' : ''}?`
                            )) {
                        return;
                    }

                    // Set the selected products in the hidden input
                    selectedProductsInput.value = JSON.stringify(selectedProducts);

                    // Change form method to POST for restoration
                    bulkDeleteForm.method = "POST";
                    bulkDeleteForm.action = "{{ route('admin.products.bulk-restore') }}";

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