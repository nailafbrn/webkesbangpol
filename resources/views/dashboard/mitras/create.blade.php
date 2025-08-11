@extends('dashboard.layouts.app')

@section('title', 'Tambah Mitra')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('mitras.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Tambah Data Mitra</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 font-weight-bold">
                                            <label for="kategori_mitra">Kategori Mitra</label>
                                            <select name="kategori_mitra" id="kategori_mitra" class="form-control">
                                                <option value="" disabled selected>Pilih Mitra</option>
                                                <option value="FORKOPIMDA" {{ old('kategori_mitra') == 'FORKOPIMDA' ? 'selected' : '' }}>FORKOPIMDA</option>
                                                <option value="KPU" {{ old('kategori_mitra') == 'KPU' ? 'selected' : '' }}>KPU</option>
                                                <option value="BAWASLU" {{ old('kategori_mitra') == 'BAWASLU' ? 'selected' : '' }}>BAWASLU</option>
                                                <option value="BNN" {{ old('kategori_mitra') == 'BNN' ? 'selected' : '' }}>BNN</option>
                                                <option value="PARPOL" {{ old('kategori_mitra') == 'PARPOL' ? 'selected' : '' }}>PARPOL</option>
                                                <option value="FKDM" {{ old('kategori_mitra') == 'FKDM' ? 'selected' : '' }}>FKDM</option>
                                                <option value="FKUB" {{ old('kategori_mitra') == 'FKUB' ? 'selected' : '' }}>FKUB</option>
                                                <option value="FPK" {{ old('kategori_mitra') == 'FPK' ? 'selected' : '' }}>FPK</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Nama Lembaga</label>
                                            {{-- Menggunakan old() untuk menjaga input jika validasi gagal --}}
                                            <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror" name="nama_lembaga" value="{{ old('nama_lembaga') }}" placeholder="Masukkan Nama Lembaga">
                                            @error('nama_lembaga')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 font-weight-bold">
                                            <label class="font-weight-bold">Logo</label>
                                            <input type="file" class="form-control @error('logo_lembaga') is-invalid @enderror" name="logo_lembaga" accept=".jpg,.jpeg,.png,.webp">
                                            @error('logo_lembaga')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Nama Ketua</label>
                                            {{-- Menggunakan old() --}}
                                            <input type="text" class="form-control @error('ketua') is-invalid @enderror" name="ketua" value="{{ old('ketua') }}" placeholder="Masukkan Nama Ketua">
                                            @error('ketua')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 font-weight-bold">
                                            <label class="font-weight-bold">Foto Ketua</label>
                                            <input type="file" class="form-control @error('foto_ketua') is-invalid @enderror" name="foto_ketua" accept=".jpg,.jpeg,.png,.webp">
                                            @error('foto_ketua')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="font-weight-bold">Kontak</label>
                                        {{-- Menggunakan old() --}}
                                        <input type="text" class="form-control @error('kontak') is-invalid @enderror" name="kontak" value="{{ old('kontak') }}" placeholder="Masukkan Kontak">
                                        @error('kontak')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-weight-bold">Alamat</label>
                                        {{-- Menggunakan old() di dalam textarea --}}
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="editor1" rows="10" placeholder="Masukkan Alamat Lembaga">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-weight-bold">Deskripsi Lembaga</label>
                                        {{-- Menggunakan old() di dalam textarea --}}
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="editor2" rows="10" placeholder="Masukkan Deskripsi Lembaga">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
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
    <style>
        .ck-editor__editable_inline{
            min-height: 200px;
        }
    </style>
@stop
