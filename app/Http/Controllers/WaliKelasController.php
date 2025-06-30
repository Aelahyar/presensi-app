<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class WaliKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:wali_kelas']);
    }

    public function dashboard()
    {
        // Tambahkan pengecekan tambahan
        // Pastikan user adalah wali kelas
        if (!auth()->user()->hasRole('wali_kelas')) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data wali kelas berdasarkan user login
        $waliKelas = Auth::user()->waliKelas;
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $waktuSekarang = Carbon::now();
        $tgl_absen = Carbon::now()->locale('id')->translatedFormat('d F Y');
        $user = auth()->user();
        $guruId = optional($user->guru)->id;
        $kelas = $waliKelas->kelas->nama_kelas;

        if (!$waliKelas) {
            abort(403, 'Data wali kelas tidak ditemukan.');
        }

        // Ambil ID kelas yang diampu wali kelas
        $kelasId = $waliKelas->kelas_id;

        // Ambil semua ID siswa dari kelas tersebut
        $siswaIds = $waliKelas->kelas->siswa->pluck('id');

        // Hitung jumlah presensi berdasarkan status
        $presensi = PresensiSiswa::whereIn('siswa_id', $siswaIds)
            ->selectRaw("
                SUM(CASE WHEN status_presensi = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
                SUM(CASE WHEN status_presensi = 'Izin' THEN 1 ELSE 0 END) AS izin,
                SUM(CASE WHEN status_presensi = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
                SUM(CASE WHEN status_presensi = 'Alpa' THEN 1 ELSE 0 END) AS alpa,
                SUM(CASE WHEN status_presensi = 'Telat' THEN 1 ELSE 0 END) AS telat,
                SUM(CASE WHEN status_presensi = 'Bolos' THEN 1 ELSE 0 END) AS bolos
            ")
            ->first();

        // Ambil jadwal mengajar hari ini milik guru tersebut
        if ($guruId) {
            $mengajars = JadwalPelajaran::with(['guru', 'matapelajaran', 'kelas'])
                ->where('hari', $hariIni)
                ->where('guru_id', $guruId)
                ->orderBy('kelas_id')
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('kelas.nama_kelas')
                ->sortKeysUsing('strnatcmp');
        }

        // Tambahkan filter untuk pelajaran yang sedang berlangsung sekarang
        $jadwalBerlangsung = $mengajars->flatMap(function ($jadwals, $kelasNama) use ($waktuSekarang) {
            return $jadwals->filter(function ($jadwal) use ($waktuSekarang) {
                $mulai = Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai);
                $selesai = Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai);

                // 🟡 Log untuk debug
                Log::info('Waktu Sekarang: ' . $waktuSekarang->toTimeString());
                Log::info('Mulai: ' . $jadwal->jam_mulai);
                Log::info('Selesai: ' . $jadwal->jam_selesai);

                return $waktuSekarang->between($mulai, $selesai);
            });
        })->groupBy('kelas.nama_kelas')
        ->sortKeysUsing('strnatcmp');

        // dd($jadwalBerlangsung);

        return view('walikelas.dashboard', compact('user',
        'kelas',
        'presensi',
        'tgl_absen', 'hariIni', 'mengajars', 'jadwalBerlangsung'));
    }

    public function option(){
        return view('walikelas.option');
    }

    public function editProfil()
    {
        $user = Auth::user();
        return view('walikelas.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        // Update di tabel wali_kelas jika ada
        if ($user->waliKelas) {
            $user->waliKelas->update([
                'email' => $request->email,
            ]);
        }

        // Update di tabel guru jika ada
        if ($user->guru) {
            $user->guru->update([
                'email' => $request->email,
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function formGantiPassword()
    {
        return view('walikelas.ganti-password');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }

        // Update password
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function getSiswaByKelas(Request $request)
    {
        $siswa = Siswa::with('kelas')
            ->where('kelas_id', $request->kelas_id)
            ->get();

        return response()->json($siswa);
    }
}
