@extends('landingpage.layouts.app')
@section('title', 'Potensi Konflik di Kota Bandung')
    <link rel="stylesheet" href="{{ asset('assets/css/landingpage-potensikonflik.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}">
@section('content')

    <div class="dashboard-container">
        <div class="container">
            <!-- Header -->
            <div class="dashboard-header text-center">
                <h1 class="dashboard-title">Dashboard Potensi Konflik</h1>
                <p class="dashboard-subtitle">Monitoring dan Analisis Potensi Konflik di Kota Bandung</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ff6b6b, #ee5a52);">
                        📋
                    </div>
                    <div class="stat-number" id="totalKonflik">{{ count($potensiKonfliks) }}</div>
                    <div class="stat-label">Total Potensi Konflik</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4ecdc4, #44a08d);">
                        🏘️
                    </div>
                    <div class="stat-number" id="totalKecamatan">{{ count($statistikKecamatan) }}</div>
                    <div class="stat-label">Kecamatan Terlibat</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #45b7d1, #2196f3);">
                        📂
                    </div>
                    <div class="stat-number" id="totalKategori">{{ count($statistikKategori) }}</div>
                    <div class="stat-label">Kategori Konflik</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #96ceb4, #85c1a7);">
                        ⚠️
                    </div>
                    <div class="stat-number" id="konflikAktif">
                        {{ $potensiKonfliks->where('status', 'aktif')->count() }}
                    </div>
                    <div class="stat-label">Konflik Aktif</div>
                </div>
            </div>

            <!-- Year Filter -->
            <div class="top-control-bar">
                <!-- Filter Tahun -->
                <div class="year-filter-container">
                    <label for="yearFilter" class="year-filter-label">🗓️ Filter Tahun:</label>
                    <select id="yearFilter" class="year-select">
                        <option value="">Semua Tahun</option>
                        <!-- Years will be populated by JavaScript -->
                    </select>
                </div>

                <!-- Tombol Pilihan Tampilan -->
                <div class="view-selector-container">
                    <button type="button" id="btnShowMap"    class="view-btn px-4 py-2 mx-1 rounded" data-target="gis-container">Maps</button>
                    <button type="button" id="btnShowChart"  class="view-btn px-4 py-2 mx-1 rounded" data-target="chart-grid">Grafik</button>
                    <button type="button" id="btnShowTable"  class="view-btn px-4 py-2 mx-1 rounded" data-target="table-container">Tabel</button>
                </div>
            </div>


            <!-- GIS Visualization -->
            <div class="gis-container">
                <h3 class="chart-title gis-title"></h3>
                <div id="map"></div>
            </div>

            <!-- Container untuk CHART -->
            <div id="chart-grid" class="chart-grid">
                
                <!-- Dropdown chart-selector di dalam chart-grid -->
                <div class="chart-selector text-center mb-3">
                    <label for="chartPicker" class="d-block mb-1">Pilih Grafik:</label>
                    <select id="chartPicker" onchange="showChart(this.value)" class="w-auto mx-auto" style="background: #fff">
                        <option value="kategori">Kategori</option>
                        <option value="kecamatan">Kecamatan</option>
                        <option value="tingkat">Tingkat Potensi</option>
                        <option value="timeline">Perkembangan</option>
                    </select>
                </div>
                
                <!-- Chart Containers -->
                <div id="chart-kategori" class="chart-container">
                        <h3 class="chart-title chart-title-kategori"></h3>
                    <div class="chart-wrapper">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                    <p class="chart-desc" id="desc-kategori">Grafik ini menampilkan sebaran potensi konflik menurut kategori penyebabnya, seperti konflik sosial, ekonomi, budaya, dan agama. Dari grafik terlihat bahwa kategori konflik sosial mendominasi dengan persentase terbesar, diikuti oleh konflik ekonomi dan budaya. Hal ini menunjukkan bahwa masalah sosial menjadi penyebab utama potensi konflik di Kota Bandung. Informasi ini penting agar pemerintah dan masyarakat dapat fokus pada penanganan isu sosial untuk mengurangi risiko konflik.</p>
                </div>
                
                <div id="chart-kecamatan" class="chart-container" style="display: none;">
                    <h3 class="chart-title chart-title-kecamatan"></h3>
                    <div class="chart-wrapper">
                        <canvas id="kecamatanChart"></canvas>
                    </div>
                    <p class="chart-desc" id="desc-kecamatan">Grafik ini memperlihatkan tingkat potensi konflik di masing-masing kecamatan di Kota Bandung. Misalnya, Kecamatan A memiliki potensi konflik tinggi, sementara Kecamatan B relatif rendah. Grafik ini membantu mengidentifikasi wilayah yang rawan konflik sehingga upaya pencegahan dan pengawasan bisa lebih terfokus. Dengan melihat grafik ini, masyarakat dan pemangku kebijakan dapat memahami kondisi keamanan di lingkungan masing-masing secara lebih jelas.</p>
                </div>
                
                <div id="chart-tingkat" class="chart-container" style="display: none;">
                    <h3 class="chart-title chart-title-level"></h3>
                    <div class="chart-wrapper">
                        <canvas id="tingkatChart"></canvas>
                    </div>
                    <p class="chart-desc" id="desc-tingkat">Grafik ini mengelompokkan potensi konflik berdasarkan tingkatannya, seperti rendah, sedang, dan tinggi. Data menunjukkan bahwa sebagian besar wilayah memiliki tingkat potensi konflik sedang, dengan beberapa wilayah berpotensi tinggi. Grafik ini memberikan gambaran umum tentang risiko konflik di Kota Bandung secara keseluruhan, sehingga dapat menjadi dasar prioritas dalam pengambilan kebijakan dan tindakan preventif.</p>
                </div>
                
                <div id="chart-timeline" class="chart-container" style="display: none;">
                    <h3 class="chart-title chart-title-tahun"></h3>
                    <div class="chart-wrapper">
                        <canvas id="timelineChart"></canvas>
                    </div>
                    <p class="chart-desc" id="desc-timeline">Grafik ini menggambarkan perubahan potensi konflik dari waktu ke waktu, misalnya dari bulan ke bulan atau tahun ke tahun. Dari grafik terlihat adanya fluktuasi, dengan peningkatan potensi konflik pada beberapa bulan tertentu dan penurunan di bulan lainnya. Tren ini penting untuk memantau dinamika konflik agar langkah antisipatif dapat dilakukan tepat waktu. Dengan memahami pola ini, pemerintah dan masyarakat dapat lebih siap menghadapi potensi konflik yang muncul.</p>
                </div>
            </div>


            <!-- Data Table -->
            <div class="table-container">
                <h3 class="chart-title table-title">📋 Data Detail Potensi Konflik di Kota Bandung</h3>
                <div style="overflow-x: auto;">
                    <table class="modern-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Nama Potensi</th>
                                <th>Kategori</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Tanggal</th>
                                <th>Tingkat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($potensiKonfliks1 as $item)
                            <tr data-year="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}">
                                <td><strong>{{ $item->nama_potensi }}</strong></td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->lokasi_kecamatan }}</td>
                                <td>{{ $item->lokasi_kelurahan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td>
                                    <span class="tingkat-badge tingkat-{{ strtolower($item->tingkat_potensi) }}">
                                        {{ $item->tingkat_potensi }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($item->status) }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    <!-- Tambahkan ini untuk pagination -->
                <div class="pagination-section">
                    {{ $potensiKonfliks1->links('components.custom-pagination') }}
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
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode('Data Potensi Konflik di Kota Bandung') }}" 
                        target="_blank" class="share-icon twitter" title="Bagikan ke Twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Data Potensi Konflik di Kota Bandung') }}%20{{ urlencode(request()->fullUrl()) }}" 
                        target="_blank" class="share-icon whatsapp" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Data Potensi Konflik di Kota Bandung') }}&body={{ urlencode('Saya ingin berbagi halaman menarik ini: ' . request()->fullUrl()) }}" 
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

    <!-- Script Charts -->
    <script>
        function showChart(chartId) {
            const allCharts = ['kategori', 'kecamatan', 'tingkat', 'timeline'];
            
            allCharts.forEach(id => {
                const chartContainer = document.getElementById(`chart-${id}`);
                if (chartContainer) {
                    chartContainer.style.display = id === chartId ? 'block' : 'none';
                }
            });

        }
    </script>

    <!-- Script Pilihan tampilan -->
    <script>
        // Tambahkan variabel untuk menyimpan currentView
        let currentView = 'table-container'; // default view

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-selector-container .view-btn');
            const containers = {
                'gis-container'   : document.querySelector('.gis-container'),
                'chart-grid'      : document.querySelector('.chart-grid'),
                'table-container' : document.querySelector('.table-container')
            };

            function showOnly(targetClass) {
                Object.keys(containers).forEach(key => {
                    containers[key].style.display = (key === targetClass) ? '' : 'none';
                });

                buttons.forEach(btn => {
                    btn.classList.toggle('active', btn.getAttribute('data-target') === targetClass);
                });

                // **PERBAIKAN: Reset filter tahun untuk SEMUA perpindahan view**
                const previousView = currentView;
                
                // Jika pindah DARI maps/chart KE tabel, atau DARI tabel KE maps/chart
                if (previousView !== targetClass) {
                    // Reset filter tahun ke default (kosong/semua data)
                    document.getElementById('yearFilter').value = '';
                    currentYear = '';
                    
                    // **TAMBAHAN: Update statistik segera setelah reset filter**
                    if (targetClass === 'table-container') {
                        // Jika pindah ke tabel, tampilkan statistik semua data dulu
                        updateTableStatistics();
                        animateNumbers();
                    } else {
                        // Jika pindah ke maps/chart, tampilkan statistik semua data
                        updateMapsChartStatistics();
                        animateNumbers();
                    }
                }
                
                // Update currentView
                currentView = targetClass;

                if (targetClass === 'gis-container' && map) {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 0);
                }

                // Simpan tampilan terakhir HANYA jika table yang dipilih
                if (targetClass === 'table-container') {
                    localStorage.setItem('lastView', 'table-container');
                } else {
                    localStorage.removeItem('lastView');
                }

                // **PERBAIKAN: Update view setelah semua reset selesai**
                if (targetClass !== 'table-container') {
                    updateCurrentView();
                }
            }

            // **PERBAIKAN: Inisialisasi view dengan reset yang tepat**
            const lastView = localStorage.getItem('lastView') === 'table-container' ? 'table-container' : 'gis-container';
            currentView = lastView;
            
            // Reset filter saat inisialisasi
            document.getElementById('yearFilter').value = '';
            currentYear = '';
            
            showOnly(lastView);

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    if (containers[target]) {
                        showOnly(target);
                    }
                });
            });
        });
    </script>

    <!-- Main Script -->
    <script>
        // INISIALISASI DATA & VARIABEL
        // Mengambil data dari server (Laravel Blade) ke JavaScript
        const potensiKonfliks = @json($potensiKonfliks);
        const statistikKategori = @json($statistikKategori);
        const statistikKecamatan = @json($statistikKecamatan);
        const statistikTingkat = @json($statistikTingkat);
        const statistikKelurahan = @json($statistikKelurahan); // NEW: Data statistik per kelurahan

        // Variabel global untuk menyimpan objek-objek utama
        let map;
        let markers = [];
        let charts = {};
        let currentYear = '';

        // NEW: Variabel untuk GeoJSON layers
        let kecamatanLayer;
        let kelurahanLayer;
        let geoJsonKecamatan;
        let geoJsonKelurahan;
        
        // Label aktif (hanya satu)
        let activeLabel = null;

        // NEW: Variabel untuk mencegah event berulang
        let isHovering = false;
        let hoverTimeout = null;
        let currentHoveredFeature = null;

        // EVENT LISTENER UTAMA
        
        // Event listener yang dijalankan ketika halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function () {
            initializeMap();        // Inisialisasi peta
            initializeYearFilter(); // Inisialisasi dropdown filter tahun
            initializeCharts();     // Inisialisasi semua chart kosong
            loadGeoJsonData(); // NEW: Load GeoJSON data
            // updateChartDescriptions(); // Update narasi deskripsi dan judul
            
            // **TAMBAHAN: Inisialisasi statistik berdasarkan view awal**
            if (currentView === 'table-container') {
                updateTableStatistics(); // Statistik terfilter untuk tabel
            } else {
                updateMapsChartStatistics(); // Statistik semua data untuk maps/chart
            }
            animateNumbers(); // Animasi untuk semua view

            // Event listener untuk perubahan filter tahun
            document.getElementById('yearFilter').addEventListener('change', function() {
                const newYear = this.value;
                const oldYear = currentYear;

                // **PERBAIKAN: Jika sedang di view table, langsung reload tanpa konfirmasi berulang**
                if (currentView === 'table-container') {
                    currentYear = newYear;
                    reloadTableWithYearFilter(newYear);
                    return; // **PENTING: Stop execution di sini untuk table**
                }

                // Untuk view lain (maps & chart), proses seperti biasa
                if (newYear !== oldYear) {
                    currentYear = newYear;
                    updateCurrentView();
                }
            });
        });

        // NEW: FUNGSI LOAD GEOJSON DATA
        async function loadGeoJsonData() {
            try {
                // Load kedua file GeoJSON secara bersamaan
                const [kecamatanResponse, kelurahanResponse] = await Promise.all([
                    fetch('/geojson-bandung-master/3273-kota-bandung-level-kecamatan.json'),
                    fetch('/geojson-bandung-master/3273-kota-bandung-level-kelurahan.json')
                ]);

                geoJsonKecamatan = await kecamatanResponse.json();
                geoJsonKelurahan = await kelurahanResponse.json();

                console.log('geoJsonKelurahan structure:', geoJsonKelurahan); // ← TAMBAH INI
                console.log('First feature:', geoJsonKelurahan.features[0]); // ← TAMBAH INI
                console.log('First feature properties:', geoJsonKelurahan.features[0].properties); // ← TAMBAH INI

                console.log('GeoJSON data loaded successfully');
                
                // Setelah data loaded, update visualisasi
                updateVisualization();
            } catch (error) {
                console.error('Error loading GeoJSON data:', error);
                // Fallback ke sistem marker lama jika GeoJSON gagal dimuat
                updateMapWithMarkers();
            }
        }

            // FUNGSI GABUNGAN UNTUK MENANGANI EVENT KELURAHAN - BARU
        function onEachKelurahanCombined(feature, layer) {
            const kelurahanName = feature.properties.nama_kelurahan;
            const kecamatanName = feature.properties.nama_kecamatan;

            // Hitung centroid polygon untuk label
            let centroid = null;
            if (feature.geometry.type === 'Polygon') {
                centroid = calculateCentroid(feature.geometry.coordinates[0]);
            } else if (feature.geometry.type === 'MultiPolygon') {
                centroid = calculateCentroid(feature.geometry.coordinates[0][0]);
            }

            // Data konflik untuk popup
            const filteredData = getFilteredData();
            const listConflict = filteredData.filter(item => item.lokasi_kelurahan === kelurahanName);
            const totalCount = listConflict.length;

            // Hitung per tingkat untuk popup
            const highCount = listConflict.filter(c => c.tingkat_potensi === 'tinggi').length;
            const mediumCount = listConflict.filter(c => c.tingkat_potensi === 'sedang').length;
            const lowCount = listConflict.filter(c => c.tingkat_potensi === 'rendah').length;

            // Buat popup content dengan enhanced styling
            let popupContent = `
                <div class="main-popup-container" style="min-width: 250px; font-family: Arial, sans-serif;">
                    <div class="popup-left-panel" style="position: relative;">
                        <h5 style="margin: 0 0 10px 0; color: #2d3748; border-bottom: 2px solid #3182ce; padding-bottom: 5px;">
                            Kelurahan ${kelurahanName}
                        </h5>
                        <p style="margin: 0 0 5px 0; color: #666; font-size: 0.9em;">Kecamatan ${kecamatanName}</p>
                        <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 1.1em; color: #2d3748;">
                            Total Konflik: <span style="color: #e53e3e;">${totalCount}</span>
                        </p>
            `;

            if (totalCount > 0) {
                popupContent += `
                    <div style="margin-bottom: 15px; padding: 10px; background: #f7fafc; border-radius: 6px;">
                        <p style="margin: 0 0 5px 0; font-size: 0.95em;">🔴 Tinggi: <strong>${highCount}</strong></p>
                        <p style="margin: 0 0 5px 0; font-size: 0.95em;">🟡 Sedang: <strong>${mediumCount}</strong></p>
                        <p style="margin: 0 0 0 0; font-size: 0.95em;">🟢 Rendah: <strong>${lowCount}</strong></p>
                    </div>
                    
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 4px;">
                        <h6 style="margin: 0; padding: 8px; background: #edf2f7; font-size: 0.9em; color: #4a5568; border-bottom: 1px solid #e2e8f0;">
                            Daftar Konflik (Klik untuk detail)
                        </h6>
                `;
                
                listConflict.forEach((conflict, index) => {
                    const priorityColor = getPriorityColor(conflict.tingkat_potensi);
                    const statusBadge = getStatusBadge(conflict.status);
                    
                    popupContent += `
                        <div class="conflict-item" 
                            data-conflict-id="${conflict.id || index}"
                            style="padding: 8px; margin: 0; background: #fff; border-bottom: 1px solid #f1f5f9; 
                                    cursor: pointer; transition: all 0.2s ease; font-size: 0.85em;
                                    border-left: 4px solid ${priorityColor};">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="flex: 1;">
                                    <strong style="color: #2d3748; display: block; margin-bottom: 2px;">
                                        ${conflict.nama_potensi}
                                    </strong>
                                    <div style="color: #666; font-size: 0.8em;">
                                        <span>📂 ${conflict.kategori}</span>
                                    </div>
                                </div>
                                <div style="margin-left: 8px;">
                                    ${statusBadge}
                                </div>
                            </div>
                            <div style="margin-top: 4px; font-size: 0.75em; color: #718096;">
                                <span>📍 ${conflict.alamat || 'Alamat tidak tersedia'}</span>
                            </div>
                        </div>
                    `;
                });
                
                popupContent += `</div>`;
            } else {
                popupContent += `
                    <div style="padding: 20px; text-align: center; color: #718096; font-style: italic;">
                        Tidak ada data konflik di kelurahan ini
                    </div>
                `;
            }

            popupContent += `
                    </div>
                    <div class="popup-detail-panel" id="detail-panel-${kelurahanName.replace(/\s+/g, '-')}" 
                        style="display: none; position: absolute; left: 100%; top: 0; 
                                width: 300px; margin-left: 10px; background: white; 
                                border: 1px solid #e2e8f0; border-radius: 6px; 
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000;">
                        <div class="detail-content" style="padding: 15px;">
                            <div style="text-align: center; padding: 20px; color: #718096;">
                                Klik item konflik untuk melihat detail
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Bind popup dengan enhanced options
            layer.bindPopup(popupContent, {
                maxWidth: 800,
                className: 'enhanced-popup'
            });

            // Event handlers
            layer.on({
                mouseover: function(e) {
                    if (currentHoveredFeature === kelurahanName || isHovering) {
                        return;
                    }

                    e.originalEvent && e.originalEvent.stopPropagation();
                    isHovering = true;
                    currentHoveredFeature = kelurahanName;

                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }

                    hoverTimeout = setTimeout(() => {
                        if (currentHoveredFeature === kelurahanName) {
                            e.target.setStyle({
                                weight: 3,
                                color: '#2563eb',
                                fillOpacity: 0.9
                            });

                            if (!isMobileDevice() && centroid) {
                                showKelurahanLabel(feature, centroid, totalCount);
                            }
                        }
                        isHovering = false;
                    }, 100);
                },

                mouseout: function(e) {
                    e.originalEvent && e.originalEvent.stopPropagation();

                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }

                    if (currentHoveredFeature === kelurahanName) {
                        currentHoveredFeature = null;
                    }
                    isHovering = false;

                    setTimeout(() => {
                        if (currentHoveredFeature !== kelurahanName) {
                            if (kelurahanLayer) {
                                kelurahanLayer.resetStyle(e.target);
                            }

                            if (!isMobileDevice()) {
                                removeActiveLabel();
                            }
                        }
                    }, 50);
                },

                click: function(e) {
                    e.originalEvent && e.originalEvent.stopPropagation();

                    if (isMobileDevice() && centroid) {
                        removeActiveLabel();
                        showKelurahanLabel(feature, centroid, totalCount);
                        
                        setTimeout(() => {
                            removeActiveLabel();
                        }, 3000);
                    }
                }
            });

            // Add event listener untuk popup setelah dibuka
            layer.on('popupopen', function(e) {
                setTimeout(() => {
                    setupConflictItemHandlers(kelurahanName, listConflict);
                }, 100);
            });
        }

        // Fungsi helper untuk mendapatkan warna berdasarkan prioritas
        function getPriorityColor(tingkat) {
            switch(tingkat?.toLowerCase()) {
                case 'tinggi': return '#FF0000';
                case 'sedang': return '#FFC800';
                case 'rendah': return '#00B400';
                default: return '#a0aec0';
            }
        }

        // Fungsi helper untuk mendapatkan badge status
        function getStatusBadge(status) {
            const statusColors = {
                'aktif': '#e53e3e',
                'monitoring': '#f6ad55',
                'selesai': '#48bb78',
                'pending': '#a0aec0'
            };
            
            const color = statusColors[status?.toLowerCase()] || '#a0aec0';
            return `<span style="background: ${color}; color: white; padding: 2px 6px; 
                            border-radius: 10px; font-size: 0.7em; font-weight: bold;">
                        ${status || 'N/A'}
                    </span>`;
        }

        // Fungsi untuk setup event handlers pada conflict items
        function setupConflictItemHandlers(kelurahanName, listConflict) {
            const conflictItems = document.querySelectorAll('.conflict-item');
            const detailPanel = document.getElementById(`detail-panel-${kelurahanName.replace(/\s+/g, '-')}`);
            
            if (!detailPanel) return;

            conflictItems.forEach((item, index) => {
                // Hover effects
                item.addEventListener('mouseenter', function() {
                    this.style.background = '#f7fafc';
                    this.style.transform = 'translateX(2px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.background = '#fff';
                    this.style.transform = 'translateX(0)';
                });

                // Click handler
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    const conflictData = listConflict[index];
                    if (!conflictData) return;

                    // Remove active class from all items
                    conflictItems.forEach(i => i.classList.remove('active-conflict'));
                    
                    // Add active class to clicked item
                    this.classList.add('active-conflict');
                    
                    // Show detail panel
                    showConflictDetail(detailPanel, conflictData);
                });
            });
        }

        // Fungsi untuk menampilkan detail konflik
        function showConflictDetail(detailPanel, conflictData) {
            const detailContent = detailPanel.querySelector('.detail-content');
            
            const priorityColor = getPriorityColor(conflictData.tingkat_potensi);
            const statusBadge = getStatusBadge(conflictData.status);
            
            detailContent.innerHTML = `
                <div style="border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 15px;">
                    <button onclick="hideConflictDetail('${detailPanel.id}')" 
                            style="float: right; background: none; border: none; 
                                font-size: 16px; cursor: pointer; color: #a0aec0;">
                        ✕
                    </button>
                    <h6 style="margin: 0; color: #2d3748; font-size: 1em;">Detail Konflik</h6>
                </div>
                
                <div style="space-y: 10px;">
                    <div style="margin-bottom: 12px;">
                        <h5 style="margin: 0 0 5px 0; color: #2d3748; font-size: 0.95em; line-height: 1.3;">
                            ${conflictData.nama_potensi}
                        </h5>
                        <div style="margin-bottom: 8px;">
                            ${statusBadge}
                        </div>
                    </div>
                    
                    <div style="background: #f7fafc; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        <div style="margin-bottom: 8px;">
                            <strong style="font-size: 0.8em; color: #4a5568;">Tingkat Potensi:</strong>
                            <div style="margin-top: 2px;">
                                <span style="background: ${priorityColor}; color: white; 
                                        padding: 2px 8px; border-radius: 12px; 
                                        font-size: 0.75em; font-weight: bold;">
                                    ${conflictData.tingkat_potensi || 'N/A'}
                                </span>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 8px;">
                            <strong style="font-size: 0.8em; color: #4a5568;">Kategori:</strong>
                            <p style="margin: 2px 0 0 0; font-size: 0.85em; color: #2d3748;">
                                ${conflictData.kategori || 'Tidak tersedia'}
                            </p>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 10px;">
                        <strong style="font-size: 0.8em; color: #4a5568;">📍 Alamat:</strong>
                        <p style="margin: 2px 0 0 0; font-size: 0.85em; color: #2d3748; line-height: 1.3;">
                            ${conflictData.alamat || 'Alamat tidak tersedia'}
                        </p>
                    </div>
                    
                    ${conflictData.deskripsi ? `
                        <div style="margin-bottom: 10px;">
                            <strong style="font-size: 0.8em; color: #4a5568;">📝 Deskripsi:</strong>
                            <p style="margin: 2px 0 0 0; font-size: 0.85em; color: #2d3748; line-height: 1.3;">
                                ${conflictData.deskripsi.length > 150 ? 
                                    conflictData.deskripsi.substring(0, 150) + '...' : 
                                    conflictData.deskripsi}
                            </p>
                        </div>
                    ` : ''}
                    
                    ${conflictData.tanggal ? `
                        <div style="margin-bottom: 10px;">
                            <strong style="font-size: 0.8em; color: #4a5568;">📅 Tanggal Kejadian:</strong>
                            <p style="margin: 2px 0 0 0; font-size: 0.85em; color: #2d3748;">
                                ${formatDate(conflictData.tanggal)}
                            </p>
                        </div>
                    ` : ''}
                    
                    ${conflictData.pihak_terlibat ? `
                        <div style="margin-bottom: 10px;">
                            <strong style="font-size: 0.8em; color: #4a5568;">👥 Pihak Terlibat:</strong>
                            <p style="margin: 2px 0 0 0; font-size: 0.85em; color: #2d3748;">
                                ${conflictData.pihak_terlibat}
                            </p>
                        </div>
                    ` : ''}
                </div>
                
            `;
            
            detailPanel.style.display = 'block';
        }

        // Fungsi helper untuk menyembunyikan detail panel
        function hideConflictDetail(panelId) {
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.style.display = 'none';
            }
            
            // Remove active class from all conflict items
            document.querySelectorAll('.conflict-item').forEach(item => {
                item.classList.remove('active-conflict');
            });
        }

        // Fungsi helper untuk format tanggal
        function formatDate(dateString) {
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (e) {
                return dateString;
            }
        }


        // CSS untuk styling tambahan (tambahkan ke stylesheet)
        const additionalCSS = `
            .enhanced-popup .leaflet-popup-content-wrapper {
                overflow: visible !important;
            }
            
            .conflict-item.active-conflict {
                background: #ebf8ff !important;
                border-left-color: #3182ce !important;
            }
            
            .popup-detail-panel {
                max-height: 400px;
                overflow-y: auto;
            }
            
            @media (max-width: 768px) {
                .popup-detail-panel {
                    position: fixed !important;
                    left: 10px !important;
                    right: 10px !important;
                    top: 50% !important;
                    transform: translateY(-50%) !important;
                    width: auto !important;
                    margin: 0 !important;
                    z-index: 2000 !important;
                }
            }
        `;

        // Inject CSS
        if (!document.getElementById('enhanced-popup-styles')) {
            const style = document.createElement('style');
            style.id = 'enhanced-popup-styles';
            style.textContent = additionalCSS;
            document.head.appendChild(style);
        }

        function showKelurahanLabel(feature, centroidCoords, conflictCount) {
            // Hapus label sebelumnya (jika ada)
            removeActiveLabel();

            const kelurahanName = feature.properties.nama_kelurahan;

            // Siapkan konten HTML untuk label
            const labelContent = `
                <div style="
                    background: rgba(255, 255, 255, 0.95);
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    padding: 6px 10px;
                    font-size: 11px;
                    font-weight: 500;
                    text-align: center;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                    white-space: nowrap;
                    max-width: 200px;
                    pointer-events: none;
                    ${conflictCount > 0 ? 'border-left: 3px solid #f59e0b;' : 'border-left: 3px solid #10b981;'}
                ">
                    <div style="color: #374151; font-weight: 600; margin-bottom: 2px;">${kelurahanName}</div>
                    ${conflictCount > 0 
                        ? `<div style="color: #dc2626; font-size: 10px;">${conflictCount} konflik</div>` 
                        : `<div style="color: #10b981; font-size: 10px;">Tidak ada konflik</div>`
                    }
                </div>
            `;

            // Buat marker dengan divIcon di titik centroid
            activeLabel = L.marker(
                [centroidCoords[1], centroidCoords[0]],
                {
                    icon: L.divIcon({
                        className: 'kelurahan-hover-label',
                        html: labelContent,
                        iconSize: null,
                        iconAnchor: [0, 0]
                    }),
                    zIndexOffset: 1000,
                    interactive: false // Penting: label tidak boleh interactive
                }
            ).addTo(map);
        }

        function removeActiveLabel() {
            if (activeLabel) {
                map.removeLayer(activeLabel);
                activeLabel = null;
            }
        }

        function isMobileDevice() {
            return (
                typeof window.orientation !== "undefined" ||
                navigator.userAgent.indexOf('IEMobile') !== -1 ||
                /Android|iPhone|iPad|iPod|Opera Mini|IEMobile/i.test(navigator.userAgent)
            );
        }

        // NEW: FUNGSI UNTUK MENGHITUNG CENTROID POLYGON
        function calculateCentroid(coordinates) {
            let x = 0, y = 0, area = 0;
            const len = coordinates.length;
            
            if (len < 3) return null;
            
            for (let i = 0; i < len; i++) {
                const j = (i + 1) % len;
                const xi = coordinates[i][0], yi = coordinates[i][1];
                const xj = coordinates[j][0], yj = coordinates[j][1];
                const a = xi * yj - xj * yi;
                area += a;
                x += (xi + xj) * a;
                y += (yi + yj) * a;
            }
            
            area *= 0.5;
            if (area === 0) return null;
            
            return [x / (6 * area), y / (6 * area)];
        }

        // NEW: FUNGSI UNTUK MEMBUAT LEGEND GRADASI WARNA
        function createColorLegend() {
            const legend = L.control({position: 'bottomright'});
            
            legend.onAdd = function(map) {
                const div = L.DomUtil.create('div', 'legend');
                div.innerHTML = `
                    <h4 style="margin: 0 0 10px 0; font-size: 14px;">Jumlah Konflik</h4>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="display: flex; align-items: center;">
                            <i style="background: #f0f0f0; width: 18px; height: 12px; margin-right: 8px;"></i>
                            <span style="font-size: 12px;">Tidak ada</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i style="background: #84cc16; width: 18px; height: 12px; margin-right: 8px;"></i>
                            <span style="font-size: 12px;">Rendah</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i style="background: #eab308; width: 18px; height: 12px; margin-right: 8px;"></i>
                            <span style="font-size: 12px;">Sedang</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i style="background: #ef4444; width: 18px; height: 12px; margin-right: 8px;"></i>
                            <span style="font-size: 12px;">Tinggi</span>
                        </div>
                    </div>
                `;
                return div;
            };
            
            return legend;
        }

        // INISIALISASI PETA LEAFLET
        function initializeMap() {
            addMinimalInfoControlStyles();
            map = L.map('map', {
                minZoom: 12  // Batas minimum zoom (tidak bisa zoom out lebih dari level 12)
            }).setView([-6.9175, 107.6191], 12);
            
            // 1) Lapisan utama: CartoDB Positron tanpa label (grayscale-nolabels)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
                attribution: '© OpenStreetMap contributors © CARTO',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);
            
            // 2) Lapisan overlay hanya label: CartoDB Positron only_labels
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}{r}.png', {
                attribution: '',
                subdomains: 'abcd',
                maxZoom: 19,
                pane: 'overlayPane',
                opacity: 1
            }).addTo(map);
            
            // Tombol Home untuk kembali ke titik awal
            const homeButton = L.control({ position: 'topleft' });
            homeButton.onAdd = function (map) {
                const div = L.DomUtil.create('div', 'home-button-control');
                div.innerHTML = '<button class="home-btn" title="Kembali ke posisi awal"><i class="fa-solid fa-location-dot"></i></button>';        
                // Event handler untuk tombol home
                div.onclick = function(e) {
                    e.stopPropagation();
                    map.setView([-6.9175, 107.6191], 12, {
                        animate: true,
                        duration: 0.8
                    });
                };
                
                return div;
            };
            homeButton.addTo(map);
            
            // Info control (sama seperti sebelumnya)
            const info = L.control({ position: 'topright' });
            info.onAdd = function (map) {
                this._div = L.DomUtil.create('div', 'info-control');
                this.update();
                return this._div;
            };
            info.update = function (props) {
                const content = props ? 
                    `<div class="info-header">
                        <i class="info-icon">📍</i>
                        <span class="info-title">Detail Lokasi</span>
                    </div>
                    <div class="info-content">
                        <div class="location-name">${props.name}</div>
                        <div class="conflict-count">
                            <span class="count-number">${props.count}</span>
                            <span class="count-label">konflik tercatat</span>
                        </div>
                    </div>` :
                    `<div class="info-header">
                        <i class="info-icon">ℹ️</i>
                        <span class="info-title">Info Lokasi</span>
                    </div>
                    <div class="info-placeholder">
                        Arahkan kursor ke area untuk melihat detail
                    </div>`;
                
                this._div.innerHTML = content;
            };
            info.addTo(map);
        }

        function addMinimalInfoControlStyles() {
            // Cek apakah style sudah ada untuk menghindari duplikasi
            if (document.getElementById('minimal-info-control-styles')) {
                return;
            }
            
            const style = document.createElement('style');
            style.id = 'minimal-info-control-styles';
            style.textContent = `
                /* Minimal Info Control Styling */
                .info-control {
                    background: white;
                    border: 2px solid #e2e8f0;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    padding: 0;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    min-width: 240px;
                    overflow: hidden;
                    transition: all 0.2s ease;
                }

                .info-control:hover {
                    border-color: #cbd5e0;
                    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
                }

                .info-header {
                    background: #f7fafc;
                    color: #4a5568;
                    padding: 10px 14px;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    border-bottom: 1px solid #e2e8f0;
                }

                .info-icon {
                    font-size: 14px;
                }

                .info-title {
                    font-weight: 600;
                    font-size: 13px;
                    color: #2d3748;
                }

                .info-content {
                    padding: 14px;
                }

                .location-name {
                    font-size: 16px;
                    font-weight: 600;
                    color: #1a202c;
                    margin-bottom: 6px;
                }

                .conflict-count {
                    display: flex;
                    align-items: baseline;
                    gap: 5px;
                }

                .count-number {
                    font-size: 20px;
                    font-weight: 700;
                    color: #dc2626;
                }

                .count-label {
                    font-size: 11px;
                    color: #6b7280;
                    text-transform: uppercase;
                    letter-spacing: 0.3px;
                }

                .info-placeholder {
                    padding: 14px;
                    color: #6b7280;
                    font-size: 12px;
                    text-align: center;
                }

                /* Home Button Styling */
                .home-button-control {
                    background: none;
                    border: none;
                    margin: 0;
                    padding: 0;
                }

                .home-btn {
                    background: white;
                    border: 2px solid #e2e8f0;
                    border-radius: 6px;
                    width: 40px;
                    height: 40px;
                    font-size: 16px;
                    cursor: pointer;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    transition: all 0.2s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .home-btn:hover {
                    background: #f7fafc;
                    border-color: #cbd5e0;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                .home-btn:active {
                    transform: translateY(0);
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                }
            `;
            
            document.head.appendChild(style);
        }

        // FUNGSI UNTUK MENGHITUNG WARNA BERDASARKAN JUMLAH KONFLIK
        function getColorForKonflik(count, maxCount) {
            if (count === 0) return '#f0f0f0';

            const intensity = count / maxCount;  // nilai antara 0 dan 1

            if (intensity <= 0.20) {
                // 0% – 20%: hijau muda
                return 'rgb(0, 180, 0)';
            } 
            else if (intensity <= 0.60) {
                // >20% – 60%: kuning
                return 'rgb(255, 200, 0)';
            } 
            else if (intensity <= 0.80) {
                // >60% – 80%: oranye
                return 'rgb(255, 90, 0)';         // #FFC000
            } 
            else {
                // >80% – 100%: merah
                return 'rgb(255, 0, 0)';           // #FF0000
            }
        }

        // FUNGSI FILTER DATA
        function getFilteredData() {
            if (!currentYear) return potensiKonfliks;
            
            return potensiKonfliks.filter(item => {
                const itemYear = new Date(item.tanggal).getFullYear();
                return itemYear.toString() === currentYear;
            });
        }

        // FUNGSI UPDATE PETA DENGAN GEOJSON - DIPERBAIKI
        function updateMapWithGeoJson() {
            // Hapus layer lama jika ada
            if (kecamatanLayer) {
                map.removeLayer(kecamatanLayer);
                kecamatanLayer = null;
            }
            if (kelurahanLayer) {
                map.removeLayer(kelurahanLayer);
                kelurahanLayer = null;
            }

            // Reset semua state
            removeActiveLabel();
            currentHoveredFeature = null;
            isHovering = false;
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
                hoverTimeout = null;
            }

            const filteredData = getFilteredData();

            // Kelompokkan hasil filter berdasarkan nama kelurahan
            const kelurahanData = {};
            filteredData.forEach(item => {
                const namaKel = item.lokasi_kelurahan;
                if (!kelurahanData[namaKel]) {
                    kelurahanData[namaKel] = [];
                }
                kelurahanData[namaKel].push(item);
            });

            // Cari konflik maksimum untuk gradiasi warna
            const maxKonflik = Math.max(
                1, 
                ...Object.values(kelurahanData).map(arr => arr.length)
            );

            // Style layer kelurahan (area berwarna)
            function styleKelurahan(feature) {
                const namaKel = feature.properties.nama_kelurahan;
                const count = kelurahanData[namaKel] ? kelurahanData[namaKel].length : 0;
                return {
                    fillColor: getColorForKonflik(count, maxKonflik),
                    weight: 1,
                    opacity: 0.8,
                    color: '#ffffff',
                    fillOpacity: 0.7
                };
            }

            // Style layer kecamatan (hanya garis batas)
            function styleKecamatan(feature) {
                return {
                    fillColor: 'transparent',
                    weight: 2,
                    opacity: 1,
                    color: '#2563eb',
                    fillOpacity: 0,
                    interactive: false // Penting: kecamatan layer tidak interactive
                };
            }

            // Buat layer kelurahan dengan fungsi gabungan
            kelurahanLayer = L.geoJson(geoJsonKelurahan, {
                style: styleKelurahan,
                onEachFeature: onEachKelurahanCombined
            }).addTo(map);

            // Layer kecamatan (garis batas di atas) - NON-INTERACTIVE
            kecamatanLayer = L.geoJson(geoJsonKecamatan, {
                style: styleKecamatan,
                interactive: false // Mencegah event pada layer kecamatan
            }).addTo(map);

            // Tambahkan legend jika belum ada
            if (!map.legend) {
                map.legend = createColorLegend();
                map.legend.addTo(map);
            }

            console.log('Map updated with GeoJSON layers');
        }

        // FUNGSI UPDATE PETA UTAMA
        function updateMap() {
            if (geoJsonKecamatan && geoJsonKelurahan) {
                updateMapWithGeoJson();
            } else {
                updateMapWithMarkers();
            }
        }

        // FALLBACK: FUNGSI UPDATE PETA DENGAN MARKER (sistem lama)
        function updateMapWithMarkers() {
            // Kode marker lama tetap ada sebagai fallback
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            
            const filteredData = getFilteredData();
            
        }
        // ============================================================================================================================================================

        // FUNGSI UNTUK MENDAPATKAN PARAMETER URL SAAT INI
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // INISIALISASI FILTER TAHUN
        function initializeYearFilter() {
            // Mengambil semua tahun unik dari data konflik
            const years = [...new Set(potensiKonfliks.map(item => {
                return new Date(item.tanggal).getFullYear();
            }))].sort((a, b) => b - a); // Sort descending (tahun terbaru dulu)
            
            // Menambahkan option ke dropdown filter
            const yearSelect = document.getElementById('yearFilter');
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });

            // Set nilai dropdown berdasarkan parameter URL jika ada
            const urlYearFilter = getUrlParameter('year_filter');
            if (urlYearFilter) {
                yearSelect.value = urlYearFilter;
                currentYear = urlYearFilter;
            }

        }

        // UPDATE TABEL DATA
        function updateTableWithPageReload() {
            if (!currentYear) {
                // Jika tidak ada filter, hapus parameter year_filter dari URL
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('year_filter');
                currentUrl.searchParams.delete('page'); // Reset pagination
                
                if (currentUrl.toString() !== window.location.href) {
                    window.location.href = currentUrl.toString();
                }
                return;
            }
            
            // Jika ada filter tahun, reload halaman dengan parameter
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('year_filter', currentYear);
            currentUrl.searchParams.delete('page'); // Reset ke halaman pertama
            
            // Reload halaman dengan parameter baru
            window.location.href = currentUrl.toString();
        }

        // FUNGSI BARU: RELOAD TABEL DENGAN FILTER TAHUN
        function reloadTableWithYearFilter(year) {
            const currentUrl = new URL(window.location.href);
            
            if (year) {
                currentUrl.searchParams.set('year_filter', year);
            } else {
                currentUrl.searchParams.delete('year_filter');
            }
            
            // Reset pagination ke halaman pertama ketika filter berubah
            currentUrl.searchParams.delete('page');
            
            // Reload halaman dengan parameter baru
            window.location.href = currentUrl.toString();
        }

        // UPDATE SEMUA CHARTS
        function updateCharts() {
            const filteredData = getFilteredData();
            
            // Hitung ulang statistik untuk data yang sudah difilter
            const kategoriStats = {};
            const kecamatanStats = {};
            const tingkatStats = {};
            
            filteredData.forEach(item => {
                // Statistik per kategori
                kategoriStats[item.kategori] = (kategoriStats[item.kategori] || 0) + 1;
                
                // Statistik per kecamatan
                kecamatanStats[item.lokasi_kecamatan] = (kecamatanStats[item.lokasi_kecamatan] || 0) + 1;
                
                // Statistik per tingkat potensi
                tingkatStats[item.tingkat_potensi] = (tingkatStats[item.tingkat_potensi] || 0) + 1;
            });
            
            // Update masing-masing chart
            updateKategoriChart(kategoriStats);
            updateKecamatanChart(kecamatanStats);
            updateTingkatChart(tingkatStats);
            updateTimelineChart(filteredData);
        }

        function updateChartTitle(chartSelector, baseTitle) {
            const chartTitle = document.querySelector(chartSelector);
            const years = [...new Set(potensiKonfliks.map(item => new Date(item.tanggal).getFullYear()))];
            const tahunTerlama = Math.min(...years);
            const tahunTerbaru = Math.max(...years);

            if (!currentYear) {
                chartTitle.textContent = `${baseTitle} Tahun ${tahunTerlama} - ${tahunTerbaru}`;
            } else {
                chartTitle.textContent = `${baseTitle} Tahun ${currentYear}`;
            }
        }

        // Fungsi pembantu: cari entitas (kategori/ kecamatan / tingkat) dengan count tertinggi
        function getMaxGroupInfo(data, key) {
            const countMap = {};
            data.forEach(item => {
                const value = item[key] || 'Tidak Diketahui';
                countMap[value] = (countMap[value] || 0) + 1;
            });
            const maxCount = Math.max(...Object.values(countMap));
            const labels = Object.keys(countMap).filter(k => countMap[k] === maxCount);
            return { labels, count: maxCount };
        }

        function getMinGroupInfo(data, key) {
            const countMap = {};
            data.forEach(item => {
                const value = item[key] || 'Tidak Diketahui';
                countMap[value] = (countMap[value] || 0) + 1;
            });

            const minCount = Math.min(...Object.values(countMap));
            const labels = Object.keys(countMap).filter(k => countMap[k] === minCount);
            return { labels, count: minCount };
        }

        function getAllGroupCounts(data, key) {
            const countMap = {};
            data.forEach(item => {
                const value = item[key] || 'Tidak Diketahui';
                countMap[value] = (countMap[value] || 0) + 1;
            });
            return countMap;
        }

        // Fungsi untuk mendapatkan label tahun (rentang jika semua, atau satu tahun terpilih)
        function formatYearLabel() {
            const allYears = [...new Set(potensiKonfliks.map(i => new Date(i.tanggal).getFullYear()))].sort((a, b) => a - b);
            if (!currentYear) {
                return `${allYears[0]} - ${allYears[allYears.length - 1]}`;
            }
            return currentYear;
        }

        // Fungsi untuk baca dropdown tahun
        function getSelectedYear() {
            const yearSelect = document.getElementById('yearFilter');
            if (!yearSelect) return '';
            return yearSelect.value || ''; // value="" artinya semua
        }

        function updateChartDescriptions() {
            // 1. Ambil data sesuai filter tahun
            const data = getFilteredData();

            // 2. Tentukan label tahun (rentang atau satu tahun)
            const tahunFilter = getSelectedYear(); // '' atau '2023', '2024', dst
            const tahunLabel = formatYearLabel();   // mis: "2020 - 2025" atau "2023"

            // 3. Cari entitas dengan count tertinggi
            const kategoriInfo = getMaxGroupInfo(data, 'kategori');
            const kecamatanInfo = getMaxGroupInfo(data, 'lokasi_kecamatan');
            const kecamatanInfo1 = getMinGroupInfo(data, 'lokasi_kecamatan');
            const tingkatInfo = getMaxGroupInfo(data, 'tingkat_potensi');
            const tingkatCounts = getAllGroupCounts(data, 'tingkat_potensi');


            // 4. Buat list kategori unik (dipakai di deskripsi kategori)
            const semuaKategori = [...new Set(data.map(item => item.kategori).filter(Boolean))].join(', ');

            const urutanTingkat = ['rendah', 'sedang', 'tinggi'];
            const tingkatDescriptions = urutanTingkat
                .map(tingkat => {
                    const count = tingkatCounts[tingkat] || 0;
                    return `tingkat ${tingkat.toLowerCase()} sebanyak ${count} konflik`;
                })
                .join(', ');

            // 5. Update judul chart (tetap gunakan tahunLabel)
            document.querySelector('.chart-title-kategori').textContent =
                `📊 Kategori Konflik di Kota Bandung Tahun ${tahunLabel}`;
            document.querySelector('.chart-title-kecamatan').textContent =
                `📍 Persebaran Konflik per Kecamatan Tahun ${tahunLabel}`;
            document.querySelector('.chart-title-level').textContent =
                `🚦 Tingkat Potensi Konflik Tahun ${tahunLabel}`;
            document.querySelector('.chart-title-tahun').textContent =
                `📈 Tren Konflik per Waktu Tahun ${tahunLabel}`;

            // TAMBAHAN BARU: Update judul Maps dan Tabel
            document.querySelector('.gis-title').textContent =
                `🗺️ Peta Sebaran Potensi Konflik Di Kota Bandung Tahun ${tahunLabel}`;

            // 6. Update deskripsi KATEGORI
            document.getElementById('desc-kategori').textContent =
                `Grafik ini menampilkan sebaran potensi konflik menurut kategori penyebabnya, seperti konflik ${semuaKategori}. ` +
                `Dari grafik terlihat bahwa kategori konflik "${kategoriInfo.labels.join('", "')}" ` +
                `mendominasi dengan jumlah total konflik terbesar, dengan total ${kategoriInfo.count} konflik pada tahun ${tahunLabel}. ` +
                `Hal ini menunjukkan bahwa masalah  "${kategoriInfo.labels.join('", "')}" menjadi penyebab utama potensi konflik di Kota Bandung.`;

            // 7. Update deskripsi KECAMATAN
            document.getElementById('desc-kecamatan').textContent =
                `Grafik ini memperlihatkan tingkat potensi konflik di masing-masing kecamatan di Kota Bandung. ` +
                `Misalnya, Kecamatan "${kecamatanInfo.labels.join('", "')}" ` +
                `memiliki potensi konflik yang tinggi dengan total ${kecamatanInfo.count} konflik, ` +
                `sementara Kecamatan "${kecamatanInfo1.labels.join('", "')}" ` +
                `memiliki potensi konflik yang rendah dengan total ${kecamatanInfo1.count} konflik pada tahun ${tahunLabel}. ` +
                `Grafik ini membantu mengidentifikasi wilayah yang rawan konflik sehingga upaya pencegahan dan pengawasan bisa lebih terfokus. Dengan melihat grafik ini, masyarakat dan pemangku kebijakan dapat memahami kondisi keamanan di lingkungan masing-masing secara lebih jelas.`;

            // 8. Update deskripsi TINGKAT POTENSI
            document.getElementById('desc-tingkat').textContent =
                `Grafik ini mengelompokkan potensi konflik berdasarkan tingkatannya, seperti rendah, sedang, dan tinggi. ` +
                `Secara keseluruhan wilayah di Kota Bandung menunjukkan potensi konflik ${tingkatDescriptions} pada tahun ${tahunLabel}. ` +
                `Grafik ini memberikan gambaran umum tentang risiko konflik di Kota Bandung, yang dapat menjadi dasar prioritas kebijakan dan langkah preventif.`;

            // 9. Update deskripsi TIMELINE
            const totalTimeline = data.length;
            document.getElementById('desc-timeline').textContent =
                `Grafik ini menggambarkan tren potensi konflik dari waktu ke waktu pada tahun ${tahunLabel}. ` +
                `Total konflik yang tercatat pada periode ini adalah ${totalTimeline} kasus. ` +
                `Dari grafik terlihat adanya fluktuasi, dengan peningkatan potensi konflik pada beberapa waktu tertentu dan penurunan di waktu lainnya. Tren ini penting untuk memantau dinamika konflik agar langkah antisipatif dapat dilakukan tepat waktu. Dengan memahami pola ini, pemerintah dan masyarakat dapat lebih siap menghadapi potensi konflik yang muncul.`;
        }

        // INISIALISASI SEMUA CHARTS
        function initializeCharts() {
            // Skema warna untuk semua chart
            const colorSchemes = {
                primary: ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3', '#54a0ff', '#5f27cd'],
                gradients: [
                    'rgba(255, 107, 107, 0.8)',
                    'rgba(78, 205, 196, 0.8)',
                    'rgba(69, 183, 209, 0.8)',
                    'rgba(150, 206, 180, 0.8)',
                    'rgba(254, 202, 87, 0.8)',
                    'rgba(255, 159, 243, 0.8)',
                    'rgba(84, 160, 255, 0.8)',
                    'rgba(95, 39, 205, 0.8)'
                ]
            };


            // KATEGORI (DOUGHNUT CHART)
            // Menampilkan distribusi konflik berdasarkan kategori dalam bentuk donat
            const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
            charts.kategori = new Chart(kategoriCtx, {
                type: 'doughnut',
                data: { 
                    labels: [], 
                    datasets: [{ 
                        data: [], 
                        backgroundColor: [], 
                        borderColor: [], 
                        borderWidth: 2 
                    }] 
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });


            // KECAMATAN (BAR CHART)
            // Menampilkan jumlah konflik per kecamatan dalam bentuk bar chart
            const kecamatanCtx = document.getElementById('kecamatanChart').getContext('2d');
            charts.kecamatan = new Chart(kecamatanCtx, {
                type: 'bar',
                data: { 
                    labels: [], 
                    datasets: [{ 
                        label: 'Jumlah Konflik', 
                        data: [], 
                        backgroundColor: colorSchemes.gradients[1], 
                        borderColor: colorSchemes.primary[1], 
                        borderWidth: 2, 
                        borderRadius: 8 
                    }] 
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: colorSchemes.primary[1],
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, color: '#718096' },
                            grid: { color: 'rgba(113, 128, 150, 0.1)' }
                        },
                        x: {
                            ticks: {
                                color: '#718096',
                                autoSkip: false,    // ← jangan lewati label apa pun
                                maxRotation: 45,    // atau sesuai kebutuhan (0–90)
                                minRotation: 0
                            },
                            grid: { display: false }
                        }
                    }
                }
            });


            // TINGKAT POTENSI (PIE CHART)
            // Menampilkan distribusi konflik berdasarkan tingkat potensi
            const tingkatCtx = document.getElementById('tingkatChart').getContext('2d');
            charts.tingkat = new Chart(tingkatCtx, {
                type: 'pie',
                data: { 
                    labels: [], 
                    datasets: [{ 
                        data: [], 
                        backgroundColor: [], 
                        borderColor: [], 
                        borderWidth: 2 
                    }] 
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });


            // TIMELINE (LINE CHART)
            // Menampilkan tren konflik dari waktu ke waktu
            const timelineCtx = document.getElementById('timelineChart').getContext('2d');
            charts.timeline = new Chart(timelineCtx, {
                type: 'line',
                data: { 
                    labels: [], 
                    datasets: [{ 
                        label: 'Jumlah Konflik', 
                        data: [], 
                        borderColor: colorSchemes.primary[2], 
                        backgroundColor: colorSchemes.gradients[2], 
                        borderWidth: 3, 
                        fill: true, 
                        tension: 0.4 
                    }] 
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: colorSchemes.primary[2],
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, color: '#718096' },
                            grid: { color: 'rgba(113, 128, 150, 0.1)' }
                        },
                        x: {
                            ticks: { color: '#718096' },
                            grid: { color: 'rgba(113, 128, 150, 0.1)' }
                        }
                    }
                }
            });
        }

        // FUNGSI UPDATE CHART INDIVIDU
        // Update Chart Kategori dengan data baru
        function updateKategoriChart(data) {
            const labels = Object.keys(data);
            const values = Object.values(data);
            const colorSchemes = {
                primary: ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3', '#54a0ff', '#5f27cd'],
                gradients: [
                    'rgba(255, 107, 107, 0.8)',
                    'rgba(78, 205, 196, 0.8)',
                    'rgba(69, 183, 209, 0.8)',
                    'rgba(150, 206, 180, 0.8)',
                    'rgba(254, 202, 87, 0.8)',
                    'rgba(255, 159, 243, 0.8)',
                    'rgba(84, 160, 255, 0.8)',
                    'rgba(95, 39, 205, 0.8)'
                ]
            };

            charts.kategori.data.labels = labels;
            charts.kategori.data.datasets[0].data = values;
            charts.kategori.data.datasets[0].backgroundColor = colorSchemes.gradients.slice(0, labels.length);
            charts.kategori.data.datasets[0].borderColor = colorSchemes.primary.slice(0, labels.length);
            charts.kategori.update();
        }

        // Update Chart Kecamatan dengan data baru
        function updateKecamatanChart(data) {
            const entries = Object.entries(data); // [ [kec1, jumlah1], [kec2, jumlah2], ... ]
            
            // Urutkan berdasarkan nama kecamatan (A-Z)
            const sorted = entries.sort((a, b) => a[0].localeCompare(b[0]));

            const labels = sorted.map(entry => entry[0]);
            const values = sorted.map(entry => entry[1]);

            charts.kecamatan.data.labels = labels;
            charts.kecamatan.data.datasets[0].data = values;

            // Update bar colors berdasarkan tinggi rendahnya jumlah konflik
            const max = Math.max(...values);
            const barColors = values.map(val => {
                const intensity = val / max;
                if (intensity > 0.7) return '#e53e3e';       // tinggi → merah
                if (intensity > 0.4) return '#f6ad55';       // sedang → oranye
                return '#68d391';                            // rendah → hijau
            });

            charts.kecamatan.data.datasets[0].backgroundColor = barColors;
            charts.kecamatan.data.datasets[0].borderColor = barColors; // <- tambahkan ini


            charts.kecamatan.update();
        }

        // Update Chart Tingkat Potensi dengan data baru dan warna sesuai tingkat
        function updateTingkatChart(data) {
            const labels = Object.keys(data);
            const values = Object.values(data);
            
            // Warna khusus untuk setiap tingkat potensi
            const colors = {
                'rendah': ['rgba(150, 206, 180, 0.8)', '#96ceb4'],  // Hijau
                'sedang': ['rgba(254, 202, 87, 0.8)', '#feca57'],   // Kuning
                'tinggi': ['rgba(255, 107, 107, 0.8)', '#ff6b6b']   // Merah
            };

            const backgrounds = labels.map(label => colors[label] ? colors[label][0] : 'rgba(200, 200, 200, 0.8)');
            const borders = labels.map(label => colors[label] ? colors[label][1] : '#c8c8c8');

            charts.tingkat.data.labels = labels;
            charts.tingkat.data.datasets[0].data = values;
            charts.tingkat.data.datasets[0].backgroundColor = backgrounds;
            charts.tingkat.data.datasets[0].borderColor = borders;
            charts.tingkat.update();
        }

        // Update Chart Timeline dengan data baru yang dikelompokkan per bulan
        function updateTimelineChart(filteredData) {
            const selectedYear = document.getElementById('yearFilter').value;
            const timelineData = {};

            filteredData.forEach(item => {
                const date = new Date(item.tanggal);
                const year = date.getFullYear();
                const month = date.getMonth(); // 0 = Jan, 11 = Dec

                if (!selectedYear) {
                    // Semua tahun → kelompokkan per tahun
                    timelineData[year] = (timelineData[year] || 0) + 1;
                } else if (String(year) === selectedYear) {
                    // Tahun tertentu → kelompokkan per bulan
                    timelineData[month] = (timelineData[month] || 0) + 1;
                }
            });

            let labels = [], values = [];

            if (!selectedYear) {
                // Mode Semua Tahun
                const sortedYears = Object.keys(timelineData).sort();
                labels = sortedYears;
                values = sortedYears.map(y => timelineData[y]);
            } else {
                // Mode Tahun Tertentu → tampilkan per bulan
                labels = [...Array(12).keys()].map(m =>
                    new Date(0, m).toLocaleString('id-ID', { month: 'short' })
                );
                values = [...Array(12).keys()].map(m => timelineData[m] || 0);
            }

            charts.timeline.data.labels = labels;
            charts.timeline.data.datasets[0].data = values;
            charts.timeline.update();

            // Update deskripsi jika mau
            document.getElementById('desc-timeline').textContent =
                selectedYear ?
                `Menampilkan jumlah konflik per bulan untuk tahun ${selectedYear}.` :
                'Menampilkan jumlah konflik per tahun.';
        }

        // **TAMBAHAN: Fungsi untuk update tampilan berdasarkan view yang aktif**
        function updateCurrentView() {
            switch(currentView) {
                case 'gis-container':
                    updateMap();
                    updateMapsChartStatistics(); // untuk stat cards yang biasanya selalu tampil
                    animateNumbers();
                    updateChartDescriptions();
                    break;
                case 'chart-grid':
                    updateCharts();
                    updateMapsChartStatistics();
                    animateNumbers();
                    updateChartDescriptions();
                    break;
                case 'table-container':
                    updateTableStatistics();
                    animateTableNumbers();
                    break;
            }
        }

        // Fungsi utama yang dipanggil untuk update semua visualisasi
        function updateVisualization() {
            // Ini bisa dihapus atau dijadikan wrapper untuk updateCurrentView()
            updateCurrentView();
        }

        // ========== FUNGSI STATISTIK KHUSUS UNTUK TABEL ==========
        function updateTableStatistics() {
            const filteredData = getFilteredData(); // Data sudah difilter berdasarkan tahun
            
            // Update card total konflik
            document.getElementById('totalKonflik').textContent = filteredData.length;
            
            // Update card total kecamatan yang terdampak
            const uniqueKecamatan = [...new Set(filteredData.map(item => item.lokasi_kecamatan))];
            document.getElementById('totalKecamatan').textContent = uniqueKecamatan.length;
            
            // Update card total kategori konflik
            const uniqueKategori = [...new Set(filteredData.map(item => item.kategori))];
            document.getElementById('totalKategori').textContent = uniqueKategori.length;
            
            // Update card konflik aktif
            const konflikAktif = filteredData.filter(item => item.status === 'aktif').length;
            document.getElementById('konflikAktif').textContent = konflikAktif;
        }

        function updateMapsChartStatistics() {
            const filteredData = getFilteredData();
            
            // Update card total konflik
            document.getElementById('totalKonflik').textContent = filteredData.length;
            
            // Update card total kecamatan yang terdampak
            const uniqueKecamatan = [...new Set(filteredData.map(item => item.lokasi_kecamatan))];
            document.getElementById('totalKecamatan').textContent = uniqueKecamatan.length;
            
            // Update card total kategori konflik
            const uniqueKategori = [...new Set(filteredData.map(item => item.kategori))];
            document.getElementById('totalKategori').textContent = uniqueKategori.length;
            
            // Update card konflik aktif
            const konflikAktif = filteredData.filter(item => item.status === 'aktif').length;
            document.getElementById('konflikAktif').textContent = konflikAktif;
        }

        function animateNumbers() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(element => {
                const target = parseInt(element.textContent);
                let current = 0;
                const increment = target / 50; // Dibagi 50 step untuk animasi smooth
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current);
                    }
                }, 30); // Update setiap 30ms
            });
        }
    </script>
@endsection