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
        Schema::create('legislatif_terpilihs', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel legislatifs
            $table->foreignId('legislatif_id')
                  ->constrained('legislatifs', 'id') // tabel legislatifs, kolom id
                  ->onDelete('cascade'); // kalau legislatif dihapus, ikut terhapus

            // Jabatan opsional (contoh: Ketua, Wakil, dll.)
            $table->string('jabatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislatif_terpilihs');
    }
};
