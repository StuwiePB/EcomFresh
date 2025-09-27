<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcomFresh - Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg, #1e90ff, #ffffff);
      color: #333;
    }

    .container {
      width: 100%;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      box-sizing: border-box;
      text-align: center;
    }

    .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .logo img {
      width: 40px;
      height: 40px;
      margin-right: 10px;
    }

    .logo-text {
      font-size: 22px;
      font-weight: bold;
      color: #1e90ff;
    }

    h2 {
      margin-bottom: 10px;
      font-size: 22px;
      color: #1e90ff;
    }

    p {
      margin-bottom: 20px;
      font-size: 14px;
      color: #555;
    }

    .form-group {
      margin-bottom: 15px;
    }

    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 20px;
      box-sizing: border-box;
      outline: none;
    }

    .forgot {
      text-align: right;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .forgot a {
      text-decoration: none;
      color: #1e90ff;
    }

    .remember {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      font-size: 14px;
      color: #333;
    }

    .remember input {
      margin-right: 8px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #1e90ff;
      border: none;
      border-radius: 20px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #0066cc;
    }

    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
      color: #333;
    }

    .footer a {
      text-decoration: none;
      color: #1e90ff;
      font-weight: bold;
    }

    /* Make text scale on smaller screens */
    @media (max-width: 500px) {
      h2 { font-size: 20px; }
      button { font-size: 14px; }
      .logo-text { font-size: 18px; }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Logo -->
    <div class="logo">
      <img src="logo.png" alt="EcomFresh Logo">
      <span class="logo-text">EcomFresh</span>
    </div>

    <!-- Heading -->
    <h2>Welcome Back!</h2>
    <p>Sign in to your account</p>
    
    <!-- Form -->
    <form>
      <div class="form-group">
        <input type="text" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="password" placeholder="Password" required>
      </div>
      
      <div class="forgot">
        <a href="#">Forgot Password?</a>
      </div>

      <button type="submit">Sign In</button>

      <div class="footer">
        Don’t have an account? <a href="#">Sign Up</a>
      </div>
    </form>
  </div>
</body>
</html>
