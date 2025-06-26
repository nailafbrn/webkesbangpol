@extends('dashboard.layouts.app')

@section('title', 'Program')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('programs.create') }}" class="btn-tambah-konten">
                            <i class="fas fa-plus"></i> <span>Tambah Program</span>
                        </a>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered program-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="kolom-nama_program" scope="col">NAMA PROGRAM</th>
                                        <th class="kolom-bidang" scope="col">BIDANG</th>
                                        <th class="kolom-aksi" scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($programs as $program)
                                        <tr>
                                            <td class="kolom-nama_program">
                                                {{ $program->nama_program }}
                                            </td>
                                            <td class="kolom-bidang">
                                                {{ $program->bidang->nama_bidang ?? '-' }}
                                            </td>
                                            <td class="kolom-aksi text-center">
                                                <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <div class="alert alert-warning text-center m-0">Belum ada data Program.</div>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            
                        </div>
                        {{ $programs->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Proporsi kolom yang lebih baik */
        .program-table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        .program-table th.kolom-nama_program,
        .program-table td.kolom-nama_program {
            width: 50% !important;
            text-align: justify  !important;
        }

        .program-table th.kolom-bidang,
        .program-table td.kolom-bidang {
            width: 30% !important;
        }

        .program-table th.kolom-aksi,
        .program-table td.kolom-aksi {
            width: 20% !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Penanganan text dan padding */
        .program-table td {
            padding: 12px 15px !important;
            white-space: normal !important;
            word-break: break-word !important;
            vertical-align: middle !important;
        }

        .program-table th {
            padding: 12px 15px !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-weight: 600 !important;
        }

        /* Tombol aksi */
        .kolom-aksi .btn {
            margin: 0 2px !important;
        }

        /* Pagination styling */
        .page-link {
            color: #B40D14 !important;
            background-color: #fff !important;
            border-color: #ddd !important;
        }

        .page-link:hover {
            color: #ffffff !important;
            background-color: #B40D14 !important;
            border-color: #B40D14 !important;
        }

        .page-item.active .page-link {
            color: #fff !important;
            background-color: #B40D14 !important;
            border-color: #B40D14 !important;
        }

        .page-item.disabled .page-link {
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .program-table th.kolom-nama_program,
            .program-table td.kolom-nama_program {
                width: 50% !important;
            }
            
            .program-table th.kolom-bidang,
            .program-table td.kolom-bidang {
                width: 30% !important;
            }
            
            .program-table th.kolom-aksi,
            .program-table td.kolom-aksi {
                width: 20% !important;
            }
        }
    </style>

    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script>
@stop
