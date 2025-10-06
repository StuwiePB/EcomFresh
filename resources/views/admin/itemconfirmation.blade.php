<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Item Created • ECOM FRESH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --brand: #134EF5; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
  </style>
</head>
<body class="bg-gray-200 text-gray-900 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-[color:var(--brand)] text-white text-center py-4">
    <h1 class="text-lg sm:text-xl font-extrabold tracking-wide">ECOM FRESH</h1>
  </header>

  <!-- Content -->
  <main class="flex-1 flex flex-col items-center justify-center px-4 text-center space-y-6">
    <!-- Big checkmark -->
    <div class="w-32 h-32 sm:w-40 sm:h-40 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <!-- Text -->
    <div>
      <h2 class="text-xl sm:text-2xl font-bold mb-2">Item created successfully</h2>
    </div>

    <!-- Button -->
    <a href="{{ route('admin.dashboard') }}"
       class="bg-[color:var(--brand)] text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-800 transition">
      Return to Homepage
    </a>
  </main>

</body>
</html>