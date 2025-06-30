@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-center align-items-center">
        <h5 class="mb-0 text-white text-center">Catatan</h5>
    </header>

@endsection
@section('content')
    <nav class="subject-tabs">
        <ul class="nav nav-pills">
            @foreach ($catatans as $kelas => $group)
                <li class="nav-item" style="display: inline-block;">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-bs-toggle="tab"
                    href="#tab-{{ Str::slug($kelas) }}">
                        {{ $kelas }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <main class="grades-list">
        <div class="tab-content grades-list">
            @foreach ($catatans as $kelas => $statusGroup)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ Str::slug($kelas) }}">
                    <div class="subject-section mb-4">
                        @foreach ($statusGroup as $status => $daftarCatatan)
                            <div class="kelas-section mb-3">
                                <h6 class="text-secondary">{{ $status }}</h6>

                                <ul class="list-group">
                                    @foreach ($daftarCatatan as $catatan)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $catatan->siswa->nama }}</strong>
                                                <br>
                                                {{ $catatan->jenis_pelanggaran }}
                                                <br>
                                                <small class="text-muted">
                                                    Kejadian: {{ \Carbon\Carbon::parse($catatan->tanggal_kejadian)->translatedFormat('d M Y') }}
                                                </small>
                                            </div>
                                            <a href="{{ route('catatan.show', $catatan->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                                Detail
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <a href="{{ route('catatan.create') }}" class="fab">
        <i class="bi bi-plus-lg text-white"></i>
    </a>
@endsection
@section('nav')

    <nav class="nav bottom-nav fixed-bottom d-flex justify-content-between bg-light">
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.presensi')}}">
            <i class="bi bi-journal-check"></i>
            Presensi
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.nilai')}}">
            <i class="bi bi-award-fill"></i>
            Nilai
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.dashboard')}}">
            <i class="bi bi-house-door"></i>
            Beranda
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.siswa')}}">
            <i class="bi bi-people"></i>
            Siswa
        </a>
        <a class="nav-link text-center flex-fill text-success" href="#">
            <i class="bi bi-list-stars"></i>
            Catatan
        </a>
    </nav>
@endsection
