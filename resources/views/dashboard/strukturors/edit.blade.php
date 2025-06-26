@extends('dashboard.layouts.app')

@section('title', 'Edit Struktur Organisasi')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('strukturors.update', $strukturors->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- NAMA --}}
                        <div class="form-group">
                            <label class="font-weight-bold">NAMA</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $strukturors->nama) }}" placeholder="Masukkan Nama">
                            @error('nama')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- NIP --}}
                        <div class="form-group">
                            <label class="font-weight-bold">NIP</label>
                            <input type="text" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $strukturors->nip) }}" placeholder="Contoh: 19671005 198903 1 008">
                            <small class="text-muted">Masukkan 18 digit angka. Format akan otomatis dirapikan.</small>
                            @error('nip')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- GOLONGAN & PANGKAT --}}
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Golongan</label>
                                <select name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                                    <option value="" disabled>Pilih Golongan</option>
                                    @foreach (['I', 'II', 'III', 'IV'] as $gol)
                                        <option value="{{ $gol }}" {{ old('golongan', $strukturors->golongan) == $gol ? 'selected' : '' }}>Golongan {{ $gol }}</option>
                                    @endforeach
                                </select>
                                @error('golongan')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="font-weight-bold">Pangkat</label>
                                <select name="pangkat" class="form-control @error('pangkat') is-invalid @enderror">
                                    <option value="" disabled>Pilih Pangkat</option>
                                    @foreach (['a', 'b', 'c', 'd'] as $pangkat)
                                        <option value="{{ $pangkat }}" {{ old('pangkat', $strukturors->pangkat) == $pangkat ? 'selected' : '' }}>Pangkat {{ $pangkat }}</option>
                                    @endforeach
                                </select>
                                @error('pangkat')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- JABATAN --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Jabatan</label>
                            <select class="form-select form-control @error('jabatan') is-invalid @enderror" id="selectMenu" name="jabatan">
                                <option disabled>Pilih...</option>
                                @php
                                    $jabatanOptions = [
                                        "Kepala Badan Kesatuan Bangsa dan Politik Kota Bandung",
                                        "Sekertaris Badan Kesatuan Bangsa dan Politik Kota Bandung",
                                        "Kepala Sub Bagian Umum Dan Kepegawaian",
                                        "Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa",
                                        "Kepala Bidang Politik Dalam Negeri",
                                        "Kepala Bidang Ketahanan, Ekonomi, Sosial Budaya Dan Organisasi Kemasyarakatan",
                                        "Kepala Bidang Kewaspadaan Nasional Dan Penanganan Konflik",
                                        "Subkoordinator Ideologi dan Wawasan Kebangsaan",
                                        "Subkoordinator Bela Negara dan Karakter Bangsa",
                                        "Subkoordinator Fasilitasi Kelembagaan Pemerintahan, Perwakilan, dan Partai Politik",
                                        "Subkoordinator Pendidikan Politik dan Peningkatan Demokrasi",
                                        "Subkoordinator Ketahanan Ekonomi, Sosial, Budaya dan Agama",
                                        "Subkoordinator Kewaspadaan Dini dan Kerjasama Intelijen",
                                    ];
                                @endphp
                                @foreach ($jabatanOptions as $jabatan)
                                    <option value="{{ $jabatan }}" {{ old('jabatan', $strukturors->jabatan) == $jabatan ? 'selected' : '' }}>
                                        {{ $jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Foto Profile</label>
                            @if($strukturors->foto_profile)
                                <div>
                                    <img src="{{ asset('images/struktur-organisasi/' . $strukturors->foto_profile) }}" alt="Gambar" class="img-thumbnail mb-2" width="150">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>

                        {{-- BUTTONS --}}
                        <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nipInput = document.getElementById('nip');

        nipInput.addEventListener('input', function () {
            let value = nipInput.value.replace(/\D/g, '');
            if (value.length > 18) value = value.slice(0, 18);

            const part1 = value.substr(0, 8);
            const part2 = value.substr(8, 6);
            const part3 = value.substr(14, 1);
            const part4 = value.substr(15, 3);

            let formatted = part1;
            if (part2) formatted += ' ' + part2;
            if (part3) formatted += ' ' + part3;
            if (part4) formatted += ' ' + part4;

            nipInput.value = formatted;
        });
    });
</script>
@stop

@section('js')
    <script> console.log('Edit Struktur JS Loaded!'); </script>
@stop
