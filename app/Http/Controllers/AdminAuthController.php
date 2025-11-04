<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Only allow the designated Soon Lee admin email to log in via admin panel
        if (($credentials['email'] ?? null) !== 'soonlee@ecomfresh.com') {
            return back()->withErrors([
                'email' => 'Unauthorized to access admin panel.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
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
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function updateStoreInfo(Request $request)
    {
        // Add your store info update logic here
        return back()->with('success', 'Store information updated successfully.');
    }
}