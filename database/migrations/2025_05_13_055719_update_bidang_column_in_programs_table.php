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
        Schema::table('programs', function (Blueprint $table) {
            //
            $table->dropColumn('bidang');

            $table->unsignedBigInteger('bidang_id')->after('id');
            $table->foreign('bidang_id')->references('id')->on('bidangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            //
            $table->dropForeign(['bidang_id']);
            $table->dropColumn('bidang_id');
            $table->string('bidang'); // sesuaikan dengan tipe awalnya
        });
    }
};
