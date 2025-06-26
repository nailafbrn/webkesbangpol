@extends('dashboard.layouts.app')

@section('title', 'Edit Mitra')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <!-- Manual Input Form -->
                        <div id="manual-input-form">
                        <form action="{{ route('mitras.update', $mitra->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="mb-0">Edit Data Mitra</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 font-weight-bold">
                                                <label for="kategori_mitra">Kategori Mitra</label>
                                                <select name="kategori_mitra" id="kategori_mitra" class="form-control @error('kategori_mitra') is-invalid @enderror">
                                                    <option value="" disabled>Pilih Mitra</option>
                                                    <option value="FORKOPIMDA" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'FORKOPIMDA' ? 'selected' : '' }}>FORKOPIMDA</option>
                                                    <option value="KPU" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'KPU' ? 'selected' : '' }}>KPU</option>
                                                    <option value="BAWASLU" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'BAWASLU' ? 'selected' : '' }}>BAWASLU</option>
                                                    <option value="BNN" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'BNN' ? 'selected' : '' }}>BNN</option>
                                                    <option value="PARPOL" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'PARPOL' ? 'selected' : '' }}>PARPOL</option>
                                                    <option value="FKDM" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'FKDM' ? 'selected' : '' }}>FKDM</option>
                                                    <option value="FKUB" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'FKUB' ? 'selected' : '' }}>FKUB</option>
                                                    <option value="FPK" {{ old('kategori_mitra', $mitra->kategori_mitra) == 'FPK' ? 'selected' : '' }}>FPK</option>
                                                </select>
                                                <!-- error message untuk kategori_mitra -->
                                                @error('kategori_mitra')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold">Nama Lembaga</label>
                                                <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror" name="nama_lembaga" value="{{ old('nama_lembaga', $mitra->nama_lembaga) }}" placeholder="Masukkan Nama Lembaga">
                                                <!-- error message untuk nama_lembaga -->
                                                @error('nama_lembaga')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3 font-weight-bold">
                                                <label class="font-weight-bold">Logo</label>
                                                <input type="file" class="form-control @error('logo_lembaga') is-invalid @enderror" name="logo_lembaga" accept=".jpg,.jpeg,.png,.webp">
                                                
                                                <!-- Preview gambar existing -->
                                                @if($mitra->logo_lembaga)
                                                    <div class="mt-2">
                                                        <small class="text-muted">Logo saat ini:</small><br>
                                                        <img src="{{ asset('images/mitras/logo/'.$mitra->logo_lembaga) }}" alt="{{ $mitra->nama_lembaga }}" class="img-thumbnail mt-1" style="max-width: 150px; max-height: 100px;">
                                                        <small class="text-info d-block mt-1">Kosongkan jika tidak ingin mengubah logo</small>
                                                    </div>
                                                @endif
                                                
                                                <!-- error message untuk logo_lembaga -->
                                                @error('logo_lembaga')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold">Nama Ketua</label>
                                                <input type="text" class="form-control @error('ketua') is-invalid @enderror" name="ketua" value="{{ old('ketua', $mitra->ketua) }}" placeholder="Masukkan Nama Ketua">
                                                <!-- error message untuk ketua -->
                                                @error('ketua')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3 font-weight-bold">
                                                <label class="font-weight-bold">Foto Ketua</label>
                                                <input type="file" class="form-control @error('foto_ketua') is-invalid @enderror" name="foto_ketua" accept=".jpg,.jpeg,.png,.webp">
                                                
                                                <!-- Preview gambar existing -->
                                                @if($mitra->foto_ketua)
                                                    <div class="mt-2">
                                                        <small class="text-muted">Foto ketua saat ini:</small><br>
                                                        <img src="{{ asset('images/mitras/foto_ketua/'.$mitra->foto_ketua) }}" alt="{{ $mitra->ketua }}" class="img-thumbnail mt-1" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                        <small class="text-info d-block mt-1">Kosongkan jika tidak ingin mengubah foto</small>
                                                    </div>
                                                @endif
                                                
                                                <!-- error message untuk foto_ketua -->
                                                @error('foto_ketua')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Kontak</label>
                                            <input type="text" class="form-control @error('kontak') is-invalid @enderror" name="kontak" value="{{ old('kontak', $mitra->kontak) }}" placeholder="Masukkan Kontak">
                                            <!-- error message untuk kontak -->
                                            @error('kontak')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="editor1" rows="5" placeholder="Masukkan Alamat Lembaga">{{ old('alamat', $mitra->alamat) }}</textarea>
                                        
                                            <!-- error message untuk alamat -->
                                            @error('alamat')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Deskripsi Lembaga</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="editor2" rows="5" placeholder="Masukkan Deskripsi Lembaga">{{ old('deskripsi', $mitra->deskripsi) }}</textarea>
                                        
                                            <!-- error message untuk deskripsi -->
                                            @error('deskripsi')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions d-flex gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                    <a href="{{ route('mitras.index') }}" class="btn btn-secondary">
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
    
    <style>
        .ck-editor__editable_inline{
            min-height: 150px; /* Lebih kecil untuk form edit */
        }
        
        /* Style untuk preview gambar */
        .img-thumbnail {
            border: 2px solid #dee2e6;
            border-radius: 6px;
            padding: 4px;
        }
        
        /* Style untuk form actions */
        .form-actions {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            margin-top: 20px;
        }
        
        /* Style untuk text info */
        .text-info {
            font-size: 0.875rem;
        }
        
        /* Style untuk card header edit */
        .card-header.bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
    </style>

@stop