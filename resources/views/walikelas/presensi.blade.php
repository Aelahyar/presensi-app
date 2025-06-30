@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white">Presensi</h5>
        <div class="header-actions d-flex align-items-center gap-3">
            <a href="{{ route('wali_kelas.rekap') }}">
                <i class="bi bi-file-earmark-arrow-down text-white"></i></a>
        </div>
    </header>
@endsection
@section('content')
    <nav class="subject-tabs mb-3">
        <ul class="nav nav-pills">
            @foreach ($jadwalHariIni as $mapel => $jadwalList)
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

            <input type="hidden" id="lokasi">
            @foreach ($jadwalHariIni as $mapel => $jadwalList)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ Str::slug($mapel) }}">
                    <div class="subject-section mb-4">
                        <div class="kelas-section mb-3">
                        @foreach ($jadwalList as $jadwal)
                            <div class="mb-2">
                                <h6 class="text-secondary">
                                    {{ $jadwal->kelas->nama_kelas }} ({{ $jadwal->kelas->siswa->count() }} siswa)
                                </h6>

                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center clickable-jadwal"
                                        data-lat="{{ $jadwal->lokasiPresensi->koordinat_lat }}"
                                        data-lon="{{ $jadwal->lokasiPresensi->koordinat_lon }}"
                                        data-target-url="{{ route('wali_kelas.show', $jadwal->id) }}"
                                        style="cursor: pointer;"
                                    >
                                        <div>
                                            <strong>{{ $mapel }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                                - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </small>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                        </div>
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
        <a class="nav-link text-center flex-fill text-success" href="#">
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
        <a class="nav-link text-center flex-fill" href="{{ Route('catatan.wali')}}">
            <i class="bi bi-list-stars"></i>
            Catatan
        </a>
    </nav>
@endsection
@push('scripts')
<script>
        var lokasi = document.getElementById('lokasi');
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(pcc){
            lokasi.value = pcc.coords.latitude + "," + pcc.coords.longitude;
        }

        function errorCallback(){
        }

        document.querySelectorAll('.clickable-jadwal').forEach(item => {
            item.addEventListener('click', function () {
                const url = this.getAttribute('data-target-url');
                // Validasi lokasi jika diperlukan di sini
                window.location.href = url;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-cek-lokasi');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const targetLat = parseFloat(this.dataset.lat);
                const targetLon = parseFloat(this.dataset.lon);
                const targetUrl = this.dataset.targetUrl;

                if (!navigator.geolocation) {
                    alert('Geolocation tidak didukung browser ini.');
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLon = position.coords.longitude;

                        const distance = hitungJarak(userLat, userLon, targetLat, targetLon);
                        if (distance <= 100) {
                            window.location.href = targetUrl;
                        } else {
                            alert('Anda berada di luar jangkauan lokasi presensi.');
                        }
                    },
                    () => {
                        alert('Gagal mengambil lokasi. Pastikan GPS aktif.');
                    }
                );
            });
        });

        // Haversine formula
        function hitungJarak(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // meters
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                    Math.cos(φ1) * Math.cos(φ2) *
                    Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const d = R * c;
            return d; // in meters
        }
    });
</script>

@endpush
