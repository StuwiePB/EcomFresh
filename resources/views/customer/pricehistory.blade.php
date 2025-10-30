<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - EcomFresh</title>
    
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
        
        .price-increase {
            color: #EF4444;
        }
        
        .price-decrease {
            color: #10B981;
        }
        
        .price-stable {
            color: #6B7280;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar.open {
            transform: translateX(0);
        }
        
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        /* Hamburger Menu Animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }
        
        .hamburger.open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .hamburger.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Left Section: Hamburger + Logo -->
                <div class="flex items-center space-x-4">
                    <!-- Hamburger Menu Button -->
                    <button onclick="toggleSidebar()" class="hamburger p-2 rounded-lg hover:bg-blue-50 transition duration-300 group">
                        <div class="w-6 h-6 flex flex-col justify-between">
                            <div class="hamburger-line w-full h-0.5 bg-gray-700 rounded group-hover:bg-blue-600"></div>
                            <div class="hamburger-line w-full h-0.5 bg-gray-700 rounded group-hover:bg-blue-600"></div>
                            <div class="hamburger-line w-full h-0.5 bg-gray-700 rounded group-hover:bg-blue-600"></div>
                        </div>
                    </button>

                    <!-- Logo and Title -->
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 md:w-16 md:h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-leaf text-white text-xl md:text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                            <p class="text-blue-600 font-medium text-sm md:text-base">{{ $title }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-2 justify-center">
                    <a href="/customer" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                    </a>
                    <a href="/todaysprice" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                        <i class="fas fa-tag mr-2"></i>Today's Prices
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleSidebar()"></div>

    <!-- Quick Access Sidebar -->
    <div id="sidebar" class="sidebar fixed left-0 top-0 h-full w-80 bg-white/95 backdrop-blur-md shadow-2xl z-50 border-r border-gray-200">
        <div class="p-6 h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Quick Navigation</h2>
                <button onclick="toggleSidebar()" class="hamburger p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="w-6 h-6 relative">
                        <div class="absolute top-1/2 left-1/2 w-6 h-0.5 bg-gray-700 rounded transform -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
                        <div class="absolute top-1/2 left-1/2 w-6 h-0.5 bg-gray-700 rounded transform -translate-x-1/2 -translate-y-1/2 -rotate-45"></div>
                    </div>
                </button>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3 flex-1">
                <!-- All Products -->
                <a href="/pricehistory" onclick="toggleSidebar()" class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100 transition group hover:shadow-md">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4 shadow-sm">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">All Products</h3>
                        <p class="text-sm text-gray-600">View all price trends</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 transition"></i>
                </a>

                <!-- Beef Prices -->
                <a href="/beef-prices" onclick="toggleSidebar()" class="flex items-center p-4 bg-red-50 rounded-lg border border-red-200 hover:bg-red-100 transition group hover:shadow-md">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-4 shadow-sm">
                        <i class="fas fa-drumstick-bite text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 group-hover:text-red-600">Beef Price Trend</h3>
                        <p class="text-sm text-gray-600">Ribeye, Sirloin & more</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-500 transition"></i>
                </a>

                <!-- Hua Ho -->
                <a href="/huaho-prices" onclick="toggleSidebar()" class="flex items-center p-4 bg-green-50 rounded-lg border border-green-200 hover:bg-green-100 transition group hover:shadow-md">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4 shadow-sm">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 group-hover:text-green-600">Hua Ho Price Trend</h3>
                        <p class="text-sm text-gray-600">Store-specific prices</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-500 transition"></i>
                </a>

                <!-- Soon Lee -->
                <a href="/soonlee-prices" onclick="toggleSidebar()" class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-200 hover:bg-purple-100 transition group hover:shadow-md">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4 shadow-sm">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 group-hover:text-purple-600">Soon Lee Price Trend</h3>
                        <p class="text-sm text-gray-600">Store-specific prices</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-500 transition"></i>
                </a>
            </div>

            <!-- Statistics -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                    Quick Stats
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Products Tracked:</span>
                        <span class="font-semibold">{{ count($products) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Price Increases:</span>
                        <span class="font-semibold text-red-600">
                            {{ collect($products)->where('trend', 'increase')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Price Decreases:</span>
                        <span class="font-semibold text-green-600">
                            {{ collect($products)->where('trend', 'decrease')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>EcomFresh v1.0</span>
                    <span>Price Tracker</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">{{ $title }}</h2>
            <p class="text-xl text-gray-600">Tracks average price trends over the last 3 months</p>
            <p class="text-lg text-gray-700 mt-2">{{ $location }}</p>
            
            <!-- Quick Access Hint -->
            <div class="mt-4 inline-flex items-center bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full border border-blue-200">
                <i class="fas fa-bars text-blue-500 mr-2"></i>
                <span class="text-sm text-gray-700">Use the menu icon for quick navigation</span>
            </div>
        </div>

        <!-- Products Price History -->
        <div class="space-y-8">
            @foreach($products as $index => $product)
            <div class="product-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 overflow-hidden">
                <div class="flex items-center bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <!-- Product Image -->
                    <div class="w-16 h-16 rounded-lg overflow-hidden mr-4 border border-blue-200 shadow-sm flex-shrink-0">
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center">
                            <i class="fas fa-drumstick-bite text-orange-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-gray-600">{{ $product['description'] }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-extrabold 
                            @if($product['trend'] === 'increase') text-red-600
                            @elseif($product['trend'] === 'decrease') text-green-600
                            @else text-gray-600 @endif">
                            BND {{ number_format($product['currentPrice'], 2) }}
                        </div>
                        <div class="text-sm font-semibold 
                            @if($product['trend'] === 'increase') price-increase
                            @elseif($product['trend'] === 'decrease') price-decrease
                            @else price-stable @endif">
                            @if($product['trend'] === 'increase')
                                <i class="fas fa-arrow-up mr-1"></i>
                            @elseif($product['trend'] === 'decrease')
                                <i class="fas fa-arrow-down mr-1"></i>
                            @else
                                <i class="fas fa-minus mr-1"></i>
                            @endif
                            {{ number_format(abs($product['percentageChange']), 1) }}% 
                            @if($product['trend'] !== 'stable')
                                from last month
                            @else
                                no change from last month
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Price Chart -->
                        <div class="chart-container">
                            <canvas id="chart{{ $index }}"></canvas>
                        </div>
                        
                        <!-- Price History Table -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Current Month -->
                            <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-600 mb-1">Current Month</div>
                                <div class="text-2xl font-bold text-green-600">
                                    BND {{ number_format($product['priceHistory']['current'], 2) }}
                                </div>
                            </div>
                            
                            <!-- Last Month -->
                            <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-600 mb-1">Last Month</div>
                                <div class="text-xl font-bold text-gray-700">
                                    BND {{ number_format($product['priceHistory']['lastMonth'], 2) }}
                                </div>
                                <div class="text-sm font-semibold 
                                    @if($product['priceHistory']['lastMonth'] > $product['priceHistory']['current']) price-decrease
                                    @elseif($product['priceHistory']['lastMonth'] < $product['priceHistory']['current']) price-increase
                                    @else price-stable @endif">
                                    @if($product['priceHistory']['lastMonth'] != $product['priceHistory']['current'])
                                        {{ number_format($product['priceHistory']['lastMonth'] - $product['priceHistory']['current'], 2) }}
                                    @else
                                        0.00
                                    @endif
                                </div>
                            </div>
                            
                            <!-- 2 Months Ago -->
                            <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-600 mb-1">2 Months Ago</div>
                                <div class="text-xl font-bold text-gray-700">
                                    BND {{ number_format($product['priceHistory']['twoMonthsAgo'], 2) }}
                                </div>
                            </div>
                            
                            <!-- 3 Months Ago -->
                            <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-600 mb-1">3 Months Ago</div>
                                <div class="text-xl font-bold text-gray-700">
                                    BND {{ number_format($product['priceHistory']['threeMonthsAgo'], 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden data for JavaScript charts -->
            <div class="hidden" id="chartData{{ $index }}"
                 data-name="{{ $product['name'] }}"
                 data-three-months="{{ $product['priceHistory']['threeMonthsAgo'] }}"
                 data-two-months="{{ $product['priceHistory']['twoMonthsAgo'] }}"
                 data-last-month="{{ $product['priceHistory']['lastMonth'] }}"
                 data-current="{{ $product['priceHistory']['current'] }}"
                 data-trend="{{ $product['trend'] }}">
            </div>
            @endforeach
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. Track prices and save money.</p>
        </div>
    </footer>

    <!-- JavaScript for Dynamic Charts and Sidebar -->
    <script>
        // Sidebar functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburger = document.querySelector('.hamburger');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            hamburger.classList.toggle('open');
        }

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const hamburger = document.querySelector('.hamburger');
                
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                hamburger.classList.remove('open');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get current month and previous months
            const months = [];
            const currentDate = new Date();
            for (let i = 3; i >= 0; i--) {
                const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
                months.push(date.toLocaleString('default', { month: 'short' }));
            }

            // Create charts for each product
            const productCount = {{ count($products) }};
            
            for (let i = 0; i < productCount; i++) {
                const chartDataElement = document.getElementById('chartData' + i);
                if (!chartDataElement) continue;

                const productName = chartDataElement.getAttribute('data-name');
                const threeMonthsAgo = parseFloat(chartDataElement.getAttribute('data-three-months'));
                const twoMonthsAgo = parseFloat(chartDataElement.getAttribute('data-two-months'));
                const lastMonth = parseFloat(chartDataElement.getAttribute('data-last-month'));
                const current = parseFloat(chartDataElement.getAttribute('data-current'));
                const trend = chartDataElement.getAttribute('data-trend');

                // Set chart color based on trend
                let chartColor;
                if (trend === 'increase') {
                    chartColor = '#EF4444'; // Red for increase
                } else if (trend === 'decrease') {
                    chartColor = '#10B981'; // Green for decrease
                } else {
                    chartColor = '#6B7280'; // Gray for stable
                }

                const ctx = document.getElementById('chart' + i).getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: productName + ' Price (BND)',
                            data: [threeMonthsAgo, twoMonthsAgo, lastMonth, current],
                            borderColor: chartColor,
                            backgroundColor: trend === 'increase' ? 'rgba(239, 68, 68, 0.1)' : 
                                          trend === 'decrease' ? 'rgba(16, 185, 129, 0.1)' : 
                                          'rgba(107, 114, 128, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: productName + ' Price Trend',
                                font: {
                                    size: 16,
                                    family: 'Poppins'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Price (BND)'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>