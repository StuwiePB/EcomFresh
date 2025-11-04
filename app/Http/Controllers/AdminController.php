<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeleteHistoryTable;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Safe count - try different models
        try {
            if (class_exists(\App\Models\CustomerProduct::class)) {
                $totalProducts = \App\Models\CustomerProduct::count();
            } else {
                $totalProducts = 0;
            }
        } catch (\Exception $e) {
            $totalProducts = 0;
        }

        $totalUsers = User::count();
        $totalOrders = 0;
        $recentDeletes = DeleteHistoryTable::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalUsers', 
            'totalOrders',
            'recentDeletes'
        ));
    }
}