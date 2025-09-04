@extends('layouts.app')

@section('content')

<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-9 d-flex justify-content-center align-items-center">
            <div class="card w-50 ">
                <div class="card-header text-center">
                    <img src="/image/umuka.png" alt="Logo" width="50">
                    <h5 style='font-weight:700;'>CBT UMUKA</h5>
                </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                               name="username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required>
                        @error('password')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
