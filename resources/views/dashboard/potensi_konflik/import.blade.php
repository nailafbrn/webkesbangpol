@extends('dashboard.layouts.app')

@section('title', 'Import Potensi Konflik')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="card-title">Import Data Potensi Konflik dari Excel</h4>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('potensi-konflik.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">File Excel</label>
                            <input type="file" class="form-control" id="file" name="file" required accept=".xlsx,.xls">
                            <div class="form-text">Format file harus .xlsx atau .xls</div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('potensi-konflik.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-import"></i> Import
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4">
                        <h5>Petunjuk Import:</h5>
                        <ol>
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data sesuai dengan format yang ditentukan</li>
                            <li>Upload file yang sudah diisi</li>
                        </ol>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-file-excel"></i> Download Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection