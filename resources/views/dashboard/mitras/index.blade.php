@extends('dashboard.layouts.app')

@section('title', 'Mitra')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif
                        <a href="{{ route('mitras.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus fa-fw"></i> <span>Tambah Mitra</span>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Logo Lembaga</th>
                                        <th>Nama Lembaga</th>
                                        <th>Alamat</th>
                                        <th>Deskripsi</th>
                                        <th>Ketua</th>
                                        <th>Foto Ketua</th>
                                        <th>Kontak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mitras as $mitra)
                                        <tr>
                                            <td class="fw-semibold">{{ $mitra->kategori_mitra }}</td>
                                            <td>
                                                <img src="{{ asset('images/mitras/logo/'.$mitra->logo_lembaga) }}" alt="{{ $mitra->nama_lembaga }}" class="img-thumbnail" style="width: 120px; height: auto;">
                                            </td>
                                            <td class="fw-semibold">{{ $mitra->nama_lembaga }}</td>
                                            <td class="text-start">{!! Str::limit(strip_tags($mitra->alamat), 100, '...') !!}</td>
                                            <td class="text-start">{!! Str::limit(strip_tags($mitra->deskripsi), 100, '...') !!}</td>
                                            <td class="fw-semibold">{{ $mitra->ketua }}</td>
                                            <td>
                                                <img src="{{ asset('images/mitras/foto_ketua/'.$mitra->foto_ketua) }}" alt="{{ $mitra->ketua }}" class="img-thumbnail" style="width: 120px; height: auto;">
                                            </td>
                                            <td class="fw-semibold">{{ $mitra->kontak }}</td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('mitras.edit', $mitra->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('mitras.destroy', $mitra->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-warning">Data mitra belum tersedia.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $mitras->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    /* Pengaturan dasar tabel */
    .table {
        table-layout: fixed;
        width: 1500px;/* Minimum width untuk mencegah kolom terlalu sempit */
    }

    /* Pengaturan ukuran kolom spesifik */
    .table thead th:nth-child(1) { /* Kategori */
        width: 50px;
        text-align: center !important;
    }

    .table thead th:nth-child(2) { /* Logo Lembaga */
        width: 20px;
        text-align: center !important;
    }

    .table thead th:nth-child(3) { /* Nama Lembaga */
        width: 50px;
        text-align: center !important;
    }

    .table thead th:nth-child(4) { /* Alamat */
        width: 50px;
        text-align: center !important;
    }

    .table thead th:nth-child(5) { /* Deskripsi */
        width: 40px;
        text-align: center !important;
    }

    .table thead th:nth-child(6) { /* Ketua */
        width: 40px;
        text-align: center !important;
    }

    .table thead th:nth-child(7) { /* Foto Ketua */
        width: 20px;
        text-align: center !important;
    }

    .table thead th:nth-child(8) { /* Kontak */
        width: 30px;
        text-align: center !important;
    }

    .table thead th:nth-child(9) { /* Aksi */
        width: 40px;
        text-align: center !important;
    }

    /* Pengaturan konten sel */
    .table tbody td {
        vertical-align: middle !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* Kolom kategori */
    .table tbody td:nth-child(1) {
        text-align: center !important;
        font-weight: 600;
    }

    /* Kolom logo lembaga */
    .table tbody td:nth-child(2) {
        text-align: center !important;
        padding: 8px;
    }

    .table tbody td:nth-child(2) img {
        max-width: 80px;
        max-height: 60px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    /* Kolom nama lembaga */
    .table tbody td:nth-child(3) {
        text-align: left !important;
        font-weight: 600;
        padding-left: 12px;
    }

    /* Kolom alamat */
    .table tbody td:nth-child(4) {
        text-align: left !important;
        padding-left: 12px;
        font-size: 0.9em;
        line-height: 1.4;
    }

    /* Kolom deskripsi */
    .table tbody td:nth-child(5) {
        text-align: left !important;
        padding-left: 12px;
        font-size: 0.9em;
        line-height: 1.4;
    }

    /* Kolom ketua */
    .table tbody td:nth-child(6) {
        text-align: center !important;
        font-weight: 600;
    }

    /* Kolom foto ketua */
    .table tbody td:nth-child(7) {
        text-align: center !important;
        padding: 8px;
    }

    .table tbody td:nth-child(7) img {
        max-width: 60px;
        max-height: 60px;
        width: auto;
        height: auto;
        object-fit: cover;
        border-radius: 4px;
    }

    /* Kolom kontak */
    .table tbody td:nth-child(8) {
        text-align: center !important;
        font-weight: 600;
        font-size: 0.9em;
    }

    /* Kolom aksi */
    .table tbody td:nth-child(9) {
        text-align: center !important;
        white-space: nowrap;
    }

    .kolom-aksi .btn {
        margin: 0 2px;
        padding: 4px 8px;
    }

    .kolom-aksi form {
        display: inline-block;
        margin: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 1400px) {
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            min-width: 1000px;
        }
    }

    @media (max-width: 992px) {
        .table {
            min-width: 900px;
            font-size: 0.85em;
        }
        
        .table tbody td:nth-child(2) img,
        .table tbody td:nth-child(7) img {
            max-width: 50px;
            max-height: 50px;
        }
        
        .kolom-aksi .btn {
            padding: 2px 6px;
            font-size: 0.8em;
        }
    }

    @media (max-width: 768px) {
        .table {
            min-width: 800px;
            font-size: 0.8em;
        }
        
        .table th,
        .table td {
            padding: 6px 4px;
        }
        
        .table tbody td:nth-child(2) img,
        .table tbody td:nth-child(7) img {
            max-width: 40px;
            max-height: 40px;
        }
    }

    /* Perbaikan untuk header tabel */
    .table thead th {
        text-align: center !important;
        vertical-align: middle !important;
        font-weight: 600;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        padding: 12px 8px;
    }

    /* Styling untuk row hover */
    .table-hover tbody tr:hover {
        background-color: rgba(180, 13, 20, 0.05);
    }

    /* Alert styling untuk empty state */
    .alert-warning {
        border: none;
        background-color: #fff3cd;
        color: #856404;
        border-radius: 6px;
        padding: 20px;
        margin: 0;
    }

    /* Existing pagination and button styles remain unchanged */
    .page-link {
        color: #B40D14 !important;
        background-color: #fff !important;
        border-color: #ddd !important;
    }

    .page-link:hover {
        color: #ffffff !important;
        background-color: #B40D14 !important;
        border-color: #B40D14 !important;
    }

    .page-item.active .page-link {
        color: #fff !important;
        background-color: #B40D14 !important;
        border-color: #B40D14 !important;
    }

    .page-item.disabled .page-link {
        color: #6c757d !important;
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
    }

        /* Tombol normal */
        .page-link {
            color: #B40D14 !important;
            background-color: #fff !important;
            border-color: #ddd !important;
        }

        /* Hover */
        .page-link:hover {
            color: #ffffff !important;
            background-color: #B40D14 !important;
            border-color: #B40D14 !important;
        }

        /* Tombol aktif */
        .page-item.active .page-link {
            color: #fff !important;
            background-color: #B40D14 !important;
            border-color: #B40D14 !important;
        }

        /* Tombol disabled */
        .page-item.disabled .page-link {
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
        }

                .table thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }


        .table tbody tr td:nth-child(2) {
            text-align: justify !important;
        }

        .table tbody tr td:nth-child(3) {
            text-align: justify !important;
        }
    </style>

    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script>
@stop


