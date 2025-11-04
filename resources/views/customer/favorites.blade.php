<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - EcomFresh</title>
    
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e90ff 0%, #ffffff 100%);
            min-height: 100vh;
        }
        .logo-placeholder { 
            background: linear-gradient(135deg, #1e90ff, #00bfff); 
        }
        .product-card { 
            transition: all 0.3s ease; 
        }
        .product-card:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .favorite-btn.active { 
            color: #F59E0B; 
        }
        .category-section {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }
        .store-card {
            transition: all 0.2s ease;
        }
        .store-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
        }
        
        /* DISCOUNT STYLING - Same as category-products */
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
        
        .best-price {
            position: relative;
            border: 2px solid #10B981 !important;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7) !important;
        }
        
        .best-price::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #10B981, #34D399);
            border-radius: 0.5rem;
            z-index: -1;
        }
    </style>
</head>
<body>
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
                    <p class="text-blue-600 font-medium text-sm md:text-base">My Favorite Products</p>
                </div>
            </div>
            
            <!-- Buttons Section -->
            <div class="flex flex-col sm:flex-row items-center gap-2 justify-center">
                <a href="{{ route('customer.main') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                    <i class="fas fa-home mr-2"></i>Back to Categories
                </a>
                <button onclick="clearAllFavorites()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                    <i class="fas fa-trash mr-2"></i>Clear All
                </button>
            </div>
        </div>
    </div>
