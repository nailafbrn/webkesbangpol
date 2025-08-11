@extends('dashboard.layouts.app') {{-- Pastikan nama layout ini benar --}}

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Paslon Pilpres Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pemilu.pilpres.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Data Umum Paslon --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="no_urut" class="form-label">Nomor Urut</label>
                        <input type="number" name="no_urut" id="no_urut" class="form-control @error('no_urut') is-invalid @enderror" value="{{ old('no_urut') }}" required>
                        @error('no_urut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tahun_pemilu" class="form-label">Tahun Pemilu</label>
                        <input type="number" name="tahun_pemilu" id="tahun_pemilu" class="form-control @error('tahun_pemilu') is-invalid @enderror" value="{{ old('tahun_pemilu', date('Y')) }}" required>
                        @error('tahun_pemilu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="partai_pengusung" class="form-label">Partai Pengusung</label>
                        <input type="text" name="partai_pengusung" id="partai_pengusung" class="form-control @error('partai_pengusung') is-invalid @enderror" value="{{ old('partai_pengusung') }}" required>
                        @error('partai_pengusung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                
                <div class="row">
                    {{-- ================================== --}}
                    {{--     AWAL KOLOM KIRI (CAPRES)       --}}
                    {{-- ================================== --}}
                    <div class="col-md-6">
                        <h4>Data Calon Presiden</h4>
                        <div class="mb-3">
                            <label for="capres_nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="capres_nama" id="capres_nama" class="form-control @error('capres_nama') is-invalid @enderror" value="{{ old('capres_nama') }}" required>
                            @error('capres_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_foto" class="form-label">Foto</label>
                            <input type="file" name="capres_foto" id="capres_foto" class="form-control @error('capres_foto') is-invalid @enderror">
                            @error('capres_foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="capres_tempat_lahir" id="capres_tempat_lahir" class="form-control @error('capres_tempat_lahir') is-invalid @enderror" value="{{ old('capres_tempat_lahir') }}" required>
                            @error('capres_tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="capres_tanggal_lahir" id="capres_tanggal_lahir" class="form-control @error('capres_tanggal_lahir') is-invalid @enderror" value="{{ old('capres_tanggal_lahir') }}" required>
                            @error('capres_tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="capres_jenis_kelamin" id="capres_jenis_kelamin" class="form-control @error('capres_jenis_kelamin') is-invalid @enderror" required>
                                <option value="Laki-laki" {{ old('capres_jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('capres_jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('capres_jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="capres_riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                            <textarea name="capres_riwayat_pendidikan" id="capres_riwayat_pendidikan" class="form-control">{{ old('capres_riwayat_pendidikan') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="capres_riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                            <textarea name="capres_riwayat_pekerjaan" id="capres_riwayat_pekerjaan" class="form-control">{{ old('capres_riwayat_pekerjaan') }}</textarea>
                        </div>
                    </div>
                    
                    {{-- ===================================== --}}
                    {{--     AWAL KOLOM KANAN (CAWAPRES)       --}}
                    {{-- ===================================== --}}
                    <div class="col-md-6">
                        <h4>Data Calon Wakil Presiden</h4>
                        <div class="mb-3">
                            <label for="cawapres_nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="cawapres_nama" id="cawapres_nama" class="form-control @error('cawapres_nama') is-invalid @enderror" value="{{ old('cawapres_nama') }}">
                            @error('cawapres_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_foto" class="form-label">Foto</label>
                            <input type="file" name="cawapres_foto" id="cawapres_foto" class="form-control @error('cawapres_foto') is-invalid @enderror">
                            @error('cawapres_foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="cawapres_tempat_lahir" id="cawapres_tempat_lahir" class="form-control @error('cawapres_tempat_lahir') is-invalid @enderror" value="{{ old('cawapres_tempat_lahir') }}">
                            @error('cawapres_tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="cawapres_tanggal_lahir" id="cawapres_tanggal_lahir" class="form-control @error('cawapres_tanggal_lahir') is-invalid @enderror" value="{{ old('cawapres_tanggal_lahir') }}">
                            @error('cawapres_tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="cawapres_jenis_kelamin" id="cawapres_jenis_kelamin" class="form-control @error('cawapres_jenis_kelamin') is-invalid @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('cawapres_jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('cawapres_jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('cawapres_jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_riwayat_pendidikan" class="form-label">Riwayat Pendidikan</label>
                            <textarea name="cawapres_riwayat_pendidikan" id="cawapres_riwayat_pendidikan" class="form-control">{{ old('cawapres_riwayat_pendidikan') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cawapres_riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label>
                            <textarea name="cawapres_riwayat_pekerjaan" id="cawapres_riwayat_pekerjaan" class="form-control">{{ old('cawapres_riwayat_pekerjaan') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- PERUBAHAN: Visi, Misi, dan Total Suara digabung di sini --}}
                <div class="row">
                    <div class="col-md-8">
                        <h4>Visi & Misi</h4>
                        <div class="mb-3">
                            <label for="visi" class="form-label">Visi</label>
                            <textarea name="visi" id="visi" class="form-control @error('visi') is-invalid @enderror" rows="4">{{ old('visi') }}</textarea>
                            @error('visi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="misi" class="form-label">Misi</label>
                            <textarea name="misi" id="misi" class="form-control @error('misi') is-invalid @enderror" rows="8">{{ old('misi') }}</textarea>
                            @error('misi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>Jumlah Suara</h4>
                        <div class="mb-3">
                            <label for="total_suara" class="form-label">Total Suara Paslon</label>
                            {{-- PERUBAHAN: Input tunggal untuk total_suara --}}
                            <input type="text" name="total_suara" id="total_suara" class="form-control number-format @error('total_suara') is-invalid @enderror" value="{{ old('total_suara', 0) }}">
                            @error('total_suara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <a href="{{ route('admin.pemilu.pilpres.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- PERUBAHAN: Tambahkan push script untuk number-format jika belum ada --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk memformat angka dengan titik sebagai pemisah ribuan
        function formatNumber(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }
        
        // Terapkan pada semua input dengan class 'number-format'
        document.querySelectorAll('.number-format').forEach(input => {
            input.addEventListener('keyup', function() {
                formatNumber(this);
            });
            // Format juga saat halaman pertama kali dimuat
            formatNumber(input);
        });
    });
</script>
@endpush
