<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reset Password - EcomFresh</title>
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
      <a href="#" class="hover:bg-white/20 text-sm sm:text-base font-medium px-3 py-1.5 rounded-lg transition">
        Back to Login
      </a>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 mt-6 sm:mt-10">
    <!-- Title card -->
    <div class="rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5 bg-[color:var(--brand)] text-white">
      <div class="text-xl sm:text-2xl md:text-3xl font-extrabold italic">RESET YOUR PASSWORD</div>
    </div>

    <!-- Password Reset Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5">
      <div class="text-gray-700 font-semibold mb-6 text-base sm:text-lg">Create a new password for your account</div>
      
      <form id="resetPasswordForm" class="space-y-6">
        <!-- Old Password -->
        <div>
          <label for="oldPassword" class="block text-sm font-medium text-gray-700 mb-2">Old Password</label>
          <div class="relative">
            <input type="password" id="oldPassword" name="oldPassword" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[color:var(--brand)] focus:border-transparent transition">
            <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('oldPassword')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>

        <!-- New Password -->
        <div>
          <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
          <div class="relative">
            <input type="password" id="newPassword" name="newPassword" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[color:var(--brand)] focus:border-transparent transition"
                   onkeyup="checkPasswordStrength()">
            <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('newPassword')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <!-- Password Strength Indicator -->
          <div class="mt-2">
            <div class="flex items-center space-x-2 text-xs text-gray-500">
              <span>Password strength:</span>
              <div id="passwordStrength" class="font-medium"></div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
              <div id="strengthBar" class="h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
          </div>
        </div>

        <!-- Confirm New Password -->
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
          <div class="relative">
            <input type="password" id="confirmPassword" name="confirmPassword" required 
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[color:var(--brand)] focus:border-transparent transition"
                   onkeyup="checkPasswordMatch()">
            <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('confirmPassword')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <div id="passwordMatch" class="mt-2 text-xs"></div>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-[color:var(--brand)] text-white font-semibold py-3 px-4 rounded-xl hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Reset Password
        </button>
      </form>
    </div>

    <!-- Password Requirements -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-5">
      <div class="text-gray-700 font-semibold mb-3 text-base sm:text-lg">Password Requirements</div>
      <ul class="space-y-2 text-sm text-gray-600">
        <li class="flex items-center">
          <span id="lengthReq" class="inline-block w-4 h-4 rounded-full bg-gray-300 mr-2"></span>
          At least 8 characters long
        </li>
        <li class="flex items-center">
          <span id="uppercaseReq" class="inline-block w-4 h-4 rounded-full bg-gray-300 mr-2"></span>
          Contains at least one uppercase letter
        </li>
        <li class="flex items-center">
          <span id="numberReq" class="inline-block w-4 h-4 rounded-full bg-gray-300 mr-2"></span>
          Contains at least one number
        </li>
        <li class="flex items-center">
          <span id="specialReq" class="inline-block w-4 h-4 rounded-full bg-gray-300 mr-2"></span>
          Contains at least one special character
        </li>
      </ul>
    </section>

    <!-- Success Message (Hidden by default) -->
    <div id="successMessage" class="hidden bg-green-50 border border-green-200 rounded-2xl p-4 sm:p-6 mb-5">
      <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="text-green-800 font-medium">Password reset successfully! Redirecting to login...</div>
      </div>
    </div>
  </main>

  <script>
    function togglePassword(fieldId) {
      const passwordField = document.getElementById(fieldId);
      const eyeIcon = passwordField.nextElementSibling.querySelector('svg');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
      } else {
        passwordField.type = 'password';
        eyeIcon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
      }
    }
    
    function checkPasswordStrength() {
      const password = document.getElementById('newPassword').value;
      const strengthBar = document.getElementById('strengthBar');
      const strengthText = document.getElementById('passwordStrength');
      const lengthReq = document.getElementById('lengthReq');
      const uppercaseReq = document.getElementById('uppercaseReq');
      const numberReq = document.getElementById('numberReq');
      const specialReq = document.getElementById('specialReq');
      
      let strength = 0;
      
      // Check length
      if (password.length >= 8) {
        strength += 25;
        lengthReq.style.backgroundColor = '#10B981';
      } else {
        lengthReq.style.backgroundColor = '#D1D5DB';
      }
      
      // Check uppercase
      if (/[A-Z]/.test(password)) {
        strength += 25;
        uppercaseReq.style.backgroundColor = '#10B981';
      } else {
        uppercaseReq.style.backgroundColor = '#D1D5DB';
      }
      
      // Check numbers
      if (/[0-9]/.test(password)) {
        strength += 25;
        numberReq.style.backgroundColor = '#10B981';
      } else {
        numberReq.style.backgroundColor = '#D1D5DB';
      }
      
      // Check special characters
      if (/[^A-Za-z0-9]/.test(password)) {
        strength += 25;
        specialReq.style.backgroundColor = '#10B981';
      } else {
        specialReq.style.backgroundColor = '#D1D5DB';
      }
      
      // Update strength bar and text
      strengthBar.style.width = strength + '%';
      
      if (strength < 50) {
        strengthBar.style.backgroundColor = '#EF4444';
        strengthText.textContent = 'Weak';
        strengthText.style.color = '#EF4444';
      } else if (strength < 75) {
        strengthBar.style.backgroundColor = '#F59E0B';
        strengthText.textContent = 'Medium';
        strengthText.style.color = '#F59E0B';
      } else {
        strengthBar.style.backgroundColor = '#10B981';
        strengthText.textContent = 'Strong';
        strengthText.style.color = '#10B981';
      }
    }
    
    function checkPasswordMatch() {
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      const matchIndicator = document.getElementById('passwordMatch');
      
      if (confirmPassword === '') {
        matchIndicator.innerHTML = '';
        return;
      }
      
      if (newPassword === confirmPassword) {
        matchIndicator.innerHTML = '<span class="text-green-600">✓ Passwords match</span>';
      } else {
        matchIndicator.innerHTML = '<span class="text-red-600">✗ Passwords do not match</span>';
      }
    }
    
    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const oldPassword = document.getElementById('oldPassword').value;
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      
      // Basic validation
      if (newPassword !== confirmPassword) {
        alert('New password and confirmation do not match.');
        return;
      }
      
      if (newPassword.length < 8) {
        alert('Password must be at least 8 characters long.');
        return;
      }
      
      // Show success message
      const successMessage = document.getElementById('successMessage');
      successMessage.classList.remove('hidden');
      
      // In a real application, you would send this data to the server
      setTimeout(function() {
        // Redirect to login page
        window.location.href = '#';
      }, 2000);
    });
  </script>
</body>
</html>