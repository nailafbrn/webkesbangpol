@extends('dashboard.layouts.app')

@section('title', 'Laporan AKIP')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('lakip.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus"></i> <span>Tambah Laporan AKIP</span>
                        </a>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="kolom-bidang text-start">TITLE</th>
                                        <th scope="col" class="kolom-nama text-start">TAHUN</th>
                                        <th scope="col" class="kolom-nip">FILE</th>
                                        <th scope="col" class="kolom-nip">FILE WATERMARK</th>
                                        <th scope="col" class="kolom-aksi text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lakips as $lakip)
                                        <tr>
                                            <td>{{ $lakip->title }}</td>
                                            <td>{{ $lakip->tahun }}</td>
                                            <td>
                                                <a href="{{ asset($lakip->file_upload) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <span>{{ basename($lakip->file_upload) }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ asset($lakip->file_upload_wm) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <span>{{ basename($lakip->file_upload_wm) }}</span>
                                                </a>
                                            </td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('lakip.edit', $lakip->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('lakip.destroy', $lakip->id) }}" method="POST" class="d-inline"
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
                                            <td colspan="4">
                                                <div class="alert alert-warning text-center m-0">Belum ada data Laporan AKIP.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $lakips->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
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

                /* Center text in table headers */
        .table thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table tbody tr td:nth-child(1) {
            text-align: justify !important;
            padding-left: 2rem;
        }

        .table tbody tr td:nth-child(2) {
            text-align: center !important;
        }

        .table tbody tr td:nth-child(3) {
            text-align: left !important;
        }

        .table tbody tr td:nth-child(4) {
            text-align: center !important;
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

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-struktur.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop