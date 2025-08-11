@extends('landingpage.layouts.app')

@push('styles')
<style>
    .candidate-card {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .candidate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .candidate-card .card-header {
        background: linear-gradient(90deg, #B40D14, #8B0000);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .photo-container {
        display: flex;
        height: 250px;
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        flex-shrink: 0;
    }

    .candidate-card .card-body {
        flex-grow: 1;
    }

    .btn-detail {
        background-color: #B40D14;
        color: #fff;
        border: none;
    }

    /* Tambahan untuk perbaikan ukuran foto */
    .foto-kandidat {
        object-fit: cover;
        object-position: top;
        height: 100%;
        display: block;
    }

    .foto-kandidat-full {
        width: 100%;
    }

    .foto-kandidat-half {
        width: 50%;
    }

    .foto-kandidat-half:first-child {
        border-right: 1px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row text-center mb-5">
        <div class="col">
            <h2 class="display-5 fw-bold text-uppercase" style="color: #B40D14;">{{ $judulHalaman ?? 'Data Pemilu' }}</h2>
            <p class="lead text-muted">
                Tahun {{ $tahunPemilu ?? 'Tidak Diketahui' }}
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

                <div class="photo-container">
                    @php
                        $foto1Url = null;
                        if ($paslon->capres_foto) {
                            $cleanedPath1 = str_replace('public/', '', $paslon->capres_foto);
                            if (file_exists(public_path($cleanedPath1))) {
                                $foto1Url = asset($cleanedPath1);
                            }
                        }

                        $foto2Url = null;
                        if ($paslon->cawapres_foto) {
                            $cleanedPath2 = str_replace('public/', '', $paslon->cawapres_foto);
                            if (file_exists(public_path($cleanedPath2))) {
                                $foto2Url = asset($cleanedPath2);
                            }
                        }
                    @endphp

                    @if ($foto1Url && $foto2Url)
                        {{-- Jika KEDUA foto ada, tampilkan berdampingan --}}
                        <img src="{{ $foto1Url }}" alt="Foto {{ $paslon->capres_nama }}" 
                             class="foto-kandidat foto-kandidat-half">
                        <img src="{{ $foto2Url }}" alt="Foto {{ $paslon->cawapres_nama }}"
                             class="foto-kandidat foto-kandidat-half">
                    @else
                        {{-- Jika hanya satu (atau tidak ada), tampilkan foto utama saja (atau placeholder) --}}
                        @php
                            $singlePhotoUrl = $foto1Url ?? $foto2Url ?? 'https://placehold.co/400x250/e2e8f0/e2e8f0?text=Foto';
                            $singlePhotoAlt = $foto1Url ? $paslon->capres_nama : ($foto2Url ? $paslon->cawapres_nama : 'Kandidat');
                        @endphp
                        <img src="{{ $singlePhotoUrl }}" alt="Foto {{ $singlePhotoAlt }}"
                             class="foto-kandidat foto-kandidat-full">
                    @endif
                </div>

                <div class="card-body text-center d-flex flex-column">
                    <div class="mt-auto">
                        <h5 class="fw-bold mb-1">{{ $paslon->capres_nama }}</h5>
                        @if($paslon->cawapres_nama)
                        <p class="text-muted mb-1">&</p>
                        <h5 class="fw-bold">{{ $paslon->cawapres_nama }}</h5>
                        @endif
                    </div>
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
                <p class="mb-0">Tidak ada data pasangan calon untuk kategori ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        {{-- PERBAIKAN: Mengarahkan tombol kembali ke route 'pemilu.index' --}}
        <a href="{{ route('pemilu.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
