@extends('dashboard.layouts.app')

@section('title', 'Tambah Hukum')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('landasanhukum.store') }}" method="POST" enctype="multipart/form-data">   
                            @csrf
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
                            <div class="mb-3">
                                <label for="jenis_peraturan" class="form-label">Jenis Peraturan</label>
                                <input type="text" class="form-control" id="jenis_peraturan" name="jenis_peraturan" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="nomor_peraturan" class="form-label">Nomor Peraturan</label>
                                <input type="text" class="form-control" id="nomor_peraturan" name="nomor_peraturan" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun_peraturan" class="form-label">Tahun Peraturan</label>
                                <input type="number" class="form-control" id="tahun_peraturan" name="tahun_peraturan" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tentang" class="form-label">Tentang</label>
                                <textarea class="form-control" id="tentang" name="tentang" rows="4" required autocomplete="off"></textarea>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px; /* Atur sesuai keinginan */
        }
    </style>

@stop


@section('js')
    <script> console.log('Hi!'); </script>
@stop