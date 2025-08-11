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
    .filter-section {
        padding: 2rem 0;
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
    }
    .dapil-section {
        margin-bottom: 3rem;
        display: none; /* Sembunyikan semua secara default */
    }
    .dapil-section.active {
        display: block; /* Tampilkan yang aktif */
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
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
    }
    .caleg-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .caleg-card .card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .caleg-no-urut {
        background-color: #B40D14;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        align-self: center;
    }
    .caleg-partai {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .caleg-nama {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1rem;
        flex-grow: 1;
        text-align: center;
    }
    .caleg-nama a {
        text-decoration: none;
        color: inherit;
    }
    .caleg-nama a:hover {
        color: #B40D14;
    }
</style>

<section class="hero-legislatif">
    <div class="container">
        <h1 class="display-5 fw-bold">{{ $judulHalaman ?? 'Pemilihan Legislatif' }}</h1>
        <p class="lead">Daftar Calon Anggota Legislatif DPRD Kota Bandung</p>
    </div>
</section>

{{-- Filter Section --}}
<section class="filter-section sticky-top">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <label for="dapil-select" class="form-label fw-bold">Pilih Daerah Pemilihan (Dapil):</label>
                <select class="form-select" id="dapil-select" style="max-width: 250px; display: inline-block; width: auto;">
                    <option value="all" selected>Semua Dapil</option>
                    @for ($i = 1; $i <= 7; $i++)
                        <option value="{{ $i }}">Dapil {{ $i }}</option>
                    @endfor
                </select>
            </div>
            
            {{-- PERBAIKAN: Menambahkan route ke tombol --}}
            <div class="col-md-6 text-center text-md-end">
                <a href="{{ route('pemilu.legislatif.terpilih') }}" class="btn btn-success">
                    <i class="fas fa-award me-2"></i>Lihat Caleg Terpilih
                </a>
            </div>
        </div>
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
                <div class="dapil-section" data-dapil="{{ $dapil }}">
                    <h2 class="dapil-title">{{ $dapil }}</h2>
                    <div class="row g-4">
                        @foreach($calegsInDapil as $caleg)
                            <div class="col-md-6 col-lg-3">
                                <div class="caleg-card">
                                    <div class="card-body">
                                        <div class="caleg-no-urut">{{ $caleg->no_urut }}</div>
                                        <p class="caleg-partai">{{ $caleg->nama_partai }}</p>
                                        <h5 class="caleg-nama">
                                            <a href="{{ route('pemilu.detail', ['kategori' => 'legislatif', 'id' => $caleg->id]) }}">
                                                {{ $caleg->nama_lengkap }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
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

{{-- JavaScript untuk filter --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dapilSelect = document.getElementById('dapil-select');
    const dapilSections = document.querySelectorAll('.dapil-section');

    function filterDapil(filter) {
        dapilSections.forEach(section => {
            if (filter === 'all' || section.dataset.dapil.endsWith(filter)) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
    }

    // Tampilkan semua dapil saat pertama kali halaman dimuat
    filterDapil('all');

    // Tambahkan event listener untuk dropdown
    dapilSelect.addEventListener('change', function () {
        const filterValue = this.value;
        filterDapil(filterValue);
    });
});
</script>
@endsection
