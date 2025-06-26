@extends('dashboard.layouts.app')
@section('title', 'Tambah Ormas')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="input-toggle-container mb-4">
                            <div class="toggle-switch">
                                <input type="checkbox" id="input-toggle" class="toggle-input">
                                <label for="input-toggle" class="toggle-label">
                                    <span class="toggle-option">Manual Input</span>
                                    <span class="toggle-option">Excel Upload</span>
                                </label>
                            </div>
                        </div>

                        <!-- Manual Input Form -->
                        <div id="manual-input-form">
                            <form action="{{ route('ormass.inputmanualstore') }}" method="POST">
                                @csrf
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Data Organisasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_organisasi" class="form-label">Nama Organisasi</label>
                                                <input type="text" class="form-control" name="nama_organisasi" placeholder="Masukkan nama organisasi" required autocomplete="off">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bidang" class="form-label">Bidang</label>
                                                <input type="text" class="form-control" name="bidang" placeholder="Masukkan bidang" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="editor" rows="3" placeholder="Masukkan alamat lengkap" required autocomplete="off"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sumber_data" class="form-label">Sumber Data</label>
                                            <input type="text" class="form-control" name="sumber_data" placeholder="Masukkan sumber data" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Data Pengurus</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="pengurus-section mb-4">
                                            <h6 class="border-bottom pb-2">Ketua</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="ketua_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[0][nama]" placeholder="Masukkan nama ketua" required autocomplete="off">
                                                    <input type="hidden" name="pengurus[0][jabatan]" value="Ketua">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ketua_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[0][no_telepon]" placeholder="Masukkan nomor telepon ketua" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pengurus-section mb-4">
                                            <h6 class="border-bottom pb-2">Sekretaris</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="sekretaris_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[1][nama]" placeholder="Masukkan nama sekretaris" required autocomplete="off">
                                                    <input type="hidden" name="pengurus[1][jabatan]" value="Sekretaris">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="sekretaris_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[1][no_telepon]" placeholder="Masukkan nomor telepon sekretaris" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pengurus-section">
                                            <h6 class="border-bottom pb-2">Bendahara</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="bendahara_nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="pengurus[2][nama]" placeholder="Masukkan nama bendahara" required autocomplete="off">
                                                    <input type="hidden" name="pengurus[2][jabatan]" value="Bendahara">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bendahara_no_telepon" class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" name="pengurus[2][no_telepon]" placeholder="Masukkan nomor telepon bendahara" required autocomplete="off">
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
                                                <input type="text" class="form-control" name="dokumen[akta_notaris]" placeholder="Masukkan nomor akta notaris" required autocomplete="off">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="ahu_skt" class="form-label">AHU/SKT</label>
                                                <input type="text" class="form-control" name="dokumen[ahu_skt]" placeholder="Masukkan nomor AHU/SKT" required autocomplete="off">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="npwp" class="form-label">NPWP</label>
                                                <input type="text" class="form-control" name="dokumen[npwp]" placeholder="Masukkan nomor NPWP" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-warning">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Excel Upload Form -->
                        <div id="excel-upload-form" style="display: none;">
                            <form action="{{ route('ormass.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Upload Data Ormas via Excel</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="upload-area mb-3">
                                            <label for="file" class="form-label">Pilih File Excel</label>
                                            <div class="file-upload-wrapper">
                                                <input type="file" name="file" id="file" class="file-upload-input" accept=".xlsx,.xls" required autocomplete="off">
                                                <label for="file" class="file-upload-label">
                                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                    <span class="upload-text">Pilih file atau drop disini</span>
                                                    <span class="upload-hint">Format: .xlsx, .xls</span>
                                                </label>
                                            </div>
                                            <div id="file-name-display" class="mt-2"></div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#excelTemplateModal">
                                                <i class="fas fa-download me-1"></i> Download Template Excel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-warning">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Template Excel -->
    <div class="modal fade" id="excelTemplateModal" tabindex="-1" aria-labelledby="excelTemplateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="excelTemplateModalLabel">Download Template Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan download template Excel untuk mengisi data Ormas dengan format yang sesuai.</p>
                    <a href="{{ asset('document/template-import/Template-Data-Ormas.xlsx') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i> Download Template
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
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


