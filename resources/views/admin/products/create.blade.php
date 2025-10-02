<x-admin-layout>
    @section('title', $product->exists ? 'Edit Product' : 'Create Product')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $product->exists ? 'Edit Product' : 'Create New Product' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $product->exists ? 'Update product information' : 'Add a new product to your inventory' }}
                    </p>
                </div>

                <!-- Form -->
                <form
                    action="{{ $product->exists ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                    method="POST" enctype="multipart/form-data" class="px-6 py-4">
                    @csrf
                    @if ($product->exists)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic Information
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product
                                            Name *</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $product->name) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="sku"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU
                                            *</label>
                                        <input type="text" id="sku" name="sku"
                                            value="{{ old('sku', $product->sku) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('sku')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Description *
                                        </label>
                                        <div class="flex items-center mb-1">
                                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">AI-generate
                                                from product name</span>
                                            <button type="button" id="generate-description"
                                                class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 py-1 px-2 rounded-md transition-colors">
                                                Generate Description
                                            </button>
                                        </div>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Product Images
                                    (Max size per photo: 400 KB)
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="image_gallery"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product
                                            Images (Recommended ratio 4:3)</label>
                                        <input type="file" id="image_gallery" name="image_gallery[]" multiple
                                            accept="image/*"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('image_gallery')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @if ($product->images->count() > 0)
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @foreach ($product->images as $image)
                                                    <div class="relative">
                                                        <img src="{{ Storage::url($image->image_path) }}"
                                                            alt="Gallery image"
                                                            class="h-16 w-16 object-cover rounded-md">
                                                        @if ($image->is_primary)
                                                            <span
                                                                class="absolute top-0 right-0 bg-blue-600 text-white text-xs px-1 rounded">Primary</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">


                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Pricing & Stock
                                </h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price
                                            *</label>
                                        <input type="number" id="price" name="price" step="0.01"
                                            min="0" value="{{ old('price', $product->price) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="discount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount</label>
                                        <input type="number" id="discount" name="discount" step="0.01"
                                            min="0" value="{{ old('discount', $product->discount) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('discount')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="buy_price"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buy
                                            Price</label>
                                        <input type="number" id="buy_price" name="buy_price" step="0.01"
                                            min="0" value="{{ old('buy_price', $product->buy_price) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('buy_price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="stock_quantity"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock
                                            Quantity *</label>
                                        <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('stock_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>

                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_active"
                                            class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Active Product
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_featured"
                                            class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Featured Product
                                        </label>
                                    </div>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('is_featured')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Specifications (JSON) -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Specifications</h3>
                        <div id="specifications-container" class="space-y-3">
                            <!-- Specifications will be added here dynamically -->
                        </div>
                        <button type="button" id="add-specification"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800">
                            Add Specification
                        </button>
                        <textarea id="specifications-json" name="specifications" class="hidden">{{ old('specifications', $product->specifications ? json_encode($product->specifications) : '{}') }}</textarea>
                        @error('specifications')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $product->exists ? 'Update Product' : 'Create Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Handle specifications
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('specifications-container');
                const jsonInput = document.getElementById('specifications-json');
                const addButton = document.getElementById('add-specification');

                // Load existing specifications
                let specifications = JSON.parse(jsonInput.value || '{}');
                renderSpecifications();

                addButton.addEventListener('click', function() {
                    const key = prompt('Enter specification key:');
                    if (key) {
                        const value = prompt('Enter specification value:');
                        if (value !== null) {
                            specifications[key] = value;
                            updateJsonInput();
                            renderSpecifications();
                        }
                    }
                });

                function renderSpecifications() {
                    container.innerHTML = '';
                    for (const [key, value] of Object.entries(specifications)) {
                        const div = document.createElement('div');
                        div.className = 'flex items-center space-x-2';
                        div.innerHTML = `
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">${key}:</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">${value}</span>
                            <button type="button" class="text-red-600 hover:text-red-800 text-sm" data-key="${key}">
                                Remove
                            </button>
                        `;
                        container.appendChild(div);
                    }

                    // Add event listeners to remove buttons
                    container.querySelectorAll('button').forEach(button => {
                        button.addEventListener('click', function() {
                            const key = this.getAttribute('data-key');
                            delete specifications[key];
                            updateJsonInput();
                            renderSpecifications();
                        });
                    });
                }

                function updateJsonInput() {
                    jsonInput.value = JSON.stringify(specifications);
                }
            });
        </script>

        <script>
            document.getElementById('generate-description').addEventListener('click', function() {
                const productName = document.getElementById('name').value;
                const descriptionField = document.getElementById('description');
                const generateButton = this;

                if (!productName) {
                    alert('Please enter a product name first');
                    return;
                }

                // Show loading state
                generateButton.innerHTML = 'Generating...';
                generateButton.disabled = true;

                // Make API request to your Laravel backend
                fetch('/generate-description', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_name: productName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.description) {
                            descriptionField.value = data.description;
                        } else {
                            alert('Failed to generate description');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while generating the description');
                    })
                    .finally(() => {
                        // Reset button state
                        generateButton.innerHTML = 'Generate Description';
                        generateButton.disabled = false;
                    });
            });
        </script>
    </x-slot>
</x-admin-layout>
