<x-app-layout>
    @section('title', $product->name)
    <x-slot name="main">
        <!-- Product Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4 bg-white rounded-lg shadow-md p-4">
                        <div class="relative overflow-hidden rounded-lg">
                            @if ($product->images->count() > 0)
                                <img id="main-product-image"
                                    src="{{ Storage::url($product->images->first()->image_path) }}"
                                    alt="{{ $product->name }}" class="w-full h-96 object-contain">
                            @else
                                <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            @if ($product->discount > 0)
                                <div
                                    class="absolute top-4 left-4 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full">
                                    {{ number_format($product->discount) }} TK OFF
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Images -->
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $image)
                                <div class="border-2 border-transparent hover:border-indigo-500 rounded-lg p-1 cursor-pointer transition-all"
                                    onclick="changeImage('{{ Storage::url($image->image_path) }}')">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 object-cover rounded-md">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Product Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                        <!-- Price -->
                        <div class="mb-6">
                            @if ($product->discount > 0)
                                <div class="flex items-center flex-wrap gap-2">
                                    <span
                                        class="text-3xl font-bold text-gray-900">{{ number_format($product->final_price) }}
                                        TK</span>
                                    <span
                                        class="text-xl text-gray-500 line-through">{{ number_format($product->price) }}
                                        TK</span>
                                    <span class="bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded">
                                        Save {{ number_format($product->discount) }} TK
                                    </span>
                                </div>
                            @else
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price) }}
                                    TK</span>
                            @endif
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <button type="button"
                                        class="px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors"
                                        onclick="decreaseQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-16 text-center border-0 focus:ring-0 focus:outline-none">
                                    <button type="button"
                                        class="px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors"
                                        onclick="increaseQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Attributes -->
                        @if ($groupedAttributes->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Options</h3>
                                <div class="space-y-6">
                                    @foreach ($groupedAttributes as $attribute)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <dt class="text-sm font-medium text-gray-700 mb-3">
                                                {{ $attribute['name'] }} *
                                            </dt>
                                            <dd class="text-sm text-gray-900 mt-1">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($attribute['values'] as $value)
                                                        @php
                                                            $inputName = 'attributes[' . $attribute['id'] . ']';
                                                            $valueId =
                                                                $attribute['id'] .
                                                                '_' .
                                                                \Illuminate\Support\Str::slug($value, '_');
                                                        @endphp

                                                        <label for="{{ $valueId }}" class="cursor-pointer">
                                                            <input type="radio" id="{{ $valueId }}"
                                                                name="{{ $inputName }}" value="{{ $value }}"
                                                                class="peer hidden" required
                                                                data-attribute-id="{{ $attribute['id'] }}"
                                                                data-attribute-name="{{ $attribute['name'] }}"
                                                                onchange="updateSelectedAttributes()">
                                                            <span
                                                                class="inline-block px-4 py-2 rounded-lg border-2 border-gray-300 text-sm font-medium peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                                                                {{ $value }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                <div class="mt-2 text-xs text-red-600 hidden"
                                                    id="error-{{ $attribute['id'] }}">
                                                    Please select {{ $attribute['name'] }}
                                                </div>
                                            </dd>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Selected Attributes Summary -->
                                <div id="selected-attributes-summary" class="mt-4 p-4 bg-blue-50 rounded-lg hidden">
                                    <h4 class="text-sm font-medium text-blue-900 mb-2">Selected Options:</h4>
                                    <div id="selected-attributes-list" class="text-sm text-blue-800"></div>
                                </div>
                            </div>
                        @endif

                        @php
                            $lang = setting('order_form_bangla') ? '1' : '0';
                        @endphp

                        <!-- Order Form -->
                        <div class="border-t border-gray-200 pt-6">
                            <form action="{{ route('public.order.store') }}" method="POST" id="checkout-form"
                                class="space-y-6">
                                @csrf
                                <input type="hidden" id="form-quantity" name="quantity" value="1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Hidden fields for selected attributes -->
                                <div id="attributes-data-container"></div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            @if ($lang === '1')
                                                আপনার সম্পূর্ণ নাম *
                                            @else
                                                Full Name *
                                            @endif
                                        </label>
                                        <input type="text" name="full_name" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
                                            placeholder="@if ($lang === '1') আপনার সম্পূর্ণ নাম লিখুন @else Enter your full name @endif">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            @if ($lang === '1')
                                                আপনার ফোন নম্বর *
                                            @else
                                                Phone Number *
                                            @endif
                                        </label>
                                        <input type="tel" name="phone" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
                                            placeholder="@if ($lang === '1') আপনার ফোন নম্বর লিখুন @else Your phone number @endif">
                                    </div>
                                </div>

                                @if (setting('order_email_need'))
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            @if ($lang === '1')
                                                ইমেইল ঠিকানা দিন (যদি থাকে)
                                            @else
                                                Email Address
                                            @endif
                                        </label>
                                        <input type="email" name="email"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
                                            placeholder="@if ($lang === '1') your.email@example.com @else your.email@example.com @endif">
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @if ($lang === '1')
                                            সম্পূর্ণ ঠিকানা *
                                        @else
                                            Delivery Full Address *
                                        @endif
                                    </label>
                                    <textarea name="full_address" required rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200 resize-none"
                                        placeholder="@if ($lang === '1') আপনার সম্পূর্ণ ঠিকানা লিখুন @else Enter your complete delivery address @endif"></textarea>
                                </div>

                                @if (setting('order_notes_need'))
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            @if ($lang === '1')
                                                নোট (যদি থাকে)
                                            @else
                                                Notes (If Any)
                                            @endif
                                        </label>
                                        <textarea name="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200 resize-none"
                                            placeholder="@if ($lang === '1') অতিরিক্ত নোট বা নির্দেশনা লিখুন @else Enter any additional notes or instructions @endif"></textarea>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        @if ($lang === '1')
                                            ডেলিভারির এলাকা *
                                        @else
                                            Delivery Area *
                                        @endif
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="relative">
                                            <input class="sr-only peer" type="radio" name="delivery_area"
                                                id="inside_dhaka" value="inside_dhaka" checked>
                                            <label
                                                class="flex p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 transition-all duration-200"
                                                for="inside_dhaka">
                                                <div class="ml-3">
                                                    <span class="block font-semibold text-gray-900">
                                                        @if ($lang === '1')
                                                            ঢাকার ভিতরে
                                                        @else
                                                            Inside Dhaka
                                                        @endif
                                                    </span>
                                                    <p class="mt-1 text-sm text-gray-600">
                                                        <span
                                                            id="inside_dhaka_price">{{ setting('inside_dhaka_shipping_cost') }}</span>
                                                        TK - @if ($lang === '1')
                                                            ১-২ ব্যবসায়িক দিন
                                                        @else
                                                            1-2 business days
                                                        @endif
                                                    </p>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="relative">
                                            <input class="sr-only peer" type="radio" name="delivery_area"
                                                id="outside_dhaka" value="outside_dhaka">
                                            <label
                                                class="flex p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 transition-all duration-200"
                                                for="outside_dhaka">
                                                <div class="ml-3">
                                                    <span class="block font-semibold text-gray-900">
                                                        @if ($lang === '1')
                                                            ঢাকার বাইরে
                                                        @else
                                                            Outside Dhaka
                                                        @endif
                                                    </span>
                                                    <p class="mt-1 text-sm text-gray-600">
                                                        <span
                                                            id="outside_dhaka_price">{{ setting('outside_dhaka_shipping_cost') }}</span>
                                                        TK - @if ($lang === '1')
                                                            ৩-৫ ব্যবসায়িক দিন
                                                        @else
                                                            3-5 business days
                                                        @endif
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="place-order-btn"
                                    class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center shadow-md hover:shadow-lg">
                                    <i class="fas fa-lock mr-3"></i>
                                    @if ($lang === '1')
                                        নিরাপদভাবে অর্ডার করুন
                                    @else
                                        Place Order Securely
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-12 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex flex-wrap -mb-px overflow-x-auto">
                        <button id="tab-description"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-blue-500 text-blue-600 whitespace-nowrap transition-colors duration-200">
                            <i class="fas fa-file-alt mr-2"></i>
                            Description
                        </button>
                        <button id="tab-specifications"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i>
                            Specifications
                        </button>
                        <button id="tab-shipping"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap transition-colors duration-200">
                            <i class="fas fa-truck mr-2"></i>
                            Shipping & Returns
                        </button>
                    </nav>
                </div>
                <div class="p-6">
                    <!-- Description Tab -->
                    <div id="content-description" class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </p>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="content-specifications" class="prose max-w-none hidden">
                        @if ($product->specifications && count($product->specifications) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($product->specifications as $key => $value)
                                    <div class="border-b border-gray-100 pb-3">
                                        <dt class="font-medium text-gray-900 text-lg">{{ $key }}</dt>
                                        <dd class="text-gray-700 mt-1">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 text-center py-8">No specifications available.</p>
                        @endif
                    </div>

                    <!-- Shipping Tab -->
                    <div id="content-shipping" class="prose max-w-none hidden">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Shipping Information</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    We offer standard shipping within 2-5 business days. Express shipping options are
                                    available
                                    at checkout for an additional fee.
                                </p>
                                <p class="text-gray-700 leading-relaxed mt-2">
                                    Free shipping on orders over ৳1000. All orders are processed within 24 hours of
                                    placement.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Returns Policy</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    We offer a 30-day money-back guarantee on all products. If you're not completely
                                    satisfied
                                    with your purchase, you can return it for a full refund.
                                </p>
                                <p class="text-gray-700 leading-relaxed mt-2">
                                    To initiate a return, please contact our customer service team with your order
                                    number and
                                    reason for return.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (setting('google_tag_manager_id'))
            @push('scripts')
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({
                        event: 'view_item',
                        ecommerce: {
                            items: [{
                                item_id: {{ $product->id }},
                                item_name: '{{ $product->name }}',
                                price: {{ $product->price }}
                            }]
                        }
                    });
                </script>
            @endpush
        @endif
        @if (setting('fb_pixel_id') && !empty($eventId))
            <script>
                fbq('track', 'ViewContent', {
                    content_ids: ['{{ $product->sku }}'],
                    content_type: 'product',
                    value: {{ $product->price }},
                    currency: "USD"
                }, {
                    eventID: "{{ $eventId }}"
                });
            </script>
        @endif

        <script>
            // Function to change the main product image
            function changeImage(src) {
                document.getElementById('main-product-image').src = src;
            }

            // Function to increase quantity
            function increaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                const max = parseInt(quantityInput.max);
                let value = parseInt(quantityInput.value);
                if (value < max) {
                    quantityInput.value = value + 1;
                    formQuantityInput.value = value + 1;
                }
            }

            // Function to decrease quantity
            function decreaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                    formQuantityInput.value = value - 1;
                }
            }

            // Update selected attributes and create hidden fields
            function updateSelectedAttributes() {
                const attributesContainer = document.getElementById('attributes-data-container');
                const summaryContainer = document.getElementById('selected-attributes-summary');
                const selectedAttributesList = document.getElementById('selected-attributes-list');

                // Clear previous data
                attributesContainer.innerHTML = '';
                selectedAttributesList.innerHTML = '';

                // Get all selected attribute radio buttons
                const selectedAttributes = [];
                const attributeGroups = document.querySelectorAll('input[type="radio"][name^="attributes"]:checked');

                attributeGroups.forEach(radio => {
                    const attributeId = radio.getAttribute('data-attribute-id');
                    const attributeName = radio.getAttribute('data-attribute-name');
                    const attributeValue = radio.value;

                    // Create hidden input for form submission
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `attributes[${attributeId}]`;
                    hiddenInput.value = attributeValue;
                    attributesContainer.appendChild(hiddenInput);

                    // Add to selected attributes list
                    selectedAttributes.push({
                        name: attributeName,
                        value: attributeValue
                    });
                });

                // Update summary
                if (selectedAttributes.length > 0) {
                    summaryContainer.classList.remove('hidden');
                    selectedAttributes.forEach(attr => {
                        const attrElement = document.createElement('div');
                        attrElement.className = 'flex justify-between';
                        attrElement.innerHTML = `
                            <span>${attr.name}:</span>
                            <span class="font-medium">${attr.value}</span>
                        `;
                        selectedAttributesList.appendChild(attrElement);
                    });
                } else {
                    summaryContainer.classList.add('hidden');
                }

                // Hide all error messages
                document.querySelectorAll('[id^="error-"]').forEach(error => {
                    error.classList.add('hidden');
                });
            }

            // Validate attributes before form submission
            function validateAttributes() {
                let isValid = true;
                const attributeGroups = document.querySelectorAll('input[type="radio"][name^="attributes"]');
                const groupedAttributes = {};

                // Group attributes by name
                attributeGroups.forEach(radio => {
                    const name = radio.name;
                    if (!groupedAttributes[name]) {
                        groupedAttributes[name] = [];
                    }
                    groupedAttributes[name].push(radio);
                });

                // Check if at least one option is selected for each attribute group
                Object.keys(groupedAttributes).forEach(groupName => {
                    const groupRadios = groupedAttributes[groupName];
                    const isSelected = groupRadios.some(radio => radio.checked);

                    if (!isSelected) {
                        isValid = false;
                        const attributeId = groupRadios[0].getAttribute('data-attribute-id');
                        const errorElement = document.getElementById(`error-${attributeId}`);
                        if (errorElement) {
                            errorElement.classList.remove('hidden');
                        }
                    }
                });

                return isValid;
            }

            // Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('[id^="tab-"]');
                const contents = document.querySelectorAll('[id^="content-"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const target = this.id.replace('tab-', 'content-');

                        // Update active tab
                        tabs.forEach(t => {
                            t.classList.remove('border-blue-500', 'text-blue-600');
                            t.classList.add('border-transparent', 'text-gray-500');
                        });
                        this.classList.add('border-blue-500', 'text-blue-600');
                        this.classList.remove('border-transparent', 'text-gray-500');

                        // Show target content
                        contents.forEach(content => {
                            content.classList.add('hidden');
                        });
                        document.getElementById(target).classList.remove('hidden');
                    });
                });

                // Form submission handling
                document.getElementById('checkout-form').addEventListener('submit', function(e) {
                    // Validate attributes first
                    if (!validateAttributes()) {
                        e.preventDefault();
                        // Scroll to attributes section
                        document.querySelector('[id^="error-"]:not(.hidden)')?.closest('.border')
                            ?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        return;
                    }

                    // Update attributes data before submission
                    updateSelectedAttributes();

                    // Show loading state
                    const submitBtn = document.getElementById('place-order-btn');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    submitBtn.disabled = true;

                    // Form will now submit normally with all attributes data
                });

                // Initialize attributes on page load
                updateSelectedAttributes();
            });
        </script>
    </x-slot>
</x-app-layout>