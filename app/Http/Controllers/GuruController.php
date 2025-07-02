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

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function dashboard()
    {
        if (!auth()->user()->hasRole('guru')) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();
        $guruId = optional($user->guru)->id;

        if (!$guruId) {
            abort(403, 'Data guru tidak ditemukan.');
        }

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $waktuSekarang = Carbon::now();
        $tgl_absen = Carbon::now()->locale('id')->translatedFormat('d F Y');

        // Ambil semua jadwal hari ini milik guru, dengan relasi kelas dan mata pelajaran
        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('hari', $hariIni)
            ->where('guru_id', $guruId)
            ->orderBy('kelas_id')
            ->orderBy('jam_mulai')
            ->get();

        // Tambahkan log jika ada jadwal yang tidak memiliki kelas
        foreach ($jadwalHariIni as $jadwal) {
            if (!$jadwal->kelas) {
                Log::warning("⚠️ Jadwal ID {$jadwal->id} tidak memiliki relasi kelas.");
            }
        }

        // Filter hanya jadwal yang memiliki relasi kelas
        $jadwalHariIni = $jadwalHariIni->filter(function ($jadwal) {
            return $jadwal->kelas !== null;
        });

        // Grouping berdasarkan nama kelas
        $mengajars = $jadwalHariIni
            ->groupBy('kelas.nama_kelas')
            ->sortKeysUsing('strnatcmp');

        // Jadwal yang sedang berlangsung
        $jadwalBerlangsung = $jadwalHariIni
            ->filter(function ($jadwal) use ($waktuSekarang) {
                $mulai = Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai);
                $selesai = Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai);

                return $waktuSekarang->between($mulai, $selesai);
            })
            ->groupBy('kelas.nama_kelas')
            ->sortKeysUsing('strnatcmp');

        return view('guru.dashboard', compact(
            'user',
            'hariIni',
            'tgl_absen',
            'mengajars',
            'jadwalBerlangsung'
        ));
    }
}
