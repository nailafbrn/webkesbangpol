@extends('landingpage.layouts.app')
@section('title', 'Potensi Konflik di Kota Bandung')
@section('content')

<style>
.dashboard-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.dashboard-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dashboard-title {
    color: white;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.dashboard-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin-bottom: 0;
}

.year-filter-container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.year-filter-label {
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.year-select {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    color: #2d3748;
    min-width: 120px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.year-select:focus {
    outline: none;
    border-color: #4ecdc4;
    box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
    background-size: 300% 100%;
    animation: gradient 3s ease infinite;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #718096;
    font-weight: 500;
    font-size: 0.9rem;
}

.gis-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.gis-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
    text-align: center;
}

#map {
    height: 500px;
    width: 100%;
    border-radius: 12px;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.map-legend {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.legend-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.25rem;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    margin-right: 0.5rem;
    border: 1px solid rgba(0, 0, 0, 0.2);
}

.chart-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.chart-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
    text-align: center;
}

.chart-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.table-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.modern-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.modern-table th {
    color: white;
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    font-size: 0.9rem;
    border: none;
}

.modern-table tbody tr {
    background: white;
    transition: all 0.2s ease;
}

.modern-table tbody tr:nth-child(even) {
    background: #f8fafc;
}

.modern-table tbody tr:hover {
    background: #e2e8f0;
    transform: scale(1.01);
}

.modern-table td {
    padding: 1rem;
    border: none;
    font-size: 0.9rem;
    color: #4a5568;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-aktif {
    background: #c6f6d5;
    color: #22543d;
}

.status-selesai {
    background: #bee3f8;
    color: #2a4365;
}

.status-pending {
    background: #feebc8;
    color: #744210;
}

.tingkat-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.tingkat-rendah {
    background: #c6f6d5;
    color: #22543d;
}

.tingkat-sedang {
    background: #feebc8;
    color: #744210;
}

.tingkat-tinggi {
    background: #fed7e2;
    color: #702459;
}

@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .chart-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .modern-table {
        font-size: 0.8rem;
    }
    
    .modern-table th,
    .modern-table td {
        padding: 0.75rem 0.5rem;
    }
    
    .year-filter-container {
        flex-direction: column;
        text-align: center;
    }
    
    #map {
        height: 400px;
    }
}
</style>

<!-- Add Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="dashboard-container">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header text-center">
            <h1 class="dashboard-title">📊 Dashboard Potensi Konflik</h1>
            <p class="dashboard-subtitle">Monitoring dan Analisis Potensi Konflik di Kota Bandung</p>
        </div>

        <!-- Year Filter -->
        <div class="year-filter-container">
            <label for="yearFilter" class="year-filter-label">🗓️ Filter Tahun:</label>
            <select id="yearFilter" class="year-select">
                <option value="">Semua Tahun</option>
                <!-- Years will be populated by JavaScript -->
            </select>
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

        <!-- GIS Visualization -->
        <div class="gis-container">
            <h3 class="gis-title">🗺️ Peta Sebaran Potensi Konflik</h3>
            <div id="map"></div>
            <div class="map-legend">
                <div class="legend-title">Keterangan:</div>
                
                <!-- Legend untuk tingkat konflik kelurahan -->
                <div style="margin-bottom: 15px;">
                    <div style="font-weight: 600; font-size: 12px; margin-bottom: 8px; color: #4a5568;">
                        Tingkat Konflik per Kelurahan:
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #de2d26;"></div>
                        <span>Sangat Tinggi (>20 konflik)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #fb6a4a;"></div>
                        <span>Tinggi (11-20 konflik)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #fc9272;"></div>
                        <span>Sedang (6-10 konflik)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #fcbba1;"></div>
                        <span>Ringan (3-5 konflik)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #fee5d9;"></div>
                        <span>Sangat Ringan (1-2 konflik)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: transparent; border: 1px dashed #999;"></div>
                        <span>Tidak ada konflik</span>
                    </div>
                </div>
                
                <!-- Legend untuk garis batas -->
                <div>
                    <div style="font-weight: 600; font-size: 12px; margin-bottom: 8px; color: #4a5568;">
                        Batas Wilayah:
                    </div>
                    <div class="legend-item">
                        <div style="width: 20px; height: 3px; background: #2563eb; margin-right: 8px; border: 1px dashed #2563eb;"></div>
                        <span>Batas Kecamatan</span>
                    </div>
                    <div class="legend-item">
                        <div style="width: 20px; height: 2px; background: #666666; margin-right: 8px;"></div>
                        <span>Batas Kelurahan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="chart-grid">
            <!-- Kategori Chart -->
            <div class="chart-container">
                <h3 class="chart-title">📊 Distribusi per Kategori</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            <!-- Kecamatan Chart -->
            <div class="chart-container">
                <h3 class="chart-title">🗺️ Distribusi per Kecamatan</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="kecamatanChart"></canvas>
                </div>
            </div>

            <!-- Tingkat Potensi Chart -->
            <div class="chart-container">
                <h3 class="chart-title">⚡ Tingkat Potensi</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="tingkatChart"></canvas>
                </div>
            </div>

            <!-- Timeline Chart -->
            <div class="chart-container">
                <h3 class="chart-title">📅 Trend Bulanan</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <h3 class="chart-title">📋 Data Detail Potensi Konflik</h3>
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
                        @foreach ($potensiKonfliks as $item)
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
        </div>
    </div>
