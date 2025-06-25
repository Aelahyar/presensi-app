<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BKController;

// Route::get('/check-auth', function () {
//     return auth()->check()
//         ? response()->json(['authenticated' => true])
//         : response()->json(['authenticated' => false], 401);
// })->name('check.auth');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Group role
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    Route::middleware(['role:kepala_sekolah'])->prefix('kepala-sekolah')->group(function () {
        Route::get('/dashboard', [KepalaSekolahController::class, 'dashboard'])->name('kepala_sekolah.dashboard');
    });

    Route::middleware(['role:wali_kelas'])->prefix('wali-kelas')->group(function () {
        Route::get('/dashboard', [WaliKelasController::class, 'dashboard'])->name('wali_kelas.dashboard');
        Route::get('/option', [WaliKelasController::class, 'option'])->name('wali_kelas.option');
        Route::get('/siswa', [SiswaController::class, 'dataSiswa'])->name('wali_kelas.siswa');
    });

    Route::middleware(['role:guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    });

    Route::middleware(['role:bk'])->prefix('bk')->group(function () {
        Route::get('/dashboard', [BKController::class, 'dashboard'])->name('bk.dashboard');
    });

});



// Route::get('/', function () {
//     return view('welcome');
// });
