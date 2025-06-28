@extends('layout')
@section('header')
        <header class="top-header d-flex align-items-center gap-3  text-white">
        <!-- Ganti # dengan URL yang sesuai dari Laravel Anda -->
        <a href="{{ Route('wali_kelas.presensi')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Presensi Siswa</h5>
    </header>
@endsection

@section('content')
    {{-- <div class="container"> --}}
    <section class="assessment-details">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h6 class="title mb-1">Presensi Kelas {{ $jadwal->kelas->nama_kelas }}</h6>
                <p class="date-info mb-0">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p class="info-label">Mapel</p>
                <p class="info-value">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
            </div>
            <div class="col-6">
                <p class="info-label">Lokasi</p>
                <p class="info-value">{{ $jadwal->lokasiPresensi->nama_lokasi ?? '-' }}</p>
            </div>
        </div>
    </section>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('wali_kelas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
            <div class="assessment-details">
                <div class="mb-3">
                    <label for="materi" class="form-label">Materi</label>
                    <input type="text" name="materi" id="materi" class="form-control" required  value="{{ old('materi', $materi ?? '') }}">
                </div>
                <div class="table-responsive table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="width: 60%;">Nama Siswa</th>
                                <th style="width: 30%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal->kelas->siswa as $siswa)
                                @php
                                    $presensi = $presensiHariIni[$siswa->id] ?? null;
                                @endphp
                                <tr>
                                    <td class="text-center"><small class="text-muted d-block">{{ $loop->iteration }}</small></td>
                                    <td class="text-start">{{ $siswa->nama_lengkap }}</td>
                                    <td class="text-center">
                                        <select name="presensi[{{ $siswa->id }}]" class="form-control" required>
                                            <option value="">-- Pilih Status --</option>
                                            @foreach (['Hadir', 'Izin', 'Sakit', 'Alpa', 'Telat', 'Bolos'] as $status)
                                                <option value="{{ $status }}" {{ ($presensi && $presensi->status_presensi === $status) ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row g-2">
                        <div class="col">
                        <button type="submit" class="btn w-100 py-2 btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection
@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.presensi-form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung!');
                return;
            }

            navigator.geolocation.getCurrentPosition(position => {
                form.querySelector('[name="latitude"]').value = position.coords.latitude;
                form.querySelector('[name="longitude"]').value = position.coords.longitude;
                form.submit();
            }, () => {
                alert('Gagal mendapatkan lokasi!');
            });
        });
    });
});
</script>
@endpush
