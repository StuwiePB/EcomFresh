<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                border: none;
                background: none;
                width: 100%;
                text-align: left;
                cursor: pointer;
                font-family: inherit;
            }
            
            .profile-link:hover {
                background-color: #f3f4f6;
                color: #1e40af;
            }
            
            .hidden {
                display: none;
            }

            .profile-avatar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                cursor: pointer;
                transition: all 0.3s ease;
                border: 3px solid white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .profile-avatar:hover {
                transform: scale(1.05);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .settings-section {
                margin-bottom: 24px;
            }

            .settings-section-title {
                font-size: 18px;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 16px;
                padding-bottom: 8px;
                border-bottom: 2px solid #e5e7eb;
            }

            .settings-item {
                display: flex;
                align-items: center;
                justify-content: between;
                padding: 12px 0;
                border-bottom: 1px solid #f3f4f6;
            }

            .settings-item:last-child {
                border-bottom: none;
            }

            .settings-label {
                flex: 1;
                font-weight: 500;
                color: #374151;
            }

            .settings-value {
                color: #6b7280;
                margin-right: 12px;
            }

            .settings-action {
                color: #3b82f6;
                font-weight: 500;
                cursor: pointer;
                transition: color 0.2s ease;
            }

            .settings-action:hover {
                color: #1d4ed8;
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

                .header-buttons {
                    flex-direction: row;
                    justify-content: center;
                    gap: 1rem;
                    width: 100%;
                }
            }

            /* Price Trends specific styles - Blended with popup background */
            .price-trends-icon {
                background: #f8fafc;
                border: 2px solid #e2e8f0;
            }
            
            .price-trends-icon .fas {
                color: #3b82f6;
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
                    <div class="w-12 h-12 md:w-16 md:h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-leaf text-white text-xl md:text-2xl"></i>
                    </div>
                    <!-- App Name -->
                    <div class="text-center md:text-left">
                        <h1 class="mobile-text text-2xl md:text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                        <p class="mobile-subtext text-blue-600 font-medium text-sm md:text-base">Compare Prices & Find the Best Deals</p>
                    </div>
                </div>
                
                <!-- Header Buttons -->
                <div class="header-buttons flex items-center justify-center md:justify-end space-x-3">
                    <!-- Favorites Button -->
                    <a href="/customer/favorites" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 font-medium text-sm flex items-center justify-center">
                        <i class="fas fa-star mr-2"></i>My Favorites
                    </a>
                    
                    <!-- Profile Avatar -->
                    <div class="profile-avatar w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center text-white font-bold text-lg md:text-xl" id="profileAvatar">
                        @auth
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @else
                            <i class="fas fa-user"></i>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
<div class="space-y-6">
    <main class="container mx-auto px-4 py-8">
        @foreach($categories as $category)
        <a href="{{ route('customer.category', $category->slug) }}" class="block category-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 hover:no-underline">
            <div class="flex items-center p-6">
                <!-- Category Image -->
                <div class="w-24 h-24 rounded-lg overflow-hidden mr-6 border border-blue-200 flex-shrink-0">
                    @if(file_exists(public_path($category->image)))
                        <img 
                            src="{{ asset($category->image) }}" 
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover"
                        >
                    @else
                        <!-- Fallback placeholder if image doesn't exist -->
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                            <i class="fas fa-{{ $category->icon }} text-blue-400 text-2xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Category Info -->
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">{{ $category->name }}</h3>
                    <p class="text-gray-600 mt-1 font-medium">{{ $category->description }}</p>
                    <p class="text-blue-600 text-sm mt-2">{{ $category->products_count }} products available</p>
                </div>
                
                <!-- Arrow Indicator -->
                <div class="text-blue-600">
                    <i class="fas fa-chevron-right text-lg"></i>
                </div>
            </div>
        </a>
        @endforeach
    </main>
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
                        @auth
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @else
                            U
                        @endauth
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            @auth
                                {{ Auth::user()->name }}
                            @else
                                User
                            @endauth
                        </h3>
                        <p class="text-gray-600">Customer</p>
                    </div>
                </div>
                
                
                <!-- Account Actions -->
                <div class="space-y-2">
                    <a href="/customer/settings" class="profile-link">
                        <i class="fas fa-cog text-gray-500 mr-3"></i>
                        <div class="font-medium">Account Settings</div>
                    </a>
                    
                    <!-- Logout Button -->
                    <button onclick="logoutAndRedirect()" class="profile-link">
                        <i class="fas fa-sign-out-alt text-red-500 mr-3"></i>
                        <div class="font-medium">Logout</div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Popup -->
    <div class="popup-overlay" id="settingsPopup">
        <div class="popup-content">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Account Settings</h2>
                    <button id="closeSettingsPopup" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Settings Content -->
            <div class="p-6">
                <!-- Profile Information Section -->
                <div class="settings-section">
                    <h3 class="settings-section-title">Profile Information</h3>
                    <div class="space-y-3">
                        <div class="settings-item">
                            <div class="settings-label">Full Name</div>
                            <div class="settings-value">
                                @auth
                                    {{ Auth::user()->name }}
                                @else
                                    Not set
                                @endauth
                            </div>
                            <div class="settings-action">Edit</div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">Email Address</div>
                            <div class="settings-value">
                                @auth
                                    {{ Auth::user()->email }}
                                @else
                                    Not set
                                @endauth
                            </div>
                            <div class="settings-action">Edit</div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">Phone Number</div>
                            <div class="settings-value">Not set</div>
                            <div class="settings-action">Add</div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="settings-section">
                    <h3 class="settings-section-title">Security</h3>
                    <div class="space-y-3">
                        <div class="settings-item">
                            <div class="settings-label">Password</div>
                            <div class="settings-value">••••••••</div>
                            <div class="settings-action">Change</div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">Two-Factor Authentication</div>
                            <div class="settings-value">Disabled</div>
                            <div class="settings-action">Enable</div>
                        </div>
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="settings-section">
                    <h3 class="settings-section-title">Preferences</h3>
                    <div class="space-y-3">
                        <div class="settings-item">
                            <div class="settings-label">Email Notifications</div>
                            <div class="settings-value">Enabled</div>
                            <div class="settings-action">Manage</div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">Language</div>
                            <div class="settings-value">English</div>
                            <div class="settings-action">Change</div>
                        </div>
                        <div class="settings-item">
                            <div class="settings-label">Currency</div>
                            <div class="settings-value">USD ($)</div>
                            <div class="settings-action">Change</div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone Section -->
                <div class="settings-section">
                    <h3 class="settings-section-title" style="color: #dc2626;">Danger Zone</h3>
                    <div class="space-y-3">
                        <div class="settings-item">
                            <div class="settings-label">Delete Account</div>
                            <div class="settings-value">Permanently remove your account</div>
                            <button class="settings-action text-red-600 hover:text-red-800 font-medium" 
                                    onclick="showDeleteConfirmation()" 
                                    style="color: #dc2626;">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Popup functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profileAvatar = document.getElementById('profileAvatar');
            const profilePopup = document.getElementById('profilePopup');
            const closePopup = document.getElementById('closePopup');
            const settingsPopup = document.getElementById('settingsPopup');
            const closeSettingsPopup = document.getElementById('closeSettingsPopup');
            
            // Open profile popup when profile avatar is clicked
            if (profileAvatar) {
                profileAvatar.addEventListener('click', function() {
                    profilePopup.classList.add('active');
                });
            }
            
            // Close profile popup when close button is clicked
            if (closePopup) {
                closePopup.addEventListener('click', function() {
                    profilePopup.classList.remove('active');
                });
            }
            
            // Close settings popup when close button is clicked
            if (closeSettingsPopup) {
                closeSettingsPopup.addEventListener('click', function() {
                    settingsPopup.classList.remove('active');
                });
            }
            
            // Close popups when clicking outside the content
            if (profilePopup) {
                profilePopup.addEventListener('click', function(e) {
                    if (e.target === profilePopup) {
                        profilePopup.classList.remove('active');
                    }
                });
            }
            
            if (settingsPopup) {
                settingsPopup.addEventListener('click', function(e) {
                    if (e.target === settingsPopup) {
                        settingsPopup.classList.remove('active');
                    }
                });
            }

            // Open settings from profile popup
            const settingsLink = document.querySelector('a[href="/customer/settings"]');
            if (settingsLink) {
                settingsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    profilePopup.classList.remove('active');
                    settingsPopup.classList.add('active');
                });
            }
        });

        // Logout function that redirects to login page
        function logoutAndRedirect() {
            // Close the popup first
            document.getElementById('profilePopup').classList.remove('active');
            
            // Submit the logout form
            document.getElementById('logout-form').submit();
            
            // The redirect will be handled by the server in the CustomerAuthController
        }
    </script>
    
</body>
</html>