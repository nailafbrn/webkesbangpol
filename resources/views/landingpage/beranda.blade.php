    @extends('landingpage.layouts.app')
    @section('title', 'Halaman Beranda')
    @section('content')
        <!-- ========================== Hero Section ======================================================================================= -->
        <section  class="hero">
            <!-- Floating Elements for Background -->
            <div class="floating-elements">
                <div class="float-element float-1"></div>
                <div class="float-element float-2"></div>
                <div class="float-element float-3"></div>
                <div class="float-element float-4"></div>
            </div>
            
            <div class="hero-container">
                <!-- Hero Content -->
                <div class="hero-content">
                    <h2 class="display-5 fw-light fade-in" id="welcome-text">PUSAT INFORMASI DAN PELAYANAN</h2>
                    <h1 class="fw-bold fade-in" id="title">BADAN KESATUAN BANGSA DAN POLITIK</h1>
                    <h1 class="fw-bold fade-in" id="title">KOTA BANDUNG</h1>
                    <p class="lead fade-in" id="description">Menyajikan Informasi Terbaru dan Artikel Inspiratif untuk Mendukung Pemahaman Kebangsaan Anda</p>
                    
                    <div class="divider fade-in"></div>
                    
                    <form action="{{ route('semua-artikel') }}" method="GET" class="search-form fade-in" id="search-group">
                        <div class="search-input-wrapper">
                            <input id="search-text" name="search" class="form-control" placeholder="Cari Artikel Terkini..." autocomplete="off">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        

        <!-- ========================== Carousel ============================================================================================ -->
        <div class="carousel-section" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
            <div class="swiper mySwiperCarousel">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                        <div class="swiper-slide position-relative">
                            <img 
                                src="{{ asset('images/banner/' . $banner->gambar_upload) }}" 
                                class="d-block w-100" 
                                alt="{{ $banner->judul }}"
                            >
                            <div class="carousel-caption text-center text-white custom-caption-center">
                                <h5>{{ $banner->judul }}</h5>
                                <p>{{ $banner->caption }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigasi -->
                <div class="swiper-button-prev custom-swiper-button">
                    <i class="fa-solid fa-angle-left"></i>
                </div>
                <div class="swiper-button-next custom-swiper-button">
                    <i class="fa-solid fa-angle-right"></i>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>


        <!-- ========================== Articles Section ===================================================================================================================== -->
        <section class="artikel-highlight py-5">
            <div class="container">
                <div class="text-center mb-5" id="judul-section-article" data-aos="fade-up" data-aos-delay="0" data-aos-duration="800">
                    <h2 class="fw-bold">Berita dan Artikel</h2>
                    <p>Temukan informasi terkini seputar kebijakan, kegiatan, dan berita menarik lainnya dari Bakesbangpol Kota Bandung.</p>
                </div>

                <div class="row gx-5 artikel-custom-layout">
                    {{-- Artikel Utama --}}
                    <div class="col-lg-7 col-md-12" id="artikel-utama-section" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                        <div class="artikel-highlight-box">
                            {{-- Bagian Swiper Artikel Utama --}}
                            <div class="swiper artikelSwiper">
                                <div class="swiper-wrapper" id="artikel-swiper-wrapper">
                                    <!-- Artikel utama akan dimasukkan dengan JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- List Artikel Terbaru --}}
                    <div class="col-lg-5 col-md-12" id="list-artikel-section" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                        <div class="list-artikel-wrapper">
                            <h5 class="fw-bold mb-3">Artikel Terbaru</h5>
                            <hr>
                            <div class="artikel-list-container" id="list-artikel-container">
                                <!-- Artikel terbaru akan dimasukkan dengan JS -->
                            </div>
                            <div class="text-center">
                                <a href="/articles" class="lihat-semua-artikel-btn">
                                    Lihat Semua Artikel <i class="fa-solid fa-circle-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========================== Layanan Section ===================================================================================================================== -->
        <section class="py-5 bg-white" id="layanan-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left side: Section title and subtitle -->
                    <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="400" data-aos-duration="800">
                        <div class="section-header position-sticky" style="top: 100px;">
                            <h2 class="fw-bold display-5 mb-3">Pelayanan Kami</h2>
                            <p class="text-muted fs-5">Layanan unggulan yang dapat diakses oleh masyarakat</p>
                        </div>
                    </div>
                    
                    <!-- Right side: Service boxes -->
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <!-- Box 1 -->
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500" data-aos-duration="600">
                                <div class="layanan-box">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="icon-circle me-3" data-aos="zoom-in" data-aos-delay="500">
                                            <i class="fas fa-landmark"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Profil Badan</h5>
                                    </div>
                                    <p class="text-muted">Menyajikan informasi mengenai struktur organisasi, tugas pokok, fungsi, dan visi-misi Badan.</p>
                                    <div class="text-end mt-3">
                                        <a href="{{ route('tampilmenuprofile') }}" class="layanan-link">
                                            Selengkapnya 
                                            <span class="icon-wrapper">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Box 2 -->
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="600" data-aos-duration="600">
                                <div class="layanan-box">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="icon-circle me-3" data-aos="zoom-in" data-aos-delay="600">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Simple Sakti</h5>
                                    </div>
                                    <p class="text-muted">Sistem pelaporan situasi keamanan dan ketertiban wilayah Kota Bandung secara digital.</p>
                                    <div class="text-end mt-3">
                                        <a href="https://layanan.bandung.go.id" target="_blank" class="layanan-link">
                                            Selengkapnya 
                                            <span class="icon-wrapper">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Box 3 -->
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="700" data-aos-duration="600">
                                <div class="layanan-box">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="icon-circle me-3" data-aos="zoom-in" data-aos-delay="700">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Dokumen dan Regulasi</h5>
                                    </div>
                                    <p class="text-muted">Mengakses dokumen perencanaan strategis serta laporan evaluasi dan pengukuran kinerja Badan.</p>
                                    <div class="text-end mt-3">
                                        <a href="{{ route('tampilmenusakip') }}" class="layanan-link">
                                            Selengkapnya 
                                            <span class="icon-wrapper">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Box 4 (Added as example, you can remove if not needed) -->
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="800" data-aos-duration="600">
                                <div class="layanan-box">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="icon-circle me-3" data-aos="zoom-in" data-aos-delay="800">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">Data Organisasi Masyarakat</h5>
                                    </div>
                                    <p class="text-muted">Menampilkan informasi dan rekapitulasi data organisasi kemasyarakatan yang terdaftar.</p>
                                    <div class="text-end mt-3">
                                        <a href="{{ route('tampil-data-ormas') }}" class="layanan-link">
                                            Selengkapnya 
                                            <span class="icon-wrapper">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========================== Galeri Kegiatan Section ========================== -->
        <section class="galeri-section">
            <div class="galeri-header" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                <span class="section-tag">Dokumentasi</span>
                <h2 class="judul-galeri">Galeri Kegiatan</h2>
                <p class="desc-galeri">Dokumentasi kegiatan dan penghargaan di Bakesbangpol Kota Bandung</p>
            </div>
            
            <div class="galeri-container" id="galeri-box" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                @foreach ($galeris as $item)
                    <a href="{{ asset('images/gallery/' . $item->gambar_upload) }}"
                        data-fancybox="gallery"
                        class="galeri-item {{ $loop->index > 2 ? 'hidden' : '' }}">
                        <div class="galeri-card">
                            <div class="image-container">
                                <img src="{{ asset('images/gallery/' . $item->gambar_upload) }}"
                                    alt="{{ $item->judul }}">
                                <div class="overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="image-caption">
                                <h4>{{ $item->judul }}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($galeris->count() > 3)
            <div class="lihat-lebih-container" data-aos="fade-up" data-aos-delay="300">
                <button id="lihat-lebih-btn">
                    <span>Lihat Gambar Lainnya</span>
                    <div class="btn-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </button>
            </div>
            @endif
        </section>



        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Ambil data artikel dari Blade
                const allPosts = @json($posts);
        
                // Urutkan berdasarkan created_at DESC
                const sortedPosts = allPosts.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        
                // Ambil 5 artikel terbaru
                const artikelUtama = sortedPosts.slice(0, 5);
        
                const formatDate = (dateStr) => {
                    const date = new Date(dateStr);
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return date.toLocaleDateString('id-ID', options); // Format: 17 April 2025
                };
        
                // Render artikel utama (max 3 di swiper)
                const swiperWrapper = document.getElementById('artikel-swiper-wrapper');
                artikelUtama.slice(0, 3).forEach(post => {
                    
                    const truncatedContent = post.content.length > 180 ? post.content.substring(0, 180) + '...' : post.content;
                    swiperWrapper.innerHTML += `
                        <div class="swiper-slide">
                            <div class="card artikel-card">
                                <img src="/images/posts/${post.image}" alt="Gambar Artikel" />
                                <div class="card-overlay">
                                    <span class="badge mb-2">BIDANG ${post.bidang.no_bidang}</span>
                                    <h5 class="card-title">${post.title}</h5>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="card-date">${formatDate(post.created_at)}</small>
                                        <a href="/artikel/${post.slug}" class="artikel-action-btn">
                                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
        
                // Render list artikel terbaru (semua)
                const listContainer = document.getElementById('list-artikel-container');
                sortedPosts.forEach(post => {
                    listContainer.innerHTML += `
                        <a href="/artikel/${post.slug}" class="artikel-item-link">
                            <div class="artikel-item">
                                <span class="artikel-item-title">${post.title}</span>
                                <span class="artikel-item-date">${formatDate(post.created_at)}</span>
                            </div>
                        </a>
                    `;
                });
        
                // Update Swiper jika diperlukan
                if (window.artikelSwiper) window.artikelSwiper.update();
            });


            document.getElementById('lihat-lebih-btn')?.addEventListener('click', function() {
                const hiddenItems = document.querySelectorAll('.galeri-item.hidden');
                hiddenItems.forEach(item => item.classList.remove('hidden'));
                this.style.display = 'none';
            });
        </script>
        
    @endsection


