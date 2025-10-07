<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BeefController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\PriceController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminProduct;


// ✅ Global logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// --------------------
// CUSTOMER ROUTES
// --------------------
Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');
Route::get('/todaysprice', [PriceController::class, 'todaysPrice']);
Route::get('/login', fn() => view('customer.login'))->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/', fn() => view('customer.welcome'))->name('home');
});

// Customer category
Route::get('/customer/category/{category}', [ProductController::class, 'categoryProducts'])->name('customer.category');

// --------------------
// ADMIN ROUTES
// --------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard
Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('admin.dashboard');

// Chicken CRUD (Main Product CRUD)
Route::get('/admin/chicken-crud', [ProductController::class, 'adminIndex'])->name('admin.chicken-crud');

// Add new item
Route::get('/admin/items/create', fn() => view('admin.adminaddnewitem'))->name('items.create');

// Save new item
Route::post('/admin/items', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    Product::create($request->all());

    // Redirect back to chicken CRUD page (NOT items.index)
    return redirect()->route('admin.chicken-crud')->with('success', 'Item added successfully!');
})->name('items.store');

// Edit Item
Route::get('/admin/items/{id}/edit', [ProductController::class, 'edit'])->name('items.edit');
Route::put('/admin/items/{id}', [ProductController::class, 'update'])->name('items.update');

// Delete confirmation page
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/itemconfirmation', 'admin.itemconfirmation');
});

// Delete Item
Route::delete('/admin/items/{id}', [ProductController::class, 'destroy'])->name('items.destroy');

// --------------------
// BEEF CRUD SECTION
// --------------------
// Beef controller handles everything for beef-crud
Route::get('/admin/beef-crud', [BeefController::class, 'index'])->name('admin.beef-crud');
Route::get('/admin/beef/create', [BeefController::class, 'create'])->name('admin.beef.create');
Route::post('/admin/beef', [BeefController::class, 'store'])->name('admin.beef.store');
Route::get('/admin/beef/{id}/edit', [BeefController::class, 'edit'])->name('admin.beef.edit');
Route::put('/admin/beef/{id}', [BeefController::class, 'update'])->name('admin.beef.update');
Route::delete('/admin/beef/{id}', [BeefController::class, 'destroy'])->name('admin.beef.destroy');

//STORE INFO
Route::get('/admin/storeinfo', function () {
    return view('admin.storeinfo');
})->name('admin.storeinfo');
Route::post('/admin/storeinfo', [AdminAuthController::class, 'updateStoreInfo'])->name('admin.storeinfo.update');

// Delete History Page
Route::get('/admin/deletehistory', function () {
    $deletedItems = AdminProduct::onlyTrashed()->get();
    return view('admin.deletehistory', compact('deletedItems'));
})->name('admin.deletehistory');
// --------------------
// VOLT SETTINGS
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

    Route::get('/todaysprice', fn() => dd('Route works!'));
});
