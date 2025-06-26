{{-- @extends('adminlte::auth.verify') --}}
@extends('auth.auth-page')


@section('title', 'Verifikasi Email')

@section('auth_header', 'Silakan Masuk')

@section('auth_body')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h4 class="mb-3 text-center">Verifikasi Alamat Email</h4>

                    @if(session('resent'))
                        <div class="alert alert-success" role="alert">
                            Link verifikasi baru telah dikirim ke email kamu.
                        </div>
                    @endif

                    <p class="mb-3">
                        Sebelum melanjutkan, silakan cek email kamu untuk link verifikasi.
                        Jika kamu tidak menerima email tersebut,
                        klik tombol di bawah untuk mengirim ulang.
                    </p>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
