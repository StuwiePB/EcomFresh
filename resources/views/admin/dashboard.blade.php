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
        <!-- User's name acts as logout button -->
        <button id="logoutBtn"
          class="hover:bg-white/20 text-sm sm:text-base font-medium px-3 py-1.5 rounded-lg transition">
          {{ Auth::user()->name }}
        </button>
      @else
        <!-- Show login if no user -->
        <a href="{{ route('login') }}"
          class="hover:bg-white/20 text-sm sm:text-base font-medium px-3 py-1.5 rounded-lg transition">
          Login
        </a>
      @endauth
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 mt-6 sm:mt-10">
    <!-- Title card -->
    <div class="rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5 bg-[color:var(--brand)] text-white">
      <div class="text-xl sm:text-2xl md:text-3xl font-extrabold italic">SELLER DASHBOARD</div>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-5">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="text-gray-600 font-medium text-sm sm:text-base">Total Customers</div>
        <div class="mt-2 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-none">215</div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="text-gray-600 font-medium text-sm sm:text-base">Products Sold</div>
        <div class="mt-2 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-none">28</div>
      </div>
    </div>

    <!-- Item list -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5">
      <div class="text-gray-700 font-semibold mb-3 text-base sm:text-lg">Item List</div>
      <ul class="space-y-1 text-sm sm:text-base">
        <li class="font-semibold">Whole Chicken <span class="font-normal text-gray-600">– 42 pcs</span></li>
        <li class="font-semibold">Chicken Thigh <span class="font-normal text-gray-600">– 28 pcs</span></li>
        <li class="font-semibold">Chicken Wings <span class="font-normal text-gray-600">– 50 pcs</span></li>
        <li class="text-gray-400">……….</li>
      </ul>
    </section>

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

    <!-- Delete history -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-10">
      <div class="flex items-center gap-3">
        <div class="text-xl sm:text-2xl">🗑️</div>
        <div class="text-gray-800 font-extrabold text-base sm:text-lg">Delete History</div>
      </div>
      <ol class="mt-3 list-decimal pl-6 space-y-1 text-sm sm:text-base">
        <li class="font-semibold">Chicken Thigh</li>
        <li class="font-semibold">Striploin</li>
      </ol>
    </section>
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
            window.location.href = "/"; // redirect after logout
          } else {
            alert("Logout failed");
          }
        });
      }
    });
  </script>
</body>
</html>
