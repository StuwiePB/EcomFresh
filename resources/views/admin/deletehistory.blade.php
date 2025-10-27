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
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl sm:text-2xl font-extrabold text-[color:var(--brand)]">Delete History</h2>
        <button id="refreshBtn" class="bg-[color:var(--brand)] text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
          🔄 Refresh
        </button>
      </div>

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
          <tbody id="deleteTable" class="divide-y divide-gray-200">
            @foreach ($deletedItems as $index => $item)
              <tr>
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2 font-semibold">{{ $item->name }}</td>
                <td class="px-4 py-2">{{ $item->category }}</td>
                <td class="px-4 py-2">{{ $item->quantity ?? '-' }}</td>
                <td class="px-4 py-2 text-gray-500">
                  {{ optional($item->deleted_at)->format('d M Y') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    document.getElementById('refreshBtn').addEventListener('click', async () => {
      const res = await fetch('{{ route("admin.deletehistory.fetch") }}');
      const data = await res.json();

      const table = document.getElementById('deleteTable');
      table.innerHTML = '';

      if (data.length === 0) {
        table.innerHTML = `
          <tr><td colspan="5" class="text-center py-4 text-gray-500 italic">No deleted items yet.</td></tr>
        `;
        return;
      }

      data.forEach((item, index) => {
        const deletedAt = item.deleted_at
          ? new Date(item.deleted_at).toLocaleString('en-GB', { dateStyle: 'medium', timeStyle: 'short' })
          : '-';
        table.innerHTML += `
          <tr>
            <td class="px-4 py-2">${index + 1}</td>
            <td class="px-4 py-2 font-semibold">${item.name}</td>
            <td class="px-4 py-2">${item.category}</td>
            <td class="px-4 py-2">${item.quantity ?? '-'}</td>
            <td class="px-4 py-2 text-gray-500">${deletedAt}</td>
          </tr>`;
      });
    });
  </script>
</body>
</html>
