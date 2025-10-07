<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Delete History • ECOM FRESH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --brand: #134EF5; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-[color:var(--brand)] text-white py-4 shadow">
    <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-wide">ECOM FRESH</h1>
      <a href="{{ route('admin.dashboard') }}"
         class="bg-white text-[color:var(--brand)] px-3 py-1.5 rounded-lg font-semibold hover:bg-gray-200 transition">
        ← Back
      </a>
    </div>
  </header>

  <!-- Main -->
  <main class="flex-1 flex flex-col items-center px-4 py-8 sm:py-10">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow p-6 sm:p-8">
      <h2 class="text-xl sm:text-2xl font-extrabold text-[color:var(--brand)] mb-6 text-center">Delete History</h2>

      <!-- Delete History Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm sm:text-base">
          <thead class="bg-[color:var(--brand)] text-white">
            <tr>
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Item Name</th>
              <th class="px-4 py-2 text-left">Category</th>
              <th class="px-4 py-2 text-left">Quantity</th>
              <th class="px-4 py-2 text-left">Deleted At</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($deletedItems as $index => $item)
              <tr>
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2 font-semibold">{{ $item->name }}</td>
                <td class="px-4 py-2">{{ $item->category }}</td>
                <td class="px-4 py-2">{{ $item->quantity ?? '-' }}</td>
                <td class="px-4 py-2 text-gray-500">{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-500 italic">No deleted items yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>

</body>
</html>
