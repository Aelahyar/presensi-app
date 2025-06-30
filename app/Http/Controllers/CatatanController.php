<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Catatan;
use App\Models\WaliKelas;
use App\Models\Kelas;

class CatatanController extends Controller
{
        // Wali Kelas - Lihat semua catatan yang dia buat
    public function indexWali()
    {
        $catatans = Catatan::with(['siswa.kelas'])
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy(function ($item) {
                return $item->siswa->kelas->nama_kelas ?? 'Tidak Ada Kelas';
            })
            ->map(function ($items) {
                return $items->groupBy('status_penanganan');
            });

        return view('walikelas.catatan', compact('catatans'));
    }

    // Form input catatan
    public function create()
    {

        $user = auth()->user();
        if (!$user) {
            abort(403, 'Anda bukan wali kelas.');
        }


        // Ambil semua kelas yang berkaitan dengan wali kelas saat ini
        $waliKelas = WaliKelas::where('user_id', auth()->id())->first();

        if (!$waliKelas || !$waliKelas->kelas_id) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }

        // Ambil hanya kelas yang diampu wali kelas ini
        $kelasList = Kelas::where('id', $waliKelas->kelas_id)->get();

        return view('walikelas.catatan-create', compact('kelasList'));
    }

    // Simpan catatan
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'siswa_id' => 'required|array',
            'tanggal_kejadian' => 'required|date',
            'jenis_pelanggaran' => 'required|string',
            'deskripsi_pelanggaran' => 'required|array',
            'deskripsi_pelanggaran.*' => 'nullable|string',
            'status_penanganan' => 'required|in:Ditangani Wali Kelas,Dilimpahkan ke BK',
            'tindakan_wali_kelas' => 'nullable|string',
        ]);


        foreach ($request->input('siswa_id', []) as $siswaId) {
            $deskripsi = $request->input("deskripsi_pelanggaran.$siswaId");

            if (!$deskripsi) continue; // Lewatkan jika kosong

            Catatan::create([
                'siswa_id' => $siswaId,
                'user_id' => auth()->id(),
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'jenis_pelanggaran' => $request->jenis_pelanggaran,
                'deskripsi_pelanggaran' => $deskripsi,
                'status_penanganan' => $request->status_penanganan,
                'tindakan_wali_kelas' => $request->status_penanganan === 'Ditangani Wali Kelas' ? 'Dipantau oleh wali kelas' : null,
                'tanggal_dilaporkan' => now(),
            ]);
        }
        return redirect()->route('catatan.wali')->with('success', 'Catatan pelanggaran berhasil ditambahkan.');
    }

    // Lihat detail catatan
    public function show($id)
    {
        $catatan = Catatan::with(['siswa', 'user'])->findOrFail($id);
        // dd($catatan);
        return view('walikelas.catatan-show', compact('catatan'));
    }

        // BK - Lihat semua catatan
    public function indexBk()
    {
        $catatans = Catatan::whereIn('status_penanganan', ['Dilimpahkan ke BK', 'Ditangani BK', 'Selesai'])
            ->with(['siswa', 'user'])
            ->latest()
            ->get();

        return view('catatan.bk.index', compact('catatans'));
    }

    // BK - Form penanganan
    public function edit($id)
    {
        $catatan = Catatan::findOrFail($id);
        return view('catatan.bk.edit', compact('catatan'));
    }

    // BK - Simpan tindakan
    public function update(Request $request, $id)
    {
        $request->validate([
            'tindakan_bk' => 'required|string',
            'status_penanganan' => 'required|in:Ditangani BK,Selesai',
        ]);

        $catatan = Catatan::findOrFail($id);
        $catatan->update([
            'tindakan_bk' => $request->tindakan_bk,
            'status_penanganan' => $request->status_penanganan,
            'tanggal_selesai_penanganan' => now(),
        ]);

        return redirect()->route('catatan.bk')->with('success', 'Catatan berhasil ditangani.');
    }
}
