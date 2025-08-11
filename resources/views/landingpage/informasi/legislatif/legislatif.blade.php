@extends('landingpage.layouts.app')
@section('title', 'Pemilihan Legislatif')

@section('content')
<style>
    .hero-legislatif {
        padding: 4rem 0;
        background: linear-gradient(135deg, #B40D14 0%, #8B0000 100%);
        color: white;
        text-align: center;
    }
    .dapil-section {
        margin-bottom: 3rem;
    }
    .dapil-title {
        font-weight: 700;
        color: #2c3e50;
        border-bottom: 3px solid #B40D14;
        padding-bottom: 0.5rem;
        margin-bottom: 2rem;
    }
    .caleg-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
    }
    .caleg-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .caleg-card .card-img-top {
        height: 200px;
        object-fit: cover;
        object-position: top;
    }
    .caleg-card .card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .caleg-partai {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .caleg-nama {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    .caleg-no-urut {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0,0,0,0.6);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        border: 2px solid white;
    }
</style>

<section class="hero-legislatif">
    <div class="container">
        <h1 class="display-5 fw-bold">{{ $judulHalaman ?? 'Pemilihan Legislatif' }}</h1>
        <p class="lead">Daftar Calon Anggota Legislatif DPRD Kota Bandung</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        @if($groupedLegislatifs->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">Data Calon Legislatif Belum Tersedia</h3>
                <p>Silakan periksa kembali nanti.</p>
            </div>
        @else
            @foreach($groupedLegislatifs as $dapil => $calegsInDapil)
                <div class="dapil-section">
                    <h2 class="dapil-title">Daerah Pemilihan {{ $dapil }}</h2>
                    <div class="row g-4">
                        @foreach($calegsInDapil as $caleg)
                            <div class="col-md-6 col-lg-3">
                                <a href="{{ route('pemilu.detail', ['kategori' => 'legislatif', 'id' => $caleg->id]) }}" class="text-decoration-none">
                                    <div class="caleg-card">
                                        <div class="position-relative">
                                            <img src="{{ asset('images/legislatif/' . $caleg->foto_profile) }}" 
                                                 class="card-img-top" 
                                                 alt="Foto {{ $caleg->nama_lengkap }}"
                                                 onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=Foto';">
                                            <div class="caleg-no-urut">{{ $caleg->no_urut }}</div>
                                        </div>
                                        <div class="card-body">
                                            <p class="caleg-partai">{{ $caleg->nama_partai }}</p>
                                            <h5 class="caleg-nama">{{ $caleg->nama_lengkap }}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('pemilu.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Menu Pemilu
            </a>
        </div>
    </div>
</section>
@endsection
