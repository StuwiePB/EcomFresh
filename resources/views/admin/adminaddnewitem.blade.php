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

    <form action="{{ route('items.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" name="name" required
               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
          <option value="Chicken">Chicken</option>
          <option value="Beef">Beef</option>
          <option value="Vegetables">Vegetables</option>
          <option value="Seafood">Seafood</option>
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

      <button type="submit"
              class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Save Item
      </button>
    </form>
  </div>
</body>
</html>
