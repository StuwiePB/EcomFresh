<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcomFresh</title>
    
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
        
        .category-card {
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .logo-placeholder {
            background: linear-gradient(135deg, #1e90ff, #00bfff);
            cursor: pointer;
        }
        
        .category-image {
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-image {
            transform: scale(1.05);
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .popup-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .popup-overlay.active .popup-content {
            transform: scale(1);
        }
        
        .profile-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            color: #374151;
            text-decoration: none;
        }
        
        .profile-link:hover {
            background-color: #f3f4f6;
            color: #1e40af;
        }
        
        /* Mobile Optimizations */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .header-flex {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .mobile-stack {
        flex-direction: column;
        width: 100%;
    }
    
    .mobile-stack a,
    .mobile-stack button {
        width: 100%;
        text-align: center;
    }
    
    .mobile-text {
        font-size: 1.5rem !important;
    }
    
    .mobile-subtext {
        font-size: 0.875rem !important;
    }
}
    </style>
</head>
<body class="min-h-screen">
<!-- Header -->
<header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
    <div class="container mx-auto px-4 py-4">
        <div class="header-flex flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center justify-center md:justify-start space-x-4">
                <!-- Logo Placeholder -->
                <div class="w-12 h-12 md:w-16 md:h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md" id="logoButton">
                    <i class="fas fa-leaf text-white text-xl md:text-2xl"></i>
                </div>
                <!-- App Name -->
                <div class="text-center md:text-left">
                    <h1 class="mobile-text text-2xl md:text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                    <p class="mobile-subtext text-blue-600 font-medium text-sm md:text-base">Compare Prices & Find the Best Deals</p>
                </div>
            </div>
            
            <!-- Favorites Button -->
            <div class="flex justify-center md:justify-end">
                <a href="/customer/favorites" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 font-medium text-sm w-full md:w-auto text-center">
                    <i class="fas fa-star mr-2"></i>My Favorites
                </a>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
   <!-- Main Content -->
   <div class="space-y-6">
     <main class="container mx-auto px-4 py-8">
    @foreach($categories as $category)
    <a href="{{ route('customer.category', ['category' => strtolower($category['name'])]) }}" class="block category-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 hover:no-underline">
        <div class="flex items-center p-6">
            <!-- Category Image -->
            <div class="w-24 h-24 rounded-lg overflow-hidden mr-6 border border-blue-200 flex-shrink-0">
                @if(file_exists(public_path($category['image'])))
                    <img 
                        src="{{ asset($category['image']) }}" 
                        alt="{{ $category['name'] }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <!-- Fallback placeholder if image doesn't exist -->
                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                        <i class="fas fa-image text-blue-400 text-2xl"></i>
                    </div>
                @endif
            </div>
            
            <!-- Category Info -->
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ $category['name'] }}</h3>
                <p class="text-gray-600 mt-1 font-medium">{{ $category['description'] }}</p>
            </div>
            
            <!-- Arrow Indicator -->
            <div class="text-blue-600">
                <i class="fas fa-chevron-right text-lg"></i>
            </div>
        </div>
    </a>
    @endforeach
</div>

    <!-- Profile Popup -->
    <div class="popup-overlay" id="profilePopup">
        <div class="popup-content">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">User Profile</h2>
                    <button id="closePopup" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="p-6">
                <!-- User Info -->
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                        S
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Stuart</h3>
                        <p class="text-gray-600">Customer</p>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Quick Links</h3>
                    <div class="space-y-2">
                        <!-- Today's Prices Link -->
                        <a href="/todaysprice" class="profile-link">
                            <i class="fas fa-chart-line text-blue-500 mr-3"></i>
                            <div>
                                <div class="font-medium">Today's Prices</div>
                                <div class="text-sm text-gray-500">View current market prices</div>
                            </div>
                        </a>
                        
                        <!-- Price History Link -->
                        <a href="/pricehistory" class="profile-link">
                            <i class="fas fa-history text-green-500 mr-3"></i>
                            <div>
                                <div class="font-medium">Price History</div>
                                <div class="text-sm text-gray-500">Track price trends over time</div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Account Actions -->
                <a href="/customer/settings" class="profile-link">
    <i class="fas fa-cog text-gray-500 mr-3"></i>
    <div class="font-medium">Settings</div>
</a>
        </a>
        
        <a href="#" class="profile-link">
            <i class="fas fa-sign-out-alt text-red-500 mr-3"></i>
            <div class="font-medium">Logout</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Popup functionality
        document.addEventListener('DOMContentLoaded', function() {
            const logoButton = document.getElementById('logoButton');
            const profilePopup = document.getElementById('profilePopup');
            const closePopup = document.getElementById('closePopup');
            
            // Open popup when logo is clicked
            logoButton.addEventListener('click', function() {
                profilePopup.classList.add('active');
            });
            
            // Close popup when close button is clicked
            closePopup.addEventListener('click', function() {
                profilePopup.classList.remove('active');
            });
            
            // Close popup when clicking outside the content
            profilePopup.addEventListener('click', function(e) {
                if (e.target === profilePopup) {
                    profilePopup.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>