<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // public function handle($request, Closure $next, $role)
    // {
    //     $user = $request->user();

    //     if (!$user) {
    //         return redirect('/login');
    //     }

    //     $method = 'is' . str_replace('_', '', ucwords($role, '_'));

    //     if (method_exists($user, $method) && $user->$method()) {
    //         return $next($request);
    //     }

    //     abort(403, 'Unauthorized action.');
    // }
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login'); // Redirect ke halaman login jika belum login
        }

        $user = Auth::user();

        // Periksa apakah pengguna memiliki salah satu peran yang diizinkan
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request); // Lanjutkan request jika peran cocok
            }
        }

        // Jika tidak memiliki peran yang diizinkan, redirect ke halaman home atau error
        // return redirect('/home')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->withErrors(['access' => 'Akses ditolak. Silakan login kembali.']);

    }

}
