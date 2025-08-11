@extends('dashboard.layouts.app')

@section('content')
<style>
    /* Style untuk memperjelas pemisahan data */
    .detail-group {
        margin-bottom: 1.5rem;
    }
    .detail-group h4 {
        color: #B40D14;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    /* PERUBAHAN: Style untuk layout rata kiri, label di atas nilai */
    .detail-item {
        margin-bottom: 1rem; /* Memberi jarak antar item */
    }
    .detail-item .label {
        font-weight: 600;
        color: #6c757d;
        display: block; /* Membuat label menjadi elemen block */
        margin-bottom: 0.25rem; /* Jarak kecil antara label dan nilai */
        font-size: 0.9rem;
    }
    .detail-item .value {
        /* Tidak perlu style khusus, akan mengikuti alur normal (rata kiri) */
        padding-left: 0.5rem; /* Sedikit indentasi untuk nilai */
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Detail Paslon #{{ $paslon->no_urut }}</h3>
            <a href="{{ route('admin.pemilu.pilpres.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- KOLOM CALON WALI KOTA --}}
                <div class="col-md-6">
                    <div class="detail-group">
                        <h4>Kandidat Wali Kota</h4>
                        <div class="text-center mb-3">
                            @if($paslon->capres_foto && file_exists(public_path($paslon->capres_foto)))
                                <img src="{{ asset($paslon->capres_foto) }}" alt="Foto {{ $paslon->capres_nama }}" class="img-fluid rounded" style="max-height: 300px;">
                            @else
                                <img src="https://placehold.co/300x400/e2e8f0/e2e8f0?text=Foto" alt="Foto tidak tersedia" class="img-fluid rounded" style="max-height: 300px;">
                            @endif
                        </div>
                        <div class="detail-item">
                            <span class="label">Nama Lengkap</span>
                            <span class="value">{{ $paslon->capres_nama }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Tempat, Tanggal Lahir</span>
                            <span class="value">{{ $paslon->capres_tempat_lahir }}, {{ \Carbon\Carbon::parse($paslon->capres_tanggal_lahir)->format('d F Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Jenis Kelamin</span>
                            <span class="value">{{ $paslon->capres_jenis_kelamin }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Riwayat Pendidikan</span>
                            <div class="value">{!! nl2br(e($paslon->capres_riwayat_pendidikan)) !!}</div>
                        </div>
                        <div class="detail-item">
                            <span class="label">Riwayat Pekerjaan</span>
                            <div class="value">{!! nl2br(e($paslon->capres_riwayat_pekerjaan)) !!}</div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM CALON WAKIL WALI KOTA --}}
                <div class="col-md-6">
                    <div class="detail-group">
                        <h4>Kandidat Wakil Wali Kota</h4>
                        <div class="text-center mb-3">
                            @if($paslon->cawapres_foto && file_exists(public_path($paslon->cawapres_foto)))
                                <img src="{{ asset($paslon->cawapres_foto) }}" alt="Foto {{ $paslon->cawapres_nama }}" class="img-fluid rounded" style="max-height: 300px;">
                            @else
                                <img src="https://placehold.co/300x400/e2e8f0/e2e8f0?text=Foto" alt="Foto tidak tersedia" class="img-fluid rounded" style="max-height: 300px;">
                            @endif
                        </div>
                        <div class="detail-item">
                            <span class="label">Nama Lengkap</span>
                            <span class="value">{{ $paslon->cawapres_nama ?? '-' }}</span>
                        </div>
                        @if($paslon->cawapres_tempat_lahir)
                        <div class="detail-item">
                            <span class="label">Tempat, Tanggal Lahir</span>
                            <span class="value">{{ $paslon->cawapres_tempat_lahir }}, {{ $paslon->cawapres_tanggal_lahir ? \Carbon\Carbon::parse($paslon->cawapres_tanggal_lahir)->format('d F Y') : '' }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="label">Jenis Kelamin</span>
                            <span class="value">{{ $paslon->cawapres_jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Riwayat Pendidikan</span>
                            <div class="value">{!! nl2br(e($paslon->cawapres_riwayat_pendidikan)) !!}</div>
                        </div>
                        <div class="detail-item">
                            <span class="label">Riwayat Pekerjaan</span>
                            <div class="value">{!! nl2br(e($paslon->cawapres_riwayat_pekerjaan)) !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- DETAIL PEMILU --}}
            <div class="detail-group">
                <h4>Detail Pemilu</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <span class="label">Nomor Urut</span>
                            <span class="value fw-bold">{{ $paslon->no_urut }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Partai Pengusung</span>
                            <span class="value">{{ $paslon->partai_pengusung }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <span class="label">Tahun Pemilu</span>
                            <span class="value">{{ $paslon->tahun_pemilu }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Jumlah Suara (Kota Bandung)</span>
                            <span class="value fw-bold text-danger">{{ number_format($paslon->total_suara ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VISI & MISI --}}
            <div class="detail-group">
                <h4>Visi & Misi</h4>
                <h5>Visi</h5>
                <p class="text-muted">{{ $paslon->visi ?? 'Tidak ada data visi.' }}</p>
                <h5 class="mt-3">Misi</h5>
                <p class="text-muted">{!! nl2br(e($paslon->misi ?? 'Tidak ada data misi.')) !!}</p>
            </div>
        </div>
    </div>
</div>
@endsection
