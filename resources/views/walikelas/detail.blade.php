@extends('layout')
@section('content')
    <header class="top-header d-flex justify-content-between align-items-center text-white">
        <a href="{{ Route('wali_kelas.nilai')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0">Detail Penilaian</h5>
        <form action="{{ route('nilai.destroyGroup') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua nilai ini?')">
            @csrf
            @method('DELETE')

            <input type="hidden" name="mapel_id" value="{{ $dataNilai->first()->mapel_id }}">
            <input type="hidden" name="kelas_id" value="{{ $dataNilai->first()->siswa->kelas_id }}">
            <input type="hidden" name="jenis_nilai" value="{{ $dataNilai->first()->jenis_nilai }}">

            <button type="submit" class="btn btn-sm text-danger delete-icon" style="background: none; border: none;">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </header>
    <section class="assessment-details">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h6 class="title mb-1">{{ $jenis_nilai }}</h6>
                <p class="date-info mb-0">{{ \Carbon\Carbon::parse($tanggal_input)->translatedFormat('d M Y') }}</p>
            </div>
            <a href="{{ route('nilai.editGroup', [
                    'mapel' => $dataNilai->first()->mapel_id,
                    'kelas' => $dataNilai->first()->siswa->kelas_id,
                    'jenis' => $dataNilai->first()->jenis_nilai
                ]) }}" class="edit-icon">
                    <i class="bi bi-pencil-fill"></i>
                </a>
        </div>
        <div class="row">
            <div class="col-6">
                <p class="info-label">Mapel</p>
                <p class="info-value">{{ $mapel }}</p>
            </div>
            <div class="col-6">
                <p class="info-label">Kelas</p>
                <p class="info-value">{{ $kelas }}</p>
            </div>
        </div>
    </section>

    <div class="table-responsive table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10%;">No</th>
                    <th style="width: 55%;">Siswa ({{ $dataNilai->count() }})</th>
                    <th style="width: 15%;">Nilai</th>
                    <th style="width: 15%;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataNilai as $index => $nilai)
                    <tr>
                        <td class="text-center"><small class="text-muted d-block">{{ $index + 1 }}</small></td>
                        <td>{{ $nilai->siswa->nama_lengkap }}</td>
                        <td class="grade-zero">{{ $nilai->nilai }}</td>
                        <td>{{ $nilai->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')

@endpush
