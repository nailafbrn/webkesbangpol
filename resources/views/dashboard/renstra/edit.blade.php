@extends('dashboard.layouts.app')

@section('title', 'Edit Rencana Strategis')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('renstra.update', $renstra->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title-renstra" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-renstra" name="title" value="{{ old('title', $renstra->title) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                                <input type="text" class="form-control" id="tahun_mulai" name="tahun_mulai" value="{{ old('tahun_mulai', $renstra->tahun_mulai) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                                <input type="text" class="form-control" id="tahun_selesai" name="tahun_selesai" value="{{ old('tahun_selesai', $renstra->tahun_selesai) }}" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="file_upload" class="form-label">Ganti File (jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($renstra->file_upload)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($renstra->file_upload) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="file_upload_wm" class="form-label">Ganti File Watermark(jika perlu)</label>
                                <input type="file" class="form-control" id="file_upload_wm" name="file_upload_wm" accept=".pdf">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                @if($renstra->file_upload_wm)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($renstra->file_upload_wm) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <a href="{{ route('renstra.index') }}" class="btn btn-md btn-secondary">BATAL</a>
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
