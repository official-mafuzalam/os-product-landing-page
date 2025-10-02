<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>StyleHub - Premium Clothing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .newsletter-bg {
            background: linear-gradient(rgba(59, 130, 246, 0.9), rgba(147, 51, 234, 0.9)),
                url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800">Style<span class="text-blue-500">Hub</span></h1>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-600 hover:text-blue-500 font-medium">Home</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 font-medium">Men</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 font-medium">Women</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 font-medium">Kids</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 font-medium">Sale</a>
            </nav>

            <div class="flex items-center space-x-6">
                <button class="text-gray-600 hover:text-blue-500">
                    <i class="fas fa-search text-lg"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-500">
                    <i class="fas fa-shopping-bag text-lg"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-500 md:hidden">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </header>


    <!-- Page Content -->
    @if (isset($main))
        <main>
            {{ $main }}
        </main>
    @endif


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Style<span class="text-blue-500">Hub</span></h3>
                    <p class="text-gray-300">Your one-stop destination for premium fashion and clothing.</p>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Shop</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Returns & Refunds</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Size Guide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">FAQs</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white text-xl">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2023 StyleHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
