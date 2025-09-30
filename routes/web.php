<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;

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
