<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\BeefController;
use App\Http\Controllers\VegetableController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminSettingsController;

use App\Models\AdminProduct;
use App\Models\Product;
use App\Models\Beef;
use App\Models\Vegetable;
use Livewire\Volt\Volt;
use Laravel\Fortify\Features;

// --------------------
// GLOBAL LOGOUT
// --------------------
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// --------------------
// ROOT ROUTE - Show Login Page First (CHANGED)
// --------------------
Route::get('/', fn() => view('customer.login'))->name('home'); // CHANGED: from customer.welcome to customer.login


// --------------------
// CUSTOMER ROUTES
// --------------------
Route::get('/welcome', fn() => view('customer.welcome'))->name('welcome'); // ADDED: Welcome page as separate route
Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');
Route::get('/todaysprice', [PriceController::class, 'todaysPrice'])->name('todaysprice');
Route::get('/pricehistory', [PriceController::class, 'priceHistory']);
Route::get('/login', fn() => view('customer.login'))->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
Route::get('/customer/category/{category}', [ProductController::class, 'categoryProducts'])->name('customer.category');
Route::get('/customer/favorites', function () {return view('customer.favorites');})->name('customer.favorites');
Route::get('/customer/settings', function () {return view('customer.settings');})->name('customer.settings');

// --------------------
// ADMIN ROUTES
// --------------------
Route::prefix('admin')->group(function () {

    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Dashboard for total products
   Route::get('/dashboard', function () {
    $totalProducts = Product::count() + Beef::count() + Vegetable::count();
    
    return view('admin.dashboard', [
        'totalProducts' => $totalProducts,
    ]);
})->middleware('auth')->name('admin.dashboard');
    // --------------------
    // CHICKEN CRUD
    // --------------------
   Route::middleware('auth')->group(function () {
    Route::get('/chicken-crud', [ProductController::class, 'adminIndex'])->name('admin.chicken-crud');
    Route::get('/chicken/create', [ProductController::class, 'create'])->name('admin.chicken.create');
    Route::post('/chicken', [ProductController::class, 'store'])->name('admin.chicken.store');
    Route::get('/chicken/{id}/edit', [ProductController::class, 'edit'])->name('admin.chicken.edit');
    Route::put('/chicken/{id}', [ProductController::class, 'update'])->name('admin.chicken.update');
    Route::delete('/chicken/{id}', [ProductController::class, 'destroy'])->name('admin.chicken.destroy');
});
    // --------------------
    // BEEF CRUD
    // --------------------
    Route::middleware('auth')->group(function () {
        Route::get('/beef-crud', [BeefController::class, 'index'])->name('admin.beef-crud');
        Route::get('/beef/create', [BeefController::class, 'create'])->name('admin.beef.create');
        Route::post('/beef', [BeefController::class, 'store'])->name('admin.beef.store');
        Route::get('/beef/{id}/edit', [BeefController::class, 'edit'])->name('admin.beef.edit');
        Route::put('/beef/{id}', [BeefController::class, 'update'])->name('admin.beef.update');
        Route::delete('/beef/{id}', [BeefController::class, 'destroy'])->name('admin.beef.destroy');
    });

    // --------------------
    // VEGETABLE CRUD
    // --------------------
    Route::middleware('auth')->group(function () {
        Route::get('/vegetable-crud', [VegetableController::class, 'index'])->name('admin.vegetable-crud');
        Route::get('/vegetable/create', [VegetableController::class, 'create'])->name('admin.vegetable.create');
        Route::post('/vegetable', [VegetableController::class, 'store'])->name('admin.vegetable.store');
        Route::get('/vegetable/{id}/edit', [VegetableController::class, 'edit'])->name('admin.vegetable.edit');
        Route::put('/vegetable/{id}', [VegetableController::class, 'update'])->name('admin.vegetable.update');
        Route::delete('/vegetable/{id}', [VegetableController::class, 'destroy'])->name('admin.vegetable.destroy');
    });

    // Store info
    Route::middleware('auth')->group(function () {
        Route::get('/storeinfo', fn() => view('admin.storeinfo'))->name('admin.storeinfo');
        Route::post('/storeinfo', [AdminAuthController::class, 'updateStoreInfo'])->name('admin.storeinfo.update');

        // Delete history
        Route::get('/deletehistory', function () {
            $deletedItems = AdminProduct::onlyTrashed()->get();
            return view('admin.deletehistory', compact('deletedItems'));
        })->name('admin.deletehistory');
    });
});
// --------------------
// SELLER DASHBOARD
// --------------------
Route::get('/dashboard', function () {

    // Define what counts as low stock
    $threshold = 5; // Anything <= 5 is low stock
    $displayLimit = 10; // Limit number of names shown

    // Count total products (all categories)
    $totalProducts =
        Product::count() +
        Beef::count() +
        Chicken::count() +
        Vegetable::count();

    // Fetch low stock items from each category
    $beefLow = Beef::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();
    $chickenLow = Chicken::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();
    $vegeLow = Vegetable::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();

    // Merge them all together
    $lowStockItems = collect()
        ->merge($beefLow)
        ->merge($chickenLow)
        ->merge($vegeLow)
        ->sortBy('stock')
        ->take($displayLimit);

    // Count total low-stock items
    $totalLowStock = $lowStockItems->count();

    // Send to Blade
    return view('admin.dashboard', [
        'totalProducts'  => $totalProducts,
        'totalLowStock'  => $totalLowStock,
        'lowStockItems'  => $lowStockItems,
        'threshold'      => $threshold,
    ]);
})->middleware('auth')->name('admin.dashboard');


// ADMIN DROPDOWN PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('settings', [AdminSettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});


// --------------------
// GLOBAL LOGOUT
// --------------------
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
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
});

// --------------------
// WELCOME ROUTE FOR ADMIN BUTTON
// --------------------
Route::get('/welcome', fn() => view('customer.welcome'))->name('welcome');