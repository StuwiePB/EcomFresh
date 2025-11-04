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
                        <p class="text-blue-600 font-medium text-sm md:text-base">{{ $title }}</p>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-2 justify-center">
                    <a href="/customer" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-medium text-sm w-full sm:w-auto text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                    </a>
                    <!-- Removed "Today's Prices" button per request -->
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 800;">{{ $title }}</h2>
            <p class="text-xl text-gray-600">Tracks average price trends over the last 3 months</p>
            <p class="text-lg text-gray-700 mt-2">{{ $location }}</p>
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

    <!-- JavaScript for Dynamic Charts -->
    <script>
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