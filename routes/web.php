<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Models\Product;
use Illuminate\Http\Request;

// --------------------
// Customer routes (PUBLIC - no login required)
// --------------------

// Customer main page (PUBLIC)
Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');

// Customer login page
Route::get('/login', function () {
    return view('customer.login');
})->name('login');

// Customer login form submission
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');

// Customer logout
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

// Customer PROTECTED routes (require login)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('customer.welcome');
    })->name('home');
});

// Dynamic category products page for CUSTOMER
Route::get('/customer/category/{category}', [ProductController::class, 'categoryProducts'])->name('customer.category');
// ... rest of your admin routes stay the same


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
Route::get('/admin/chicken-crud', [ProductController::class, 'adminIndex'])->name('admin.chicken-crud');

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

// Edit Item form
Route::get('/admin/items/{id}/edit', [ProductController::class, 'edit'])->name('items.edit');
Route::put('/admin/items/{id}', [ProductController::class, 'update'])->name('items.update');

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
