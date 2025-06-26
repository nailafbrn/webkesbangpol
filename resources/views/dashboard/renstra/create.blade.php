@extends('dashboard.layouts.app')

@section('title', 'Tambah Rencana Strategis')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('renstra.store') }}" method="POST" enctype="multipart/form-data">   
                            @csrf
                            <div class="mb-3">
                                <label for="title-renstra" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-renstra" name="title" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                                <input type="text" class="form-control" id="tahun_mulai" name="tahun_mulai" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                                <input type="text" class="form-control" id="tahun_selesai" name="tahun_selesai" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="file_upload" class="form-label">Upload File</label>
                                <input type="file" class="form-control" id="file_upload" name="file_upload" required accept=".pdf">
                            </div>
                            
                            <div class="mb-3">
                                <label for="file_upload_wm" class="form-label">Upload File Watermark</label>
                                <input type="file" class="form-control" id="file_upload_wm" name="file_upload_wm" required accept=".pdf">
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
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