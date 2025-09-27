<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcomFresh - Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .signup-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
        }
        
        .signup-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me input {
            margin-right: 10px;
            width: auto;
        }
        
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 25px 0;
        }
        
        .signup-button {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .signup-button:hover {
            background-color: #2980b9;
        }
        
        .signup-button:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="logo">
            <h1>EcomFresh</h1>
        </div>
        
        <div class="signup-form">
            <h2>Sign Up</h2>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your email">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter your password">
            </div>
            
            <div class="remember-me">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>
            
            <div class="divider"></div>
            
            <button class="signup-button" disabled>Sign Up</button>
        </div>
    </div>
</body>
</html>