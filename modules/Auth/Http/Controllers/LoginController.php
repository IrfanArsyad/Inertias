<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function index(): Response|RedirectResponse
    {
        // If already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->intended('/');
        }

        return Inertia::render('auth::Login', [
            'appName' => config('app.name', 'Laravel')
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Auto-login as first user (development only)
     * Remove this in production!
     */
    public function autoLogin(): RedirectResponse
    {
        $user = User::first();

        if ($user) {
            Auth::login($user);
            return redirect('/');
        }

        return redirect('/login')->with('error', 'No users found. Please create a user first.');
    }
}
