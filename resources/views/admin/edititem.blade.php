<!-- resources/views/admin/edititem.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - ECOM FRESH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center pt-10">

    <!-- Back Button -->
    <div class="w-full max-w-3xl mb-6 px-4">
        <a href="{{ route($backRoute) }}" class="flex items-center text-blue-700 hover:text-blue-900 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <!-- Form Container -->
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Item</h1>

        <form action="{{ route($updateRoute, $item->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <input type="text" name="category" value="{{ old('category', $item->category ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('category') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Stock -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $item->stock) }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- After the stock field -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Store Prices</label>
                 @foreach($stores as $store)
                  @php
        // Determine the current price for this store. Support both CustomerProduct (with stores relation)
        // and legacy admin models (Beef/Vegetable) that provide a single price on the model.
        $inputName = 'prices.' . $store->id;
        $defaultPrice = '0';
        if (!empty($item) && isset($item->stores)) {
            $found = $item->stores->firstWhere('id', $store->id);
            $defaultPrice = $found && isset($found->pivot) ? ($found->pivot->current_price ?? '0') : '0';
        } else {
            // fallback to legacy model price field if present
            $defaultPrice = $item->price ?? '0';
        }
        $value = old($inputName, $defaultPrice);

        // Compute a friendly display label mapping older store names to Soon Lee branches
        $lower = strtolower($store->name ?? '');
        if (str_contains($lower, 'supa') || str_contains($lower, 'supasave')) {
            $displayName = 'Soon Lee Bandar Seri Begawan';
        } elseif (str_contains($lower, 'gadong')) {
            $displayName = 'Soon Lee Gadong';
        } elseif (str_contains($lower, 'bandar') || str_contains($lower, 'begawan') || str_contains($lower, 'seri')) {
            $displayName = 'Soon Lee Bandar Seri Begawan';
        } elseif (str_contains($lower, 'soon')) {
            $displayName = 'Soon Lee Gadong';
        } else {
            $displayName = $store->name;
        }
    @endphp
    <div class="flex items-center mb-2">
        <label class="w-1/3 text-gray-600">{{ $displayName }} Price (BND)</label>
        <input type="number" step="0.01" min="0" 
               name="prices[{{ $store->id }}]" 
               value="{{ $value }}"
               class="w-2/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
               required>
    </div>
    @endforeach
</div>
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                Save Item
            </button>
        </form>
    </div>
</body>
</html>
