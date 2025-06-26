@extends('dashboard.layouts.app')

@section('title', 'Tambah Program')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('programs.store') }}" method="POST">   
                            @csrf

                            {{-- Nama Program --}}
                            <div class="mb-3">
                                <label for="nama_program" class="form-label">Nama Program</label>
                                <input type="text" name="nama_program" id="nama_program"
                                    class="form-control @error('nama_program') is-invalid @enderror"
                                    value="{{ old('nama_program') }}" required>

                                @error('nama_program')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bidang --}}
                            <div class="mb-3">
                                <label for="bidang_id" class="form-label">Bidang</label>
                                <select name="bidang_id" id="bidang_id"
                                    class="form-select @error('bidang_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach ($bidangs as $bidang)
                                        <option value="{{ $bidang->id }}"
                                            {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                            {{ $bidang->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bidang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

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