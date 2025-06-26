@extends('dashboard.layouts.app')

@section('title', 'Edit Program')

@section('content')
    <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('programs.update', $programs->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
    
                                <div class="mb-3">
                                    <label for="nama_program" class="form-label">Nama Program</label>
                                    <input type="text" name="nama_program" value="{{ old('nama_program', $programs->nama_program) }}"
                                        class="form-control @error('nama_program') is-invalid @enderror" placeholder="Masukkan Nama Program">
                                    @error('nama_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="bidang_id" class="form-label">Bidang</label>
                                    <select name="bidang_id" id="bidang_id" class="form-select @error('bidang_id') is-invalid @enderror">
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach ($bidangs as $bidang)
                                            <option value="{{ $bidang->id }}" {{ $programs->bidang_id == $bidang->id ? 'selected' : '' }}>
                                                {{ $bidang->nama_bidang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bidang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
    
                                <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                                <button type="reset" class="btn btn-md btn-warning">RESET</button>
                                <a href="{{ route('programs.index') }}" class="btn btn-md btn-secondary">KEMBALI</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        CKEDITOR.replace( 'content' );
    </script>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop