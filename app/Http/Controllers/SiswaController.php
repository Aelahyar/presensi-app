<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dataSiswa()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil guru yang terkait dengan user
        $guru = $user->guru;

        if (!$guru) {
            return abort(403, 'Guru tidak ditemukan');
        }

        // Ambil semua kelas yang diajar oleh guru ini melalui JadwalAjar
        $kelasIds = JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id')->unique();

        // Ambil data kelas beserta siswa-siswanya
        $kelasDenganSiswa = Kelas::with('siswa')
            ->whereIn('id', $kelasIds)
            ->get();

            // dd($kelasDenganSiswa);

        // Kirim ke view
        return view('walikelas.siswa', compact('kelasDenganSiswa'));
    }
}
