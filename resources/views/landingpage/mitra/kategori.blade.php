@extends('landingpage.layouts.app')
@section('title', 'Kategori: ' . ucwords(str_replace('-', ' ', strtolower($namaKategori))))

@section('content')
    <!-- Hero Section dengan Gradient Modern -->
    <section class="category-hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <h1 class="hero-title">FORKOPIMDA</h1>
                    <p class="hero-subtitle">Daftar Semua Mitra Dalam Kategori Ini</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Mitra Grid Section -->
    <section class="mitra-grid-section">
        <div class="container">
            <div class="mitra-grid" id="mitraGrid">
                @forelse ($mitras as $mitra)
                    <div class="mitra-card" data-name="{{ strtolower($mitra->nama_lembaga) }}">
                        <a href="{{ route('mitra.show.detail', $mitra->id) }}" class="card-link">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="logo-container">
                                        @if($mitra->logo_lembaga)
                                            <img src="{{ asset('images/mitras/logo/' . $mitra->logo_lembaga) }}" 
                                                 alt="Logo {{ $mitra->nama_lembaga }}" 
                                                 class="mitra-logo">
                                        @else
                                            <div class="logo-placeholder">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-badge">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="mitra-name">{{ $mitra->nama_lembaga }}</h3>
                                    <p class="mitra-leader">
                                        <i class="fas fa-user-tie"></i>
                                        {{ $mitra->ketua }}
                                    </p>
                                    <div class="card-footer">
                                        <span class="view-detail">
                                            Lihat Detail
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="empty-title">Tidak Ada Mitra Ditemukan</h3>
                        <p class="empty-description">Belum ada mitra yang terdaftar dalam kategori ini.</p>
                        <a href="{{ route('tampilmitra') }}" class="btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Semua Mitra
                        </a>
                    </div>
                @endforelse
            </div>

            @if(count($mitras) > 0)
                <div class="back-section">
                    <a href="{{ route('tampilmitra') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Semua Mitra
                    </a>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* Hero Section Styles */
        .category-hero {
            position: relative;
            min-height: 250px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #b40d14 0%, #8b0000 100%);
            opacity: 0.9;
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 80px 0;
            text-align: center;
        }

        .breadcrumb-nav {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .breadcrumb-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-link:hover {
            color: white;
        }

        .breadcrumb-separator {
            margin: 0 10px;
            color: rgba(255, 255, 255, 0.6);
        }

        .breadcrumb-current {
            color: white;
            font-weight: 500;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
        }

        .hero-stats {
            display: flex;
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Filter Section */
        .filter-section {
            padding: 30px 0;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .view-options {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            padding: 10px 12px;
            border: 2px solid #e9ecef;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-btn.active,
        .view-btn:hover {
            border-color: #dc2626;
            background: #dc2626;
            color: white;
        }

        /* Mitra Grid Section */
        .mitra-grid-section {
            padding: 60px 0;
        }

        .mitra-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .mitra-card {
            transition: transform 0.3s ease;
        }

        .mitra-card:hover {
            transform: translateY(-5px);
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .card-content {
            background: white;
            border-radius: 16px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626, #b91c1c);
        }

        .card-content:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .mitra-logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .logo-placeholder {
            color: #6c757d;
            font-size: 2rem;
        }

        .card-badge {
            background: linear-gradient(135deg, #ffd700, #ffed4a);
            color: #8b7800;
            padding: 8px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .mitra-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            line-height: 1.3;
        }

        .mitra-leader {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-footer {
            margin-top: auto;
            padding-top: 20px;
        }

        .view-detail {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dc2626;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .view-detail:hover {
            color: #b91c1c;
        }

        .view-detail i {
            transition: transform 0.3s ease;
        }

        .card-content:hover .view-detail i {
            transform: translateX(5px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            color: #e9ecef;
            margin-bottom: 30px;
        }

        .empty-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .empty-description {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(220, 38, 38, 0.3);
            color: white;
        }

        .back-section {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: white;
            color: #6c757d;
            text-decoration: none;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            border-color: #dc2626;
            color: #dc2626;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .mitra-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .filter-bar {
                flex-direction: column;
                gap: 15px;
            }

            .search-container {
                max-width: 100%;
            }

            .hero-stats {
                justify-content: center;
            }

            .card-content {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-content {
                padding: 60px 0;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('mitraSearch');
            const mitraCards = document.querySelectorAll('.mitra-card');
            
            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                mitraCards.forEach(card => {
                    const mitraName = card.getAttribute('data-name');
                    if (mitraName.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
            
            // View toggle functionality (future enhancement)
            const viewButtons = document.querySelectorAll('.view-btn');
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    viewButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    // Add list/grid view toggle logic here
                });
            });
        });
    </script>
@endsection