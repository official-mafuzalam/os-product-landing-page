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
                                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Auto-generate
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
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Categories &
                                    Brands</h3>

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="category_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category
                                            *</label>
                                        <select id="category_id" name="category_id"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
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

                    <!-- Product Attributes Section -->
                    <div id="attributes-container" class="space-y-4">
                        @if ($product->exists && isset($groupedAttributes) && $groupedAttributes->count() > 0)
                            @foreach ($groupedAttributes as $index => $attribute)
                                <div
                                    class="attribute-row flex items-end space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Attribute
                                        </label>
                                        <select name="product_attributes[{{ $index }}][id]"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                               dark:bg-gray-600 dark:border-gray-500 dark:text-white py-2 px-3"
                                            required>
                                            <option value="">Select Attribute</option>
                                            @foreach ($allAttributes as $attr)
                                                <option value="{{ $attr->id }}"
                                                    {{ $attribute['id'] == $attr->id ? 'selected' : '' }}>
                                                    {{ $attr->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Values</label>
                                        <div class="tag-input w-full flex flex-wrap items-center rounded-md border border-gray-300
                                dark:border-gray-500 bg-white dark:bg-gray-600 px-2 py-1 cursor-text"
                                            data-name="product_attributes[{{ $index }}][values]">
                                            @foreach ($attribute['values'] as $val)
                                                <span
                                                    class="tag bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-sm mr-2 mb-1 flex items-center">
                                                    {{ trim($val) }}
                                                    <button type="button"
                                                        class="remove-tag ml-1 text-red-600 hover:text-red-800">×</button>
                                                    <input type="hidden"
                                                        name="product_attributes[{{ $index }}][values][]"
                                                        value="{{ trim($val) }}">
                                                </span>
                                            @endforeach
                                            <input type="text"
                                                class="tag-input-field flex-1 bg-transparent border-none focus:ring-0 focus:outline-none dark:text-white"
                                                placeholder="Type and press Enter">
                                        </div>
                                    </div>

                                    <div>
                                        <button type="button"
                                            class="remove-attribute text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200
                               px-3 py-2 rounded-md transition-colors">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <button type="button" id="add-attribute"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add Attribute
                        </button>
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
            // Handle dynamic addition/removal of product attributes
            document.addEventListener('DOMContentLoaded', function() {
                const attributesContainer = document.getElementById('attributes-container');
                const addAttributeBtn = document.getElementById('add-attribute');
                let attributeCount = {{ $product->exists ? $product->attributes->count() : 0 }};

                function initTagInput(container) {
                    const input = container.querySelector('.tag-input-field');

                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ',') {
                            e.preventDefault();
                            const value = input.value.trim();
                            if (value !== '') {
                                addTag(container, value);
                                input.value = '';
                            }
                        }
                    });
                }

                function addTag(container, value) {
                    const name = container.dataset.name;

                    const tag = document.createElement('span');
                    tag.className =
                        "tag bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-sm mr-2 mb-1 flex items-center";
                    tag.innerHTML = `
            ${value}
            <button type="button" class="remove-tag ml-1 text-red-600 hover:text-red-800">×</button>
            <input type="hidden" name="${name}[]" value="${value}">
        `;

                    const input = container.querySelector('.tag-input-field');
                    container.insertBefore(tag, input);

                    // remove event
                    tag.querySelector('.remove-tag').addEventListener('click', () => tag.remove());
                }

                // Initialize existing tag inputs
                document.querySelectorAll('.tag-input').forEach(initTagInput);

                // Add new attribute row
                addAttributeBtn.addEventListener('click', function() {
                    const attributeRow = document.createElement('div');
                    attributeRow.className =
                        'attribute-row flex items-end space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-md';
                    attributeRow.innerHTML = `
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Attribute</label>
                <select name="product_attributes[${attributeCount}][id]"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white py-2 px-3" required>
                    <option value="">Select Attribute</option>
                    @foreach ($allAttributes as $attribute)
                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Values</label>
                <div class="tag-input w-full flex flex-wrap items-center rounded-md border border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-600 px-2 py-1 cursor-text"
                     data-name="product_attributes[${attributeCount}][values]">
                    <input type="text"
                           class="tag-input-field flex-1 bg-transparent border-none focus:ring-0 focus:outline-none dark:text-white"
                           placeholder="Type and press Enter">
                </div>
            </div>
            <div>
                <button type="button" class="remove-attribute text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 px-3 py-2 rounded-md transition-colors">
                    Remove
                </button>
            </div>
        `;

                    attributesContainer.appendChild(attributeRow);

                    // initialize new tag input
                    initTagInput(attributeRow.querySelector('.tag-input'));

                    // remove button
                    attributeRow.querySelector('.remove-attribute').addEventListener('click', function() {
                        attributeRow.remove();
                    });

                    attributeCount++;
                });

                // Add event listeners to existing remove buttons
                document.querySelectorAll('.remove-attribute').forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.attribute-row').remove();
                    });
                });
            });

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