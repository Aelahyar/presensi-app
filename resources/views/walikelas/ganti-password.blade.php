@extends('layout')
@section('header')
    <div class="options-container">
        <div class="options-header">
            <a href="{{ Route('wali_kelas.option') }}" class="text-decoration-none back-icon">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h4>Update Password</h4>
        </div>
@endsection
@section('content')
<div class="container">
    <br>
    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        </script>
    @endif

    <form action="{{ route('wali_kelas.password.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="password_lama" class="form-label">Password Lama</label>
            <input type="text" name="password_lama" class="form-control">
            @error('password_lama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password_baru" class="form-label">Password Baru</label>
            <div class="input-group">
                <input type="password" name="password_baru" class="form-control" id="passwordBaru">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('passwordBaru')">
                    {{-- <i class="fa fa-eye" id="icon-passwordBaru"></i> --}}
                    <i class="bi bi-eye-slash" id="icon-passwordBaru"></i>
                </button>
            </div>
            @error('password_baru') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password_baru_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" name="password_baru_confirmation" class="form-control" id="passwordBaruKonfirmasi">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('passwordBaruKonfirmasi')">
                    {{-- <i class="fa fa-eye" id="icon-passwordBaruKonfirmasi"></i> --}}
                    <i class="bi bi-eye-slash" id="icon-passwordBaruKonfirmasi"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn w-100 py-2 btn-success mb-3">Simpan Password Baru</button>
    </form>

</div>
@endsection
@push('scripts')
    <script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    </script>
@endpush
