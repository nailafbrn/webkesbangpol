{{-- @extends('adminlte::auth.passwords.confirm') --}}
@extends('auth.auth-page')

@section('auth_body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom-confirm-card shadow rounded-4">
                <div class="card-header text-center fw-bold text-white">
                    {{ __('Konfirmasi Password') }}
                </div>

                <div class="card-body">
                    <p class="text-muted text-center mb-4">
                        {{ __('Sebelum melanjutkan, silakan konfirmasi password Anda.') }}
                    </p>

                    @if ($errors->has('password'))
                        <div class="alert alert-danger text-center">
                            {{ $errors->first('password') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control custom-input @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" autofocus>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary custom-btn">
                                {{ __('Konfirmasi Password') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('password.request') }}" class="custom-link">
                            {{ __('Lupa password?') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container{
        margin-top: 1rem;
        padding: 3rem 1rem;
    }
    /* Header gradient dan desain seragam */
    .custom-confirm-card .card-header {
        background: linear-gradient(45deg, #B40D14, #D81B60);
        border-radius: 0.75rem 0.75rem 0 0;
        font-size: 1.3rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
    }

    /* Card shadow halus */
    .custom-confirm-card {
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Input styling */
    .custom-confirm-card .custom-input {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        transition: box-shadow 0.2s ease-in-out, border-color 0.2s;
    }

    .custom-confirm-card .custom-input:focus {
        border-color: #B40D14;
        box-shadow: 0 0 0 0.2rem rgba(180, 13, 20, 0.2);
    }

    /* Tombol submit styling */
    .custom-confirm-card .custom-btn {
        border-radius: 0.5rem;
        background: #B40D14;
        border: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .custom-confirm-card .custom-btn:hover {
        background: #8c0c12;
    }

    /* Link styling */
    .custom-link {
        color: #B40D14;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .custom-link:hover {
        color: #8c0c12;
        text-decoration: underline;
    }

    /* Tambahkan transisi lembut */
    .custom-confirm-card .card-body,
    .custom-confirm-card .card-header {
        transition: all 0.3s ease;
    }
</style>
@endsection
