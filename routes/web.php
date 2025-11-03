<?php  

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ChickenController;
use App\Http\Controllers\BeefController;
use App\Http\Controllers\VegetableController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;

use App\Models\AdminProduct;
use App\Models\Chicken;
use App\Models\Product;
use App\Models\Beef;
use App\Models\Vegetable;
use App\Models\DeleteHistoryTable;
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
// ROOT ROUTE - Show Customer Main Page First
// --------------------
Route::get('/', [ProductController::class, 'index'])->name('home');

// --------------------
// UNIFIED LOGIN PAGE
// --------------------
Route::get('/login', function() {
    return view('login');
})->name('login');

// --------------------
// CUSTOMER ROUTES
// --------------------
Route::get('/welcome', fn() => view('customer.welcome'))->name('welcome');
Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');
Route::get('/todaysprice', [PriceController::class, 'todaysPrice'])->name('todaysprice')->middleware('auth');
Route::get('/pricehistory', [PriceController::class, 'priceHistory']);
Route::get('/beef-prices', [PriceController::class, 'beefPriceHistory']);
Route::get('/huaho-prices', [PriceController::class, 'huahoPriceHistory']);
Route::get('/soonlee-prices', [PriceController::class, 'soonleePriceHistory']);
Route::get('/login', fn() => view('customer.login'))->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
Route::get('/customer/category/{category}', [ProductController::class, 'categoryProducts'])->name('customer.category');
Route::get('/customer/favorites', function () {return view('customer.favorites');})->name('customer.favorites')->middleware('auth');
Route::get('/customer/settings', function () {return view('customer.settings');})->name('customer.settings')->middleware('auth');
Route::delete('/customer/delete-account', [CustomerAuthController::class, 'deleteAccount'])->name('customer.delete.account')->middleware('auth');

// Update these existing CUSTOMER routes to use database
Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');
Route::get('/customer/category/{category}', [ProductController::class, 'categoryProducts'])->name('customer.category');

// Favorites routes
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Favorites route (still using localStorage for now)
Route::get('/customer/favorites', [FavoriteController::class, 'index'])->name('customer.favorites');
Route::get('/favorites/user-status', [FavoriteController::class, 'userStatus'])->name('favorites.user-status');

// --------------------
// SIGNUP ROUTES
// --------------------
Route::get('/signup', function () {
    return view('customer.signuppage');
})->name('signup');
Route::post('/signup', [CustomerAuthController::class, 'register'])->name('customer.signup.submit');

// --------------------
// CUSTOMER LOGIN FORM
// --------------------
Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');

// --------------------
// ADMIN ROUTES
// --------------------
Route::prefix('admin')->group(function () {

    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');

    // Dashboard for total products
    Route::get('/dashboard', function () {
        $totalProducts = Chicken::count() + Beef::count() + Vegetable::count();
        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
        ]);
    })->middleware('auth')->name('admin.dashboard');

    // --------------------
    // CHICKEN CRUD
    // --------------------
    Route::middleware('auth')->group(function () {
        Route::get('/chicken-crud', [ChickenController::class, 'adminIndex'])->name('admin.chicken-crud');
        Route::get('/chicken/create', [ChickenController::class, 'create'])->name('admin.chicken.create');
        Route::post('/chicken', [ChickenController::class, 'store'])->name('admin.chicken.store');
        Route::get('/chicken/{id}/edit', [ChickenController::class, 'edit'])->name('admin.chicken.edit');
        Route::put('/chicken/{id}', [ChickenController::class, 'update'])->name('admin.chicken.update');
        Route::get('/chicken/{id}/delete', [ChickenController::class, 'confirmDelete'])->name('admin.chicken.confirmDelete');
        Route::delete('/chicken/{id}', [ChickenController::class, 'destroy'])->name('admin.chicken.destroy');
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
        Route::get('/beef/{id}/delete', [BeefController::class, 'confirmDelete'])->name('admin.beef.confirmDelete');
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
        Route::get('/vegetable/{id}/delete', [VegetableController::class, 'confirmDelete'])->name('admin.vegetable.confirmDelete');
        Route::delete('/vegetable/{id}', [VegetableController::class, 'destroy'])->name('admin.vegetable.destroy');
    });

    // --------------------
    // STORE INFO + DELETE HISTORY
    // --------------------
    Route::middleware('auth')->group(function () {
        Route::get('/storeinfo', fn() => view('admin.storeinfo'))->name('admin.storeinfo');
        Route::post('/storeinfo', [AdminAuthController::class, 'updateStoreInfo'])->name('admin.storeinfo.update');
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
    $threshold = 5;
    $displayLimit = 10;

    $totalProducts =
        Beef::count() +
        Chicken::count() +
        Vegetable::count();

    $beefLow = Beef::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();
    $chickenLow = Chicken::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();
    $vegeLow = Vegetable::select('id', 'name', 'stock')->where('stock', '<=', $threshold)->get();

    $lowStockItems = collect()
        ->merge($beefLow)
        ->merge($chickenLow)
        ->merge($vegeLow)
        ->sortBy('stock')
        ->take($displayLimit);

    $totalLowStock = $lowStockItems->count();

    return view('admin.dashboard', [
        'totalProducts'  => $totalProducts,
        'totalLowStock'  => $totalLowStock,
        'lowStockItems'  => $lowStockItems,
        'threshold'      => $threshold,
    ]);
})->middleware('auth')->name('admin.dashboard');

// --------------------
// ADMIN PROFILE + SETTINGS
// --------------------
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('settings', [AdminSettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});

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

// --------------------
// DELETE HISTORY CUSTOM ROUTE
// --------------------
Route::get('/admin/delete-history', function () {
    $deletedItems = DeleteHistoryTable::latest()->get();
    return view('admin.deletehistory', compact('deletedItems'));
})->name('admin.deletehistory');

Route::get('/admin/delete-history/fetch', function () {
    return DeleteHistoryTable::latest()->get();
})->name('admin.deletehistory.fetch');

// --------------------
// FINAL DASHBOARD ROUTE WITH RECENT DELETES
// --------------------
Route::get('/dashboard', function () {
    $totalProducts = Chicken::count();
    $recentDeletes = DeleteHistoryTable::latest()->take(3)->get();

    return view('admin.dashboard', [
        'totalProducts' => $totalProducts,
        'recentDeletes' => $recentDeletes,
    ]);
})->middleware('auth')->name('admin.dashboard');
// --------------------
// PRODUCT ROUTES WITH AUTH MIDDLEWARE
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});
// --------------------
// ADMIN PRODUCT ROUTES WITH STORE PARAMETER
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin/{store}')->group(function () {
        Route::get('/', function ($store) {
            return redirect("/admin/$store/dashboard");
        });

        Route::get('/dashboard', [ProductController::class, 'adminIndex'])
            ->name('admin.dashboard');

        Route::get('/products', [ProductController::class, 'adminIndex'])
            ->name('admin.products');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('admin.products.store');
    });
});
