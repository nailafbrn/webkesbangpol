@extends('dashboard.layouts.app')
@section('title', 'Edit Calon Legislatif')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <!-- Manual Input Form -->
                        <div id="manual-input-form">
                            {{-- PERBAIKAN: Mengarahkan form ke route yang benar --}}
                            <form action="{{ route('admin.pemilu.legislatif.update', $legislatif->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="mb-0">Edit Data Calon Legislatif</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- PERBAIKAN: Menggabungkan semua field dan menyesuaikan nama variabel --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="no_urut" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('no_urut') is-invalid @enderror" id="no_urut" name="no_urut" value="{{ old('no_urut', $legislatif->no_urut) }}" required>
                                                @error('no_urut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="nama_calon" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('nama_calon') is-invalid @enderror" id="nama_calon" name="nama_calon" value="{{ old('nama_calon', $legislatif->nama_calon) }}" required>
                                                @error('nama_calon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="nama_partai" class="form-label">Nama Partai <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('nama_partai') is-invalid @enderror" id="partai" name="partai" value="{{ old('nama_partai', $legislatif->partai) }}" required>
                                                @error('nama_partai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $legislatif->tempat_lahir) }}" required>
                                                @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $legislatif->tanggal_lahir) }}" required>
                                                @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                    <option value="">Pilih...</option>
                                                    <option value="Laki-laki" {{ old('jenis_kelamin', $legislatif->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="Perempuan" {{ old('jenis_kelamin', $legislatif->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="dapil" class="form-label">Dapil <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('dapil') is-invalid @enderror" id="dapil" name="dapil" value="{{ old('dapil', $legislatif->dapil) }}" required>
                                                @error('dapil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="suara_sah" class="form-label">Total Suara <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('suara_sah') is-invalid @enderror" id="suara_sah" name="suara_sah" value="{{ old('suara_sah', $legislatif->suara_sah) }}" required>
                                                @error('suara_sah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <!-- <div class="col-md-4 mb-3">
                                                <label for="foto_profil" class="form-label">Foto Profil</label>
                                                <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png,.webp">
                                                @if($legislatif->foto_profil)
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. <a href="{{ asset('images/legislatif/' . $legislatif->foto_profil) }}" target="_blank">Lihat foto saat ini</a></small>
                                                @endif
                                                @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div> -->
                                            <div class="col-md-6 mb-3">
                                                <label for="riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                                                <textarea class="form-control @error('riwayat_pendidikan') is-invalid @enderror" id="riwayat_pendidikan" name="riwayat_pendidikan" rows="3">{{ old('riwayat_pendidikan', $legislatif->riwayat_pendidikan) }}</textarea>
                                                @error('riwayat_pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                                                <textarea class="form-control @error('riwayat_pekerjaan') is-invalid @enderror" id="riwayat_pekerjaan" name="riwayat_pekerjaan" rows="3">{{ old('riwayat_pekerjaan', $legislatif->riwayat_pekerjaan) }}</textarea>
                                                @error('riwayat_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions d-flex gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i> Perbarui
                                    </button>
                                    <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
