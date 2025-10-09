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
    }

    .role-btn {
      flex: 1;
      text-align: center;
      padding: 12px 0;
      background: #fff;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 16px;
    }

    .role-btn:first-child {
      margin-right: 10px;
    }

    .role-btn.active {
      border-color: #007bff;
      background: #e6f0ff;
      color: #007bff;
    }

    .role-btn:hover {
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
  </style>
</head>
<body>

<!-- Role Toggle -->
<div class="role-toggle">
    <a href="/admin/login" class="role-btn active">Admin</a>
    <a href="/customer" class="role-btn">Customer</a>
</div>
  <!-- Login Box -->
  <div class="container">
    <h2>Welcome Back!</h2>
    <p>Sign in to your account</p>
    
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
    
    <form method="POST" id="loginForm">
      @csrf
      <input type="text" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required>
      <input type="password" name="password" class="input-field" placeholder="Password" required>
      <a href="#" class="forgot">Forgot Password?</a>
      <button type="submit" class="btn">Sign In</button>
      <div class="signup">
        Don't have an account? <a href="#">Sign Up</a>
      </div>
    </form>
  </div>

  <script>
    let currentRole = 'admin'; // Default to Admin

    function setRole(role) {
      currentRole = role;
      document.querySelectorAll(".role-btn").forEach(btn => btn.classList.remove("active"));
      if (role === "admin") {
        document.querySelectorAll(".role-btn")[0].classList.add("active");
      } else {
        document.querySelectorAll(".role-btn")[1].classList.add("active");
      }
    }

    // Change form action dynamically
    document.getElementById("loginForm").addEventListener("submit", function (e) {
      if (currentRole === "admin") {
        this.action = "{{ route('admin.login.submit') }}";
      } else {
        this.action = "{{ route('customer.login.submit') }}";
      }
      // Form will now submit to the correct route
    });
  </script>

</body>
</html>