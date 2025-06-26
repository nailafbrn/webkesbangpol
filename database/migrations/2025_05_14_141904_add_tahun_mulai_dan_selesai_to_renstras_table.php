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
        Schema::table('renstras', function (Blueprint $table) {
            $table->year('tahun_mulai')->after('title');
            $table->year('tahun_selesai')->after('tahun_mulai');
            $table->dropColumn('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renstras', function (Blueprint $table) {
            $table->dropColumn(['tahun_mulai', 'tahun_selesai']);
            $table->year('tahun')->nullable();
        });
    }
};
