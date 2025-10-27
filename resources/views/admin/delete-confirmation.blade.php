<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Confirm Delete • ECOM FRESH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full text-center">
    <div class="text-6xl mb-4">⚠️</div>
    <h1 class="text-2xl font-bold mb-2">Confirm Delete</h1>
    <p class="text-gray-600 mb-6">Are you sure you want to delete <strong>{{ $item->name }}</strong>?</p>

    <form action="{{ $destroyRoute }}" method="POST" class="flex justify-center gap-4">
        @csrf
        @method('DELETE')

        <a href="{{ route('admin.chicken-crud') }}" 
           class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
           Cancel
        </a>

        <button type="submit" 
                class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
           Yes, Delete
        </button>
    </form>
  </div>

</body>
</html>
