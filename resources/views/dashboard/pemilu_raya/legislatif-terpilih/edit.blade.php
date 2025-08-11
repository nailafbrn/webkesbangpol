@extends('dashboard.layouts.app')
@section('title', 'Edit Jabatan Caleg Terpilih')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div>
                <a href="{{ route('admin.pemilu.legislatif-terpilih.index') }}" class="btn btn-secondary mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Terpilih
                </a>
                <h3 class="m-0">Edit Jabatan Caleg Terpilih</h3>
            </div>
            <hr>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <form action="{{ route('admin.pemilu.legislatif-terpilih.update', $legislatif_terpilih->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Menampilkan info caleg yang tidak bisa diubah --}}
                <div class="mb-3">
                    <label class="form-label">Nama Caleg</label>
                    <input type="text" class="form-control" value="{{ $legislatif_terpilih->legislatif->nama_lengkap ?? 'N/A' }}" readonly disabled>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Partai</label>
                        <input type="text" class="form-control" value="{{ $legislatif_terpilih->legislatif->nama_partai ?? 'N/A' }}" readonly disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dapil</label>
                        <input type="text" class="form-control" value="{{ $legislatif_terpilih->legislatif->dapil ?? 'N/A' }}" readonly disabled>
                    </div>
                </div>

                <hr>

                {{-- Kolom Jabatan yang bisa diubah --}}
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan (Opsional)</label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" 
                           value="{{ old('jabatan', $legislatif_terpilih->jabatan) }}" 
                           placeholder="Contoh: Ketua Komisi A">
                    <small class="form-text text-muted">Isi jika caleg terpilih memiliki jabatan spesifik di DPRD.</small>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Perbarui Jabatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
