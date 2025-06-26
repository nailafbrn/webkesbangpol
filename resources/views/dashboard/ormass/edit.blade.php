@extends('dashboard.layouts.app')
@section('title', 'Tambah Ormas')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">

                        <!-- Manual Input Form -->
                        <div id="manual-input-form">
                            <form action="{{ route('ormass.update', $ormas->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Data Organisasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                                                <input type="text" class="form-control" name="nama_organisasi" placeholder="Masukkan nama organisasi" required autocomplete="off" value="{{ $ormas->nama_organisasi }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bidang" class="form-label">Bidang</label>
                                                <input type="text" class="form-control" name="bidang" placeholder="Masukkan bidang" required autocomplete="off" value="{{ $ormas->bidang }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id='editor' rows="3" placeholder="Masukkan alamat lengkap" required autocomplete="off">{{ $ormas->alamat }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sumber_data" class="form-label">Sumber Data</label>
                                            <input type="text" class="form-control" name="sumber_data" placeholder="Masukkan sumber data" required autocomplete="off" value="{{ $ormas->sumber_data }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Data Pengurus</h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $pengurus = $ormas->pengurus->keyBy('jabatan');
                                        @endphp
                                        
                                        <div class="pengurus-section mb-4">
                                            <h6 class="border-bottom pb-2">Ketua</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="ketua_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[0][nama]" placeholder="Masukkan nama ketua"  autocomplete="off" value="{{ $pengurus->get('Ketua')->nama ?? '' }}">
                                                    <input type="hidden" name="pengurus[0][jabatan]" value="Ketua">
                                                    <input type="hidden" name="pengurus[0][id]" value="{{ $pengurus->get('Ketua')->id ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ketua_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[0][no_telepon]" placeholder="Masukkan nomor telepon ketua"  autocomplete="off" value="{{ $pengurus->get('Ketua')->no_telepon ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pengurus-section mb-4">
                                            <h6 class="border-bottom pb-2">Sekretaris</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="sekretaris_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[1][nama]" placeholder="Masukkan nama sekretaris"  autocomplete="off" value="{{ $pengurus->get('Sekretaris')->nama ?? '' }}">
                                                    <input type="hidden" name="pengurus[1][jabatan]" value="Sekretaris">
                                                    <input type="hidden" name="pengurus[1][id]" value="{{ $pengurus->get('Sekretaris')->id ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="sekretaris_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[1][no_telepon]" placeholder="Masukkan nomor telepon sekretaris"  autocomplete="off" value="{{ $pengurus->get('Sekretaris')->no_telepon ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pengurus-section">
                                            <h6 class="border-bottom pb-2">Bendahara</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="bendahara_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[2][nama]" placeholder="Masukkan nama bendahara"  autocomplete="off" value="{{ $pengurus->get('Bendahara')->nama ?? '' }}">
                                                    <input type="hidden" name="pengurus[2][jabatan]" value="Bendahara">
                                                    <input type="hidden" name="pengurus[2][id]" value="{{ $pengurus->get('Bendahara')->id ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bendahara_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[2][no_telepon]" placeholder="Masukkan nomor telepon bendahara"  autocomplete="off" value="{{ $pengurus->get('Bendahara')->no_telepon ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Data Dokumen</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="akta_notaris" class="form-label">Akta Notaris</label>
                                                <input type="text" class="form-control" name="dokumen[akta_notaris]" placeholder="Masukkan nomor akta notaris" autocomplete="off" value="{{ $ormas->dokumenedit->akta_notaris ?? '' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="ahu_skt" class="form-label">AHU/SKT</label>
                                                <input type="text" class="form-control" name="dokumen[ahu_skt]" placeholder="Masukkan nomor AHU/SKT" autocomplete="off" value="{{ $ormas->dokumenedit->ahu_skt ?? '' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="npwp" class="form-label">NPWP</label>
                                                <input type="text" class="form-control" name="dokumen[npwp]" placeholder="Masukkan nomor NPWP" autocomplete="off" value="{{ $ormas->dokumenedit->npwp ?? '' }}">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> 
                                        Simpan Perubahan
                                    </button>
                                    <a href="{{ route('ormass.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                        <style>
                            .ck-editor__editable_inline {
                                min-height: 200px; /* Atur sesuai keinginan */
                            }
                        </style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputToggle = document.getElementById('input-toggle');
        const manualInputForm = document.getElementById('manual-input-form');
        const excelUploadForm = document.getElementById('excel-upload-form');
        
        // Set initial state
        manualInputForm.style.display = 'block';
        excelUploadForm.style.display = 'none';
        
        // Toggle between manual input and excel upload forms
        inputToggle.addEventListener('change', function() {
            if (this.checked) {
                manualInputForm.style.display = 'none';
                excelUploadForm.style.display = 'block';
            } else {
                manualInputForm.style.display = 'block';
                excelUploadForm.style.display = 'none';
            }
        });

        // File input handling
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file-name-display');
        
        if (fileInput && fileNameDisplay) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileNameDisplay.textContent = `File terpilih: ${fileName}`;
                    fileNameDisplay.classList.add('file-selected');
                } else {
                    fileNameDisplay.textContent = '';
                    fileNameDisplay.classList.remove('file-selected');
                }
            });
        }

        // Drag and drop functionality
        const uploadArea = document.querySelector('.file-upload-wrapper');
        
        if (uploadArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadArea.classList.add('highlight');
            }

            function unhighlight() {
                uploadArea.classList.remove('highlight');
            }

            uploadArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        }
    });
</script>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-ormasform.css') }}">
@endpush


