<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlySoonLeeAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->email !== 'soonlee@ecomfresh.com') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}
