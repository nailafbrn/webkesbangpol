@extends('dashboard.layouts.app')

@section('title', 'Edit Visi & Misi')

@section('content')
    <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('visimisis.update', $visimisis->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="font-weight-bold">VISI</label>
                                    <textarea class="form-control @error('visi') is-invalid @enderror" name="visi" id="editor1" rows="5" placeholder="Masukkan Visi">{{ old('visi', $visimisis->visi) }}</textarea>
                                
                                    <!-- error message untuk content -->
                                    @error('visi')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">MISI</label>
                                    <textarea class="form-control @error('misi') is-invalid @enderror" name="misi" id="editor2" rows="5" placeholder="Masukkan Misi">{{ old('misi', $visimisis->misi) }}</textarea>
                                
                                    <!-- error message untuk content -->
                                    @error('misi')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">TUPOKSI</label>
                                    <textarea class="form-control @error('tupoksi') is-invalid @enderror" name="tupoksi" id="editor3" rows="4" placeholder="Masukkan Tupoksi">{{ old('tupoksi', $visimisis->tupoksi) }}</textarea>
                                    @error('tupoksi')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">SEJARAH IMAGE</label>
                                    @if($visimisis->sejarah_image)
                                        <div>
                                            <img src="{{ asset('images/component/' . $visimisis->sejarah_image) }}" alt="Gambar" class="img-thumbnail mb-2" width="150">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                    <!-- error message untuk title -->
                                    @error('image')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">SEJARAH</label>
                                    <textarea class="form-control @error('sejarah') is-invalid @enderror" name="sejarah" id="editor4" rows="4" placeholder="Masukkan Sejarah">{{ old('sejarah', $visimisis->sejarah) }}</textarea>
                                    @error('sejarah')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
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
    <style>
        .ck-editor__editable_inline {
            min-height: 400px; /* Atur sesuai keinginan */
        }
    </style>
    
@stop


@section('js')
    <script> console.log('Hi!'); </script>
@stop