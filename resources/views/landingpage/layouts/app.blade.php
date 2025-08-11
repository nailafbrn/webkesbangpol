<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/component/logoremovebg2.png') }}" type="image/png" />

    <title>
        @hasSection('title')
            @yield('title') - Badan Kesatuan Bangsa dan Politik Kota Bandung
        @else
            Bakesbangpol Kota Bandung
        @endif
    </title>

    {{-- Tempat tambahan CSS dari blade lain --}}
    @stack('styles')

    <style>
        html, body {
            /* overflow-y: hidden !important; */
        }
        body, .main-wrapper, .main-content {
            background: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
              Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        /* Contoh styling untuk gambar responsif */
        img.responsive-photo {
            max-width: 200px;
            height: auto;
            display: block;
            border-radius: 8px;
        }

        /* Scroll to top button style */
        .scroll-top-btn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 9999;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: none; /* default hidden */
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        .scroll-top-btn:hover {
            background-color: #0056b3;
        }

        /* Loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        .loading-spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
</head>
<body>
    <div id="app" class="main-wrapper">
        {{-- Header --}}
        @include('landingpage.shared.header')

        {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('landingpage.shared.footer')
    </div>

    {{-- Overlay loading --}}
    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    {{-- Scroll to top button --}}
    <button id="scrollTopBtn" class="scroll-top-btn" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- Tempat tambahan JS dari blade lain --}}
    @stack('scripts')

    {{-- Scroll to top button script --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const scrollBtn = document.getElementById('scrollTopBtn');

        // Show button after scroll down 200px
        window.addEventListener('scroll', () => {
          if (window.scrollY > 200) {
            scrollBtn.style.display = 'block';
          } else {
            scrollBtn.style.display = 'none';
          }
        });

        // Scroll to top on click
        scrollBtn.addEventListener('click', () => {
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      });
    </script>
</body>
</html>
