<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legislatifs', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut')->default(0);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->text('riwayat_pendidikan')->nullable();
            $table->text('riwayat_pekerjaan')->nullable();
            $table->string('jenis_kelamin')->nullable(); // Can be null if import value is invalid
            $table->string('nama_partai')->nullable();
            $table->string('dapil')->nullable(); // Electoral District
            $table->integer('suara_sah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legislatifs');
    }
};