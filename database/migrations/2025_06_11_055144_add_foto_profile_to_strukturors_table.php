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
        // Tambahkan kolom hanya jika belum ada
        if (!Schema::hasColumn('strukturors', 'foto_profile')) {
            Schema::table('strukturors', function (Blueprint $table) {
                $table->string('foto_profile')->nullable()->after('pangkat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom hanya jika sudah ada
        if (Schema::hasColumn('strukturors', 'foto_profile')) {
            Schema::table('strukturors', function (Blueprint $table) {
                $table->dropColumn('foto_profile');
            });
        }
    }
};
