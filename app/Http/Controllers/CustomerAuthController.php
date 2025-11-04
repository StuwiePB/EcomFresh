<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
// Password hashing is handled by the User model cast ('password' => 'hashed')
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    /**
     * Show the customer login form
     */
    public function showLoginForm()
    {
        return view('customer.login');
    }

    /**
     * Handle customer login request
     */
    public function login(Request $request)
    {
        // Check for too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Add remember me functionality
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            
            return $this->sendLoginResponse($request);
        }

        // If login attempt was unsuccessful, increment login attempts
        $this->incrementLoginAttempts($request);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the customer registration form
     */
    public function showRegisterForm()
    {
        return view('customer.signuppage');
    }

    /**
     * Handle customer registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // The User model casts 'password' => 'hashed', so provide the plain password
            // and let the model handle hashing to avoid double-hashing.
            'password' => $request->password,
            // Some DB schemas require `store_name` to be present and NOT NULL. Provide
            // an empty string as a safe default when the signup form doesn't include it.
            'store_name' => $request->input('store_name', ''),
        ]);

        // Fire registered event (useful for sending welcome emails)
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Call the registered method for additional actions
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('success', 'Account created successfully! Welcome to EcomFresh!');
    }

    /**
     * Log the user out and redirect to login page
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect to login page after logout instead of home page
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * NEW: Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Logout the user first
        Auth::logout();
        
        // Delete the user account
        $user->delete();
        
        // Invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Your account has been deleted successfully.');
    }

    /**
     * Show password reset request form
     */
    public function showLinkRequestForm()
    {
        return view('customer.passwords.email');
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('customer.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the guard to be used during authentication
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the post register/login redirect path
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/customer';
    }

    /**
     * The user has been registered - you can add additional logic here
     */
    protected function registered(Request $request, $user)
    {
        // Additional actions after registration
        // For example: Send welcome email, create user profile, etc.
        
        // Return null to continue with default redirect
        return null;
    }

    /**
     * NEW: Handle authenticated user - for redirecting after login
     */
    public function authenticated(Request $request, $user)
    {
        // Check if there's an intended URL (from middleware auth redirect)
        if ($request->session()->has('url.intended')) {
            return redirect()->intended();
        }
        
        return redirect()->route('customer.main');
    }

    /**
     * NEW: Simple redirect method for intended URLs
     */
    public function redirectToIntended()
    {
        return redirect()->intended(route('customer.main'));
    }

    /**
     * NEW: Send the response after the user was authenticated.
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * NEW: Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * NEW: Get the login username to be used by the controller.
     */
    public function username()
    {
        return 'email';
    }

    /**
     * NEW: Increment the login attempts for the user.
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request), $this->decayMinutes() * 60
        );
    }

    /**
     * NEW: Determine if the user has too many failed login attempts.
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts()
        );
    }

    /**
     * NEW: Clear the login locks for the given user credentials.
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    /**
     * NEW: Redirect the user after determining they are locked out.
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [
                trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ])
            ],
        ])->status(429);
    }

    /**
     * NEW: Fire an event when a lockout occurs.
     */
    protected function fireLockoutEvent(Request $request)
    {
        // You can add custom lockout event here if needed
    }

    /**
     * NEW: Get the throttle key for the given request.
     */
    protected function throttleKey(Request $request)
    {
        return strtolower($request->input($this->username())).'|'.$request->ip();
    }

    /**
     * NEW: Get the maximum number of attempts to allow.
     */
    public function maxAttempts()
    {
        return 5; // 5 login attempts
    }

    /**
     * NEW: Get the number of minutes to throttle for.
     */
    public function decayMinutes()
    {
        return 1; // 1 minute lockout
    }

    /**
     * NEW: Get the rate limiter instance.
     */
    protected function limiter()
    {
        return app(\Illuminate\Cache\RateLimiter::class);
    }
}