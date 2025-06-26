@extends('landingpage.layouts.app')
@section('title', 'Data Organisasi Masyarakat')
    <link rel="stylesheet" href="{{ asset('assets/css/landingpage-ormas.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">

@section('content')
    <div class="ormas-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <h1 class="page-title">Data Organisasi Masyarakat</h1>
                <p class="page-subtitle">Informasi lengkap organisasi masyarakat yang terdaftar</p>
            </div>
            
            <!-- Search Bar -->
            <div class="search-section">
                <form method="GET" action="{{ route('tampil-data-ormas') }}" class="search-form" autocomplete="off">
                    <div class="search-input-group">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari nama organisasi..." 
                            value="{{ request('search') }}"
                            class="search-input"
                        >
                        <button type="submit" class="search-btn">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number">{{ $ormass->total() }}</div>
                <div class="stat-label">Total Organisasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $ormass->count() }}</div>
                <div class="stat-label">Ditampilkan</div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            @if($ormass->count() > 0)
                <div class="ormas-grid">
                    @foreach($ormass as $ormas)
                        <div class="ormas-card" style="cursor:pointer" data-ormas='@json($ormas->load("pengurus", "dokumen"))'>
                            <div class="card-header">
                                <div class="org-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <h3 class="org-name">{{ $ormas->nama_organisasi }}</h3>
                            </div>
                            
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Alamat</span>
                                        <span class="info-value">{!! $ormas->alamat ?: 'Tidak tersedia' !!}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6m8 0V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2"/>
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Bidang</span>
                                        <span class="info-value">{{ $ormas->bidang ?: 'Tidak tersedia' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="pengurus-count">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    <span>{{ $ormas->pengurus->count() }} Pengurus</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-section">
                    {{ $ormass->links('components.custom-pagination') }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">Tidak ada data ditemukan</h3>
                    <p class="empty-subtitle">
                        @if(request('search'))
                            Tidak ada organisasi dengan kata kunci "{{ request('search') }}"
                        @else
                            Belum ada data organisasi masyarakat yang terdaftar
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('data-ormas') }}" class="reset-btn">
                            Tampilkan Semua Data
                        </a>
                    @endif
                </div>
            @endif
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
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Data Organisasi Masyarakat Badan Kesatuan Bangsa dan Politik Kota Bandung') }}" 
                        target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Data Organisasi Masyarakat Badan Kesatuan Bangsa dan Politik Kota Bandung') }}%20{{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Data Organisasi Masyarakat Badan Kesatuan Bangsa dan Politik Kota Bandung') }}&body={{ urlencode('Saya ingin berbagi halaman menarik ini: ' . request()->fullUrl()) }}" 
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
    
