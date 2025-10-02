<x-admin-layout>
    @section('title', $product->name)
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Product Details
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            Edit Product
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                            class="px-3 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Back to Products
                        </a>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column - Image -->
                        <div class="md:col-span-1">
                            <!-- Main Image -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 mb-4 relative">
                                <img id="mainProductImage"
                                    src="{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}" class="w-full h-80 object-contain">

                                <!-- Set Primary Button -->
                                <button type="button" onclick="openSetPrimaryModal()"
                                    class="absolute top-4 right-4 bg-indigo-600 text-white p-2 rounded-full shadow-md hover:bg-indigo-700 transition-colors"
                                    title="Set as primary image">
                                    <i class="fas fa-star text-sm"></i>
                                </button>
                            </div>

                            <!-- Image Gallery -->
                            @if ($product->images->count() > 0)
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Gallery Images
                                        </h3>
                                        <button type="button" onclick="openSetPrimaryModal()"
                                            class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Set Primary Image
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-4 gap-3">
                                        <!-- Gallery images -->
                                        @foreach ($product->images as $index => $image)
                                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-1.5 cursor-pointer shadow-sm transition-all duration-200 hover:border-indigo-400 hover:shadow-md relative group"
                                                onclick="changeMainImage('{{ Storage::url($image->image_path) }}')">
                                                <img src="{{ Storage::url($image->image_path) }}"
                                                    alt="Gallery image {{ $index + 1 }}"
                                                    class="h-20 w-full object-cover rounded">

                                                <!-- Primary Badge -->
                                                @if ($image->is_primary)
                                                    <span
                                                        class="absolute top-0 right-0 bg-indigo-500 text-white text-xs px-1.5 py-0.5 rounded-bl-lg rounded-tr-lg">
                                                        Primary
                                                    </span>
                                                @endif

                                                <!-- Set Primary Button (shown on hover) -->
                                                <button type="button"
                                                    onclick="event.stopPropagation(); setAsPrimary({{ $image->id }})"
                                                    class="absolute bottom-1 left-1 bg-indigo-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-md"
                                                    title="Set as primary image">
                                                    <i class="fas fa-star text-xs"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Set Primary Image Modal -->
                        <div id="setPrimaryModal"
                            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Set Primary
                                        Image</h3>

                                    <div class="space-y-3 mb-6">
                                        @foreach ($product->images as $image)
                                            <div
                                                class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail"
                                                        class="w-12 h-12 object-cover rounded">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                                        Image {{ $loop->iteration }}
                                                    </span>
                                                    @if ($image->is_primary)
                                                        <span
                                                            class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                                            Current Primary
                                                        </span>
                                                    @endif
                                                </div>
                                                <button type="button" onclick="setAsPrimary({{ $image->id }})"
                                                    class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition-colors {{ $image->is_primary ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                                    Set Primary
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <button type="button" onclick="closeSetPrimaryModal()"
                                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->name }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SKU</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->sku }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->slug }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->description }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Pricing & Stock -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Pricing &
                                        Stock</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Buy Price
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ number_format($product->buy_price, 2) }} TK</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ number_format($product->price, 2) }} TK</dd>
                                        </div>
                                        @if ($product->discount > 0)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                    Discount</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                    {{ number_format($product->discount, 2) }} TK</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Final
                                                    Price</dt>
                                                <dd class="text-sm text-green-600 dark:text-green-400 font-semibold">
                                                    {{ number_format($product->final_price, 2) }} TK</dd>
                                            </div>
                                        @endif
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock
                                                Quantity</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->stock_quantity }}
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                        $product->stock_quantity > 0,
                                                    'bg-red-500/10 text-red-600 dark:text-red-400' =>
                                                        $product->stock_quantity <= 0,
                                                ])>
                                                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Category & Brand -->
                                {{-- <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Category &
                                        Brand</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->category->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Brand</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->brand->name }}</dd>
                                        </div>
                                    </dl>
                                </div> --}}

                                <!-- Status Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Active
                                                Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-green-500/10 text-green-600 dark:text-green-400' => $product->is_active,
                                                    'bg-red-500/10 text-red-600 dark:text-red-400' => !$product->is_active,
                                                ])>
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Featured
                                                Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-blue-500/10 text-blue-600 dark:text-blue-400' => $product->is_featured,
                                                    'bg-gray-500/10 text-gray-600 dark:text-gray-400' => !$product->is_featured,
                                                ])>
                                                    {{ $product->is_featured ? 'Featured' : 'Not Featured' }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->created_at->format('M d, Y h:i A') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Attributes -->
                                @if ($groupedAttributes->count() > 0)
                                    <div class="md:col-span-2">
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">
                                            Attributes
                                        </h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($groupedAttributes as $attribute)
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        {{ $attribute['name'] }}
                                                    </dt>
                                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                        {{ implode(', ', $attribute['values']) }}
                                                    </dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif

                                <!-- Specifications -->
                                @if ($product->specifications && count($product->specifications) > 0)
                                    <div class="md:col-span-2">
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">
                                            Specifications</h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($product->specifications as $key => $value)
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        {{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                        {{ $value }}</dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function changeMainImage(src) {
                const mainImage = document.getElementById('mainProductImage');

                // Add fade transition
                mainImage.style.opacity = '0';

                setTimeout(() => {
                    mainImage.src = src;
                    mainImage.style.opacity = '1';
                }, 200);

                // Update active thumbnail styling
                document.querySelectorAll('.border-2').forEach(el => {
                    el.classList.remove('border-2', 'border-indigo-500');
                    el.classList.add('border', 'border-gray-200', 'dark:border-gray-600');
                });

                // Find the clicked thumbnail and update its styling
                const clickedElement = event.currentTarget;
                clickedElement.classList.remove('border', 'border-gray-200', 'dark:border-gray-600');
                clickedElement.classList.add('border-2', 'border-indigo-500');
            }

            // Initialize with smooth transition
            document.addEventListener('DOMContentLoaded', function() {
                const mainImage = document.getElementById('mainProductImage');
                mainImage.style.transition = 'opacity 0.2s ease-in-out';
            });

            // Set Primary Image Functions
            function openSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function setAsPrimary(imageId) {
                // Show loading state
                const buttons = document.querySelectorAll(`button[onclick="setAsPrimary(${imageId})"]`);
                buttons.forEach(button => {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                });

                // Send AJAX request
                fetch('{{ route('admin.products.set-primary-image', $product->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            image_id: imageId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to see changes
                            window.location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to set primary image'));
                            // Reset buttons
                            buttons.forEach(button => {
                                button.innerHTML = 'Set Primary';
                                button.disabled = false;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while setting the primary image');
                        // Reset buttons
                        buttons.forEach(button => {
                            button.innerHTML = 'Set Primary';
                            button.disabled = false;
                        });
                    });
            }

            // Close modal when clicking outside
            document.getElementById('setPrimaryModal').addEventListener('click', function(e) {
                if (e.target.id === 'setPrimaryModal') {
                    closeSetPrimaryModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('setPrimaryModal').classList.contains('hidden')) {
                    closeSetPrimaryModal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
