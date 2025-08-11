<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paslons', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pemilu')->default('pilpres');
            $table->integer('no_urut');
            $table->year('tahun_pemilu');
            $table->string('partai_pengusung');
            $table->bigInteger('total_suara')->default(0);

            // Kembali menggunakan nama kolom spesifik
            $table->string('capres_nama');
            $table->string('capres_foto')->nullable();
            $table->string('capres_tempat_lahir');
            $table->date('capres_tanggal_lahir');
            $table->enum('capres_jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('capres_riwayat_pendidikan')->nullable();
            $table->text('capres_riwayat_pekerjaan')->nullable();

            $table->string('cawapres_nama');
            $table->string('cawapres_foto')->nullable();
            $table->string('cawapres_tempat_lahir');
            $table->date('cawapres_tanggal_lahir');
            $table->enum('cawapres_jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('cawapres_riwayat_pendidikan')->nullable();
            $table->text('cawapres_riwayat_pekerjaan')->nullable();
            
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paslons');
    }
};