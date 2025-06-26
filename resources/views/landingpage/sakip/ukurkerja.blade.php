@extends('landingpage.layouts.app')
@section('title', 'Pengukuran Kerja')
    <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">
@section('content')
    <section class="ukurkerja-hero">
        <div class="ukurkerja-overlay"></div>
        <div class="ukurkerja-content">
            <div class="hero-badge">
                <span class="badge-text">Job Evaluation</span>
            </div>
            <h1 class="ukurkerja-title">PENGUKURAN KERJA</h1>
            <p class="ukurkerja-subtitle">Badan Kesatuan Bangsa dan Politik Kota Bandung</p>
            <p class="ukurkerja-lead">Dokumen Evaluasi Yang Berisi Capaian Pelaksanaan Program Dan Kegiatan, Digunakan Untuk Menilai Efektivitas Kinerja Dalam Mencapai Tujuan Dan Sasaran Pembangunan</p>

        </div>
    </section>

    <div class="main-container">
        <div class="content-wrapper">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <div class="filter-title-wrapper">
                        <h3 class="filter-title">
                            <i class="fas fa-filter filter-icon"></i>
                            Filter & Pencarian
                        </h3>
                        <p class="filter-subtitle">Temukan dokumen Pengukuran Kinerja dengan mudah</p>
                    </div>
                </div>
                
                <div class="filter-controls">
                    <div class="filter-row">
                        <div class="filter-item">
                            <label for="tahunFilter" class="filter-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tahun
                            </label>
                            <select class="filter-select" id="tahunFilter">
                                <option value="">Semua Tahun</option>
                                @php
                                    $years = $ukurkerjas->pluck('tahun')->unique()->sort()->reverse();
                                @endphp
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-item">
                            <label for="searchInput" class="filter-label">
                                <i class="fas fa-search"></i>
                                Pencarian
                            </label>
                            <input type="text" class="filter-input" id="searchInput" placeholder="Masukkan kata kunci...">
                        </div>
                        
                        <div class="filter-item">
                            <label for="sortOrder" class="filter-label">
                                <i class="fas fa-sort"></i>
                                Urutkan
                            </label>
                            <select class="filter-select" id="sortOrder">
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                                <option value="title">Judul A-Z</option>
                                <option value="title-desc">Judul Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div id="tableView" class="table-section">
                <div class="table-wrapper">
                    <div class="table-container">
                        <table class="ukurkerja-table">
                            <thead>
                                <tr>
                                    <th width="5%" class="table-header-number">No</th>
                                    <th width="15%" class="table-header-year">Tahun</th>
                                    <th width="50%" class="table-header-title">Judul Dokumen</th>
                                    <th width="30%" class="table-header-actions">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ukurkerjaTableBody">
                                @forelse($ukurkerjas as $index => $ukurkerja)
                                <tr class="ukurkerja-item table-row" data-year="{{ $ukurkerja->tahun }}" data-title="{{ $ukurkerja->title }}" data-index="{{ $index + 1 }}">
                                    <td class="item-number table-cell-number">
                                        <span class="row-number">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="table-cell-year">
                                        <span class="badge badge-year">{{ $ukurkerja->tahun }}</span>
                                    </td>
                                    <td class="table-cell-title">
                                        <div class="document-title">{{ $ukurkerja->title }}</div>
                                    </td>
                                    <td class="table-cell-actions">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-preview preview-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#previewModal" 
                                                    data-file="{{ basename($ukurkerja->file_upload) }}" 
                                                    data-download-url="{{ asset($ukurkerja->file_upload_wm) }}"
                                                    data-title="{{ $ukurkerja->title }}">
                                                <i class="fas fa-eye"></i>
                                                <span class="btn-text">Preview</span>
                                            </button>
                                            <a href="{{ asset($ukurkerja->file_upload_wm) }}" class="btn btn-download" download>
                                                <i class="fas fa-download"></i>
                                                <span class="btn-text">Unduh</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="empty-row">
                                    <td colspan="4" class="empty-cell">
                                        <div class="empty-state">
                                            <i class="fas fa-folder-open empty-icon"></i>
                                            <p class="empty-text">Tidak ada data Indikator Kinerja Utama yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $ukurkerjas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="modal-title-wrapper">
                        <h5 class="modal-title" id="previewModalLabel">
                            <i class="fas fa-file-pdf modal-icon"></i>
                            Preview Dokumen
                        </h5>
                    </div>
                    <div class="modal-actions">
                        <a id="downloadBtn" href="#" class="modal-btn modal-download" download>
                            <i class="fas fa-download"></i>
                            <span>Unduh</span>
                        </a>
                        <button type="button" class="modal-btn modal-close" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="modal-body modern-modal-body">
                    <!-- Error message -->
                    <div id="pdfError" class="error-container" style="display: none;"></div>
                    
                    <!-- Loading indicator -->
                    <div id="pdfLoading" class="loading-container">
                        <div class="loading-spinner">
                            <div class="spinner"></div>
                        </div>
                        <p class="loading-text">Memuat dokumen...</p>
                    </div>
                    
                    <!-- Container for PDF object -->
                    <div id="pdfContainer" class="pdf-container"></div>
                    
                    <!-- Canvas for PDF.js fallback -->
                    <canvas id="pdfCanvas" class="pdf-canvas"></canvas>
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
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Pengukuran Kerja Badan Kesatuan Bangsa dan Politik Kota Bandung') }}" 
                        target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Pengukuran Kerja Badan Kesatuan Bangsa dan Politik Kota Bandung') }}%20{{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Pengukuran Kerja Badan Kesatuan Bangsa dan Politik Kota Bandung') }}&body={{ urlencode('Saya ingin berbagi halaman menarik ini: ' . request()->fullUrl()) }}" 
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

    <style>
        :root {
            --primary-light: #dbeafe;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;
        }

        /* Hero Section */
        .ukurkerja-hero {
            background: #b40D14;
            color: var(--white);
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .ukurkerja-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Floating Elements */
        .ukurkerja-hero .floating {
            position: absolute;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }

        /* Variasi posisi awal floating element */
        .ukurkerja-hero .floating.f1 {
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }

        .ukurkerja-hero .floating.f2 {
            top: 40%;
            left: 70%;
            animation-delay: 1.5s;
            width: 30px;
            height: 30px;
        }

        .ukurkerja-hero .floating.f3 {
            bottom: 15%;
            left: 35%;
            animation-delay: 3s;
            width: 20px;
            height: 20px;
        }

        /* Floating Animation */
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .ukurkerja-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.1;
        }

        .ukurkerja-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-block;
            margin-bottom: 1.5rem;
            background: none !important;
            border: none !important;
        }

        .badge-text {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            backdrop-filter: blur(10px);
            font-family: 'Montserrat', sans-serif;
        }

        .ukurkerja-title {
            font-size: clamp(1rem, 3vw, 2rem);
            font-weight: 700;
            margin-bottom: 1rem;
            font-family: 'Montserrat', sans-serif;
            color: var(--white);
            line-height: 1.1;
        }

        .ukurkerja-subtitle {
            font-size: clamp(1.125rem, 3vw, 1.5rem);
            font-weight: 600;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            font-family: 'Open Sans', sans-serif;
            color: var(--white);
        }

        .ukurkerja-lead {
            font-size: 1.125rem;
            font-weight: 400;
            opacity: 0.85;
            font-family: 'Work Sans', sans-serif;
            color: var(--white);
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Main Container */
        .main-container {
            background: var(--gray-50);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Filter Section */
        .filter-section {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .filter-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            padding: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .filter-title-wrapper {
            text-align: center;
        }

        .filter-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .filter-icon {
            color: #DC2626;
            font-size: 1.25rem;
        }

        .filter-subtitle {
            color: var(--gray-600);
            margin: 0;
            font-size: 0.875rem;
        }

        .filter-controls {
            padding: 2rem;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-label i {
            color: #DC2626;
            font-size: 0.875rem;
        }

        .filter-select,
        .filter-input {
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
            background: var(--white);
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: #b40d14;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-input::placeholder {
            color: var(--gray-400);
        }

        /* Table Section */
        .table-section {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .table-container {
            min-width: 100%;
        }

        .ukurkerja-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .ukurkerja-table thead tr {
            background: linear-gradient(135deg, #B40D14 0%, #DC2626 50%, #EF4444 100%);
        }

        .ukurkerja-table th {
            padding: 1.25rem 1rem;
            color: var(--white);
            font-weight: 600;
            font-size: 0.875rem;
            text-align: left;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-header-number {
            text-align: center;
        }

        .table-row {
            transition: all 0.2s ease-in-out;
            border-bottom: 1px solid var(--gray-100);
        }

        .table-row:hover {
            background: var(--gray-50);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .ukurkerja-table td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border: none;
        }

        .table-cell-number {
            text-align: center;
        }

        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            background: #DC2626;
            color: #fff;
            border-radius: 50%;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-year {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
            box-shadow: var(--shadow-sm);
        }

        .document-title {
            font-weight: 500;
            color: var(--gray-800);
            line-height: 1.4;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-preview {
            background: linear-gradient(135deg, #B40D14 0%, #DC2626 100%);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-preview:hover {
            background: linear-gradient(135deg, #A30B12 0%, #B91C1C 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: var(--white);
        }

        .btn-download {
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .btn-download:hover {
            background: var(--gray-50);
            border-color: var(--gray-300);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: var(--gray-700);
            text-decoration: none;
        }

        .btn-text {
            font-size: 0.875rem;
        }

        /* Empty State */
        .empty-cell {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--gray-300);
        }

        .empty-text {
            color: var(--gray-500);
            font-size: 1rem;
            margin: 0;
        }

        /* Modal Styles */
        .modern-modal {
            border: none;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .modern-modal-header {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            border-bottom: 1px solid var(--gray-200);
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title-wrapper {
            flex: 1;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-icon {
            color: var(--danger-color);
            font-size: 1.125rem;
        }

        .modal-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .modal-download {
            background: linear-gradient(135deg, #B40D14 0%, #DC2626 100%);
            color: var(--white);
        }

        .modal-download:hover {
            background: linear-gradient(135deg, #A30B12 0%, #B91C1C 100%);
            color: var(--white);
            text-decoration: none;
        }

        .modal-close {
            background: var(--gray-100);
            color: var(--gray-600);
            padding: 0.5rem;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            justify-content: center;
        }

        .modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .modern-modal-body {
            padding: 2rem;
            background: var(--gray-50);
        }

        .error-container {
            margin-bottom: 1rem;
        }

        .loading-container {
            text-align: center;
            padding: 3rem 1rem;
        }

        .loading-spinner {
            margin-bottom: 1rem;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
            border: 3px solid var(--gray-200);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: var(--gray-600);
            font-size: 1rem;
            margin: 0;
        }

        .pdf-container {
            min-height: 500px;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
        }

        .pdf-canvas {
            max-width: 100%;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            display: none;
            box-shadow: var(--shadow-sm);
        }

        /* Pagination Styles */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            color: var(--primary-color) !important;
            background-color: var(--white) !important;
            border-color: var(--gray-200) !important;
            padding: 0.75rem 1rem !important;
            margin: 0 0.125rem !important;
            border-radius: var(--border-radius) !important;
            font-weight: 500 !important;
            transition: all 0.2s ease-in-out !important;
        }

        .page-link:hover {
            color: var(--white) !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            transform: translateY(-1px) !important;
            box-shadow: var(--shadow-md) !important;
        }

        .page-item.active .page-link {
            color: var(--white) !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            box-shadow: var(--shadow-md) !important;
        }

        .page-item.disabled .page-link {
            color: var(--gray-400) !important;
            background-color: var(--gray-100) !important;
            border-color: var(--gray-200) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ukurkerja-hero {
                padding: 3rem 1rem;
            }
            
            .filter-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                justify-content: center;
            }
            
            .modal-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }
            
            .modal-btn {
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .main-container {
                padding: 1rem 0;
            }
            
            .content-wrapper {
                padding: 0 0.5rem;
            }
            
            .filter-header,
            .filter-controls {
                padding: 1.5rem 1rem;
            }
            
            .modern-modal-header,
            .modern-modal-body {
                padding: 1rem;
            }
            
            .table-wrapper {
                margin: -1rem;
                padding: 1rem;
            }
        }
    </style>

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

    <script>
        // Enhanced JavaScript for PDF preview
        document.addEventListener("DOMContentLoaded", function () {
            const previewButtons = document.querySelectorAll('.preview-btn');
            const previewModalLabel = document.getElementById('previewModalLabel');
            const downloadBtn = document.getElementById('downloadBtn');
            const errorDiv = document.getElementById('pdfError');
            const pdfContainer = document.getElementById('pdfContainer');
            const pdfLoading = document.getElementById('pdfLoading');
            
            // PDF.js rendering function - untuk direct URL
            const renderPdfWithPdfJs = async (url, isPdfData = false) => {
                try {
                    pdfLoading.style.display = 'block';
                    errorDiv.style.display = 'none';
                    
                    // Clear previous content
                    pdfContainer.innerHTML = '';
                    
                    // Create viewer container
                    const viewerContainer = document.createElement('div');
                    viewerContainer.style.width = '100%';
                    viewerContainer.style.height = '500px';
                    viewerContainer.style.overflow = 'auto';
                    viewerContainer.style.border = '1px solid #ccc';
                    pdfContainer.appendChild(viewerContainer);
                    
                    // Load PDF document using PDF.js
                    let loadingTask;
                    if (isPdfData) {
                        loadingTask = pdfjsLib.getDocument({data: url}); // url adalah binary data dalam kasus ini
                    } else {
                        loadingTask = pdfjsLib.getDocument(url);
                    }
                    
                    const pdf = await loadingTask.promise;
                    // console.log(`PDF loaded successfully. Number of pages: ${pdf.numPages}`);
                    
                    // SELALU buat navigasi jika ada lebih dari 1 halaman
                    if (pdf.numPages > 1) {
                        const navDiv = document.createElement('div');
                        navDiv.className = 'text-center mb-2';
                        navDiv.innerHTML = `
                            <div class="btn-group" role="group">
                                <button id="prevPage" class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="fas fa-chevron-left"></i> Prev
                                </button>
                                <span class="btn btn-sm btn-outline-secondary" id="pageInfo">
                                    Page <span id="currentPage">1</span> of ${pdf.numPages}
                                </span>
                                <button id="nextPage" class="btn btn-sm btn-outline-secondary">
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        `;
                        pdfContainer.insertBefore(navDiv, viewerContainer);
                        
                        // Set up navigation handlers
                        let currentPageNum = 1;
                        const currentPageElem = document.getElementById('currentPage');
                        const pageContainers = {};
                        
                        // Fungsi untuk membuat semua container halaman
                        const setupPageContainers = () => {
                            // Buat container untuk halaman pertama
                            const firstPageContainer = document.createElement('div');
                            firstPageContainer.id = `page-1`;
                            firstPageContainer.className = 'pdf-page mb-2';
                            viewerContainer.appendChild(firstPageContainer);
                            pageContainers[1] = firstPageContainer;
                        };
                        
                        // Setup halaman pertama
                        setupPageContainers();
                        
                        document.getElementById('prevPage').addEventListener('click', () => {
                            if (currentPageNum > 1) {
                                // Sembunyikan halaman saat ini
                                if (pageContainers[currentPageNum]) {
                                    pageContainers[currentPageNum].style.display = 'none';
                                }
                                
                                currentPageNum--;
                                
                                // Buat container jika belum ada
                                if (!pageContainers[currentPageNum]) {
                                    const pageContainer = document.createElement('div');
                                    pageContainer.id = `page-${currentPageNum}`;
                                    pageContainer.className = 'pdf-page mb-2';
                                    viewerContainer.appendChild(pageContainer);
                                    pageContainers[currentPageNum] = pageContainer;
                                } else {
                                    pageContainers[currentPageNum].style.display = 'block';
                                }
                                
                                // Render halaman jika belum pernah dirender
                                if (pageContainers[currentPageNum].childElementCount === 0) {
                                    renderPage(currentPageNum);
                                }
                                
                                // Update UI
                                currentPageElem.textContent = currentPageNum;
                                document.getElementById('nextPage').disabled = false;
                                if (currentPageNum === 1) {
                                    document.getElementById('prevPage').disabled = true;
                                }
                            }
                        });
                        
                        document.getElementById('nextPage').addEventListener('click', () => {
                            if (currentPageNum < pdf.numPages) {
                                // Sembunyikan halaman saat ini
                                if (pageContainers[currentPageNum]) {
                                    pageContainers[currentPageNum].style.display = 'none';
                                }
                                
                                currentPageNum++;
                                
                                // Buat container jika belum ada
                                if (!pageContainers[currentPageNum]) {
                                    const pageContainer = document.createElement('div');
                                    pageContainer.id = `page-${currentPageNum}`;
                                    pageContainer.className = 'pdf-page mb-2';
                                    viewerContainer.appendChild(pageContainer);
                                    pageContainers[currentPageNum] = pageContainer;
                                } else {
                                    pageContainers[currentPageNum].style.display = 'block';
                                }
                                
                                // Render halaman jika belum pernah dirender
                                if (pageContainers[currentPageNum].childElementCount === 0) {
                                    renderPage(currentPageNum);
                                }
                                
                                // Update UI
                                currentPageElem.textContent = currentPageNum;
                                document.getElementById('prevPage').disabled = false;
                                if (currentPageNum === pdf.numPages) {
                                    document.getElementById('nextPage').disabled = true;
                                }
                            }
                        });
                        
                        // Function to render a specific page
                        const renderPage = async (pageNumber) => {
                            // Get the page container
                            const pageContainer = pageContainers[pageNumber];
                            if (!pageContainer) {
                                console.error(`Page container for page ${pageNumber} not found`);
                                return;
                            }
                            
                            // Show loading indicator
                            pageContainer.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
                            
                            try {
                                // Get the page
                                const page = await pdf.getPage(pageNumber);
                                
                                // Clear loading indicator
                                pageContainer.innerHTML = '';
                                
                                // Create canvas for this page
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                pageContainer.appendChild(canvas);
                                
                                // Calculate scale to fit width
                                const viewport = page.getViewport({ scale: 1 });
                                const containerWidth = viewerContainer.clientWidth - 30; // Account for padding
                                const scale = containerWidth / viewport.width;
                                const scaledViewport = page.getViewport({ scale });
                                
                                // Set canvas dimensions
                                canvas.width = scaledViewport.width;
                                canvas.height = scaledViewport.height;
                                
                                // Render the page
                                const renderContext = {
                                    canvasContext: context,
                                    viewport: scaledViewport
                                };
                                
                                await page.render(renderContext).promise;
                                
                                // Hide loading indicator if on first page
                                if (pageNumber === 1) {
                                    pdfLoading.style.display = 'none';
                                }
                                
                            } catch (error) {
                                console.error(`Error rendering page ${pageNumber}:`, error);
                                pageContainer.innerHTML = `<div class="alert alert-danger">Error rendering page ${pageNumber}: ${error.message}</div>`;
                                if (pageNumber === 1) {
                                    pdfLoading.style.display = 'none';
                                }
                            }
                        };
                        
                        // Initial render of first page
                        renderPage(1);
                        
                    } else {
                        // Just render the single page
                        const page = await pdf.getPage(1);
                        
                        // Create canvas
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        viewerContainer.appendChild(canvas);
                        
                        // Calculate scale to fit width
                        const viewport = page.getViewport({ scale: 1 });
                        const containerWidth = viewerContainer.clientWidth - 30; // Account for padding
                        const scale = containerWidth / viewport.width;
                        const scaledViewport = page.getViewport({ scale });
                        
                        // Set canvas dimensions
                        canvas.width = scaledViewport.width;
                        canvas.height = scaledViewport.height;
                        
                        // Render the page
                        const renderContext = {
                            canvasContext: context,
                            viewport: scaledViewport
                        };
                        
                        await page.render(renderContext).promise;
                        pdfLoading.style.display = 'none';
                    }
                    
                    return true;
                } catch (error) {
                    console.error('PDF.js rendering error:', error);
                    throw error;
                }
            };
            
            // Base64 PDF loader (untuk mengatasi AdBlock) - Menggunakan renderer yang sama
            const loadPdfFromBase64 = async (filename) => {
                try {
                    pdfLoading.style.display = 'block';
                    errorDiv.style.display = 'none';
                    
                    // Fetch dokumen sebagai base64
                    const response = await fetch(`/serve-document-ukurkerja/${encodeURIComponent(filename)}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    // Buat bytes dari base64
                    const pdfData = atob(data.content);
                    const pdfBytes = new Uint8Array(pdfData.length);
                    for (let i = 0; i < pdfData.length; i++) {
                        pdfBytes[i] = pdfData.charCodeAt(i);
                    }
                    
                    // Gunakan fungsi renderer utama dengan data PDF
                    return await renderPdfWithPdfJs(pdfBytes, true);
                    
                } catch (error) {
                    console.error('Error loading PDF from base64:', error);
                    throw error;
                }
            };
            
            // Improved PDF loading with AdBlock mitigation
            const loadPdf = async (filename) => {
                // Show loading state
                pdfLoading.style.display = 'block';
                errorDiv.style.display = 'none';
                pdfContainer.innerHTML = '';
                
                try {
                    // Solusi 1: Coba metode Base64
                        // console.log('Mencoba memuat PDF dengan metode Base64');
                        await loadPdfFromBase64(filename);
                        return true;
                    
                } catch (error1) {
                    console.warn('Loading via Base64 route failed:', error1);
                    
                    try {
                        // Solusi 2: Coba gunakan view-doc sebagai route alternatif
                        const alternativeUrl = `/secure-file-ukurkerja/${encodeURIComponent(filename)}`;
                        console.log('Mencoba memuat PDF melalui route alternatif:', alternativeUrl);
                        
                        await renderPdfWithPdfJs(alternativeUrl);
                        return true;
                        
                    } catch (error2) {
                        console.warn('Alternative loading failed:', error2);
                        
                        try {
                            // Solusi 3: Coba metode object tag
                            console.log('Mencoba memuat dengan object tag');
                            
                            pdfContainer.innerHTML = `
                                <object 
                                    data="/secure-file-ukurkerja/${encodeURIComponent(filename)}" 
                                    type="application/pdf" 
                                    width="100%" 
                                    height="500px"
                                    style="border: 1px solid #ccc;">
                                    <div class="text-center p-5">
                                        <p>Browser Anda tidak mendukung tampilan PDF secara langsung.</p>
                                        <a href="/secure-file-ukurkerja/${encodeURIComponent(filename)}" class="btn btn-primary" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Buka PDF di Tab Baru
                                        </a>
                                    </div>
                                </object>
                            `;
                            
                            pdfLoading.style.display = 'none';
                            return true;
                            
                        } catch (error3) {
                            // Jika semua metode gagal, berikan link download
                            console.error('All loading strategies failed');
                            
                            pdfContainer.innerHTML = `
                                <div class="text-center p-5">
                                    <div class="alert alert-warning">
                                        <p><i class="fas fa-exclamation-triangle"></i> Tidak dapat menampilkan preview PDF secara langsung.</p>
                                        <p>Hal ini bisa disebabkan oleh pengaturan browser atau ekstensi seperti AdBlock.</p>
                                        <a href="/file-content-ukurkerja/${encodeURIComponent(filename)}" class="btn btn-primary" download="${filename}">
                                            <i class="fas fa-download"></i> Unduh PDF
                                        </a>
                                    </div>
                                </div>
                            `;
                            
                            pdfLoading.style.display = 'none';
                            return false;
                        }
                    }
                }
            };
            
            // Handler for preview buttons
            previewButtons.forEach(button => {
                button.addEventListener('click', async function () {
                    const filename = this.getAttribute('data-file');
                    const title = this.getAttribute('data-title');
                    const downloadUrl = this.getAttribute('data-download-url'); // ← ambil dari data attribute baru

                    previewModalLabel.textContent = `Preview: ${title}`;

                    // Set tombol download ke file watermark
                    if (downloadUrl) {
                        downloadBtn.setAttribute('href', downloadUrl);
                        const downloadFilename = downloadUrl.split('/').pop();
                        downloadBtn.setAttribute('download', downloadFilename);
                    } else {
                        // fallback jika data-download-url tidak ada
                        downloadBtn.setAttribute('href', `/file-content-ukurkerja/${encodeURIComponent(filename)}`);
                        downloadBtn.setAttribute('download', filename);
                    }

                    // Reset tampilan awal modal
                    errorDiv.innerHTML = '';
                    errorDiv.style.display = 'none';
                    pdfContainer.innerHTML = '';
                    pdfCanvas.style.display = 'none';
                    pdfLoading.style.display = 'block';

                    try {
                        // Check if file exists
                        const debugResponse = await fetch(`/debug-file-ukurkerja/${encodeURIComponent(filename)}`);

                        if (!debugResponse.ok) {
                            throw new Error(`Server returned ${debugResponse.status}: ${debugResponse.statusText}`);
                        }

                        const contentType = debugResponse.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Debug endpoint did not return JSON. Check if the route is properly defined.');
                        }

                        const debugInfo = await debugResponse.json();

                        if (!debugInfo.file_exists) {
                            errorDiv.innerHTML = `
                                <div class="alert alert-warning">
                                    <strong>File tidak ditemukan di server.</strong><br>
                                </div>
                            `;
                            errorDiv.style.display = 'block';
                            pdfLoading.style.display = 'none';
                            return;
                        }

                        // Load PDF original
                        await loadPdf(filename);
                        pdfLoading.style.display = 'none';

                    } catch (error) {
                        pdfLoading.style.display = 'none';
                        errorDiv.innerHTML = `
                            <div class="alert alert-danger">
                                <strong>Gagal memuat dokumen</strong><br>
                                Error: ${error.message || 'Unknown error'}<br>
                                <hr>
                                <p>Silakan coba cara berikut:</p>
                                <ul class="text-start">
                                    <li>Gunakan tombol download untuk membuka dokumen secara langsung</li>
                                    <li>Refresh halaman dan coba lagi</li>
                                </ul>
                            </div>
                        `;
                        errorDiv.style.display = 'block';
                        console.error('Error loading PDF:', error);
                    }
                });
            });


            const searchInput = document.getElementById('searchInput');
            const tahunFilter = document.getElementById('tahunFilter');
            const sortOrder = document.getElementById('sortOrder');
            const tableBody = document.getElementById('ukurkerjaTableBody');

            // Simpan semua baris asli sekali saja
            const allRows = Array.from(tableBody.querySelectorAll('tr.ukurkerja-item'));

            function filterAndSortTable() {
                const keyword = searchInput.value.toLowerCase();
                const selectedYear = tahunFilter.value;
                const sortBy = sortOrder.value;

                // Filter dari data asli, bukan dari DOM yang sudah termodifikasi
                let rows = allRows.filter(row => {
                    const rowYear = row.dataset.year;
                    const rowTitle = row.dataset.title.toLowerCase();
                    return (
                        (selectedYear === '' || rowYear === selectedYear) &&
                        (keyword === '' || rowTitle.includes(keyword))
                    );
                });

                // Sort
                rows.sort((a, b) => {
                    const titleA = a.dataset.title.toLowerCase();
                    const titleB = b.dataset.title.toLowerCase();
                    const yearA = parseInt(a.dataset.year);
                    const yearB = parseInt(b.dataset.year);

                    switch (sortBy) {
                        case 'newest':
                            return yearB - yearA;
                        case 'oldest':
                            return yearA - yearB;
                        case 'title':
                            return titleA.localeCompare(titleB);
                        case 'title-desc':
                            return titleB.localeCompare(titleA);
                        default:
                            return 0;
                    }
                });

                // Render ulang
                if (rows.length === 0) {
                    tableBody.innerHTML = `
                        <tr class="empty-row">
                            <td colspan="4" class="empty-cell">
                                <div class="empty-state">
                                    <i class="fas fa-search empty-icon"></i>
                                    <p class="empty-text">Tidak ada data Indikator Kinerja Utama yang sesuai dengan filter</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                const fragment = document.createDocumentFragment();
                rows.forEach((row, index) => {
                    row.querySelector('.item-number .row-number').textContent = index + 1;
                    fragment.appendChild(row);
                });

                tableBody.innerHTML = '';
                tableBody.appendChild(fragment);
            }

            [searchInput, tahunFilter, sortOrder].forEach(el => {
                el.addEventListener('input', filterAndSortTable);
                el.addEventListener('change', filterAndSortTable);
            });

        });
    </script>
@endsection