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
        
        .favorite-btn.active { 
    color: #F59E0B; 
}
        
        .product-image {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        .favourite-notification {
    transition: all 0.3s ease;
}

.product-card {
    transition: all 0.5s ease;
}

/* Smooth reordering animation */
.space-y-6 {
    transition: all 0.5s ease;
}
  /* Mobile Optimizations */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .product-card {
            margin: 0.5rem 0;
        }
        
        .store-card {
            min-height: auto;
        }
        
        /* Stack header elements vertically on mobile */
        .header-flex {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        /* Adjust product header for mobile */
        .product-header-flex {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        /* Make buttons full width on mobile */
        .mobile-stack {
            flex-direction: column;
            width: 100%;
        }
        
        .mobile-stack a,
        .mobile-stack button {
            width: 100%;
            text-align: center;
        }
        
        /* Adjust text sizes for mobile */
        .mobile-text {
            font-size: 1.5rem !important; /* text-2xl */
        }
        
        .mobile-subtext {
            font-size: 0.875rem !important; /* text-sm */
        }
    }
    
    /* Discount styling */
.discount-badge {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    box-shadow: 0 2px 4px rgba(255, 107, 107, 0.3);
}

.discount-badge-sm {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.save-5 { background: linear-gradient(135deg, #ff6b6b, #ee5a24); }
.save-10 { background: linear-gradient(135deg, #ff6b6b, #c44569); }
.save-15 { background: linear-gradient(135deg, #ff6b6b, #a55eea); }
.save-20 { background: linear-gradient(135deg, #ff6b6b, #eb3b5a); }
.save-25 { background: linear-gradient(135deg, #ff6b6b, #fc5c65); }

.original-price {
    text-decoration: line-through;
    color: #718096 !important;
    font-size: 0.875rem;
    font-weight: 500;
    opacity: 0.8;
}

.current-price {
    color: #059669;
    font-weight: 800;
    text-shadow: 0 1px 2px rgba(5, 150, 105, 0.1);
}

.has-discount {
    position: relative;
    background: linear-gradient(135deg, #f0fff4, #ffffff);
    border-left: 4px solid #48bb78;
}

.discount-ribbon {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 0.25rem 1rem;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 0.375rem;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    z-index: 10;
}

.price-container {
    position: relative;
    background: linear-gradient(135deg, #f7fafc, #edf2f7);
    border: 2px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1rem;
    transition: all 0.3s ease;
}

.has-discount .price-container {
    background: linear-gradient(135deg, #f0fff4, #e6fffa);
    border-color: #68d391;
}

.discount-percentage {
    font-weight: 800;
    font-size: 0.9em;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.savings-amount {
    font-size: 0.75rem;
    color: #059669;
    font-weight: 600;
    margin-top: 0.25rem;
}
</style>

<body class="min-h-screen">
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Logo and Title Section -->
                <div class="flex items-center justify-center md:justify-start space-x-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-leaf text-white text-xl md:text-2xl"></i>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">E-COM FRESH</h1>
                        <p class="text-blue-600 font-medium text-sm md:text-base">Compare Prices & Find the Best Deals</p>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-2 justify-center">
                    <a href="/customer/favorites" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                        <i class="fas fa-star mr-2"></i>My Favorites
                    </a>
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
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4">{{ $categoryData['name'] }}</h2>
            <p class="text-xl text-gray-600">{{ $categoryData['description'] }}</p>
            
            <!-- Discounts Available Badge -->
            @if($hasDiscounts ?? false)
            <div class="inline-flex items-center bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold mt-4">
                <i class="fas fa-fire mr-2"></i>
                Hot Discounts Available Today!
            </div>
            @endif
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
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-gray-600 text-sm">Fresh • Quality Guaranteed</p>
                    </div>
                    
                    <!-- Show discount badge if any store has discount -->
                    @php
                        $hasProductDiscount = false;
                        foreach($product['stores'] as $store) {
                            if(isset($store['originalPrice']) && $store['originalPrice'] > $store['price']) {
                                $hasProductDiscount = true;
                                break;
                            }
                        }
                    @endphp
                    
                    @if($hasProductDiscount)
                    <div class="mr-4 discount-badge text-white text-xs font-bold px-3 py-1 rounded-full">
                        <i class="fas fa-tag mr-1"></i>ON SALE
                    </div>
                    @endif
                    
                    <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition duration-300 {{ $product['stores'][0]['is_favorite'] ? 'active text-yellow-500' : '' }}">
                        <i class="fas fa-star text-xl"></i>
                    </button>
                </div>
                
                <!-- Stores Comparison -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-{{ count($product['stores']) }} gap-4">
                        @foreach($product['stores'] as $store)
                        @php
                            $isBestPrice = $store['price'] === min(array_column($product['stores'], 'price'));
                            $hasDiscount = isset($store['originalPrice']) && $store['originalPrice'] > $store['price'];
                            $discountPercentage = $hasDiscount ? round((($store['originalPrice'] - $store['price']) / $store['originalPrice']) * 100) : 0;
                        @endphp
                        <div class="store-card bg-white border border-gray-200 rounded-lg p-4 {{ $isBestPrice ? 'best-price border-2 border-green-500' : '' }} {{ $hasDiscount ? 'has-discount' : '' }}">
                            @if($isBestPrice)
                            <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                <i class="fas fa-trophy mr-1"></i>Best Price
                            </div>
                            @endif
                            
                            @if($hasDiscount && !$isBestPrice)
                            <div class="discount-badge text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                <i class="fas fa-bolt mr-1"></i>{{ $discountPercentage }}% OFF
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
                                            {{ $store['rating'] }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           <!-- ENHANCED Price Highlight with Better Discount Styling -->
<div class="price-container text-center mb-4">
    @if($hasDiscount)
    <div class="original-price text-sm mb-1">
        Was BND {{ number_format($store['originalPrice'], 2) }}
    </div>
    @endif
    
    <div class="text-2xl font-extrabold current-price">
        BND {{ number_format($store['price'], 2) }}
    </div>
    
    @if($hasDiscount)
    @php
        $savingsAmount = $store['originalPrice'] - $store['price'];
    @endphp
    <div class="discount-badge text-white text-xs font-bold px-2 py-1 rounded-full mt-2 discount-percentage">
        <i class="fas fa-bolt mr-1"></i>SAVE {{ $discountPercentage }}%
    </div>
   
    @endif
    
    <div class="text-gray-600 text-sm mt-1">per kg</div>
</div>
                            
                            <!-- Store Details -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">📦 In Stock:</span>
                                    <span class="font-semibold text-green-600">Available</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">🕒 Store Hours:</span>
                                    <span class="font-semibold text-gray-700">{{ $store['store_hours'] ?? '8AM-9PM' }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                                <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 font-semibold text-sm">
                                    <i class="fas fa-store mr-2"></i>Price History
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

    <!-- JavaScript for Hybrid Favorite System (Database + LocalStorage Fallback) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize favorites
        initializeFavorites();

        // Favorite button functionality
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productCard = this.closest('.product-card');
                const productName = productCard.querySelector('h3').textContent.trim();
                const category = '{{ $categoryData["name"] }}';
                const productId = this.getAttribute('data-product-id');
                const isCurrentlyFavorite = this.classList.contains('active');
                
                // Toggle visual state immediately for better UX
                this.classList.toggle('active');
                this.classList.toggle('text-yellow-500');
                this.classList.toggle('text-gray-400');
                
                // Get complete product data for localStorage fallback
                const productData = getCompleteProductData(productCard, category, productName);
                
                // Try database first, fallback to localStorage
                if (productId) {
                    toggleDatabaseFavorite(productId, !isCurrentlyFavorite, productData, productName, productCard);
                } else {
                    // Fallback to localStorage only
                    toggleLocalStorageFavorite(!isCurrentlyFavorite, productData, productName, category);
                }
                
                // Re-sort products in this category
                sortProductsInCategory(productCard);
                
                // Show notification
                showFavoriteNotification(!isCurrentlyFavorite, productCard);
            });
        });

        // Toggle favorite in database
        async function toggleDatabaseFavorite(productId, shouldAdd, productData, productName, productCard) {
            try {
                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const result = await response.json();

                if (response.status === 401) {
                    // Not authenticated - fallback to localStorage and show login prompt
                    showNotification('Please login to save favorites permanently', 'yellow');
                    toggleLocalStorageFavorite(shouldAdd, productData, productName, '{{ $categoryData["name"] }}');
                    return;
                }

                if (!response.ok) {
                    throw new Error(result.message || 'Error updating favorite');
                }

                // Success - also update localStorage as backup
                if (shouldAdd) {
                    addToFavorites(productData);
                } else {
                    removeFromFavorites(productName, '{{ $categoryData["name"] }}');
                }

            } catch (error) {
                console.error('Database favorite error:', error);
                // Fallback to localStorage on error
                toggleLocalStorageFavorite(shouldAdd, productData, productName, '{{ $categoryData["name"] }}');
                showNotification('Using offline favorites', 'yellow');
            }
        }

        // Toggle favorite in localStorage (fallback)
        function toggleLocalStorageFavorite(shouldAdd, productData, productName, category) {
            if (shouldAdd) {
                addToFavorites(productData);
            } else {
                removeFromFavorites(productName, category);
            }
        }

        // KEEP ALL YOUR EXISTING FUNCTIONS - they work perfectly!
        function getCompleteProductData(productCard, category, productName) {
            const stores = [];
            const storeElements = productCard.querySelectorAll('.store-card');
            
            storeElements.forEach(storeElement => {
                const storeName = storeElement.querySelector('h4').textContent.trim();
                
                // UPDATED: Use current-price class instead of text-2xl
                const priceElement = storeElement.querySelector('.current-price');
                const price = priceElement ? parseFloat(priceElement.textContent.replace('BND', '').trim()) : 0;
                
                // NEW: Check for original price
                const originalPriceElement = storeElement.querySelector('.original-price');
                const originalPrice = originalPriceElement ? 
                    parseFloat(originalPriceElement.textContent.replace('Was BND', '').trim()) : 
                    null;

                // Get all store details
                const details = storeElement.querySelectorAll('.space-y-2 div');
                let distance = 'N/A';
                let travelTime = 'N/A'; 
                let storeHours = '8AM-9PM';

                details.forEach(detail => {
                    const text = detail.textContent;
                    if (text.includes('Distance:')) {
                        distance = detail.querySelector('span:last-child').textContent;
                    } else if (text.includes('Travel Time:')) {
                        travelTime = detail.querySelector('span:last-child').textContent;
                    } else if (text.includes('Store Hours:')) {
                        storeHours = detail.querySelector('span:last-child').textContent;
                    }
                });

                // Get rating
                const ratingElement = storeElement.querySelector('.fa-star').parentElement;
                const rating = ratingElement ? parseFloat(ratingElement.textContent.trim()) : 4.0;

                stores.push({
                    store_name: storeName,
                    price: price,
                    originalPrice: originalPrice,
                    distance: distance,
                    travel_time: travelTime,
                    store_hours: storeHours,
                    rating: rating,
                    is_favorite: true
                });
            });

            // Get the actual product image
            const productImageElement = productCard.querySelector('.product-image');
            const productImage = productImageElement ? 
                productImageElement.src.replace(window.location.origin, '') : 
                '{{ $categoryData["image"] }}';

            return {
                name: productName,
                category: category,
                description: '{{ $categoryData["description"] }}',
                image: productImage,
                stores: stores,
                favorited_at: new Date().toISOString()
            };
        }

        // Add product to favorites in localStorage
        function addToFavorites(productData) {
            const favorites = getFavorites();
            // Check if product already exists
            const existingIndex = favorites.findIndex(fav => 
                fav.name === productData.name && fav.category === productData.category
            );
            
            if (existingIndex === -1) {
                favorites.push(productData);
                localStorage.setItem('ecomfresh_favorites', JSON.stringify(favorites));
                console.log('Added to favorites:', productData);
            } else {
                // Update existing favorite
                favorites[existingIndex] = productData;
                localStorage.setItem('ecomfresh_favorites', JSON.stringify(favorites));
            }
        }

        // Remove product from favorites
        function removeFromFavorites(productName, category) {
            const favorites = getFavorites();
            const updatedFavorites = favorites.filter(fav => 
                !(fav.name === productName && fav.category === category)
            );
            localStorage.setItem('ecomfresh_favorites', JSON.stringify(updatedFavorites));
            console.log('Removed from favorites:', productName);
        }

        // Get favorites from localStorage
        function getFavorites() {
            return JSON.parse(localStorage.getItem('ecomfresh_favorites') || '[]');
        }

        // Initialize favorite buttons based on stored data
        function initializeFavorites() {
            // Try to sync with database first
            initializeDatabaseFavorites();
        }

        // Initialize with database favorites if user is logged in
        async function initializeDatabaseFavorites() {
            try {
                const response = await fetch('/favorites/user-status', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const userFavorites = await response.json();
                    // If we have database favorites, use them to initialize the UI
                    initializeFavoriteButtons(userFavorites);
                } else {
                    // Fallback to localStorage
                    initializeLocalStorageFavorites();
                }
            } catch (error) {
                console.error('Error initializing database favorites:', error);
                initializeLocalStorageFavorites();
            }
        }

        // Initialize with localStorage favorites
        function initializeLocalStorageFavorites() {
            const favorites = getFavorites();
            const currentCategory = '{{ $categoryData["name"] }}';
            
            document.querySelectorAll('.product-card').forEach(card => {
                const productName = card.querySelector('h3').textContent.trim();
                const favoriteBtn = card.querySelector('.favorite-btn');
                
                // Check if this product is in favorites for current category
                const isFavorite = favorites.some(fav => 
                    fav.name === productName && fav.category === currentCategory
                );
                
                if (isFavorite) {
                    favoriteBtn.classList.add('active', 'text-yellow-500');
                    favoriteBtn.classList.remove('text-gray-400');
                }
            });
            
            // Initial sort
            document.querySelectorAll('.product-card').forEach(card => {
                sortProductsInCategory(card);
            });
        }

        // Initialize buttons with database favorites data
        function initializeFavoriteButtons(userFavorites) {
            document.querySelectorAll('.product-card').forEach(card => {
                const productId = card.querySelector('.favorite-btn').getAttribute('data-product-id');
                const favoriteBtn = card.querySelector('.favorite-btn');
                
                // Check if this product is in user's database favorites
                const isFavorite = userFavorites.some(fav => fav.product_id == productId);
                
                if (isFavorite) {
                    favoriteBtn.classList.add('active', 'text-yellow-500');
                    favoriteBtn.classList.remove('text-gray-400');
                }
            });
            
            // Initial sort
            document.querySelectorAll('.product-card').forEach(card => {
                sortProductsInCategory(card);
            });
        }

        // Sort products within a category (favorites first)
        function sortProductsInCategory(clickedProductCard) {
            const categorySection = clickedProductCard.closest('.space-y-6');
            const productCards = Array.from(categorySection.querySelectorAll('.product-card'));
            
            productCards.sort((a, b) => {
                const aFavorite = a.querySelector('.favorite-btn').classList.contains('active');
                const bFavorite = b.querySelector('.favorite-btn').classList.contains('active');
                
                if (aFavorite && !bFavorite) return -1;
                if (!aFavorite && bFavorite) return 1;
                return 0;
            });
            
            productCards.forEach(card => categorySection.appendChild(card));
        }

        // Show notification when favoriting
        function showFavoriteNotification(added, productCard) {
            const productName = productCard.querySelector('h3').textContent.trim();
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
                added ? 'bg-green-500 text-white' : 'bg-gray-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${added ? 'fa-star' : 'fa-star-half-alt'} mr-2"></i>
                    <span>${added ? 'Added to favorites' : 'Removed from favorites'}: ${productName}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Helper function for general notifications
        function showNotification(message, color = 'green') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 left-4 p-4 rounded-lg shadow-lg z-50 transform transition-transform duration-300 bg-${color}-500 text-white`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(-100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    });
</script>

