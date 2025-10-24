<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CustomerAuthController extends Controller
{
    /**
     * Show the customer login form
     */
    public function showLoginForm()
    {
        return view('customer.login');
    }

    /**
     * Handle customer login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Add remember me functionality
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('customer.main'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the customer registration form
     */
    public function showRegisterForm()
    {
        return view('customer.signuppage');
    }

    /**
     * Handle customer registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Fire registered event (useful for sending welcome emails)
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        return redirect()->route('customer.main')
            ->with('success', 'Account created successfully! Welcome to EcomFresh!');
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show password reset request form
     */
    public function showLinkRequestForm()
    {
        return view('customer.passwords.email');
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('customer.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the guard to be used during authentication
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the post register/login redirect path
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/customer';
    }

    /**
     * The user has been registered - you can add additional logic here
     */
    protected function registered(Request $request, $user)
    {
        // Additional actions after registration
        // For example: Send welcome email, create user profile, etc.
    }
}