<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/component/logoremovebg2.png') }}" type="image/png">
    <title>
      @hasSection('title')
          @yield('title') - Badan Kesatuan Bangsa dan Politik Kota Bandung
      @else
          Bakesbangpol Kota Bandung 
      @endif
  </title>

  <style>
    html, body{
      /* overflow-y: hidden !important; */
    }
    body, .main-wrapper, .main-content {
        background: transparent !important; /* atau sesuai background hero */
        margin: 0 !important;
        padding: 0 !important;
        
    }
  </style>
  </head>

  <body>
  	<div id="app" class="main-wrapper">
  			@include('landingpage.shared.header')
	  		<div class="main-content">
	  			@yield('content')
	  		</div>
	  		@include('landingpage.shared.footer')
		</div>
    <!-- Overlay loading -->
    <div id="loading-overlay">
      <div class="loading-spinner"></div>
    </div>
    <button id="scrollTopBtn" class="scroll-top-btn" title="Kembali ke atas">
      <i class="fas fa-arrow-up"></i>
    </button>
  

  </body>
</html>