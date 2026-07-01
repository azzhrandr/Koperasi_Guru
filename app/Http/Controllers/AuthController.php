<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('anggota.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status !== 'aktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun Anda dinonaktifkan. Hubungi admin.']);
            }

            $request->session()->regenerate();
            
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Administrator!')
                : redirect()->route('anggota.dashboard')->with('success', 'Selamat datang di Koperasi Guru!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    /**
     * Quick role switcher for demo purposes.
     */
    public function switchRole()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->role === 'admin') {
            Auth::loginUsingId(2); // Log in as Budi Setiawan (anggota)
            return redirect()->route('anggota.dashboard')->with('success', 'Beralih ke Anggota Mode (Budi Setiawan)');
        } else {
            Auth::loginUsingId(1); // Log in as Administrator
            return redirect()->route('admin.dashboard')->with('success', 'Beralih ke Admin Mode');
        }
    }

    /**
     * Show the member registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('login');
        }
        return view('auth.register');
    }

    /**
     * Handle member registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:30', 'unique:users,nip'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        Auth::login($user);

        return redirect()->route('anggota.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Koperasi Guru.');
    }
}
