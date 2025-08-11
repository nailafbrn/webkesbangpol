@extends('dashboard.layouts.app')
@section('title', 'Tambah Calon Legislatif')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-secondary mb-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <h3 class="m-0">Tambah Calon Legislatif Baru</h3>
            <hr>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <form action="{{ route('admin.pemilu.legislatif.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="no_urut" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('no_urut') is-invalid @enderror" id="no_urut" name="no_urut" value="{{ old('no_urut') }}" required>
                        @error('no_urut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nama_partai" class="form-label">Nama Partai <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_partai') is-invalid @enderror" id="nama_partai" name="nama_partai" value="{{ old('nama_partai') }}" required>
                        @error('nama_partai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="dapil" class="form-label">Dapil <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('dapil') is-invalid @enderror" id="dapil" name="dapil" value="{{ old('dapil') }}" required>
                        @error('dapil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        {{-- ================================================================= --}}
                        {{-- == PERBAIKAN UTAMA ADA DI SINI == --}}
                        {{-- ================================================================= --}}
                        <label for="suara_sah" class="form-label">Total Suara <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('suara_sah') is-invalid @enderror" id="suara_sah" name="suara_sah" value="{{ old('suara_sah', 0) }}" required>
                        @error('suara_sah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                        <textarea class="form-control @error('riwayat_pendidikan') is-invalid @enderror" id="riwayat_pendidikan" name="riwayat_pendidikan" rows="3">{{ old('riwayat_pendidikan') }}</textarea>
                        @error('riwayat_pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                        <textarea class="form-control @error('riwayat_pekerjaan') is-invalid @enderror" id="riwayat_pekerjaan" name="riwayat_pekerjaan" rows="3">{{ old('riwayat_pekerjaan') }}</textarea>
                        @error('riwayat_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
