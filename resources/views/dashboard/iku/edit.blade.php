@extends('dashboard.layouts.app')

@section('title', 'Edit Indikator Kinerja Utama')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('iku.update', $iku->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title-iku" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-iku" name="title" value="{{ old('title', $iku->title) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $iku->tahun) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="file_upload" class="form-label">Ganti File (jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($iku->file_upload)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($iku->file_upload) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="file_upload_wm" class="form-label">Ganti File Watermark(jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload_wm" name="file_upload_wm" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($iku->file_upload_wm)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($iku->file_upload_wm) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <a href="{{ route('iku.index') }}" class="btn btn-md btn-secondary">BATAL</a>
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
