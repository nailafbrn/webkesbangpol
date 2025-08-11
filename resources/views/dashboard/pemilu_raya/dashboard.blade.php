@extends('dashboard.layouts.app') {{-- Sesuaikan dengan layout utama admin Anda --}}

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-red text-white shadow-lg border-0">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-1 font-weight-bold">
                                <i class="fas fa-vote-yea mr-2"></i>
                                Dashboard Pemilu Raya
                            </h2>
                            <p class="mb-0 opacity-75">
                                Sistem Manajemen Pemilihan Umum Terpadu
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="badge badge-light badge-pill px-3 py-2">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ date('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Management Cards --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h4 class="text-dark font-weight-bold">
                <i class="fas fa-cogs mr-2"></i>
                Manajemen Sistem
            </h4>
            <hr class="bg-danger" style="height: 3px;">
        </div>
    </div>

    <div class="row">
        {{-- KARTU 1: MANAJEMEN PILPRES --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card">
                <div class="card-header bg-gradient-red text-white text-center py-3">
                    <i class="fas fa-flag-usa fa-3x mb-2"></i>
                    <h5 class="card-title mb-0 font-weight-bold">Manajemen Pilpres</h5>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <p class="card-text flex-grow-1 text-muted">
                        Kelola data pasangan calon Presiden dan Wakil Presiden untuk pemilihan umum.
                    </p>
                    <div class="mt-auto">
            
                        {{-- Link ini akan mengarah ke daftar paslon pilpres --}}
                        <a href="{{ route('admin.pemilu.pilpres.index') }}" class="btn btn-danger btn-lg btn-block shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU 2: MANAJEMEN WALIKOTA --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card">
                <div class="card-header bg-gradient-red text-white text-center py-3">
                    <i class="fas fa-flag-usa fa-3x mb-2"></i>
                    <h5 class="card-title mb-0 font-weight-bold">Manajemen Walikota</h5>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <p class="card-text flex-grow-1 text-muted">
                        Kelola data pasangan calon Wali Kota dan Wakil Wali Kota untuk pemilihan daerah.
                    </p>
                    <div class="mt-auto">
            
                        {{-- Link ini akan mengarah ke daftar paslon walikota --}}
                        <a href="{{ route('admin.pemilu.walikota.index') }}" class="btn btn-danger btn-lg btn-block shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU 3: MANAJEMEN DPRD --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card">
                <div class="card-header bg-gradient-red text-white text-center py-3">
                    <i class="fas fa-flag-usa fa-3x mb-2"></i>
                    <h5 class="card-title mb-0 font-weight-bold">Manajemen DPRD</h5>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <p class="card-text flex-grow-1 text-muted">
                        Kelola data pasangan calon DPRD untuk pemilihan daerah.
                    </p>
                    <div class="mt-auto">
            
                        {{-- Link ini akan mengarah ke daftar paslon legistlatif --}}
                        <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-danger btn-lg btn-block shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>


</div>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.bg-gradient-red {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}


.opacity-75 {
    opacity: 0.75;
}

.card-header {
    border: none;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.shadow-lg {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>
@endsection