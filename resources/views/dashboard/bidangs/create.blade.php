@extends('dashboard.layouts.app')

@section('title', 'Tambah Bidang')

@section('content_header')
    <h1>Tambah Bidang</h1>
@stop

@section('content')
    <form action="{{ route('bidangs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>No Bidang</label>
            <input type="text" name="no_bidang" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama Bidang</label>
            <input type="text" name="nama_bidang" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Simpan</button>
        <a href="{{ route('bidangs.index') }}" class="btn btn-secondary mt-2">Kembali</a>
    </form>
@stop

