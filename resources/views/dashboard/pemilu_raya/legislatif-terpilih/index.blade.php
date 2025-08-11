@extends('dashboard.layouts.app')
@section('title', 'Manajemen Caleg Terpilih')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div>
                <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-secondary mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Manajemen DPRD
                </a>
                <h3 class="m-0">Manajemen Caleg Terpilih</h3>
            </div>
            <hr>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pemilu.legislatif-terpilih.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> <span>Tambah Manual</span>
                    </a>
                    <a href="{{ route('admin.pemilu.legislatif-terpilih.import.form') }}" class="btn btn-primary">
                        <i class="fas fa-file-excel"></i> <span>Import Excel</span>
                    </a>
                </div>
            </div>

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>NAMA LENGKAP</th>
                            <th>PARTAI</th>
                            <th class="text-center">DAPIL</th>
                            <th>JABATAN</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($terpilihs as $terpilih)
                            <tr>
                                {{-- Mengakses data caleg melalui relasi 'legislatif' --}}
                                <td>{{ $terpilih->legislatif->nama_lengkap ?? 'Data Caleg Dihapus' }}</td>
                                <td>{{ $terpilih->legislatif->nama_partai ?? '-' }}</td>
                                <td class="text-center">{{ $terpilih->legislatif->dapil ?? '-' }}</td>
                                <td>{{ $terpilih->jabatan ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pemilu.legislatif-terpilih.edit', $terpilih->id) }}" class="btn btn-sm btn-warning" title="Edit Jabatan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pemilu.legislatif-terpilih.destroy', $terpilih->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini dari daftar terpilih?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus dari Daftar Terpilih">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data caleg terpilih. Silakan tambahkan melalui tombol "Tambah Manual" atau "Import Excel".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-3">
                {{ $terpilihs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
