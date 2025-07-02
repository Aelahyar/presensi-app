<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NilaiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){

    // Ambil data guru yang sedang login
    $guru = Auth::user()->guru;

    // Pastikan guru ditemukan
    if (!$guru) {
        abort(403, 'Guru tidak ditemukan atau tidak memiliki akses.');
    }

    // Ambil dan kelompokkan nilai berdasarkan mapel, kelas, dan jenis_nilai
    $nilaiRingkas = NilaiSiswa::with(['siswa.kelas', 'mataPelajaran'])
        ->where('guru_id', $guru->id)
        ->get()
        ->groupBy(function ($item) {
            return $item->mataPelajaran->nama_mapel;
        })->map(function ($items) {
            return $items->groupBy(function ($item) {
                return $item->siswa->kelas->nama_kelas;
            })->map(function ($itemsPerKelas) {
                return $itemsPerKelas->groupBy('jenis_nilai');
            });
        });
        // dd($nilaiRingkas);

        if (auth()->user()->hasRole('wali_kelas')) {
            return view('walikelas.nilai', compact('nilaiRingkas'));
        } else {
            return view('guru.nilai', compact('nilaiRingkas'));
        }
    }

    public function detail($mapel_id, $kelas_id, $jenis)
    {
        $dataNilai = NilaiSiswa::with(['siswa.kelas', 'mataPelajaran'])
            ->where('mapel_id', $mapel_id)
            ->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelas_id))
            ->where('jenis_nilai', $jenis)
            ->get();

        if ($dataNilai->isEmpty()) {
            return back()->with('error', 'Data nilai tidak ditemukan.');
        }

        return view('walikelas.detail', [
            'dataNilai'     => $dataNilai,
            'jenis_nilai'   => $jenis,
            'tanggal_input' => $dataNilai->first()->tanggal_input,
            'mapel'         => $dataNilai->first()->mataPelajaran->nama_mapel,
            'kelas'         => $dataNilai->first()->siswa->kelas->nama_kelas,
        ]);
    }

    public function showInput()
    {
        $guru = Auth::user()->guru;

        // Ambil semua jadwal pelajaran yang diajar guru ini
        $jadwal = JadwalPelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guru->id)
            ->get();

        // Ambil mapel & kelas unik dari jadwal tersebut
        $mapelList = $jadwal->pluck('mataPelajaran')->unique('id');
        $kelasList = $jadwal->pluck('kelas')->unique('id');

        return view('walikelas.input', compact('mapelList', 'kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_nilai' => 'required|string',
            'tanggal_input' => 'required|date',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {
        // Hitung predikat dari nilai
            $predikat = match (true) {
                $nilai >= 90 => 'A',
                $nilai >= 70 => 'B',
                $nilai >= 50 => 'C',
                $nilai >= 30 => 'D',
                default => 'E',
            };

            NilaiSiswa::create([
                'siswa_id'      => $siswa_id,
                'mapel_id'      => $request->mapel_id,
                'guru_id'       => $guru->id,
                'jenis_nilai'   => $request->jenis_nilai,
                'nilai'         => $nilai,
                'tanggal_input' => $request->tanggal_input,
                'keterangan'    => $predikat, // <--- simpan predikat di sini
            ]);
        }

        return redirect()->route('wali_kelas.nilai')->with('success', 'Data nilai berhasil disimpan.');
    }

    public function editGroup(Request $request)
    {
        $dataNilai = NilaiSiswa::with('siswa.kelas')
            ->where('mapel_id', $request->mapel)
            ->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas))
            ->where('jenis_nilai', $request->jenis)
            ->get();

        if ($dataNilai->isEmpty()) {
            return redirect()->route('walikelas.nilai')->with('error', 'Data nilai tidak ditemukan.');
        }

        return view('walikelas.edit', compact('dataNilai'));
    }

    public function updateGroup(Request $request)
    {
        foreach ($request->nilai as $id => $nilai) {
            $data = NilaiSiswa::find($id);
            if ($data) {
                $data->nilai = $nilai;
                $data->keterangan = $request->keterangan[$id] ?? null;
                $data->save();
            }
        }

        return redirect()->route('wali_kelas.nilai')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroyGroup(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_nilai' => 'required|string',
        ]);

        NilaiSiswa::where('mapel_id', $request->mapel_id)
            ->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id))
            ->where('jenis_nilai', $request->jenis_nilai)
            ->delete();

        return redirect()->route('wali_kelas.nilai')->with('success', 'Semua nilai berhasil dihapus.');
    }
}
