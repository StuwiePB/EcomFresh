<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    // Fake login for testing: any email/password works
    public function login(Request $request)
    {
        $request->session()->put('customer_logged_in', true);
        return redirect()->route('home');
    }

    // Fake logout
    public function logout(Request $request)
    {
        $request->session()->forget('customer_logged_in');
        return redirect('/login');
    }
}
