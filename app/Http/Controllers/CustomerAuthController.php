<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if there's an intended URL to redirect to
            if ($request->session()->has('url.intended')) {
                return redirect()->intended();
            }
            
            return redirect()->route('customer.main');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Handle redirect after authentication
     * This method will be called automatically by Laravel's auth system
     */
    public function authenticated(Request $request, $user)
    {
        // Check if there's an intended URL (from middleware auth redirect)
        if ($request->session()->has('url.intended')) {
            return redirect()->intended();
        }
        
        return redirect()->route('customer.main');
    }
}