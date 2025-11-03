<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ECOM FRESH - Vegetable List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-blue-700 text-white flex items-center px-4 py-3">
    <a href="{{ route('admin.dashboard') }}" class="mr-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 19l-7-7 7-7" />
      </svg>
    </a>
    <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold">ECOM FRESH</h1>
  </header>

  <!-- Main content -->
  <main class="flex-1 p-4 flex flex-col items-center">

    <!-- Success message -->
    @if (session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center w-full max-w-3xl">
        {{ session('success') }}
      </div>
    @endif

    <div class="w-full max-w-3xl">
      <!-- Page header with controls -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Vegetable List</h2>

        <div class="flex gap-2">
          <select id="itemType" class="border rounded px-3 py-2">
            <option value="{{ route('admin.chicken-crud') }}" {{ request()->is('admin/chicken-crud') ? 'selected' : '' }}>Chicken</option>
            <option value="{{ route('admin.beef-crud') }}" {{ request()->is('admin/beef-crud') ? 'selected' : '' }}>Beef</option>
            <option value="{{ route('admin.vegetable-crud') }}" {{ request()->is('admin/vegetable-crud') ? 'selected' : '' }}>Vegetable</option>
          </select>

          <a id="newButton" href="{{ route('admin.vegetable.create') }}" 
             class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
            New
          </a>
        </div>
      </div>

      <!-- Items grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($vegetables as $vegetable)
          <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="text-4xl">🥦</div>
              <div class="flex flex-col space-y-1">
                <h3 class="font-bold text-lg">{{ $vegetable->name }}</h3>
                <p class="text-sm text-gray-500">Category: {{ $vegetable->category->name ?? 'Vegetable' }}</p>
        @php
          $stores = $vegetable->stores ?? collect();
          $bestPrice = $stores->pluck('pivot.current_price')->filter()->min() ?? null;
        @endphp

        <div class="flex flex-col space-y-1">
          <div class="flex flex-wrap gap-2">
            @forelse($stores as $store)
              @php
                $price = $store->pivot->current_price ?? 0;
                $original = $store->pivot->original_price ?? null;
                $hasDiscount = $original && $original > $price;
                $discountPercentage = $hasDiscount ? round((($original - $price) / $original) * 100) : 0;
              @endphp

              <span class="relative group inline-block">
                <span class="px-2 py-1 rounded text-sm {{ $price == $bestPrice ? 'bg-green-100 text-green-800 font-semibold' : 'bg-gray-100 text-gray-700' }}">
                  {{ $store->store_name ?? $store->name ?? 'Store' }}: BND {{ number_format($price, 2) }}
                  @if($hasDiscount)
                    <span class="ml-2 text-xs text-red-600 font-bold">-{{ $discountPercentage }}%</span>
                  @endif
                </span>

                @if($hasDiscount)
                  <div class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-max bg-white border border-gray-200 rounded shadow-lg text-xs text-gray-700 px-3 py-2 hidden group-hover:block z-50">
                    Was BND {{ number_format($original, 2) }} — Save {{ $discountPercentage }}%
                  </div>
                @endif
              </span>
            @empty
              <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-sm">No store prices</span>
            @endforelse
          </div>

          <p class="text-sm">Stock: {{ $vegetable->stock }}</p>
        </div>
            </div>
            </div>

            <div class="flex gap-2">
              <a href="{{ route('admin.vegetable.edit', $vegetable->id) }}" class="bg-blue-100 p-2 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                </svg>
              </a>

              <a href="{{ route('admin.vegetable.confirmDelete', $vegetable->id) }}" class="bg-red-100 p-2 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                </svg>
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </main>

  <!-- Floating Add Button -->
  <a href="{{ route('admin.vegetable.create') }}" 
     class="fixed bottom-6 right-6 bg-blue-700 text-white p-4 rounded-full shadow-lg hover:bg-blue-800 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M12 4v16m8-8H4" />
    </svg>
  </a>

  <script>
    const dropdown = document.getElementById('itemType');
    const newButton = document.getElementById('newButton');

    dropdown.addEventListener('change', function() {
      const selectedURL = dropdown.value;
      if(selectedURL.includes('chicken')) newButton.href = "{{ route('admin.chicken.create') }}";
      else if(selectedURL.includes('beef')) newButton.href = "{{ route('admin.beef.create') }}";
      else if(selectedURL.includes('vegetable')) newButton.href = "{{ route('admin.vegetable.create') }}";

      window.location.href = selectedURL;
    });
  </script>

</body>
</html>
