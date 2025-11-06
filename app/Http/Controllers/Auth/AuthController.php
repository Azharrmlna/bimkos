<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            return $this->redirectUser($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->onlyInput('email');
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'kelas' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'kelas' => $validated['kelas'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'siswa', // Default role adalah siswa
        ]);

        Auth::login($user);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    // Helper method untuk redirect berdasarkan role
    private function redirectUser($user)
    {
        if ($user->isGuruBK()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSiswa()) {
            return redirect()->route('siswa.dashboard');
        }

        Auth::logout();
        return redirect()->route('login')->withErrors('Role user tidak dikenali.');
    }
}