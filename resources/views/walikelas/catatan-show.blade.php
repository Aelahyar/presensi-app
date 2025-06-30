@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-between align-items-center text-white">
        <a href="{{ Route('catatan.wali')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Detail Catatan</h5>
    </header>
@endsection
@section('content')
<div class="container">
    <br>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Informasi Siswa
        </div>
        <div class="card-body">
            <p><strong>Nama Siswa:</strong> {{ $catatan->siswa->nama_lengkap }}</p>
            <p><strong>NISN:</strong> {{ $catatan->siswa->nisn }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $catatan->siswa->jenis_kelamin }}</p>
            <p><strong>Alamat:</strong> {{ $catatan->siswa->alamat }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-warning text-dark">
            Detail Pelanggaran
        </div>
        <div class="card-body">
            <p><strong>Pelapor:</strong> {{ $catatan->user->username }} ({{ $catatan->user->email }})</p>
            <p><strong>Tanggal Kejadian:</strong> {{ \Carbon\Carbon::parse($catatan->tanggal_kejadian)->format('d M Y') }}</p>
            <p><strong>Jenis Pelanggaran:</strong> {{ $catatan->jenis_pelanggaran }}</p>
            <p><strong>Deskripsi:</strong> {{ $catatan->deskripsi_pelanggaran }}</p>
            <p><strong>Status Penanganan:</strong> <span class="badge bg-info">{{ $catatan->status_penanganan }}</span></p>
            <p><strong>Tanggal Dilaporkan:</strong> {{ \Carbon\Carbon::parse($catatan->tanggal_dilaporkan)->format('d M Y H:i') }}</p>
            @if ($catatan->tanggal_selesai_penanganan)
                <p><strong>Tanggal Selesai Penanganan:</strong> {{ \Carbon\Carbon::parse($catatan->tanggal_selesai_penanganan)->format('d M Y H:i') }}</p>
            @endif
        </div>
    </div>

    @if ($catatan->tindakan_wali_kelas)
    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            Tindakan Wali Kelas
        </div>
        <div class="card-body">
            <p>{{ $catatan->tindakan_wali_kelas }}</p>
        </div>
    </div>
    @endif

    @if ($catatan->tindakan_bk)
    <div class="card mb-3">
        <div class="card-header bg-danger text-white">
            Tindakan BK
        </div>
        <div class="card-body">
            <p>{{ $catatan->tindakan_bk }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
