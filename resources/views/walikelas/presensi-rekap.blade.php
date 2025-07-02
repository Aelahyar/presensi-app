@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-between align-items-center text-white">
        <a href="{{ Route('wali_kelas.presensi')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Rekap Presensi</h5>
    </header>
@endsection

@section('content')
    <div class="p-3">
        <form method="GET" class="mb-3 row g-2 align-items-end">
            <div class="row">
                <div class="col-6">
                    <label for="tanggal_awal" class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-6">
                    <label for="tanggal_akhir" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-success w-100">Tampilkan</button>
            </div>
        </form>

        <div class="table-responsive">
            <table id="table1" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Status</th>
                        <th>Materi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap as $data)
                        <tr>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->siswa->nama_lengkap ?? '-'  }}</td>
                            <td>{{ $data->jadwal->kelas->nama_kelas ?? '-'  }}</td>
                            <td>{{ $data->jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                            <td>{{ $data->status_presensi ?? '-'  }}</td>
                            <td>{{ $data->materi ?? '-'  }}</td>
                        </tr>
                    @empty
                        {{-- <tr>
                            <td colspan="6" class="text-center"></td>
                        </tr> --}}
                        <div class="alert alert-danger text-center">
                            Data tidak ditemukan
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
