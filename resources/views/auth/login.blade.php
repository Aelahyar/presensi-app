@extends('auth.layoutlog')

@section('content')
   <div class="mobile-container">

        <div class="decorative-circle top"></div>
        <div class="decorative-circle bottom"></div>

        <div class="text-center text-black mb-3 z-10">
            <img src="{{ asset('assets/img/logo.png')}}" class="mb-1" width="120" alt="">
            <h1 id="header-title" class="display-6 fw-bold">MA MINAT</h1>
            <p id="header-subtitle" class="text-black-75 mt-2">Mobile App E-Presensi</p>
        </div>

        <div class="w-100" style="max-width: 320px; margin: 0 auto;">

            <!-- Konten Form -->
            <div class="tab-content" id="myTabContent">
                <!-- Login Pane -->
                <div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                    <div class="card form-card border-0 shadow-sm p-4 pt-5">
                        <div class="text-center mb-4 z-10">
                            <h1 id="header-title" class="display-6 fw-bold">Welcome back!</h1>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <!-- <input type="email" class="form-control" placeholder="Email Address"> -->
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="User Name" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password" placeholder="Password">

                                <button class="btn btn-outline-secondary border-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="iconToggle"></i>
                                </button>

                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-cyan w-100 fw-semibold py-2">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
