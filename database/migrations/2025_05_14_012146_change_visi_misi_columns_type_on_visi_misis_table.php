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
        //
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->text('visi')->nullable()->change();
            $table->text('misi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->string('visi')->nullable()->change();
            $table->string('misi')->nullable()->change();
        });
    }
};
