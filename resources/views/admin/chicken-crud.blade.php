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
    <button class="mr-3">
      <!-- Back arrow -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold">ECOM FRESH</h1>
  </header>

  <!-- Item list container -->
  <main class="flex-1 p-4 flex justify-center">
    <div class="w-full max-w-md md:max-w-2xl lg:max-w-3xl">
      <h2 class="text-center text-xl md:text-2xl font-bold mb-4">Item List</h2>

      <!-- Dropdown -->
      <div class="flex justify-center mb-6">
        <div class="bg-white px-6 py-2 rounded-lg flex items-center shadow">
          <span class="font-semibold">Chicken</span>
          <div class="ml-3 flex flex-col">
            <!-- Up arrow -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 15l7-7 7 7" />
            </svg>
            <!-- Down arrow -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Items grid (responsive) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- Item Card 1 -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <!-- Icon -->
            <div class="text-4xl">🍗</div>
            <div>
              <h3 class="font-bold">Chicken Breast</h3>
              <p class="text-sm text-gray-500">Category: Meat</p>
              <p class="text-sm">$3.50</p>
              <p class="text-sm">Stock: 30</p>
            </div>
          </div>
          <!-- Actions -->
          <div class="flex gap-2">
            <button class="bg-blue-100 p-2 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
              </svg>
            </button>
            <button class="bg-red-100 p-2 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Item Card 2 -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <!-- Icon -->
            <div class="text-4xl">🍖</div>
            <div>
              <h3 class="font-bold">Whole Chicken</h3>
              <p class="text-sm text-gray-500">Category: Meat</p>
              <p class="text-sm">$5.50</p>
              <p class="text-sm">Stock: 30</p>
            </div>
          </div>
          <!-- Actions -->
          <div class="flex gap-2">
            <button class="bg-blue-100 p-2 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
              </svg>
            </button>
            <button class="bg-red-100 p-2 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Floating Add Button -->
  <button class="fixed bottom-6 right-6 bg-blue-700 text-white p-4 rounded-full shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M12 4v16m8-8H4" />
    </svg>
  </button>
</body>
</html>
