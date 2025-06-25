<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use App\Models\JadwalPelajaran;
use App\Models\WaliKelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



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
}
