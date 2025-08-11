<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan tabel dan kolom ada sebelum mengubah
        if (Schema::hasTable('paslons')) {
            if (Schema::hasColumn('paslons', 'capres_foto')) {
                DB::statement("ALTER TABLE paslons MODIFY capres_foto LONGBLOB NULL");
            }
            if (Schema::hasColumn('paslons', 'cawapres_foto')) {
                DB::statement("ALTER TABLE paslons MODIFY cawapres_foto LONGBLOB NULL");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke tipe string jika dibatalkan
        if (Schema::hasTable('paslons')) {
            if (Schema::hasColumn('paslons', 'capres_foto')) {
                DB::statement("ALTER TABLE paslons MODIFY capres_foto VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('paslons', 'cawapres_foto')) {
                DB::statement("ALTER TABLE paslons MODIFY cawapres_foto VARCHAR(255) NULL");
            }
        }
    }
};