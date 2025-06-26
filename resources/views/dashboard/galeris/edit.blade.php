@extends('dashboard.layouts.app')

@section('title', 'Edit Galeri Kegiatan')

@section('content')
    <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('galeris.update', $galeris->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label class="font-weight-bold">Kategori Kegiatan</label>
                                    <select name="program_id" class="form-control @error('program_id') is-invalid @enderror">
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}" 
                                                    {{ old('program_id', $galeris->program_id) == $program->id ? 'selected' : '' }}>
                                                {{ $program->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @error('program_id')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>
                                @if($galeris->gambar_upload)
                                    <div>
                                        <img src="{{ asset('images/gallery/' . $galeris->gambar_upload) }}" alt="Gambar" class="img-thumbnail mb-2" width="150">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="image">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                            </div>
                            

                                <div class="form-group">
                                    <label class="font-weight-bold">JUDUL</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $galeris->judul) }}" placeholder="Masukkan Judul Galeri" maxlength="34" autocomplete="off">
                                
                                    <!-- error message untuk judul -->
                                    @error('judul')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
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

@section('js')
    <script> console.log('Hi!'); </script>
@stop