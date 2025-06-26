@extends('dashboard.layouts.app')

@section('title', 'Edit Potensi Konflik')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('potensi-konflik.update', $potensiKonflik->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card mb-4">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">Edit Data Potensi Konflik</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        {{-- Nama Potensi --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Nama Potensi</label>
                                            <input type="text"
                                                   name="nama_potensi"
                                                   class="form-control @error('nama_potensi') is-invalid @enderror"
                                                   value="{{ old('nama_potensi', $potensiKonflik->nama_potensi) }}"
                                                   placeholder="Masukkan nama potensi">
                                            @error('nama_potensi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Kategori --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Kategori</label>
                                            <input type="text"
                                                   name="kategori"
                                                   class="form-control @error('kategori') is-invalid @enderror"
                                                   value="{{ old('kategori', $potensiKonflik->kategori) }}"
                                                   placeholder="Masukkan kategori">
                                            @error('kategori')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Kecamatan --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kecamatan</label>
                                            <select name="lokasi_kecamatan"
                                                    id="kecamatanSelect"
                                                    class="form-control @error('lokasi_kecamatan') is-invalid @enderror">
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach(array_keys($kecamatanKelurahan) as $kecamatan)
                                                    <option value="{{ $kecamatan }}"
                                                        {{ old('lokasi_kecamatan', $potensiKonflik->lokasi_kecamatan) == $kecamatan ? 'selected' : '' }}>
                                                        {{ $kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_kecamatan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Kelurahan --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Lokasi Kelurahan</label>
                                            <select name="lokasi_kelurahan"
                                                    id="kelurahanSelect"
                                                    class="form-control @error('lokasi_kelurahan') is-invalid @enderror">
                                                <option value="">-- Pilih Kelurahan --</option>
                                            </select>
                                            @error('lokasi_kelurahan')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Alamat --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Alamat</label>
                                            <textarea name="alamat"
                                                      rows="2"
                                                      class="form-control @error('alamat') is-invalid @enderror"
                                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $potensiKonflik->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Tanggal --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="date"
                                                   name="tanggal"
                                                   class="form-control @error('tanggal') is-invalid @enderror"
                                                   value="{{ old('tanggal', $potensiKonflik->tanggal->format('Y-m-d')) }}">
                                            @error('tanggal')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Tingkat Potensi --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tingkat Potensi</label>
                                            <select name="tingkat_potensi"
                                                    class="form-control @error('tingkat_potensi') is-invalid @enderror">
                                                <option value="" disabled>Pilih tingkat potensi</option>
                                                @foreach(['rendah','sedang','tinggi'] as $level)
                                                    <option value="{{ $level }}"
                                                        {{ old('tingkat_potensi', $potensiKonflik->tingkat_potensi) == $level ? 'selected' : '' }}>
                                                        {{ ucfirst($level) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tingkat_potensi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Status</label>
                                            <select name="status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                <option value="" disabled>Pilih status</option>
                                                @foreach(['aktif','selesai'] as $st)
                                                    <option value="{{ $st }}"
                                                        {{ old('status', $potensiKonflik->status) == $st ? 'selected' : '' }}>
                                                        {{ ucfirst($st) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Deskripsi --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="font-weight-bold">Deskripsi</label>
                                            <textarea name="deskripsi"
                                                      rows="5"
                                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                                      placeholder="Masukkan deskripsi">{{ old('deskripsi', $potensiKonflik->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="{{ route('potensi-konflik.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dependent dropdown script --}}
    <script>
        const kecamatanKelurahan = @json($kecamatanKelurahan);

        document.addEventListener('DOMContentLoaded', function () {
            const kecamatanSelect = document.getElementById('kecamatanSelect');
            const kelurahanSelect = document.getElementById('kelurahanSelect');
            const selectedKecamatan = "{{ old('lokasi_kecamatan', $potensiKonflik->lokasi_kecamatan) }}";
            const selectedKelurahan = "{{ old('lokasi_kelurahan', $potensiKonflik->lokasi_kelurahan) }}";

            function updateKelurahanOptions(kecamatan) {
                kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                if (kecamatan && kecamatanKelurahan[kecamatan]) {
                    kecamatanKelurahan[kecamatan].forEach(kel => {
                        const opt = document.createElement('option');
                        opt.value = kel;
                        opt.textContent = kel;
                        if (kel === selectedKelurahan) opt.selected = true;
                        kelurahanSelect.appendChild(opt);
                    });
                }
            }

            // Inisialisasi ketika load
            if (selectedKecamatan) {
                kecamatanSelect.value = selectedKecamatan;
                updateKelurahanOptions(selectedKecamatan);
            }

            // Event change
            kecamatanSelect.addEventListener('change', function () {
                updateKelurahanOptions(this.value);
            });
        });
    </script>
@stop
