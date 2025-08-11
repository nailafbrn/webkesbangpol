
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
            // Mengembalikan tipe kolom menjadi string
            $table->string('capres_foto')->nullable()->change();
            $table->string('cawapres_foto')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paslons', function (Blueprint $table) {
            // Jika di-rollback, ubah kembali ke blob (untuk keamanan)
            $table->longBlob('capres_foto')->nullable()->change();
            $table->longBlob('cawapres_foto')->nullable()->change();
        });
    }
};
