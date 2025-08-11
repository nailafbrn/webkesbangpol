@extends('dashboard.layouts.app')
@section('title', 'Manajemen Calon Legislatif')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div>
                {{-- This route name should exist in your routes file --}}
                <a href="{{ route('admin.pemilu-raya.dashboard') }}" class="btn btn-secondary mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard Pemilu
                </a>
                <h3 class="m-0">Manajemen DPRD</h3>
            </div>
            <hr>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Action Buttons --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pemilu.legislatif.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> <span>Tambah Manual</span>
                    </a>
                    <a href="{{ route('admin.pemilu.legislatif.import.form') }}" class="btn btn-primary">
                        <i class="fas fa-file-excel"></i> <span>Import Excel</span>
                    </a>
                    
                    <!-- {{-- PERUBAHAN: Menambahkan tombol untuk ke halaman Caleg Terpilih --}}
                    <a href="{{ route('admin.pemilu.legislatif-terpilih.index') }}" class="btn btn-info">
                        <i class="fas fa-award"></i> <span>Manajemen Terpilih</span>
                    </a>
                </div> -->
                {{-- PERUBAHAN: Menambahkan tombol untuk ke halaman Caleg Terpilih --}}
                <a href="{{ route('legislatif.terpilih') }}" class="btn btn-success">
                <i class="fas fa-award"></i> <span>Lihat Caleg Terpilih</span>
</a>

                <!-- Search Form -->{{-- PERUBAHAN: Menambahkan tombol untuk ke halaman Caleg Terpilih --}}
            <a href="{{ route('legislatif.terpilih') }}" class="btn btn-success">
            <i class="fas fa-award"></i> <span>Lihat Caleg Terpilih</span>
</a>

                <div class="search-container">
                    <form method="GET" action="{{ route('admin.pemilu.legislatif.index') }}" class="d-flex">
                        <div class="input-group" style="width: 350px;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama, partai, atau dapil..." autocomplete="off">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-outline-danger" title="Hapus pencarian">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Session Notifications --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Table of Candidates --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>NAMA LENGKAP</th>
                            <th>PARTAI</th>
                            <th>DAPIL</th>
                            <th class="text-center">NO URUT</th>
                            <th class="text-center">TOTAL SUARA</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($legislatifs as $legislatif)
                            <tr>
                                <td>{{ $legislatif->nama_lengkap }}</td>
                                <td>{{ $legislatif->nama_partai }}</td>
                                <td class="text-center">{{ $legislatif->dapil }}</td>
                                <td class="text-center">{{ $legislatif->no_urut }}</td>
                                <td class="text-center">{{ number_format($legislatif->suara_sah, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pemilu.legislatif.edit', $legislatif->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pemilu.legislatif.destroy', $legislatif->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data {{ $legislatif->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    @if(request('search'))
                                        Tidak ada data ditemukan untuk kata kunci: "{{ request('search') }}".
                                    @else
                                        Belum ada data calon legislatif. Silakan tambah data baru.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-3">
                {{ $legislatifs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
