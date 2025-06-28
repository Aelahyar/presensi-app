@extends('layout')
@section('header')
    <header class="top-header d-flex align-items-center gap-3  text-white">
        <!-- Ganti # dengan URL yang sesuai dari Laravel Anda -->
        <a href="{{ Route('wali_kelas.nilai')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Update Nilai</h5>
    </header>
@endsection
@section('content')
<form action="{{ route('nilai.updateGroup') }}" method="POST">
    @csrf
    @method('PUT')
        <input type="hidden" name="jenis_nilai" class="form-control info-value" value="{{ $dataNilai->first()->jenis_nilai }}">
        <input type="hidden" name="mapel_id" class="form-control info-value" value="{{ $dataNilai->first()->mapel_id }}">
        <input type="hidden" name="kelas_id" class="form-control info-value" value="{{ $dataNilai->first()->siswa->kelas_id }}">


        <div class="table-responsive table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 55%;" class="text-center">Nama Siswa</th>
                        <th style="width: 25%;" class="text-center">Nilai</th>
                        <th style="width: 10%;" class="text-center">Predikat</th>
                    </tr>
                </thead>
                <tbody id="siswa-table-body">

            @foreach ($dataNilai as $index => $nilai)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-start">{{ $nilai->siswa->nama_lengkap }}</td>
                    <td class="grade-zero text-center">
                        <div class="d-flex justify-content-center">
                            <input type="number" name="nilai[{{ $nilai->id }}]" class="form-control grade-input" value="{{ (int) $nilai->nilai }}">
                        </div>
                    </td>
                    <td class="text-center">
                        <input type="text" name="keterangan[{{ $nilai->id }}]" class="form-control" value="{{ $nilai->keterangan }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <footer class="footer-actions">
        <div class="row g-2">
            <div class="col">
            <button type="submit" class="btn w-100 py-2 btn-success">Simpan</button>
            </div>
        </div>
    </footer>
</form>
@endsection
@push('scripts')
    <script>
    document.querySelectorAll('input[name^="nilai["]').forEach(function (input) {
        input.dispatchEvent(new Event('input'));
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[name^="nilai["]').forEach(function (nilaiInput) {
                nilaiInput.addEventListener('input', function () {
                    const nilai = parseFloat(this.value);
                    const id = this.name.match(/\d+/)[0]; // Ambil ID dari nama input
                    const predikatInput = document.querySelector(`input[name="keterangan[${id}]"]`);
                    let predikat = 'E';

                    if (!isNaN(nilai)) {
                        if (nilai >= 90) predikat = 'A';
                        else if (nilai >= 70) predikat = 'B';
                        else if (nilai >= 50) predikat = 'C';
                        else if (nilai >= 30) predikat = 'D';
                    }

                    predikatInput.value = predikat;
                });
            });
        });
    </script>
@endpush
