@extends('auth.auth-page')

@section('auth_body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom-reset-card shadow rounded-4">
                <div class="card-header text-center fw-bold text-white">
                    {{ __('Reset Password') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted text-center mb-4">
                        {{ __('Masukkan email Anda untuk menerima link reset password.') }}
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email"
                                class="form-control custom-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary custom-btn">
                                {{ __('Kirim Link Reset Password') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" class="custom-link">
                            {{ __('Kembali ke login') }}
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
    /* Warna utama dan latar belakang header */
    .custom-reset-card .card-header {
        background: linear-gradient(45deg, #B40D14, #D81B60);
        border-radius: 0.75rem 0.75rem 0 0;
        font-size: 1.3rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
    }

    /* Tambahkan padding dan bayangan halus */
    .custom-reset-card {
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Input styling */
    .custom-reset-card .custom-input {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        transition: box-shadow 0.2s ease-in-out, border-color 0.2s;
    }

    .custom-reset-card .custom-input:focus {
        border-color: #B40D14;
        box-shadow: 0 0 0 0.2rem rgba(180, 13, 20, 0.2);
    }

    /* Tombol submit styling */
    .custom-reset-card .custom-btn {
        border-radius: 0.5rem;
        background: #B40D14;
        border: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .custom-reset-card .custom-btn:hover {
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

    /* Tambahkan sedikit transisi */
    .custom-reset-card .card-body,
    .custom-reset-card .card-header {
        transition: all 0.3s ease;
    }
</style>
@endsection
