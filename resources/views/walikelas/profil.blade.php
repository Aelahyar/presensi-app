@extends('layout')
@section('header')
    <div class="options-container">
        <div class="options-header">
            <a href="{{ Route('wali_kelas.option') }}" class="text-decoration-none back-icon">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h4>Profile</h4>
        </div>
@endsection

@section('content')
<div class="container">
    <br>
    <div class="text-center mb-2">
        <img src="{{ asset('assets/img/pap.jpg')}}" class="mb-1" width="120" alt="">
    </div>

    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Hapus dari DOM setelah animasi selesai
                }
            }, 3000); // 3 detik
        </script>
    @endif

    <form action="{{ route('wali_kelas.profil.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control">
            @error('username') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn w-100 py-2 btn-success mb-3">Simpan</button>
    </form>


</div>
@endsection
@push('scripts')
    <script>
        setTimeout(function () {
            $('#success-alert').fadeOut('slow', function () {
                $(this).remove();
            });
        }, 3000);
    </script>

@endpush
