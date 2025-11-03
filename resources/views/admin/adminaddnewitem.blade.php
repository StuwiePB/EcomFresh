<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Item</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md bg-white p-6 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Add New Item</h2>

    <!-- Only one form -->
    <form id="addItemForm" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" name="name" required
               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select id="categorySelect" name="category" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
          <option value="">-- Select Category --</option>
          <option value="chicken">Chicken</option>
          <option value="beef">Beef</option>
          <option value="vegetable">Vegetables</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" step="0.01" name="price" required
               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Stock</label>
        <input type="number" name="stock" required
               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
      </div>

<!-- After the stock field -->
<!-- Store Prices -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Store Prices</label>
    @foreach($stores as $store)
    <div class="flex items-center mb-2">
        <label class="w-1/3 text-gray-600">{{ $store->name }} Price (BND)</label>
        <input type="number" step="0.01" min="0" 
               name="prices[{{ $store->id }}]" 
               value="{{ old('prices.' . $store->id, '0') }}"
               class="w-2/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
               required>
    </div>
    @endforeach
</div>

      <button type="submit"
              class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Save Item
      </button>
    </form>
  </div>

  <script>
    const form = document.getElementById('addItemForm');
    const categorySelect = document.getElementById('categorySelect');

    form.addEventListener('submit', function(e) {
      const category = categorySelect.value;

      if (!category) {
        e.preventDefault();
        alert('Please select a category.');
        return;
      }

      // Set the action dynamically based on selected category
      switch(category) {
        case 'chicken':
          form.action = "{{ route('admin.chicken.store') }}";
          break;
        case 'beef':
          form.action = "{{ route('admin.beef.store') }}";
          break;
        case 'vegetable':
          form.action = "{{ route('admin.vegetable.store') }}";
          break;
        default:
          e.preventDefault();
          alert('Invalid category selected.');
      }
    });
  </script>
</body>
</html>
