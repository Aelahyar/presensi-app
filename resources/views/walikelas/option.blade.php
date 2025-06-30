@extends('layout')
@section('header')
    <div class="options-container">
        <div class="options-header">
            <a href="{{ Route('wali_kelas.dashboard') }}" class="text-decoration-none back-icon">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h4>Options</h4>
        </div>
@endsection

@section('content')
        <div class="list-container">
            <div class="section-title">Accounts</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-person item-icon"></i>
                        <span>Edit Profile</span>
                    </div>
                    <a href="{{ Route('wali_kelas.profil')}}" class="text-decoration-none d-flex justify-content-between align-items-center">
                        <i class="bi bi-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-key item-icon"></i>
                        <span>Change Password</span>
                    </div>
                    <a href="{{ Route('wali_kelas.password.form')}}" class="text-decoration-none d-flex justify-content-between align-items-center">
                    <i class="bi bi-chevron-right chevron-icon"></i>
                    </a>
                </li>
            </ul>

            {{-- <div class="section-title">Settings</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-send item-icon"></i>
                        <span>Notices</span>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-translate item-icon"></i>
                        <span>Language</span>
                    </div>
                    <i class="bi bi-chevron-right chevron-icon"></i>
                </li>
            </ul>

            <div class="section-title">Connect social accounts</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-facebook item-icon"></i>
                        <span>Facebook</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchFacebook" checked>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-twitter item-icon"></i>
                        <span>Twitter</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchTwitter" checked>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-instagram item-icon"></i>
                        <span>Instagram</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchInstagram">
                    </div>
                </li>
                    <li class="list-group-item">
                    <div class="item-content">
                        <i class="bi bi-google item-icon"></i>
                        <span>Google</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchGoogle">
                    </div>
                </li>
            </ul> --}}

            <div class="logout-link">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log out current account</button>
                </form>

            </div>
        </div>
    </div>
@endsection

