<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container-fluid px-0">
    <div class="d-flex align-items-center ms-5 ps-5">
        <a class="navbar-brand d-flex align-items-center me-2" href="/" onkeyup="fetchData()">
        <img src="{{ asset('images/component/logo3.png') }}" alt="Logo" class="img-fluid">
        <img src="{{ asset('images/component/logo1-2.png') }}" alt="Logo" class="img-fluid">
        </a>
        <div class="navbar-title text-left fw-bold">
          <div class="ms-1">BADAN KESATUAN BANGSA DAN POLITIK</div>
          <div class="ms-1">KOTA BANDUNG</div>
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarNav" class="collapse navbar-collapse justify-content-center">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Beranda</a>
        </li>

        <!-- Profil -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#">Profil</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('tampilvisimisi') }}">Visi Misi</a></li>
            <li><a class="dropdown-item" href="{{ route('tampiltugasfungsi') }}">Tugas dan Fungsi</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilstruktur') }}">Struktur Organisasi</a></li>
            <li class="dropdown-submenu dropend-left">
              <a class="dropdown-item" href="/articles">Artikel &raquo;</a>
              <ul class="submenu dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('semua-artikel')}}">Semua Artikel</a></li>
                <li><a class="dropdown-item" href="{{ route('semua-artikel', ['bidang_id' => 1]) }}">Bidang 1 (Ideologi, Wawasan Kebangsaan dan Karakter Bangsa)</a></li>
                <li><a class="dropdown-item" href="{{ route('semua-artikel', ['bidang_id' => 2]) }}">Bidang 2 (Politik Dalam Negeri)</a></li>
                <li><a class="dropdown-item" href="{{ route('semua-artikel', ['bidang_id' => 3]) }}">Bidang 3 (Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Ormas)</a></li>
                <li><a class="dropdown-item" href="{{ route('semua-artikel', ['bidang_id' => 4]) }}">Bidang 4 (Kewaspadaan Nasional dan Penanganan Konflik)</a></li>
              </ul>
            </li>
            <li><a class="dropdown-item" href="{{ route('tampildasarhukum') }}">Landasan Hukum</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilprogram') }}">Program dan Kegiatan</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilsejarah') }}">Sejarah</a></li>
          </ul>
        </li>

        <!-- Sakib -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#">SAKIP</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('tampiliku') }}">Indikator Kinerja Utama</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilrenja') }}">RENJA</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilrenstra') }}">RENSTRA</a></li>
            <li><a class="dropdown-item" href="{{ route('tampilukurkerja') }}">Pengukuran Kerja</a></li>
            <li><a class="dropdown-item" href="{{ route('tampillakip') }}">Laporan AKIP</a></li>
          </ul>
        </li>

        <!-- Mitra -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#">Mitra</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">FORKOPIMDA</a></li>
            <li><a class="dropdown-item" href="#">KPU</a></li>
            <li><a class="dropdown-item" href="#">BAWASLU</a></li>
            <li><a class="dropdown-item" href="#">BNN</a></li>
            <li><a class="dropdown-item" href="#">Partai Politik</a></li>
            <li><a class="dropdown-item" href="#">FKDM</a></li>
            <li><a class="dropdown-item" href="#">FKUB</a></li>
            <li><a class="dropdown-item" href="#">FPK</a></li>
          </ul>
        </li>

        <!-- Pelayanan -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#">Pelayanan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('maintenance') }}">Pendaftaran Ormas</a></li>
            <li><a class="dropdown-item" href="https://layanan.bandung.go.id">Simpel Sakti</a></li>
          </ul>
        </li>

        <!-- Informasi -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#">Informasi</a>
          <ul class="dropdown-menu">

            <li><a class="dropdown-item" href="#">Pemilukada</a></li>
            <li><a class="dropdown-item" href="{{ route('tampil-data-ormas') }}">Data Ormas</a></li>
            <li class="dropdown-submenu dropend-left">
              <a class="dropdown-item" href="#">Data Statistik &raquo;</a>
              <ul class="submenu dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('tampil-jumlah-potensi-konflik') }}">Jumlah Potensi Konflik Kota Bandung</a></li>
              </ul>
            </li>
            
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<script>
  /**
   * DROPDOWN & SUBMENU HANDLING - FIXED VERSION
   */
  
  // Global variables to track state
  let isInitialized = false;
  let currentActiveDropdown = null;
  let currentActiveSubmenu = null;

  function clearAllEventListeners() {
    // Remove existing event listeners by replacing elements
    document.querySelectorAll('.navbar-nav .dropdown > a, .dropdown-submenu > a').forEach(function(el) {
      const newEl = el.cloneNode(true);
      el.parentNode.replaceChild(newEl, el);
    });
  }

  function closeAllDropdowns() {
    document.querySelectorAll('.navbar-nav .dropdown-menu').forEach(function(menu) {
      menu.style.display = 'none';
    });
    currentActiveDropdown = null;
  }

  function closeAllSubmenus() {
    document.querySelectorAll('.dropdown-submenu .submenu').forEach(function(menu) {
      menu.style.display = 'none';
    });
    currentActiveSubmenu = null;
  }

