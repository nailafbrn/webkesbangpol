@extends('landingpage.layouts.app')
@section('title', 'Profile')
    <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">

@section('content')

    <!-- Hero Section -->
    <div class="profile-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">PROFIL ORGANISASI</h1>
                <p class="hero-subtitle">Mengenal lebih dekat dengan Badan Kesatuan Bangsa dan Politik Kota Bandung</p>
            </div>
            <div class="hero-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-square"></div>
            </div>
        </div>

        <!-- Profile Menu Grid -->
        <div class="menu-container">
            <div class="menu-grid">
                <!-- Visi Misi -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Visi Misi</h3>
                        <p class="card-description">Pandangan masa depan dan tujuan utama organisasi dalam memberikan pelayanan terbaik</p>
                        <a href="{{ route('tampilvisimisi') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Tugas dan Fungsi -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Tugas dan Fungsi</h3>
                        <p class="card-description">Peran dan tanggung jawab organisasi dalam menjalankan mandate yang diberikan</p>
                        <a href="{{ route('tampiltugasfungsi') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Struktur Organisasi -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon">
                        <i class="fas fa-sitemap fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Struktur Organisasi</h3>
                        <p class="card-description">Susunan kepemimpinan dan pembagian tugas dalam organisasi</p>
                        <a href="{{ route('tampilstruktur') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Landasan Hukum -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-icon">
                        <i class="fas fa-gavel fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Landasan Hukum</h3>
                        <p class="card-description">Dasar hukum pembentukan dan operasional organisasi</p>
                        <a href="{{ route('tampildasarhukum') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Program dan Kegiatan -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-icon">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Program dan Kegiatan</h3>
                        <p class="card-description">Berbagai program kerja dan kegiatan yang telah dan akan dilaksanakan</p>
                        <a href="{{ route('tampilprogram') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Sejarah -->
                <div class="menu-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="card-icon">
                        <i class="fas fa-history fa-2x"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Sejarah</h3>
                        <p class="card-description">Perjalanan dan perkembangan organisasi dari masa ke masa</p>
                        <a href="{{ route('tampilsejarah') }}" class="card-link">
                            <span>Selengkapnya</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Bagian Share -->
    <section class="share-section py-4">
        <div class="container">
            <div class="page-share p-3 rounded shadow-sm" style="background: #ffffff;">
                <h3 class="share-title mb-3">
                    <i class="fas fa-share-alt"></i>
                    Bagikan Halaman Ini
                </h3>
                <div class="share-options d-flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon facebook" title="Bagikan ke Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Menu Profile Badan Kesatuan Bangsa dan Politik Kota Bandung') }}" 
                        target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Menu Profile Badan Kesatuan Bangsa dan Politik Kota Bandung') }}%20{{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Menu Profile Badan Kesatuan Bangsa dan Politik Kota Bandung') }}&body={{ urlencode('Saya ingin berbagi halaman menarik ini: ' . request()->fullUrl()) }}" 
                        class="share-icon email" title="Bagikan via Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="javascript:void(0)" onclick="copyToClipboard()" 
                        class="share-icon copy" title="Salin Link">
                        <i class="fas fa-link"></i>
                    </a>
                </div>
            </div>

            <!-- Toast Notification -->
            <div id="copyToast" class="copy-toast hidden">
                <i class="fas fa-check-circle"></i>
                Link berhasil disalin!
            </div>
        </div>
    </section>

        <!-- Script Share -->
    <script>
        function copyToClipboard() {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast();
                }).catch(() => {
                    fallbackCopyToClipboard();
                });
            } else {
                fallbackCopyToClipboard();
            }
        }

        function fallbackCopyToClipboard() {
            const tempInput = document.createElement('input');
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showToast();
        }

        function showToast() {
            const toast = document.getElementById('copyToast');
            toast.classList.remove('hidden');
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }, 3000);
        }
    </script>

    <style>
        /* ===== PROFILE PAGE STYLES ===== */
        /* CSS Variables */
        :root {
            --primary-color: #b40D14;
            --primary-dark: #b91c1c;
            --primary-light: #DC2626;
            --secondary-color: #f8fafc;
            --accent-color: #06b6d4;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
        }

        /* Profile Container */
        .profile-container {
            min-height: 100vh;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            padding: 80px 20px 120px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white !important;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            opacity: 0.9;
            line-height: 1.6;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Decorations */
        .hero-decoration {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }

        .decoration-circle {
            position: absolute;
            top: 20%;
            right: 10%;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border-radius: 50%;
            animation: rotate 20s linear infinite;
        }

        .decoration-square {
            position: absolute;
            bottom: 20%;
            left: 10%;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%);
            border-radius: var(--radius-lg);
            transform: rotate(15deg);
            animation: rotate 25s linear infinite reverse;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Menu Container */
        .menu-container {
            position: relative;
            z-index: 3;
            margin-top: -60px;
            padding: 0 20px 80px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Menu Card */
        .menu-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }

        .menu-card:hover::before {
            transform: scaleX(1);
        }

        /* Card Icon */
        .card-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .card-icon i {
            width: 32px;
            height: 32px;
            color: white;
            transition: transform 0.3s ease;
        }

        .menu-card:hover .card-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .menu-card:hover .card-icon svg {
            transform: rotate(5deg);
        }

        /* Card Content */
        .card-content {
            position: relative;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .card-description {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Card Link */
        .card-link {
            display: inline-flex;
            /* align-items: center; */
            align-items: flex-end; 
            gap: 0.5rem;
            font-family: 'Mulish', sans-serif;
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .card-link span {
            position: relative;
        }

        .card-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .card-link:hover {
            color: var(--primary-dark);
            gap: 0.75rem;
        }

        .card-link:hover::after {
            transform: scaleX(1);
        }

        .card-link svg {
            width: 18px;
            height: 18px;
            transition: transform 0.3s ease;
        }

        .card-link:hover svg {
            transform: translateX(4px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.125rem;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .menu-card {
                padding: 1.5rem;
            }
            
            .hero-section {
                padding: 60px 20px 100px;
            }
            
            .menu-container {
                margin-top: -40px;
                padding: 0 15px 60px;
            }
            
            .decoration-circle,
            .decoration-square {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .menu-card {
                padding: 1.25rem;
            }
            
            .card-icon {
                width: 56px;
                height: 56px;
            }
            
            .card-icon svg {
                width: 28px;
                height: 28px;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            :root {
                --text-primary: #f1f5f9;
                --text-secondary: #cbd5e1;
                --text-light: #64748b;
                --border-color: #334155;
                --secondary-color: #1e293b;
            }
            
            .profile-container {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            }
            
            .menu-card {
                background: #1e293b;
                border-color: #334155;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print Styles */
        @media print {
            .profile-container {
                background: white;
            }
            
            .hero-section {
                background: white;
                color: black;
                page-break-after: avoid;
            }
            
            .menu-card {
                box-shadow: none;
                border: 2px solid #e2e8f0;
                page-break-inside: avoid;
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection