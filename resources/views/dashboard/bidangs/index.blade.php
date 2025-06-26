@extends('dashboard.layouts.app')

@section('title', 'Daftar Bidang')

@section('content_header')
    <h1>Daftar Bidang</h1>
@stop

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('bidangs.create') }}" class="btn-tambah-konten">
                        <i class="fas fa-plus"></i> <span>Tambah Bidang</span>
                    </a>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama Bidang</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bidangs as $bidang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $bidang->nama_bidang }}</td>
                                        <td class="kolom-aksi text-center">
                                            <a href="{{ route('bidangs.edit', $bidang->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('bidangs.destroy', $bidang->id) }}" method="POST" class="d-inline"
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
                                        <td colspan="3">
                                            <div class="alert alert-warning text-center m-0">Belum ada data bidang.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@stop

@section('js')

    {{-- Toastr Message --}}
    <script>
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif(session()->has('error'))
            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
            "positionClass": "toast-bottom-right"
        };

    </script>

    {{-- Debug Log --}}
    <script> console.log('Hi!'); </script>
@stop
