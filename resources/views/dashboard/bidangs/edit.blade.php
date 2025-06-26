@extends('dashboard.layouts.app')

@section('title', 'Edit Bidang')

@section('content_header')
    <h1>Edit Bidang</h1>
@stop

@section('content')
    <form action="{{ route('bidangs.update', $bidang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>No Bidang</label>
            <input type="text" name="no_bidang" value="{{ $bidang->no_bidang }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama Bidang</label>
            <input type="text" name="nama_bidang" value="{{ $bidang->nama_bidang }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update</button>
        <a href="{{ route('bidangs.index') }}" class="btn btn-secondary mt-2">Kembali</a>
    </form>
@stop
