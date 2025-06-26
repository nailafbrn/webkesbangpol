@extends('dashboard.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="container text-center mt-5">
    <h4 class="mb-5 font-weight-bold">STRUKTUR ORGANISASI BADAN KESATUAN BANGSA DAN POLITIK</h4>

    <div style="position: relative; width: 1000px; height: 900px; margin: auto; ">
        <!-- SVG untuk garis -->
        <svg id="connector-svg" width="1000" height="800" style="position: absolute; top: 0; left: 0; z-index: 0;"></svg>

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
        
        <div id="kepala-badan" class="box" style="top: 0px; left: 300px;">
            @php $kepala = getByJabatan($strukturors, 'Kepala Badan Kesatuan Bangsa dan Politik Kota Bandung'); @endphp
            <div class="bold-text">{{ $kepala->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $kepala->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $kepala->formatted_nip ?? '' }} /{{ $kepala->golongan ?? '' }} {{ $kepala->pangkat ?? '' }}</div>
        </div>
        
        <div id="sekretaris-badan" class="box" style="top: 150px; left: 700px;">
            @php $sekretaris = getByJabatan($strukturors, 'Sekertaris Badan Kesatuan Bangsa dan Politik Kota Bandung'); @endphp
            <div class="bold-text">{{ $sekretaris->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $sekretaris->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $sekretaris->formatted_nip ?? '' }} /{{ $sekretaris->golongan ?? '' }} {{ $sekretaris->pangkat ?? '' }}</div>
        </div>

        <div id="kelompok-fungsional" class="box" style="top: 320px; left: 50px;  font-weight: bold;">KELOMPOK JABATAN FUNGSIONAL</div>
        
        <div id="subbag-umum" class="box" style="top: 310px; left: 570px;">
            @php $subbag = getByJabatan($strukturors, 'Kepala Sub Bagian Umum dan Kepegawaian'); @endphp
            <div class="bold-text">{{ $subbag->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $subbag->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $subbag->formatted_nip ?? '' }} /{{ $subbag->golongan ?? '' }} {{ $subbag->pangkat ?? '' }}</div>

        </div>
        
        <div id="bidang-1" class="box bidang" style="top: 500px; left: 5px;">
            @php $b1 = getByJabatan($strukturors, 'Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa'); @endphp
            <div class="bold-text">{{ $b1->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $b1->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $b1->formatted_nip ?? '' }} /{{ $b1->golongan ?? '' }} {{ $b1->pangkat ?? '' }}</div>

        </div>
        
        <div id="bidang-2" class="box bidang" style="top: 500px; left: 260px;">
            @php $b2 = getByJabatan($strukturors, 'Kepala Bidang Politik Dalam Negeri'); @endphp
            <div class="bold-text">{{ $b2->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $b2->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $b2->formatted_nip ?? '' }} /{{ $b2->golongan ?? '' }} {{ $b2->pangkat ?? '' }}</div>

        </div>
        
        <div id="bidang-3" class="box bidang" style="top: 500px; left: 485px;">
            @php $b3 = getByJabatan($strukturors, 'Kepala Bidang Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Organisasi Kemasyarakatan'); @endphp
            <div class="bold-text">{{ $b3->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $b3->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $b3->formatted_nip ?? '' }} /{{ $b3->golongan ?? '' }} {{ $b3->pangkat ?? '' }}</div>

        </div>
        
        <div id="bidang-4" class="box bidang" style="top: 500px; left: 740px;">
            @php $b4 = getByJabatan($strukturors, 'Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik'); @endphp
            <div class="bold-text">{{ $b4->jabatan ?? '' }}</div>
            <div class="bold-text">{{ $b4->nama ?? '' }}</div>
            <div style="color: black">NIP. {{ $b4->formatted_nip ?? '' }} /{{ $b4->golongan ?? '' }} {{ $b4->pangkat ?? '' }}</div>

        </div>
    </div>
    <div class="text-right mb-3">
        <button id="save-as-image" class="btn btn-success">Simpan Struktur Sebagai Gambar</button>
    </div>
</div>
@endsection

@section('css')
<style>
    .bold-text {
        font-weight: bold;
    }


    .box {
        position: absolute;
        min-width: 180px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 2px solid #6c757d;
        border-radius: 10px;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        font-size: 14px;
        text-align: center;
        line-height: 1.4;
        z-index: 1;
    }

    .box div {
        margin-bottom: 4px;
    }

    .box div:last-child {
        margin-bottom: 0;
        font-size: 13px;
        color: #555;
    }

    /* Optional: hover effect biar interaktif */
    .box:hover {
        background-color: #e2e6ea;
        cursor: default;
    }

    .box.bidang {
        min-width: 190px;
        max-width: 250px;
        word-wrap: break-word;
        white-space: normal;
        padding: 8px 8px;
        font-size: 13px;
    }

    .box div {
        margin-bottom: 6px;
        word-break: break-word;
    }
</style>

@endsection

@section('js')

<script>

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

        const midY = 450; // posisi garis horizontal
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

    function generateLineFromSekretarisToBidangs() {
        const svg = document.getElementById("connector-svg");
        const svgBox = svg.getBoundingClientRect();
        const sekretaris = document.getElementById("sekretaris-badan");
        const bidangIds = ['bidang-1', 'bidang-2', 'bidang-3', 'bidang-4'];

        const start = getCenterBottom(sekretaris, svgBox);

        const verticalY = start.y + 23;
        const horizontalX = 994;
        const downToY = verticalY + 430;

        // Garis utama: dari sekretaris turun → kanan → turun
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
        const verticalY = startY + 100;
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

        // Fungsi bantu khusus garis putus-putus
        function drawDashedLine(points) {
            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", points.join(" "));
            polyline.setAttribute("stroke", "#6c757d");
            polyline.setAttribute("stroke-width", "2");
            polyline.setAttribute("fill", "none");
            polyline.setAttribute("stroke-dasharray", "10,5"); // inilah garis putus-putus
            svg.appendChild(polyline);
        }
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
        const verticalY = startY + 350;
        const horizontalFarRightX = startX + 945;
        const upY = verticalY - 390;
        const leftToEndX = horizontalFarRightX - 100;

        const endX = sekretarisBox.left + (sekretarisBox.width * 0.65) - svgBox.left;
        const endY = sekretarisBox.bottom - svgBox.top;

        drawLine([
            `${startX},${startY}`,
            `${horizontalLeftX},${startY}`,
            `${horizontalLeftX},${verticalY}`,
            `${horizontalFarRightX},${verticalY}`,
            `${horizontalFarRightX},${upY}`,
            `${leftToEndX},${upY}`,
            `${endX},${endY}`
        ]);

        function drawLine(points) {
            const svg = document.getElementById("connector-svg");
            const polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
            polyline.setAttribute("points", points.join(" "));
            polyline.setAttribute("fill", "none");
            polyline.setAttribute("stroke", "#6c757d");
            polyline.setAttribute("stroke-width", "2");
            polyline.setAttribute("stroke-dasharray", "5,5"); // buat garis putus-putus

            svg.appendChild(polyline);
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
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

</script>
@endsection
