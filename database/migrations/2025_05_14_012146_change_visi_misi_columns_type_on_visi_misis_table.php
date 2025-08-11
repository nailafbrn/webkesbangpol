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
        // Mengubah tipe kolom menjadi TEXT agar bisa menampung data panjang
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->text('visi')->change();
            $table->text('misi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Saat proses 'down', kita ubah kembali menjadi TEXT juga.
        // Ini untuk mencegah error "Data too long" jika ada data yang sudah terlanjur panjang.
        // Ini adalah cara paling aman untuk memastikan migrasi bisa dibatalkan tanpa error.
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->text('visi')->change();
            $table->text('misi')->change();
        });
    }
};
