@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Paslon Presiden: {{ $paslon->capres_nama }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pemilu.pilpres.update', $paslon->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Data Umum Paslon --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="no_urut" class="form-label">Nomor Urut</label>
                        <input type="number" name="no_urut" id="no_urut" class="form-control @error('no_urut') is-invalid @enderror" value="{{ old('no_urut', $paslon->no_urut) }}" required>
                        @error('no_urut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tahun_pemilu" class="form-label">Tahun Pemilu</label>
                        <input type="number" name="tahun_pemilu" id="tahun_pemilu" class="form-control @error('tahun_pemilu') is-invalid @enderror" value="{{ old('tahun_pemilu', $paslon->tahun_pemilu) }}" required>
                        @error('tahun_pemilu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="partai_pengusung" class="form-label">Partai Pengusung</label>
                        <input type="text" name="partai_pengusung" id="partai_pengusung" class="form-control @error('partai_pengusung') is-invalid @enderror" value="{{ old('partai_pengusung', $paslon->partai_pengusung) }}" required>
                        @error('partai_pengusung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                
                <div class="row">
                    {{-- Kolom Calon Presiden --}}
                    <div class="col-md-6">
                        <h4>Data Calon Presiden</h4>
                        <div class="mb-3">
                            <label for="capres_nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="capres_nama" id="capres_nama" class="form-control @error('capres_nama') is-invalid @enderror" value="{{ old('capres_nama', $paslon->capres_nama) }}" required>
                            @error('capres_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_foto" class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="capres_foto" id="capres_foto" class="form-control @error('capres_foto') is-invalid @enderror">
                            @if($paslon->capres_foto)
                                <small class="text-muted">Foto saat ini: <a href="{{ asset($paslon->capres_foto) }}" target="_blank">Lihat Gambar</a></small>
                            @endif
                            @error('capres_foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="capres_tempat_lahir" id="capres_tempat_lahir" class="form-control" value="{{ old('capres_tempat_lahir', $paslon->capres_tempat_lahir) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="capres_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="capres_tanggal_lahir" id="capres_tanggal_lahir" class="form-control" value="{{ old('capres_tanggal_lahir', $paslon->capres_tanggal_lahir) }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="capres_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="capres_jenis_kelamin" id="capres_jenis_kelamin" class="form-control" required>
                                <option value="Laki-laki" {{ old('capres_jenis_kelamin', $paslon->capres_jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('capres_jenis_kelamin', $paslon->capres_jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="capres_riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                            <textarea name="capres_riwayat_pendidikan" id="capres_riwayat_pendidikan" class="form-control">{{ old('capres_riwayat_pendidikan', $paslon->capres_riwayat_pendidikan) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="capres_riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                            <textarea name="capres_riwayat_pekerjaan" id="capres_riwayat_pekerjaan" class="form-control">{{ old('capres_riwayat_pekerjaan', $paslon->capres_riwayat_pekerjaan) }}</textarea>
                        </div>
                    </div>

                    {{-- Kolom Calon Wakil Presiden --}}
                    <div class="col-md-6">
                        <h4>Data Calon Wakil Presiden</h4>
                        <div class="mb-3">
                            <label for="cawapres_nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="cawapres_nama" id="cawapres_nama" class="form-control" value="{{ old('cawapres_nama', $paslon->cawapres_nama) }}">
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_foto" class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="cawapres_foto" id="cawapres_foto" class="form-control @error('cawapres_foto') is-invalid @enderror">
                             @if($paslon->cawapres_foto)
                                <small class="text-muted">Foto saat ini: <a href="{{ asset($paslon->cawapres_foto) }}" target="_blank">Lihat Gambar</a></small>
                            @endif
                            @error('cawapres_foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                         <div class="mb-3">
                            <label for="cawapres_tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="cawapres_tempat_lahir" id="cawapres_tempat_lahir" class="form-control" value="{{ old('cawapres_tempat_lahir', $paslon->cawapres_tempat_lahir) }}">
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="cawapres_tanggal_lahir" id="cawapres_tanggal_lahir" class="form-control" value="{{ old('cawapres_tanggal_lahir', $paslon->cawapres_tanggal_lahir) }}">
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="cawapres_jenis_kelamin" id="cawapres_jenis_kelamin" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('cawapres_jenis_kelamin', $paslon->cawapres_jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('cawapres_jenis_kelamin', $paslon->cawapres_jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                            <textarea name="cawapres_riwayat_pendidikan" id="cawapres_riwayat_pendidikan" class="form-control">{{ old('cawapres_riwayat_pendidikan', $paslon->cawapres_riwayat_pendidikan) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                            <textarea name="cawapres_riwayat_pekerjaan" id="cawapres_riwayat_pekerjaan" class="form-control">{{ old('cawapres_riwayat_pekerjaan', $paslon->cawapres_riwayat_pekerjaan) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Visi, Misi & Total Suara --}}
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <h4>Visi & Misi</h4>
                        <div class="mb-3">
                            <label for="visi" class="form-label">Visi</label>
                            <textarea name="visi" id="visi" class="form-control" rows="4">{{ old('visi', $paslon->visi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="misi" class="form-label">Misi</label>
                            <textarea name="misi" id="misi" class="form-control" rows="8">{{ old('misi', $paslon->misi) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>Jumlah Suara</h4>
                        <div class="mb-3">
                            <label for="total_suara" class="form-label">Total Suara Paslon</label>
                            {{-- PERUBAHAN: Input tunggal untuk total_suara --}}
                            <input type="text" name="total_suara" id="total_suara" class="form-control number-format @error('total_suara') is-invalid @enderror" value="{{ old('total_suara', number_format($paslon->total_suara ?? 0, 0, ',', '.')) }}">
                            @error('total_suara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>


                {{-- Tombol Aksi --}}
                <div class="mt-3 d-flex justify-content-end">
                    <a href="{{ route('admin.pemilu.pilpres.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- JavaScript untuk format angka dengan koma/titik --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.number-format').forEach(input => {
            input.addEventListener('keyup', function(e) {
                let value = e.target.value.replace(/[^0-9]/g, '');
                if (value) {
                    e.target.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    e.target.value = '';
                }
            });
        });
    });
</script>
@endpush
