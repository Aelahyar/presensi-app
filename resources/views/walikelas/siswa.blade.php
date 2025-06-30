@extends('layout')
@section('header')
        <header class="top-header d-flex justify-content-between align-items-center">
            <!-- Kiri: Tulisan Siswa -->
            <h5 class="mb-0 text-white">Siswa</h5>
            <!-- Kanan: Ikon Search -->
            <div class="header-actions d-flex align-items-center gap-3">
                <a href="#"><i class="bi bi-search fs-5 text-white"></i></a>
            </div>
        </header>
@endsection
@section('content')
        <nav class="subject-tabs">
            <ul class="nav nav-pills">
                @foreach ($kelasDenganSiswa as $kelas)
                    <li class="nav-item" style="display: inline-block;">
                        <a class="nav-link kelas-tab"
                            data-bs-toggle="tab"
                            data-kelas-id="kelas-{{ $kelas->id }}"
                            href="#"
                        >
                            {{ $kelas->nama_kelas }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>


        {{-- <main class="student-list grades-list"> --}}
            <div class="tab-content grades-list">
            @foreach ($kelasDenganSiswa as $kelas)
                <div class="kelas-siswa-group" id="kelas-{{ $kelas->id }}" style="display: none;">
                    <ul class="list-group list-group-flush">
                        @foreach ($kelas->siswa as $siswa)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar"><i class="bi bi-person"></i></div>
                                    <div class="student-info">
                                        <p class="student-name mb-0">{{ $siswa->nama_lengkap }}</p>
                                        <p class="student-nis text-muted mb-0">{{ $siswa->nisn }}</p>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        {{-- </main> --}}
@endsection
@section('nav')
    <nav class="nav bottom-nav fixed-bottom d-flex justify-content-between bg-light">
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.presensi')}}">
            <i class="bi bi-journal-check"></i>
            Presensi
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.nilai')}}">
            <i class="bi bi-award"></i>
            Nilai
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.dashboard')}}">
            <i class="bi bi-house-door-fill"></i>
            Beranda
        </a>
        <a class="nav-link text-center flex-fill  text-success" href="#">
            <i class="bi bi-people"></i>
            Siswa
        </a>
        <a class="nav-link text-center flex-fill" href="{{ Route('catatan.wali')}}">
            <i class="bi bi-list-stars"></i>
            Catatan
        </a>
    </nav>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.kelas-tab'); // hanya tab kelas
        const kelasGroups = document.querySelectorAll('.kelas-siswa-group');

        function showKelas(kelasId) {
            // Sembunyikan semua
            kelasGroups.forEach(group => group.style.display = 'none');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Tampilkan yang sesuai
            const selectedGroup = document.getElementById(kelasId);
            if (selectedGroup) {
                selectedGroup.style.display = 'block';
            }

            // Aktifkan tab yang diklik
            const selectedTab = document.querySelector(`[data-kelas-id="${kelasId}"]`);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        }

        // Event listener untuk tab kelas saja
        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                const kelasId = this.getAttribute('data-kelas-id');
                showKelas(kelasId);
            });
        });

        // Tampilkan kelas pertama secara default
        if (tabs.length > 0) {
            showKelas(tabs[0].getAttribute('data-kelas-id'));
        }
    });

</script>

@endpush
