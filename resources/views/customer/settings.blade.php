<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - EcomFresh</title>
    
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
        }
        
        .settings-card {
            transition: all 0.3s ease;
        }
        
        .settings-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .logo-placeholder {
            background: linear-gradient(135deg, #1e90ff, #00bfff);
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-blue-100">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Logo Placeholder -->
                    <a href="/" class="w-16 h-16 logo-placeholder rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </a>
                    <!-- App Name -->
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-800" style="font-family: 'Poppins', sans-serif; font-weight: 800;">E-COM FRESH</h1>
                        <p class="text-blue-600 font-medium">Account Settings</p>
                    </div>
                </div>
                
                <!-- Back to Home Button -->
                <a href="/customer" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300 font-medium">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 p-6 mb-6 settings-card">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                        S
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Stuart</h2>
                    </div>
                </div>
            </div>

            <!-- Account Settings Form -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-blue-50 p-6 settings-card">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Account Information</h3>
                
                <form id="accountForm">
                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user text-blue-500 mr-2"></i>Full Name
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="Stuart" 
                            class="w-full px-4 py-3 form-input rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your full name"
                        >
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope text-blue-500 mr-2"></i>Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="stuart@example.com" 
                            class="w-full px-4 py-3 form-input rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your email address"
                        >
                    </div>

                    <!-- Date of Birth Field -->
                    <div class="mb-6">
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>Date of Birth
                        </label>
                        <input 
                            type="date" 
                            id="dob" 
                            name="dob" 
                            value="2002-10-07" 
                            class="w-full px-4 py-3 form-input rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Save Changes Button -->
                    <div class="flex justify-end space-x-4 mb-6">
                        <button 
                            type="button" 
                            onclick="resetForm()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300 font-medium"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 font-medium"
                        >
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-red-100 p-6 mt-6 settings-card">
                <h3 class="text-xl font-bold text-red-800 mb-4">Danger Zone</h3>
                
                <!-- Logout Button -->
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                    <div>
                        <h4 class="font-medium text-red-800">Logout</h4>
                        <p class="text-sm text-red-600">Sign out of your account</p>
                    </div>
                    <button 
                        onclick="logout()"
                        class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 font-medium"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </div>

                <!-- Delete Account (Optional) -->
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200 mt-4">
                    <div>
                        <h4 class="font-medium text-red-800">Delete Account</h4>
                        <p class="text-sm text-red-600">Permanently delete your account and all data</p>
                    </div>
                    <button 
                        onclick="deleteAccount()"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 font-medium"
                    >
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-blue-100 mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p class="text-gray-700 font-medium">&copy; 2025 EcomFresh. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Form handling
        document.getElementById('accountForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const dob = document.getElementById('dob').value;
            
            // Simulate saving changes
            alert(`Changes saved successfully!\n\nName: ${name}\nEmail: ${email}\nDate of Birth: ${dob}`);
            
            // Here you would typically send the data to your backend
            // fetch('/api/account/update', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ name, email, dob })
            // })
        });

        // Reset form to original values
        function resetForm() {
            document.getElementById('name').value = 'John Doe';
            document.getElementById('email').value = 'john.doe@example.com';
            document.getElementById('dob').value = '1990-01-15';
        }

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                alert('You have been logged out successfully!');
                // Here you would typically redirect to logout route
                // window.location.href = '/logout';
            }
        }

        // Delete account function
        function deleteAccount() {
            if (confirm('Are you absolutely sure? This will permanently delete your account and all associated data. This action cannot be undone.')) {
                if (confirm('This is your final warning. All your data will be lost forever.')) {
                    alert('Account deletion initiated. You will be logged out shortly.');
                    // Here you would typically call the account deletion API
                    // fetch('/api/account/delete', { method: 'DELETE' })
                }
            }
        }
    </script>
</body>
</html>