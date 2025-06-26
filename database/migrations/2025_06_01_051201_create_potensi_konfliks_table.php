<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('potensi_konfliks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_potensi');
            $table->string('kategori')->nullable();
            $table->string('lokasi_kecamatan');
            $table->string('lokasi_kelurahan')->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('tingkat_potensi', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potensi_konfliks');
    }
};
