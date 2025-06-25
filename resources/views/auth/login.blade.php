@extends('auth.layoutlog')

@section('content')
   <div class="mobile-container">

        <div class="decorative-circle top"></div>
        <div class="decorative-circle bottom"></div>

        <div class="text-center text-white mb-5 z-10">
            <h1 id="header-title" class="display-6 fw-bold">Welcome back!</h1>
            <p id="header-subtitle" class="text-white-75 mt-2">Lorem ipsum dolor sit amet, consectetur.</p>
        </div>

        <div class="w-100" style="max-width: 320px; margin: 0 auto;">

            <!-- Konten Form -->
            <div class="tab-content" id="myTabContent">
                <!-- Login Pane -->
                <div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                    <div class="card form-card border-0 shadow-sm p-4 pt-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text border-0"><i class="bi bi-envelope"></i></span>
                                <!-- <input type="email" class="form-control" placeholder="Email Address"> -->
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text border-0"><i class="bi bi-lock"></i></span>
                                <!-- <input type="password" class="form-control" placeholder="Password"> -->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group row mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                            </div>
                            <button type="submit" class="btn btn-cyan w-100 fw-semibold py-2">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
