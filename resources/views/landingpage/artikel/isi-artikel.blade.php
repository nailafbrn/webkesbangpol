@extends('landingpage.layouts.app')
@section('title', 'Baca Artikel')
    <link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}">
@section('content')
<div class="back-to-home">
    <a href="{{ route('beranda') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        <span class="label-text">Kembali ke Beranda</span>
    </a>
</div>

<div class="container-article">
    <!-- KONTEN ARTIKEL -->
    <div class="article-main">
        <div class="article-wrapper">
            <div class="article-image">
                <img src="{{ asset('images/posts/' . $post->image) }}" alt="{{ $post->title }}">
            </div>

            <div class="article-content-wrapper">
                <div class="article-category">{{ $post->bidang->nama_bidang }}</div>
                
                <h1 class="article-title">{{ $post->title }}</h1>
                
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-tag"></i>
                        <span>{{ $post->bidang->nama_bidang }}</span>
                    </div>
                </div>

                <div class="article-content">
                    {!! $post->content !!}
                </div>

                <!-- Tombol Share -->
                <div class="article-share" style="background: #ffff">
                    <h3 class="share-title">
                        <i class="fas fa-share-alt"></i>
                        Bagikan Artikel Ini
                    </h3>
                    <div class="share-options">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                            target="_blank" class="share-icon facebook" title="Bagikan ke Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" 
                            target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" 
                            target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode('Saya ingin berbagi artikel menarik ini: ' . request()->fullUrl()) }}" 
                            class="share-icon email" title="Bagikan via Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="copyToClipboard()" 
                            class="share-icon copy" title="Salin Link">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR ARTIKEL LAINNYA -->
    <aside class="article-sidebar">
        <h4>Artikel Terkait</h4>
        <div class="sidebar-box">
            @foreach($latestPosts as $item)
                <a href="{{ route('isi-artikel', $item->slug) }}" class="sidebar-article-link">
                    <div class="sidebar-article">
                        <!-- Gambar -->
                        <div class="sidebar-thumb">
                            <img src="{{ asset('images/posts/' . $item->image) }}" alt="{{ $item->title }}">
                        </div>

                        <!-- Info -->
                        <div class="sidebar-info">
                            <h5 class="sidebar-title">
                                {{ Str::limit($item->title, 65) }}
                            </h5>
                            <div class="sidebar-meta">
                                <span class="sidebar-date">
                                    {{ $item->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span class="sidebar-category">
                                    {{ $item->bidang->nama_bidang }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <a href="{{ route('semua-artikel') }}" class="lihat-semua-artikel-isi-artikel-btn">
            <span>Lihat Semua Artikel</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </aside>
</div>

<!-- Toast Notification -->
<div id="copyToast" class="copy-toast hidden">
    <i class="fas fa-check-circle"></i>
    Link berhasil disalin!
</div>

<script>
    function copyToClipboard() {
        // Modern clipboard API
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

    // Smooth scroll untuk anchor links
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

    // Reading progress indicator (optional)
    function updateReadingProgress() {
        const article = document.querySelector('.article-content');
        if (!article) return;

        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        const progress = Math.min(100, Math.max(0, 
            ((scrollTop - articleTop + windowHeight) / articleHeight) * 100
        ));
        
        // You can use this progress value to update a progress bar
        document.documentElement.style.setProperty('--reading-progress', progress + '%');
    }

    window.addEventListener('scroll', updateReadingProgress);
    updateReadingProgress(); // Initial call
</script>
@endsection