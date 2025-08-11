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
        Schema::table('paslons', function (Blueprint $table) {
            // Tambah kolom hanya jika belum ada
            if (!Schema::hasColumn('paslons', 'jenis_pemilu')) {
                $table->string('jenis_pemilu')->default('pilpres')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paslons', function (Blueprint $table) {
            // Hapus kolom jika ada
            if (Schema::hasColumn('paslons', 'jenis_pemilu')) {
                $table->dropColumn('jenis_pemilu');
            }
        });
    }
};