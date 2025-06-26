@extends('dashboard.layouts.app')

@section('title', 'Potensi Konflik')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('potensi-konflik.create') }}" class="btn-tambah-konten">
                        <i class="fas fa-plus"></i> <span>Tambah Potensi Konflik</span>
                    </a>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered program-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="kolom-aksi">No.</th>
                                    <th class="kolom-nama_program">Nama Potensi</th>
                                    <th class="kolom-bidang">Kategori</th>
                                    <th class="kolom-bidang">Lokasi</th>
                                    <th class="kolom-bidang">Tanggal</th>
                                    <th class="kolom-bidang">Level Potensi</th>
                                    <th class="kolom-bidang">Status</th>
                                    <th class="kolom-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($potensiKonfliks as $index => $item)
                                    <tr>
                                        <td>{{ $potensiKonfliks->firstItem() + $index }}</td>
                                        <td class="kolom-nama_program">{{ $item->nama_potensi }}</td>
                                        <td class="kolom-bidang">{{ $item->kategori ?? '-' }}</td>
                                        <td class="kolom-bidang">
                                            {!! ($item->alamat) !!}
                                            {{ $item->lokasi_kecamatan }}
                                            @if($item->lokasi_kelurahan)
                                                , {{ $item->lokasi_kelurahan }}
                                            @endif
                                        </td>
                                        <td class="kolom-bidang">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td class="kolom-bidang text-capitalize">{{ $item->tingkat_potensi }}</td>
                                        <td class="kolom-bidang text-capitalize">{{ $item->status }}</td>
                                        <td class="kolom-aksi">
                                            <a href="{{ route('potensi-konflik.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('potensi-konflik.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus data ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data potensi konflik belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $potensiKonfliks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tetap gunakan CSS yang sudah ada */
    .program-table {
        width: 100% !important;
        table-layout: fixed !important;
    }

    .program-table th.kolom-nama_program,
    .program-table td.kolom-nama_program {
        width: 50% !important;
        text-align: justify !important;
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

    .kolom-aksi .btn {
        margin: 0 2px !important;
    }

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