</header>

    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4">⭐ My Favorites</h2>
            <p class="text-xl text-gray-600">All your favorite products with complete information</p>
        </div>

        <!-- Favorites Container -->
        <div id="favorites-container" class="space-y-8">
            <!-- Favorites will be loaded here by JavaScript -->
        </div>

        <!-- Empty State (initially hidden) -->
        <div id="empty-favorites" class="text-center py-16 bg-white/80 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 hidden">
            <i class="fas fa-star text-6xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-600 mb-4">No favorites yet</h3>
            <p class="text-gray-500 text-lg mb-6">Start clicking the star icons on products to add them here!</p>
            <a href="{{ route('customer.main') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-medium text-lg">
                <i class="fas fa-shopping-basket mr-2"></i>Browse Products
            </a>
        </div>
    </main>

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        loadFavorites();
    });

    function loadFavorites() {
        const favorites = getFavorites();
        const container = document.getElementById('favorites-container');
        const emptyState = document.getElementById('empty-favorites');

        // Clear container
        container.innerHTML = '';

        if (favorites.length === 0) {
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');

        // Group favorites by category
        const favoritesByCategory = {};
        favorites.forEach(fav => {
            if (!favoritesByCategory[fav.category]) {
                favoritesByCategory[fav.category] = [];
            }
            favoritesByCategory[fav.category].push(fav);
        });

        // Create HTML for each category
        Object.entries(favoritesByCategory).forEach(([category, products]) => {
            const categorySection = document.createElement('div');
            categorySection.className = 'category-section rounded-xl shadow-md border border-blue-100 overflow-hidden';
            
            categorySection.innerHTML = `
                <div class="bg-gradient-to-r from-blue-100 to-blue-200 px-6 py-4 border-b border-blue-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">${category}</h3>
                            <p class="text-blue-700 text-sm">${products.length} favorite product(s)</p>
                        </div>
                        <div class="text-blue-600">
                            <i class="fas fa-${getCategoryIcon(category)} text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 space-y-6">
                    ${products.map(product => {
                        // Find the best price for this product
                        const bestPrice = Math.min(...product.stores.map(store => store.price));
                        
                        // Check if product has any discounts
                        const hasProductDiscount = product.stores.some(store => store.originalPrice && store.originalPrice > store.price);
                        
                        return `
                        <div class="product-card bg-white rounded-lg border border-gray-200 overflow-hidden ${hasProductDiscount ? 'has-discount' : ''}">
                            <!-- Product Header -->
                            <div class="flex items-center bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center space-x-4 flex-1">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-300 flex-shrink-0">
                                        <img src="${product.image}" alt="${product.name}" 
                                             class="w-full h-full object-cover" 
                                             onerror="this.src='{{ asset('images/categories/default.jpg') }}'">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-800">${product.name}</h4>
                                        <p class="text-gray-600 text-sm">${product.description}</p>
                                    </div>
                                </div>
                                
                                <!-- Discount Badge for Product -->
                                ${hasProductDiscount ? `
                                    <div class="discount-badge text-white text-xs font-bold px-3 py-1 rounded-full mr-4">
                                        <i class="fas fa-tag mr-1"></i>ON SALE
                                    </div>
                                ` : ''}
                                
                                <button onclick="removeFavorite('${product.name.replace(/'/g, "\\'")}', '${category}')" 
                                        class="favorite-btn active text-yellow-500 hover:text-yellow-600 transition duration-300 ml-4">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                            </div>
                            
                            <!-- Store Comparison -->
                            <div class="p-6">
                                <h5 class="text-md font-semibold text-gray-700 mb-4">Available at:</h5>
                                <div class="grid grid-cols-1 md:grid-cols-${Math.min(product.stores.length, 3)} gap-4">
                                    ${product.stores.map(store => {
                                        const isBestPrice = store.price === bestPrice;
                                        const hasDiscount = store.originalPrice && store.originalPrice > store.price;
                                        const discountPercentage = hasDiscount ? Math.round(((store.originalPrice - store.price) / store.originalPrice) * 100) : 0;
                                        const savingsAmount = hasDiscount ? (store.originalPrice - store.price).toFixed(2) : 0;
                                        
                                        return `
                                        <div class="store-card bg-gray-50 border border-gray-300 rounded-lg p-4 ${isBestPrice ? 'best-price' : ''} ${hasDiscount ? 'has-discount' : ''}">
                                            ${isBestPrice ? `
                                                <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                                    <i class="fas fa-trophy mr-1"></i>Best Price
                                                </div>
                                            ` : ''}
                                            
                                            ${hasDiscount && !isBestPrice ? `
                                                <div class="discount-badge text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                                    <i class="fas fa-bolt mr-1"></i>${discountPercentage}% OFF
                                                </div>
                                            ` : ''}
                                            
                                            <div class="flex items-center justify-between mb-3">
                                                <h6 class="font-bold text-gray-800 text-lg">${store.store_name}</h6>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                                    ${store.rating}
                                                </div>
                                            </div>
                                            
                                            <!-- ENHANCED Price Highlight with Discount Support -->
                                            <div class="price-container text-center mb-3">
                                                ${hasDiscount ? `
                                                    <div class="original-price text-sm mb-1">
                                                        Was BND ${store.originalPrice.toFixed(2)}
                                                    </div>
                                                ` : ''}
                                                
                                                <div class="text-2xl font-extrabold current-price">
                                                    BND ${store.price.toFixed(2)}
                                                </div>
                                                
                                                ${hasDiscount ? `
                                                    <div class="discount-badge text-white text-xs font-bold px-2 py-1 rounded-full mt-2 discount-percentage">
                                                        <i class="fas fa-bolt mr-1"></i>SAVE ${discountPercentage}%
                                                    </div>
                                                    
                                                ` : ''}
                                                
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
                                                    <span class="font-semibold text-gray-700">${store.store_hours}</span>
                                                </div>
                                            </div>
                                        </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>
                        </div>
                        `;
                    }).join('')}
                </div>
            `;
            
            container.appendChild(categorySection);
        });
    }

    function getCategoryIcon(category) {
        const icons = {
            'Chicken': 'drumstick-bite',
            'Beef': 'hamburger',
            'Vegetables': 'carrot'
        };
        return icons[category] || 'shopping-basket';
    }

    function getFavorites() {
        return JSON.parse(localStorage.getItem('ecomfresh_favorites') || '[]');
    }

    function removeFavorite(productName, category) {
        let favorites = getFavorites();
        favorites = favorites.filter(fav => !(fav.name === productName && fav.category === category));
        localStorage.setItem('ecomfresh_favorites', JSON.stringify(favorites));
        
        // Show notification
        showNotification(`Removed ${productName} from favorites`, 'red');
        
        // Reload favorites
        loadFavorites();
    }

    function clearAllFavorites() {
        if (confirm('Are you sure you want to remove all favorites?')) {
            localStorage.removeItem('ecomfresh_favorites');
            showNotification('All favorites cleared', 'red');
            loadFavorites();
        }
    }

    function showNotification(message, color = 'green') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-transform duration-300 bg-${color}-500 text-white`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${color === 'green' ? 'check' : 'info'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
</body>
</html>