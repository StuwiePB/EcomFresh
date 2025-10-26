<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #4facfe, #00f2fe);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
    }

    .role-toggle {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      width: 100%;
      max-width: 350px;
      background: white;
      border-radius: 8px;
      padding: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .role-btn {
      flex: 1;
      text-align: center;
      padding: 12px 0;
      background: transparent;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 16px;
      text-decoration: none;
      color: inherit;
    }

    .role-btn.active {
      background: #007bff;
      color: white;
      box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    .role-btn:hover:not(.active) {
      background: #f2f2f2;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 350px;
      text-align: center;
    }

    h2 {
      color: #007bff;
      margin-bottom: 10px;
      font-size: 1.5em;
    }

    .input-field {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 20px;
      outline: none;
      font-size: 1em;
      box-sizing: border-box;
    }

    .input-field:focus {
      border-color: #007bff;
    }

    .forgot {
      display: block;
      text-align: right;
      margin-bottom: 15px;
      font-size: 14px;
      color: #007bff;
      text-decoration: none;
    }

    .forgot:hover {
      text-decoration: underline;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #007bff;
      border: none;
      border-radius: 20px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #0056b3;
    }

    .signup {
      margin-top: 15px;
      font-size: 14px;
    }

    .signup a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    .signup a:hover {
      text-decoration: underline;
    }

    .message {
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      display: none;
    }
    
    .error {
      background-color: #ffebee;
      color: #c62828;
      border: 1px solid #ffcdd2;
    }

    .form-title {
      transition: all 0.3s ease;
    }
  </style>
</head>
<body>

<!-- Role Toggle -->
<div class="role-toggle">
    <a href="{{ route('admin.login') }}" class="role-btn active">Admin</a>
    <a href="{{ route('customer.login') }}" class="role-btn">Customer</a>
</div>

<!-- Login Box -->
<div class="container">
  <h2 class="form-title" id="formTitle">Welcome Back, Admin!</h2>
  <p id="formSubtitle">Sign in to your admin account</p>
  
  <!-- Display validation errors -->
  @if($errors->any())
    <div class="error" style="display: block; padding: 10px; margin: 10px 0; border-radius: 5px; background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2;">
      {{ $errors->first() }}
    </div>
  @endif
  
  <!-- Display success message -->
  @if(session('success'))
    <div class="success" style="display: block; padding: 10px; margin: 10px 0; border-radius: 5px; background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;">
      {{ session('success') }}
    </div>
  @endif
  
  <form method="POST" id="loginForm" action="{{ route('admin.login.submit') }}">
    @csrf
    <input type="text" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required>
    <input type="password" name="password" class="input-field" placeholder="Password" required>
    <a href="#" class="forgot">Forgot Password?</a>
    <button type="submit" class="btn" id="submitBtn">Sign In as Admin</button>
    <div class="signup">
      Don't have an account? <a href="#" id="signupLink">Sign Up</a>
    </div>
  </form>
</div>

<script>
  // Function to redirect when role buttons are clicked
  document.addEventListener('DOMContentLoaded', function() {
    const roleButtons = document.querySelectorAll('.role-btn');
    
    roleButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        // Remove active class from all buttons
        roleButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');
        
        // The href of the button will handle the redirect
        // No need to prevent default - let the link work normally
      });
    });
  });

  // Optional: If you want to keep the dynamic form updates for the current page
  function updateFormForCurrentRole() {
    const currentPath = window.location.pathname;
    const isAdminLogin = currentPath.includes('/admin/login');
    const formTitle = document.getElementById('formTitle');
    const formSubtitle = document.getElementById('formSubtitle');
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const signupLink = document.getElementById('signupLink');

    if (isAdminLogin) {
      formTitle.textContent = 'Welcome Back, Admin!';
      formSubtitle.textContent = 'Sign in to your admin account';
      loginForm.action = "{{ route('admin.login.submit') }}";
      submitBtn.textContent = 'Sign In as Admin';
      signupLink.href = "#";
      signupLink.textContent = "Contact Administrator";
      signupLink.onclick = function() { alert('Please contact system administrator for admin account creation.'); return false; };
    } else {
      formTitle.textContent = 'Welcome, Customer!';
      formSubtitle.textContent = 'Sign in to your customer account';
      loginForm.action = "{{ route('customer.login.submit') }}";
      submitBtn.textContent = 'Sign In as Customer';
      signupLink.href = "{{ route('signup') }}";
      signupLink.textContent = "Sign Up";
      signupLink.onclick = null;
    }
  }

  // Update form based on current URL
  document.addEventListener('DOMContentLoaded', updateFormForCurrentRole);
</script>

</body>
</html>