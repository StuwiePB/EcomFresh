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
            background: linear-gradient(135deg, #1e90ff 0%, #ffffff 100%);
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
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center space-x-4">
                <!-- Logo Placeholder -->
                <div class="w-16 h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                    <i class="fas fa-leaf text-white text-2xl"></i>
                </div>
                <!-- App Name -->
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                    <p class="text-blue-600 font-medium"></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Categories Section -->
        <section>
            <h2 class="text-2xl font-extrabold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 800;">Categories</h2>
            
            <div class="space-y-6">
                @foreach($categories as $category)
                <div class="category-card bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50">
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
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>