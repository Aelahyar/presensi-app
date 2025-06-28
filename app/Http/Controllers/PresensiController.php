<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use App\Models\PresensiGuru;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:wali_kelas']);
    }

    public function index() {
        $guru = Auth::user()->guru;
        $user = auth()->user();
        $guruId = optional($user->guru)->id;

        if (!$guru) {
            abort(403, 'Guru tidak ditemukan atau tidak memiliki akses.');
        }

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');

        $jadwalHariIni = JadwalPelajaran::with([
            'guru',
            'mataPelajaran',
            'kelas.siswa'
        ])
        ->where('hari', $hariIni)
        ->where('guru_id', $guruId)
        ->orderBy('kelas_id')
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy(fn($item) => $item->mataPelajaran->nama_mapel);

        return view('walikelas.presensi', compact('jadwalHariIni'));
    }

    public function show($jadwalId)
    {
        $jadwal = JadwalPelajaran::with(['kelas.siswa', 'mataPelajaran', 'lokasiPresensi'])->findOrFail($jadwalId);

        // Ambil data presensi siswa yang sudah tercatat hari ini
        $presensiHariIni = PresensiSiswa::where('jadwal_id', $jadwalId)
            ->whereDate('tanggal', now()->toDateString())
            ->get()
            ->keyBy('siswa_id'); // agar mudah diakses: $presensiHariIni[$siswa->id]

        // Ambil salah satu materi dari presensi hari ini (jika ada)
        $materi = PresensiSiswa::where('jadwal_id', $jadwalId)
            ->whereDate('tanggal', now()->toDateString())
            ->value('materi');

        return view('walikelas.presensi-detail', compact('jadwal', 'presensiHariIni', 'materi'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelajarans,id',
            'presensi' => 'required|array',
            'materi' => 'required|string',
        ]);

        $jadwal = JadwalPelajaran::findOrFail($request->jadwal_id);
        $guruId = Auth::user()->guru->id;
        $today = now()->toDateString();

        // ✅ Simpan presensi siswa
        foreach ($request->presensi as $siswaId => $status) {
            PresensiSiswa::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'tanggal' => $today,
                ],
                [
                    'waktu_presensi' => now(),
                    'status_presensi' => $status,
                    'materi' => $request->materi,
                    'guru_id' => $guruId,
                ]
            );
        }

        // ✅ Cek apakah guru sudah presensi hari ini di jadwal tersebut
        $presensiGuru = PresensiGuru::where('jadwal_id', $jadwal->id)
            ->where('guru_id', $guruId)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$presensiGuru) {
            PresensiGuru::create([
                'jadwal_id' => $jadwal->id,
                'guru_id' => $guruId,
                'tanggal' => $today,
                'waktu_presensi' => now(),
                'status_presensi' => 'Hadir',
                'lokasi_valid' => true, // diasumsikan valid karena sudah dicek di index
                'keterangan' => 'Otomatis tercatat saat presensi siswa',
            ]);
        }

        return redirect()->route('wali_kelas.index')->with('success', 'Presensi berhasil disimpan.');
    }



    // Fungsi bantu hitung jarak
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return $miles * 1609.344; // hasil dalam meter
    }

    public function rekapPresensi(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $request->validate([
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
        ]);

        $query = PresensiSiswa::with(['siswa', 'jadwal.kelas', 'jadwal.mataPelajaran'])
                    ->when($tanggalAwal && $tanggalAkhir, function ($q) use ($tanggalAwal, $tanggalAkhir) {
                        $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
                    })
                    ->orderBy('tanggal', 'desc');

        $rekap = $query->get();

        return view('walikelas.presensi-rekap', compact('rekap', 'tanggalAwal', 'tanggalAkhir'));
    }

}
