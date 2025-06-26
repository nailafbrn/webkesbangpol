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
        Schema::table('posts', function (Blueprint $table) {
            // Drop FK dulu
            $table->dropForeign(['bidang_id']);
            $table->dropForeign(['program_id']);

            // Alter kolom
            $table->unsignedBigInteger('bidang_id')->nullable(false)->change();
            $table->unsignedBigInteger('program_id')->nullable(false)->change();

            // Recreate FK
            $table->foreign('bidang_id')
                ->references('id')->on('bidangs')
                ->onDelete('RESTRICT'); // Atau 'CASCADE' kalau mau

            $table->foreign('program_id')
                ->references('id')->on('programs')
                ->onDelete('RESTRICT'); // Atau 'CASCADE' kalau mau
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop FK dulu
            $table->dropForeign(['bidang_id']);
            $table->dropForeign(['program_id']);

            // Alter kolom balik ke nullable
            $table->unsignedBigInteger('bidang_id')->nullable()->change();
            $table->unsignedBigInteger('program_id')->nullable()->change();

            // Recreate FK dengan default behaviour
            $table->foreign('bidang_id')
                ->references('id')->on('bidangs')
                ->onDelete('SET NULL');

            $table->foreign('program_id')
                ->references('id')->on('programs')
                ->onDelete('SET NULL');
        });
    }
};
