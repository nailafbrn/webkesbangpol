@extends('landingpage.layouts.app')
@section('title', $mitra->nama_lembaga)
<link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/landingpage-mitra.css') }}">

@section('content')
    <!-- Hero Section -->
    <section class="category-hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <h1 class="hero-title">Mitra</h1>
                    <p class="hero-subtitle">Badan Kesatuan Bangsa dan Politik Kota Bandung</p>
                </div>
            </div>
        </div>
    </section>


<!-- Detail Mitra Section -->
<section class="mitra-section" id="main-content">
    <div class="mitra-container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <!-- Mitra Header Card -->
<div class="mitra-header-card">
    
    <div class="header-top-row">
        
        <div class="mitra-logo-container">
            <div class="mitra-logo">
                <img src="{{ asset('images/mitras/logo/' . $mitra->logo_lembaga) }}" 
                     alt="Logo {{ $mitra->nama_lembaga }}">
            </div>
        </div>
        
        <div class="mitra-title-info">
            <h2 class="mitra-name">{{ $mitra->nama_lembaga }}</h2>
            <span class="mitra-category-badge">{{ $mitra->kategori_mitra }}</span>
        </div>

    </div>
    @if($mitra->deskripsi)
        <div class="mitra-description">
            <p>{!! $mitra->deskripsi !!}</p>
        </div>
    @endif
