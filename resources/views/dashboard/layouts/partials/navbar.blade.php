<nav class="dashboard-navbar d-flex justify-content-between align-items-center px-3">
    <div class="d-flex align-items-center gap-3">
        <button id="sidebarToggle" class="btn btn-dark">
            <i class="fas fa-bars" style="font-size: 1rem"></i>
        </button>
    </div>

    <div class="d-flex align-items-center gap-2">
        <form class="navbar-search collapsed" role="search">
            <input type="text" class="dashboard-navbar-search-input" placeholder="Search...">
            <button type="button" class="dashboard-navbar-search-btn toggle-search">
                <i class="fas fa-search"></i>
            </button>
        </form>



        {{-- Fullscreen --}}
        <button class="btn btn-md" onclick="toggleFullscreen()" style="color: #D6D6D6">
            <i class="fas fa-expand-arrows-alt" style="font-size: 1rem"></i>
        </button>

        {{-- User --}}
        @auth
        <div class="dashboard-user-dropdown">
            <button class="dashboard-user-btn">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
            </button>
            <ul class="dashboard-user-menu">
                <li>
                    <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
        
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar toggle
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const wrapper = document.querySelector('.main-wrapper');

        if (toggleBtn && sidebar && wrapper) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                wrapper.classList.toggle('expanded');
            });
        }

        // Inisialisasi dropdown Bootstrap
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(function (el) {
            new bootstrap.Dropdown(el);
        });
    });

    // Fungsi untuk toggle fullscreen
    function toggleFullscreen() {
        const doc = document.documentElement; // Ambil elemen root (html)
        
        // Cek apakah browser mendukung fullscreen API
        if (!document.fullscreenElement &&   // Jika tidak ada elemen fullscreen
            !document.webkitFullscreenElement && // Untuk Safari
            !document.mozFullScreenElement && // Untuk Firefox
            !document.msFullscreenElement) { // Untuk IE/Edge

            // Masukkan elemen dalam mode fullscreen
            if (doc.requestFullscreen) {
                doc.requestFullscreen();
            } else if (doc.webkitRequestFullscreen) { // Untuk Safari
                doc.webkitRequestFullscreen();
            } else if (doc.mozRequestFullScreen) { // Untuk Firefox
                doc.mozRequestFullScreen();
            } else if (doc.msRequestFullscreen) { // Untuk IE/Edge
                doc.msRequestFullscreen();
            }
        } else {
            // Keluar dari fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { // Untuk Safari
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) { // Untuk Firefox
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) { // Untuk IE/Edge
                document.msExitFullscreen();
            }
        }
    }


    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.querySelector('.navbar-search');
        const toggleBtn = document.querySelector('.toggle-search');
        const inputField = searchForm.querySelector('.dashboard-navbar-search-input');

        toggleBtn.addEventListener('click', function () {
            searchForm.classList.toggle('expanded');
            inputField.focus();
        });

        // Auto-collapse saat klik di luar
        document.addEventListener('click', function (e) {
            if (!searchForm.contains(e.target)) {
                searchForm.classList.remove('expanded');
            }
        });
    });
</script>


