<x-app-layout>
    <x-slot name="main">

        <!-- Hero Section -->
        <section class="hero-bg py-20 md:py-32 text-white">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Summer Collection 2023</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Discover the latest trends in fashion with our
                    premium collection</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Shop Now
                    </button>
                    <button
                        class="bg-transparent border-2 border-white hover:bg-white hover:text-gray-800 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Explore
                    </button>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Featured Products</h2>
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Check out our featured products</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($featuredProducts as $product)
                        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ $product->images->where('is_primary', true)->first()
                                    ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                                    : 'https://placehold.co/400x400?text=No+Image' }}"
                                    alt="{{ $product->name }}" class="w-full h-64 object-cover">

                                {{-- New Badge --}}
                                @if ($product->created_at->gt(now()->subDays(30)))
                                    <div
                                        class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded shadow">
                                        NEW
                                    </div>
                                @endif

                                {{-- Discount Badge --}}
                                @if ($product->discount > 0)
                                    <div
                                        class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded shadow">
                                        {{ number_format(($product->discount / $product->price) * 100) }}% OFF
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-500 font-bold text-lg">${{ $product->price }}</span>
                                    <a href="{{ route('public.products.details', $product->slug) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- All Products -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">All Products</h2>
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Check out all premium items</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($products as $product)
                        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ $product->images->where('is_primary', true)->first()
                                    ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                                    : 'https://placehold.co/400x400?text=No+Image' }}"
                                    alt="{{ $product->name }}" class="w-full h-64 object-cover">

                                {{-- New Badge --}}
                                @if ($product->created_at->gt(now()->subDays(30)))
                                    <div
                                        class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded shadow">
                                        NEW
                                    </div>
                                @endif

                                {{-- Discount Badge --}}
                                @if ($product->discount > 0)
                                    <div
                                        class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded shadow">
                                        {{ number_format(($product->discount / $product->price) * 100) }}% OFF
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-500 font-bold text-lg">${{ $product->price }}</span>
                                    <a href="{{ route('public.products.details', $product->slug) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </x-slot>
</x-app-layout>
