@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-center align-items-center">
        <h5 class="mb-0 text-white text-center">Nilai</h5>
    </header>
@endsection
@section('content')
    <nav class="subject-tabs mb-3">
        <ul class="nav nav-pills">
            @foreach ($nilaiRingkas as $mapel => $nilaiGroup)
                <li class="nav-item" style="display: inline-block;">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-bs-toggle="tab"
                    href="#tab-{{ Str::slug($mapel) }}">
                        {{ $mapel }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <main class="grades-list">
        <div class="tab-content grades-list">
            @foreach ($nilaiRingkas as $mapel => $kelasGroup)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ Str::slug($mapel) }}">
                    <div class="subject-section mb-4">
                        @foreach ($kelasGroup as $kelas => $jenisGroup)
                            <div class="kelas-section mb-3">
                                <h6 class="text-secondary">{{ $kelas }}</h6>

                                <ul class="list-group">
                                    @foreach ($jenisGroup as $jenis => $dataNilai)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $jenis }}</strong> - {{ $dataNilai->count() }} siswa
                                                <br>
                                                <small class="text-muted">
                                                    Tanggal {{ \Carbon\Carbon::parse($dataNilai->first()->tanggal_input)->translatedFormat('d M Y') }}
                                                </small>
                                            </div>
                                            <a href="{{ route('wali_kelas.detail', ['mapel' => $dataNilai->first()->mapel_id, 'kelas' => $dataNilai->first()->siswa->kelas_id, 'jenis' => $jenis]) }}"
                                            class="btn btn-outline-success">
                                                Lihat Detail
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

    <a href="{{ Route('wali_kelas.tambah')}}" class="fab">
        <i class="bi bi-plus-lg text-white"></i>
    </a>
@endsection
@section('nav')
    <nav class="nav bottom-nav fixed-bottom d-flex justify-content-between bg-light">
        <a class="nav-link text-center flex-fill" href="{{ Route('guru.presensi')}}">
            <i class="bi bi-journal-check"></i>
            Presensi
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('guru.dashboard')}}">
            <i class="bi bi-house-door"></i>
            Beranda
        </a>
        <a class="nav-link text-center flex-fill text-success" href="#">
            <i class="bi bi-award-fill"></i>
            Nilai
        </a>
    </nav>
@endsection
@push('scripts')

@endpush
