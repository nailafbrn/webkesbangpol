@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Bagian Judul Utama dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- PERBAIKAN: Menambahkan div untuk mengelompokkan tombol kembali dan judul --}}
        <div>
            <a href="{{ route('admin.pemilu-raya.dashboard') }}" class="btn btn-secondary mb-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Pemilu Raya
            </a>
            <h3 class="m-0">Manajemen Walikota</h3>
        </div>
        <a href="{{ route('admin.pemilu.walikota.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Paslon Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Kondisi Utama untuk Menampilkan Tabel atau Pesan Kosong --}}
    @if($paslons->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pasangan Calon Wali Kota</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No Urut</th>
                                <th>Foto</th>
                                <th>Calon Wali Kota</th>
                                <th>Calon Wakil Wali Kota</th>
                                <th>Partai Pengusung</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paslons as $paslon)
                            <tr>
                                <td class="text-center"><h4>{{ $paslon->no_urut }}</h4></td>
                                <td>
                                    {{-- Tampilkan foto Calon Wali Kota --}}
                                    @if($paslon->capres_foto && file_exists(public_path($paslon->capres_foto)))
                                        <img src="{{ asset($paslon->capres_foto) }}" alt="Foto Wali Kota" style="height: 100px; object-fit: cover;" class="rounded mb-2">
                                    @endif

                                    {{-- Tampilkan foto Calon Wakil Wali Kota --}}
                                    @if($paslon->cawapres_foto && file_exists(public_path($paslon->cawapres_foto)))
                                        <img src="{{ asset($paslon->cawapres_foto) }}" alt="Foto Wakil Wali Kota" style="height: 100px; object-fit: cover;" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $paslon->capres_nama }}</td>
                                <td>{{ $paslon->cawapres_nama }}</td>
                                <td>{{ $paslon->partai_pengusung }}</td>
                                <td>
                                    <a href="{{ route('admin.pemilu.walikota.show', $paslon->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.pemilu.walikota.edit', $paslon->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.pemilu.walikota.destroy', $paslon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        {{-- Tampilan jika tidak ada data --}}
        <div class="card">
            <div class="card-body text-center p-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Data Pasangan Calon</h5>
                <p class="text-muted">Silakan tambahkan data baru melalui tombol "Tambah Paslon Baru" di pojok kanan atas.</p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .main-wrapper .dashboard-content {
        padding-top: 1rem !important;
    }
</style>
@endpush
