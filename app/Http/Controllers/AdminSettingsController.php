<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->show_email_public = $request->has('show_email_public');
        $user->notify_stock_low   = $request->has('notify_stock_low');
        $user->notify_orders      = $request->has('notify_orders');
        $user->two_factor_auth    = $request->has('two_factor_auth');

        $user->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
