@extends('dashboard.layouts.app')

@section('title', 'Banner Landing Page')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif
                        <a href="{{ route('banners.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus fa-fw"></i> <span>Tambah Banner</span>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">Gambar</th>
                                        <th style="width: 50px;">Judul</th>
                                        <th style="width: 100px;">Caption</th>
                                        <th style="width: 50px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($banners as $banner)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/banner/'.$banner->gambar_upload) }}" alt="{{ $banner->judul }}" class="img-thumbnail" style="width: 120px; height: auto;">
                                            </td>
                                            <td class="fw-semibold">{{ $banner->judul }}</td>
                                            <td class="text-start">
                                                {{ $banner->caption }}
                                            </td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" class="d-inline"
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
                                                <div class="alert alert-warning">Data Banner belum tersedia.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $banners->links('pagination::bootstrap-5') }}
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


