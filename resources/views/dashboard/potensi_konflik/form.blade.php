@extends('dashboard.layouts.app')

@section('title', $title)

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if(isset($method))
                            @method($method)
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Potensi</label>
                                    <input type="text" class="form-control @error('nama_potensi') is-invalid @enderror" 
                                           name="nama_potensi" value="{{ old('nama_potensi', $potensiKonflik->nama_potensi ?? '') }}" required>
                                    @error('nama_potensi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                                           name="kategori" value="{{ old('kategori', $potensiKonflik->kategori ?? '') }}" required>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <select class="form-select @error('lokasi_kecamatan') is-invalid @enderror" 
                                            name="lokasi_kecamatan" id="kecamatanSelect" required>
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach($kecamatanKelurahan as $kecamatan => $kelurahans)
                                            <option value="{{ $kecamatan }}" 
                                                {{ old('lokasi_kecamatan', $potensiKonflik->lokasi_kecamatan ?? '') == $kecamatan ? 'selected' : '' }}>
                                                {{ $kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lokasi_kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <select class="form-select @error('lokasi_kelurahan') is-invalid @enderror" 
                                            name="lokasi_kelurahan" id="kelurahanSelect">
                                        <option value="">Pilih Kelurahan</option>
                                        @if(isset($potensiKonflik))
                                            <option value="{{ $potensiKonflik->lokasi_kelurahan }}" selected>
                                                {{ $potensiKonflik->lokasi_kelurahan }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('lokasi_kelurahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                           name="tanggal" value="{{ old('tanggal', isset($potensiKonflik->tanggal) ? $potensiKonflik->tanggal->format('Y-m-d') : '') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tingkat Potensi</label>
                                    <select class="form-select @error('tingkat_potensi') is-invalid @enderror" name="tingkat_potensi" required>
                                        <option value="">Pilih Tingkat</option>
                                        <option value="rendah" {{ old('tingkat_potensi', $potensiKonflik->tingkat_potensi ?? '') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ old('tingkat_potensi', $potensiKonflik->tingkat_potensi ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ old('tingkat_potensi', $potensiKonflik->tingkat_potensi ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                    @error('tingkat_potensi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif" {{ old('status', $potensiKonflik->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="selesai" {{ old('status', $potensiKonflik->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              name="alamat" rows="2" required>{{ old('alamat', $potensiKonflik->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="5" required>{{ old('deskripsi', $potensiKonflik->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('potensi-konflik.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const kecamatanKelurahan = @json($kecamatanKelurahan);
    
    document.addEventListener('DOMContentLoaded', function() {
        const kecamatanSelect = document.getElementById('kecamatanSelect');
        const kelurahanSelect = document.getElementById('kelurahanSelect');
        
        kecamatanSelect.addEventListener('change', function() {
            const selectedKecamatan = this.value;
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            if (selectedKecamatan && kecamatanKelurahan[selectedKecamatan]) {
                kecamatanKelurahan[selectedKecamatan].forEach(kelurahan => {
                    const option = document.createElement('option');
                    option.value = kelurahan;
                    option.textContent = kelurahan;
                    kelurahanSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endsection