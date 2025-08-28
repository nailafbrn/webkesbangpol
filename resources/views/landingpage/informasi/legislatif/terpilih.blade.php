<!-- @extends('landingpage.layouts.app')
@section('title', 'Calon Legislatif Terpilih')

@section('content')
{{-- Style ini bisa disalin dari halaman legislatif/show.blade.php --}}
<style>
    .hero-legislatif {
        padding: 4rem 0;
        /* Menggunakan warna hijau untuk membedakan halaman terpilih */
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        color: white;
        text-align: center;
    }
    .dapil-section {
        margin-bottom: 3rem;
    }
    .dapil-title {
        font-weight: 700;
        color: #2c3e50;
        border-bottom: 3px solid #28a745;
        padding-bottom: 0.5rem;
        margin-bottom: 2rem;
    }
    .caleg-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .caleg-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .caleg-card .card-body {
        padding: 1.25rem;
        text-align: center;
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
    }
    .caleg-nama a {
        text-decoration: none;
        color: inherit;
    }
    .caleg-nama a:hover {
        color: #28a745;
    }
</style>

<section class="hero-legislatif">
    <div class="container">
        <h1 class="display-5 fw-bold">{{ $judulHalaman }}</h1>
        <p class="lead">Anggota DPRD Kota Bandung Periode Terbaru</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        @if($groupedLegislatifs->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">Data Calon Legislatif Terpilih Belum Ditetapkan</h3>
                <p>Silakan periksa kembali nanti.</p>
            </div>
        @else
            @foreach($groupedLegislatifs as $dapil => $calegsInDapil)
                <div class="dapil-section">
                    <h2 class="dapil-title">Daerah Pemilihan {{ $dapil }}</h2>
                    <div class="row g-4">
                        @foreach($calegsInDapil as $caleg)
                            @if($caleg) {{-- Memastikan data caleg tidak null --}}
                            <div class="col-md-6 col-lg-3">
                                <div class="caleg-card">
                                    <div class="card-body">
                                        <p class="caleg-partai">{{ $caleg->nama_partai }}</p>
                                        <h5 class="caleg-nama">
                                            <a href="{{ route('pemilu.detail', ['kategori' => 'legislatif', 'id' => $caleg->id]) }}">
                                                {{ $caleg->nama_lengkap }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('pemilu.show', 'legislatif') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Semua Caleg
            </a>
        </div>
    </div>
</section>
@endsection -->
