<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\KepalaSekolah;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\BK;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('kepala_sekolah')) {
                return redirect()->intended('/kepala-sekolah/dashboard');
            } elseif ($user->hasRole('wali_kelas')) {
                return redirect()->intended('/wali-kelas/dashboard');
            } elseif ($user->hasRole('guru')) {
                return redirect()->intended('/guru/dashboard');
            } elseif ($user->hasRole('bk')) {
                return redirect()->intended('/bk/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