</div>


<script>

    // INISIALISASI DATA & VARIABEL
    // Mengambil data dari server (Laravel Blade) ke JavaScript
    const potensiKonfliks = @json($potensiKonfliks);     // Data semua konflik
    const statistikKategori = @json($statistikKategori); // Statistik per kategori
    const statistikKecamatan = @json($statistikKecamatan); // Statistik per kecamatan
    const statistikTingkat = @json($statistikTingkat);   // Statistik per tingkat potensi

    // Variabel global untuk menyimpan objek-objek utama
    let map;           // Objek peta Leaflet
    let markers = [];  // Array untuk menyimpan marker di peta
    let charts = {};   // Objek untuk menyimpan semua chart
    let currentYear = ''; // Tahun yang sedang dipilih untuk filter


    // KOORDINAT KECAMATAN BANDUNG
    // Koordinat [latitude, longitude] untuk setiap kecamatan di Bandung
    // Data ini digunakan untuk menampilkan marker di peta
    const bandungDistricts = {
        'Andir': [-6.9175, 107.5831],
        'Antapani': [-6.9147, 107.6398],
        'Arcamanik': [-6.9441, 107.6634],
        'Astana Anyar': [-6.9344, 107.5831],
        'Babakan Ciparay': [-6.9528, 107.5831],
        'Bandung Kidul': [-6.9528, 107.6634],
        'Bandung Kulon': [-6.9175, 107.5831],
        'Bandung Wetan': [-6.9175, 107.6398],
        'Batununggal': [-6.9441, 107.6398],
        'Bojongloa Kaler': [-6.9175, 107.5831],
        'Bojongloa Kidul': [-6.9528, 107.5831],
        'Buahbatu': [-6.9441, 107.6634],
        'Cibeunying Kaler': [-6.9147, 107.6398],
        'Cibeunying Kidul': [-6.9147, 107.6398],
        'Cibiru': [-6.9441, 107.6634],
        'Cicendo': [-6.9175, 107.5831],
        'Cidadap': [-6.8882, 107.6398],
        'Cinambo': [-6.9441, 107.6634],
        'Coblong': [-6.8882, 107.6398],
        'Gedebage': [-6.9441, 107.6634],
        'Kiaracondong': [-6.9441, 107.6398],
        'Lengkong': [-6.9344, 107.6398],
        'Mandalajati': [-6.9441, 107.6398],
        'Panyileukan': [-6.9441, 107.6634],
        'Rancasari': [-6.9441, 107.6634],
        'Regol': [-6.9344, 107.6398],
        'Sukajadi': [-6.8882, 107.6398],
        'Sukasari': [-6.8882, 107.6398],
        'Sumur Bandung': [-6.9175, 107.6398],
        'Ujungberung': [-6.9441, 107.6634]
    };

    // EVENT LISTENER UTAMA
    
    // Event listener yang dijalankan ketika halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {
        initializeMap();        // Inisialisasi peta
        initializeYearFilter(); // Inisialisasi dropdown filter tahun
        initializeCharts();     // Inisialisasi semua chart kosong
        updateVisualization();  // Update semua visualisasi dengan data awal
        
        // Event listener untuk perubahan filter tahun
        document.getElementById('yearFilter').addEventListener('change', function() {
            currentYear = this.value;
            updateVisualization(); // Update semua visualisasi ketika tahun berubah
        });
    });


    // INISIALISASI PETA LEAFLET
    function initializeMap() {
        // Membuat peta dengan center di Bandung, zoom level 11
        map = L.map('map').setView([-6.9175, 107.6191], 11);
        
        // Menambahkan layer tile OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Membuat kontrol info yang akan muncul di peta
        const info = L.control();
        
        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        
        // Function untuk update info ketika hover marker
        info.update = function (props) {
            this._div.innerHTML = '<h4>Info Lokasi</h4>' +  (props ?
                '<b>' + props.name + '</b><br />' + props.count + ' konflik'
                : 'Hover over a marker');
        };
        
        info.addTo(map);
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
    }


    // FUNGSI FILTER DATA
    // Mengembalikan data yang sudah difilter berdasarkan tahun
    function getFilteredData() {
        if (!currentYear) return potensiKonfliks; // Jika tidak ada filter, return semua data
        
        return potensiKonfliks.filter(item => {
            const itemYear = new Date(item.tanggal).getFullYear();
            return itemYear.toString() === currentYear;
        });
    }


    // UPDATE PETA
    function updateMap() {
        // Hapus semua marker yang ada
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        
        const filteredData = getFilteredData();
        
        // Kelompokkan data berdasarkan kecamatan
        const districtData = {};
        filteredData.forEach(item => {
            const district = item.lokasi_kecamatan;
            if (!districtData[district]) {
                districtData[district] = [];
            }
            districtData[district].push(item);
        });
        
        // Buat marker untuk setiap kecamatan yang memiliki data
        Object.keys(districtData).forEach(district => {
            const coords = bandungDistricts[district];
            if (coords) {
                const conflicts = districtData[district];
                const count = conflicts.length;
                
                // Hitung jumlah konflik berdasarkan tingkat potensi
                const highCount = conflicts.filter(c => c.tingkat_potensi === 'Tinggi').length;
                const mediumCount = conflicts.filter(c => c.tingkat_potensi === 'Sedang').length;
                const lowCount = conflicts.filter(c => c.tingkat_potensi === 'Rendah').length;
                
                // Tentukan warna marker berdasarkan tingkat potensi tertinggi
                let color = '#96ceb4'; // Default: hijau untuk rendah
                if (highCount > 0) color = '#ff6b6b';      // Merah untuk tinggi
                else if (mediumCount > 0) color = '#feca57'; // Kuning untuk sedang
                
                // Buat circle marker dengan ukuran sesuai jumlah konflik
                const marker = L.circleMarker(coords, {
                    radius: Math.max(8, count * 3), // Minimal radius 8, maksimal sesuai jumlah konflik
                    fillColor: color,
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map);
                
                // Buat konten popup yang informatif
                let popupContent = `<div style="min-width: 200px;">
                    <h5 style="margin: 0 0 10px 0; color: #2d3748;">${district}</h5>
                    <p style="margin: 0 0 5px 0;"><strong>Total Konflik: ${count}</strong></p>
                    <p style="margin: 0 0 5px 0;">🔴 Tinggi: ${highCount}</p>
                    <p style="margin: 0 0 5px 0;">🟡 Sedang: ${mediumCount}</p>
                    <p style="margin: 0 0 10px 0;">🟢 Rendah: ${lowCount}</p>
                    <div style="max-height: 150px; overflow-y: auto;">`;
                
                // Tampilkan maksimal 5 konflik pertama
                conflicts.slice(0, 5).forEach(conflict => {
                    popupContent += `<div style="padding: 5px; margin: 2px 0; background: #f8f9fa; border-radius: 4px; font-size: 0.85em;">
                        <strong>${conflict.nama_potensi}</strong><br>
                        <small>${conflict.kategori} - ${conflict.lokasi_kelurahan}</small>
                    </div>`;
                });
                
                // Jika ada lebih dari 5 konflik, tampilkan info tambahan
                if (conflicts.length > 5) {
                    popupContent += `<p style="margin: 5px 0 0 0; font-size: 0.8em; color: #666;">Dan ${conflicts.length - 5} lainnya...</p>`;
                }
                
                popupContent += '</div></div>';
                
                marker.bindPopup(popupContent);
                markers.push(marker);
            }
        });
    }


    // UPDATE STATISTIK CARDS
    function updateStatistics() {
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


    // UPDATE TABEL DATA
    function updateTable() {
        const filteredData = getFilteredData();
        const tableBody = document.getElementById('tableBody');
        
        // Show/hide baris tabel berdasarkan filter tahun
        const allRows = tableBody.querySelectorAll('tr');
        allRows.forEach(row => {
            const rowYear = row.getAttribute('data-year');
            if (!currentYear || rowYear === currentYear) {
                row.style.display = ''; // Tampilkan baris
            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });
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
                        ticks: { color: '#718096', maxRotation: 45 },
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
        const labels = Object.keys(data);
        const values = Object.values(data);

        charts.kecamatan.data.labels = labels;
        charts.kecamatan.data.datasets[0].data = values;
        charts.kecamatan.update();
    }

    // Update Chart Tingkat Potensi dengan data baru dan warna sesuai tingkat
    function updateTingkatChart(data) {
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        // Warna khusus untuk setiap tingkat potensi
        const colors = {
            'Rendah': ['rgba(150, 206, 180, 0.8)', '#96ceb4'],  // Hijau
            'Sedang': ['rgba(254, 202, 87, 0.8)', '#feca57'],   // Kuning
            'Tinggi': ['rgba(255, 107, 107, 0.8)', '#ff6b6b']   // Merah
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
        // Kelompokkan data berdasarkan bulan-tahun
        const monthlyData = {};
        filteredData.forEach(item => {
            const date = new Date(item.tanggal);
            const monthYear = date.toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'short' 
            });
            monthlyData[monthYear] = (monthlyData[monthYear] || 0) + 1;
        });

        // Urutkan berdasarkan tanggal
        const sortedMonths = Object.keys(monthlyData).sort((a, b) => {
            const dateA = new Date(a + ' 1, 2000');
            const dateB = new Date(b + ' 1, 2000');
            return dateA - dateB;
        });

        const labels = sortedMonths;
        const values = sortedMonths.map(month => monthlyData[month]);

        charts.timeline.data.labels = labels;
        charts.timeline.data.datasets[0].data = values;
        charts.timeline.update();
    }


    // UNGSI UTAMA UPDATE SEMUA
    // Fungsi utama yang dipanggil untuk update semua visualisasi
    function updateVisualization() {
        updateMap();         // Update peta dan marker
        updateStatistics();  // Update angka di stat cards
        updateTable();       // Update tabel data
        updateCharts();      // Update semua charts
        animateNumbers();    // Animasi angka di stat cards
    }

    
    // ANIMASI ANGKA STATISTIK
    // Memberikan efek animasi counting up pada angka statistik
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