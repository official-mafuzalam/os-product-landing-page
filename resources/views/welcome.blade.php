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
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Check out our handpicked selection of
                    premium clothing items</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Product 1 -->
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                alt="Classic White Shirt" class="w-full h-64 object-cover">
                            <span
                                class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded">New</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Classic White Shirt</h3>
                            <p class="text-gray-600 text-sm mb-4">Premium cotton fabric with perfect fit</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-500 font-bold text-lg">$49.99</span>
                                <button
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                alt="Denim Jacket" class="w-full h-64 object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Vintage Denim Jacket</h3>
                            <p class="text-gray-600 text-sm mb-4">Classic denim with modern styling</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-500 font-bold text-lg">$79.99</span>
                                <button
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                alt="Summer Dress" class="w-full h-64 object-cover">
                            <span
                                class="absolute top-4 right-4 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">Sale</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Floral Summer Dress</h3>
                            <p class="text-gray-600 text-sm mb-4">Light and comfortable for summer days</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="text-blue-500 font-bold text-lg">$39.99</span>
                                    <span class="text-gray-400 text-sm line-through ml-2">$59.99</span>
                                </div>
                                <button
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                alt="Casual Pants" class="w-full h-64 object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Casual Chino Pants</h3>
                            <p class="text-gray-600 text-sm mb-4">Perfect for casual and office wear</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-500 font-bold text-lg">$44.99</span>
                                <button
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition duration-300">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <button
                        class="bg-gray-800 hover:bg-black text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        View All Products
                    </button>
                </div>
            </div>
        </section>

    </x-slot>
</x-app-layout>
