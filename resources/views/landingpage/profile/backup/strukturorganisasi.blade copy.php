@extends('landingpage.layouts.app')
@section('title', 'Struktur Organisasi')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/share-page.css') }}"> --}}

@section('content')
    <section class="visimisi-hero">
        <div class="floating-elements">
            <div class="float-element float-1"></div>
            <div class="float-element float-2"></div>
            <div class="float-element float-3"></div>
            <div class="float-element float-4"></div>
        </div>
        <div class="visimisi-hero-overlay"></div>
        <div class="visimisi-hero-content">
            <div class="hero-badge">Org Structure</div>
            <h1 class="visimisi-title">STRUKTUR ORGANISASI</h1>
            <p class="visimisi-subtitle">Badan Kesatuan Bangsa dan Politik Kota Bandung</p>

        </div>
        <div class="hero-shape"></div>
    </section>

    <section class="strukturorg-section">
        <div class="strukturorg-container" data-aos="fade-up">
            <div class="org-chart-container">
                <!-- SVG untuk garis -->
                <svg id="connector-svg" width="1200" height="650" style="background-color: #ffff"></svg>

                <!-- Elemen box -->
                @php
                    function getByJabatan($strukturors, $jabatan) {
                        $data = $strukturors->firstWhere('jabatan', $jabatan);
                        if ($data && isset($data->nip)) {
                            $formattedNip = substr($data->nip, 0, 8) . ' ' .
                                            substr($data->nip, 8, 6) . ' ' .
                                            substr($data->nip, 14, 1) . ' ' .
                                            substr($data->nip, 15, 3);
                            $data->formatted_nip = $formattedNip;
                        }
                        return $data;
                    }
                @endphp
                
                <div id="kepala-badan" class="box">
                    @php $kepala = getByJabatan($strukturors, 'Kepala Badan Kesatuan Bangsa dan Politik Kota Bandung'); @endphp
                    <div class="box-jabatan bold-text">{{ $kepala->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $kepala->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $kepala->formatted_nip ?? '' }} /{{ $kepala->golongan ?? '' }} {{ $kepala->pangkat ?? '' }}</div>
                </div>
                
                <div id="sekretaris-badan" class="box">
                    @php $sekretaris = getByJabatan($strukturors, 'Sekertaris Badan Kesatuan Bangsa dan Politik Kota Bandung'); @endphp
                    <div class="box-jabatan bold-text">{{ $sekretaris->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $sekretaris->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $sekretaris->formatted_nip ?? '' }} /{{ $sekretaris->golongan ?? '' }} {{ $sekretaris->pangkat ?? '' }}</div>
                </div>

                <div id="kelompok-fungsional1" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                
                <div id="subbag-umum" class="box">
                    @php $subbag = getByJabatan($strukturors, 'Kepala Sub Bagian Umum dan Kepegawaian'); @endphp
                    <div class="box-jabatan bold-text">{{ $subbag->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $subbag->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $subbag->formatted_nip ?? '' }} /{{ $subbag->golongan ?? '' }} {{ $subbag->pangkat ?? '' }}</div>
                </div>

                <div id="kelompok-fungsional2" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>

                <div id="bidang-1" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div>

                {{-- <div id="subkoor-1" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Ideologi dan Wawasan Kebangsaan'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div>

                <div id="subkoor-2" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Bela Negara dan Karakter Bangsa'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div> --}}
                
                <div id="kelompok-fungsional3" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                
                <div id="bidang-2" class="box bidang">
                    @php $b2 = getByJabatan($strukturors, 'Kepala Bidang Politik Dalam Negeri'); @endphp
                    <div class="box-jabatan bold-text">{{ $b2->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b2->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b2->formatted_nip ?? '' }} /{{ $b2->golongan ?? '' }} {{ $b2->pangkat ?? '' }}</div>
                </div>
                
                {{-- <div id="subkoor-3" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Fasilitasi Kelembagaan Pemerintahan, Perwakilan, dan Partai Politik'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div>

                <div id="subkoor-4" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Pendidikan Politik dan Peningkatan Demokrasi'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div> --}}

                <div id="kelompok-fungsional4" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                
                <div id="bidang-3" class="box bidang">
                    @php $b3 = getByJabatan($strukturors, 'Kepala Bidang Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Organisasi Kemasyarakatan'); @endphp
                    <div class="box-jabatan bold-text">{{ $b3->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b3->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b3->formatted_nip ?? '' }} /{{ $b3->golongan ?? '' }} {{ $b3->pangkat ?? '' }}</div>
                </div>
                
                {{-- <div id="subkoor-5" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Ketahanan Ekonomi, Sosial, Budaya dan Agama'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div> --}}

                <div id="kelompok-fungsional5" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                
                <div id="bidang-4" class="box bidang">
                    @php $b4 = getByJabatan($strukturors, 'Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik'); @endphp
                    <div class="box-jabatan bold-text">{{ $b4->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b4->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b4->formatted_nip ?? '' }} /{{ $b4->golongan ?? '' }} {{ $b4->pangkat ?? '' }}</div>
                </div>

                {{-- <div id="subkoor-6" class="box bidang">
                    @php $b1 = getByJabatan($strukturors, 'Subkoordinator Kewaspadaan Dini dan Kerjasama Intelijen'); @endphp
                    <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                    <div class="line-separator"></div>
                    <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                    <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                </div> --}}

                <div id="kelompok-fungsional6" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                
            </div>
        </div>
    </section>

    

    <script>
        // Organization Chart Connections
        document.addEventListener('DOMContentLoaded', () => {
            generatePolylineFromKepalaToSekretaris('kepala-badan', 'sekretaris-badan');
            generatePolylineToKelompokFungsional();
            generatePolylinePath('sekretaris-badan', 'subbag-umum');
            generatePolylinePath('sekretaris-badan', 'kelompok-fungsional2');
            
            // generatePolylinePath('bidang-1', 'subkoor-1');
            // generatePolylinePath('bidang-1', 'subkoor-2');
            generatePolylinePath('bidang-1', 'kelompok-fungsional3');

            // generatePolylinePath('bidang-2', 'subkoor-3');
            // generatePolylinePath('bidang-2', 'subkoor-4');
            generatePolylinePath('bidang-2', 'kelompok-fungsional4');

            // generatePolylinePath('bidang-3', 'subkoor-5');
            generatePolylinePath('bidang-3', 'kelompok-fungsional5');

            generatePolylinePath('bidang-4', 'subkoor-6');
            generatePolylinePath('bidang-4', 'kelompok-fungsional6');
            
            generatePolylineFromKepalaToBidang('bidang-1');
            generatePolylineFromKepalaToBidang('bidang-2');
            generatePolylineFromKepalaToBidang('bidang-3');
            generatePolylineFromKepalaToBidang('bidang-4');

        });

        function generatePolylinePath(fromId, toId) {
            const fromEl = document.getElementById(fromId);
            const toEl = document.getElementById(toId);
            const svg = document.getElementById('connector-svg');

            if (!fromEl || !toEl || !svg) return;

            const fromBox = fromEl.getBoundingClientRect();
            const toBox = toEl.getBoundingClientRect();
            const svgBox = svg.getBoundingClientRect();

            const fromX = fromBox.left + fromBox.width / 2 - svgBox.left;
            const fromY = fromBox.top + fromBox.height - svgBox.top;

            const toX = toBox.left + toBox.width / 2 - svgBox.left;
            const toY = toBox.top - svgBox.top;

            const midY = (fromY + toY) / 2;

            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", `${fromX},${fromY} ${fromX},${midY} ${toX},${midY} ${toX},${toY}`);
            polyline.setAttribute("stroke", "#B40D1A");
            polyline.setAttribute("stroke-width", "2");
            polyline.setAttribute("fill", "none");

            svg.appendChild(polyline);
        }

        function generatePolylineFromKepalaToSekretaris(fromId, toId) {
            const fromEl = document.getElementById(fromId);
            const toEl = document.getElementById(toId);
            const svg = document.getElementById('connector-svg');

            if (!fromEl || !toEl || !svg) return;

            const fromBox = fromEl.getBoundingClientRect();
            const toBox = toEl.getBoundingClientRect();
            const svgBox = svg.getBoundingClientRect();

            // Titik awal: kanan tengah dari fromEl
            const fromX = fromBox.right - svgBox.left;
            const fromY = fromBox.top + fromBox.height / 2 - svgBox.top;

            // Titik akhir: tengah atas dari toEl
            const toX = toBox.left + toBox.width / 2 - svgBox.left;
            const toY = toBox.top - svgBox.top;

            // Titik belok: lurus ke kanan dari fromX ke sejajar toX (tetap di fromY)
            // lalu turun dari situ ke toY
            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", `${fromX},${fromY} ${toX},${fromY} ${toX},${toY}`);
            polyline.setAttribute("stroke", "#B40D1A");
            polyline.setAttribute("stroke-width", "1.5");
            polyline.setAttribute("fill", "none");

            svg.appendChild(polyline);
        }


function generatePolylineFromKepalaToBidang(bidangId) {
    const kepala = document.getElementById('kepala-badan');
    const target = document.getElementById(bidangId);
    const svg = document.getElementById('connector-svg');
    const subbag = document.getElementById('subbag-umum');

    if (!kepala || !target || !svg || !subbag) return;

    const kepalaBox = kepala.getBoundingClientRect();
    const targetBox = target.getBoundingClientRect();
    const svgBox = svg.getBoundingClientRect();
    const subbagBox = subbag.getBoundingClientRect();

    const startX = kepalaBox.left + kepalaBox.width / 2 - svgBox.left;
    const startY = kepalaBox.bottom - svgBox.top;

    // MidY adalah bottom subbag-umum + 50px
    const midY = subbagBox.bottom - svgBox.top + 20;

    const endX = targetBox.left + targetBox.width / 2 - svgBox.left;
    const endY = targetBox.top - svgBox.top;

    const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
    polyline.setAttribute("points", `
        ${startX},${startY}
        ${startX},${midY}
        ${endX},${midY}
        ${endX},${endY}
    `);
    polyline.setAttribute("stroke", "#B40D1A");
    polyline.setAttribute("stroke-width", "2");
    polyline.setAttribute("fill", "none");

    svg.appendChild(polyline);
}


        function generatePolylineToKelompokFungsional() {
            const fromEl = document.getElementById('kepala-badan');
            const toEl = document.getElementById('kelompok-fungsional1');
            const svg = document.getElementById('connector-svg');

            if (!fromEl || !toEl || !svg) return;

            const fromBox = fromEl.getBoundingClientRect();
            const toBox = toEl.getBoundingClientRect();
            const svgBox = svg.getBoundingClientRect();

            // Titik awal: tengah bawah kepala-badan
            const startX = fromBox.left + fromBox.width / 2 - svgBox.left;
            const startY = fromBox.bottom - svgBox.top;

            // Titik akhir: tengah kanan kelompok-fungsional
            const endX = toBox.right - svgBox.left;
            const endY = toBox.top + toBox.height / 2 - svgBox.top;

            // midY-nya samakan dengan endY biar lurus
            const midY = endY;
            const midX = endX;

            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", `
                ${startX},${startY}
                ${startX},${midY}
                ${midX},${midY}
                ${endX},${endY}
            `);
            polyline.setAttribute("stroke", "#B40D1A");
            polyline.setAttribute("stroke-width", "2");
            polyline.setAttribute("fill", "none");

            svg.appendChild(polyline);
        }


        function drawLine(points) {
            const svg = document.getElementById("connector-svg");
            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", points.join(" "));
            polyline.setAttribute("stroke", "#B40D1A");
            polyline.setAttribute("stroke-width", "2");
            polyline.setAttribute("fill", "none");
            svg.appendChild(polyline);
        }

        function getCenterBottom(el, svgBox) {
            const rect = el.getBoundingClientRect();
            return {
                x: rect.left + rect.width / 2 - svgBox.left,
                y: rect.bottom - svgBox.top,
            };
        }

        function getCenterTop(el, svgBox) {
            const rect = el.getBoundingClientRect();
            return {
                x: rect.left + rect.width / 2 - svgBox.left,
                y: rect.top - svgBox.top,
            };
        }

    </script>
@endsection

