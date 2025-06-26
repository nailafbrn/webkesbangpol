@extends('dashboard.layouts.app')

@section('title', 'Tambah Potensi Konflik')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('potensi-konflik.store') }}" method="POST">
                            @csrf
                            
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Tambah Data Potensi Konflik</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Nama Potensi</label>
                                            <input type="text" class="form-control @error('nama_potensi') is-invalid @enderror" name="nama_potensi" value="{{ old('nama_potensi') }}" placeholder="Masukkan nama potensi">
                                            @error('nama_potensi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Kategori</label>
                                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori') }}" placeholder="Masukkan kategori">
                                            @error('kategori')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kecamatan</label>
                                            <input type="text" class="form-control @error('lokasi_kecamatan') is-invalid @enderror" name="lokasi_kecamatan" value="{{ old('lokasi_kecamatan') }}" placeholder="Masukkan kecamatan">
                                            @error('lokasi_kecamatan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kelurahan</label>
                                            <input type="text" class="form-control @error('lokasi_kelurahan') is-invalid @enderror" name="lokasi_kelurahan" value="{{ old('lokasi_kelurahan') }}" placeholder="Masukkan kelurahan (opsional)">
                                            @error('lokasi_kelurahan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kecamatan</label>
                                            <select class="form-control @error('lokasi_kecamatan') is-invalid @enderror" name="lokasi_kecamatan" id="kecamatanSelect">
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach(array_keys($kecamatanKelurahan) as $kecamatan)
                                                    <option value="{{ $kecamatan }}" {{ old('lokasi_kecamatan') == $kecamatan ? 'selected' : '' }}>
                                                        {{ $kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_kecamatan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kelurahan</label>
                                            <select class="form-control @error('lokasi_kelurahan') is-invalid @enderror" name="lokasi_kelurahan" id="kelurahanSelect">
                                                <option value="">-- Pilih Kelurahan --</option>
                                            </select>
                                            @error('lokasi_kelurahan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Alamat</label>
                                            {{-- <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat lengkap"> --}}
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>

                                            @error('alamat')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                            @error('tanggal')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tingkat Potensi</label>
                                            <select name="tingkat_potensi" class="form-control @error('tingkat_potensi') is-invalid @enderror">
                                                <option value="" disabled selected>Pilih tingkat potensi</option>
                                                <option value="rendah" {{ old('tingkat_potensi') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                                <option value="sedang" {{ old('tingkat_potensi') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                                <option value="tinggi" {{ old('tingkat_potensi') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                            </select>
                                            @error('tingkat_potensi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Status</label>
                                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                <option value="" disabled selected>Pilih status</option>
                                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                            @error('status')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="font-weight-bold">Deskripsi</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" placeholder="Masukkan deskripsi">{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const kecamatanKelurahan = @json($kecamatanKelurahan);

        document.addEventListener('DOMContentLoaded', function () {
            const kecamatanSelect = document.getElementById('kecamatanSelect');
            const kelurahanSelect = document.getElementById('kelurahanSelect');
            const selectedKelurahan = "{{ old('lokasi_kelurahan') }}";

            function updateKelurahanOptions(kecamatan) {
                kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';

                if (kecamatan && kecamatanKelurahan[kecamatan]) {
                    kecamatanKelurahan[kecamatan].forEach(kel => {
                        const option = document.createElement('option');
                        option.value = kel;
                        option.textContent = kel;
                        if (kel === selectedKelurahan) {
                            option.selected = true;
                        }
                        kelurahanSelect.appendChild(option);
                    });
                }
            }

            // Saat pertama kali load (jika old('lokasi_kecamatan') ada)
            if (kecamatanSelect.value) {
                updateKelurahanOptions(kecamatanSelect.value);
            }

            // Saat berubah kecamatan
            kecamatanSelect.addEventListener('change', function () {
                updateKelurahanOptions(this.value);
            });
        });
    </script>

@stop