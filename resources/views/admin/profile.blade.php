<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Profile • EcomFresh</title>
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

      <h2 class="text-2xl font-bold mb-6">Profile</h2>

      @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Profile picture -->
        <div class="flex flex-col items-center mb-6">
          <img class="w-24 h-24 rounded-full object-cover border border-gray-300"
               src="{{ Auth::user()->profile_picture ?? asset('images/avatar-placeholder.png') }}" alt="Profile Picture">
          <label class="mt-3 cursor-pointer text-blue-600 hover:underline">
            Change Picture
            <input type="file" name="profile_picture" class="hidden">
          </label>
        </div>

        <!-- Name -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Name</label>
          <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
          @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">New Password</label>
          <input type="password" name="password" placeholder="Leave blank to keep current password"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2">
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Confirmation -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Confirm new password">
        </div>

        <!-- Submit -->
        <button type="submit"
                class="bg-[color:var(--brand)] text-white px-4 py-2 rounded-lg hover:bg-blue-600">
          Save Changes
        </button>

      </form>
    </div>
  </main>

</body>
</html>
