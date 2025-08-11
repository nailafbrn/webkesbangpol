@extends('dashboard.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('strukturors.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus"></i> <span>Tambah Struktur</span>
                        </a>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="kolom-nama text-start">NAMA</th>
                                        <th scope="col" class="kolom-nip">NIP</th>
                                        <th scope="col" class="kolom-jabatan">JABATAN</th>
                                        <th style="width: 50px;">FOTO PROFIL</th>
                                        <th scope="col" class="kolom-aksi text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($strukturors as $strukturor)
                                        <tr>
                                            <td class="text-start">{{ $strukturor->nama }}</td>
                                            
                                            @php
                                                $nip = $strukturor->nip;
                                                $formattedNip = substr($nip, 0, 8) . ' ' . 
                                                                substr($nip, 8, 6) . ' ' . 
                                                                substr($nip, 14, 1) . ' ' . 
                                                                substr($nip, 15, 3);
                                            @endphp

                                            <td>
                                                {{ $formattedNip }} /{{ $strukturor->golongan }} {{ $strukturor->pangkat }}
                                            </td> 

                                            <td>{!! $strukturor->jabatan !!}</td> 

                                            <td>
                                                @if($strukturor->foto_profile)
                                                    <img src="{{ asset('images/struktur-organisasi/' . $strukturor->foto_profile) }}" 
                                                         alt="{{ $strukturor->nip }}" 
                                                         class="img-thumbnail" style="width: 120px; height: auto;">
                                                @else
                                                    <span class="text-muted">Belum ada foto</span>
                                                @endif
                                            </td> 

                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('strukturors.edit', $strukturor->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('strukturors.destroy', $strukturor->id) }}" method="POST" class="d-inline"
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
                                            <td colspan="5">
                                                <div class="alert alert-warning text-center m-0">Belum ada data Struktur.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $strukturors->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .table thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table tbody tr td:nth-child(1) {
            text-align: left !important;
        }

        .table tbody tr td:nth-child(2),
        .table tbody tr td:nth-child(3) {
            text-align: justify !important;
        }

        .table tbody tr td:nth-child(4) {
            align-items: center !important;
        }
    </style>

    <script>
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
