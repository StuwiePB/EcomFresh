<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Settings • EcomFresh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --brand:#134EF5; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-900">

  <!-- Header -->
  <header class="bg-[color:var(--brand)] text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
      <h1 class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-wide">ECOM FRESH</h1>
      <a href="{{ route('admin.dashboard') }}" class="hover:bg-white/20 px-3 py-1.5 rounded-lg">Dashboard</a>
    </div>
  </header>

  <main class="max-w-3xl mx-auto px-4 sm:px-6 mt-6 sm:mt-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

      <h2 class="text-2xl font-bold mb-6">Settings</h2>

      @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <!-- Account Preferences -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2 text-gray-800">Account Preferences</h3>
          <div class="flex items-center gap-3">
            <input type="checkbox" name="show_email_public" id="show_email_public" class="w-4 h-4" {{ $user->show_email_public ? 'checked' : '' }}>
            <label for="show_email_public" class="text-gray-700">Show Email Publicly</label>
          </div>
        </div>

        <!-- Notifications -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2 text-gray-800">Email Notifications</h3>
          <div class="flex items-center gap-3 mb-2">
            <input type="checkbox" name="notify_stock_low" id="notify_stock_low" class="w-4 h-4" {{ $user->notify_stock_low ? 'checked' : '' }}>
            <label for="notify_stock_low" class="text-gray-700">Notify when stock is low</label>
          </div>
          <div class="flex items-center gap-3">
            <input type="checkbox" name="notify_orders" id="notify_orders" class="w-4 h-4" {{ $user->notify_orders ? 'checked' : '' }}>
            <label for="notify_orders" class="text-gray-700">Notify on new orders</label>
          </div>
        </div>

        <!-- Security -->
        <div class="mb-6">
          <h3 class="font-semibold mb-2 text-gray-800">Security</h3>
          <div class="flex items-center gap-3">
            <input type="checkbox" name="two_factor_auth" id="two_factor_auth" class="w-4 h-4" {{ $user->two_factor_auth ? 'checked' : '' }}>
            <label for="two_factor_auth" class="text-gray-700">Enable Two-Factor Authentication (2FA)</label>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="bg-[color:var(--brand)] text-white px-4 py-2 rounded-lg hover:bg-blue-600">
          Save Settings
        </button>

      </form>

    </div>
  </main>

</body>
</html>
