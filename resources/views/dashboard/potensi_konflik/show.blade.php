@extends('dashboard.layouts.app')

@section('title', 'Detail Potensi Konflik')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4">Detail Potensi Konflik</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                        
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Potensi:</label>
                                <p>{{ $potensiKonflik->nama_potensi }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kategori:</label>
                                <p>{{ $potensiKonflik->kategori }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Lokasi:</label>
                                <p>
                                    {{ $potensiKonflik->lokasi_kecamatan }}, 
                                    {{ $potensiKonflik->lokasi_kelurahan }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal:</label>
                                <p>{{ $potensiKonflik->tanggal->format('d F Y') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tingkat Potensi:</label>
                                <span class="badge bg-{{ $potensiKonflik->tingkat_color }}">
                                    {{ ucfirst($potensiKonflik->tingkat_potensi) }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status:</label>
                                <span class="badge bg-{{ $potensiKonflik->status_color }}">
                                    {{ ucfirst($potensiKonflik->status) }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat:</label>
                                <p>{{ $potensiKonflik->alamat }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <p>{{ $potensiKonflik->deskripsi }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('potensi-konflik.edit', $potensiKonflik->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('potensi-konflik.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection