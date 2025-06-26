@extends('dashboard.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('banners.update', $banners->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                    <div class="form-group">
                                        <label class="font-weight-bold">JUDUL</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $banners->judul) }}" placeholder="Masukkan Judul Banner" maxlength="100" autocomplete="off">
                                    
                                        <!-- error message untuk judul -->
                                        @error('judul')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Caption</label>
                                        <input type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption', $banners->caption) }}" placeholder="Masukkan Judul Caption Banner" maxlength="100" autocomplete="off">
                                    
                                        <!-- error message untuk judul -->
                                        @error('caption')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label class="font-weight-bold">Gambar</label>
                                        @if($banners->gambar_upload)
                                            <div>
                                                <img src="{{ asset('images/banner/' . $banners->gambar_upload) }}" alt="Gambar" class="img-thumbnail mb-2" width="150">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="image">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                    </div>
                            
                                <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                                <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
