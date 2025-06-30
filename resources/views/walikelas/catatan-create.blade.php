@extends('layout')
@section('header')
    <header class="top-header d-flex justify-content-between align-items-center text-white">
        <a href="{{ Route('catatan.wali')}}" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
        <h5 class="mb-0 flex-grow-1 text-center">Input Catatan</h5>
    </header>
@endsection
@section('content')
<form action="{{ route('catatan.store') }}" method="POST">
    @csrf

    <section class="assessment-details">
        <div class="row">
            <div class="col-6">
                <label for="tanggal_kejadian" class="form-label info-label">Tanggal Kejadian</label>
                <input type="date" name="tanggal_kejadian" class="form-control info-value" id="tanggal_kejadian" required>
            </div>
            <div class="col-6">
                <label for="jenis_pelanggaran" class="form-label info-label">Jenis Pelanggaran</label>
                <input type="text" name="jenis_pelanggaran" class="form-control info-value" id="jenis_pelanggaran" placeholder="Misal: Terlambat, Tidak Membawa Buku" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <label for="kelas_id" class="form-label info-label">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-select" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="status_penanganan" class="form-label info-label">Status Penanganan</label>
                <select name="status_penanganan" id="status_penanganan" class="form-select" required>
                    <option value="Ditangani Wali Kelas">Ditangani Wali Kelas</option>
                    <option value="Dilimpahkan ke BK">Dilimpahkan ke BK</option>
                </select>
            </div>
        </div>
    </section>

    <div class="table-responsive table-container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 40%;" class="text-center">Nama Siswa</th>
                    <th style="width: 55%;" class="text-center">Deskripsi Pelanggaran</th>
                </tr>
            </thead>
            <tbody id="siswa-table-body">
                <tr><td colspan="3" class="text-center text-muted">Silakan pilih kelas terlebih dahulu</td></tr>
            </tbody>
        </table>
    </div>

    <footer class="footer-actions mt-4">
        <div class="row g-2">
            <div class="col">
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
                tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Tidak ada siswa</td></tr>';
                return;
            }

            data.forEach((siswa, index) => {
                const checkboxId = `checkbox-${siswa.id}`;
                const deskripsiId = `deskripsi-${siswa.id}`;

                tbody.innerHTML += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-start">
                            <div class="form-check">
                                <input class="form-check-input siswa-check" type="checkbox" id="${checkboxId}" value="${siswa.id}" name="siswa_id[]">
                                <label class="form-check-label" for="${checkboxId}">
                                    ${siswa.nama_lengkap}
                                </label>
                            </div>
                        </td>
                        <td class="text-center">
                            <textarea name="deskripsi_pelanggaran[${siswa.id}]" id="${deskripsiId}" class="form-control" rows="2" disabled></textarea>
                        </td>
                    </tr>
                `;
            });

            // Pindahkan ke luar dari loop agar dipasang setelah DOM selesai
            setTimeout(() => {
                document.querySelectorAll('.siswa-check').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const textarea = document.getElementById(`deskripsi-${this.value}`);
                        textarea.disabled = !this.checked;
                        if (!this.checked) textarea.value = '';
                    });
                });
            }, 100);

        });
});
</script>
@endpush
