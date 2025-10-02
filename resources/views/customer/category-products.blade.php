<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $categoryData['name'] }} - EcomFresh</title>
    
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
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
        }
        
        .favourite-btn.active {
            color: #F59E0B;
        }
        
        .product-image {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
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
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">{{ $categoryData['name'] }}</h2>
            <p class="text-xl text-gray-600">{{ $categoryData['description'] }}</p>
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
            @foreach($categoryData['products'] as $product)
            <div class="product-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 overflow-hidden">
                <!-- Product Header with Image -->
                <div class="flex items-center bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <!-- Product Image -->
                    <div class="w-16 h-16 rounded-lg overflow-hidden mr-4 border border-blue-200 shadow-sm flex-shrink-0">
                        @if(file_exists(public_path($product['image'])))
                            <img 
                                src="{{ asset($product['image']) }}" 
                                alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover product-image"
                            >
                        @else
                            <!-- Fallback to icon if image doesn't exist -->
                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center">
                                @if(str_contains(strtolower($categoryData['name']), 'chicken'))
                                    <i class="fas fa-drumstick-bite text-orange-500 text-lg"></i>
                                @elseif(str_contains(strtolower($categoryData['name']), 'beef'))
                                    <i class="fas fa-hamburger text-red-500 text-lg"></i>
                                @elseif(str_contains(strtolower($categoryData['name']), 'vegetables'))
                                    <i class="fas fa-carrot text-green-500 text-lg"></i>
                                @else
                                    <i class="fas fa-shopping-basket text-blue-500 text-lg"></i>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-gray-600 text-sm">Fresh • Quality Guaranteed</p>
                    </div>
                    <button class="favourite-btn text-gray-400 hover:text-yellow-500 transition duration-300 {{ $product['stores'][0]['is_favourite'] ? 'active text-yellow-500' : '' }}">
                        <i class="fas fa-star text-xl"></i>
                    </button>
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
                            
                            <!-- Store Header with Logo -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <!-- Store Logo Placeholder -->
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3 border border-gray-300">
                                        <span class="font-bold text-gray-700 text-sm">{{ substr($store['store_name'], 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $store['store_name'] }}</h4>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            {{ $store['rating'] }} • {{ $store['distance'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Highlight -->
                            <div class="text-center mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="text-2xl font-extrabold text-green-600">
                                    BND {{ number_format($store['price'], 2) }}
                                </div>
                                <div class="text-gray-600 text-sm">per kg</div>
                            </div>
                            
                            <!-- Store Details -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">📍 Distance:</span>
                                    <span class="font-semibold text-blue-600">{{ $store['distance'] }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">⏱️ Travel Time:</span>
                                    <span class="font-semibold text-gray-700">~{{ round((float)$store['distance'] * 3) }} min</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">🕒 Store Hours:</span>
                                    <span class="font-semibold text-gray-700">{{ $store['store_hours'] ?? '8AM-9PM' }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold text-sm">
                                    <i class="fas fa-directions mr-2"></i>Get Directions
                                </button>
                                <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 font-semibold text-sm">
                                    <i class="fas fa-phone mr-2"></i>Call Store
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
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
                });
            });
        });
    </script>
</body>
</html>