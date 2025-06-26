@extends('dashboard.layouts.app')

@section('title', 'Edit Data Hukum')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                    <form action="{{ route('landasanhukum.update', $landasanHukum->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="bidang_id" class="form-label">Bidang</label>
                            <select name="bidang_id" id="bidang_id" class="form-select @error('bidang_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ old('bidang_id', $landasanHukum->bidang_id) == $bidang->id ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('jenis_peraturan') is-invalid @enderror" id="jenis_peraturan" name="jenis_peraturan" value="{{ old('jenis_peraturan', $landasanHukum->jenis_peraturan) }}" required>
                            @error('jenis_peraturan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_peraturan" class="form-label">Nomor Peraturan</label>
                            <input type="text" class="form-control @error('nomor_peraturan') is-invalid @enderror" id="nomor_peraturan" name="nomor_peraturan" value="{{ old('nomor_peraturan', $landasanHukum->nomor_peraturan) }}" required>
                            @error('nomor_peraturan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_peraturan" class="form-label">Tahun Peraturan</label>
                            <input type="number" class="form-control @error('tahun_peraturan') is-invalid @enderror" id="tahun_peraturan" name="tahun_peraturan" value="{{ old('tahun_peraturan', $landasanHukum->tahun_peraturan) }}" required>
                            @error('tahun_peraturan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tentang" class="form-label">Tentang</label>
                            <textarea class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" rows="4" required>{{ old('tentang', $landasanHukum->tentang) }}</textarea>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        <a href="{{ route('landasanhukum.index') }}" class="btn btn-md btn-secondary">BATAL</a>
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