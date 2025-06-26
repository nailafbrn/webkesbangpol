@extends('dashboard.layouts.app')

@section('title', 'Tambah Pengukuran Kerja')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('ukurkerja.store') }}" method="POST" enctype="multipart/form-data">   
                            @csrf
                            <div class="mb-3">
                                <label for="title-ukurkerja" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-ukurkerja" name="title" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" required autocomplete="off">
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