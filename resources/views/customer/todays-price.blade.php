<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Prices - EcomFresh</title>
    
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
        
        .price-comparison-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .discount-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        }
        
        .original-price {
            text-decoration: line-through;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
<header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Logo and Title Section -->
            <div class="flex items-center justify-center md:justify-start space-x-4">
                <div class="w-12 h-12 md:w-16 md:h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                    <i class="fas fa-leaf text-white text-xl md:text-2xl"></i>
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                    <p class="text-blue-600 font-medium text-sm md:text-base">Compare Prices & Find the Best Deals</p>
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="flex justify-center">
                <a href="/customer" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                </a>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">Today's Best Prices</h2>
            <p class="text-xl text-gray-600">Fresh products with amazing discounts - limited time offers!</p>
        </div>

       

        <!-- Products Comparison -->
        <div class="space-y-6">
            @foreach($products as $product)
            <div class="product-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 overflow-hidden">
                <!-- Product Header with Image -->
                <div class="flex items-center bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <!-- Product Image -->
                    <div class="w-16 h-16 rounded-lg overflow-hidden mr-4 border border-blue-200 shadow-sm flex-shrink-0">
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center">
                            <i class="fas fa-drumstick-bite text-orange-500 text-lg"></i>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-gray-600 text-sm">{{ $product['description'] }}</p>
                    </div>
                    <button class="favourite-btn text-gray-400 hover:text-yellow-500 transition duration-300">
                        <i class="fas fa-star text-xl"></i>
                    </button>
                </div>
                
                <!-- Stores Comparison -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-{{ count($product['stores']) }} gap-4">
                        @foreach($product['stores'] as $store)
                        @php
                            $isBestPrice = $store['currentPrice'] === min(array_column($product['stores'], 'currentPrice'));
                            $discountPercentage = round((($store['originalPrice'] - $store['currentPrice']) / $store['originalPrice']) * 100);
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
                                        <span class="font-bold text-gray-700 text-sm">{{ substr($store['name'], 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $store['name'] }}</h4>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            {{ $store['rating'] }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Highlight -->
                            <div class="text-center mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-500 original-price mb-1">
                                    Was BND {{ number_format($store['originalPrice'], 2) }}
                                </div>
                                <div class="text-2xl font-extrabold text-green-600">
                                    BND {{ number_format($store['currentPrice'], 2) }}
                                </div>
                                <div class="discount-badge text-white text-xs font-bold px-2 py-1 rounded-full mt-1">
                                    SAVE {{ $discountPercentage }}%
                                </div>
                                <div class="text-gray-600 text-sm">per kg</div>
                            </div>
                            
                            <!-- Store Details -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center">
                                      <span class="text-gray-600">📦 In Stock:</span>
        <span class="font-semibold text-green-600">Available</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">🕒 Store Hours:</span>
                                    <span class="font-semibold text-gray-700">{{ $store['hours'] }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                              
                                <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 font-semibold text-sm">
                                    <i ></i>Store Details
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
                    
                    const icon = this.querySelector('i');
                    if (this.classList.contains('active')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                });
            });

            // Add far class to all star icons initially
            document.querySelectorAll('.favourite-btn i').forEach(icon => {
                icon.classList.add('far');
            });

            // Button click handlers
            document.querySelectorAll('button').forEach(button => {
                if (button.textContent.includes('Get Directions')) {
                    button.addEventListener('click', function() {
                        const storeName = this.closest('.store-card').querySelector('h4').textContent;
                        alert(`Getting directions to ${storeName}`);
                    });
                }
                
                if (button.textContent.includes('Call Store')) {
                    button.addEventListener('click', function() {
                        const storeName = this.closest('.store-card').querySelector('h4').textContent;
                        alert(`Calling ${storeName}`);
                    });
                }
                
                if (button.textContent.includes('Change Location')) {
                    button.addEventListener('click', function() {
                        alert('Location change feature would open here');
                    });
                }
            });
        });
    </script>
</body>
</html>