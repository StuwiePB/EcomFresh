<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ECOM FRESH - Item List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-blue-700 text-white flex items-center px-4 py-3">
    <a href="{{ url()->previous() }}" class="mr-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 19l-7-7 7-7" />
      </svg>
    </a>
    <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold">ECOM FRESH</h1>
  </header>

  <main class="flex-1 p-4 flex flex-col items-center">

    <!-- Success message -->
    @if (session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center w-full max-w-md md:max-w-2xl lg:max-w-3xl">
        {{ session('success') }}
      </div>
    @endif

    <div class="w-full max-w-md md:max-w-2xl lg:max-w-3xl">

      <!-- Page header + controls -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Item List</h2>

        <div class="flex gap-2">
          <!-- Dropdown for item type -->
          <select id="itemType" class="border rounded px-3 py-2" onchange="navigateToPage()">
            <option value="{{ route('admin.chicken-crud') }}" {{ request()->is('admin/chicken-crud') ? 'selected' : '' }}>Chicken</option>
            <option value="{{ route('admin.beef-crud') }}" {{ request()->is('admin/beef-crud') ? 'selected' : '' }}>Beef</option>
            <option value="{{ route('admin.vegetable-crud') }}" {{ request()->is('admin/vegetable-crud') ? 'selected' : '' }}>Vegetable</option>
          </select>

          <!-- New button -->
          <a id="newButton" href="{{ route('admin.beef.create') }}" 
             class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
            New
          </a>
        </div>
      </div>

      <!-- Items grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($beefs as $beef)
        <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="text-4xl">🥩</div>
            <div class="flex flex-col space-y-1">
              <h3 class="font-bold text-lg">{{ $beef->name }}</h3>
              <p class="text-sm text-gray-500">Category: {{ $beef->category }}</p>
              <p class="text-sm font-semibold">${{ number_format($beef->price, 2) }}</p>
              <p class="text-sm">Stock: {{ $beef->stock }}</p>
            </div>
          </div>

          <div class="flex gap-2">
            <a href="{{ route('admin.beef.edit', $beef->id) }}" class="bg-blue-100 p-2 rounded-lg flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" 
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
              </svg>
            </a>

            <form action="{{ route('admin.beef.destroy', $beef->id) }}" method="POST" onsubmit="return confirmDelete(event)">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-100 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                </svg>
              </button>
            </form>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </main>

  <!-- Floating Add Button -->
  <a href="{{ route('admin.beef.create') }}" 
     class="fixed bottom-6 right-6 bg-blue-700 text-white p-4 rounded-full shadow-lg hover:bg-blue-800 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M12 4v16m8-8H4" />
    </svg>
  </a>

  <!-- JS -->
  <script>
    function confirmDelete(event) {
      event.preventDefault();
      if (confirm('Are you sure you want to delete this item?')) {
        event.target.submit();
      }
    }

    function navigateToPage() {
      const dropdown = document.getElementById("itemType");
      window.location.href = dropdown.value;
    }

    // Dynamic "New" button update
    const newButton = document.getElementById('newButton');
    const dropdown = document.getElementById('itemType');

    dropdown.addEventListener('change', function() {
      const type = dropdown.options[dropdown.selectedIndex].text.toLowerCase();
      if(type === 'chicken') newButton.href = "{{ route('items.create') }}";
      else if(type === 'beef') newButton.href = "{{ route('admin.beef.create') }}";
      else if(type === 'vegetable') newButton.href = "{{ route('admin.vegetable.create') }}";
    });
  </script>

</body>
</html>
