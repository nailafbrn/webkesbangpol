@extends('dashboard.layouts.app')

@section('title', 'Tambah Banner')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <!-- Manual Input Form -->
                        <div id="manual-input-form">
                            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Tambah Data Banner</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold">Judul</label>
                                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" placeholder="Masukkan Judul Banner" maxlength="100" autocomplete="off">
                                                <!-- error message untuk judul -->
                                                @error('judul')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold">Caption</label>
                                                <input type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" placeholder="Masukkan Judul Caption Banner" maxlength="100" autocomplete="off">
                                                <!-- error message untuk judul -->
                                                @error('caption')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Gambar</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.jpeg,.png">
                                            
                                            <!-- error message untuk judul -->
                                            @error('image')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
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
    </div>
        
@stop
