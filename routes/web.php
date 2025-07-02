<?php

use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\CatatanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BKController;

Route::get('/force-logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});


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
        Route::get('/profil', [WaliKelasController::class, 'editProfil'])->name('wali_kelas.profil');
        Route::get('/ganti-password', [WaliKelasController::class, 'formGantiPassword'])->name('wali_kelas.password.form');
        Route::post('/ganti-password', [WaliKelasController::class, 'gantiPassword'])->name('wali_kelas.password.update');
        Route::post('/profil/update', [WaliKelasController::class, 'updateProfil'])->name('wali_kelas.profil.update');
        // Get siswa
        Route::get('/get-siswa', [WaliKelasController::class, 'getSiswaByKelas'])->name('get.siswa');
        // Presensi
        Route::get('/presensi', [PresensiController::class, 'index'])->name('wali_kelas.presensi');
        Route::get('/presensi/{jadwal}', [PresensiController::class, 'show'])->name('wali_kelas.show');
        Route::get('/detail/presensi', [PresensiController::class, 'index'])->name('wali_kelas.index');
        Route::post('/presensi/store', [PresensiController::class, 'store'])->name('wali_kelas.store');
        Route::get('/rekap-presensi', [PresensiController::class, 'rekapPresensi'])->name('wali_kelas.rekap');
        // Nilai
        Route::get('/nilai', [NilaiController::class, 'index'])->name('wali_kelas.nilai');
        Route::get('/nilai/tambah', [NilaiController::class, 'showInput'])->name('wali_kelas.tambah');
        Route::post('/nilai-siswa/simpan', [NilaiController::class, 'store'])->name('nilai-siswa.store');
        Route::get('/nilai/detail/{mapel}/{kelas}/{jenis}', [NilaiController::class, 'detail'])->name('wali_kelas.detail');
        Route::get('/nilai/edit-group', [NilaiController::class, 'editGroup'])->name('nilai.editGroup');
        Route::put('/nilai/update-group', [NilaiController::class, 'updateGroup'])->name('nilai.updateGroup');
        Route::delete('/nilai/group', [NilaiController::class, 'destroyGroup'])->name('nilai.destroyGroup');
        // Catatan
        Route::get('/catatan/wali', [CatatanController::class, 'indexWali'])->name('catatan.wali');
        Route::get('/catatan/create', [CatatanController::class, 'create'])->name('catatan.create');
        Route::post('/catatan', [CatatanController::class, 'store'])->name('catatan.store');
        Route::get('/catatan/{id}', [CatatanController::class, 'show'])->name('catatan.show');
        // Siswa
        Route::get('/siswa', [SiswaController::class, 'dataSiswa'])->name('wali_kelas.siswa');
    });

    Route::middleware(['role:guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
        // Presensi
        Route::get('/presensi', [PresensiController::class, 'index'])->name('guru.presensi');
        Route::get('/presensi/{jadwal}', [PresensiController::class, 'show'])->name('guru.show');
        Route::get('/detail/presensi', [PresensiController::class, 'index'])->name('guru.index');
        Route::post('/presensi/store', [PresensiController::class, 'store'])->name('guru.store');
        Route::get('/rekap-presensi', [PresensiController::class, 'rekapPresensi'])->name('guru.rekap');
        // Nilai
        Route::get('/nilai', [NilaiController::class, 'index'])->name('guru.nilai');
        Route::get('/nilai/tambah', [NilaiController::class, 'showInput'])->name('guru-nilai.tambah');
        Route::post('/nilai-siswa/simpan', [NilaiController::class, 'store'])->name('guru-nilai.store');
        Route::get('/nilai/detail/{mapel}/{kelas}/{jenis}', [NilaiController::class, 'detail'])->name('guru-nilai.detail');
        Route::get('/nilai/edit-group', [NilaiController::class, 'editGroup'])->name('guru-nilai.editGroup');
        Route::put('/nilai/update-group', [NilaiController::class, 'updateGroup'])->name('guru-nilai.updateGroup');
        Route::delete('/nilai/group', [NilaiController::class, 'destroyGroup'])->name('guru-nilai.destroyGroup');
    });

    Route::middleware(['role:bk'])->prefix('bk')->group(function () {
        Route::get('/dashboard', [BKController::class, 'dashboard'])->name('bk.dashboard');
        Route::get('/catatan/bk', [CatatanController::class, 'indexBk'])->name('catatan.bk');
        Route::get('/catatan/{id}/tangani', [CatatanController::class, 'edit'])->name('catatan.edit');
        Route::put('/catatan/{id}', [CatatanController::class, 'update'])->name('catatan.update');
        Route::get('/catatan/{id}', [CatatanController::class, 'show'])->name('catatan.show.bk');
    });

});

// Route::get('/', function () {
//     return view('welcome');
// });
