@extends('auth.auth-page')

@section('title', 'Register')
    {{-- RECAPTCHA SCRIPT --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="{{ asset('assets/css/register-form.css') }}">

@section('auth_body')

@php
    $registerUrl = route('register');
    $loginUrl = Route::has('login') ? route('login') : null;
@endphp

<div class="register-wrapper d-flex align-items-center justify-content-center">
    <div class="register-card shadow">
        {{-- Logo Kesbangpol --}}
        <div class="register-logo">
            <img src="{{ asset('images/component/logo1-2.png') }}" alt="Logo Kesbangpol" class="logo-img me-2">
            <h2 class="logo-text m-0">BAKESBANGPOL</h2>
        </div>

        <h3 class="text-center mb-4">Register a new membership</h3>

        <form action="{{ $registerUrl }}" method="POST" class="register-form">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama Lengkap" required autofocus autocomplete="off">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="Email" required autocomplete="off">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password" required autocomplete="off">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="Konfirmasi Password" required autocomplete="off">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- RECAPTCHA --}}
            <div class="form-group mt-3">
                {!! NoCaptcha::display() !!}
                @if ($errors->has('g-recaptcha-response'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-register w-100">
                <span class="btn-text">Register</span>
                <span class="btn-icon">
                    <i class="fas fa-user-plus"></i>
                </span>
            </button>

            {{-- Login --}}
            @if($loginUrl)
                <div class="text-center mt-2">
                    <a href="{{ $loginUrl }}" class="link-secondary">Sudah punya akun? Login disini</a>
                </div>
            @endif

        </form>
    </div>
</div>

@endsection
