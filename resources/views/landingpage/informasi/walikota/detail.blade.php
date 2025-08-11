@extends('landingpage.layouts.app')

@section('content')

<style>
    .table-details {
        table-layout: fixed;
        width: 100%;
    }
    .table-details th {
        width: 150px;
        vertical-align: top;
    }
    .table-details td {
        word-wrap: break-word;
        vertical-align: top;
    }
</style>

<div class="container my-5">
    @php
        $isPilpres = ($paslon->jenis_pemilu == 'pilpres');
        $label_calon_1 = $isPilpres ? 'Kandidat Presiden' : 'Kandidat Wali Kota';
        $label_calon_2 = $isPilpres ? 'Kandidat Wakil Presiden' : 'Kandidat Wakil Wali Kota';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #B40D14;">Detail Paslon #{{ $paslon->no_urut }}</h2>
        <a href="{{ route('pemilu.show', $paslon->jenis_pemilu) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- KARTU CALON UTAMA --}}
    <div class="card shadow-lg mb-4">
        <div class="card-header text-white" style="background-color: #B40D14;">
            <h4 class="mb-0"><i class="fas fa-user me-2"></i>{{ $label_calon_1 }}</h4>
        </div>
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center p-3">
                @if($paslon->capres_foto && file_exists(public_path($paslon->capres_foto)))
                    <img src="{{ asset($paslon->capres_foto) }}"
                         class="img-fluid rounded shadow"
                         alt="Foto {{ $paslon->capres_nama }}"
                         style="width: 100%; height: 350px; object-fit: cover; object-position: top;">
                @else
                    <img src="https://placehold.co/300x400/e2e8f0/e2e8f0?text=Foto" 
                         class="img-fluid rounded shadow"
                         alt="Foto tidak tersedia"
                         style="width: 100%; height: 350px; object-fit: cover;">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title mb-4" style="color: #B40D14;">{{ $paslon->capres_nama }}</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-borderless table-details">
                                <tr>
                                    <th class="text-muted"><i class="fas fa-hashtag me-2"></i>No Urut</th>
                                    <td><span class="badge fs-6" style="background-color: #B40D14;">{{ $paslon->no_urut }}</span></td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-user me-2"></i>Nama</th>
                                    <td>{{ $paslon->capres_nama }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir</th>
                                    <td>{{ $paslon->capres_tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-calendar me-2"></i>Tgl. Lahir</th>
                                    <td>{{ \Carbon\Carbon::parse($paslon->capres_tanggal_lahir)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-graduation-cap me-2"></i>Pendidikan</th>
                                    <td>{!! nl2br(e($paslon->capres_riwayat_pendidikan)) !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-borderless table-details">
                                <tr>
                                    <th class="text-muted"><i class="fas fa-briefcase me-2"></i>Pekerjaan</th>
                                    <td>{!! nl2br(e($paslon->capres_riwayat_pekerjaan)) !!}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</th>
                                    <td>{{ $paslon->capres_jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-flag me-2"></i>Partai</th>
                                    <td>{{ $paslon->partai_pengusung }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-calendar-check me-2"></i>Tahun</th>
                                    <td>{{ $paslon->tahun_pemilu }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU WAKIL (jika ada) --}}
    @if(!empty($paslon->cawapres_nama))
    <div class="card shadow-lg mb-4">
        <div class="card-header text-white" style="background-color: #B40D14;">
            <h4 class="mb-0"><i class="fas fa-user-tie me-2"></i>{{ $label_calon_2 }}</h4>
        </div>
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center p-3">
                @if($paslon->cawapres_foto && file_exists(public_path($paslon->cawapres_foto)))
                    <img src="{{ asset($paslon->cawapres_foto) }}"
                         class="img-fluid rounded shadow"
                         alt="Foto {{ $paslon->cawapres_nama }}"
                         style="width: 100%; height: 350px; object-fit: cover; object-position: top;">
                @else
                    <img src="https://placehold.co/300x400/e2e8f0/e2e8f0?text=Foto" 
                         class="img-fluid rounded shadow"
                         alt="Foto tidak tersedia"
                         style="width: 100%; height: 350px; object-fit: cover;">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title mb-4" style="color: #B40D14;">{{ $paslon->cawapres_nama }}</h3>
                    {{-- PERBAIKAN: Menggunakan layout 2 kolom seperti di atas --}}
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-borderless table-details">
                                <tr>
                                    <th class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir</th>
                                    <td>{{ $paslon->cawapres_tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-calendar me-2"></i>Tgl. Lahir</th>
                                    <td>{{ $paslon->cawapres_tanggal_lahir ? \Carbon\Carbon::parse($paslon->cawapres_tanggal_lahir)->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</th>
                                    <td>{{ $paslon->cawapres_jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-graduation-cap me-2"></i>Pendidikan</th>
                                    <td>{!! nl2br(e($paslon->cawapres_riwayat_pendidikan)) !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-borderless table-details">
                                <tr>
                                    <th class="text-muted"><i class="fas fa-briefcase me-2"></i>Pekerjaan</th>
                                    <td>{!! nl2br(e($paslon->cawapres_riwayat_pekerjaan)) !!}</td>
                                </tr>
                                {{-- PENAMBAHAN: Menampilkan Partai dan Tahun untuk Wakil --}}
                                <tr>
                                    <th class="text-muted"><i class="fas fa-flag me-2"></i>Partai</th>
                                    <td>{{ $paslon->partai_pengusung }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted"><i class="fas fa-calendar-check me-2"></i>Tahun</th>
                                    <td>{{ $paslon->tahun_pemilu }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Visi, Misi & Total Suara --}}
    <div class="card shadow-lg mt-4">
        <div class="card-header text-white" style="background-color: #B40D14;">
            <h4 class="mb-0"><i class="fas fa-bullseye me-2"></i>Rekapitulasi</h4>
        </div>
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h5 class="text-uppercase">Total Perolehan Suara Paslon</h5>
                <p class="display-4 fw-bold" style="color: #B40D14;">{{ number_format($paslon->total_suara ?? 0, 0, ',', '.') }}</p>
                <small class="text-muted">(Kota Bandung)</small>
            </div>
            <hr>
            @if(!empty($paslon->visi))
            <div class="mb-4">
                <h5 class="text-danger"><i class="fas fa-eye me-2"></i>Visi</h5>
                <div class="ps-3">{!! nl2br(e($paslon->visi)) !!}</div>
            </div>
            @endif
            @if(!empty($paslon->misi))
            <div>
                <h5 class="text-danger"><i class="fas fa-bullseye me-2"></i>Misi</h5>
                <div class="ps-3">{!! nl2br(e($paslon->misi)) !!}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
