@extends('dashboard.layouts.app')

@section('title', 'Tambah Struktur Organisasi')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('strukturors.store') }}" method="POST" enctype="multipart/form-data">   
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">NAMA</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">NIP</label>
                                <input type="text" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $strukturors->nip ?? '') }}" placeholder="Contoh: 10101010 101010 1 010">
                                <small class="text-muted">Masukkan 18 digit angka. Format akan otomatis dirapikan.</small>
                                @error('nip')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <!-- Golongan -->
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Golongan</label>
                                    <select name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                                        <option selected disabled>Pilih Golongan</option>
                                        <option value="I" {{ old('golongan') == 'I' ? 'selected' : '' }}>Golongan I</option>
                                        <option value="II" {{ old('golongan') == 'II' ? 'selected' : '' }}>Golongan II</option>
                                        <option value="III" {{ old('golongan') == 'III' ? 'selected' : '' }}>Golongan III</option>
                                        <option value="IV" {{ old('golongan') == 'IV' ? 'selected' : '' }}>Golongan IV</option>
                                    </select>
                                    @error('golongan')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            <!-- Pangkat -->
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Pangkat</label>
                                    <select name="pangkat" class="form-control @error('pangkat') is-invalid @enderror">
                                        <option selected disabled>Pilih Pangkat</option>
                                        <option value="a" {{ old('pangkat') == 'a' ? 'selected' : '' }}>Pangkat a</option>
                                        <option value="b" {{ old('pangkat') == 'b' ? 'selected' : '' }}>Pangkat b</option>
                                        <option value="c" {{ old('pangkat') == 'c' ? 'selected' : '' }}>Pangkat c</option>
                                        <option value="d" {{ old('pangkat') == 'd' ? 'selected' : '' }}>Pangkat d</option>
                                    </select>
                                    @error('pangkat')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="selectMenu" class="font-weight-bold">Jabatan</label>
                                <select class="form-select form-control @error('jabatan') is-invalid @enderror" id="selectMenu" name="jabatan">
                                    <option selected disabled>Pilih Jabatan</option>
                                    <option value="Kepala Badan Kesatuan Bangsa dan Politik Kota Bandung">Kepala Badan Kesatuan Bangsa dan Politik Kota Bandung</option>
                                    <option value="Sekertaris Badan Kesatuan Bangsa dan Politik Kota Bandung">Sekertaris Badan Kesatuan Bangsa dan Politik Kota Bandung</option>
                                    <option value="Kepala Sub Bagian Umum dan Kepegawaian">Kepala Sub Bagian Umum dan Kepegawaian</option>
                                    <option value="Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa">Kepala Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa</option>
                                    <option value="Kepala Bidang Politik Dalam Negeri">Kepala Bidang Politik Dalam Negeri</option>
                                    <option value="Kepala Bidang Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Organisasi Kemasyarakatan">Kepala Bidang Ketahanan Ekonomi, Sosial, Budaya, Agama, dan Organisasi Kemasyarakatan</option>
                                    <option value="Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik">Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik</option>
                                    <option value="Subkoordinator Ideologi dan Wawasan Kebangsaan">Subkoordinator Ideologi dan Wawasan Kebangsaan</option>
                                    <option value="Subkoordinator Bela Negara dan Karakter Bangsa">Subkoordinator Bela Negara dan Karakter Bangsa</option>
                                    <option value="Subkoordinator Fasilitasi Kelembagaan Pemerintahan, Perwakilan, dan Partai Politik">Subkoordinator Fasilitasi Kelembagaan Pemerintahan, Perwakilan, dan Partai Politik</option>
                                    <option value="Subkoordinator Pendidikan Politik dan Peningkatan Demokrasi">Subkoordinator Pendidikan Politik dan Peningkatan Demokrasi</option>
                                    <option value="Subkoordinator Ketahanan Ekonomi, Sosial, Budaya dan Agama">Subkoordinator Ketahanan Ekonomi, Sosial, Budaya dan Agama</option>
                                    <option value="Subkoordinator Kewaspadaan Dini dan Kerjasama Intelijen">Subkoordinator Kewaspadaan Dini dan Kerjasama Intelijen</option>


                                </select>
                                @error('jabatan')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="font-weight-bold">Foto Profil</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.jpeg,.png,.webp">
                                
                                <!-- error message untuk title -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nipInput = document.getElementById('nip');
    
            nipInput.addEventListener('input', function (e) {
                let value = nipInput.value.replace(/\D/g, ''); // ambil angka saja
                if (value.length > 18) value = value.slice(0, 18); // maksimal 18 digit
    
                // Pisah format jadi 8 + 6 + 1 + 3
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
