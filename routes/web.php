<?php
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;

Route::get('/customer', [ProductController::class, 'index'])->name('customer.main');

// Home page for customers
Route::get('/', function () {
    return view('customer.welcome');
})->name('home');

// --------------------
// Admin login form
// --------------------
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

// --------------------
// Admin login process
// --------------------
Route::post('/admin/login', function (Request $request) {
    $credentials = $request->only(['email', 'password']); // ✅ works, because $request is an instance

    if (Auth::attempt($credentials)) {
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
})->name('admin.login.submit');

// --------------------
// Admin logout
// --------------------
Route::post('/admin/logout', function () {
    Auth::logout();
    return redirect()->route('admin.login');
})->name('admin.logout');

// --------------------
// Admin dashboard
// --------------------
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

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

require __DIR__.'/auth.php';
