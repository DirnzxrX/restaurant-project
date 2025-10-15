<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'namauser' => 'required|string',
                'password' => 'required|string',
            ]);

            $credentials = [
                'namauser' => $request->namauser,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'namauser' => 'Username atau password salah.',
            ])->onlyInput('namauser');
        } catch (\Exception $e) {
            return back()->withErrors([
                'namauser' => 'Terjadi kesalahan. Silakan coba lagi.',
            ])->onlyInput('namauser');
        }
    }

    /**
     * Show the register form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle register request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'namauser' => ['required', 'string', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,kasir,waiter,owner'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'namauser' => $request->namauser,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show password reset form.
     */
    public function showPasswordResetForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Handle password reset request.
     */
    public function sendPasswordResetLink(Request $request)
    {
        // For now, just redirect back with a message
        // You can implement actual password reset functionality later if needed
        return back()->with('status', 'Password reset functionality not implemented yet.');
    }
}
