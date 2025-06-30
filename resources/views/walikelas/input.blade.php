@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-between align-items-center text-white">
        <a href="{{ Route('wali_kelas.nilai')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Input Nilai</h5>
    </header>
@endsection
@section('content')
    <form action="{{ route('nilai-siswa.store') }}" method="POST">
    @csrf
        <section class="assessment-details">
            <div class="row">
                <div class="col-6">
                    <label for="jenis_nilai" class="form-label info-label">Nilai</label>
                    <input type="text" name="jenis_nilai" class="form-control info-value" id="jenis_nilai" placeholder="Nama Nilai" required>
                </div>
                <div class="col-6">
                    <label for="tanggal_input" class="form-label info-label">Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="tanggal_input" class="form-control info-value" id="tanggal_input"  onfocus="(this.type='date')" required>
                    </div>
                </div>
            </div>
                {{-- <a href="#" class="edit-icon"><i class="bi bi-pencil-fill"></i></a> --}}
            <div class="row">
                <div class="col-6">
                    <label for="mapel_id" class="form-label info-label">Mapel</label>
                    {{-- <input type="text" class="form-control info-value" id="mapel_id" placeholder="Mapel"> --}}
                    <select name="mapel_id" id="mapel_id" class="form-select" required>
                        <option value="">Pilih Mapel</option>
                        @foreach ($mapelList as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="kelas_id" class="form-label info-label">Kelas</label>
                    {{-- <input type="text" class="form-control info-value" id="kelas_id" placeholder="Kelas"> --}}
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

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
                    <tr><td colspan="5" class="text-center text-muted">Silakan pilih mapel dan kelas terlebih dahulu</td></tr>
                </tbody>
            </table>
        </div>
        <footer class="footer-actions">
            <div class="row g-2">
                {{-- <div class="col">
                    <button type="button" class="btn btn-secondary w-100 py-2">Remidial</button>
                </div> --}}
                <div class="col">
                    {{-- <button type="button" class="btn btn-accent-orange w-100 py-2">Simpan</button> --}}
                    <button type="submit" class="btn btn-accent-orange w-100 py-2">Simpan</button>
                </div>
            </div>
        </footer>
    </form>
@endsection
@push('scripts')
    <script>
    document.getElementById('kelas_id').addEventListener('change', function () {
        const kelasId = this.value;

        if (!kelasId) return;

        fetch(`/wali-kelas/get-siswa?kelas_id=${kelasId}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('siswa-table-body');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Tidak ada siswa</td></tr>';
                    return;
                }

                data.forEach((siswa, index) => {
                    const nilaiInputId = `nilai-${siswa.id}`;
                    const predikatInputId = `predikat-${siswa.id}`;

                    tbody.innerHTML += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-start">${siswa.nama_lengkap}</td>
                            <td class="text-center">
                                <input type="number" name="nilai[${siswa.id}]" id="${nilaiInputId}" class="form-control nilai-input" required>
                            </td>
                            <td class="text-center">
                                <input type="text" name="predikat[${siswa.id}]" id="${predikatInputId}" class="form-control" readonly>
                            </td>
                        </tr>
                    `;
                });

                // Pasang event listener untuk semua input nilai setelah siswa ditampilkan
                setTimeout(() => {
                    document.querySelectorAll('.nilai-input').forEach(input => {
                        input.addEventListener('input', function () {
                            const nilai = parseFloat(this.value);
                            const predikatInput = document.getElementById(this.id.replace('nilai', 'predikat'));
                            let predikat = '';

                            if (!isNaN(nilai)) {
                                if (nilai >= 90) predikat = 'A';
                                else if (nilai >= 70) predikat = 'B';
                                else if (nilai >= 50) predikat = 'C';
                                else if (nilai >= 30) predikat = 'D';
                                else predikat = 'E';
                            }

                            predikatInput.value = predikat;
                        });
                    });
                }, 100); // tunggu DOM selesai ditambahkan
            });
    });

</script>
@endpush
