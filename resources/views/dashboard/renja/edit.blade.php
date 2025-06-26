@extends('dashboard.layouts.app')

@section('title', 'Edit Rencana Kerja')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('renja.update', $renja->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title-renja" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-renja" name="title" value="{{ old('title', $renja->title) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $renja->tahun) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="file_upload" class="form-label">Ganti File (jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($renja->file_upload)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($renja->file_upload) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="file_upload_wm" class="form-label">Ganti File Watermark(jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload_wm" name="file_upload_wm" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($renja->file_upload_wm)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($renja->file_upload_wm) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <a href="{{ route('renja.index') }}" class="btn btn-md btn-secondary">BATAL</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script> console.log('Edit page loaded'); </script>
@stop
