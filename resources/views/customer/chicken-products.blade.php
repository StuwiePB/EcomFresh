<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chicken Price Comparison - EcomFresh</title>
    
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e90ff 0%, #ffffff 100%);
            min-height: 100vh;
        }
        
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .logo-placeholder {
            background: linear-gradient(135deg, #1e90ff, #00bfff);
        }
        
        .best-price {
            border: 2px solid #10B981;
            background: linear-gradient(135deg, #10B981, #34D399);
        }
        
        .favourite-btn.active {
            color: #F59E0B;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Logo Placeholder -->
                    <div class="w-16 h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <!-- App Name -->
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                        <p class="text-blue-600 font-medium">Compare Prices & Find the Best Deals</p>
                    </div>
                </div>
                <!-- Back Button -->
                <a href="{{ route('customer.main') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">Chicken Products</h2>
            <p class="text-xl text-gray-600">Compare prices across stores in Brunei</p>
        </div>

        <!-- Location Filter -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">📍 Your Location</h3>
                    <p class="text-gray-600">Showing stores near <span class="font-semibold">Gadong, Brunei</span></p>
                </div>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                    <i class="fas fa-map-marker-alt mr-2"></i>Change Location
                </button>
            </div>
        </div>

        <!-- Products Comparison -->
        <div class="space-y-6">
            @foreach($chickenProducts as $product)
            <div class="product-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 overflow-hidden">
                <!-- Product Header -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $product['name'] }}
                        </h3>
                        <button class="favourite-btn text-gray-400 hover:text-yellow-500 transition duration-300 {{ $product['stores'][0]['is_favourite'] ? 'active text-yellow-500' : '' }}">
                            <i class="fas fa-star text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Stores Comparison -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-{{ count($product['stores']) }} gap-4">
                        @foreach($product['stores'] as $store)
                        @php
                            $isBestPrice = $store['price'] === min(array_column($product['stores'], 'price'));
                        @endphp
                        <div class="store-card bg-white border border-gray-200 rounded-lg p-4 {{ $isBestPrice ? 'best-price' : '' }}">
                            @if($isBestPrice)
                            <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                <i class="fas fa-trophy mr-1"></i>Best Price
                            </div>
                            @endif
                            
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-bold text-gray-800 text-lg">{{ $store['store_name'] }}</h4>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    {{ $store['rating'] }}
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <!-- Price -->
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Price:</span>
                                    <span class="text-xl font-extrabold text-green-600">
                                        BND {{ number_format($store['price'], 2) }}/kg
                                    </span>
                                </div>
                                
                                <!-- Distance -->
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Distance:</span>
                                    <span class="font-semibold text-blue-600">
                                        <i class="fas fa-location-arrow mr-1"></i>{{ $store['distance'] }}
                                    </span>
                                </div>
                                
                                <!-- Estimated Travel Time -->
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Travel Time:</span>
                                    <span class="font-semibold text-gray-700">
                                        ~{{ round((float)$store['distance'] * 3) }} min
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold text-sm">
                                    <i class="fas fa-directions mr-2"></i>Get Directions
                                </button>
                                <button class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition duration-300 font-semibold text-sm">
                                    <i class="fas fa-store mr-2"></i>View Store Details
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Features Section -->
        <div class="mt-12 bg-white/80 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 700;">Why Use EcomFresh?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-wave text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Save Money</h4>
                    <p class="text-gray-600 text-sm">Compare prices and find the best deals across all stores</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Nearby Stores</h4>
                    <p class="text-gray-600 text-sm">Find stores closest to you with the best prices</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-yellow-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Favorites</h4>
                    <p class="text-gray-600 text-sm">Save your favorite products and stores for quick access</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. Compare prices and save money.</p>
        </div>
    </footer>

    <!-- JavaScript for Favourite Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Favourite button functionality
            document.querySelectorAll('.favourite-btn').forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('active');
                    this.classList.toggle('text-yellow-500');
                    this.classList.toggle('text-gray-400');
                    
                    const icon = this.querySelector('i');
                    if (this.classList.contains('active')) {
                        // Optional: Add animation or confirmation
                    }
                });
            });
        });
    </script>
</body>
</html>