@extends('dashboard.layouts.app')

@section('title', 'Visi & Misi')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                    <a href="{{ route('visimisis.create') }}" class="btn-tambah-konten">
                        <i class="fas fa-plus"></i> <span>Tambah Data</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">VISI</th>
                                    <th scope="col">MISI</th>
                                    <th scope="col">TUPOKSI</th>
                                    <th scope="col">SEJARAH</th>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($visimisis as $visimisi)
                                    <tr>
                                        <td>{!! $visimisi->visi !!}</td>
                                        <td>{!! $visimisi->misi !!}</td>
                                        <td>{!! $visimisi->tupoksi !!}</td>
                                        <td>{!! $visimisi->sejarah !!}</td>
                                        <td>
                                            <img src="{{ asset('images/component/'.$visimisi->sejarah_image) }}" class="img-thumbnail" style="width: 120px; height: auto;">
                                        </td>
                                        <td class="kolom-aksi text-center">
                                            <a href="{{ route('visimisis.edit', $visimisi->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('visimisis.destroy', $visimisi->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Visi Misi belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table> 
                    </div> 
                        {{ $visimisis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table tbody tr td:nth-child(1) {
            text-align: justify !important;
        }

        .table tbody tr td:nth-child(2) {
            text-align: justify !important;
        }

        .table tbody tr td:nth-child(3) {
            text-align: justify !important;
        }

        .table tbody tr td:nth-child(4) {
            text-align: justify !important;
        }
        .table tbody tr td:nth-child(5) {
            align-items: center !important;
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

@section('js')
    <script> console.log('Hi!'); </script>
@stop