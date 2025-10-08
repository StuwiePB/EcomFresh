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
        }
    </style>
</head>
<body class="min-h-screen">
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                        <p class="text-blue-600 font-medium">My Favorite Products</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('customer.main') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                        <i class="fas fa-home mr-2"></i>Back to Categories
                    </a>
                    <button onclick="clearAllFavorites()" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition duration-300 font-medium">
                        <i class="fas fa-trash mr-2"></i>Clear All
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">⭐ My Favorites</h2>
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
                        return `
                        <div class="product-card bg-white rounded-lg border border-gray-200 overflow-hidden">
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
                                        return `
                                        <div class="store-card bg-gray-50 border border-gray-300 rounded-lg p-4 ${isBestPrice ? 'best-price border-2 border-green-500' : ''}">
                                            ${isBestPrice ? `
                                                <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">
                                                    <i class="fas fa-trophy mr-1"></i>Best Price
                                                </div>
                                            ` : ''}
                                            
                                            <div class="flex items-center justify-between mb-3">
                                                <h6 class="font-bold text-gray-800 text-lg">${store.store_name}</h6>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                                    ${store.rating}
                                                </div>
                                            </div>
                                            
                                            <!-- Price Highlight -->
                                            <div class="text-center mb-3 p-3 bg-white rounded border ${isBestPrice ? 'border-green-200 bg-green-50' : 'border-gray-200'}">
                                                <div class="text-2xl font-extrabold ${isBestPrice ? 'text-green-700' : 'text-green-600'}">
                                                    BND ${store.price.toFixed(2)}
                                                </div>
                                                <div class="text-gray-600 text-sm">per kg</div>
                                            </div>
                                            
                                            <!-- Store Details -->
                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-600">📍 Distance:</span>
                                                    <span class="font-semibold text-blue-600">${store.distance}</span>
                                                </div>
                                                
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-600">⏱️ Travel Time:</span>
                                                    <span class="font-semibold text-gray-700">${store.travel_time}</span>
                                                </div>
                                                
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-600">🕒 Store Hours:</span>
                                                    <span class="font-semibold text-gray-700">${store.store_hours}</span>
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