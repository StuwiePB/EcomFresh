<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Models\Product;


// --------------------
// Customer routes
// --------------------
Route::get('/', function () {
    return view('customer.welcome'); // resources/views/customer/welcome.blade.php
})->name('home');

Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');

// --------------------
// Admin login/logout
// --------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// --------------------
// Admin dashboard
// --------------------
Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->middleware(['auth']) // keep it simple: 'auth' only
    ->name('admin.dashboard');

// --------------------
// Admin Item List page
// --------------------
Route::get('/admin/items', function () {
    return view('admin.chicken-crud'); // resources/views/admin/item-list.blade.php
})->name('admin.items');

// Admin Chicken CRUD
Route::get('/admin/chicken-crud', function () {
    return view('admin.chicken-crud'); 
})->name('admin.chicken-crud');

// Admin add new item
Route::get('/admin/items/create', function () {
    return view('admin.adminaddnewitem'); // resources/views/admin/adminaddnewitem.blade.php
})->name('items.create');

// Save new item (form submit)
Route::post('/admin/items', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    Product::create($request->all());

    return redirect()->route('items.index')->with('success', 'Item added successfully!');
})->name('items.store');

// --------------------
// Volt settings routes
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
