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
        Schema::create('legislatif_terpilihs', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke caleg di tabel 'legislatifs'
            $table->foreignId('legislatif_id')->constrained('legislatifs')->onDelete('cascade');
            $table->string('jabatan')->nullable(); // Untuk jabatan seperti Ketua, Wakil, dll.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislatif_terpilihs');
    }
};
