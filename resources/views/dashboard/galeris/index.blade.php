@extends('dashboard.layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif
                        <a href="{{ route('galeris.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus fa-fw"></i> <span>Tambah Galeri Kegiatan</span>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">Gambar</th>
                                        <th style="width: 50px;">Judul</th>
                                        <th style="width: 100px;">Kategori/Kegiatan</th>
                                        <th style="width: 50px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($galeris as $galeri)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/gallery/'.$galeri->gambar_upload) }}" alt="{{ $galeri->judul }}" class="img-thumbnail" style="width: 120px; height: auto;">
                                            </td>
                                            <td class="fw-semibold">{{ $galeri->judul }}</td>
                                            <td class="text-start">
                                                {{ $galeri->program->nama_program }}
                                            </td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('galeris.edit', $galeri->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('galeris.destroy', $galeri->id) }}" method="POST" class="d-inline"
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
                                            <td colspan="4" class="text-center">
                                                <div class="alert alert-warning">Data Galeri belum tersedia.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $galeris->links('pagination::bootstrap-5') }}
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


