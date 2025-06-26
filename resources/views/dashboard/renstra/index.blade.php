@extends('dashboard.layouts.app')

@section('title', 'Rencana Strategis')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('renstra.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus"></i> <span>Tambah Rencana Strategis</span>
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
                                    @forelse ($renstras as $renstra)
                                        <tr>
                                            <td>{{ $renstra->title }}</td>
                                            <td>{{ $renstra->tahun_mulai }} - {{ $renstra->tahun_selesai }}</td>
                                            <td>
                                                <a href="{{ asset($renstra->file_upload) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <span>{{ basename($renstra->file_upload) }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ asset($renstra->file_upload_wm) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <span>{{ basename($renstra->file_upload_wm) }}</span>
                                                </a>
                                            </td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('renstra.edit', $renstra->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('renstra.destroy', $renstra->id) }}" method="POST" class="d-inline"
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
                                                <div class="alert alert-warning text-center m-0">Belum ada data Rencana Strategis.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $renstras->links('pagination::bootstrap-5') }}

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