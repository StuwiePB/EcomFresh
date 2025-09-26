<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcomFresh - Fresh Products Delivered</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-green-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center space-x-4">
                <!-- Logo Placeholder -->
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-leaf text-green-600 text-2xl"></i>
                </div>
                <!-- App Name -->
                <div>
                    <h1 class="text-3xl font-bold">E-COM FRESH</h1>
                    <p class="text-green-100"></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Categories Section -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Categories</h2>
            
            <div class="space-y-6">
                @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center p-6">
                        <!-- Category Image Placeholder -->
                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center mr-6">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                        
                        <!-- Category Info -->
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $category['name'] }}</h3>
                            <p class="text-gray-600 mt-1">{{ $category['description'] }}</p>
                        </div>
                        
                        <!-- Arrow Indicator -->
                        <div class="text-green-600">
                            <i class="fas fa-chevron-right text-lg"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p>&copy; 2024 EcomFresh. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>