@extends('layout')
@section('header')
    <div class="main-wrapper">
        <header class="top-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <!-- Kiri: Tulisan Siswa -->
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Siswa</h5>
            </div>

            <!-- Kanan: Ikon Search -->
            <div class="d-flex align-items-center">
                <a href="#" class="text-decoration-none"><i class="bi bi-search fs-5"></i></a>
            </div>
        </header>
@endsection
@section('content')
        <div class="class-filter-bar mb-3">
            <div class="class-tabs-container d-flex gap-2">
                @foreach ($kelasDenganSiswa as $kelas)
                    <a href="#" class="class-tab btn btn-outline-primary"
                    data-kelas-id="kelas-{{ $kelas->id }}">{{ $kelas->nama_kelas }}</a>
                @endforeach
            </div>
        </div>

        <main class="student-list bg-white">
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
        </main>

    </div>
@endsection
@section('nav')
    <nav class="nav bottom-nav fixed-bottom d-flex justify-content-between bg-light">
        <a class="nav-link text-center flex-fill" href="{{ Route('wali_kelas.dashboard')}}">
            <i class="bi bi-house-door-fill"></i><br>
            Beranda
        </a>
        <a class="nav-link text-center flex-fill" href="#">
            <i class="bi bi-journal-check"></i><br>
            Presensi
        </a>
        <a class="nav-link text-center flex-fill" href="#">
            <i class="bi bi-award"></i><br>
            Nilai
        </a>
        <a class="nav-link text-center flex-fill active" href="#">
            <i class="bi bi-people"></i><br>
            Siswa
        </a>
    </nav>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.class-tab');
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
                document.querySelector(`[data-kelas-id="${kelasId}"]`).classList.add('active');
            }

            // Event listener
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
