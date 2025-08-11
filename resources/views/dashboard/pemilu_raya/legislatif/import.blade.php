@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.pemilu.legislatif.index') }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                    <h3 class="m-0">Impor Data Calon Legislatif dari Excel</h3>
                </div>
            </div>
            <hr>
        </div>
    </div>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('import_success_with_errors'))
        <div class="alert alert-warning">
            {!! session('import_success_with_errors') !!}
        </div>
    @endif
    @if(session('import_errors'))
        <div class="alert alert-danger">
            <h5 class="alert-heading">Ditemukan beberapa error validasi:</h5>
            <ul>
                @foreach(session('import_errors') as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-file-upload me-2"></i>Unggah File Excel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pemilu.legislatif.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" class="form-control" id="file" name="file" required accept=".xlsx, .xls, .csv">
                            <small class="form-text text-muted">Pastikan file Anda sesuai dengan format template yang disediakan.</small>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-check-circle me-2"></i> Impor Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Petunjuk Format</h5>
                </div>
                <div class="card-body">
                    <p>Pastikan file Excel Anda memiliki **header** dengan nama kolom berikut (urutan tidak masalah):</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>no_urut</strong> (Angka)</li>
                        <li class="list-group-item"><strong>nama_lengkap</strong> (Teks, Wajib)</li>
                        <li class="list-group-item"><strong>tempat_lahir</strong> (Teks)</li>
                        <li class="list-group-item"><strong>jenis_kelamin</strong> (Teks: 'L' atau 'P')</li>
                        <li class="list-group-item"><strong>nama_partai</strong> (Teks)</li>
                        <li class="list-group-item"><strong>dapil</strong> (Teks)</li>
                        <li class="list-group-item"><strong>suara_sah</strong> (Angka)</li>
                        <li class="list-group-item"><strong>riwayat_pendidikan</strong> (Teks, Opsional)</li>
                        <li class="list-group-item"><strong>riwayat_pekerjaan</strong> (Teks, Opsional)</li>
                    </ul>
                    <hr>
                    <a href="/templates/template_legislatif.xlsx" class="btn btn-success w-100" download>
                        <i class="fas fa-download me-2"></i> Unduh Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection