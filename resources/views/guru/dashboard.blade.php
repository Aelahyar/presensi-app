@extends('layout')

@section('header')
<header class="header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/img/pap.jpg') }}" alt="Foto Profil" class="profile-pic me-3">
            <div>
                <p>Selamat Datang,</p>
                <h5>{{ optional(Auth::user()->guru)->nama_lengkap ?? Auth::user()->username }}</h5>
            </div>
        </div>
        <a href="#" class="settings-icon">
            <i class="bi bi-gear"></i>
        </a>
    </div>
</header>
@endsection

@section('content')
<main class="container py-3">

    <div class="mb-4">
        <h6 class="fw-bold mb-3">Pelajaran Berlangsung</h6>
        @if ($jadwalBerlangsung->isEmpty())
            <div class="text-muted small mb-2">Tidak ada jadwal untuk saat ini.</div>
        @else
            @foreach ($jadwalBerlangsung as $kelasNama => $jadwals)
                @foreach ($jadwals as $jadwal)
                    <div class="card custom-card mb-2">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h6>
                                <p class="text-muted small mb-2">{{ $kelasNama }}</p>
                                <div>
                                    <span class="me-3 small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                    </span>
                                    <span class="small text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $jadwal->kelas->siswa->count() ?? 0 }} Siswa
                                    </span>
                                </div>
                            </div>
                            {{-- <a href="{{ route('guru.presensi', $jadwal->id) }}"> --}}
                                <i class="bi bi-chevron-right text-muted"></i>
                            {{-- </a> --}}
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif
    </div>

    <div>
        <h6 class="fw-bold mb-3">Jadwal Hari Ini</h6>
        <div class="card custom-card">
            <div class="list-group list-group-flush">
                @if ($mengajars->isEmpty())
                    <p class="mb-0 text-muted small">Tidak ada jadwal yang tersedia.</p>
                @else
                    @foreach ($mengajars as $kelasNama => $jadwals)
                        @foreach ($jadwals->sortBy('jam_mulai') as $jadwal)
                            <div class="list-group-item d-flex justify-content-between align-items-center schedule-item">
                                <div>
                                    <div class="fw-bold">{{ $jadwal->mataPelajaran->nama_mapel }}</div>
                                    <div class="schedule-time">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</div>
                                </div>
                                <div class="schedule-class">{{ $kelasNama }}</div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</main>
@endsection

@section('nav')
<nav class="nav bottom-nav fixed-bottom d-flex justify-content-between bg-light">
    <a class="nav-link text-center flex-fill" href="{{ route('guru.presensi')}}">
        <i class="bi bi-journal-check"></i>
        Presensi
    </a>
    <a class="nav-link text-center flex-fill text-success" href="#">
        <i class="bi bi-house-door-fill"></i>
        Beranda
    </a>
    <a class="nav-link text-center flex-fill" href="{{ route('guru.nilai')}}">
        <i class="bi bi-award"></i>
        Nilai
    </a>
</nav>
@endsection
