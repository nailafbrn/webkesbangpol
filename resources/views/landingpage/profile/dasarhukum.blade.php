@extends('landingpage.layouts.app')
@section('title', 'Dasar Hukum')
    <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">

@section('content')
    <!-- Hero Section -->
    <section class="visimisi-hero">
        <div class="floating-elements">
            <div class="float-element float-1"></div>
            <div class="float-element float-2"></div>
            <div class="float-element float-3"></div>
            <div class="float-element float-4"></div>
        </div>
        <div class="visimisi-hero-overlay"></div>
        <div class="visimisi-hero-content">
            <div class="hero-badge">Law Reference</div>
            <h1 class="visimisi-title">LANDASAN HUKUM</h1>
            <p class="visimisi-subtitle">Badan Kesatuan Bangsa dan Politik Kota Bandung</p>

        </div>
        <div class="hero-shape"></div>
    </section>
        
    <!-- Main Content Section -->
    <section class="dasarhukum-section">
      <div class="container py-5">
        <div class="row justify-content-center mb-3">

          <!-- Gabungkan Sort & Search dalam satu container -->
          <div class="row justify-content-center mb-5">
            <div class="col-md-10">
              <div class="combined-filter-search">
                <!-- Sort/Filter -->
                <div class="filter-container d-flex flex-wrap gap-2">
                  <select class="form-select" id="bidangFilter" onchange="filterByBidang(this.value)">
                    <option value="">Semua Bidang</option>
                    @foreach($groupedHukums as $bidangName => $hukums)
                      <option value="{{ $bidangName }}">{{ $bidangName }}</option>
                    @endforeach
                  </select>
                </div>
                
                <!-- Search -->
                <div class="search-container">
                  <input type="text" class="form-control search-input" id="searchInput" placeholder="Cari dokumen hukum..." onkeyup="filterItems(this.value)" autocomplete="off">
                  <i class="fas fa-search search-icon"></i>
                </div>
              </div>
            </div>
          </div>

        <!-- Bidang Sections -->
        @forelse($groupedHukums as $bidangName => $hukums)
          <div class="bidang-section mb-5">
            <h2 class="bidang-title">{{ $bidangName }}</h2>
            <div class="bidang-divider"></div>
            
            <!-- Hukum List -->
            <div class="hukum-list">
              @foreach($hukums as $hukum)
                <div class="hukum-item">
                  <div class="hukum-header" onclick="toggleContent(this)">
                    <div class="hukum-info">
                      <h4 class="hukum-title">{{ $hukum->jenis_peraturan_lengkap }} No. {{ $hukum->nomor_peraturan }} Tahun {{ $hukum->tahun_peraturan }}</h4>
                    </div>
                  </div>
                    <div class="hukum-content">
                      <span class="label-tentang">Tentang :</span>
                      <span class="isi-tentang">{!! $hukum->tentang !!}</span>
                    </div>
                </div>
              @endforeach
            </div>
          </div>
        @empty
          <div class="text-center py-5">
            <div class="empty-state">
              <i class="fas fa-file-alt empty-icon"></i>
              <h3 class="mt-3">Belum ada data hukum</h3>
              <p class="text-muted">Dokumen dasar hukum belum tersedia saat ini.</p>
            </div>
          </div>
        @endforelse
      </div>
    </section>

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
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Landasan Hukum Badan Kesatuan Bangsa dan Politik Kota Bandung') }}" 
                        target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Landasan Hukum Badan Kesatuan Bangsa dan Politik Kota Bandung') }}%20{{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Landasan Hukum Badan Kesatuan Bangsa dan Politik Kota Bandung') }}&body={{ urlencode('Saya ingin berbagi halaman menarik ini: ' . request()->fullUrl()) }}" 
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

    <script>
      function toggleContent(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.toggle-icon');
        const isActive = header.classList.contains('active');
        
        // Close all other open items
        document.querySelectorAll('.hukum-header').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.hukum-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.toggle-icon').forEach(el => el.textContent = '+');
        
        // Toggle current item
        if (!isActive) {
          header.classList.add('active');
          content.classList.add('active');
          icon.textContent = '−';
        }
      }
      
      function filterItems(keyword) {
        keyword = keyword.toLowerCase();
        
        // Hide/show the items
        document.querySelectorAll('.hukum-item').forEach(item => {
          const text = item.innerText.toLowerCase();
          const isVisible = text.includes(keyword);
          item.style.display = isVisible ? 'block' : 'none';
        });
        
        // Hide/show the bidang sections
        document.querySelectorAll('.bidang-section').forEach(section => {
          const hasVisibleItems = Array.from(section.querySelectorAll('.hukum-item')).some(
            item => item.style.display !== 'none'
          );
          section.style.display = hasVisibleItems ? 'block' : 'none';
        });
      }
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Smooth scroll for anchor links
          document.querySelectorAll('a[href^="#"]').forEach(anchor => {
              anchor.addEventListener('click', function(e) {
                  e.preventDefault();
                  
                  const targetId = this.getAttribute('href');
                  const targetElement = document.querySelector(targetId);
                  
                  if (targetElement) {
                      window.scrollTo({
                          top: targetElement.offsetTop - 80, // Offset for fixed header if needed
                          behavior: 'smooth'
                      });
                  }
              });
          });
      });
    </script>

    <script>
      function filterByBidang(bidangName) {
        bidangName = bidangName.toLowerCase();
        
        document.querySelectorAll('.bidang-section').forEach(section => {
          const title = section.querySelector('.bidang-title').innerText.toLowerCase();
          section.style.display = (!bidangName || title === bidangName) ? 'block' : 'none';
        });
      }
    </script>

@endsection