function closeAllNavMenus() {
  document.querySelectorAll('.navbar-nav .dropdown-menu').forEach(function(menu) {
    menu.style.display = 'none';
  });
  currentActiveDropdown = null;
  
  document.querySelectorAll('.dropdown-submenu .submenu').forEach(function(menu) {
    menu.style.display = 'none';
  });
  currentActiveSubmenu = null;
}


  function handleDropdownMenus() {
    // Prevent multiple initializations
    if (isInitialized) {
      return;
    }

    const isMobile = window.innerWidth < 992;
    
    // Clear previous event listeners
    clearAllEventListeners();

    // Handle main dropdown menus
    document.querySelectorAll('.navbar-nav .dropdown > a').forEach(function(el) {
      // Ensure href is set properly
      if (el.getAttribute('href') === '#' || !el.getAttribute('href')) {
        el.setAttribute('href', 'javascript:void(0)');
      }

      if (isMobile) {
        // Mobile: Click to toggle
        el.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          const dropdownMenu = this.nextElementSibling;
          const isCurrentlyOpen = dropdownMenu.style.display === 'block';

          // Close all other dropdowns
          closeAllDropdowns();
          closeAllSubmenus();

          // Toggle current dropdown
          if (!isCurrentlyOpen) {
            dropdownMenu.style.display = 'block';
            currentActiveDropdown = dropdownMenu;
          }
        });
      } else {
        // Desktop: Hover and click
        const parentLi = el.parentElement;
        
        // Hover events
        parentLi.addEventListener('mouseenter', function() {
          closeAllDropdowns();
          closeAllSubmenus();
          const dropdownMenu = this.querySelector('.dropdown-menu');
          dropdownMenu.style.display = 'block';
          currentActiveDropdown = dropdownMenu;
        });
        
        parentLi.addEventListener('mouseleave', function() {
          const dropdownMenu = this.querySelector('.dropdown-menu');
          dropdownMenu.style.display = 'none';
          if (currentActiveDropdown === dropdownMenu) {
            currentActiveDropdown = null;
          }
        });

        // Click events
        el.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          const dropdownMenu = this.nextElementSibling;
          const isCurrentlyOpen = dropdownMenu.style.display === 'block';

          closeAllDropdowns();
          closeAllSubmenus();

          if (!isCurrentlyOpen) {
            dropdownMenu.style.display = 'block';
            currentActiveDropdown = dropdownMenu;
          }
        });
      }
    });

    // Handle submenu items
    document.querySelectorAll('.dropdown-submenu > a').forEach(function(el) {
      // Ensure href is set properly
      if (el.getAttribute('href') === '#' || !el.getAttribute('href')) {
        el.setAttribute('href', 'javascript:void(0)');
      }

      // Click events for submenu
      el.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const submenu = this.nextElementSibling;
        const isCurrentlyOpen = submenu.style.display === 'block';

        // Close all other submenus
        closeAllSubmenus();

        // Toggle current submenu
        if (!isCurrentlyOpen) {
          submenu.style.display = 'block';
          currentActiveSubmenu = submenu;
        }
      });

      if (!isMobile) {
        // Desktop hover for submenu
        const parentLi = el.parentElement;
        
        parentLi.addEventListener('mouseenter', function() {
          closeAllSubmenus();
          const submenu = this.querySelector('.submenu');
          submenu.style.display = 'block';
          currentActiveSubmenu = submenu;
        });
        
        parentLi.addEventListener('mouseleave', function() {
          const submenu = this.querySelector('.submenu');
          submenu.style.display = 'none';
          if (currentActiveSubmenu === submenu) {
            currentActiveSubmenu = null;
          }
        });
      }
    });

    isInitialized = true;
  }

  /**
   * INITIALIZATION
   */
  document.addEventListener('DOMContentLoaded', function() {
    handleDropdownMenus();

    // Handle window resize
    window.addEventListener('resize', function() {
      // Reset initialization flag and reinitialize
      isInitialized = false;
      closeAllDropdowns();
      closeAllSubmenus();
      
      // Delay reinitializing to ensure proper rendering
      setTimeout(function() {
        handleDropdownMenus();
      }, 100);
    });
  });

  /**
   * CLOSE DROPDOWNS WHEN CLICKING OUTSIDE
   */
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.navbar')) {
      closeAllDropdowns();
      closeAllSubmenus();
    }
  });

  /**
   * HANDLE NAVBAR TOGGLER
   */
document.addEventListener('DOMContentLoaded', function() {
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('#navbarNav');
  
  if (navbarToggler && navbarCollapse) {
    // Hapus semua event listener Bootstrap dari toggler
    navbarToggler.removeAttribute('data-bs-toggle');
    navbarToggler.removeAttribute('data-bs-target');
    
    // Buat event listener custom
    navbarToggler.addEventListener('click', function(e) {
      e.preventDefault();
      
      if (navbarCollapse.classList.contains('show')) {
        // Jika terbuka, tutup semuanya
        navbarCollapse.classList.remove('show');
        navbarToggler.classList.add('collapsed');
        navbarToggler.setAttribute('aria-expanded', 'false');
        closeAllNavMenus();
      } else {
        // Jika tertutup, buka
        navbarCollapse.classList.add('show');
        navbarToggler.classList.remove('collapsed');
        navbarToggler.setAttribute('aria-expanded', 'true');
      }
    });
  }
});

  /**
   * SCROLL TO TOP BUTTON
   */
  document.addEventListener('DOMContentLoaded', function() {
    const scrollTopBtn = document.querySelector('.scroll-top-btn');
    if (scrollTopBtn) {
      window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
          scrollTopBtn.style.display = 'flex';
        } else {
          scrollTopBtn.style.display = 'none';
        }
      });

      scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    }
  });
</script>