<!-- Modal Detail Ormas - MODERN VERSION -->
    <div class="modal fade" id="modalDetailOrmas" tabindex="-1" aria-labelledby="detailOrmasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-custom modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ultra-modern-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailOrmasLabel">Detail Organisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-content-loading" class="loading-modern">
                        <div class="spinner"></div>
                        Memuat data organisasi...
                    </div>
                    <div id="modal-content-ormas" class="d-none">
                        <h4 id="modal-nama" class="org-title"></h4>
                        
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </div>
                            <div id="modal-alamat" class="info-value"></div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-briefcase"></i>
                                Bidang Organisasi
                            </div>
                            <div id="modal-bidang" class="info-value"></div>
                        </div>

                        <h5 class="section-header">
                            <i class="fas fa-users"></i>
                            Pengurus Organisasi
                        </h5>
                        <div id="modal-pengurus"></div>

                        <h5 class="section-header">
                            <i class="fas fa-file-alt"></i>
                            Dokumen Organisasi
                        </h5>
                        <div id="modal-dokumen"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modal Ultra Modern Style */
        .ultra-modern-modal {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.98);
        }

        .ultra-modern-modal .modal-header {
            background: linear-gradient(135deg, #B40D14 0%, #DC2626 50%, #EF4444 100%); 
            color: white;
            border: none;
            padding: 25px 30px 20px;
            position: relative;
            overflow: hidden;
        }

        .ultra-modern-modal .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }

        .ultra-modern-modal .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .ultra-modern-modal .modal-title::before {
            content: '\f1ad';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            background: rgba(255, 255, 255, 0.2);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .ultra-modern-modal .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            color: white; /* Tambah ini */
            font-size: 1.2rem; /* Tambah ini */
        }
        
        /* BARU - Tambahkan ini untuk icon Font Awesome */
        .ultra-modern-modal .btn-close::before {
            content: '\f00d'; /* Unicode untuk Font Awesome X */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        
        .ultra-modern-modal .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            opacity: 1;
            transform: rotate(90deg);
        }

        .ultra-modern-modal .modal-body {
            padding: 35px;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }

        .ultra-modern-modal .org-title {
            color: #2d3748;
            font-weight: 800;
            font-size: 1.75rem;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .ultra-modern-modal .org-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            border-radius: 2px;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(90deg, #ff6b6b);
        }

        .info-label {
            color: #B40D14;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            color: #2d3748;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.6;
        }

        .section-header {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 30px 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .section-header i {
            background: #B40D14;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.4rem;
        }

        .member-card {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            border-left: 4px solid #ff6b6b;
            transition: all 0.3s ease;
        }

        .member-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.15);
        }

        .member-position {
            color: #B40D14;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .member-name {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .doc-item {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .doc-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .doc-icon {
            background: linear-gradient(135deg, #B40D14 0%, #DC2626 50%, #EF4444 100%); 
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .doc-content {
            flex-grow: 1;
        }

        .doc-label {
            color: #B40D14;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .doc-value {
            color: #2d3748;
            font-weight: 500;
        }

        .loading-modern {
            text-align: center;
            padding: 50px 0;
            color: #667eea;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .loading-modern .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #a0aec0;
            font-style: italic;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .modal-lg-custom {
            max-width: 800px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ultra-modern-modal .modal-body {
                padding: 20px;
            }
            
            .ultra-modern-modal .org-title {
                font-size: 1.4rem;
            }
            
            .info-card {
                padding: 15px;
            }
            
            .member-card {
                padding: 15px;
            }
            
            .doc-item {
                padding: 12px;
                flex-direction: column;
                text-align: center;
            }
            
            .doc-icon {
                width: 40px;
                height: 40px;
            }
        }
    </style>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Cek apakah Bootstrap tersedia
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap JS tidak ditemukan! Pastikan Bootstrap sudah di-load.');
                return;
            }

            const modalElement = document.getElementById('modalDetailOrmas');
            if (!modalElement) {
                console.error('Modal element tidak ditemukan!');
                return;
            }

            const modal = new bootstrap.Modal(modalElement);

            document.querySelectorAll('.ormas-card').forEach(card => {
                card.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    try {
                        // Parse data ormas dengan error handling
                        const ormasData = card.getAttribute('data-ormas');
                        if (!ormasData) {
                            throw new Error('Data ormas tidak ditemukan');
                        }
                        
                        const ormas = JSON.parse(ormasData);
                        console.log('Data ormas:', ormas); // Debug log
                        
                        const pengurus = ormas.pengurus || [];
                        const dokumen = ormas.dokumen || {};

                        // Tampilkan loading
                        const loadingElement = document.getElementById("modal-content-loading");
                        const contentElement = document.getElementById("modal-content-ormas");
                        
                        if (loadingElement) loadingElement.classList.remove('d-none');
                        if (contentElement) contentElement.classList.add('d-none');

                        // Isi konten modal dengan delay untuk efek loading
                        setTimeout(() => {
                            try {
                                // Set nama organisasi
                                const namaElement = document.getElementById("modal-nama");
                                if (namaElement) namaElement.textContent = ormas.nama_organisasi || 'Tidak tersedia';

                                // Set alamat
                                const alamatElement = document.getElementById("modal-alamat");
                                if (alamatElement) alamatElement.innerHTML = ormas.alamat || 'Tidak tersedia';

                                // Set bidang
                                const bidangElement = document.getElementById("modal-bidang");
                                if (bidangElement) bidangElement.textContent = ormas.bidang || 'Tidak tersedia';

                                // Set pengurus dengan tampilan modern
                                const pengurusList = document.getElementById("modal-pengurus");
                                if (pengurusList) {
                                    if (pengurus.length > 0) {
                                        pengurusList.innerHTML = pengurus.map(p => 
                                            `<div class="member-card">
                                                <div class="member-position">${p.jabatan || 'Jabatan tidak tersedia'}</div>
                                                <div class="member-name">${p.nama || 'Nama tidak tersedia'}</div>
                                            </div>`
                                        ).join('');
                                    } else {
                                        pengurusList.innerHTML = `
                                            <div class="empty-state">
                                                <i class="fas fa-users"></i>
                                                <div>Tidak ada data pengurus</div>
                                            </div>
                                        `;
                                    }
                                }

                                // Set dokumen dengan tampilan modern
                                const dokumenList = document.getElementById("modal-dokumen");
                                if (dokumenList) {
                                    let dokumenHTML = '';
                                    let dokData = null;
                                    
                                    // Handle berbagai struktur data dokumen
                                    if (Array.isArray(dokumen) && dokumen.length > 0) {
                                        dokData = dokumen[0];
                                    } else if (dokumen && typeof dokumen === 'object' && !Array.isArray(dokumen)) {
                                        dokData = dokumen;
                                    }
                                    
                                    if (dokData) {
                                        // Akta Notaris
                                        if (dokData.akta_notaris) {
                                            dokumenHTML += `
                                                <div class="doc-item">
                                                    <div class="doc-icon">
                                                        <i class="fas fa-certificate"></i>
                                                    </div>
                                                    <div class="doc-content">
                                                        <div class="doc-label">Akta Notaris</div>
                                                        <div class="doc-value">${dokData.akta_notaris}</div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                        
                                        // AHU/SKT
                                        if (dokData.ahu_skt) {
                                            dokumenHTML += `
                                                <div class="doc-item">
                                                    <div class="doc-icon">
                                                        <i class="fas fa-stamp"></i>
                                                    </div>
                                                    <div class="doc-content">
                                                        <div class="doc-label">AHU/SKT</div>
                                                        <div class="doc-value">${dokData.ahu_skt}</div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                        
                                        // NPWP
                                        if (dokData.npwp) {
                                            dokumenHTML += `
                                                <div class="doc-item">
                                                    <div class="doc-icon">
                                                        <i class="fas fa-receipt"></i>
                                                    </div>
                                                    <div class="doc-content">
                                                        <div class="doc-label">NPWP</div>
                                                        <div class="doc-value">${dokData.npwp}</div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                    }
                                    
                                    if (dokumenHTML === '') {
                                        dokumenHTML = `
                                            <div class="empty-state">
                                                <i class="fas fa-file-alt"></i>
                                                <div>Tidak ada data dokumen</div>
                                            </div>
                                        `;
                                    }
                                    
                                    dokumenList.innerHTML = dokumenHTML;
                                }

                                // Sembunyikan loading dan tampilkan konten
                                if (loadingElement) loadingElement.classList.add('d-none');
                                if (contentElement) contentElement.classList.remove('d-none');
                                
                            } catch (error) {
                                console.error('Error mengisi konten modal:', error);
                                if (loadingElement) {
                                    loadingElement.innerHTML = `
                                        <div class="empty-state">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div>Terjadi kesalahan saat memuat data</div>
                                        </div>
                                    `;
                                }
                            }
                        }, 800); // Delay 800ms untuk efek loading yang lebih smooth

                        // Tampilkan modal
                        modal.show();
                        
                    } catch (error) {
                        console.error('Error parsing data ormas:', error);
                        alert('Terjadi kesalahan saat memuat data organisasi');
                    }
                });
            });

            // Event listener untuk menutup modal
            modalElement.addEventListener('hidden.bs.modal', function () {
                // Reset konten modal dengan animasi
                const loadingElement = document.getElementById("modal-content-loading");
                const contentElement = document.getElementById("modal-content-ormas");
                
                if (loadingElement) {
                    loadingElement.classList.remove('d-none');
                    loadingElement.innerHTML = `
                        <div class="spinner"></div>
                        Memuat data organisasi...
                    `;
                }
                if (contentElement) contentElement.classList.add('d-none');
            });
        });
    </script>

@endsection