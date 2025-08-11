@extends('dashboard.layouts.app')

@section('title', 'Potensi Konflik')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('potensi-konflik.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Manual
                        </a>
                        <a href="{{ route('potensi-konflik.import.form') }}" class="btn btn-success">
                            <i class="fas fa-file-import"></i> Import Excel
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Potensi</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Tingkat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($potensiKonfliks as $item)
                                <tr>
                                    <td>{{ $item->nama_potensi }}</td>
                                    <td>{{ $item->lokasi_kecamatan }}, {{ $item->lokasi_kelurahan }}</td>
                                    <td>{{ optional($item->tanggal)->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->tingkat_color }}">
                                            {{ ucfirst($item->tingkat_potensi) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->status_color }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('potensi-konflik.show', $item->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('potensi-konflik.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('potensi-konflik.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Gunakan pagination bootstrap (tanpa panah SVG besar) -->
                    {{ $potensiKonfliks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection