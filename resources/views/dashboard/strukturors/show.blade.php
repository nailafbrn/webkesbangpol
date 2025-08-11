@extends('dashboard.layouts.app')

@section('title', 'Struktur Organisasi')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-5 font-weight-bold text-center">STRUKTUR ORGANISASI BADAN KESATUAN BANGSA DAN POLITIK KOTA BANDUNG</h4>

                    <div class="org-chart-container">
                        <!-- SVG untuk garis -->
                        <svg id="connector-svg" width="1000" height="700"></svg>

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

                        <div id="kelompok-fungsional" class="box" style="font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
                        
                        <div id="subbag-umum" class="box">
                            @php $subbag = getByJabatan($strukturors, 'Kepala Sub Bagian Umum dan Kepegawaian'); @endphp
                            <div class="box-jabatan bold-text">{{ $subbag->jabatan ?? '' }}</div>
                            <div class="line-separator"></div>
                            <div class="box-nama bold-text">{{ $subbag->nama ?? '' }}</div>
                            <div class="box-nip">NIP. {{ $subbag->formatted_nip ?? '' }} /{{ $subbag->golongan ?? '' }} {{ $subbag->pangkat ?? '' }}</div>
                        </div>
                        
                        <div id="bidang-1" class="box bidang">
                            @php $b1 = getByJabatan($strukturors, 'Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa'); @endphp
                            <div class="box-jabatan bold-text">{{ $b1->jabatan ?? '' }}</div>
                            <div class="line-separator"></div>
                            <div class="box-nama bold-text">{{ $b1->nama ?? '' }}</div>
                            <div class="box-nip">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>
                        </div>
                        
                        <div id="bidang-2" class="box bidang">
                            @php $b2 = getByJabatan($strukturors, 'Kepala Bidang Politik Dalam Negeri'); @endphp
                            <div class="box-jabatan bold-text">{{ $b2->jabatan ?? '' }}</div>
                            <div class="line-separator"></div>
                            <div class="box-nama bold-text">{{ $b2->nama ?? '' }}</div>
                            <div class="box-nip">NIP. {{ $b2->formatted_nip ?? '' }} /{{ $b2->golongan ?? '' }} {{ $b2->pangkat ?? '' }}</div>
                        </div>
                        
                        <div id="bidang-3" class="box bidang">
                            @php $b3 = getByJabatan($strukturors, 'Kepala Bidang Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Organisasi Kemasyarakatan'); @endphp
                            <div class="box-jabatan bold-text">{{ $b3->jabatan ?? '' }}</div>
                            <div class="line-separator"></div>
                            <div class="box-nama bold-text">{{ $b3->nama ?? '' }}</div>
                            <div class="box-nip">NIP. {{ $b3->formatted_nip ?? '' }} /{{ $b3->golongan ?? '' }} {{ $b3->pangkat ?? '' }}</div>
                        </div>
                        
                        <div id="bidang-4" class="box bidang">
                            @php $b4 = getByJabatan($strukturors, 'Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik'); @endphp
                            <div class="box-jabatan bold-text">{{ $b4->jabatan ?? '' }}</div>
                            <div class="line-separator"></div>
                            <div class="box-nama bold-text">{{ $b4->nama ?? '' }}</div>
                            <div class="box-nip">NIP. {{ $b4->formatted_nip ?? '' }} /{{ $b4->golongan ?? '' }} {{ $b4->pangkat ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Organization Chart Connections
    document.addEventListener('DOMContentLoaded', () => {
        generatePolylinePath('kepala-badan', 'sekretaris-badan');
        generatePolylineToKelompokFungsional();
        generatePolylinePath('sekretaris-badan', 'subbag-umum');

        generatePolylineFromKepalaToBidang('bidang-1');
        generatePolylineFromKepalaToBidang('bidang-2');
        generatePolylineFromKepalaToBidang('bidang-3');
        generatePolylineFromKepalaToBidang('bidang-4');
        generateLineFromSekretarisToBidangs();
        generateLineFromKelompokFungsionalToBidangs();
        generateLineFromKelompokFungsionalToSekretaris();

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
        polyline.setAttribute("stroke", "#6c757d");
        polyline.setAttribute("stroke-width", "2");
        polyline.setAttribute("fill", "none");

        svg.appendChild(polyline);
    }

    function generatePolylineFromKepalaToBidang(bidangId) {
        const kepala = document.getElementById('kepala-badan');
        const target = document.getElementById(bidangId);
        const svg = document.getElementById('connector-svg');

        if (!kepala || !target || !svg) return;

        const kepalaBox = kepala.getBoundingClientRect();
        const targetBox = target.getBoundingClientRect();
        const svgBox = svg.getBoundingClientRect();

        const startX = kepalaBox.left + kepalaBox.width / 2 - svgBox.left;
        const startY = kepalaBox.bottom - svgBox.top;

        const midY = 410; // posisi garis horizontal
        const endX = targetBox.left + targetBox.width / 2 - svgBox.left;
        const endY = targetBox.top - svgBox.top;

        const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
        polyline.setAttribute("points", `
            ${startX},${startY}
            ${startX},${midY}
            ${endX},${midY}
            ${endX},${endY}
        `);
        polyline.setAttribute("stroke", "#6c757d");
        polyline.setAttribute("stroke-width", "2");
        polyline.setAttribute("fill", "none");

        svg.appendChild(polyline);
    }

    function generatePolylineToKelompokFungsional() {
        const fromEl = document.getElementById('kepala-badan');
        const toEl = document.getElementById('kelompok-fungsional');
        const svg = document.getElementById('connector-svg');

        if (!fromEl || !toEl || !svg) return;

        const fromBox = fromEl.getBoundingClientRect();
        const toBox = toEl.getBoundingClientRect();
        const svgBox = svg.getBoundingClientRect();

        // Titik awal: tengah bawah kepala-badan
        const startX = fromBox.left + fromBox.width / 2 - svgBox.left;
        const startY = fromBox.bottom - svgBox.top;

        // Titik tengah horizontal kanan dari kelompok-fungsional
        const endX = toBox.right - svgBox.left;
        const endY = toBox.top + toBox.height / 2 - svgBox.top;

        // Titik vertikal turun dulu 200px
        const midY = startY + 250;

        // Titik horizontal sebelum masuk ke sisi kanan kelompok-fungsional
        const midX = endX;

        const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
        polyline.setAttribute("points", `
            ${startX},${startY}
            ${startX},${midY}
            ${midX},${midY}
            ${endX},${endY}
        `);
        polyline.setAttribute("stroke", "#6c757d");
        polyline.setAttribute("stroke-width", "2");
        polyline.setAttribute("fill", "none");

        svg.appendChild(polyline);
    }

    function drawLine(points) {
        const svg = document.getElementById("connector-svg");
        const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
        polyline.setAttribute("points", points.join(" "));
        polyline.setAttribute("stroke", "#6c757d");
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

    // function generateLineFromSekretarisToBidangs() {
        const svg = document.getElementById("connector-svg");
        const svgBox = svg.getBoundingClientRect();
        const sekretaris = document.getElementById("sekretaris-badan");
        const bidangIds = ['bidang-1', 'bidang-2', 'bidang-3', 'bidang-4'];

        const start = getCenterBottom(sekretaris, svgBox);

        const verticalY = start.y + 23;
        const horizontalX = 975;
        const downToY = verticalY + 340;

        // // Garis utama: dari sekretaris turun → kanan → turun
        const mainLinePoints = [
            `${start.x},${start.y}`,
            `${start.x},${verticalY}`,
            `${horizontalX},${verticalY}`,
            `${horizontalX},${downToY}`
        ];
        drawLine(mainLinePoints);

        // Cabang ke tiap bidang
        bidangIds.forEach(id => {
            const bidang = document.getElementById(id);
            const target = getCenterTop(bidang, svgBox);
            drawLine([
                `${horizontalX},${downToY}`,
                `${target.x},${downToY}`,
                `${target.x},${target.y}`
            ]);
        });
    }

    function generateLineFromKelompokFungsionalToBidangs() {
        const svg = document.getElementById("connector-svg");
        const svgBox = svg.getBoundingClientRect();
        const kelompok = document.getElementById("kelompok-fungsional");
        const bidangIds = ['bidang-1', 'bidang-2', 'bidang-3', 'bidang-4'];

        const kelompokRect = kelompok.getBoundingClientRect();

        // Titik awal: tengah kiri kelompok-fungsional
        const startX = kelompokRect.left - svgBox.left;
        const startY = kelompokRect.top + kelompokRect.height / 2 - svgBox.top;

        // Belok kiri → turun → turun
        const horizontalLeftX = startX - 48;
        const verticalY = startY + 50;
        const downToY = verticalY + 250;

        // Garis utama (putus-putus)
        drawDashedLine([
            `${startX},${startY}`,
            `${horizontalLeftX},${startY}`,
            `${horizontalLeftX},${verticalY}`,
            `${horizontalLeftX},${downToY}`
        ]);

        // Fungsi lokal: titik tengah atas bidang tapi digeser kanan 20px
        function getRightShiftedTop(el) {
            const rect = el.getBoundingClientRect();
            return {
                x: rect.left + rect.width / 2 + 20 - svgBox.left,
                y: rect.top - svgBox.top,
            };
        }

        // Cabang ke tiap bidang (juga putus-putus)
        bidangIds.forEach(id => {
            const bidang = document.getElementById(id);
            const target = getRightShiftedTop(bidang);
            drawDashedLine([
                `${horizontalLeftX},${downToY}`,
                `${target.x},${downToY}`,
                `${target.x},${target.y}`
            ]);
        });
    }

    function drawDashedLine(points) {
        const svg = document.getElementById("connector-svg");
        const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
        polyline.setAttribute("points", points.join(" "));
        polyline.setAttribute("stroke", "#6c757d");
        polyline.setAttribute("stroke-width", "2");
        polyline.setAttribute("fill", "none");
        polyline.setAttribute("stroke-dasharray", "10,5"); // inilah garis putus-putus
        svg.appendChild(polyline);
    }

    function generateLineFromKelompokFungsionalToSekretaris() {
        const svg = document.getElementById("connector-svg");
        const svgBox = svg.getBoundingClientRect();
        const kelompok = document.getElementById("kelompok-fungsional");
        const sekretaris = document.getElementById("sekretaris-badan");

        const kelompokBox = kelompok.getBoundingClientRect();
        const sekretarisBox = sekretaris.getBoundingClientRect();

        // Titik awal: tengah kiri kelompok-fungsional
        const startX = kelompokBox.left - svgBox.left;
        const startY = kelompokBox.top + kelompokBox.height / 2 - svgBox.top;

        const horizontalLeftX = startX - 48;
        const verticalY = startY + 300;
        const horizontalFarRightX = startX + 940;
        const upY = verticalY - 380;
        const leftToEndX = horizontalFarRightX - 150;

        const endX = sekretarisBox.left + (sekretarisBox.width * 0.65) - svgBox.left;
        const endY = sekretarisBox.bottom - svgBox.top;

        const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
        polyline.setAttribute("points", `
            ${startX},${startY}
            ${horizontalLeftX},${startY}
            ${horizontalLeftX},${verticalY}
            ${horizontalFarRightX},${verticalY}
            ${horizontalFarRightX},${upY}
            ${leftToEndX},${upY}
            ${endX},${endY}
        `);
        polyline.setAttribute("fill", "none");
        polyline.setAttribute("stroke", "#6c757d");
        polyline.setAttribute("stroke-width", "2");
        polyline.setAttribute("stroke-dasharray", "5,5"); // buat garis putus-putus

        svg.appendChild(polyline);
    }
</script>
@endsection
