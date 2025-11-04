<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - ECOM FRESH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-700 text-white flex items-center px-4 py-3">
        <a href="{{ route('admin.dashboard') }}" class="mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold">ECOM FRESH - Edit Chicken</h1>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-4 flex flex-col items-center">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center w-full max-w-3xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-center w-full max-w-3xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="w-full max-w-3xl">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route($backRoute) }}" class="flex items-center text-blue-700 hover:text-blue-900 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Chicken List
                </a>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Chicken Product</h2>

                <form action="{{ route($updateRoute, $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('name') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            rows="3">{{ old('description', $item->description) }}</textarea>
                        @error('description') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('stock') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Store Prices Section - FIXED -->
                    <div class="border-t pt-6">
                        <label class="block text-lg font-semibold text-gray-700 mb-4">Store Prices</label>
                        
                        @if(isset($stores) && $stores->count() > 0)
                            <div class="space-y-4">
                                @foreach($stores as $store)
                                    @php
                                        // Get the current price for this store from the pivot table
                                        $storePrice = $item->stores->firstWhere('id', $store->id);
                                        $currentPrice = $storePrice ? ($storePrice->pivot->current_price ?? 0) : 0;
                                    @endphp
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50">
                                        <label class="text-sm font-medium text-gray-700">
                                            {{ $store->store_name ?? $store->name }}
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-500">BND</span>
                                            <input type="number" step="0.01" min="0" 
                                                   name="prices[{{ $store->id }}]" 
                                                   value="{{ old('prices.'.$store->id, $currentPrice) }}" 
                                                   class="w-32 border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                   required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-yellow-700 text-sm">
                                    No stores available. Please add stores in the admin panel first.
                                </p>
                            </div>
                        @endif
                        @error('prices') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                            Update Chicken Product
                        </button>
                        <a href="{{ route($backRoute) }}"
                            class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition font-semibold text-lg text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>