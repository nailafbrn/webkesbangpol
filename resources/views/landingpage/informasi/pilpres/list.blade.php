@extends('landingpage.layouts.app')

@push('styles')
<style>
    .candidate-card {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
    }

    .candidate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .candidate-card .card-header {
        background: linear-gradient(90deg, #002147, #8b0000);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .candidate-card .card-img-top {
        height: 220px;
        object-fit: cover;
        object-position: top;
        border-bottom: 1px solid #dee2e6;
    }

    .candidate-card .card-body h5 {
        color: #002147;
    }

    .btn-detail {
        background-color: #002147;
        color: #fff;
        border: none;
        transition: background 0.3s ease;
    }

    .btn-detail:hover {
        background-color: #8b0000;
        color: #fff;
    }

    .btn-back {
        color: #002147;
        border-color: #002147;
    }

    .btn-back:hover {
        background-color: #002147;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row text-center mb-5">
        <div class="col">
            <h2 class="display-5 fw-bold text-uppercase text-primary">Data Pemilu {{ ucfirst($kategori) }}</h2>
            <p class="lead text-muted">
                Tahun {{ $paslons->first()->tahun_pemilu ?? 'Tidak Diketahui' }}
            </p>
        </div>
    </div>
    
    <div class="row justify-content-center">
        @forelse ($paslons as $paslon)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card candidate-card h-100">
                <div class="card-header text-center">
                    Nomor Urut <strong>{{ $paslon->no_urut }}</strong>
                </div>

                {{-- Gambar kandidat dengan fallback --}}
                <!-- @php
                    $fotoCapres = $paslon->capres_foto 
                        ? asset($paslon->capres_foto) 
                        : 'https://placehold.co/400x300/e2e8f0/e2e8f0?text=Foto+Tidak+Tersedia';
                @endphp -->

                <img src="{{ asset('images/pemilu/' . $paslon->capres_foto) }}" class="card-img-top" alt="Foto {{ $paslon->capres_nama }}">

                <div class="card-body text-center">
                    <h5 class="fw-bold mb-1">{{ $paslon->capres_nama }}</h5>
                    <p class="text-muted mb-1">&</p>
                    <h5 class="fw-bold">{{ $paslon->cawapres_nama ?? '-' }}</h5>
                </div>

                <div class="card-footer text-center bg-light">
                    <a href="{{ route('pemilu.detail', ['kategori' => $kategori, 'id' => $paslon->id]) }}" class="btn btn-detail w-100">
                        <i class="fas fa-search-plus me-1"></i> Lihat Detail Profil
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <div class="alert alert-warning">
                <p>Tidak ada data pasangan calon untuk kategori ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('pemilu.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Pilihan Pemilu
        </a>
    </div>
</div>
@endsection
