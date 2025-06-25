@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome, {{ optional(Auth::user()->profile)->nama_lengkap ?? Auth::user()->username }}!
                    You are logged in as Admin.
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
    @csrf
    <button type="submit" class="btn btn-danger">
        Keluar
    </button>
</form>

</div>
@endsection