</div>
                    </div>
                </div>

                <!-- Mitra Detail Grid -->
                <div class="mitra-detail-grid">

                    <!-- Leadership Card -->
                    @if($mitra->ketua)
                        <div class="detail-card leadership-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-tie"></i>
                                    Pimpinan
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="leader-profile">
                                    @if($mitra->foto_ketua)
                                        <div class="leader-photo">
                                            <img src="{{ asset('images/mitras/foto_ketua/' . $mitra->foto_ketua) }}" 
                                                 alt="Foto {{ $mitra->ketua }}">
                                        </div>
                                    @endif
                                    <div class="leader-info">
                                        <h4 class="leader-name">{{ $mitra->ketua }}</h4>
                                        <p class="leader-position">Ketua {{ $mitra->nama_lembaga }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Kontak -->
                    @if($mitra->kontak)
                        <div class="detail-card contact-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-address-book"></i>
                                    Informasi Kontak
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="contact-list">
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="contact-info">
                                            <span class="contact-label">Kontak</span>
                                            <a href="tel:{{ $mitra->kontak }}" class="contact-value">{{ $mitra->kontak }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Alamat -->
                    <div class="detail-card contact-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-address-book"></i>
                                Alamat
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="contact-list">
                                @if($mitra->alamat)
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="contact-info">
                                            <span class="contact-label">Alamat</span>
                                            <span class="contact-value">{!! $mitra->alamat !!}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="contact-info">
                                            <span class="contact-label">Alamat</span>
                                            <span class="contact-value text-muted">Alamat tidak tersedia</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Back Navigation -->
                <div class="back-navigation">
                    <a href="{{ route('tampilmitra') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Daftar Mitra</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="section-decoration">
        <div class="dot-pattern dot-pattern-1"></div>
        <div class="dot-pattern dot-pattern-2"></div>
    </div>
</section>
   

    <!-- Custom Styles -->
    <style>
        /* Reset dan Global Styles */
        * {
            box-sizing: border-box;
        }

        /* Variables untuk konsistensi */
        :root {
            --primary-color: #dc3545;
            --primary-dark: #c82333;
            --secondary-color: #6c757d;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --border-color: #e9ecef;
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 25px rgba(0,0,0,0.1);
            --shadow-lg: 0 15px 35px rgba(0,0,0,0.12);
            --border-radius: 15px;
            --border-radius-lg: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Main Container */
        .mitra-section {
            padding: 40px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }

        .mitra-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

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

        /* Header Card */
/* Header Card - Layout Revisi */
.mitra-header-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: var(--border-radius-lg);
    padding: 50px;
    margin-bottom: 50px;
    color: white;
    box-shadow: var(--shadow-lg);
    align-items: flex-start;
    gap: 40px;
    position: relative;
    overflow: hidden;
    z-index: 10;
}

.mitra-header-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="90" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.3;
}

/* BARU: Baris atas untuk logo & judul.
  'display: flex' dipindahkan ke sini.
*/
.header-top-row {
    display: flex;
    align-items: center; /* Membuat logo dan judul sejajar */
    gap: 30px;
}

/* Logo (tidak banyak berubah) */
.mitra-logo-container {
    flex-shrink: 0; /* Mencegah logo menyusut */
}

.mitra-logo {
    width: 120px;
    height: 120px;
    background: white;
    border-radius: var(--border-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    padding: 15px; /* Padding agar logo tidak terlalu mepet */
}

.mitra-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* BARU: Pembungkus untuk judul dan badge */
.mitra-title-info {
    flex: 1; /* Mengisi sisa ruang */
}

.mitra-name {
    font-size: 2.4rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 15px;
    text-align: left;
}

.mitra-category-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    border: 1px solid rgba(255,255,255,0.3);
}

/* REVISI: Styling untuk deskripsi.
  Sekarang posisinya di bawah dan akan rata kiri secara otomatis.
*/
.mitra-description {
    margin-top: 30px; /* Jarak dari header di atasnya */
    padding-top: 30px; /* Padding di atas untuk ruang nafas */
    border-top: 1px solid rgba(255,255,255,0.25); /* Garis pemisah */
}

.mitra-description p {
    font-size: 1.1rem;
    line-height: 1.7;
    opacity: 0.95;
    margin: 0;
    padding: 0;
    text-align: justify; /* Teks rata kiri */
}

/* ================================================== */
/* == STYLING RESPONSIVE YANG SUDAH DISESUAIKAN == */
/* ================================================== */

@media (max-width: 768px) {
    .mitra-header-card {
        padding: 30px 25px;
        transform: translateY(-60px); /* Efek visual tetap ada */
    }

    .mitra-name {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    /* Saat layar kecil, buat logo dan judul tersusun ke bawah */
    .header-top-row {
        flex-direction: column;
        align-items: center; /* Posisikan di tengah saat ke bawah */
        text-align: center;
        gap: 20px;
    }

    .mitra-description {
        margin-top: 25px;
        padding-top: 25px;
    }

    /* Pastikan teks deskripsi tetap rata kiri di mobile */
    .mitra-description p {
        text-align: left;
    }
}

        /* Detail Grid */
        .mitra-detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .detail-card {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .detail-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background: linear-gradient(135deg, var(--bg-light) 0%, #e9ecef 100%);
            padding: 25px 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .card-body {
            padding: 30px;
        }

        /* Leadership Card */
        .leader-profile {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .leader-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .leader-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .leader-info {
            flex: 1;
        }

        .leader-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 8px 0;
        }

        .leader-position {
            color: var(--text-secondary);
            font-size: 1.05rem;
            margin: 0;
        }

        /* Contact Card */
        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            padding: 18px;
            background: var(--bg-light);
            border-radius: 12px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .contact-item:hover {
            background: #e9ecef;
            border-color: var(--primary-color);
            transform: translateX(5px);
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .contact-info {
            flex: 1;
        }

        .contact-label {
            display: block;
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-value {
            font-size: 1.05rem;
            color: var(--text-primary);
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }

        .contact-value:hover {
            color: var(--primary-color);
        }

        
        /* Back Navigation */
        .back-navigation {
            text-align: center;
            margin-top: 50px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--secondary-color), #495057);
            color: white;
            padding: 18px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            border: 1px solid transparent;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #495057, #343a40);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
            color: white;
        }

        /* Share Section */
        .share-section {
            background: linear-gradient(135deg, var(--bg-light) 0%, #e9ecef 100%);
            padding: 80px 0;
            position: relative;
        }

        .share-card {
            background: var(--bg-white);
            border-radius: var(--border-radius-lg);
            padding: 50px;
            box-shadow: var(--shadow-md);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .share-header {
            margin-bottom: 40px;
        }

        .share-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .share-title i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .share-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .share-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            color: white;
            box-shadow: var(--shadow-sm);
            border: 1px solid transparent;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .share-btn i {
            font-size: 1.1rem;
        }

        .share-btn.facebook {
            background: linear-gradient(135deg, #3b5998, #2d4373);
        }

        .share-btn.facebook:hover {
            background: linear-gradient(135deg, #2d4373, #1e2e4f);
        }

        .share-btn.twitter {
            background: linear-gradient(135deg, #1da1f2, #0d8bd9);
        }

        .share-btn.twitter:hover {
            background: linear-gradient(135deg, #0d8bd9, #0a6eaa);
        }

        .share-btn.whatsapp {
            background: linear-gradient(135deg, #25d366, #128c7e);
        }

        .share-btn.whatsapp:hover {
            background: linear-gradient(135deg, #128c7e, #0a6b5d);
        }

        .share-btn.email {
            background: linear-gradient(135deg, #ea4335, #d33b2c);
        }

        .share-btn.email:hover {
            background: linear-gradient(135deg, #d33b2c, #b52d20);
        }

        .share-btn.copy {
            background: linear-gradient(135deg, var(--secondary-color), #495057);
        }

        .share-btn.copy:hover {
            background: linear-gradient(135deg, #495057, #343a40);
        }

        /* Toast Notification */
        .copy-toast {
            position: fixed;
            top: 30px;
            right: 30px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 18px 30px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transform: translateX(100%);
            transition: var(--transition);
            font-weight: 500;
        }

        .copy-toast.show {
            transform: translateX(0);
        }

        .copy-toast i {
            font-size: 1.2rem;
        }

        /* Section Decorations */
        .section-decoration {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .dot-pattern {
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(220, 53, 69, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .dot-pattern-1 {
            top: 10%;
            left: -50px;
            animation: float 6s ease-in-out infinite;
        }

        .dot-pattern-2 {
            bottom: 10%;
            right: -50px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .mitra-detail-grid {
                grid-template-columns: 1fr;
            }
            
            .mitra-header-card {
                padding: 40px 30px;
            }
            
            .mitra-name {
                font-size: 2.4rem;
            }
        }

        @media (max-width: 768px) {
            .mitra-section {
                padding: 60px 0;
            }
            
            .mitra-hero {
                min-height: 40vh;
            }
            
            .mitra-title {
                font-size: 2.8rem;
            }
            
            .mitra-subtitle {
                font-size: 1.1rem;
            }
            
            .mitra-header-card {
                flex-direction: column;
                text-align: center;
                padding: 35px 25px;
                gap: 30px;
                transform: translateY(-60px);
            }

            .mitra-name {
                font-size: 2rem;
            }
            
            .mitra-container {
                padding: 0 15px;
            }

            .leader-profile {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .share-card {
                padding: 40px 25px;
            }
            
            .share-options {
                flex-direction: column;
                align-items: center;
            }

            .share-btn {
                min-width: 200px;
                justify-content: center;
            }
            
            .copy-toast {
                right: 15px;
                top: 20px;
                left: 15px;
                transform: translateY(-100%);
            }
            
            .copy-toast.show {
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .mitra-title {
                font-size: 2.2rem;
            }
            
            .mitra-name {
                font-size: 1.7rem;
            }
            
            .mitra-detail-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .card-header {
                padding: 20px;
            }
            
            .card-body {
                padding: 25px 20px;
            }
            
            .share-card {
                padding: 30px 20px;
            }
            
            .share-title {
                font-size: 1.5rem;
            }
        }

        /* Loading Animation */
        .detail-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .detail-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .detail-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Scripts -->
    <script>
        // Copy to clipboard functionality
        function copyToClipboard() {
            const url = window.location.href;
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast();
                }).catch(() => {
                    fallbackCopyToClipboard(url);
                });
            } else {
                fallbackCopyToClipboard(url);
            }
        }

        function fallbackCopyToClipboard(text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999);
            
            try {
                document.execCommand('copy');
                showToast();
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
            
            document.body.removeChild(tempInput);
        }

        function showToast() {
            const toast = document.getElementById('copyToast');
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Enhanced scroll animations
        function observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.detail-card').forEach(card => {
                observer.observe(card);
            });
        }

        // Initialize animations when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            observeElements();
            
            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Add loading state for images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                
                img.addEventListener('error', function() {
                    this.style.opacity = '0.5';
                    this.title = 'Gambar tidak dapat dimuat';
                });
            });
        });
    </script>
@endsection