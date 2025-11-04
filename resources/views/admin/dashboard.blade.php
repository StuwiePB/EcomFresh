<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>EcomFresh • Seller Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --brand:#134EF5; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-900">

  <!-- Top bar -->
  <header class="bg-[color:var(--brand)] text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
      <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-wide">ECOM FRESH</h1>

      @auth

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <div class="relative" x-data="{ open: false }">
    <!-- Profile button -->
    <button @click="open = !open"
      class="flex items-center gap-2 hover:bg-white/20 text-sm sm:text-base font-medium px-3 py-1.5 rounded-lg transition">
      {{ Auth::user()->name }}
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false" 
         class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
      <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
      <a href="{{ route('admin.settings.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
      </form>
    </div>
  </div>
@endauth

  </header>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 mt-6 sm:mt-10">
    <!-- Title card -->
    <div class="rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5 bg-[color:var(--brand)] text-white">
      <div class="text-xl sm:text-2xl md:text-3xl font-extrabold italic">SELLER DASHBOARD</div>
    </div>

    <!-- Stat cards row -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
  
  <!-- Left: Total Products -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
    <div class="text-gray-600 font-medium text-sm sm:text-base">Total Products</div>
    <div class="mt-2 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-none">{{ $totalProducts }}</div>
  </div>

  <!-- Right: Customer Page -->
  <a href="{{ route('customer.main') }}" 
     class="group flex flex-col items-center justify-center bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🧍</div>
    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Customer Page</h3>
  </a>

</div>
    <!-- Item list -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto mt-8 mb-16">
  <!-- Chicken -->
  <a href="{{ route('admin.chicken-crud') }}" 
     class="group flex flex-col items-center justify-center bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🐔</div>
    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-yellow-600 transition-colors">Chicken</h3>
  </a>

  <!-- Beef -->
  <a href="{{ route('admin.beef-crud') }}" 
     class="group flex flex-col items-center justify-center bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🥩</div>
    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-red-600 transition-colors">Beef</h3>
  </a>

  <!-- Vegetable -->
  <a href="{{ route('admin.vegetable-crud') }}" 
     class="group flex flex-col items-center justify-center bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🥦</div>
    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Vegetable</h3>
  </a>
</div>

    <!-- Priority alert -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5">
      <a href="#" class="text-[color:var(--brand)] font-semibold underline text-base sm:text-lg">Priority Alert</a>

      <div class="mt-4 space-y-4">
        <div class="flex items-start gap-3">
          <div class="text-xl sm:text-2xl">🚨</div>
          <div>
            <div class="font-semibold text-sm sm:text-base">Stock running low</div>
            <div class="text-gray-500 text-xs sm:text-sm">Whole chicken leg is almost running out</div>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <div class="text-xl sm:text-2xl">🟢</div>
          <div>
            <div class="font-semibold text-sm sm:text-base">Stock is back</div>
            <div class="text-gray-500 text-xs sm:text-sm">Whole chicken has been restocked</div>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <div class="text-xl sm:text-2xl">💹</div>
          <div>
            <div class="font-semibold text-sm sm:text-base">Price change opportunity</div>
            <div class="text-gray-500 text-xs sm:text-sm">Market price for Chicken Breast has lowered by 3%</div>
          </div>
        </div>
      </div>
    </section>

<!-- Delete history (Clickable Box) -->
@php
  // Prevent undefined variable error
  $recentDeletes = $recentDeletes ?? collect();
@endphp

<!-- Delete history (Clickable Box) -->
<a href="{{ route('admin.deletehistory') }}" class="block">
  <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-10 hover:bg-gray-50 transition cursor-pointer">
    <div class="flex items-center gap-3">
      <div class="text-xl sm:text-2xl">🗑️</div>
      <div class="text-gray-800 font-extrabold text-base sm:text-lg">Delete History</div>
    </div>

    @if ($recentDeletes->isNotEmpty())
      <ol class="mt-3 list-decimal pl-6 space-y-1 text-sm sm:text-base text-gray-700">
        @foreach ($recentDeletes as $item)
          <li class="font-semibold flex justify-between">
            <span>
              {{ $item->name }}
              <span class="text-gray-500 text-xs">({{ $item->category }})</span>
            </span>
            <span class="text-gray-400 text-xs">
              {{ optional($item->deleted_at)->format('d M') }}
            </span>
          </li>
        @endforeach
      </ol>
    @else
      <p class="mt-3 text-sm text-gray-500 italic">No deleted items yet.</p>
    @endif
  </section>
</a>
  </main>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", async () => {
        let res = await fetch("{{ route('logout') }}", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
          },
        });
        if (res.ok) {
          window.location.href = "/login"; // ✅ redirect after logout
        } else {
          alert("Logout failed");
        }
      });
    }
  });
</script>
</body>
</html>
