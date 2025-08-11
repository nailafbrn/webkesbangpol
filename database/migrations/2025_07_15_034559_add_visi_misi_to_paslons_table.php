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
        // Menambahkan kolom baru untuk Visi dan Misi
        $table->text('visi')->nullable()->after('cawapres_riwayat_pekerjaan');
        $table->text('misi')->nullable()->after('visi');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paslons', function (Blueprint $table) {
            //
        });
    }
};