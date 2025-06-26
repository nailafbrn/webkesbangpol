@extends('auth.auth-page')

@section('title', 'Login')
    <link rel="stylesheet" href="{{ asset('assets/css/login-form.css') }}">
@section('auth_body')

@php
    $loginUrl = route('login');
    $registerUrl = Route::has('register') ? route('register') : null;
    $passResetUrl = Route::has('password.request') ? route('password.request') : null;
@endphp

<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-card">
        {{-- Logo Kesbangpol --}}
        <div class="login-logo">
            <img src="{{ asset('images/component/logo1-2.png') }}" alt="Logo Kesbangpol" class="logo-img me-2">
            <h2 class="logo-text m-0">BAKESBANGPOL</h2>
        </div>
        <h3 class="text-center mb-0">Sign in to start your session</h3>
        <form action="{{ $loginUrl }}" method="POST" class="login-form">
            @csrf
            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password" required autocomplete="off">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-login w-100">

                <span class="btn-text">Sign In</span>
                <span class="btn-icon">
                    {{-- Inline SVG Icon --}}
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 17l5-5-5-5v10zM4 4h2v16H4V4z"/>
                    </svg>
                </span>
            </button>

            {{-- Forgot Password --}}
            @if($passResetUrl)
                <div class="text-center mt-3">
                    <a href="{{ $passResetUrl }}" class="link-secondary">Lupa password?</a>
                </div>
            @endif
            {{-- Register --}}
            @if($registerUrl)
                <div class="text-center mt-2">
                    <a href="{{ $registerUrl }}" class="link-secondary">Belum punya akun? Daftar</a>
                </div>
            @endif
        </form>
    </div>
</div>

@endsection
