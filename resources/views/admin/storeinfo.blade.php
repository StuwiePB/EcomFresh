<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Store Information • ECOM FRESH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --brand: #134EF5; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-[color:var(--brand)] text-white text-center py-4 shadow">
    <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-wide">ECOM FRESH</h1>
  </header>

  <!-- Main Content -->
  <main class="flex-1 flex flex-col items-center justify-center px-4 py-10">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg p-6 sm:p-8">

      <h2 class="text-xl sm:text-2xl font-extrabold text-center text-[color:var(--brand)] mb-6">
        Store Information
      </h2>

      <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Store Name -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Store Name</label>
          <input type="text" name="store_name" placeholder="Enter store name" required
                 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)]">
        </div>

        <!-- Store Picture -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Store Picture</label>
          <input type="file" name="store_picture" accept="image/*"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)]">
        </div>

        <!-- Store Location -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Store Location (Map Link)</label>
          <input type="url" name="store_location" placeholder="Paste Google Maps link"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)]">
        </div>

        <!-- Store Address -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Store Address</label>
          <input type="text" name="store_address" placeholder="Enter store address"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)]">
        </div>

        <!-- Store Description -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Details About the Store</label>
          <textarea name="store_details" rows="4" placeholder="Write a short description about your store..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)]"></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center gap-3 pt-4">
          <a href="{{ route('admin.dashboard') }}"
             class="bg-gray-300 text-gray-800 px-5 py-2 rounded-full hover:bg-gray-400 transition">
            Cancel
          </a>
          <button type="submit"
                  class="bg-[color:var(--brand)] text-white px-6 py-2 rounded-full font-semibold hover:bg-blue-800 transition">
            Save Information
          </button>
        </div>
      </form>
    </div>
  </main>

</body>
</html>
